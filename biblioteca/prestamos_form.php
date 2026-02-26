<?php 
include 'config.php'; 
include 'header.php';

$id = $_GET['id'] ?? null;
$p = [
    'id_alumno' => '', 'id_libro' => '', 'id_bibliotecario' => '', 
    'fecha_salida' => date('Y-m-d'), 'fecha_entrega_esperada' => ''
];

// Si editamos, cargamos datos actuales
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM prestamo WHERE id_prestamo = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    $id_libro_anterior = $p['id_libro'];
}

// Procesar Formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_a = $_POST['id_alumno'];
    $id_l = $_POST['id_libro'];
    $id_b = $_POST['id_bibliotecario'];
    $f_s = $_POST['fecha_salida'];
    $f_e = $_POST['fecha_entrega_esperada'];

    try {
        $pdo->beginTransaction();

        if ($id) {
            // EDITAR
            $sql = "UPDATE prestamo SET id_alumno=?, id_libro=?, id_bibliotecario=?, fecha_salida=?, fecha_entrega_esperada=? WHERE id_prestamo=?";
            $pdo->prepare($sql)->execute([$id_a, $id_l, $id_b, $f_s, $f_e, $id]);

            // Si el libro cambió, actualizar estados
            if ($id_l != $id_libro_anterior) {
                $pdo->prepare("UPDATE libro SET estado = 'disponible' WHERE id_libro = ?")->execute([$id_libro_anterior]);
                $pdo->prepare("UPDATE libro SET estado = 'prestado' WHERE id_libro = ?")->execute([$id_l]);
            }
        } else {
            // NUEVO
            $sql = "INSERT INTO prestamo (id_alumno, id_libro, id_bibliotecario, fecha_salida, fecha_entrega_esperada) VALUES (?,?,?,?,?)";
            $pdo->prepare($sql)->execute([$id_a, $id_l, $id_b, $f_s, $f_e]);
            $pdo->prepare("UPDATE libro SET estado = 'prestado' WHERE id_libro = ?")->execute([$id_l]);
        }

        $pdo->commit();
        echo "<script>window.location.href='prestamos.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Datos para los SELECTS
$alumnos = $pdo->query("SELECT id_alumno, nombre FROM alumno")->fetchAll();
$biblios = $pdo->query("SELECT id_bibliotecario, nombre FROM bibliotecario")->fetchAll();
// Mostramos libros disponibles O el libro que ya tiene este préstamo actualmente
$libros = $pdo->prepare("SELECT id_libro, titulo FROM libro WHERE estado = 'disponible' OR id_libro = ?");
$libros->execute([$p['id_libro']]);
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4><?php echo $id ? 'Editar Préstamo #'.$id : 'Nuevo Préstamo'; ?></h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Alumno</label>
                            <select name="id_alumno" class="form-select" required>
                                <?php foreach($alumnos as $a): ?>
                                    <option value="<?php echo $a['id_alumno']; ?>" <?php echo $a['id_alumno']==$p['id_alumno']?'selected':''; ?>>
                                        <?php echo $a['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Libro</label>
                            <select name="id_libro" class="form-select" required>
                                <?php foreach($libros->fetchAll() as $l): ?>
                                    <option value="<?php echo $l['id_libro']; ?>" <?php echo $l['id_libro']==$p['id_libro']?'selected':''; ?>>
                                        <?php echo $l['titulo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Bibliotecario</label>
                        <select name="id_bibliotecario" class="form-select" required>
                            <?php foreach($biblios as $b): ?>
                                <option value="<?php echo $b['id_bibliotecario']; ?>" <?php echo $b['id_bibliotecario']==$p['id_bibliotecario']?'selected':''; ?>>
                                    <?php echo $b['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha Salida</label>
                            <input type="date" name="fecha_salida" class="form-control" value="<?php echo $p['fecha_salida']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Fecha Entrega Esperada</label>
                            <input type="date" name="fecha_entrega_esperada" class="form-control" value="<?php echo $p['fecha_entrega_esperada']; ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="prestamos.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>