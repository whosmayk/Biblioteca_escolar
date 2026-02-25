<?php
include 'db.php';

// Consultas para llenar los selectores (dropdowns)
$alumnos = mysqli_query($conexion, "SELECT id_alumno, nombre FROM alumno");
$libros = mysqli_query($conexion, "SELECT id_libro, titulo FROM libro WHERE estado = 'disponible'");
$bibliotecarios = mysqli_query($conexion, "SELECT id_bibliotecario, nombre FROM bibliotecario");

if (isset($_POST['registrar_prestamo'])) {
    $id_alumno = $_POST['id_alumno'];
    $id_libro = $_POST['id_libro'];
    $id_biblio = $_POST['id_bibliotecario'];
    $f_salida = $_POST['fecha_salida'];
    $f_esperada = $_POST['fecha_entrega_esperada'];

    // Verificación de seguridad: ¿Sigue el libro disponible?
    $chequeo = mysqli_query($conexion, "SELECT estado FROM libro WHERE id_libro = '$id_libro'");
    $fila = mysqli_fetch_assoc($chequeo);

    if ($fila['estado'] == 'disponible') {

        // 1. Insertar el préstamo
        $sql = "INSERT INTO prestamo (id_alumno, id_libro, id_bibliotecario, fecha_salida, fecha_entrega_esperada) 
                VALUES ('$id_alumno', '$id_libro', '$id_biblio', '$f_salida', '$f_esperada')";

        if (mysqli_query($conexion, $sql)) {
            // 2. IMPORTANTE: Cambiar el estado del libro a 'prestado' automáticamente
            mysqli_query($conexion, "UPDATE libro SET estado = 'prestado' WHERE id_libro = '$id_libro'");
            echo "<script>alert('Préstamo registrado con éxito'); window.location='index_prestamos.php';</script>";
        } else {
        echo "<script>alert('Error: Este libro acaba de ser prestado por alguien más.'); window.location='index_prestamos.php';</script>";
    }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Préstamo</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .form-card { width: 450px; margin: 30px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        select, input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 100%; padding: 12px; background: #673AB7; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Registrar Salida de Libro</h2>
    <form method="POST">
        <label>Alumno:</label>
        <select name="id_alumno" required>
            <?php while($a = mysqli_fetch_assoc($alumnos)) { 
                echo "<option value='".$a['id_alumno']."'>".$a['nombre']."</option>"; 
            } ?>
        </select>

        <label>Libro disponible:</label>
        <select name="id_libro" required>
            <?php while($l = mysqli_fetch_assoc($libros)) { 
                echo "<option value='".$l['id_libro']."'>".$l['titulo']."</option>"; 
            } ?>
        </select>

        <label>Bibliotecario que autoriza:</label>
        <select name="id_bibliotecario" required>
            <?php while($b = mysqli_fetch_assoc($bibliotecarios)) { 
                echo "<option value='".$b['id_bibliotecario']."'>".$b['nombre']."</option>"; 
            } ?>
        </select>

        <label>Fecha de Salida:</label>
        <input type="date" name="fecha_salida" value="<?php echo date('Y-m-d'); ?>" required>

        <label>Fecha Entrega Esperada:</label>
        <input type="date" name="fecha_entrega_esperada" required>

        <button type="submit" name="registrar_prestamo">Confirmar Préstamo</button>
    </form>
</div>

</body>
</html>