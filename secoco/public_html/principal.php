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
    <title>secoco</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
    <script>
      // Función para cargar los mensajes desde el servidor
      function cargarMensajes() {
        // Realizar una solicitud AJAX al servidor
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Actualizar el contenido del contenedor de mensajes con la respuesta del servidor
                document.getElementById("mensajes-container").innerHTML = this.responseText;
            }
        };
        // Especificar la URL del script PHP que devuelve los mensajes
        xmlhttp.open("GET", "php/obtener_mensajes.php", true);
        xmlhttp.send();
      }

      // Llamar a la función cargarMensajes al cargar la página para mostrar los mensajes
      window.onload = function() {
        cargarMensajes();
      };
    </script>

    <!-- Bootstrap core CSS -->
    <link href="/docs/5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.3.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.3.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.3.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.3.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.3.3/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.3.3/assets/img/favicons/favicon.ico">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <meta name="theme-color" content="#7952b3">
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      /* Estilos para el mensaje */
      .mensaje {
          background-color: #f9f9f9;
          border: 1px solid #ccc;
          border-radius: 5px;
          padding: 10px;
          margin-bottom: 10px;
      }

      .mensaje h4 {
          margin-top: 0;
      }

      .mensaje p {
          margin-bottom: 0;
      }

      /* Estilos para el botón "Aceptar Orden" */
      .btn-aceptar-orden {
          background-color: #4caf50;
          color: white;
          border: none;
          padding: 5px 10px;
          border-radius: 3px;
          cursor: pointer;
      }

      .btn-aceptar-orden:hover {
          background-color: #45a049;
      }
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
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
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
            <li class="nav-item"><a href="principal.php" class="nav-link active m-2" aria-current="page">Soporte</a></li>
            <li class="nav-item"><a href="mostrarUsuarios.php" class="nav-link active m-2">Usuarios</a></li>
            <li class="nav-item"><a href="reporte.php" class="nav-link active m-2">Soprte Activo</a></li>
            <li class="nav-item"><a href="php/registros_con_estado.php" class="nav-link active m-2">Reportes</a></li>
            <li class="nav-item"><a href="Graficas.php" class="nav-link active m-2">Graficas</a></li>
            <li class="nav-item"><a href="logout.php" class=" m-2 btn btn-danger " role="button" style="color: white;">Cerrar sesión</a></li>
          </ul>
        </header>
      </div>
    </main>
    <div id="mensajes-container"></div>
  </body>
</html>