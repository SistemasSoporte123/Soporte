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

// Respuesta por defecto
$response = array();

// Verificar si se han enviado datos desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que todos los campos requeridos están presentes
    if (!isset($_POST['id'], $_POST['nombre'], $_POST['apellido_paterno'], $_POST['apellido_materno'],$_POST['usuario'], $_POST['area'], $_POST['titulo'], $_POST['contenido'], $_POST['hora_inicio'])) {
        echo "Faltan datos del formulario.";
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $usuario = $_POST['usuario'];
        $area = $_POST['area'];
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_termino = !empty($_POST['hora_termino']) ? $_POST['hora_termino'] : null;
        $estado = !empty($_POST['estado']) ? $_POST['estado'] : null;
        
        $nombre_completo = $nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno;

        // Preparar la declaración SQL para insertar en la tabla soporte
        if($_SESSION['username']=='Alexis_Aspel'){
            $sql_insert = "INSERT INTO aspel_soporte (id, nombre, usuario, area, titulo, contenido, h_inicio, h_fin, estado) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }else{
            $sql_insert = "INSERT INTO soporte (id, nombre, usuario, area, titulo, contenido, h_inicio, h_fin, estado) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }
        

        // Preparar la declaración
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert) {
            // Vincular los parámetros, utilizando 's' para los parámetros de cadena y 'i' para los enteros
            $stmt_insert->bind_param("issssssis", $id, $nombre_completo, $usuario, $area, $titulo, $contenido, $hora_inicio, $hora_termino, $estado);

            // Ejecutar la declaración de inserción
            if ($stmt_insert->execute()) {
                // Ahora procedemos a eliminar el mensaje de la tabla mensaje
                if($_SESSION['username']=='Alexis_Aspel'){
                    $sql_delete = "DELETE FROM aspel_mensaje WHERE id = ?";
                    $stmt_delete = $conn->prepare($sql_delete);
                }else{
                    $sql_delete = "DELETE FROM mensaje WHERE id = ?";
                    $stmt_delete = $conn->prepare($sql_delete);
                }
                
                if ($stmt_delete) {
                    // Vincular el parámetro
                    $stmt_delete->bind_param("i", $id);

                    // Ejecutar la eliminación del mensaje
                    if ($stmt_delete->execute()) {
                        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css"/>
    <link rel="icon" href="../img/icono.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
</head>
<body>
    <!-- Aquí puedes poner el contenido HTML si es necesario -->
    <?php
                        echo "<script>
                $(document).ready(function() {
                    swal('¡Listo!', 'Reporte guardado exitosamente.', 'success').then(function() {
                        window.location.href = '../principal.php';
                    });
                });
              </script>";
                    } else {
                        echo "Error al eliminar el mensaje: " . $stmt_delete->error;
                    }

                    // Cerrar la declaración de eliminación
                    $stmt_delete->close();
                } else {
                    echo "Error al preparar la declaración para eliminar el mensaje: " . $conn->error;
                }
            } else {
                echo "Error al guardar el reporte: " . $stmt_insert->error;
            }
            // Cerrar la declaración de inserción
            $stmt_insert->close();
        } else {
            echo "Error al preparar la declaración para guardar el reporte: " . $conn->error;
        }
    }
} else {
    echo "No se han recibido datos del formulario.";
}

// Cerrar la conexión
$conn->close();
?>


