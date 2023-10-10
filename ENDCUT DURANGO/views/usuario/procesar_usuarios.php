<?php
require_once('db/connection.php'); // Incluye la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos existen en el array $_POST antes de acceder a ellos
    if (isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['pass']) &&
        isset($_POST['tipo']) && isset($_POST['disciplina']) && isset($_POST['universidad'])) {

        // Obtener los datos del formulario
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $tipo = $_POST['tipo'];
        $disciplina = $_POST['disciplina'];
        $universidad = $_POST['universidad'];

        // Crear la consulta SQL para insertar los datos
        $sql = "INSERT INTO usuarios (usuario, email, pass, tipo, disciplina, universidad)
                VALUES ('$usuario', '$email', '$pass', '$tipo', '$disciplina', '$universidad')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Registro exitoso',
                   text: 'Los datos se han registrado correctamente',
                   confirmButtonText: 'Aceptar'
                 }).then(function() {
                   window.location.href = 'usuarios.php'; // Redireccionar a la página de usuarios
                 });
              </script>";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }
    } else {
        echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Campos del formulario incompletos',
                   text: 'Por favor, completa todos los campos',
                   confirmButtonText: 'Aceptar'
                 }).then(function() {
                   window.location.href = 'usuarios.php'; // Redireccionar a la página de usuarios
                 });
              </script>";
    }
}

// Cerrar la conexión
$conn->close();
?>
