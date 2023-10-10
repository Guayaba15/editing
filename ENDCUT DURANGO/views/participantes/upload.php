<?php
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "endcut";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_FILES["fileInput"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["fileInput"]["tmp_name"];
    
    // Parse and insert data into the database
    // Here, you would need to use a library to parse Excel data like PHPExcel or PhpSpreadsheet
    
    // Example query to insert data into the database
    $insertQuery = "INSERT INTO participantes (matricula, universidad, nombre, ape_pat, ape_mat, grado, carrera, curp, disciplina, rama, fecha_ingreso, ciclo_escolar, sexo, nss) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)";
    $stmt = $conn->prepare($insertQuery);
    
    // Bind parameters and execute the statement for each row
    
    if ($stmt->execute()) {
        echo "Data imported successfully.";
    } else {
        echo "Error importing data: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "File upload error.";
}

$conn->close();
?>
