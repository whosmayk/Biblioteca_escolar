<?php 
include 'config.php'; 

// Consultas rápidas para las estadísticas del dashboard
$total_alumnos = $pdo->query("SELECT COUNT(*) FROM alumno")->fetchColumn();
$total_libros = $pdo->query("SELECT COUNT(*) FROM libro")->fetchColumn();
$prestamos_activos = $pdo->query("SELECT COUNT(*) FROM prestamo WHERE fecha_devolucion_real IS NULL")->fetchColumn();
$total_bibliotecarios = $pdo->query("SELECT COUNT(*) FROM bibliotecario")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Biblioteca - Panel Principal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        .card-menu {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
        }
        .card-menu:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .icon-box {
            font-size: 2rem;
            margin-bottom: 15px;
        }
        .header-custom {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            border-radius: 0 0 30px 30px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="header-custom text-center shadow">
        <h1>📚 Sistema de Gestión Bibliotecaria</h1>
        <p class="lead">Bienvenido al panel de administración</p>
    </header>

    <div class="container">
        <!-- Fila de Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center p-3 shadow-sm card-menu">
                    <h5>Libros Totales</h5>
                    <h2 class="display-6"><?php echo $total_libros; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center p-3 shadow-sm card-menu">
                    <h5>Alumnos</h5>
                    <h2 class="display-6"><?php echo $total_alumnos; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark text-center p-3 shadow-sm card-menu">
                    <h5>Préstamos Activos</h5>
                    <h2 class="display-6"><?php echo $prestamos_activos; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center p-3 shadow-sm card-menu">
                    <h5>Personal</h5>
                    <h2 class="display-6"><?php echo $total_bibliotecarios; ?></h2>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <!-- Menú de Navegación CRUD -->
        <h3 class="mb-4 text-secondary">Módulos del Sistema</h3>
        <div class="row text-center g-4">
            
            <!-- Módulo Alumnos -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm card-menu">
                    <div class="card-body">
                        <div class="icon-box">👥</div>
                        <h5 class="card-title">Alumnos</h5>
                        <p class="card-text text-muted">Registrar, editar y ver lista de estudiantes.</p>
                        <a href="alumnos.php" class="btn btn-outline-primary w-100">Gestionar</a>
                    </div>
                </div>
            </div>

            <!-- Módulo Libros -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm card-menu">
                    <div class="card-body">
                        <div class="icon-box">📖</div>
                        <h5 class="card-title">Inventario de Libros</h5>
                        <p class="card-text text-muted">Control de existencias, autores y códigos ISBN.</p>
                        <a href="libros.php" class="btn btn-outline-success w-100">Ver Catálogo</a>
                    </div>
                </div>
            </div>

            <!-- Módulo Préstamos -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm card-menu">
                    <div class="card-body border border-warning border-2 rounded-3">
                        <div class="icon-box">🤝</div>
                        <h5 class="card-title text-dark">Préstamos</h5>
                        <p class="card-text text-muted">Salida de libros y control de devoluciones.</p>
                        <a href="prestamos.php" class="btn btn-warning w-100">Operaciones</a>
                    </div>
                </div>
            </div>

            <!-- Módulo Bibliotecarios -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm card-menu">
                    <div class="card-body">
                        <div class="icon-box">🔑</div>
                        <h5 class="card-title">Bibliotecarios</h5>
                        <p class="card-text text-muted">Administrar personal y turnos de trabajo.</p>
                        <a href="bibliotecarios.php" class="btn btn-outline-info w-100">Gestionar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="text-center mt-5 py-4 text-muted">
        <p>&copy; <?php echo date('Y'); ?> Sistema de Biblioteca Escolar - Taller de Base de Datos</p>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>