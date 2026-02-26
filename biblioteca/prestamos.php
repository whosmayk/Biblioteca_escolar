<?php 
include 'config.php'; 

// --- 1. LÓGICA DE DEVOLUCIÓN ---
if (isset($_GET['return'])) {
    $id_p = $_GET['return'];
    $id_l = $_GET['libro'];
    $hoy = date('Y-m-d');
    
    $pdo->beginTransaction();
    $pdo->prepare("UPDATE prestamo SET fecha_devolucion_real = ? WHERE id_prestamo = ?")->execute([$hoy, $id_p]);
    $pdo->prepare("UPDATE libro SET estado = 'disponible' WHERE id_libro = ?")->execute([$id_l]);
    $pdo->commit();
    header("Location: prestamos.php");
    exit;
}

// --- 2. LÓGICA DE ELIMINAR ---
if (isset($_GET['delete_id'])) {
    $id_p = $_GET['delete_id'];
    $id_l = $_GET['id_libro'];

    try {
        $pdo->beginTransaction();

        // Verificamos si el préstamo que vamos a borrar estaba pendiente de devolución
        $check = $pdo->prepare("SELECT fecha_devolucion_real FROM prestamo WHERE id_prestamo = ?");
        $check->execute([$id_p]);
        $prestamo = $check->fetch();

        // Si el libro NO había sido devuelto, lo ponemos como disponible antes de borrar el préstamo
        if ($prestamo && $prestamo['fecha_devolucion_real'] == null) {
            $pdo->prepare("UPDATE libro SET estado = 'disponible' WHERE id_libro = ?")->execute([$id_l]);
        }

        // Borramos el registro del préstamo
        $pdo->prepare("DELETE FROM prestamo WHERE id_prestamo = ?")->execute([$id_p]);

        $pdo->commit();
        header("Location: prestamos.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error al eliminar: " . $e->getMessage());
    }
}

include 'header.php'; 
$busqueda = $_GET['search'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Préstamos</h2>
    <a href="prestamos_form.php" class="btn btn-primary">+ Nuevo Préstamo</a>
</div>

<!-- Barra de búsqueda -->
<form method="GET" class="mb-4">
    <div class="input-group shadow-sm">
        <input type="text" name="search" class="form-control" placeholder="Buscar por alumno, libro o folio..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
        <?php if($busqueda != ''): ?>
            <a href="prestamos.php" class="btn btn-outline-secondary">Limpiar</a>
        <?php endif; ?>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover border shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Folio</th>
                <th>Alumno</th>
                <th>Libro</th>
                <th>Salida</th>
                <th>Entrega Esperada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.*, a.nombre as alumno, l.titulo as libro 
                    FROM prestamo p
                    JOIN alumno a ON p.id_alumno = a.id_alumno
                    JOIN libro l ON p.id_libro = l.id_libro
                    WHERE a.nombre LIKE :v OR l.titulo LIKE :v OR p.id_prestamo LIKE :v
                    ORDER BY p.id_prestamo DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['v' => "%$busqueda%"]);

            while ($row = $stmt->fetch()): 
                $esperada = $row['fecha_entrega_esperada'];
                $real = $row['fecha_devolucion_real'];
                $es_tarde = ($real && $real > $esperada);
                $pendiente_retrasado = (!$real && date('Y-m-d') > $esperada);
            ?>
                <tr>
                    <td>#<?php echo $row['id_prestamo']; ?></td>
                    <td><?php echo $row['alumno']; ?></td>
                    <td><?php echo $row['libro']; ?></td>
                    <td><?php echo $row['fecha_salida']; ?></td>
                    <td><?php echo $esperada; ?></td>
                    <td>
                        <?php if ($es_tarde): ?>
                            <span class="badge bg-danger">⚠️ Devolución Tardía</span>
                        <?php elseif ($pendiente_retrasado): ?>
                            <span class="badge bg-dark">🚨 Retrasado</span>
                        <?php elseif ($real): ?>
                            <span class="badge bg-success">✓ Devuelto</span>
                        <?php else: ?>
                            <span class="badge bg-info text-dark">En curso</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php if (!$real): ?>
                                <a href="prestamos.php?return=<?php echo $row['id_prestamo']; ?>&libro=<?php echo $row['id_libro']; ?>" 
                                   class="btn btn-sm btn-success" title="Marcar Devolución">Devolver</a>
                            <?php endif; ?>
                            
                            <a href="prestamos_form.php?id=<?php echo $row['id_prestamo']; ?>" 
                               class="btn btn-sm btn-warning" title="Editar">Editar</a>
                            
                            <a href="prestamos.php?delete_id=<?php echo $row['id_prestamo']; ?>&id_libro=<?php echo $row['id_libro']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Estás seguro de eliminar este préstamo? Si el libro no ha sido devuelto, se marcará como disponible automáticamente.')" 
                               title="Eliminar">Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>