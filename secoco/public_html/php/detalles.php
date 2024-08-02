<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
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
    <link rel="icon" href="../img/icono.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h2, h3 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            // Conexión a la base de datos
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

            // Obtener el usuario_id y el mensaje_id de la URL
            if (isset($_GET['usuario_id']) && isset($_GET['mensaje_id'])) {
                $usuario_id = $_GET['usuario_id'];
                $mensaje_id = $_GET['mensaje_id'];
            } else {
                echo "Datos de usuario o mensaje no especificados";
                exit();
            }

            // Definir las tablas y consultas según el usuario
            $tabla_mensaje = $_SESSION['username'] == 'Alexis_Aspel' ? 'aspel_mensaje' : 'mensaje';
            $sql_usuario = "SELECT * FROM usuario WHERE Usuario = ?";
            $sql_mensaje = "SELECT * FROM $tabla_mensaje WHERE id = ?";

            // Preparar y ejecutar la consulta para el usuario
            if ($stmt_usuario = $conn->prepare($sql_usuario)) {
                $stmt_usuario->bind_param("s", $usuario_id);
                $stmt_usuario->execute();
                $result_usuario = $stmt_usuario->get_result();
                $stmt_usuario->close();
            }

            // Preparar y ejecutar la consulta para el mensaje
            if ($stmt_mensaje = $conn->prepare($sql_mensaje)) {
                $stmt_mensaje->bind_param("i", $mensaje_id);
                $stmt_mensaje->execute();
                $result_mensaje = $stmt_mensaje->get_result();
                $stmt_mensaje->close();
            }

            // Verificar los resultados y mostrar los detalles
            if ($result_usuario->num_rows > 0 && $result_mensaje->num_rows > 0) {
                $row_usuario = $result_usuario->fetch_assoc();
                $row_mensaje = $result_mensaje->fetch_assoc();

                echo '<h2>Detalles de la Orden</h2>';
                echo '<h3>Usuario:</h3>';
                echo '<p>Nombre: ' . $row_usuario['Nombre'] . ' ' . $row_usuario['Apellido_P'] . ' ' . $row_usuario['Apellido_S'] . '</p>';
                echo '<p>Usuario: ' . $row_usuario['Usuario'] . '</p>';
                echo '<p>Area: ' . $row_usuario['Area'] . '</p>';
                echo '<h3>Orden:</h3>';
                echo '<p>ID: ' . $row_mensaje['id'] . '</p>';
                echo '<p>Título: ' . $row_mensaje['Titulo'] . '</p>';
                echo '<p>Contenido: ' . $row_mensaje['contenido'] . '</p>';
                echo '<form action="procesar_reporte.php" method="post">';
                echo '<input type="hidden" name="nombre" value="' . $row_usuario['Nombre'] . '">';
                echo '<input type="hidden" name="apellido_paterno" value="' . $row_usuario['Apellido_P'] . '">';
                echo '<input type="hidden" name="apellido_materno" value="' . $row_usuario['Apellido_S'] . '">';
                echo '<input type="hidden" name="usuario" value="' . $row_usuario['Usuario'] . '">';
                echo '<input type="hidden" name="area" value="' . $row_usuario['Area'] . '">';
                echo '<input type="hidden" name="id" value="' . $row_mensaje['id'] . '">';
                echo '<input type="hidden" name="titulo" value="' . $row_mensaje['Titulo'] . '">';
                echo '<input type="hidden" name="contenido" value="' . $row_mensaje['contenido'] . '">';
                echo '<input type="submit" class="btn" value="Iniciar Soporte">';
                echo '</form>';
            } else {
                echo "No se encontraron datos del usuario o del mensaje";
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
        ?>
    </div>
</body>
</html>

