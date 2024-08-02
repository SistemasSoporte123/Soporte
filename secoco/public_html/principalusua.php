<?php
session_start();

// Verificar si el usuario está autenticado
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: php/login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <title>Secoco - Formulario de Soporte</title>
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .welcome-container {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .welcome-container img {
            margin-right: 10px;
            border-radius: 5px;
        }
        .welcome-container span {
            font-size: 1.2rem;
            font-weight: 500;
            color: #007bff;
        }
        .formulario {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .formulario label {
            font-weight: 500;
        }
        .formulario input, .formulario select {
            margin-bottom: 10px;
        }
        .formulario button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<main>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="welcome-container">
                <img src="img/logo.png" alt="Logo" width="170px" height="50px">
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="logout.php" class=" m-2 btn btn-danger " role="button" style="color: white;">Cerrar sesión</a></li>
            </ul>
        </header>
    </div>
</main>
<div class="container formulario">
    <h2 class="mb-4">Formulario de Soporte</h2>
    <form class="row g-3 needs-validation" method="post" action="php/guardar_mensaje.php" novalidate>
        <div class="col-md-6">
            <label for="txtTitulo" class="form-label">¿Cuál es tu problema?</label>
            <input type="text" class="form-control" id="txtTitulo" name="Titulo_php" placeholder="Título del Problema" required>
        </div>
        <div class="col-md-6">
            <label for="aspel_problema" class="form-label">¿Tu problema es de Aspel?</label>
            <select id="aspel_problema" name="aspel_problema" class="form-select" required>
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </div>
        <div class="col-12">
            <label for="txtProblema" class="form-label">Describe tu problema</label>
            <textarea class="form-control" id="txtProblema" name="problema_php" rows="6" placeholder="Descripción detallada del problema" required></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Enviar</button>
        </div>
    </form>
</div>
</body>
</html>