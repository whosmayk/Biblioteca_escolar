<?php 
include 'config.php'; 
include 'header.php'; 

$id = $_GET['id'] ?? null;
$biblio = ['nombre' => '', 'turno' => ''];

// 1. Si hay ID, buscamos los datos para llenar el formulario
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM bibliotecario WHERE id_bibliotecario = ?");
    $stmt->execute([$id]);
    $biblio = $stmt->fetch();
}

// 2. Procesar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $turno = $_POST['turno'];
    $password = $_POST['password'];

    if ($id) {
        // --- CASO: EDITAR ---
        if (!empty($password)) {
            // Si escribió una nueva contraseña, la encriptamos y actualizamos todo
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE bibliotecario SET nombre = ?, turno = ?, password = ? WHERE id_bibliotecario = ?";
            $params = [$nombre, $turno, $pass_hash, $id];
        } else {
            // Si dejó la contraseña vacía, NO la tocamos en la base de datos
            $sql = "UPDATE bibliotecario SET nombre = ?, turno = ? WHERE id_bibliotecario = ?";
            $params = [$nombre, $turno, $id];
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        // --- CASO: NUEVO ---
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO bibliotecario (nombre, turno, password) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $turno, $pass_hash]);
    }

    // Redireccionar al listado
    echo "<script>window.location.href='bibliotecarios.php';</script>";
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><?php echo $id ? 'Editar Personal' : 'Nuevo Registro'; ?></h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" 
                               placeholder="Ej: Lic. Roberto Gómez" 
                               value="<?php echo htmlspecialchars($biblio['nombre']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Turno</label>
                        <select name="turno" class="form-select" required>
                            <option value="" disabled>Selecciona el turno...</option>
                            <option value="Matutino" <?php echo ($biblio['turno'] == 'Matutino') ? 'selected' : ''; ?>>Matutino</option>
                            <option value="Vespertino" <?php echo ($biblio['turno'] == 'Vespertino') ? 'selected' : ''; ?>>Vespertino</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" 
                               placeholder="<?php echo $id ? 'Dejar vacío para no cambiar' : 'Escribe una contraseña segura'; ?>"
                               <?php echo $id ? '' : 'required'; ?>>
                        <?php if($id): ?>
                            <small class="text-muted">Si no deseas cambiar la clave actual, deja este campo en blanco.</small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="bibliotecarios.php" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-primary">Guardar Bibliotecario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>