<?php
// Conexión a la base de datos
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
    <link rel="stylesheet" href="responsive_menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>

<body>

    <!-- 1 INICIA EL MENU Y BARRA SUPERIOR-->
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
    <!-- 1 TERMINA MENU Y BARRA SUPERIOR -->




    <div id='center' class="main center">
        <div style="margin: 10%;">
            <div className="d-flex">
                <div>
                    <!-- 2 INICIA REGISTRO NUEVO-->
                    <h1 style="font-weight:bold; font-size:4vmin">Inicio / Registro Asistentes</h1>
                    <div>
                        <a href="#" class="AddButtonv2" id="btnAddNuevo"><i class="fa fa-plus"></i>&nbsp;&nbsp; Agregar registro de Asistentes</a>
                        <div id="miDiv" style="display: none;">
                            <div style="margin-bottom: 3%;">
                                <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <!-- 3 INICIA TABLA DE AGREGAR NUEVO -->
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
                                    </table>
                                    <br>
                                    <!-- 3 TERMINA TABLA DE AGREGAR NUEVO REGISTRO -->


                                    <!-- 4 INICIA TABLA DE BOTONES DE AGREGAR NUEVO REGISTRO -->
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
                                    <!-- 4 TERMINA TABLA DE BOTONES DE AGREGAR NUEVO REGISTRO-->

                                    <table>
                                        <tr>
                                            <td><img src="line6.png" alt="line" width="100%"></td>
                                        </tr>
                                    </table>
                                    <br>
                                </form>
                            </div>
                        </div>
                        <!-- 2 TERMINA REGISTRO NUEVO -->


                        <!-- 5 INICIA EDITAR REGISTRO -->
                        <div id="miDivEdit" style="display: none;">
                            <div style="margin-bottom: 3%;">
                                <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <!-- 6 INICIA TABLA DE EDITAR REGISTRO -->
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
                                    </table>
                                    <br>
                                    <!-- 6 TERMINA TABLA DE EDITAR REGISTRO -->


                                    <!-- 7 INICIA TABLA DE BOTONES DE EDITAR -->
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
                                    <!-- 7 TERMINA TABLA DE BOTONES DE EDITAR -->

                                    <table>
                                        <tr>
                                            <td><img src="line6.png" alt="line" width="100%"></td>
                                        </tr>
                                    </table>
                                    <br>
                                </form>
                            </div>
                        </div>
                        <!-- 5 TERMINA EDITAR REGISTRO -->
                    </div>


                    <!-- 8 INICIA CUADRO DE BUSQUEDA -->
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
                    <!-- 8 TERMINA CUADRO DE BUSQUEDA-->


                    <!-- 9 INICIA TABLA DE REGISTROS GUARDADOS-->
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

                                <!--10 INICIA WHILE DE TABLA DE REGISTROS -->
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
                                        <?php if ($_SESSION['tipo'] == 'admin') { ?>
                                            <td class="iconsDesign">
                                                <a href="#" class="editar-btn" data-id="<?php echo $rowList['id']; ?>"><i class="fa fa-edit"></i></a>
                                                <a href="eliminar_asistente.php?id=<?php echo $rowList['id']; ?>" class="deleteUser" data-userid="<?php echo $rowList['id']; ?>"><i class="fa fa-trash"></i></a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                <!-- 10 TERMINA WHILE DE TABLA DE REGISTROS -->

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
                    <!-- 9 TERMINA TABLA DE REGISTROS GUARDADOS-->


                    <br><br> <br> <br>
                </div>
            </div>
        </div>
    </div>

</body>

<!--<script src="js/confirmar_delete.js"></script>-->

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

    //Espera a cargar el html para cargar funciones
    $(document).ready(function() {

        //Ocultar / Mostrar Seccion de Agregar Registro nuevo
        var btnAddNuevo = document.getElementById('btnAddNuevo');

        btnAddNuevo.addEventListener('click', function() {
            var div = document.getElementById("miDiv");
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        });


        // Agregar un evento de clic a todos los botones "EDITAR"
        var editarButtons = document.querySelectorAll('.editar-btn');

        //Ocultar / Mostrar Seccion de Editar Registro
        editarButtons.forEach(function(button) {
            button.addEventListener('click', function() {

                // Obtener el ID del registro a editar desde el atributo data-id
                var registroId = button.getAttribute('data-id');
                console.log('407 registro id ' + registroId);

                // Mostrar el campo de entrada oculto
                var inputEditar = document.getElementById('registroEditar');
                //inputEditar.style.display = 'block';

                // Asignar el ID del registro a editar al campo de entrada
                inputEditar.value = registroId;

                // Obtener los datos del registro seleccionado (simulado)
                var registros = '' + <?php
                                        $conn = new mysqli('localhost', 'root', '', 'endcut');
                                        $sqlEditRow = "SELECT * FROM asistentes WHERE universidad = '" . $_SESSION['uni'] . "'";

                                        $resultEd = $conn->query($sqlEditRow);

                                        if ($result->num_rows > 0) {
                                            // Crear un arreglo para almacenar los resultados
                                            $data = array();

                                            // Iterar sobre los resultados y agregarlos al arreglo
                                            while ($resultEdit = $resultEd->fetch_assoc()) {
                                                $data[] = $resultEdit;
                                            }
                                        } else {
                                            $data[] = "No se encontraron resultados";
                                        }
                                        // Convertir el arreglo en formato JSON
                                        echo json_encode($data);
                                        ?> '';

                                       
                console.log('436 registros ' + registros);
                const result = registros.find(registroId);
                // Encontrar el registro por ID
                /*var registro = registros.find(function(item) {
                    return item.id == registroId;
                });*/


                console.log('444 input editar ' + result);

                if (registro) {
                    // Mostrar el campo de entrada oculto
                    var divEditar = document.getElementById('miDivEdit');
                    divEditar.style.display = 'block';

                    console.log('451 entra a if ');

                    // Llenar los campos de entrada con los datos del registro
                    document.getElementById('universidadEd').value = registro.universidad;
                    document.getElementById('nombreEd').value = registro.nombre;
                    document.getElementById('ape_patEd').value = registro.ape_pat;
                    document.getElementById('ape_matEd').value = registro.ape_mat;
                    document.getElementById('disciplinaEd').value = registro.disciplina;
                }

            });
        });


    });
</script>
<!-- INICIAN SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</html>