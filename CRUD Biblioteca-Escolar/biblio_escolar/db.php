<?php
// 1. Configuración de los parámetros de tu base de datos
$host = "localhost";    // Casi siempre es localhost
$user = "root";         // Usuario por defecto de XAMPP
$password = "";         // Por defecto en XAMPP está vacío
$dbname = "biblioteca_escolar"; // CAMBIA ESTO por el nombre que pusiste en MySQL Workbench

// 2. Crear la conexión usando la extensión mysqli
$conexion = mysqli_connect($host, $user, $password, $dbname);

// 3. Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} 

// Opcional: Esto ayuda a que los acentos y la "ñ" se vean bien
mysqli_set_charset($conexion, "utf8");

// Si llegamos aquí, ¡todo está funcionando!
// echo "Conexión exitosa"; 
?>