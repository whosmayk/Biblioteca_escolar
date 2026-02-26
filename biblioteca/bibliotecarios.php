<?php 
include 'config.php'; 
include 'header.php'; 

// Lógica para Eliminar
if (isset($_GET['delete'])) {
    $id_del = $_GET['delete'];
    $stmtDel = $pdo->prepare("DELETE FROM bibliotecario WHERE id_bibliotecario = ?");
    $stmtDel->execute([$id_del]);
    header("Location: bibliotecarios.php");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Personal Bibliotecario</h2>
    <a href="bibliotecarios_form.php" class="btn btn-success"> + Nuevo Bibliotecario</a>
</div>

<table class="table table-hover shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Turno</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM bibliotecario");
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>{$row['id_bibliotecario']}</td>
                <td>{$row['nombre']}</td>
                <td><span class='badge bg-secondary'>{$row['turno']}</span></td>
                <td>
                    <!-- BOTÓN EDITAR: Pasa el ID por la URL -->
                    <a href='bibliotecarios_form.php?id={$row['id_bibliotecario']}' class='btn btn-warning btn-sm'>Editar</a>
                    
                    <a href='bibliotecarios.php?delete={$row['id_bibliotecario']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Eliminar a este bibliotecario?\")'>Eliminar</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>