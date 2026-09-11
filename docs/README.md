# DocMatrix AI – Sistema Inteligente de Gestión y Análisis Documental

Proyecto integrador de **Desarrollo de Aplicaciones Empresariales – VI semestre, UTS**.

## Descripción
DocMatrix AI es una aplicación web para gestionar documentos y utilizar Inteligencia Artificial en su clasificación, resumen y consulta.

## Tecnologías
- Frontend: HTML, CSS, Vue 3, Bootstrap 5.
- Backend: PHP.
- Base de datos: MySQL/MariaDB.
- IA: Groq API.
- Control de versiones: Git/GitHub.

## Funcionalidades implementadas
- Registro e inicio de sesión.
- Carga de PDF, DOCX y TXT.
- Extracción de texto.
- Clasificación mediante IA.
- Generación de resumen.
- Listado y eliminación de documentos.
- Consulta en lenguaje natural.
- Persistencia en base de datos.

## Documentación
1. [Análisis](docs/01_ANALISIS.md)
2. [Diseño](docs/02_DISENO.md)
3. [Desarrollo](docs/03_DESARROLLO.md)
4. [Pruebas](docs/04_PRUEBAS.md)
5. [Implementación](docs/05_IMPLEMENTACION.md)
6. [Manual de usuario](docs/06_MANUAL_USUARIO.md)
7. [Manual técnico](docs/07_MANUAL_TECNICO_ADMIN.md)
8. [Trazabilidad](docs/08_MATRIZ_TRAZABILIDAD.md)

## Datos de prueba
`documentos_prueba/` contiene 30 documentos sintéticos distribuidos en tres categorías: Académico, Financiero y Administrativo, usando TXT, DOCX y PDF. No contienen datos personales reales.

## Instalación rápida
1. Instale XAMPP/PHP + MySQL/MariaDB.
2. Copie el proyecto al directorio público de Apache.
3. Cree la BD `sistema_gestion_documental`.
4. Importe `database.sql`.
5. Configure `.env` a partir de `.env.example`.
6. Verifique permisos de `uploads/`.
7. Abra la aplicación desde Apache.

## Seguridad
**Importante:** el código original entregado contenía API keys directamente en archivos PHP. Antes de publicar en GitHub deben revocarse/rotarse esas claves y migrarse a variables de entorno. El repositorio preparado para publicación no contiene las claves originales.

## Estado académico
La documentación distingue entre funcionalidades observadas en el código y requisitos de la guía que todavía requieren implementación o evidencia. No se deben marcar como completadas las pruebas hasta ejecutarlas realmente.
