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
## 📋 Índice
1. [Sobre el Proyecto](#-sobre-el-proyecto)
2. [Requisitos Previos](#-requisitos-previos)
3. [Instalación Local](#-instalacion-local)
4. [Configuración Crítica (.env)](#%EF%B8%8F-configuracion-critica-env)
5. [Arquitectura y Modificaciones](#-arquitectura-y-modificaciones)
6. [Créditos](#-creditos)

---

## 🍿 Sobre el Proyecto

Sistema de gestión de cartelera y usuarios desarrollado como proyecto final para la materia de **Tecnología Web II**. 

La aplicación se aleja de las plantillas genéricas para ofrecer una experiencia visual inmersiva orientada al usuario final, combinando una interfaz **Ultra Dark Mode** (estética de cine premium) con una arquitectura backend optimizada en Laravel y bases de datos relacionales personalizadas.

---

## 🛠️ Requisitos Previos

Para ejecutar este proyecto sin errores, tu entorno de desarrollo debe contar con:

* **PHP:** `^8.2` (Desarrollado y testeado en PHP `8.4.18`)
* **Composer:** `^2.6`
* **Node.js & NPM:** `^20.x`
* **Servidor Local:** Laravel Herd (Recomendado) o Laragon.
* **Base de Datos:** MySQL o MariaDB.
* **Git**

---

## 🚀 Instalación Local

Sigue estos pasos en tu terminal para levantar el proyecto en tu máquina:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git](https://github.com/NicoBA007/ProyectoFinal-TecnologiaWeb2.git)
   cd ProyectoFinal-TecnologiaWeb2
   ```


Asegúrate de tener instalados Composer y Node.js:

2. **Instalar dependencias del Backend (PHP)**


    ```Bash
    composer install
    ```
3. **Instalar dependencias del Frontend (Node)**
    ```bash
    npm install
    ```
Configura el archivo de entorno y genera la llave de seguridad:

4. **Preparar variables de entorno:**

    ```Bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Preparar la Base de Datos:**
    - Abre tu gestor de base de datos (HeidiSQL, DBeaver, phpMyAdmin).

   - Crea una base de datos llamada primecinemas_db.
---
### ⚙️ Configuración Crítica (.env)
---
*Asegúrate de que tu archivo .env local refleje esta configuración exacta para evitar problemas de conexión y permisos (especialmente en Windows):*

```bash
# Conexión a Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=primecinemas_db
DB_USERNAME=root
DB_PASSWORD=TU_CONTRASEÑA_LOCAL

# Gestión de Sesiones y Caché
SESSION_DRIVER=file
CACHE_STORE=file
```

*⚠️ Solución de Errores Comunes: Si experimentas errores del tipo Access Denied (Code 5) al navegar, se debe a bloqueos de Windows sobre los archivos temporales. Ejecuta php artisan view:clear en tu terminal para solucionarlo.*

## 🔐 Flujo de Autenticación y Arquitectura MVC

El sistema de acceso de **PrimeCinemas** utiliza el patrón de diseño **MVC (Modelo-Vista-Controlador)** optimizado para integrarse con una base de datos relacional preexistente. A continuación, se detalla el ciclo de vida de la autenticación:

### 1. El Modelo (`app/Models/User.php`)
El modelo de Eloquent fue refactorizado para abandonar las convenciones por defecto de Laravel y adaptarse al esquema de la base de datos del cine:
* **Tabla Personalizada:** Se utiliza `protected $table = 'usuarios';` en lugar de `users`.
* **Llave Primaria:** Se define `protected $primaryKey = 'id_usuario';` para asegurar que las relaciones y las búsquedas por ID funcionen correctamente.
* **Timestamps Desactivados:** Se incluye `public $timestamps = false;` para evitar que Laravel intente insertar `created_at` y `updated_at`, delegando el control de fechas (como `fecha_registro`) directamente al motor de MySQL.

### 2. Las Vistas (`resources/views/auth/`)
La capa de presentación (Frontend) utiliza el motor de plantillas **Blade** combinado con **Tailwind CSS**.
* **Layout Guest:** Envuelve los formularios de Login y Registro proporcionando el fondo oscuro, los gradientes radiales y el efecto cristal (*Glassmorphism*).
* **Componentes de Formulario:** Recopilan las credenciales del usuario (`email`, `password`, `name`) y las envían a través de peticiones HTTP POST, protegiendo la transacción mediante directivas `@csrf` (Cross-Site Request Forgery).

### 3. Los Controladores (`app/Http/Controllers/Auth/`)
Son el cerebro de la operación. Reciben las peticiones de las Vistas y operan sobre el Modelo:
* **`RegisteredUserController.php`:** Valida que el correo sea único, encripta la contraseña usando el algoritmo *Bcrypt* (Hasheo seguro), guarda el nuevo registro en la tabla `usuarios` y autentica al usuario instantáneamente.
* **`AuthenticatedSessionController.php`:** Recibe las credenciales de inicio de sesión, verifica que el hash de la contraseña coincida con la base de datos y genera una sesión segura. Si el login es exitoso, redirige al usuario a su Dashboard (`/dashboard`).
* **`PasswordController.php`:** Permite al usuario actualizar su contraseña desde su perfil, exigiendo la validación de la contraseña actual por motivos de seguridad.

### 4. Las Rutas (`routes/auth.php`)
El archivo de rutas fue purgado para implementar una política de **"Seguridad por Simplicidad"**. Se eliminaron intencionalmente los controladores y rutas de recuperación de contraseña y verificación de correos, dejando únicamente los *endpoints* estrictamente necesarios (Registro, Login, Logout y Actualización de Contraseña) para mantener el sistema ligero y libre de vulnerabilidades lógicas.

---

## 🚑 Solución de Problemas Frecuentes (Troubleshooting)

Si al instalar o correr el proyecto te encuentras con errores, revisa esta lista con las soluciones a los problemas más comunes en Windows:

### 1. Error en `composer install` (Versión de PHP)
**Error:** `Your requirements could not be resolved to an installable set of packages.`
**Causa:** Tienes una versión de PHP antigua. Laravel y este proyecto requieren PHP 8.2 o superior.
**Solución:** * Verifica tu versión con `php -v`.
* Si usas Laragon o XAMPP, actualiza tu versión de PHP. Recomendamos usar **Laravel Herd** para evitar este problema.

### 2. Error en `composer install` (Extensiones faltantes)
**Error:** `The requested PHP extension ext-zip * is missing from your system.`
**Causa:** Tu PHP no tiene habilitada alguna extensión necesaria (como zip, pdo_mysql o fileinfo).
**Solución:** * Abre el archivo `php.ini` de tu servidor local.
* Busca la línea `;extension=zip` (o la que te pida) y quítale el punto y coma (`;`) del principio para descomentarla. Guarda y reinicia tu servidor.

### 3. Error al correr `npm install` o `npm run dev` en PowerShell
**Error:** `npm : File C:\...\npm.ps1 cannot be loaded because running scripts is disabled on this system.`
**Causa:** Las políticas de seguridad de Windows están bloqueando la ejecución de scripts.
**Solución:** * Opción A: No uses PowerShell. Abre **Git Bash** o la terminal normal de comandos (CMD) y ejecuta los comandos ahí.
* Opción B: Abre PowerShell como Administrador y ejecuta: `Set-ExecutionPolicy RemoteSigned -Scope CurrentUser`, luego escribe `S` y presiona Enter.

### 4. Error 500 o Pantalla Blanca al iniciar sesión / registrarse
**Error:** `Access Denied (Code 5)` en la carpeta `storage` o pantalla en blanco.
**Causa:** Windows bloqueó los archivos temporales de las vistas y sesiones.
**Solución:** * En la terminal, dentro de la carpeta del proyecto, ejecuta: `php artisan view:clear` y `php artisan cache:clear`.

### 5. Error de Base de Datos al entrar a la web
**Error:** `SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'` o `Unknown database 'primecinemas_db'`.
**Causa:** Las credenciales de tu archivo `.env` no coinciden con tu MySQL o no has importado el script SQL.
**Solución:** * Revisa que `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` en el `.env` sean exactamente los de tu computadora local.
* Asegúrate de haber importado el script `base_de_datos.sql` en tu gestor (HeidiSQL, etc.).

---