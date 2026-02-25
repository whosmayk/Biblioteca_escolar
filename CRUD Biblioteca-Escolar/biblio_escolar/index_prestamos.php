<?php
include 'db.php';
// Consulta con JOIN para ver Nombres en lugar de IDs
$query = "SELECT p.id_prestamo, p.id_libro, a.nombre AS alumno, l.titulo AS libro, 
                 p.fecha_salida, p.fecha_entrega_esperada, p.fecha_devolucion_real 
          FROM prestamo p
          JOIN alumno a ON p.id_alumno = a.id_alumno
          JOIN libro l ON p.id_libro = l.id_libro";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Préstamos</title>
    <style>
        table { width: 95%; margin: auto; border-collapse: collapse; font-family: Arial; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: #673AB7; color: white; }
        .devuelto { color: green; font-weight: bold; }
        .pendiente { color: orange; font-weight: bold; }
        .btn-dev { background: #4CAF50; color: white; padding: 5px; text-decoration: none; border-radius: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h2 style="text-align:center;">Préstamos Activos</h2>
    <div style="text-align:center; margin-bottom: 20px;">
        <a href="formulario_prestamo.php" style="background: #673AB7; color: white; padding: 10px; text-decoration: none;">+ Nuevo Préstamo</a>
    </div>

    <table>
        <tr>
            <th>Alumno</th>
            <th>Libro</th>
            <th>Salida</th>
            <th>Límite</th>
            <th>Estado / Fecha Real</th>
            <th>Acción</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $row['alumno']; ?></td>
            <td><?php echo $row['libro']; ?></td>
            <td><?php echo $row['fecha_salida']; ?></td>
            <td><?php echo $row['fecha_entrega_esperada']; ?></td>
            <td>
                <?php if($row['fecha_devolucion_real']) { ?>
                    <span class="devuelto">Devuelto el: <?php echo $row['fecha_devolucion_real']; ?></span>
                <?php } else { ?>
                    <span class="pendiente">En posesión</span>
                <?php } ?>
            </td>
            <td>
                <?php if(!$row['fecha_devolucion_real']) { ?>
                    <a href="devolver.php?id_prestamo=<?php echo $row['id_prestamo']; ?>&id_libro=<?php echo $row['id_libro']; ?>" class="btn-dev">Marcar Devolución</a>
                <?php } else { echo "---"; } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>