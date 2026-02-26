<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Biblioteca</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .main-container { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<!-- Menú de navegación incluido dentro del header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">📚 Biblioteca Escolar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="alumnos.php">Alumnos</a></li>
        <li class="nav-item"><a class="nav-link" href="libros.php">Libros</a></li>
        <li class="nav-item"><a class="nav-link" href="bibliotecarios.php">Bibliotecarios</a></li>
        <li class="nav-item"><a class="nav-link" href="prestamos.php">Préstamos</a></li>
        
      </ul>
    </div>
  </div>
</nav>

<!-- Abrimos el contenedor principal que se cerrará en el footer -->
<div class="container main-container">