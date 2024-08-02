<?php
// Conexión a la base de datos (misma conexión que usas en tu archivo principal)
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
// Verificar si se ha enviado un ID para eliminar
if(isset($_POST['eliminar'])) {
    $id_usuario = $_POST['id'];

    // Consulta SQL para eliminar el usuario con el ID proporcionado
    $sql_eliminar = "DELETE FROM usuario WHERE id = $id_usuario";

    // Ejecutar la consulta
    if ($conn->query($sql_eliminar) === TRUE) {
        echo '<script>alert("El usuario se elimino correctamente.");</script>';
        echo '<script>window.location.href="../mostrarUsuarios.php";</script>';
    } else {
        echo "Error al eliminar usuario: " . $conn->error;
    }
}

// Cerrar conexión si es necesario
?>
