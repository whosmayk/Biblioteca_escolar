<?php 
include 'config.php'; 
include 'header.php'; 

// 1. Lógica de búsqueda
$busqueda = isset($_GET['search']) ? $_GET['search'] : '';

if ($busqueda != '') {
    // Si hay búsqueda, filtramos por nombre, grupo o email
    $sql = "SELECT * FROM alumno WHERE 
            nombre LIKE :valor OR 
            grado_grupo LIKE :valor OR 
            email LIKE :valor";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['valor' => "%$busqueda%"]);
} else {
    // Si no hay búsqueda, traemos todos los registros
    $stmt = $pdo->query("SELECT * FROM alumno");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Alumnos</h2>
    <a href="alumnos_form.php" class="btn btn-success">+ Nuevo Alumno</a>
</div>

<!-- Formulario de Búsqueda -->
<form method="GET" action="alumnos.php" class="mb-4">
    <div class="input-group shadow-sm">
        <input type="text" name="search" class="form-control" 
               placeholder="Buscar por nombre, grado o email..." 
               value="<?php echo htmlspecialchars($busqueda); ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
        <?php if($busqueda != ''): ?>
            <a href="alumnos.php" class="btn btn-outline-secondary">Limpiar filtro</a>
        <?php endif; ?>
    </div>
</form>

<!-- Tabla de Resultados -->
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Grado/Grupo</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($stmt->rowCount() > 0): ?>
                <?php while ($row = $stmt->fetch()): ?>
                    <tr>
                        <td><?php echo $row['id_alumno']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><span class="badge bg-info text-dark"><?php echo $row['grado_grupo']; ?></span></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="alumnos_form.php?id=<?php echo $row['id_alumno']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="alumnos.php?delete=<?php echo $row['id_alumno']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Estás seguro de eliminar este alumno?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No se encontraron alumnos con "<strong><?php echo htmlspecialchars($busqueda); ?></strong>"</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
// Lógica para eliminar
if (isset($_GET['delete'])) {
    $stmtDel = $pdo->prepare("DELETE FROM alumno WHERE id_alumno = ?");
    $stmtDel->execute([$_GET['delete']]);
    echo "<script>window.location.href='alumnos.php';</script>";
}

include 'footer.php'; 
?>