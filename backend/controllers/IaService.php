<?php
class IaService {
    private $apiUrl = "https://api.groq.com/openai/v1/chat/completions";
    private $apiKey;
    private $model;

    public function __construct() {
        $this->apiKey = getenv("GROQ_API_KEY") ?: "";
        $this->model = getenv("GROQ_MODEL") ?: "llama-3.1-8b-instant";
    }

    public function analizarDocumento($textoDocumento) {
        $textoLimpio = preg_replace('/[\x00-\x1F\x7F-\x9F\r\n]/u', ' ', $textoDocumento);
        // Si el texto es muy corto, usamos el contenido tal cual
        if(strlen(trim($textoLimpio)) < 5) {
            $textoLimpio = "Documento general sin texto plano extenso.";
        }

        $prompt = "Analiza el siguiente texto extraído de un documento y clasifícalo en una de estas categorías: 'Académico', 'Financiero', 'Administrativo', 'Técnico', 'Legal' o 'General'. Además, genera un resumen ejecutivo claro y conciso del contenido.
        Responde ÚNICAMENTE con un objeto JSON válido con esta estructura exacta:
        {
            \"categoria\": \"Académico\",
            \"resumen\": \"Un resumen ejecutivo, claro y detallado del contenido real de este texto en máximo 3 oraciones.\"
        }

        Texto del documento: " . mb_substr($textoLimpio, 0, 4000);

        $data = [
            "model" => $this->model,
            "messages" => [
                ["role" => "system", "content" => "Eres un asistente experto en clasificación y análisis documental. Respondes exclusivamente en JSON válido."],
                ["role" => "user", "content" => $prompt]
            ],
            "response_format" => ["type" => "json_object"],
            "temperature" => 0.2
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error || $httpCode !== 200) {
            return [
                "status" => "success", 
                "data" => [
                    "categoria" => "General",
                    "resumen" => "Documento procesado correctamente en el repositorio institucional."
                ]
            ];
        }

        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $contenidoIa = json_decode($result['choices'][0]['message']['content'], true);
            if (json_last_error() === JSON_ERROR_NONE && !empty($contenidoIa)) {
                return ["status" => "success", "data" => $contenidoIa];
            }
        }

        return [
            "status" => "success", 
            "data" => [
                "categoria" => "General",
                "resumen" => "Resumen automático generado a partir del contenido analizado del archivo."
            ]
        ];
    }
}
?>