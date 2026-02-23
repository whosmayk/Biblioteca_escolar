<?php 
include 'config.php';
$id = $_GET['id'] ?? null;
$alumno = ['nombre' => '', 'grado_grupo' => '', 'email' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM alumno WHERE id_alumno = ?");
    $stmt->execute([$id]);
    $alumno = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado_grupo'];
    $email = $_POST['email'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE alumno SET nombre=?, grado_grupo=?, email=? WHERE id_alumno=?");
        $stmt->execute([$nombre, $grado, $email, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO alumno (nombre, grado_grupo, email) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $grado, $email]);
    }
    header("Location: alumnos.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2><?php echo $id ? 'Editar' : 'Nuevo'; ?> Alumno</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $alumno['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Grado y Grupo</label>
            <input type="text" name="grado_grupo" class="form-control" value="<?php echo $alumno['grado_grupo']; ?>">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $alumno['email']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="alumnos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>