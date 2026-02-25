<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ejecutamos la orden de eliminar
    $sql = "DELETE FROM alumno WHERE id_alumno = $id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: index.php?msg=eliminado");
    } else {
        echo "No se puede eliminar: El alumno tiene préstamos activos.";
    }
}
?>