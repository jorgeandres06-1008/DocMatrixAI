<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once '../config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (empty($nombre) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

try {
    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    // Verificar si ya existe
    $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
    $check->bindParam(':email', $email);
    $check->execute();
    if ($check->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "El correo ya está registrado."]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $passwordHash);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario registrado con éxito."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo registrar el usuario."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de BD: " . $e->getMessage()]);
}
?>