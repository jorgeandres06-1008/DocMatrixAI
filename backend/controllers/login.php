<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once '../config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Completa todos los campos."]);
    exit;
}

try {
    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    $stmt = $conn->prepare("SELECT id_usuario, nombre, email, password FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        echo json_encode([
            "status" => "success",
            "usuario" => [
                "id" => $usuario['id_usuario'],
                "nombre" => $usuario['nombre'],
                "email" => $usuario['email']
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Credenciales incorrectas."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de BD: " . $e->getMessage()]);
}
?>