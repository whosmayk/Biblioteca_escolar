<?php
include 'db.php';

if (isset($_POST['guardar_biblio'])) {
    $nombre = $_POST['nombre'];
    $turno = $_POST['turno'];
    $pass = $_POST['password']; // Tu tabla tiene el campo 'password'

    $sql = "INSERT INTO bibliotecario (nombre, turno, password) VALUES ('$nombre', '$turno', '$pass')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: index_bibliotecarios.php");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Bibliotecario</title>
    <style>
        .card { width: 350px; margin: 50px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; font-family: sans-serif; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #FF5722; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Registrar Personal</h3>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre del Bibliotecario" required>
            
            <label>Turno:</label>
            <select name="turno">
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
            </select>

            <input type="password" name="password" placeholder="Asignar Contraseña" required>
            
            <button type="submit" name="guardar_biblio">Guardar Personal</button>
        </form>
    </div>
</body>
</html>