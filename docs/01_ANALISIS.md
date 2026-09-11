# 01 – Documento de Análisis
## 1. Contexto y problema
El proyecto **DocMatrix AI – Sistema Inteligente de Gestión y Análisis Documental** busca transformar un repositorio de archivos en una fuente de información consultable. La guía del proyecto exige una solución que permita gestionar documentos y aplicar IA para procesar, clasificar, resumir, extraer información y consultar el contenido documental.

Actualmente, la implementación disponible permite autenticación, carga de archivos PDF/DOCX/TXT, extracción de contenido, clasificación mediante IA, generación de resumen, listado y eliminación de documentos, además de una consulta en lenguaje natural basada en la información almacenada.

## 2. Necesidad y oportunidad
Una organización puede acumular documentos sin una forma eficiente de localizar o comprender su contenido. DocMatrix AI propone centralizar los archivos y agregar procesamiento automático para reducir el tiempo de búsqueda y facilitar la consulta.

## 3. Objetivo general
Diseñar, desarrollar, probar, documentar e implementar una aplicación web que gestione documentos y utilice Inteligencia Artificial para convertir información documental no estructurada en información útil y consultable.

## 4. Objetivos específicos
1. Implementar autenticación básica de usuarios.
2. Permitir cargar y administrar documentos PDF, DOCX y TXT.
3. Extraer texto de los documentos compatibles.
4. Clasificar documentos mediante IA.
5. Generar un resumen automático.
6. Permitir consultas en lenguaje natural sobre la información procesada.
7. Registrar el estado del procesamiento y facilitar la administración del repositorio.
8. Documentar pruebas, instalación, operación y trazabilidad.

## 5. Alcance
**Incluye:** autenticación, carga, listado y eliminación de documentos; procesamiento de PDF/DOCX/TXT; clasificación; resumen; búsqueda/consulta por lenguaje natural; base de datos MySQL/MariaDB; integración con Groq; documentación y control de versiones.

**Pendiente o no evidenciado en el código entregado:** creación/administración de múltiples repositorios desde la interfaz, descarga de archivos, extracción estructurada de entidades de tres tipos documentales, y un RAG semántico con embeddings/vector DB. La implementación actual de `search.php` utiliza como contexto los nombres, categorías y resúmenes almacenados.

## 6. Actores
- **Usuario:** se registra, inicia sesión, carga documentos, consulta documentos y realiza preguntas.
- **Sistema:** valida archivos, almacena documentos, extrae texto y solicita análisis a la IA.
- **Servicio de IA (Groq):** recibe el texto y devuelve clasificación y resumen.
- **Base de datos:** almacena usuarios, repositorios y resultados del procesamiento.

## 7. Requerimientos funcionales
| ID | Requerimiento | Prioridad |
|---|---|---|
| RF-01 | Registrar usuarios | Alta |
| RF-02 | Autenticar usuarios | Alta |
| RF-03 | Cargar PDF, DOCX y TXT | Alta |
| RF-04 | Validar extensión del archivo | Alta |
| RF-05 | Extraer texto | Alta |
| RF-06 | Clasificar con IA | Alta |
| RF-07 | Generar resumen | Alta |
| RF-08 | Listar documentos procesados | Alta |
| RF-09 | Eliminar documentos | Media |
| RF-10 | Consultar información mediante lenguaje natural | Alta |
| RF-11 | Registrar estado de procesamiento | Media |
| RF-12 | Mantener información en MySQL/MariaDB | Alta |

## 8. Requerimientos no funcionales
- RNF-01: interfaz web usable desde navegador.
- RNF-02: contraseñas almacenadas mediante hash.
- RNF-03: credenciales y API keys fuera del repositorio.
- RNF-04: respuestas de API en JSON.
- RNF-05: arquitectura separada entre frontend, backend, datos y servicio de IA.
- RNF-06: documentación reproducible de instalación y pruebas.

## 9. Reglas de negocio
1. Solo se aceptan PDF, DOCX y TXT.
2. El correo de usuario debe ser único.
3. Una contraseña se almacena como hash, no como texto plano.
4. Cada documento pertenece a un repositorio.
5. El documento pasa por extracción y análisis antes de marcarse como completado.
6. La IA debe devolver una categoría y un resumen.

## 10. Historias de usuario
**HU-01 – Registro:** Como usuario quiero registrarme para acceder al sistema.  
Criterio: un correo no registrado crea la cuenta; un correo existente genera error.

**HU-02 – Carga:** Como usuario quiero subir un PDF, DOCX o TXT para almacenarlo y procesarlo.  
Criterio: los formatos permitidos son aceptados y los demás son rechazados.

**HU-03 – Análisis:** Como usuario quiero que el sistema clasifique y resuma el documento automáticamente.  
Criterio: al finalizar se almacena categoría y resumen.

**HU-04 – Consulta:** Como usuario quiero realizar preguntas sobre los documentos para encontrar información relevante.  
Criterio: el sistema devuelve una respuesta basada en el contexto documental disponible.

**HU-05 – Gestión:** Como usuario quiero visualizar y eliminar documentos para mantener organizado el repositorio.  
Criterio: los documentos aparecen en el listado y pueden eliminarse mediante la función disponible.

## 11. Casos de uso
- CU-01 Registrar usuario
- CU-02 Iniciar sesión
- CU-03 Cargar documento
- CU-04 Procesar documento con IA
- CU-05 Consultar documentos
- CU-06 Listar documentos
- CU-07 Eliminar documento

## 12. Priorización
**Alta:** autenticación, carga, extracción, IA, consulta y base de datos.  
**Media:** eliminación, estados y administración avanzada.  
**Pendiente:** extracción estructurada de entidades y RAG semántico completo.

## 13. Riesgos
| Riesgo | Prob. | Impacto | Mitigación |
|---|---|---|---|
| API de IA no disponible | Media | Alta | Manejo de errores y configuración externa |
| Archivos incompatibles | Media | Media | Validación de extensión y pruebas |
| Exposición de credenciales | Alta | Alta | Variables de entorno y rotación de claves |
| Fallo de BD | Media | Alta | Copias de seguridad |
| Respuestas IA incorrectas | Media | Alta | Validación y trazabilidad |
| Falta de documentos de prueba | Media | Media | Repositorio sintético de 30 archivos |

## 14. Trazabilidad inicial
Los requisitos RF-01 a RF-12 se relacionan con los endpoints existentes de autenticación, carga, consulta, listado y eliminación, además de las tablas de usuarios, repositorios y documentos. La trazabilidad detallada requisito–prueba se encuentra en `08_MATRIZ_TRAZABILIDAD.md`.
