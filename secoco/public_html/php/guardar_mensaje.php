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

// Obtener datos del formulario
$titulo = $_POST['Titulo_php'] ?? ''; // Manejar el caso si $_POST['Titulo_php'] no está definido
$problema = $_POST['problema_php'] ?? ''; // Manejar el caso si $_POST['problema_php'] no está definido
$aspel = $_POST['aspel_problema'] ?? 'no'; // Valor por defecto si no se envía 'aspel_problema'
$usuario_id = $_SESSION['username'];

// Insertar datos en la base de datos dependiendo de la opción de Aspel
if ($aspel === 'si') {
    $sql = "INSERT INTO aspel_mensaje (usuario_id, titulo, contenido) VALUES ('$usuario_id', '$titulo', '$problema')";
} else {
    $sql = "INSERT INTO mensaje (usuario_id, titulo, contenido) VALUES ('$usuario_id', '$titulo', '$problema')";
}

// Ejecutar consulta y verificar
if ($conn->query($sql) === TRUE) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "¡Éxito!",
            text: "Mensaje guardado correctamente.",
            icon: "success"
        }).then(function() {
            window.location.href = "../principalusua.php";
        });
    });
    </script>';
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Error",
            text: "Error al guardar el mensaje: ' . $conn->error . '",
            icon: "error"
        }).then(function() {
            window.history.back();
        });
    });
    </script>';
}

$conn->close();
?>

