# 05 – Implementación y Despliegue
## 1. Requisitos
- Windows, Linux o macOS.
- Servidor Apache compatible con PHP.
- PHP 8.x.
- MySQL o MariaDB.
- Extensiones PHP para PDO, cURL y procesamiento de los formatos utilizados.
- Navegador web moderno.
- API key de Groq para las funciones de IA.

## 2. Instalación local
1. Instalar XAMPP o un entorno equivalente.
2. Copiar el proyecto en el directorio público de Apache.
3. Crear la base de datos `sistema_gestion_documental`.
4. Importar `database.sql`.
5. Configurar variables de entorno a partir de `.env.example`.
6. Verificar permisos de escritura de `uploads/`.
7. Abrir el frontend mediante Apache.
8. Probar registro, login, carga y consulta.

## 3. Base de datos
El script `database.sql` contiene la estructura de las tablas `usuarios`, `repositorios` y `documentos`, junto con sus claves e índices.

## 4. Configuración IA
La API key debe mantenerse fuera del repositorio. El proyecto debe leerla desde una variable de entorno como `GROQ_API_KEY`.

## 5. Despliegue
El mecanismo recomendado es GitHub para control de versiones y un servidor PHP para ejecución. La URL definitiva debe añadirse después de realizar el despliegue real.

## 6. Respaldo
- Copia periódica de la base de datos.
- Respaldo de los documentos cargados.
- Mantener las credenciales fuera de las copias públicas.
- Registrar cambios mediante Git.

## 7. Mantenimiento
Actualizar dependencias, revisar logs, comprobar disponibilidad de la API, verificar espacio de almacenamiento y realizar pruebas después de cambios importantes.
