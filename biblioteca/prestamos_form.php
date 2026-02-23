<?php 
include 'config.php';

// Consultas para llenar los selectores
$alumnos = $pdo->query("SELECT id_alumno, nombre FROM alumno")->fetchAll();
$libros = $pdo->query("SELECT id_libro, titulo FROM libro WHERE estado = 'disponible'")->fetchAll();
$bibliotecarios = $pdo->query("SELECT id_id_bibliotecario, nombre FROM bibliotecario")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_a = $_POST['id_alumno'];
    $id_l = $_POST['id_libro'];
    $id_b = $_POST['id_bibliotecario'];
    $f_salida = $_POST['fecha_salida'];
    $f_esperada = $_POST['fecha_entrega_esperada'];

    try {
        $pdo->beginTransaction();

        // 1. Insertar el préstamo
        $sql = "INSERT INTO prestamo (id_alumno, id_libro, id_bibliotecario, fecha_salida, fecha_entrega_esperada) 
                VALUES (?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$id_a, $id_l, $id_b, $f_salida, $f_esperada]);

        // 2. Cambiar estado del libro a prestado
        $pdo->prepare("UPDATE libro SET estado = 'prestado' WHERE id_libro = ?")->execute([$id_l]);

        $pdo->commit();
        header("Location: prestamos.php");
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Préstamo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2>Registrar Préstamo de Libro</h2>
    <form method="POST" class="card p-4 shadow">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Alumno</label>
                <select name="id_alumno" class="form-select" required>
                    <?php foreach($alumnos as $a): ?>
                        <option value="<?php echo $a['id_alumno']; ?>"><?php echo $a['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Libro (Solo disponibles)</label>
                <select name="id_libro" class="form-select" required>
                    <?php foreach($libros as $l): ?>
                        <option value="<?php echo $l['id_libro']; ?>"><?php echo $l['titulo']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Bibliotecario que autoriza</label>
            <select name="id_bibliotecario" class="form-select" required>
                <?php foreach($bibliotecarios as $b): ?>
                    <option value="<?php echo $b['id_id_bibliotecario']; ?>"><?php echo $b['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Fecha Salida</label>
                <input type="date" name="fecha_salida" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Fecha Entrega Esperada</label>
                <input type="date" name="fecha_entrega_esperada" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Confirmar Préstamo</button>
        <a href="prestamos.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>