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
$sql = "SELECT * FROM entrenadores WHERE universidad = '" . $_SESSION['uni'] . "';";
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
$sqlPaginacion = "SELECT * FROM entrenadores WHERE universidad = '" . $_SESSION['uni'] . "' LIMIT $indiceInicio, $registrosPorPagina";
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
                <img src="logo_normal.jpg" width="90%" style="margin: 7px 0px 7px;"><br>
            </li>
            <li><a href="../../index.php">Inicio</a></li>
            <li><a href="../participantes/participantes.php">Participantes</a></li>
            <li><a href="../universidades/universidades.php">Universidades</a></li>
            <li><a href="#">Entrenadores</a></li>
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
                    <h1 style="font-weight:bold; font-size:4vmin">Inicio / Registro Entrenadores</h1>
                    <div>
                        <a href="#" class="AddButtonv2" id="botonAdd" onclick="toggleDiv()"><i class="fa fa-plus"></i>&nbsp;&nbsp;   Agregar registro de Entrenadores</a>
                        <div id="miDiv" style="display: none;">
                            <div style="margin-bottom: 3%;">
                            <form method="POST" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td style="width:400px">
                                            <label>Universidad</label><br>
                                            <input type="text" name="universidad" readonly='readonly' value="<?php echo $uni; ?>">
                                        </td>
                                        <td style="width:400px">
                                            <label>Nombre</label><br>
                                            <input placeholder="Nombre" name="nombre" type="text">
                                        </td>
                                        <td style="width:400px">
                                            <label>Apellido Paterno</label><br>
                                            <input placeholder="Apellido Paterno" name="ape_pat" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Apellido Materno</label><br>
                                            <input placeholder="Apellido Materno" name="ape_mat" type="text">
                                        </td>
                                        <td>
                                            <label>Telefono de la Oficina</label><br>
                                            <input placeholder="Telefono de la Oficina" name="tel_oficina" type="number">
                                        </td>
                                        <td>
                                            <label>Celular</label><br>
                                            <input placeholder="Celular" name="celular" type="number">
                                        </td>
                                    </tr>
                                    <tr>
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
                                                <option value="Futbol 7">Fútbol 7</option>
                                                <option value="Futbol asociacion">Futbol asociacion</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Rama</label><br>
                                            <select id="rama" name="rama">
                                                <option value="" disabled selected>-- Seleccione una opción --</option>
                                                <option value="varonil">Varonil</option>
                                                <option value="femenil">Femenil</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Fotografía</label><br>
                                            <input type="file" id="imageInput" name="imagen" accept="image/*" class="AddButton" style="margin-bottom: 20px; margin-top: 20px;">
                                        </td>
                                    </tr>
                                </table><br>
                                <table>
                                    <tr>
                                        <td style="width:400px">
                                            
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
                                    <th>Universidad</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Tel. Oficina</th>
                                    <th>Celular</th>
                                    <th>Disciplina</th>
                                    <th>Rama</th>
                                    <th>Fotografía</th>
                                    <?php if ($_SESSION['tipo'] == 'admin') { ?>
                                    <th>Opciones</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $resultPaginacion->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['universidad']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['ape_pat']; ?></td>
                                    <td><?php echo $row['ape_mat']; ?></td>
                                    <td><?php echo $row['tel_oficina']; ?></td>
                                    <td><?php echo $row['celular']; ?></td>
                                    <td><?php echo $row['disciplina']; ?></td>
                                    <td><?php echo $row['rama']; ?></td>
                                    <td class="iconsDesign">
                                        <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['imagen']); ?>"><i class="fa fa-upload"></i></a>
                                    </td>
                                    <?php if ($_SESSION['tipo'] == 'admin') { ?>
                                    <td class="iconsDesign">
                                        <a href="#"><i class="fa fa-edit"></i></a>
                                        <a href="eliminar_coordinador.php?id=<?php echo $row['id']; ?>" class="deleteUser" data-userid="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Vista previa de la imagen -->
    <script>
    // Agrega un listener de clic para los enlaces con clase "previewImage"
        document.addEventListener('DOMContentLoaded', function() {
            const previewLinks = document.querySelectorAll('.previewImage');
            
            previewLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
                    
                    const imageBase64 = this.getAttribute('data-image');
                    if (imageBase64) {
                        Swal.fire({
                            title: 'Imagen Previsualizada',
                            text: '',
                            imageUrl: 'data:image/jpeg;base64,' + imageBase64,
                            imageWidth: 400,
                            imageHeight: 300,
                            imageAlt: 'Imagen Previsualizada'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'La imagen no se encuentra disponible.'
                        });
                    }
                });
            });
        });
    </script>

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
         
         // Convertir letras a mayusculas
         function convertirAMayusculas(input) {
            input.value = input.value.toUpperCase();
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
        if (empty($_POST["nombre"]) || empty($_POST["ape_pat"]) || empty($_POST["ape_mat"]) || empty($_POST["tel_oficina"]) || empty($_POST["celular"]) || empty($_POST["disciplina"]) || empty($_POST["rama"])) {
            echo '<script>
                    Swal.fire({
                        icon: "warning",
                        title: "Campos incompletos",
                        text: "Por favor, completa todos los campos del formulario.",
                    });
                </script>';
        } else {

        $universidad = $uni;
        $nombre = $_POST["nombre"];
        $ape_pat = $_POST["ape_pat"];
        $ape_mat = $_POST["ape_mat"];
        $tel_oficina = $_POST["tel_oficina"];
        $celular = $_POST["celular"];
        $disciplina = $_POST["disciplina"];
        $rama = $_POST["rama"];
    
        // Manejo de la imagen
        if (isset($_FILES["imagen"])) {
            $imagenTempPath = $_FILES["imagen"]["tmp_name"];
            $imagenContenido = file_get_contents($imagenTempPath);
        } else {
            // Si no se proporciona una imagen, puedes establecer un valor predeterminado o manejarlo según tus necesidades.
            $imagenContenido = null;
        }

        // Conexión a la base de datos
        require_once("../../db/connection.php");

        // Preparar y ejecutar la consulta
        $query = "INSERT INTO entrenadores (universidad, nombre, ape_pat, ape_mat, tel_oficina, celular, disciplina, rama,imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sssssssss", $universidad, $nombre, $ape_pat, $ape_mat, $tel_oficina, $celular, $disciplina, $rama, $imagenContenido);
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
                        window.location.href = 'entrenadores.php'; // Redireccionar a la página principal
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

        $conn->close();
    }
}
?>
