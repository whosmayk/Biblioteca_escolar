<?php
include 'db.php';

if (isset($_GET['id_prestamo']) && isset($_GET['id_libro'])) {
    $id_p = $_GET['id_prestamo'];
    $id_l = $_GET['id_libro'];
    $hoy = date('Y-m-d');

    // 1. Actualizamos la fecha de devolución en la tabla prestamo
    $sql_prestamo = "UPDATE prestamo SET fecha_devolucion_real = '$hoy' WHERE id_prestamo = $id_p";
    
    // 2. Volvemos a poner el libro como disponible
    $sql_libro = "UPDATE libro SET estado = 'disponible' WHERE id_libro = $id_l";

    if (mysqli_query($conexion, $sql_prestamo) && mysqli_query($conexion, $sql_libro)) {
        header("Location: index_prestamos.php?mensaje=devuelto");
    } else {
        echo "Error al devolver: " . mysqli_error($conexion);
    }
}
?>