<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: php/login.html");
    exit;
}

// Configuración de la base de datos
$servername = "localhost";
$username = "id22329303_sistemas";
$password = "Sistemas@2024";
$dbname = "id22329303_secoco";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar la acción de "Terminar"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'terminar') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        // Aquí puedes agregar la lógica para marcar como terminado el registro con el ID especificado en la base de datos
        // Por ejemplo, ejecutar una consulta SQL de actualización
        if($_SESSION['username']=='Alexis_Aspel'){
            $sql_update = "UPDATE aspel_soporte SET terminado = 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
        }else{
            $sql_update = "UPDATE soporte SET terminado = 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
        }
        
        if ($stmt_update) {
            $stmt_update->bind_param("i", $id);
            if ($stmt_update->execute()) {
                // Éxito al marcar como terminado, redirigir a la página de edición
                header("Location: editar_soporte.php?id=" . $id);
                exit;
            } else {
                echo "Error al marcar como terminado: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            echo "Error al preparar la consulta de actualización: " . $conn->error;
        }
    } else {
        echo "ID no especificado para la acción de terminar.";
    }
}

// Consulta SQL para obtener los datos de la tabla soporte
if($_SESSION['username']=='Alexis_Aspel'){
    $sql_soporte = "SELECT id, nombre, h_inicio FROM aspel_soporte WHERE estado IS NULL";
$result_soporte = $conn->query($sql_soporte);
}else{
    $sql_soporte = "SELECT id, nombre, h_inicio FROM soporte WHERE estado IS NULL";
$result_soporte = $conn->query($sql_soporte);
}


// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secoco</title>
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        <div class="container mt-4">
            <h1>Registros de Soporte</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_soporte->num_rows > 0) {
                        while ($row = $result_soporte->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td> RDS".$row['id']."</td>";
                            echo "<td>".$row['nombre']."</td>";
                            echo "<td>".$row['h_inicio']."</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='id' value='".$row['id']."'>";
                            /*echo "<input type='hidden' name='action' value='terminar'>";
                            echo "<button type='submit' class='btn btn-primary'>Terminar</button>";*/
                            echo "</form>";
                            echo "<a href='php/editar_soporte.php?id=".$row['id']."' class='btn btn-success ms-2'>Terminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No se encontraron registros.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

