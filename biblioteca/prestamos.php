<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Préstamos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2>Registro de Préstamos</h2>
    <a href="prestamos_form.php" class="btn btn-primary mb-3">Registrar Nuevo Préstamo</a>
    <a href="index.php" class="btn btn-secondary mb-3">Menú</a>

    <table class="table table-sm table-bordered">
        <thead class="table-info">
            <tr>
                <th>Folio</th>
                <th>Alumno</th>
                <th>Libro</th>
                <th>Bibliotecario</th>
                <th>Salida</th>
                <th>Entrega Esperada</th>
                <th>Devolución Real</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // JOIN para traer los nombres en lugar de solo los IDs
            $sql = "SELECT p.*, a.nombre as alumno, l.titulo as libro, b.nombre as bibliotecario 
                    FROM prestamo p
                    JOIN alumno a ON p.id_alumno = a.id_alumno
                    JOIN libro l ON p.id_libro = l.id_libro
                    JOIN bibliotecario b ON p.id_bibliotecario = b.id_bibliotecario";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['id_prestamo']}</td>
                    <td>{$row['alumno']}</td>
                    <td>{$row['libro']}</td>
                    <td>{$row['bibliotecario']}</td>
                    <td>{$row['fecha_salida']}</td>
                    <td>{$row['fecha_entrega_esperada']}</td>
                    <td>" . ($row['fecha_devolucion_real'] ?? '<span class="text-danger">Pendiente</span>') . "</td>
                    <td>";
                if (!$row['fecha_devolucion_real']) {
                    echo "<a href='prestamos.php?return={$row['id_prestamo']}&libro={$row['id_libro']}' class='btn btn-success btn-sm'>Marcar Devolución</a>";
                }
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Lógica para devolver libro
    if (isset($_GET['return'])) {
        $id_p = $_GET['return'];
        $id_l = $_GET['libro'];
        $hoy = date('Y-m-d');
        
        // 1. Actualizar fecha en préstamo
        $stmt1 = $pdo->prepare("UPDATE prestamo SET fecha_devolucion_real = ? WHERE id_prestamo = ?");
        $stmt1->execute([$hoy, $id_p]);
        
        // 2. Liberar el libro
        $stmt2 = $pdo->prepare("UPDATE libro SET estado = 'disponible' WHERE id_libro = ?");
        $stmt2->execute([$id_l]);
        
        header("Location: prestamos.php");
    }
    ?>
</body>
</html>