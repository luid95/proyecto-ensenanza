# Proyecto de Gestión de Cursos con Laravel

Este proyecto es una plataforma de enseñanza donde los usuarios pueden ver videos de cursos, marcar su progreso, dar y quitar likes, y dejar comentarios. Los administradores pueden gestionar los cursos, videos y moderar los comentarios. Además, el sistema permite la aprobación de comentarios y visualización de estadísticas.

## Características

- Autenticación y roles (Usuario y Administrador)
- Sistema de likes para videos
- Sistema de comentarios con aprobación por el administrador
- Seguimiento del progreso de los videos
- Administración de cursos, videos y usuarios

## Requisitos

- **PHP** ^8.x
- **Composer**
- **MySQL** (u otro sistema de gestión de bases de datos compatible)
- **Node.js** y **NPM** (opcional, solo si el proyecto incluye activos front-end)

## Instalación

Sigue los pasos a continuación para configurar el proyecto localmente:

1. **Clona el repositorio:**
   ```bash
   # Clona el repositorio desde GitHub
   git clone <URL_DEL_REPOSITORIO>
   
   # Entra en el directorio del proyecto
   cd <NOMBRE_DEL_PROYECTO>

# Instala las dependencias de Laravel
composer install

# Crea una copia del archivo .env.example y nómbrala .env
cp .env.example .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_base_de_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña

# Genera la clave de aplicación para encriptación de datos
php artisan key:generate

# Ejecuta las migraciones para crear las tablas en la base de datos
php artisan migrate --seed

# Instala las dependencias de Node.js
npm install

# Compila los activos front-end en modo de desarrollo
npm run dev

# Inicia el servidor local en el puerto 8000
php artisan serve

