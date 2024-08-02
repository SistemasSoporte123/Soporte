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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>secoco - Reporte de Soporte</title>
  <link rel="icon" href="../img/icono.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    h2 { color: #333; margin-bottom: 20px; }
    form { margin-top: 20px; }
    label { font-weight: bold; }
    input[type="datetime-local"], input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    input[type="submit"]:hover { background-color: #0056b3; }
    .btn-back { margin-top: 20px; }
    /* Estilos para el mensaje de bienvenida */
        .welcome-container {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-container img {
            margin-right: 10px;
            border-radius: 5px;
        }

        .welcome-container span {
            font-size: 1.5rem;
            font-weight: 500;
            color: #007bff;
        }
  </style>
</head>
<body>
  <main class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="welcome-container">
                <img src="../img/logo.png" alt="Logo" width="170px" height="50px">
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            </a>
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="../principal.php" class="nav-link active m-2" aria-current="page">Soporte</a></li>
        <li class="nav-item"><a href="../mostrarUsuarios.php" class="nav-link active m-2">Usuarios</a></li>
        <li class="nav-item"><a href="../reporte.php" class="nav-link active m-2">Soprte Activo</a></li>
        <li class="nav-item"><a href="registros_con_estado.php" class="nav-link active m-2">Reportes</a></li>
        <li class="nav-item"><a href="../logout.php" class="m-2 btn btn-danger" role="button" style="color: white;">Cerrar sesión</a></li>
      </ul>
    </header>
    <div>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $hora_inicio = date("Y-m-d H:i:s");
          echo '<h2>Detalles del Reporte de Soporte</h2>';
          echo '<p><strong>No. De Reporte:</strong> RDS' . htmlspecialchars($_POST['id']) . '</p>';
          echo '<p><strong>Nombre:</strong> ' . htmlspecialchars($_POST['nombre']) . ' ' . htmlspecialchars($_POST['apellido_paterno']) . ' ' . htmlspecialchars($_POST['apellido_materno']) . '</p>';
          echo '<p><strong>Usuario:</strong> ' . htmlspecialchars($_POST['usuario']) . '</p>';
          echo '<p><strong>Área:</strong> ' . htmlspecialchars($_POST['area']) . '</p>';
          echo '<p><strong>Título:</strong> ' . htmlspecialchars($_POST['titulo']) . '</p>';
          echo '<p><strong>Contenido:</strong> ' . htmlspecialchars($_POST['contenido']) . '</p>';
          echo '<form action="guardar_reporte.php" method="post">';
          echo '<input type="hidden" name="id" value="' . htmlspecialchars($_POST['id']) . '">';
          echo '<input type="hidden" name="nombre" value="' . htmlspecialchars($_POST['nombre']) . '">';
          echo '<input type="hidden" name="apellido_paterno" value="' . htmlspecialchars($_POST['apellido_paterno']) . '">';
          echo '<input type="hidden" name="apellido_materno" value="' . htmlspecialchars($_POST['apellido_materno']) . '">';
          echo '<input type="hidden" name="usuario" value="' . htmlspecialchars($_POST['usuario']) . '">';
          echo '<input type="hidden" name="area" value="' . htmlspecialchars($_POST['area']) . '">';
          echo '<input type="hidden" name="titulo" value="' . htmlspecialchars($_POST['titulo']) . '">';
          echo '<input type="hidden" name="contenido" value="' . htmlspecialchars($_POST['contenido']) . '">';
          echo '<div class="mb-3">';
          echo '<label for="hora_inicio" class="form-label">Hora de inicio:</label>';
          echo '<input type="datetime-local" id="hora_inicio" name="hora_inicio" class="form-control" required>';
          echo '</div>';
          /*echo '<div class="mb-3">';
          echo '<label for="hora_termino" class="form-label">Hora de Término:</label>';
          echo '<input type="datetime-local" id="hora_termino" name="hora_termino" class="form-control" >';
          echo '</div>';
          echo '<div class="mb-3">';
          echo '<label for="estado" class="form-label">Estado del Reporte:</label>';
          echo '<input type="text" id="estado" name="estado" class="form-control">';
          echo '</div>';*/
          echo '<input type="submit" class="btn btn-primary" value="Guardar Reporte">';
          echo '</form>';
      } else {
          echo "<p>No se han recibido datos del formulario.</p>";
      }
      ?>
    </div>
    <a href="../principal.php" class="btn btn-back btn-secondary">Volver a la página principal</a>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
