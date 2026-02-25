<?php
include 'db.php';
$query = "SELECT id_bibliotecario, nombre, turno FROM bibliotecario";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personal Bibliotecario</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; font-family: Arial; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #FF5722; color: white; }
        .btn-add { background: #FF5722; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h2 style="text-align:center;">Bibliotecarios registrados</h2>
    <div style="text-align:center; margin: 20px auto; margin-bottom:20px;">
        <a href="formulario_bibliotecario.php" class="btn-add">+ Registrar Bibliotecario</a>
        <a href="index.php" style="text-decoration:none; color: gray; margin-left:15px;">Volver</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Turno</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $row['id_bibliotecario']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['turno']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>