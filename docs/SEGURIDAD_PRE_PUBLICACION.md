# Seguridad antes de publicar en GitHub

El ZIP original contenía dos API keys de Groq directamente en código PHP. Por seguridad, **no deben publicarse**.

Acciones realizadas en esta copia:
- Se eliminaron las claves hardcodeadas de `IaService.php` y `search.php`.
- Se configuró `GROQ_API_KEY` mediante variable de entorno.
- Se agregó `.env.example`.
- Se habilitó la verificación SSL en las llamadas cURL.
- Se eliminó del script público la información de prueba con datos personales.

## Importante
Las claves que estaban en el código original deben considerarse comprometidas y deben **revocarse/rotarse en el panel de Groq** antes de continuar.

## Configuración local
Crear un `.env` local (no subirlo a GitHub) con:
```text
DB_HOST=localhost
DB_NAME=sistema_gestion_documental
DB_USER=root
DB_PASSWORD=
GROQ_API_KEY=TU_CLAVE
GROQ_MODEL=llama-3.1-8b-instant
```

> La forma exacta de cargar variables de entorno depende de cómo se ejecute PHP/Apache. En XAMPP se puede configurar el entorno de Apache/PHP o adaptar la aplicación a una estrategia de configuración local que no entre al repositorio.
