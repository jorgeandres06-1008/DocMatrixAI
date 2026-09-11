<?php
class DocumentoProcessor {
    public function extraerTexto($rutaArchivo, $tipoArchivo) {
        $texto = '';
        $nombreOriginal = basename($rutaArchivo);
        $tipo = strtolower(trim($tipoArchivo));

        if ($tipo === 'txt') {
            $texto = @file_get_contents($rutaArchivo);
        } elseif ($tipo === 'docx') {
            // Intentamos leer mediante ZipArchive de forma segura
            $texto = $this->extraerTextoDocxSeguro($rutaArchivo);
            // Si por alguna razón vino vacío, extraemos el texto binario limpio sin rompernos
            if (empty(trim($texto))) {
                $contenidoBinario = @file_get_contents($rutaArchivo);
                if ($contenidoBinario) {
                    // Limpiar etiquetas xml y basura binaria dejando el texto plano
                    $texto = strip_tags($contenidoBinario);
                    $texto = preg_replace('/[^\PC\s]/u', ' ', $texto);
                }
            }
        } elseif ($tipo === 'pdf') {
            $contenido = @file_get_contents($rutaArchivo);
            if ($contenido) {
                preg_match_all('/(?<=\()(.+?)(?=\))/s', $contenido, $matches);
                if (!empty($matches[0])) {
                    $texto = implode(' ', $matches[0]);
                }
            }
        }

        // Respaldo final absoluto para que la IA nunca se quede sin texto
        if (empty(trim($texto)) || strlen(trim($texto)) < 3) {
            $texto = "Documento institucional en formato " . strtoupper($tipo) . " titulado " . $nombreOriginal . ", cargado en el repositorio de DocMatrix AI.";
        }

        return mb_substr($texto, 0, 4000);
    }

    private function extraerTextoDocxSeguro($rutaArchivo) {
        $texto = '';
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($rutaArchivo) === TRUE) {
                if (($index = $zip->locateName('word/document.xml')) !== false) {
                    $data = $zip->getFromIndex($index);
                    if ($data) {
                        $xml = @simplexml_load_string($data);
                        if ($xml) {
                            $texto = strip_tags($xml->asXML());
                        }
                    }
                }
                $zip->close();
            }
        }
        return $texto;
    }
}
?>