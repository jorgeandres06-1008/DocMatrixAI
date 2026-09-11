# 07 – Manual Técnico / Administración
## 1. Configuración de BD
Edite la configuración de conexión para apuntar al servidor MySQL/MariaDB local. No publique contraseñas.

## 2. Variables de entorno
Copie `.env.example` a `.env` y configure:
- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`
- `GROQ_API_KEY`
- `GROQ_MODEL`

## 3. API
Los endpoints están en `backend/controllers/`. Las solicitudes y respuestas usan JSON salvo la carga multipart de archivos.

## 4. Archivos
Los documentos se almacenan en `uploads/`. Esta carpeta debe tener permisos adecuados y no debe utilizarse para guardar secretos.

## 5. Seguridad
- Nunca subir `.env`.
- Rotar inmediatamente cualquier API key que haya sido expuesta.
- Mantener verificación SSL activa.
- Validar tamaño, extensión y contenido de archivos.
- Limitar CORS en producción.
- Implementar autorización por usuario antes de un despliegue real.
- Evitar mostrar errores internos de BD al cliente.

## 6. Administración de BD
Realizar copias de seguridad periódicas y comprobar que las claves foráneas se mantengan consistentes.

## 7. Solución de problemas
**No conecta a BD:** revisar servicio MySQL/MariaDB y variables de conexión.  
**No procesa IA:** revisar `GROQ_API_KEY`, modelo y conectividad.  
**No carga archivos:** revisar permisos de `uploads/` y configuración de PHP.  
**No extrae DOCX:** verificar que `ZipArchive` esté habilitado.  
**PDF sin texto:** comprobar que el PDF contenga texto seleccionable; OCR no está evidenciado en la implementación actual.
