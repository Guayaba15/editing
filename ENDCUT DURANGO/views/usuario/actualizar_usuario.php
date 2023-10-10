<?php
// Conexión a la base de datos (cambia los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "endcut";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados por AJAX
$id = $_POST['id'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$tipo = $_POST['tipo'];
$disciplina = $_POST['disciplina'];
$universidad = $_POST['universidad'];

// Aquí deberías realizar la validación y procesamiento de los datos antes de la actualización
// Por ejemplo, puedes escapar las variables para evitar inyección de SQL y realizar validaciones
// sobre los campos, luego ejecutar la consulta de actualización

// Ejemplo de consulta de actualización (cambia la tabla y las columnas según tu base de datos)
$sql = "UPDATE usuarios SET
        usuario = '$usuario',
        email = '$email',
        pass = '$pass',
        tipo = '$tipo',
        disciplina = '$disciplina',
        universidad = '$universidad'
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    $response = "Datos actualizados exitosamente.";
} else {
    $response = "Error al actualizar los datos: " . $conn->error;
}

$conn->close();

// Enviar la respuesta al cliente
echo $response;
?>
