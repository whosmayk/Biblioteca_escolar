<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Bibliotecario</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; margin: 0; }
        .dashboard { display: flex; justify-content: center; gap: 20px; margin-top: 50px; }
        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center; width: 150px; }
        .card h1 { font-size: 40px; margin: 10px 0; color: #333; }
        .card p { color: #666; font-weight: bold; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h1 style="text-align:center;">Bienvenido al Sistema de Biblioteca</h1>

    <div class="dashboard">
        <div class="card">
            <p>Alumnos</p>
            <h1><?php echo mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumno")); ?></h1>
        </div>
        <div class="card">
            <p>Libros</p>
            <h1><?php echo mysqli_num_rows(mysqli_query($conexion, "SELECT id_libro FROM libro")); ?></h1>
        </div>
        <div class="card">
            <p>Préstamos</p>
            <h1><?php echo mysqli_num_rows(mysqli_query($conexion, "SELECT id_prestamo FROM prestamo WHERE fecha_devolucion_real IS NULL")); ?></h1>
        </div>
    </div>
</body>
</html>