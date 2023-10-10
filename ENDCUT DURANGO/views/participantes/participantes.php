<?php
// Conexión a la base de datos (cambia los valores según tu configuración)
require_once("../../db/connection.php");

//Permisos
session_start(); 

if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}

$uni = $_SESSION['uni'];

// Realiza la consulta SQL para obtener todos los registros
$sql = "SELECT * FROM participantes WHERE universidad = '" . $_SESSION['uni'] . "';";
$result = $conn->query($sql);

// Definir la cantidad de registros por página y calcular el total de páginas
$registrosPorPagina = 7;
$totalRegistros = $result->num_rows;
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener el número de página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el índice de inicio para la consulta SQL
$indiceInicio = ($paginaActual - 1) * $registrosPorPagina;

// Consulta SQL con LIMIT para paginación
$sqlPaginacion = "SELECT * FROM participantes WHERE universidad = '" . $_SESSION['uni'] . "' LIMIT $indiceInicio, $registrosPorPagina";
$resultPaginacion = $conn->query($sqlPaginacion);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ENDCUT DURANGO 2024</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="logo_chico.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <script src="js/confirmar_delete.js"></script>
    <link rel="stylesheet" href="responsive_menu.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Varela+Round');
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000; /* Asegura que el modal esté por encima de otros elementos */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscurecido */
        }

        .btn1{
            box-shadow: 0px 7px 16px -7px #3e7327;
            background-color: #77b55a; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
            font-family: 'Varela Round', sans-serif;
        }

        .btn1:hover{
            background-color:#3d9551;
        }

        .btn2{
            box-shadow: 0px 7px 16px -7px #601e5f;
            background-color: #761875; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
            font-family: 'Varela Round', sans-serif;
        }

        .btn2:hover{
            background-color:#b452b2;
        }

        .modal-content {
            background-color: white;
            border-radius: 20px;
            box-shadow: 5px 5px 20px 0px #adadad;
            margin: 10% auto;
            padding: 40px 30px 70px 30px;
            border: 1px solid #888;
            width: 50%;
            margin-top: 20%;
        }

        .modal-content h2{
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
</style>
<body>
    <!-- partial:index.partial.html -->
    <div class="header"><h2 style="margin-left: 4%;margin-top: 1%; color: #fff">ENDCUT DURANGO 2024&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['username']; ?></h2></div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
    </label>
    
    <div id="sidebarMenu">
        <ul class="sidebarMenuInner">
            <li>
                <img src="logo_normal.jpg" width="90%" style="margin: 15px 0px 15px;"><br>
            </li>
            <li><a href="../../index.php">Inicio</a></li>
            <li><a href="#">Participantes</a></li>
            <li><a href="../universidades/universidades.php">Universidades</a></li>
            <li><a href="../entrenadores/entrenadores.php">Entrenadores</a></li>
            <li><a href="../coordinadores/coordinadores.php">Coordinadores</a></li>
            <li><a href="../asistentes/asistentes.php">Asistentes</a></li>
            <li><a href="../medicos/medicos.php">Médicos</a></li>
            <li><a href="../staff/staff.php">Staff</a></li>
            <li><a href="../documentos/documentos.php">Documentos</a></li>
            <?php if ($_SESSION['tipo'] == 'superadmin') { ?>
            <li><a href="../usuario/usuarios.php">Usuarios</a></li>
            <?php } ?>
            <li><a href="../../login/logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

    <div id='center' class="main center">
        <div style="margin: 10%;">
            <div className="d-flex">
                <div>
                    <h1 style="font-weight:bold; font-size:4vmin">Inicio / Registro Participantes</h1>
                    <div>
                        <a href="#" class="AddButtonv2" id="botonAdd" onclick="toggleDiv()"><i class="fa fa-plus"></i>&nbsp;&nbsp;   Agregar registro de Participantes</a>
                        <div id="miDiv" style="display: none;">
                            <div style="margin-bottom: 3%;">
                            <form method="POST">
                                <table>
                                    <tr>
                                        <td>
                                            <label>Matricula</label><br>
                                            <input placeholder="Matricula" name="matricula">
                                        </td>
                                        <td>
                                            <label>Universidad</label><br>
                                            <input type="text" name="universidad" readonly='readonly' value="<?php echo $uni; ?>">
                                        </td>
                                        <td style="width:400px">
                                            <label>Nombre</label><br>
                                            <input placeholder="Nombre" name="nombre" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:400px">
                                            <label>Apellido Paterno</label><br>
                                            <input placeholder="Apellido Paterno" name="ape_pat" type="text">
                                        </td>
                                        <td style="width:400px">
                                            <label>Apellido Materno</label><br>
                                            <input placeholder="Apellido Materno" name="ape_mat" type="text">
                                        </td>
                                        <td>
                                            <label>Grado</label><br>
                                            <input placeholder="Grado" name="grado" type="number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Carrera</label><br>
                                            <input placeholder="Carrera" name="carrera" type="text">
                                        </td>
                                        <td>
                                            <label>Curp</label><br>
                                            <input placeholder="Curp" name="curp">
                                        </td>
                                        <td>
                                            <label>Disciplina</label><br>
                                            <select id="disciplina" name="disciplina">
                                                <option value="" disabled selected>-- Seleccione una opción --</option>
                                                <option value="Ajedrez">Ajedrez</option>
                                                <option value="Atletismo">Atletismo</option>
                                                <option value="Baloncesto">Baloncesto</option>
                                                <option value="Canto">Canto</option>
                                                <option value="Declamacion">Declamación</option>
                                                <option value="Oratoria">Oratoria</option>
                                                <option value="Voleibol">Voleibol</option>
                                                <option value="Taekwondo">Taekwondo</option>
                                                <option value="Mural en gis">Mural en Gis</option>
                                                <option value="Softbol">Softbol</option>
                                                <option value="Rondalla">Rondalla</option>
                                                <option value="Disciplina 3">Fútbol 7</option>
                                                <option value="Futbol asociacion">Futbol asociacion</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Rama</label><br>
                                            <select id="rama" name="rama">
                                                <option value="" disabled selected>-- Seleccione una opción --</option>
                                                <option value="varonil">Varonil</option>
                                                <option value="femenil">Femenil</option>
                                                <option value="mixto">Mixto</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Fecha de Ingreso</label><br>
                                            <input placeholder="Fecha de Ingreso" name="fecha_ingreso" type="date">
                                        </td>
                                        <td style="width:400px">
                                            <label>Sexo</label><br>
                                            <select name="sexo" id="sexo">
                                                <option value="" disabled selected>-- Seleccione una opción --</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table><br>
                                <table>
                                    <tr>
                                        <td style="width:400px">
                                            <a href="#" class="AddButton" style="margin-bottom: 13%;" onclick="openModal()"><i class="fa fa-upload"></i>&nbsp;&nbsp;Carga Masiva</a>
                                        </td>
                                        <td style="width:400px"></td>
                                        <td style="text-align:center;width:400px">
                                            <a href="#" class="AddButtonv3"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
                                            <button class="AddButtonv4" name="registrar"><i class="fa fa-check"></i>&nbsp;&nbsp;Registrar</button>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><img src="line6.png" alt="line"  width="100%"></td>
                                    </tr>
                                </table><br>
                                </form>
                            </div>

                            <!-- Modal -->
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2>Importar Registros desde Excel</h2>
                                    <form>
                                        <div class="large-group">
                                            <div class="small-group">
                                                <label for="fileInput">Archivo Excel:</label>
                                                <input type="file" id="fileInput">
                                            </div>
                                        </div>
                                        <button class="btn btn1" onclick="importData()">Importar</button>
                                        <button class="btn btn2" onclick="closeModal()">Cancelar</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div style="display: inline-block;margin-bottom: -50px; width: 890px;">
                        <form action="" class="search-bar">
                            <label style="color: #494949; font-size: 20px;">Buscar</label>
                            <input type="search" name="search" pattern=".*\S.*" required autocomplete="off">
                            <button class="search-btn" type="submit">
                              <span>Search</span>
                            </button>
                        </form>
                        <button class="AddButtonv3" onclick="exportToCSV()"><i class="fa fa-file-o"></i>&nbsp;&nbsp;CSV</button>
                        <button class="AddButtonv3" onclick="exportToExcel()"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;EXCEL</button>
                        <button class="AddButtonv3" onclick="exportToPDF()"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF</button>
                    </div>
                    <div>
                        <table class="TableDesign" id="miTabla">
                            <thead>
                                <tr>
                                    <th>Matricula</th>
                                    <th>Universidad</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Grado</th>
                                    <th>Carrera</th>
                                    <th>Curp</th>
                                    <th>Disciplina</th>
                                    <th>Rama</th>
                                    <th>Fecha de ingreso</th>
                                    <th>Sexo</th>
                                    <?php if ($_SESSION['tipo'] == 'admin') { ?>
                                    <th>Opciones</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $resultPaginacion->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['matricula']; ?></td>
                                        <td><?php echo $row['universidad']; ?></td>
                                        <td class="boldDesign"><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['ape_pat']; ?></td>
                                        <td><?php echo $row['ape_mat']; ?></td>
                                        <td><?php echo $row['grado']; ?></td>
                                        <td><?php echo $row['carrera']; ?></td>
                                        <td><?php echo $row['curp']; ?></td>
                                        <td><?php echo $row['disciplina']; ?></td>
                                        <td><?php echo $row['rama']; ?></td>
                                        <td><?php echo $row['fecha_ingreso']; ?></td>
                                        <td><?php echo $row['sexo']; ?></td>
                                        <?php if ($_SESSION['tipo'] == 'admin') {  ?>
                                        <td class="iconsDesign">
                                            <a href="#"><i class="fa fa-edit"></i></a>
                                            <a href="eliminar_participante.php?id=<?php echo $row['id']; ?>" class="deleteUser" data-userid="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="14">
                                        <div class="links">
                                        <?php if ($paginaActual > 1) { ?>
                                            <a href="?pagina=<?php echo $paginaActual - 1; ?>">&laquo;</a>
                                        <?php } ?>
                                        <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                                            <a class="<?php echo ($i == $paginaActual) ? 'activeD' : ''; ?>" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        <?php } ?>
                                        <?php if ($paginaActual < $totalPaginas) { ?>
                                            <a href="?pagina=<?php echo $paginaActual + 1; ?>">&raquo;</a>
                                        <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        //Ocultar / Mostrar el Div de Participantes
        function toggleDiv() {
            var div = document.getElementById("miDiv");
            if (div.style.display === "none") {
               div.style.display = "block";
            } else {
               div.style.display = "none";
            }
         }

         //Agregar una imagen
         function selectImageFile(event) {
            event.preventDefault();  // Evita que se abra el enlace
         
            var imageInput = document.getElementById('imageInput');
            imageInput.click();  // Activa el cuadro de diálogo de selección de archivos
         }
         
         // Escucha el evento de cambio en el archivo seleccionado
         document.getElementById('imageInput').addEventListener('change', function(event) {
            var selectedFile = event.target.files[0];
            if (selectedFile && selectedFile.type.startsWith('image/')) {
               console.log('Imagen seleccionada:', selectedFile);
               // Realiza las acciones necesarias con la imagen seleccionada
            } else {
               console.log('Archivo no válido. Selecciona una imagen.');
               // Muestra un mensaje de error o realiza otra acción cuando no se selecciona una imagen válida
            }
         });

         //Descargar la tabla en Excel
         function exportToExcel() {
            var table = document.getElementById('miTabla');
            var fileName = 'tabla_excel.xlsx';
         
            // Convertir la tabla en un objeto de workbook de SheetJS
            var wb = XLSX.utils.table_to_book(table);
         
            // Guardar el archivo utilizando FileSaver.js
            XLSX.writeFile(wb, fileName);
         }

         //Descargar la tabla en PDF
         function exportToPDF() {
            var table = document.getElementById('miTabla');
            var opt = {
               margin: 1,
               filename: 'tabla_pdf.pdf',
               image: { type: 'jpeg', quality: 0.98 },
               html2canvas: { scale: 2 },
               jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
         
            html2pdf().set(opt).from(table).save();
         }
         
         //Descargar la tabla en CSV
         function exportToCSV() {
            var table = document.getElementById('miTabla');
            var fileName = 'tabla_csv.csv';
         
            var csvContent = "data:text/csv;charset=utf-8,";
         
            // Obtener todas las filas de la tabla
            var rows = table.getElementsByTagName('tr');
         
            // Recorrer las filas y obtener los datos de cada celda
            for (var i = 0; i < rows.length; i++) {
               var cells = rows[i].getElementsByTagName('td');
               var rowData = [];
         
               // Recorrer las celdas y obtener el texto
               for (var j = 0; j < cells.length; j++) {
                  rowData.push(cells[j].innerText);
               }
         
               // Agregar los datos de la fila al contenido CSV
               csvContent += rowData.join(',') + '\n';
            }
         
            // Crear un objeto Blob con el contenido CSV
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
         
            // Crear un enlace de descarga y establecer el archivo Blob como origen
            var link = document.createElement("a");
            if (link.download !== undefined) {
               var url = URL.createObjectURL(blob);
               link.setAttribute("href", url);
               link.setAttribute("download", fileName);
               link.style.visibility = 'hidden';
               document.body.appendChild(link);
               link.click();
               document.body.removeChild(link);
            }
         }
         
        // Función para abrir el modal
        function openModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        }

        // Función para cerrar el modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
         
        // Cargar archivos
        function importData() {
        const form = document.getElementById("uploadForm");
        const formData = new FormData(form);

        fetch("upload.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            // Handle the response from the server (success or error)
        })
        .catch(error => {
            // Handle any errors
        });
    }
         
    </script>
    
    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script></body>
    
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    
    <script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    

</html>

<script>
    // Verificar si el usuario de la sesión coincide con el usuario deseado
    var usuarioSesion = "<?php echo $_SESSION['tipo'] ?>";

    if (usuarioSesion != "admin") {
        // Ocultar el div
        var div = document.getElementById("botonAdd");
        if (div) {
            div.style.display = "none";
        }
    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar que los campos no estén vacíos
    echo "<script>console.log('Console 413: entra a method post' );</script>";
    if (empty($_POST["matricula"]) || empty($_POST["nombre"]) || empty($_POST["ape_pat"]) || empty($_POST["ape_mat"]) || empty($_POST["grado"]) || empty($_POST["carrera"]) || empty($_POST["curp"]) || empty($_POST["disciplina"]) || empty($_POST["rama"]) || empty($_POST["fecha_ingreso"]) || empty($_POST["sexo"])) {
        echo '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Campos incompletos",
                    text: "Por favor, completa todos los campos del formulario.",
                });
            </script>';
            echo "console.log('Console 423: entra a empty' );</script>";
    } else {

    echo "<script>console.log('Console 425: entra else empty' );</script>";
    // Recuperar datos del formulario
    $matricula = $_POST["matricula"];
    echo "<script>console.log('Console 427: entra a mat: $matricula');</script>";
    $universidad = $uni;
    echo "<script>console.log('Console 427: entra a uni: $universidad');</script>";
    $nombre = $_POST["nombre"];
    echo "<script>console.log('Console 427: entra a nom: $nombre');</script>";
    $ape_pat = $_POST["ape_pat"];
    echo "<script>console.log('Console 427: entra a ape_pat: $ape_pat');</script>";
    $ape_mat = $_POST["ape_mat"];
    echo "<script>console.log('Console 427: entra a ape_mat: $ape_mat');</script>";
    $grado = $_POST["grado"];
    echo "<script>console.log('Console 427: entra a grado: $grado');</script>";
    $carrera = $_POST["carrera"];
    echo "<script>console.log('Console 427: entra a carrera: $carrera');</script>";
    $curp = $_POST["curp"];
    echo "<script>console.log('Console 427: entra a curp: $curp');</script>";
    $disciplina = $_POST["disciplina"];
    echo "<script>console.log('Console 427: entra a disciplina: $disciplina');</script>";
    $rama = $_POST["rama"];
    echo "<script>console.log('Console 427: entra a rama: $rama');</script>";
    $fecha_ingreso = $_POST["fecha_ingreso"];
    echo "<script>console.log('Console 427: entra a fecha: $fecha_ingreso');</script>";
    $sexo = $_POST["sexo"];
    echo "<script>console.log('Console 427: entra a sexo: $sexo');</script>";

    // Conexión a la base de datos (reemplaza con tus propios valores)
    require_once("../../db/connection.php");

    // Insertar datos en la base de datos
    $sql = "INSERT INTO participantes (matricula, universidad, nombre, ape_pat, ape_mat, grado, carrera, curp, disciplina, rama, fecha_ingreso, sexo)
            VALUES ('$matricula', '$universidad', '$nombre', '$ape_pat', '$ape_mat', '$grado', '$carrera', '$curp', '$disciplina', '$rama', '$fecha_ingreso', '$sexo')";
    
    echo "<script>console.log('Console 454: hace query $sql' );</script>";

    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, mostrar alerta de SweetAlert
        echo '<script>
        console.log("Console 475: hace conn true");
                Swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "El participante se ha registrado correctamente.",
                }).then(function() {
                    window.location.href = "participantes.php"; // Redirigir a la página de usuarios
                });
            </script>';
    } else {
        // Error al registrar, mostrar alerta de SweetAlert
        echo '<script>
        console.log("Console 475: hace conn false");
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error al registrar el usuario.",
                });
            </script>';
    }

    $conn->close();
}
}
?>