<?php
session_start();

// Verificar si el usuario está autenticado
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <li class="nav-item"><a href="mostrarUsuarios.php" class="nav-link active m-2">Usuarios</a></li>
                <li class="nav-item"><a href="reporte.php" class="nav-link active m-2">Soporte Activo</a></li>
                <li class="nav-item"><a href="php/registros_con_estado.php" class="nav-link active m-2">Reportes</a></li>
                <li class="nav-item"><a href="logout.php" class=" m-2 btn btn-danger " role="button" style="color: white;">Cerrar sesión</a></li>
            </ul>
        </header>
    </div>
</main>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Agregar Usuario</h4>
                </div>
                <div class="card-body">
                    <form name="autos" method="post">   
                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre</label>
                            <input type="text" id="txtNombre" placeholder="Nombre" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txtPriApe" class="form-label">Primer Apellido</label>
                            <input type="text" id="txtPriApe" placeholder="Primer Apellido" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txtSegApe" class="form-label">Segundo Apellido</label>
                            <input type="text" id="txtSegApe" placeholder="Segundo Apellido" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txtUsuario" class="form-label">Usuario</label>
                            <input type="text" id="txtUsuario" placeholder="Usuario" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txtContrasena" class="form-label">Contraseña</label>
                            <input type="text" id="txtContrasena" placeholder="Contraseña" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="combo1" class="form-label">Seleccione el área</label>
                            <select name="TArea" id="combo1" class="form-select">
                                <option default value="0">Área</option>
                                <option value="Tesoreía">Tesorería</option>
                                <option value="Contabilidad Interna">Contabilidad Interna</option>
                                <option value="Contabilidad Externa Proyectos">Contabilidad Externa y Proyectos</option>
                                <option value="Recepcíon">Recepción</option>
                                <option value="Inmuebles y la Feria">Inmuebles y la Feria</option>
                                <option value="Cuentas por cobrar y pagar">Cuentas por cobrar y pagar</option>
                                <option value="Auditoría">Auditoría</option>
                                <option value="Mensajería">Mensajería</option>
                                <option value="Recursos Humanos">Recursos Humanos</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Nóminas">Nóminas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="combo" class="form-label">Selecciona el tipo de usuario</label>
                            <select name="TUsuario" id="combo" class="form-select">
                                <option default value="0">Tipo de usuario</option>
                                <option value="2">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success rounded-pill px-3" id="boton">Guardar</button>
                            <a href="mostrarUsuarios.php" class="btn btn-danger rounded-pill px-3">Cerrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById("boton").addEventListener("click", leerValores);

    function leerValores() {
        var nombre = document.getElementById("txtNombre").value;
        var pa = document.getElementById("txtPriApe").value;
        var sa = document.getElementById("txtSegApe").value;
        var us = document.getElementById("txtUsuario").value;
        var cont = document.getElementById("txtContrasena").value;
        var area = document.getElementById("combo1").value;
        var tusu = document.getElementById("combo").value;

        if (nombre === "" || pa === "" || sa === "" || us === "" || cont === "") {
            Swal.fire({
                title: 'ERROR',
                text: 'Favor de llenar todos los campos',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            conexionServidor(nombre, pa, sa, us, cont, area, tusu);
        }
    }

    function conexionServidor(nombre, pa, sa, us, cont, area, tusu) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                var response = JSON.parse(xhr.responseText);
                Swal.fire({
                    title: response.status === 'success' ? 'Listo' : 'ERROR',
                    text: response.message,
                    icon: response.status === 'success' ? 'success' : 'error',
                    confirmButtonText: 'Aceptar'
                }).then(function() {
                    window.location = "mostrarUsuarios.php";
                });
            }
        };
        xhr.open("POST", "php/gusuario.php", true);   
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("nombre_php=" + encodeURIComponent(nombre) + "&pa_php=" + encodeURIComponent(pa) + "&sa_php=" + encodeURIComponent(sa) + "&us_php=" + encodeURIComponent(us) + "&cont_php=" + encodeURIComponent(cont) + "&area_php=" + encodeURIComponent(area) + "&tusu_php=" + encodeURIComponent(tusu));
    }
</script>
</body>
</html>
