<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once '../config/conexion.php';

$dataInput = json_decode(file_get_contents("php://input"), true);
$idDocumento = $dataInput['id_documento'] ?? null;

if (!$idDocumento) {
    echo json_encode(["status" => "error", "message" => "ID de documento no válido."]);
    exit;
}

try {
    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    // Obtener la ruta física para borrar el archivo del servidor
    $stmt = $conn->prepare("SELECT ruta_fisica FROM documentos WHERE id_documento = :id");
    $stmt->bindParam(':id', $idDocumento);
    $stmt->execute();
    $doc = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($doc) {
        $rutaFisica = $doc['ruta_fisica'];
        if (file_exists($rutaFisica)) {
            unlink($rutaFisica); // Borra el archivo físico de uploads/
        }
    }

    // Borrar el registro de la base de datos
    $stmtDel = $conn->prepare("DELETE FROM documentos WHERE id_documento = :id");
    $stmtDel->bindParam(':id', $idDocumento);
    $stmtDel->execute();

    echo json_encode(["status" => "success", "message" => "Documento eliminado correctamente."]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error al eliminar: " . $e->getMessage()]);
}
?>