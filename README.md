# 📰 El Faro (Versión Laravel) - ¡Iluminando las Noticias! 💡

¡Bienvenido/a al repositorio del proyecto "El Faro"! Este no es un periódico cualquiera, es el resultado de una misión: ¡transformar un sitio de noticias estático en una aplicación web dinámica y moderna! Este proyecto fue desarrollado como parte del curso **Taller de Aplicaciones para Internet** del **Instituto Profesional AIEP**.

## 🎯 El Desafío

El objetivo era tomar el sitio original "El Faro" (construido con HTML, CSS y JS) y darle superpoderes usando **PHP** y el increíble framework **Laravel**. Queríamos pasar de páginas fijas a un sistema donde las noticias fluyen desde una base de datos y los usuarios pueden interactuar. ¡Spoiler: Misión cumplida! 😉

## ✨ Funcionalidades Implementadas

Este faro ahora ilumina con:

* **Arquitectura MVC:** Código organizado como los profesionales, separando Modelo, Vista y Controlador. ¡Adiós al caos!
* **Noticias desde Base de Datos:** Las noticias ya no están atrapadas en archivos, ¡viven libres en una base de datos MySQL! Se muestran en la portada, por secciones y en páginas de detalle individuales.
* **Gestión de Usuarios:** ¡Los lectores pueden unirse a la tripulación!
    * Registro de nuevas cuentas.
    * Inicio de sesión seguro.
    * Cierre de sesión.
    * Página de perfil básica para ver tus datos.
* **Agregar Noticias (¡Para usuarios registrados!):** Un formulario protegido permite añadir nuevas noticias al sistema, ¡incluso con subida de imagen de portada! 🖼️
* **Formulario de Contacto:** Un canal para que los visitantes envíen mensajes (con validación incluida).
* **Páginas Estáticas:** Secciones para las importantes (pero a veces olvidadas) políticas de Privacidad, Cookies y Términos de Uso.
* **Diseño Responsivo:** Mantenemos el look & feel original con Bootstrap 5, adaptándose a cualquier pantalla.

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP 8+, Laravel 12.x
* **Frontend:** Blade (motor de plantillas de Laravel), HTML5, CSS3, JavaScript
* **Framework UI:** Bootstrap 5
* **Base de Datos:** MySQL / MariaDB
* **Servidor Desarrollo:** XAMPP (o similar)
* **Gestor Dependencias:** Composer
* **Control de Versiones:** Git & GitHub

## 🚀 Puesta en Marcha Local (¡Para Probarlo!)

¿Quieres ver El Faro brillar en tu propia máquina? Sigue estos pasos:

1.  **Clona el Repositorio:**
    ```bash
    git clone [https://github.com/OowarriorwhiteoO/tu-nuevo-nombre-de-repo.git](https://github.com/OowarriorwhiteoO/tu-nuevo-nombre-de-repo.git)  # Reemplaza con el nombre correcto de tu repo
    cd tu-nuevo-nombre-de-repo
    ```
2.  **Instala Dependencias PHP:**
    ```bash
    composer install
    ```
3.  **Crea tu Archivo `.env`:**
    * Copia `.env.example` a un nuevo archivo llamado `.env`.
    * Edita `.env` y configura tus credenciales de base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Asegúrate de que la base de datos exista en tu MySQL local.
    * Verifica que `APP_URL` sea `http://127.0.0.1:8000` o `http://localhost:8000`.
    * Asegúrate que `SESSION_DRIVER=file`.
4.  **Genera la Clave de Aplicación:**
    ```bash
    php artisan key:generate
    ```
5.  **Crea el Enlace Simbólico de Almacenamiento:** (¡Importante para ver las imágenes subidas!)
    ```bash
    php artisan storage:link
    ```
6.  **Ejecuta las Migraciones y Seeders:** (Esto crea las tablas y las llena con noticias iniciales)
    ```bash
    php artisan migrate:fresh --seed
    ```
7.  **Inicia el Servidor de Desarrollo:**
    ```bash
    php artisan serve
    ```
8.  **¡Navega!** Abre tu navegador y visita `http://127.0.0.1:8000` (o la URL que te dé el comando anterior).


