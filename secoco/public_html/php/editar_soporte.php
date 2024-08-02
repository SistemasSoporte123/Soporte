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

// Mensaje inicial para la respuesta
$response = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha proporcionado un ID válido para la edición
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Consulta SQL para obtener los datos del soporte seleccionado
    if($_SESSION['username']=='Alexis_Aspel'){
        $sql_select = "SELECT id, nombre, h_inicio, h_fin, contenido, estado, solucion FROM aspel_soporte WHERE id = ?";
        $stmt_select = $conn->prepare($sql_select);
    }else{
        $sql_select = "SELECT id, nombre, h_inicio, h_fin, contenido, estado, solucion FROM soporte WHERE id = ?";
        $stmt_select = $conn->prepare($sql_select);
    }
    
    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombre = $row['nombre'];
            $h_inicio = $row['h_inicio'];
            $h_fin = $row['h_fin'];
            $contenido = $row['contenido'];
            $estado = $row['estado'];
            $solucion = $row['solucion'];
        } else {
            $response = "No se encontró el registro solicitado.";
        }
        $stmt_select->close();
    } else {
        $response = "Error al preparar la consulta de selección: " . $conn->error;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos enviados por el formulario de edición
    if (isset($_POST['id'], $_POST['estado'], $_POST['solucion'])) {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $solucion = $_POST['solucion'];
        $h_fin = $_POST['h_fin'];
        
        // Consulta SQL para actualizar los datos del soporte
        if($_SESSION['username']=='Alexis_Aspel'){
            $sql_update = "UPDATE aspel_soporte SET h_fin = ?, estado = ?, solucion = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
        }else{
            $sql_update = "UPDATE soporte SET h_fin = ?, estado = ?, solucion = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
        }
        
        if ($stmt_update) {
            $stmt_update->bind_param("sssi", $h_fin, $estado, $solucion, $id);
            if ($stmt_update->execute()) {
                $response = "Registro actualizado correctamente.";
                // JavaScript para redirigir después de mostrar el mensaje
                echo '<script>
                        alert("Registro actualizado correctamente.");
                        window.location.href = "../reporte.php";
                      </script>';
                exit;
            } else {
                $response = "Error al actualizar el registro: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            $response = "Error al preparar la consulta de actualización: " . $conn->error;
        }
    } else {
        $response = "Faltan datos del formulario.";
    }
}

// Cerrar conexión
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Soporte - secoco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/icono.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .form-control-plaintext {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
            margin-bottom: 0;
            line-height: 1.5;
            color: #495057;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1 class="mb-4">Editar Registro de Soporte</h1>
        
        <?php if (!empty($response)) : ?>
            <div class="alert alert-info" role="alert">
                <?php echo $response; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($id)) : ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control-plaintext" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea class="form-control-plaintext" id="contenido" name="contenido" rows="5" readonly><?php echo htmlspecialchars($contenido); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="h_inicio" class="form-label">Hora de Inicio</label>
                    <input type="text" class="form-control-plaintext" id="h_inicio" name="h_inicio" value="<?php echo htmlspecialchars($h_inicio); ?>" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="h_fin" class="form-label">Hora de Fin</label>
                    <input type="datetime-local" class="form-control" id="h_fin" name="h_fin" value="<?php echo isset($h_fin) ? date('Y-m-d\TH:i', strtotime($h_fin)) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="Pendiente" <?php if ($estado == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                        <option value="En proceso" <?php if ($estado == 'En proceso') echo 'selected'; ?>>En proceso</option>
                        <option value="Terminado" <?php if ($estado == 'Terminado') echo 'selected'; ?>>Terminado</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="solucion" class="form-label">Solución</label>
                    <textarea class="form-control" id="solucion" name="solucion" rows="3"><?php echo htmlspecialchars($solucion); ?></textarea>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="../reporte.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        <?php else : ?>
            <div class="alert alert-danger mt-4" role="alert">
                No se encontró el registro solicitado para editar.
            </div>
            <a href="soporte.php" class="btn btn-secondary mt-3">Volver a Soporte</a>
        <?php endif; ?>
    </main>
</body>
</html>


