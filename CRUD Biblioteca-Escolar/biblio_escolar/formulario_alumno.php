<?php
include 'db.php'; // Conectamos a la base de datos

// 1. Verificar si el usuario hizo clic en el botón "Guardar"
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado_grupo'];
    $email = $_POST['email'];

    // 2. Insertar los datos en la tabla 'alumno'
    $sql = "INSERT INTO alumno (nombre, grado_grupo, email) VALUES ('$nombre', '$grado', '$email')";

    if (mysqli_query($conexion, $sql)) {
        // Si sale bien, regresamos a la tabla principal
        header("Location: index.php");
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);
    }
}
?>

<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light"> <?php include 'menu.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registrar Nuevo Alumno</h4>
                    </div>
                    <div class="card-body">
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Grado y Grupo</label>
                                <input type="text" name="grado_grupo" class="form-control" placeholder="Ej: 3-A" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="guardar" class="btn btn-success">Guardar registro</button>
                                <a href="index.php" class="btn btn-outline-secondary">Cancelar y volver</a>
                            </div>
                        </form>

                    </div>
                </div> </div>
        </div>
    </div>

</body>
</html>