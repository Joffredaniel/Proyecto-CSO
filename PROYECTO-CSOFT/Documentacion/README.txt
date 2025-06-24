# Proyecto CSO - Gestión de Reparaciones

## Descripción

Este proyecto es un sistema web para la gestión de clientes y reparaciones de dispositivos móviles.  
Está desarrollado con PHP y PostgreSQL, usando pgAdmin4 para administrar la base de datos.  

---

## Requisitos

- Servidor local con soporte PHP (ej. XAMPP, WAMP).  
- PostgreSQL instalado (puedes usar pgAdmin4 para administrar la BD).  
- Navegador web moderno.  

---

## Configuración

1. Clonar o descargar el repositorio en tu carpeta de servidor local (ej. `htdocs` en XAMPP):

```bash
git clone https://github.com/Joffredaniel/Proyecto-CSO.git PROYECTO-CSOFT

Importar la base de datos:

    Abrir pgAdmin4.

    Crear una base de datos llamada taller_reparacion 

    Ejecutar el script SQL con las tablas necesarias (clientes, reparaciones, usuarios, etc.).



2. Configurar conexión a la base de datos:

    Abrir el archivo conexion.php.

    Modificar los parámetros de conexión según tu entorno (en mi caso):

$host = 'localhost';
$port = '5432';
$dbname = 'taller_reparacion';
$user = 'postgres';
$password = 'postgres';


3. Uso

    Iniciar el servidor local (XAMPP o similar).

    Abrir el navegador y acceder a la página principal:

    http://localhost/PROYECTO-CSOFT/Codigo/login.php

    Ingresar con usuario y contraseña registrados (por ejemplo, admin / 123456).

    Navegar por el menú para registrar clientes, reparaciones, y ver listados.


4. Funcionalidades

    Registro y validación de clientes.

    Registro de reparaciones con estado.

    Login con manejo de sesión.

    Listado y filtrado de reparaciones por estado.

    Manejo de errores con mensajes amigables y logs.


5. Estructura del proyecto

    conexion.php — Configuración y conexión a la base de datos.

    login.php — Página de inicio de sesión.

    registro_cliente.php — Formulario y lógica para registrar clientes.

    registro_reparacion.php — Formulario y lógica para registrar reparaciones.

    listar_reparaciones.php — Visualización y filtrado de reparaciones.

    menu.php — Menú de navegación común.

    css/ — Carpeta con estilos CSS.


6. Tolerancia a fallos

    Uso de manejo de excepciones con try-catch.

    Validación estricta de datos.

    Transacciones para garantizar integridad de datos.

    Registro de errores en logs del servidor.



7. Cómo contribuir

Por ahora este proyecto es para fines académicos. Para dudas o mejoras, contacta a los integrantes del grupo.
Contacto

    [Joffre Yagual Ureta - Joffredaniel@proton.me]

 
