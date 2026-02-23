<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Libros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2>Inventario de Libros</h2>
    <a href="libros_form.php" class="btn btn-success mb-3">Nuevo Libro</a>
    <a href="index.php" class="btn btn-secondary mb-3">Volver al Menú</a>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM libro");
            while ($row = $stmt->fetch()) {
                $badge = ($row['estado'] == 'disponible') ? 'bg-success' : 'bg-danger';
                echo "<tr>
                    <td>{$row['id_libro']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['isbn']}</td>
                    <td><span class='badge $badge'>{$row['estado']}</span></td>
                    <td>
                        <a href='libros_form.php?id={$row['id_libro']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='libros.php?delete={$row['id_libro']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Borrar libro?\")'>Eliminar</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM libro WHERE id_libro = ?");
        $stmt->execute([$_GET['delete']]);
        header("Location: libros.php");
    }
    ?>
</body>
</html>