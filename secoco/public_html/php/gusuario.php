<?php
$clave = 0;  
$nombre = $_POST['nombre_php']; 
$pa = $_POST['pa_php']; 
$sa = $_POST['sa_php']; 
$us = $_POST['us_php'];
$cont = $_POST['cont_php'];
$area = $_POST['area_php'];
$tusu = $_POST['tusu_php'];

$servername = "localhost";
$username = "id22329303_sistemas";
$password = "Sistemas@2024";
$dbname = "id22329303_secoco";

$response = array();

$cn = new mysqli($servername, $username, $password, $dbname);
if (!$cn->connect_errno) {
    $stmt = $cn->prepare("INSERT INTO usuario VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $clave, $nombre, $pa, $sa, $us, $cont, $area, $tusu);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Registro guardado con éxito';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No se guardó el registro: ' . $cn->error;
    }
    $stmt->close();
    $cn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Fallo la conexión: ' . $cn->connect_errno;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
