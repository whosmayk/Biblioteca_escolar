<?php
// Incluimos la conexión que ya hiciste
include 'db.php';

// Consultamos la tabla alumno
$query = "SELECT * FROM alumno";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Alumnos</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; font-family: Arial; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 10px 15px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h2 style="text-align:center;">Listado de Alumnos</h2>
    
    <div style="text-align:center;">
        <a href="formulario_alumno.php" class="btn" style="background: #0e0e0f; color: white; padding: 10px; text-decoration: none;">+ Registrar Nuevo Estudiante</a>
    </div>

    <div class="container mt-4">
        <table class="table table-hover table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?php echo $row['id_alumno']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['grado_grupo']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="editar_alumno.php?id=<?php echo $row['id_alumno']; ?>">Editar</a> | 
                        <a href="eliminar_alumno.php?id=<?php echo $row['id_alumno']; ?>" 
                            style="color:red;" 
                            onclick="return confirm('¿Seguro que quieres borrar a este alumno?')">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>