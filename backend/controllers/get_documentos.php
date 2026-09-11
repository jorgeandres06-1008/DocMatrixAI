<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

require_once '../config/conexion.php';

try {
    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    $sql = "SELECT id_documento as id, nombre_archivo, tipo_archivo, categoria_ia as categoria, resumen_ia as resumen, fecha_subida FROM documentos ORDER BY fecha_subida DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        "status" => "success",
        "data" => $documentos
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener documentos: " . $e->getMessage()
    ]);
}
?>