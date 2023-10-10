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
$sql = "SELECT * FROM usuarios";
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
$sqlPaginacion = "SELECT * FROM usuarios LIMIT $indiceInicio, $registrosPorPagina";
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
    <script src="js/confirmar_delete.js"></script>
    <link rel="stylesheet" href="responsive_menu.css">
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="header"><h2 style="margin-left: 4%;margin-top: 1%; color: #fff">ENDCUT DURANGO 2024</h2></div>
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
            <li><a href="../asistentes/asistentes.php">Asistentes</a></li>
            <li><a href="../medicos/medicos.php">Médicos</a></li>
            <li><a href="../staff/staff.php">Staff</a></li>
            <li><a href="../documentos/documentos.php">Documentos</a></li>
            <li><a href="#">Usuarios</a></li>
            <li><a href="../../login/logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

    <div id='center' class="main center">
        <div style="margin: 10%;">
            <div className="d-flex">
                <div>
                    <h1 style="font-weight:bold; font-size:4vmin">Inicio / Registro Usuarios</h1>
                    <div>
                        <a href="#" class="AddButtonv2" onclick="toggleDiv()"><i class="fa fa-plus"></i>&nbsp;&nbsp;   Agregar registro de Usuarios</a>
                        <div id="miDiv" style="display: none;">
                            <div style="margin-bottom: 2.5%;">
                                <form method="POST">
                                    <table>
                                        <tr>
                                            <td style="width:400px">
                                                <label>Usuario</label><br>
                                                <input placeholder="Usuario" name="usuario" type="text">
                                            </td>
                                            <td style="width:400px">
                                                <label>Correo Electrónico</label><br>
                                                <input placeholder="Correo Electrónico" name="email" type="text">
                                            </td>
                                            <td style="width:400px">
                                                <label>Contraseña</label><br>
                                                <input placeholder="Contraseña" name="pass" type="password">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Tipo</label><br>
                                                <select name="tipo" id="tipo">
                                                    <option value="" disabled selected>-- Seleccione una opción --</option>
                                                    <option value="administrador">Administrador</option>
                                                    <option value="usuario">Usuario</option>
                                                </select>
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
                                                    <option value="Fútbol 7">Fútbol 7</option>
                                                    <option value="Futbol asociacion">Futbol asociacion</option>
                                                </select>
                                            </td>
                                            <td>
                                                <label>Universidad</label><br>
                                                <select id="universidad" name="universidad">
                                                    <option value="" disabled selected>-- Seleccione una opción --</option>
                                                        <option value="Universidad Tecnológica de Coahuila">Universidad Tecnológica de Coahuila</option>
                                                        <option value="Universidad Tecnológica de la Región Carbonífera">Universidad Tecnológica de la Región Carbonífera</option>
                                                        <option value="Universidad Tecnológica de la Región Centro de Coahuila">Universidad Tecnológica de la Región Centro de Coahuila</option>
                                                        <option value="Universidad Tecnológica de Parras de la Fuente">Universidad Tecnológica de Parras de la Fuente</option>
                                                        <option value="Universidad Tecnologica de Saltillo">Universidad Tecnologica de Saltillo</option>
                                                        <option value="Universidad Tecnológica de Torreón">Universidad Tecnológica de Torreón</option>
                                                        <option value="Universidad Tecnológica del Norte de Coahuila">Universidad Tecnológica del Norte de Coahuila</option>
                                                        <option value="Universidad Tecnológica de Manzanillo">Universidad Tecnológica de Manzanillo</option>
                                                        <option value="Universidad Tecnológica de Durango">Universidad Tecnológica de Durango</option>
                                                        <option value="Universidad Tecnológica de la Laguna Durango">Universidad Tecnológica de la Laguna Durango</option>
                                                        <option value="Universidad Tecnológica de Poanas">Universidad Tecnológica de Poanas</option>
                                                        <option value="Universidad Tecnológica de Rodeo">Universidad Tecnológica de Rodeo</option>
                                                        <option value="Universidad Tecnológica de Tamazula">Universidad Tecnológica de Tamazula</option>
                                                        <option value="Universidad Tecnológica del Mezquital">Universidad Tecnológica del Mezquital</option>
                                                        <option value="Universidad Tecnológica de Nezahualcóyotl">Universidad Tecnológica de Nezahualcóyotl</option>
                                                        <option value="Universidad Tecnológica de Tecámac">Universidad Tecnológica de Tecámac</option>
                                                        <option value="Universidad Tecnológica de Zinacantepec">Universidad Tecnológica de Zinacantepec</option>
                                                        <option value="Universidad Tecnológica del Sur del Estado de México">Universidad Tecnológica del Sur del Estado de México</option>
                                                        <option value="Universidad Tecnológica del Valle de Toluca">Universidad Tecnológica del Valle de Toluca</option>
                                                        <option value="Universidad Tecnológica Fidel Velázquez">Universidad Tecnológica Fidel Velázquez</option>
                                                        <option value="Universidad Tecnológica de León">Universidad Tecnológica de León</option>
                                                        <option value="Universidad Tecnológica de Salamanca">Universidad Tecnológica de Salamanca</option>
                                                        <option value="Universidad Tecnológica de San Miguel de Allende">Universidad Tecnológica de San Miguel de Allende</option>
                                                        <option value="Universidad Tecnológica del Norte de Guanajuato (UTNG)">Universidad Tecnológica del Norte de Guanajuato (UTNG)</option>
                                                        <option value="Universidad Tecnológica del Suroeste de Guanajuato">Universidad Tecnológica del Suroeste de Guanajuato</option>
                                                        <option value="Universidad Tecnológica Laja Bajío">Universidad Tecnológica Laja Bajío</option>
                                                        <option value="Universidad Tecnologica de Acapulco">Universidad Tecnologica de Acapulco</option>
                                                        <option value="Universidad Tecnológica de la Costa Grande de Guerrero">Universidad Tecnológica de la Costa Grande de Guerrero</option>
                                                        <option value="Universidad Tecnológica de la Región Norte de Guerrero">Universidad Tecnológica de la Región Norte de Guerrero</option>
                                                        <option value="Universidad Tecnologica de la Tierra caliente">Universidad Tecnologica de la Tierra caliente</option>
                                                        <option value="Universidad Tecnológica del Mar">Universidad Tecnológica del Mar</option>
                                                        <option value="Universidad Tecnológica de la Huasteca Hidalguense">Universidad Tecnológica de la Huasteca Hidalguense</option>
                                                        <option value="Universidad Tecnológica de la Sierra Hidalguense">Universidad Tecnológica de la Sierra Hidalguense</option>
                                                        <option value="Universidad Tecnológica de la Zona Metropolitana del Valle de México">Universidad Tecnológica de la Zona Metropolitana del Valle de México</option>
                                                        <option value="Universidad Tecnológica de Mineral de la Reforma">Universidad Tecnológica de Mineral de la Reforma</option>
                                                        <option value="Universidad Tecnológica de Tulancingo">Universidad Tecnológica de Tulancingo</option>
                                                        <option value="Universidad Tecnológica de Tula-Tepeji">Universidad Tecnológica de Tula-Tepeji</option>
                                                        <option value="Universidad Tecnológica del Valle del Mezquital">Universidad Tecnológica del Valle del Mezquital</option>
                                                        <option value="Universidad Tecnológica Minera de Zimapán">Universidad Tecnológica Minera de Zimapán</option>
                                                        <option value="Universidad Tecnológica de Jalisco">Universidad Tecnológica de Jalisco</option>
                                                        <option value="Universidad Tecnológica de la Zona Metropolitana de Guadalajara">Universidad Tecnológica de la Zona Metropolitana de Guadalajara</option>
                                                        <option value="Universidad Tecnológica de Morelia">Universidad Tecnológica de Morelia</option>
                                                        <option value="Universidad Tecnológica del Oriente de Michoacán">Universidad Tecnológica del Oriente de Michoacán</option>
                                                        <option value="Universidad Tecnológica del Sur del Estado de Morelos">Universidad Tecnológica del Sur del Estado de Morelos</option>
                                                        <option value="Universidad Tecnológica Emiliano Zapata del Estado de Morelos.">Universidad Tecnológica Emiliano Zapata del Estado de Morelos.</option>
                                                        <option value="Universidad Tecnológica de Bahía de Banderas">Universidad Tecnológica de Bahía de Banderas</option>
                                                        <option value="Universidad Tecnológica de la Sierra">Universidad Tecnológica de la Sierra</option>
                                                        <option value="Universidad Tecnológica de Mazatan">Universidad Tecnológica de Mazatan</option>
                                                        <option value="Universidad Tecnológica de Nayarit">Universidad Tecnológica de Nayarit</option>
                                                        <option value="Universidad Tecnológica de la Costa">Universidad Tecnológica de la Costa</option>
                                                        <option value="Universidad Tecnológica Bilingüe Franco Mexicana de Nuevo León">Universidad Tecnológica Bilingüe Franco Mexicana de Nuevo León</option>
                                                        <option value="Universidad Tecnológica Cadereyta">Universidad Tecnológica Cadereyta</option>
                                                        <option value="Universidad Tecnológica Gral. Mariano Escobedo">Universidad Tecnológica Gral. Mariano Escobedo</option>
                                                        <option value="Universidad Tecnológica Linares">Universidad Tecnológica Linares</option>
                                                        <option value="Universidad Tecnológica Santa Catarina">Universidad Tecnológica Santa Catarina</option>
                                                        <option value="Universidad Tecnológica de la Sierra Sur de Oaxaca">Universidad Tecnológica de la Sierra Sur de Oaxaca</option>
                                                        <option value="Universidad Técnica de los Valles Centrales Oaxaca">Universidad Técnica de los Valles Centrales Oaxaca</option>
                                                        <option value="Universidad Tecnológica Bilingüe Internacional y Sustentable de Puebla">Universidad Tecnológica Bilingüe Internacional y Sustentable de Puebla</option>
                                                        <option value="Universidad Tecnológica de Huejotzingo">Universidad Tecnológica de Huejotzingo</option>
                                                        <option value="Universidad Tecnológica de Izúcar de Matamoros">Universidad Tecnológica de Izúcar de Matamoros</option>
                                                        <option value="Universidad Tecnológica de Oriental">Universidad Tecnológica de Oriental</option>
                                                        <option value="Universidad Tecnológica de Puebla">Universidad Tecnológica de Puebla</option>
                                                        <option value="Universidad Tecnológica de Tecamachalco">Universidad Tecnológica de Tecamachalco</option>
                                                        <option value="Universidad Tecnológica de Xicotepec de Juárez">Universidad Tecnológica de Xicotepec de Juárez</option>
                                                        <option value="Universidad Tecnológica de Tehuacán">Universidad Tecnológica de Tehuacán</option>
                                                        <option value="Universidad Tecnológica de Corregidora">Universidad Tecnológica de Corregidora</option>
                                                        <option value="Universidad Tecnologica de Querétaro">Universidad Tecnologica de Querétaro</option>
                                                        <option value="Universidad Tecnológica de San Juan del Río">Universidad Tecnológica de San Juan del Río</option>
                                                        <option value="Universidad Tecnológica de Cancún">Universidad Tecnológica de Cancún</option>
                                                        <option value="Universidad Tecnológica de Chetumal">Universidad Tecnológica de Chetumal</option>
                                                        <option value="Universidad Tecnológica de la Riviera Maya">Universidad Tecnológica de la Riviera Maya</option>
                                                        <option value="Universidad Tecnológica de San Luis Potosí">Universidad Tecnológica de San Luis Potosí</option>
                                                        <option value="Universidad Tecnológica Metropolitana de San Luis Potosí">Universidad Tecnológica Metropolitana de San Luis Potosí</option>
                                                        <option value="Universidad Tecnológica de Culiacán">Universidad Tecnológica de Culiacán</option>
                                                        <option value="Universidad Tecnológica de Escuinapa">Universidad Tecnológica de Escuinapa</option>
                                                        <option value="Universidad Tecnológica de Etchojoa">Universidad Tecnológica de Etchojoa</option>
                                                        <option value="Universidad Tecnológica de Guaymas">Universidad Tecnológica de Guaymas</option>
                                                        <option value="Universidad Tecnológica de Hermosillo, Sonora">Universidad Tecnológica de Hermosillo, Sonora</option>
                                                        <option value="Universidad Tecnológica de Nogales">Universidad Tecnológica de Nogales</option>
                                                        <option value="Universidad Tecnológica de Puerto Peñasco">Universidad Tecnológica de Puerto Peñasco</option>
                                                        <option value="Universidad Tecnológica de San Luis Río Colorado (BIS)">Universidad Tecnológica de San Luis Río Colorado (BIS)</option>
                                                        <option value="Universidad Tecnológica del Sur de Sonora">Universidad Tecnológica del Sur de Sonora</option>
                                                        <option value="Universidad Tecnológica de Tabasco">Universidad Tecnológica de Tabasco</option>
                                                        <option value="Universidad Tecnológica del Usumacinta">Universidad Tecnológica del Usumacinta</option>
                                                        <option value="Universidad Tecnológica de Matamoros">Universidad Tecnológica de Matamoros</option>
                                                        <option value="Universidad Tecnológica de Nuevo Laredo">Universidad Tecnológica de Nuevo Laredo</option>
                                                        <option value="Universidad Tecnológica de Tamaulipas Norte">Universidad Tecnológica de Tamaulipas Norte</option>
                                                        <option value="Universidad Tecnológica del Mar de Tamaulipas Bicentenario">Universidad Tecnológica del Mar de Tamaulipas Bicentenario</option>
                                                        <option value="Universidad Tegnologica de Altamira">Universidad Tegnologica de Altamira</option>
                                                        <option value="Universidad Tecnológica de Tlaxcala">Universidad Tecnológica de Tlaxcala</option>
                                                        <option value="Universidad Tecnológica de Gutiérrez Zamora">Universidad Tecnológica de Gutiérrez Zamora</option>
                                                        <option value="Universidad Tecnológica del Centro de Veracruz">Universidad Tecnológica del Centro de Veracruz</option>
                                                        <option value="Universidad Tecnológica del Sureste de Veracruz">Universidad Tecnológica del Sureste de Veracruz</option>
                                                        <option value="Universidad Tecnológica del Centro">Universidad Tecnológica del Centro</option>
                                                        <option value="Universidad Tecnológica del Mayab">Universidad Tecnológica del Mayab</option>
                                                        <option value="Universidad Tecnológica del Poniente">Universidad Tecnológica del Poniente</option>
                                                        <option value="Universidad Tecnológica Metropolitana">Universidad Tecnológica Metropolitana</option>
                                                        <option value="Universidad Tecnológica Regional del Sur">Universidad Tecnológica Regional del Sur</option>
                                                        <option value="Universidad Tecnológica del Estado de Zacatecas">Universidad Tecnológica del Estado de Zacatecas</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                    </table><br>
                                    <table>
                                        <tr>
                                            <td style="width:400px">
                                            </td>
                                            <td style="width:400px"></td>
                                            <td style="text-align:center;width:400px">
                                                <a href="#" class="AddButtonv3"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
                                                <button class="AddButtonv4"><i class="fa fa-check"></i>&nbsp;&nbsp;Registrar</button>
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
                    <form action="buscar.php" class="search-bar" method="GET">
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
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Contraseña</th>
                                    <th>Tipo</th>
                                    <th>Disciplina</th>
                                    <th>Universidad</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $resultPaginacion->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['usuario']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['pass']; ?></td>
                                        <td><?php echo $row['tipo']; ?></td>
                                        <td><?php echo $row['disciplina']; ?></td>
                                        <td><?php echo $row['universidad']; ?></td>
                                        <td class="iconsDesign">
                                            <a href="javascript:void(0)" id="openModal"><i class="fa fa-edit"></i></a>
                                            <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="deleteUser" data-userid="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
                                        </td>
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
    
    <style>
        .hide-for-pdf {
            display: none;
        }
    </style>

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


        // Descargar la tabla en PDF
        function exportToPDF() {
            var table = document.getElementById('miTabla');

            // Add a class to the "Acciones" column cells to hide them in PDF export
            var actionsCells = table.querySelectorAll('tbody td:last-child');
            actionsCells.forEach(function(cell) {
                cell.classList.add('hide-for-pdf');
            });

            var opt = {
                margin: 0.5,
                filename: 'tabla_pdf.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(table).save();

            // Remove the added class after PDF export
            actionsCells.forEach(function(cell) {
                cell.classList.remove('hide-for-pdf');
            });
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
         
    </script>
    
    <!-- Actualizar usuario -->
    



    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script></body>
    
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    
    <script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar que los campos no estén vacíos
    if (empty($_POST["usuario"]) || empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["tipo"]) || empty($_POST["disciplina"]) || empty($_POST["universidad"])) {
        echo '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Campos incompletos",
                    text: "Por favor, completa todos los campos del formulario.",
                });
            </script>';
    } else {

    // Conexión a la base de datos (reemplaza con tus propios valores)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "endcut";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recuperar datos del formulario
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $tipo = $_POST["tipo"];
    $disciplina = $_POST["disciplina"];
    $universidad = $_POST["universidad"];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO usuarios (usuario, email, pass, tipo, disciplina, universidad)
            VALUES ('$usuario', '$email', '$pass', '$tipo', '$disciplina', '$universidad')";

    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, mostrar alerta de SweetAlert
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "El usuario se ha registrado correctamente.",
                }).then(function() {
                    window.location.href = "usuarios.php"; // Redirigir a la página de usuarios
                });
            </script>';
    } else {
        // Error al registrar, mostrar alerta de SweetAlert
        echo '<script>
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