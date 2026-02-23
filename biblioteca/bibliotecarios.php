<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bibliotecarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2>Personal Bibliotecario</h2>
    <a href="bibliotecarios_form.php" class="btn btn-success mb-3">Nuevo Bibliotecario</a>
    <table class="table">
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Turno</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM bibliotecario");
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['id_bibliotecario']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['turno']}</td>
                    <td>
                        <a href='bibliotecarios.php?delete={$row['id_bibliotecario']}' class='btn btn-danger btn-sm'>Borrar</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>