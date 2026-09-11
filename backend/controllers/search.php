<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once '../config/conexion.php';

$dataInput = json_decode(file_get_contents("php://input"), true);
$pregunta = $dataInput['pregunta'] ?? '';

if (empty(trim($pregunta))) {
    echo json_encode(["status" => "error", "message" => "Escribe una pregunta válida."]);
    exit;
}

try {
    $bd = new Conexion();
    $conn = $bd->getConexion();
    
    // Obtener documentos para el contexto RAG
    $stmt = $conn->prepare("SELECT nombre_archivo, categoria_ia, resumen_ia FROM documentos ORDER BY fecha_subida DESC");
    $stmt->execute();
    $documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $contextoDocs = "";
    if (count($documentos) > 0) {
        foreach ($documentos as $doc) {
            $contextoDocs .= "- Archivo: {$doc['nombre_archivo']} | Categoría: {$doc['categoria_ia']} | Resumen: {$doc['resumen_ia']}\n";
        }
    } else {
        $contextoDocs = "No hay documentos cargados en el repositorio actualmente.";
    }
    $apiKey = getenv("GROQ_API_KEY") ?: "";
    $model = getenv("GROQ_MODEL") ?: "llama-3.1-8b-instant";
$apiUrl = "https://api.groq.com/openai/v1/chat/completions";

    $prompt = "Eres el asistente inteligente del sistema DocMatrix AI de las UTS. 
    Responde a la pregunta del usuario basándote en la siguiente información de los documentos almacenados:
    
    [DOCUMENTOS EN REPOSITORIO]:
    {$contextoDocs}

    Pregunta del usuario: {$pregunta}";

    $data = [
        "model" => $model, // Modelo altamente optimizado y disponible en Groq
        "messages" => [
            ["role" => "system", "content" => "Eres un asistente experto en análisis documental."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.3
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curlError) {
        echo json_encode(["status" => "error", "message" => "Error cURL: " . $curlError]);
        exit;
    }

    $result = json_decode($response, true);

    // Si Groq devuelve un error en la respuesta JSON
    if (isset($result['error'])) {
        $errorMsg = $result['error']['message'] ?? 'Error desconocido de la API';
        // Respuesta de respaldo basada en los datos locales si la API falla por cuota
        $respuestaLocal = "Basado en tus documentos almacenados (como '{$documentos[0]['nombre_archivo']}'), el archivo pertenece a la categoría '{$documentos[0]['categoria_ia']}' y su contenido trata sobre: {$documentos[0]['resumen_ia']}";
        
        echo json_encode([
            "status" => "success",
            "respuesta" => $respuestaLocal
        ]);
        exit;
    }

    $respuestaIa = $result['choices'][0]['message']['content'] ?? "No se pudo interpretar la respuesta de la IA.";

    echo json_encode([
        "status" => "success",
        "respuesta" => $respuestaIa
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error interno: " . $e->getMessage()]);
}
?>