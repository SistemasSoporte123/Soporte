<?php
// Conexión a la base de datos (aquí debes colocar tus credenciales)
$servername = "localhost";
$username = "id22329303_sistemas";
$password = "Sistemas@2024";
$dbname = "id22329303_secoco";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para recuperar datos
$sql = "SELECT id, Nombre, Apellido_P, Apellido_S, Usuario, password, Area, Administrador FROM `usuario`";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar los datos
    $datos = array();
    while($row = $result->fetch_assoc()) {
        // Agregar cada fila a array de datos
        $datos[] = $row;
    }
} else {
    echo "No se encontraron resultados.";
}
// Cerrar conexión
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
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
        
        .btn-group {
            gap: 5px; /* Espacio entre los botones dentro del grupo */
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
    

    <div class="container text-center"> 
        <h1>Registros de Usuarios</h1><!-- Contenedor para centrar el botón de agregar usuario -->
        <a href="usuarios.php" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i> <!-- Icono de plus -->
            Agregar Usuario
        </a>
    </div>
    <br>
    <table class="table table-striped-columns">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Usuario</th>
          <th>Contraseña</th>
          <th>Área</th>            
          <th>Administrador</th>
          <th>Edicion</th>
        </tr>
        <?php
          // Iterar sobre los datos y mostrarlos en la tabla
          if (isset($datos) && !empty($datos)) {
              foreach ($datos as $fila) {
                  echo "<tr>";
                  echo "<td>US".$fila['id']."</td>";
                  echo "<td>".$fila['Nombre']."</td>";
                  echo "<td>".$fila['Apellido_P']."</td>";
                  echo "<td>".$fila['Apellido_S']."</td>";
                  echo "<td>".$fila['Usuario']."</td>";
                  echo "<td>".$fila['password']."</td>";
                  echo "<td>".$fila['Area']."</td>";
                  echo "<td>".($fila['Administrador'] == 1 ? 'Administrador' : 'Usuario')."</td>";
                  echo "<td>";
                  echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                  echo "<form method='post' action='php/eliminar_usuario.php'>";
                  echo "<input type='hidden' name='id' value='".$fila['id']."'>";
                  //echo "<td>";
                 echo "<button type='submit' name='eliminar' class='btn btn-danger'>";
                echo "<i class='fas fa-trash-alt'></i>"; // Icono de bote de basura
                echo "</button>";

                  //echo "</td>";
                  echo "</form>";
                  // Agregar enlace con los datos del registro para editar
                echo "<a href='editar_usuario.php?id=".$fila['id']."' class='btn btn-success'>";
                echo "<i class='fas fa-pencil-alt'></i>"; // Icono de lápiz
                echo "</a>";
                  echo "</div>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7'>No se encontraron registros.</td></tr>";
          }
        ?>
    </table>
    
</body>
</html>

