<?php
session_start();

// Conexión a la base de datos y consulta para obtener los mensajes
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

// Determinar el nombre de usuario actual de la sesión
$usuario_actual = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Consulta para obtener los mensajes
if ($_SESSION['username'] == 'Alexis_Aspel') {
    $sql = "SELECT * FROM aspel_mensaje ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM mensaje ORDER BY id DESC";
}

$result = $conn->query($sql);

// Crear HTML con los mensajes
$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<div class="mensaje">';
        $html .= '<h4>Usuario: ' . $row['usuario_id'] . '</h4>';
        $html .= '<p>Título: ' . $row['Titulo'] . '</p>';
        // Botón "Aceptar Orden" con enlace a la página de detalles
        $html .= '<a href="php/detalles.php?usuario_id=' . $row['usuario_id'] . '&mensaje_id=' . $row['id'] . '" class="btn-aceptar-orden">Ver mensaje</a>';
        // Puedes agregar más contenido según sea necesario
        $html .= '</div>';
    }
} else {
    $html = '<p>No hay mensajes disponibles</p>';
}

// Mostrar el HTML de los mensajes
echo $html;

// Cerrar la conexión a la base de datos
$conn->close();
?>
