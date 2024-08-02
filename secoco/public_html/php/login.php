<?php
session_start();

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "id22329303_sistemas";
$password = "Sistemas@2024";
$dbname = "id22329303_secoco";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario y validarlos
$username2 = isset($_POST['username']) ? $_POST['username'] : '';
$password2 = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($username2) || empty($password2)) {
    die("Nombre de usuario o contraseña no proporcionados.");
}

// Consulta SQL para verificar las credenciales
$sql = "SELECT id, Usuario, Administrador FROM usuario WHERE Usuario=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username2, $password2);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $username, $admin);
    $stmt->fetch();

    // Iniciar sesión y redirigir al usuario
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    if ($admin == 1) {
        header("Location: ../principal.php");
        exit;
    } else {
        header("Location: ../principalusua.php");
        exit;
    }
} else {
    // Mostrar mensaje de error si las credenciales son incorrectas
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Error",
                text: "Nombre de usuario o contraseña incorrectos.",
                icon: "error",
                confirmButtonText: "Aceptar"
            }).then(function() {
                window.location = "../index.html";
            });
        </script>
    </body>
    </html>';
    exit();
}

$stmt->close();
$conn->close();
?>

