<?php
include 'db.php';

// 1. Verificar si el usuario escribió algo en el buscador
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
}

// 2. Consulta SQL "inteligente": si hay búsqueda, filtra; si no, trae todo.
$query = "SELECT * FROM libro 
          WHERE titulo LIKE '%$busqueda%' 
          OR autor LIKE '%$busqueda%' 
          OR isbn LIKE '%$busqueda%'";

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Libros</title>
    <style>
        body { font-family: Arial; }
        .search-container { text-align: center; margin: 20px; }
        input[type="text"] { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-search { padding: 8px 15px; background: #2196F3; color: white; border: none; cursor: pointer; }
        table { width: 90%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2196F3; color: white; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h2 style="text-align:center;">Inventario de Libros</h2>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="buscar" placeholder="Buscar por título, autor o ISBN..." value="<?php echo $busqueda; ?>">
            <button type="submit" class="btn-search">🔍 Buscar</button>
            <?php if($busqueda != ""): ?>
                <a href="index_libros.php" style="font-size: 12px; color: red;">Limpiar búsqueda</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>ISBN</th>
            <th>Estado</th>
        </tr>
        <?php 
        if(mysqli_num_rows($resultado) > 0) {
            while($row = mysqli_fetch_assoc($resultado)) { 
        ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['autor']; ?></td>
                <td><?php echo $row['isbn']; ?></td>
                <td><?php echo strtoupper($row['estado']); ?></td>
            </tr>
        <?php 
            } 
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>No se encontraron resultados</td></tr>";
        }
        ?>
    </table>
</body>
</html>