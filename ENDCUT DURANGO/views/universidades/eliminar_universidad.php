<?php
// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "endcut";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el ID del usuario a eliminar desde la URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Prepara la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM universidades WHERE id = $userId";
    
    // Ejecuta la consulta y verifica el resultado
    if ($conn->query($sql) === TRUE) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }
} else {
    $response = ['success' => false];
}

// Cierra la conexión a la base de datos
$conn->close();

// Envía la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
