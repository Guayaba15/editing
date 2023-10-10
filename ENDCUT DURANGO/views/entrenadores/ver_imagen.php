<?php
// Establece la conexión a la base de datos
require_once("../../db/connection.php");

// Obtiene el ID del usuario a eliminar desde la URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Obtener información de la imagen por ID
    $query = "SELECT imagen FROM coordinadores WHERE id = $userId";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $imagenContenido = $fila["imagen"];
        
        // Obtener el tipo MIME correcto basado en el formato de imagen (por ejemplo, image/jpeg para JPEG)
        $tipoMIME = "image/jpeg"; // Cambiar según el formato de imagen
        
        header("Content-type: $tipoMIME");
        
        echo $imagenContenido;
        
        echo "<img src='data:$tipoMIME;base64," . base64_encode($imagenContenido) . "' alt='$nombreImagen' width='300'>";
    } else {
        echo "Imagen no encontrada.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();

// Envía la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

