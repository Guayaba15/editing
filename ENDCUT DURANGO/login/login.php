<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <link rel="icon" href="../img/logo_chico.png">
    <style type="text/css">
        body {
            margin-top: 20px;
            background: #f6f9fc;
        }

        .container {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .account-block {
            padding: 0;
            background-image: url(https://bootdey.com/img/Content/bg1.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            position: relative;
        }

        .account-block .overlay {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .account-block .account-testimonial {
            text-align: center;
            color: #fff;
            position: absolute;
            margin: 0 auto;
            padding: 0 1.75rem;
            bottom: 3rem;
            left: 0;
            right: 0;
        }

        .text-theme {
            color: #77b55a !important;
        }

        .btn-theme {
            background-color: #7A1A75;
            color: #fff;
        }
        .btn-theme:hover{
            background-color: #B452B2;
            padding: 0.45rem 0.8rem;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="main-wrapper" class="container" style="margin-top: 5%;">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="mb-5">
                                        <h3 class="h4 font-weight-bold text-theme">Login</h3>
                                    </div>
                                    <h6 class="h5 mb-0">¡Bienvenido de nuevo!</h6>
                                    <p class="text-muted mt-2 mb-5">Ingresa tu dirección de correo electrónico y contraseña para acceder al panel de administración.</p>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="user">Usuario</label>
                                            <input type="text" class="form-control" name="email" placeholder="Usuario" required>
                                        </div>
                                        <div class="form-group mb-5">
                                            <label for="password">Contraseña</label>
                                            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-theme">Iniciar sesión</button>
                                    </form>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-inline-block">
                                <div class="account-block rounded-right">
                                <img src="../img/logo_chico.png" alt="Logo ENDCUT 2024" class="account-image" width="460" style="margin-top: 20px;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>

<?php
require_once('../db/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();


       
        $_SESSION['username'] = $user['usuario'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['uni'] = $user['universidad'];
        $_SESSION['disc'] = $user['disciplina'];

        // Redirect with SweetAlert success message
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Login successful. Redirecting...",
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "../index.php";
                });
              </script>';
    } else {
        // Show SweetAlert error message
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Usuario o contraseña incorrectos.",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK"
                });
              </script>';
    }
}
?>
