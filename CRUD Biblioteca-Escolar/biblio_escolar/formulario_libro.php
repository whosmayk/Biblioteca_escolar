<?php
include 'db.php';

if (isset($_POST['guardar_libro'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO libro (titulo, autor, isbn, estado) VALUES ('$titulo', '$autor', '$isbn', '$estado')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: index_libros.php");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Libro</title>
    <style>
        .box { width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; font-family: Arial; }
        input, select { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #2196F3; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h3>Registrar ejemplar</h3>
        <form method="POST">
            <input type="text" name="titulo" placeholder="Título del libro" required>
            <input type="text" name="autor" placeholder="Nombre del autor" required>
            <input type="text" name="isbn" placeholder="Código ISBN" required>
            
            <label>Estado inicial:</label>
            <select name="estado">
                <option value="disponible">Disponible</option>
                <option value="prestado">Prestado</option>
            </select>

            <button type="submit" name="guardar_libro">Guardar Libro</button>
            <a href="index_libros.php" style="display:block; text-align:center; margin-top:10px; font-size:12px;">Cancelar</a>
        </form>
    </div>
</body>
</html>