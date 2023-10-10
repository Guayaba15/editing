<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
</body>
</html>
<?php
// Establecer la conexión con la base de datos (reemplaza los valores con los tuyos)
require_once("../../db/connection.php");

// Manejar el formulario de subida de archivos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disciplina = $_POST['disciplina'];

    // Subir archivos y obtener rutas temporales
    $kardex_temp_path = $_FILES['kardex']['tmp_name'];
    $curp_temp_path = $_FILES['curp']['tmp_name'];
    $cedula_temp_path = $_FILES['cedula']['tmp_name'];
    $nss_temp_path = $_FILES['nss']['tmp_name'];
    $anexos_temp_path = $_FILES['anexos']['tmp_name'];
    $registro_temp_path = $_FILES['registro']['tmp_name'];
    $certificado_temp_path = $_FILES['certificado']['tmp_name'];
    $monografia_temp_path = $_FILES['monografia']['tmp_name'];
    $cancion_temp_path = $_FILES['cancion']['tmp_name'];

    // Leer el contenido de los archivos solo si se cargaron correctamente
    if ($_FILES['kardex']['error'] === UPLOAD_ERR_OK) {
        $kardex = file_get_contents($kardex_temp_path);
    }
    if ($_FILES['curp']['error'] === UPLOAD_ERR_OK) {
        $curp = file_get_contents($curp_temp_path);
    }
    if ($_FILES['cedula']['error'] === UPLOAD_ERR_OK) {
        $cedula = file_get_contents($cedula_temp_path);
    }
    if ($_FILES['nss']['error'] === UPLOAD_ERR_OK) {
        $nss = file_get_contents($nss_temp_path);
    }
    if ($_FILES['anexos']['error'] === UPLOAD_ERR_OK) {
        $anexos = file_get_contents($anexos_temp_path);
    }
    if ($_FILES['registro']['error'] === UPLOAD_ERR_OK) {
        $registro = file_get_contents($registro_temp_path);
    }
    if ($_FILES['certificado']['error'] === UPLOAD_ERR_OK) {
        $certificado = file_get_contents($certificado_temp_path);
    }
    if ($_FILES['monografia']['error'] === UPLOAD_ERR_OK) {
        $monografia = file_get_contents($monografia_temp_path);
    }
    if ($_FILES['cancion']['error'] === UPLOAD_ERR_OK) {
        $cancion = file_get_contents($cancion_temp_path);
    }

    // Preparar consulta SQL para la inserción de datos
    $stmt = $conn->prepare("INSERT INTO documentos (disciplina, kardex, curp, cedula, nss, anexos, registro, certificado, monografia, cancion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Asociar los parámetros con las variables
    $stmt->bind_param("ssssssssss", $disciplina, $kardex, $curp, $cedula, $nss, $anexos, $registro, $certificado, $monografia, $cancion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Archivos y datos insertados correctamente.',
                timer: 3000 // Tiempo en milisegundos
            }).then(function() {
                // Redireccionar o realizar alguna otra acción después de que se cierre la alerta
                window.location.href = 'documentos.php';
            });
          </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al insertar datos: " . $stmt->error . "',
                timer: 3000 // Tiempo en milisegundos
            }).then(function() {
                // Puedes agregar código para manejar la redirección o cualquier otra acción aquí
            });
          </script>";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
