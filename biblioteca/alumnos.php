<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Alumnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2>Lista de Alumnos</h2>
    <a href="alumnos_form.php" class="btn btn-success mb-3">Nuevo Alumno</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Grado/Grupo</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM alumno");
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['id_alumno']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['grado_grupo']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='alumnos_form.php?id={$row['id_alumno']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='alumnos.php?delete={$row['id_alumno']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Borrar?\")'>Eliminar</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM alumno WHERE id_alumno = ?");
        $stmt->execute([$_GET['delete']]);
        header("Location: alumnos.php");
    }
    ?>
</body>
</html>