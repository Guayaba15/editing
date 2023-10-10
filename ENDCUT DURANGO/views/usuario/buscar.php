<?php
// Establece la conexión a la base de datos (reemplaza con tus propios valores)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "endcut";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el término de búsqueda enviado desde el formulario
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // Prepara la consulta SQL para buscar en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario LIKE '%$searchTerm%'";

    // Ejecuta la consulta y obtiene los resultados
    $result = $conn->query($sql);
    
    // ... Aquí puedes procesar y mostrar los resultados de la búsqueda ...
} else {
    // No se proporcionó un término de búsqueda válido
    echo "Ingrese un término de búsqueda.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
