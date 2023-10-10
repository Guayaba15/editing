<!DOCTYPE html>
<html>
<head>
    <title>Registro de Asistentes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
</head>
<body>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST["numero"];
    $universidad = $_POST["universidad"];
    $nombre = $_POST["nombre"];
    $ape_pat = $_POST["ape_pat"];
    $ape_mat = $_POST["ape_mat"];
    $disciplina = $_POST["disciplina"];
    
    // Manejo de la imagen
    if (isset($_FILES["imagen"])) {
        $imagenTempPath = $_FILES["imagen"]["tmp_name"];
        $imagenContenido = file_get_contents($imagenTempPath);
    } else {
        // Si no se proporciona una imagen, puedes establecer un valor predeterminado o manejarlo según tus necesidades.
        $imagenContenido = null;
    }

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "endcut");

    // Preparar y ejecutar la consulta
    $query = "INSERT INTO asistentes (numero, universidad, nombre, ape_pat, ape_mat, disciplina, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("issssss", $numero, $universidad, $nombre, $ape_pat, $ape_mat, $disciplina, $imagenContenido);
        if ($stmt->execute()) {
            // Mostrar mensaje SweetAlert de éxito
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: 'El registro se ha guardado correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'asistentes.php'; // Redireccionar a la página principal
                });
            </script>";
        } else {
            // Mostrar mensaje SweetAlert de error
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al registrar. Inténtalo nuevamente.',
                });
            </script>";
        }
        $stmt->close();
    } else {
        // Mostrar mensaje SweetAlert de error
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Hubo un problema con la consulta. Inténtalo nuevamente.',
            });
        </script>";
    }

    $conexion->close();
}
?>
