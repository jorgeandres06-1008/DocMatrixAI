# 04 – Plan y Evidencias de Pruebas
## 1. Objetivo
Verificar que las funciones implementadas cumplan los requisitos funcionales y que los casos de error sean controlados.

## 2. Estrategia
Se aplicarán pruebas funcionales, de validación de archivos, procesamiento IA, consultas, seguridad básica y casos límite.

## 3. Casos de prueba
| ID | Caso | Resultado esperado | Estado |
|---|---|---|---|
| CP-01 | Registro con datos válidos | Usuario creado | Pendiente de ejecución |
| CP-02 | Registro con correo existente | Mensaje de error | Pendiente |
| CP-03 | Login válido | Acceso concedido | Pendiente |
| CP-04 | Login inválido | Acceso rechazado | Pendiente |
| CP-05 | Carga TXT | Archivo aceptado y procesado | Pendiente |
| CP-06 | Carga DOCX | Archivo aceptado y procesado | Pendiente |
| CP-07 | Carga PDF | Archivo aceptado y procesado | Pendiente |
| CP-08 | Carga de extensión no permitida | Archivo rechazado | Pendiente |
| CP-09 | Clasificación IA | Categoría almacenada | Pendiente |
| CP-10 | Resumen IA | Resumen almacenado | Pendiente |
| CP-11 | Listado | Documentos visibles | Pendiente |
| CP-12 | Eliminación | Documento eliminado | Pendiente |
| CP-13 | Pregunta documental | Respuesta contextual | Pendiente |
| CP-14 | Pregunta vacía | Mensaje de validación | Pendiente |
| CP-15 | Archivo sin texto útil | Procesamiento controlado | Pendiente |

## 4. Evidencias
Las capturas deben agregarse después de ejecutar cada prueba realmente. No se deben declarar resultados como exitosos sin evidencia de ejecución.

## 5. Defectos
Registrar en esta tabla:
| ID | Defecto | Impacto | Corrección | Estado |
|---|---|---|---|---|
| D-01 | Credenciales de IA presentes en código original | Alto | Migrar a variables de entorno | Pendiente de aplicar/verificar |
| D-02 | Verificación SSL deshabilitada en código original | Alto | Habilitar verificación SSL | Pendiente de aplicar/verificar |

## 6. Conclusión
La prueba final deberá ejecutarse sobre el código que se publique. Este documento separa explícitamente los casos planificados de los resultados todavía no verificados.
