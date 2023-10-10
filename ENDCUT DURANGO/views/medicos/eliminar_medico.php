<?php
// Establece la conexión a la base de datos
require_once("../../db/connection.php");

// Obtiene el ID del usuario a eliminar desde la URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Prepara la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM medicos WHERE id = $userId";
    
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

