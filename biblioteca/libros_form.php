<?php 
include 'config.php';
$id = $_GET['id'] ?? null;
$libro = ['titulo' => '', 'autor' => '', 'isbn' => '', 'estado' => 'disponible'];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM libro WHERE id_libro = ?");
    $stmt->execute([$id]);
    $libro = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $estado = $_POST['estado'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE libro SET titulo=?, autor=?, isbn=?, estado=? WHERE id_libro=?");
        $stmt->execute([$titulo, $autor, $isbn, $estado, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO libro (titulo, autor, isbn, estado) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor, $isbn, $estado]);
    }
    header("Location: libros.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario Libro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <?php include 'navbar.php'; ?>
    <h2><?php echo $id ? 'Editar' : 'Nuevo'; ?> Libro</h2>
    <form method="POST" class="card p-4 shadow">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo $libro['titulo']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control" value="<?php echo $libro['autor']; ?>">
        </div>
        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" value="<?php echo $libro['isbn']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select">
                <option value="disponible" <?php if($libro['estado']=='disponible') echo 'selected'; ?>>Disponible</option>
                <option value="prestado" <?php if($libro['estado']=='prestado') echo 'selected'; ?>>Prestado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="libros.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>