# 03 – Documento de Desarrollo / Técnico
## 1. Tecnologías
- HTML5
- CSS3
- JavaScript
- Vue 3
- Bootstrap 5
- Font Awesome
- PHP 8.x
- MySQL/MariaDB
- PDO
- Groq API
- Git/GitHub

## 2. Estructura
```text
Proyecto_documental/
├── backend/
│   ├── config/
│   │   └── conexion.php
│   └── controllers/
│       ├── delete_documento.php
│       ├── DocumentoProcessor.php
│       ├── get_documentos.php
│       ├── IaService.php
│       ├── login.php
│       ├── register.php
│       ├── search.php
│       └── upload.php
├── frontend/
│   └── index.html
├── uploads/
├── documentos_prueba/
├── docs/
├── database.sql
├── .env.example
└── README.md
```

## 3. Procesamiento documental
`upload.php` valida la extensión, almacena temporalmente el archivo, invoca `DocumentoProcessor` para extraer contenido y después solicita a `IaService` la clasificación y el resumen. Finalmente, guarda el resultado en la tabla `documentos`.

## 4. Autenticación
`register.php` verifica que el correo no exista y genera el hash de contraseña. `login.php` recupera el usuario y valida la contraseña con `password_verify`.

## 5. Consulta IA
`search.php` recupera la información documental almacenada y la incorpora al prompt enviado al servicio de IA. El alcance actual de esta consulta está limitado al contexto que se guarda en la base de datos.

## 6. Configuración
Antes de publicar el proyecto se deben configurar las credenciales mediante variables de entorno. El archivo `.env.example` sirve como plantilla.

## 7. Control de versiones
Se recomienda trabajar con:
```bash
git add .
git commit -m "docs: documentación inicial del proyecto"
git push origin main
```

## 8. Bitácora sugerida
| Fecha | Actividad | Resultado |
|---|---|---|
| 2026-09-10 | Integración de carga documental | Función disponible |
| 2026-09-10 | Integración de IA | Clasificación y resumen |
| 2026-09-10 | Integración de consulta | Consulta contextual disponible |
| 2026-09-11 | Organización documental | Documentación y datos sintéticos preparados |

> La bitácora debe complementarse con las fechas y actividades reales del equipo.
