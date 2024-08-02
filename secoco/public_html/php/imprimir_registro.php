<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: php/login.html");
    exit;
}

// Verificar si se recibió un ID válido a través de GET
if (!isset($_GET['id'])) {
    header("Location: registros_con_estado.php");
    exit;
}

$id = $_GET['id'];

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

// Consulta SQL para obtener los datos del registro específico
if($_SESSION['username']=='Alexis_Aspel'){
    $sql_registro = "SELECT * FROM aspel_soporte WHERE id = ?";
    $stmt = $conn->prepare($sql_registro);
}else{
    $sql_registro = "SELECT * FROM soporte WHERE id = ?";
    $stmt = $conn->prepare($sql_registro);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombreUsuario = $_SESSION['username'];
    $nombreSistemas = "Nombre del personal de sistemas"; // Puedes ajustar esto según el nombre real
    $firmaUsuario = "Firma del usuario";
    $firmaSistemas = "Firma del personal de sistemas";
    $nombreSoporte = htmlspecialchars($row['nombre']);
    $reporte = htmlspecialchars($row['id']);
    $area = htmlspecialchars($row['area']);
    $h_inicio = htmlspecialchars($row['h_inicio']);
    $h_fin = htmlspecialchars($row['h_fin']);
    $estado = htmlspecialchars($row['estado']);
    $titulo = htmlspecialchars($row['titulo']);
    $descripcion = htmlspecialchars($row['contenido']);
} else {
    // Si no se encuentra el registro, redirigir a la página principal
    header("Location: registros_con_estado.php");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de Registro de Soporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn-group {
            margin-top: 20px;
        }
        /* Estilos para ocultar los botones al imprimir */
        @media print {
            .btn-group {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="reporte" class="form-label">No. De Reporte:</label>
                    <input type="text" class="form-control" id="reporte" value="RDS<?php echo htmlspecialchars($reporte); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nombreUsuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="nombreUsuario" value="<?php echo htmlspecialchars($nombreSoporte); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="firmaUsuario" class="form-label">Area:</label>
                    <input type="text" class="form-control" id="area" value="<?php echo htmlspecialchars($area); ?>"readonly>
                </div>
                <div class="mb-3">
                    <label for="h_inicio" class="form-label">Fecha y Hora de Inicio:</label>
                    <input type="text" class="form-control" id="h_inicio" value="<?php echo $h_inicio; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="h_inicio" class="form-label">Fecha y Hora de Termino:</label>
                    <input type="text" class="form-control" id="h_fin" value="<?php echo $h_fin; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado:</label>
                    <input type="text" class="form-control" id="estado" value="<?php echo $estado; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Falla:</label>
                    <input type="text" class="form-control" id="titulo" value="<?php echo $titulo; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <input type="text" class="form-control" id="descripcion" value="<?php echo $descripcion; ?>" readonly>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col text-center btn-group">
                <a href="#" class="btn btn-primary" onclick="window.print();">Imprimir</a>
                <a href="registros_con_estado.php" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>
