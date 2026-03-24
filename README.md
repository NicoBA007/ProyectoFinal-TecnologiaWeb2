<div align="center">
  <h1>🎬 PrimeCinemas</h1>
  <p><b>Plataforma de Gestión Cinematográfica Premium</b></p>
  
  <p>
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
    <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  </p>
</div>

---

Bienvenido al repositorio oficial de **PrimeCinemas**, un sistema de gestión de cartelera y usuarios desarrollado como proyecto final para la materia de Tecnología Web II. La aplicación destaca por una interfaz **Ultra Dark Mode** con estética de cine premium y una arquitectura backend altamente optimizada.

## 🛠️ Especificaciones Técnicas

| Componente              | Tecnología                               |
| :---------------------- | :--------------------------------------- |
| **Framework**           | Laravel 13.0.0                           |
| **Lenguaje**            | PHP 8.4.18                               |
| **Frontend**            | Tailwind CSS + Livewire (UI Customizada) |
| **Base de Datos**       | MySQL / MariaDB                          |
| **Entorno Recomendado** | Laravel Herd o Laragon (Windows)         |

---

## 🚀 Guía de Instalación para Colaboradores

Si deseas desplegar este proyecto en tu entorno local, sigue estos pasos:

### 1. Clonar y Acceder

```bash
git clone [https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git](https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git)
cd ProyectoFinal-TecnologiaWeb2
```
¡Claro que sí, Daniel! Vamos a darle ese toque final para que el README no solo sea informativo, sino que visualmente sea digno de un proyecto de Tecnología Web II.

He pulido el formato Markdown para incluir una estructura jerárquica más clara, bloques de código resaltados y una sección de agradecimientos más elegante.

Copia y pega el siguiente contenido en tu archivo README.md:

Markdown
<div align="center">
  <h1>🎬 PrimeCinemas</h1>
  <p><b>Plataforma de Gestión Cinematográfica Premium</b></p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-13.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
    <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  </p>
</div>

---

## 📝 Descripción
**PrimeCinemas** es un sistema avanzado de gestión de cartelera y usuarios diseñado para ofrecer una experiencia visual de alto nivel. Este proyecto fue desarrollado como entrega final para la materia **Tecnología Web II**, enfocándose en la optimización del backend en Laravel y una interfaz *Ultra Dark Mode* con estética cinematográfica moderna.

---

## 🛠️ Requisitos e Instalación

### 1. Clonar el Repositorio
```bash
git clone [https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git](https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git)
cd ProyectoFinal-TecnologiaWeb2
```
### 2. Instalación de Dependencias
Asegúrate de tener instalados Composer y Node.js:

```Bash
composer install
npm install
3. Preparación del Entorno
Configura el archivo de entorno y genera la llave de seguridad:
```
```Bash
cp .env.example .env
php artisan key:generate
```
### 4. Configuración de Base de Datos (.env)
Crea una base de datos llamada primecinemas_db y ajusta las siguientes líneas en tu .env:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=primecinemas_db
DB_USERNAME=root
DB_PASSWORD=TU_CONTRASEÑA_LOCAL
```
### [!IMPORTANTE]
Usuarios de Windows: Para evitar problemas de permisos y caché, verifica que estos drivers estén en modo file:

```bash
SESSION_DRIVER=file
CACHE_STORE=file
```
Nota: Si recibes un "Acceso Denegado (Code 5)", intenta ejecutar php artisan view:clear.

### 5. Migraciones y Ejecución
Ejecuta las migraciones para crear las tablas necesarias:

```Bash
php artisan migrate
```
Para iniciar el proyecto, abre dos terminales:
```bash
Backend: php artisan serve

Frontend: npm run dev
```
### 💎 Mejoras y Personalizaciones de Arquitectura
Este proyecto va más allá de un scaffolding estándar de Laravel Breeze, incorporando:

Arquitectura de Datos Custom: Modelo User vinculado a la tabla usuarios con id_usuario como clave primaria y desactivación de timestamps para mayor control manual.

Autenticación Optimizada: Se eliminaron componentes redundantes (Verificación de Email, Reset de Password) para lograr un flujo de acceso más ligero y directo.

UI/UX Premium:

Layout Guest: Implementación de glassmorphism y degradados radiales.

Localización: Navegación y mensajes de sistema completamente en español.

Seguridad: Parche aplicado contra la vulnerabilidad CVE-2026-33347 en la gestión de Markdown.

📁 Estructura del Core
Plaintext
📦 Proyecto
 ┣ 📂 app/Models/
 ┃ ┗ 📜 User.php                 # Configuración del modelo personalizado
 ┣ 📂 routes/
 ┃ ┗ 📜 auth.php                 # Rutas de autenticación seguras
 ┣ 📂 resources/views/
 ┃ ┣ 📂 layouts/                 # Plantillas maestras (Master Pages)
 ┃ ┗ 📜 welcome.blade.php        # Landing page de la cartelera


-----

