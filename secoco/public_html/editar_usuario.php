<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: php/login.html");
    exit;
}

// Conexión a la base de datos (aquí debes colocar tus credenciales)
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

// Verificar si se recibió un ID válido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de usuario no válido.";
    exit;
}

// Obtener el ID del usuario a editar y asegurarse de que sea un entero válido
$id = intval($_GET['id']);

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT * FROM `usuario` WHERE id = $id";
$result = $conn->query($sql);

// Verificar si se encontró el registro
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "No se encontró el registro.";
    exit;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['Nombre'];
    $apellido_p = $_POST['Apellido_P'];
    $apellido_s = $_POST['Apellido_S'];
    $usuario_nombre = $_POST['Usuario'];
    $contrasena = $_POST['password'];
    $area = $_POST['Area'];
    $administrador = $_POST['Administrador'];

    // Prevenir SQL Injection usando consultas preparadas
    $sql = "UPDATE `usuario` SET 
            Nombre=?, 
            Apellido_P=?, 
            Apellido_S=?, 
            Usuario=?, 
            password=?, 
            Area=?, 
            Administrador=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nombre, $apellido_p, $apellido_s, $usuario_nombre, $contrasena, $area, $administrador, $id);

    if ($stmt->execute()) {
        // Redirigir después de actualizar correctamente
        header("Location: mostrarUsuarios.php");
        exit;
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secoco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link href="signin.css" rel="stylesheet">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
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
                <li class="nav-item"><a href="usuarios.php" class="nav-link active m-2">Usuarios</a></li>
                <li class="nav-item"><a href="reporte.php" class="nav-link active m-2">Soporte Activo</a></li>
                <li class="nav-item"><a href="php/registros_con_estado.php" class="nav-link active m-2">Reportes</a></li>
                <li class="nav-item"><a href="logout.php" class="m-2 btn btn-danger" role="button" style="color: white;">Cerrar sesión</a></li>
            </ul>
        </header>
    </div>
</main>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Editar Usuario</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="Nombre" class="form-label fw-bolder">Nombre:</label>
                            <input class="form-control" type="text" name="Nombre" value="<?php echo htmlspecialchars($usuario['Nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Apellido_P" class="form-label fw-bolder">Apellido Paterno:</label>
                            <input class="form-control" type="text" name="Apellido_P" value="<?php echo htmlspecialchars($usuario['Apellido_P']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Apellido_S" class="form-label fw-bolder">Apellido Materno:</label>
                            <input class="form-control" type="text" name="Apellido_S" value="<?php echo htmlspecialchars($usuario['Apellido_S']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Usuario" class="form-label fw-bolder">Usuario:</label>
                            <input class="form-control" type="text" name="Usuario" value="<?php echo htmlspecialchars($usuario['Usuario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bolder">Contraseña:</label>
                            <input class="form-control" type="password" name="password" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Area" class="form-label fw-bolder">Área:</label>
                            <input class="form-control" type="text" name="Area" value="<?php echo htmlspecialchars($usuario['Area']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Administrador" class="form-label fw-bolder">Administrador:</label>
                            <select class="form-select" name="Administrador" required>
                                <option value="1" <?php if ($usuario['Administrador'] == 1) echo 'selected'; ?>>Administrador</option>
                                <option value="0" <?php if ($usuario['Administrador'] != 1) echo 'selected'; ?>>Usuario</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success rounded-pill px-3" type="submit">Guardar cambios</button>
                            <a href="mostrarUsuarios.php"><button type="button" class="btn btn-danger rounded-pill px-3">Cerrar</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>



