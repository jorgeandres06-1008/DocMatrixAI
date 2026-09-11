<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST");

try {
    if (!isset($_FILES['documento']) || !isset($_POST['id_repositorio'])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios para la subida."]);
        exit;
    }

    $archivo = $_FILES['documento'];
    $idRepositorio = $_POST['id_repositorio'];
    $nombreArchivo = basename($archivo['name']);
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

    $formatosPermitidos = ['pdf', 'docx', 'txt'];
    if (!in_array($extension, $formatosPermitidos)) {
        echo json_encode(["status" => "error", "message" => "Formato no soportado ($extension). Solo se permite PDF, DOCX y TXT."]);
        exit;
    }

    $directorioDestino = '../../uploads/';
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }
    $rutaFisica = $directorioDestino . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $nombreArchivo);

    if (!move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
        echo json_encode(["status" => "error", "message" => "Error al mover el archivo físico al servidor."]);
        exit;
    }

    require_once '../config/conexion.php';
    require_once 'DocumentoProcessor.php';
    require_once 'IaService.php';

    $processor = new DocumentoProcessor();
    $textoExtraido = $processor->extraerTexto($rutaFisica, $extension);

    $iaService = new IaService();
    $resultadoIa = $iaService->analizarDocumento($textoExtraido);

    $datosIa = $resultadoIa['data'] ?? [];
    $categoria = $datosIa['categoria'] ?? 'General';
    $resumen = $datosIa['resumen'] ?? "Resumen automático generado por el sistema.";

    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    $sql = "INSERT INTO documentos (id_repositorio, nombre_archivo, tipo_archivo, ruta_fisica, categoria_ia, resumen_ia, estado_procesamiento) 
            VALUES (:id_repositorio, :nombre, :tipo, :ruta, :categoria, :resumen, 'completado')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_repositorio', $idRepositorio);
    $stmt->bindParam(':nombre', $nombreArchivo);
    $stmt->bindParam(':tipo', $extension);
    $stmt->bindParam(':ruta', $rutaFisica);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':resumen', $resumen);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Documento DOCX cargado y procesado exitosamente.",
            "data" => [
                "id_documento" => $conn->lastInsertId(),
                "categoria" => $categoria,
                "resumen" => $resumen
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al guardar en la base de datos."]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Excepción del servidor: " . $e->getMessage()]);
}
?>