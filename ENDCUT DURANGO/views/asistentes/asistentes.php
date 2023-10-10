<?php
// Conexión a la base de datos (cambia los valores según tu configuración)
require_once("../../db/connection.php");

//Permisos
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}

// Realiza la consulta SQL para obtener todos los registros
$sql = "SELECT * FROM asistentes WHERE universidad = '" . $_SESSION['uni'] . "';";
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
$sqlPaginacion = "SELECT * FROM asistentes WHERE universidad = '" . $_SESSION['uni'] . "' LIMIT $indiceInicio, $registrosPorPagina";
$resultPaginacion = $conn->query($sqlPaginacion);

$uni = $_SESSION['uni'];
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
    <div class="header">
        <h2 style="margin-left: 4%;margin-top: 1%; color: #fff">ENDCUT DURANGO 2024 &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['username']; ?></h2>
    </div>
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
            <li><a href="../../index.html">Inicio</a></li>
            <li><a href="../participantes/participantes.php">Participantes</a></li>
            <li><a href="../universidades/universidades.php">Universidades</a></li>
            <li><a href="../entrenadores/entrenadores.php">Entrenadores</a></li>
            <li><a href="../coordinadores/coordinadores.php">Coordinadores</a></li>
            <li><a href="#">Asistentes</a></li>
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
                    <h1 style="font-weight:bold; font-size:4vmin">Inicio / Registro Asistentes</h1>
                    <div id="botonAdd">
                        <a href="#" class="AddButtonv2" onclick="mostrarDivs()"><i class="fa fa-plus"></i>&nbsp;&nbsp; Agregar registro de Asistentes</a>
                        <div id="miDiv" style="display: none;">
                            <div style="margin-bottom: 3%;">
                                <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
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
                                            <td><img src="line6.png" alt="line" width="100%"></td>
                                        </tr>
                                    </table><br>
                                </form>
                            </div>
                        </div>
                        <div id="miDivEdit" style="display: none;">
                            <div style="margin-bottom: 3%;">
                                <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <table>
                                        <tr>
                                            <td style="width:400px">
                                                <label>ID</label><br>
                                                <input type="text" name="registroEditar" id="registroEditar" readonly='readonly' value="">
                                            </td>
                                            <td style="width:400px">
                                                <label>Universidad</label><br>
                                                <input type="text" name="universidadEd" id="universidadEd" readonly='readonly' value="">
                                            </td>
                                            <td style="width:400px">
                                                <label>Nombre</label><br>
                                                <input placeholder="Nombre" name="nombre" id="nombreEd" type="text" value="">
                                            </td>
                                            <td style="width:400px">
                                                <label>Apellido Paterno</label><br>
                                                <input placeholder="Apellido Paterno" id="ape_patEd" name="ape_pat" type="text" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Apellido Materno</label><br>
                                                <input placeholder="Apellido Materno" id="ape_matEd" name="ape_mat" type="text">
                                            </td>
                                            <td>
                                                <label>Disciplina</label><br>
                                                <select id="disciplinaEd" name="disciplina">
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
                                                <label>Fotografía</label><br>
                                                <input type="file" id="imagenEd" name="imagen" accept="image/*" class="AddButton" style="margin-bottom: 20px; margin-top: 20px;">
                                            </td>
                                        </tr>
                                    </table><br>
                                    <table>
                                        <tr>
                                            <td style="width:400px">
                                            </td>
                                            <td style="width:400px"></td>
                                            <td style="text-align:center;width:400px">
                                                <a href="#" class="AddButtonv3" onclick="toggleDivEdit('x')"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
                                                <button class="AddButtonv4" name="actualizar"><i class="fa fa-check"></i>&nbsp;&nbsp;Actualizar</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td><img src="line6.png" alt="line" width="100%"></td>
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
                                    <th>ID</th>
                                    <th>Universidad</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Disciplina</th>
                                    <th>Fotografía</th>
                                    <?php if ($_SESSION['tipo'] == 'admin') { ?>
                                        <th>Opciones</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($rowList = $resultPaginacion->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $rowList['id']; ?></td>
                                        <td><?php echo $rowList['universidad']; ?></td>
                                        <td><?php echo $rowList['nombre']; ?></td>
                                        <td><?php echo $rowList['ape_pat']; ?></td>
                                        <td><?php echo $rowList['ape_mat']; ?></td>
                                        <td><?php echo $rowList['disciplina']; ?></td>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($rowList['imagen']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php if ($_SESSION['tipo'] == 'admin') {
                                            $editID = "" . $rowList['id'] . ""; ?>
                                            <td class="iconsDesign">
                                                <a href="#" class="editar-btn" data-id="<?php echo $editID; ?>"><i class="fa fa-edit"></i></a>
                                                <a href="eliminar_asistente.php?id=<?php echo $rowList['id']; ?>" class="deleteUser" data-userid="<?php echo $rowList['id']; ?>"><i class="fa fa-trash"></i></a>
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
                    <br><br> <br> <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista previa de la imagen -->
    <script>
        $(document).ready(function() {

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

            //Ocultar / Mostrar el Div de Asistentes
            function mostrarDivs() {
                var div = document.getElementById("miDiv");
                if (div.style.display === "none") {
                    div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
            }


            //Ocultar / Mostrar el Div de Asistentes editar
            function toggleDivEdit(uni) {
                alert(uni);
                var div = document.getElementById('miDivEdit');
                if (div.style.display === 'none') {
                    //Si oprime el boton muestra form
                    div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            }

            // Agregar un evento de clic a todos los botones "EDITAR"
            var editarButtons = document.querySelectorAll('.editar-btn');

            editarButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtener el ID del registro a editar desde el atributo data-id
                    var registroId = button.getAttribute('data-id');

                    // Mostrar el campo de entrada oculto
                    var inputEditar = document.getElementById('registroEditar');
                    inputEditar.style.display = 'block';

                    // Asignar el ID del registro a editar al campo de entrada
                    inputEditar.value = registroId;

                    // Obtener los datos del registro seleccionado (simulado)
                    var registros = <?php
                                    $sqlEditRow = "SELECT * FROM asistentes WHERE universidad = '" . $_SESSION['uni'] . "'";
                                    $resultEd = $conn->query($sqlEditRow);

                                    // Crear un arreglo para almacenar los resultados
                                    $data = array();

                                    // Iterar sobre los resultados y agregarlos al arreglo
                                    while ($resultEdit = $resultEd->fetch_assoc()) {
                                        $data[] = $resultEdit;
                                    }

                                    // Convertir el arreglo en formato JSON
                                    echo json_encode($data);
                                    ?>;

                    // Encontrar el registro por ID
                    var registro = registros.find(function(item) {
                        return item.id == registroId;
                    });

                    if (registro) {
                        // Mostrar el campo de entrada oculto
                        var divEditar = document.getElementById('miDivEdit');
                        divEditar.style.display = 'block';

                        // Llenar los campos de entrada con los datos del registro
                        document.getElementById('universidadEd').value = registro.universidad;
                        document.getElementById('nombreEd').value = registro.nombre;
                        document.getElementById('ape_patEd').value = registro.ape_pat;
                        document.getElementById('ape_matEd').value = registro.ape_mat;
                        document.getElementById('disciplinaEd').value = registro.disciplina;
                    }

                });
            });


            /*document.getElementById('editarReg').addEventListener('click', function() {
                var div = document.getElementById('miDivEdit');
                if (div.style.display === 'none') {
                    //Si oprime el boton muestra form
                        div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            });*/


            //Agregar una imagen
            function selectImageFile(event) {
                event.preventDefault(); // Evita que se abra el enlace

                var imageInput = document.getElementById('imageInput');
                imageInput.click(); // Activa el cuadro de diálogo de selección de archivos
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
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'portrait'
                    }
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
                var blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });

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

            // Verificar si el usuario de la sesión coincide con el usuario deseado
            var usuarioSesion = "<?php echo $_SESSION['tipo'] ?>";

            if (usuarioSesion != "admin") {
                // Ocultar el div
                var div = document.getElementById("botonAdd");
                if (div) {
                    div.style.display = "none";
                }
            }



        });
    </script>

    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

    <script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</body>

</html>

<?php
//Conexión a la BD
require_once("../../db/connection.php");

if (isset($_POST["registrar"])) {
    echo "<script>console.log('Console 413: entra a method post' );</script>";
    // Validar que los campos no estén vacíos
    if (empty($_POST["nombre"]) || empty($_POST["ape_pat"]) || empty($_POST["ape_mat"]) || empty($_POST["disciplina"])) {
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
        $universidad = $uni;
        echo "<script>console.log('Console 427: entra a uni: $universidad');</script>";
        $nombre = $_POST["nombre"];
        echo "<script>console.log('Console 429: entra a name: $nombre');</script>";
        $ape_pat = $_POST["ape_pat"];
        echo "<script>console.log('Console 431: entra a ape pat: $ape_pat');</script>";
        $ape_mat = $_POST["ape_mat"];
        echo "<script>console.log('Console 433: entra a ape mat: $ape_mat');</script>";
        $disciplina = $_POST["disciplina"];
        echo "<script>console.log('Console 435: entra a disciplina: $disciplina');</script>";

        // Manejo de la imagen
        if (isset($_FILES["imagen"])) {
            echo "<script>console.log('Console 439: entra if de imagen' );</script>";
            $imagenTempPath = $_FILES["imagen"]["tmp_name"];
            $imagenContenido = file_get_contents($imagenTempPath);
        } else {
            echo "<script>console.log('Console 443: entra else de imagen' );</script>";
            // Si no se proporciona una imagen, puedes establecer un valor predeterminado o manejarlo según tus necesidades.
            $imagenContenido = null;
        }

        // Preparar y ejecutar la consulta
        $query = "INSERT INTO `asistentes`(`universidad`, `nombre`, `ape_pat`, `ape_mat`, `disciplina`, `imagen`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        echo "<script>console.log('Console 454: hace query $query' );</script>";

        if ($stmt) {
            echo "<script>console.log('Console 457: entra a if stmt xd');</script>";

            if ($stmt instanceof mysqli_stmt) {
                // bind_param se ejecutará aquí
                echo "<script>console.log('Console 461: revisa antes del bind');</script>";
                if ($stmt->bind_param("sssssb", $universidad, $nombre, $ape_pat, $ape_mat, $disciplina, $imagenContenido)) {
                    // bind_param se ejecutó correctamente
                    echo "<script>console.log('Console 464: bind param se ejecuto bien' );</script>";
                } else {
                    echo "<script>console.log('Console 466: bind param  error $stmt->error' );</script>";
                }
            } else {
                echo "<script>console.log('Console 469: La declaración preparada no se creó correctamente' );</script>";
            }

            if ($stmt->execute()) {
                // Mostrar mensaje SweetAlert de éxito
                echo "<script>
                console.log('Console 475: hace if stmt execute');
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
                echo "<script>console.log('Console 487: Error en la ejecución de la sentencia $stmt->error');</script>";
                // Mostrar mensaje SweetAlert de error
                echo "<script>
                console.log('Console 490: hace else stmt execute' );
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Hubo un problema al registrar. Inténtalo nuevamente.',
                    });
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>console.log('Console 500: entra a else stmt );</script>";
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