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
$disci = $_SESSION['disc'];

// Realiza la consulta SQL para obtener todos los registros
$sql = "SELECT * FROM documentos WHERE disciplina = '" . $_SESSION['disc'] . "';";
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
$sqlPaginacion = "SELECT * FROM documentos WHERE disciplina = '" . $_SESSION['disc'] . "' LIMIT $indiceInicio, $registrosPorPagina";
$resultPaginacion = $conn->query($sqlPaginacion);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ENDCUT DURANGO 2024</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="logo_chico.png" />
    <script src="js/ocultar.js"></script>
    <script src="js/confirmar_delete.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
      }
      
      .dashboard {
        display: flex;
      }
  
      .dash-table {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        z-index: -1; /* Colocar detrás de la barra lateral */
        margin-top: -90px;
      }
      
      .dash-row {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
      }

      .dash-card {
        background-color:#e4e4e4;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        color: #62a046;
        text-align: center;
  
        background: rgba(190, 190, 190, 0.288);
          box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
          backdrop-filter: blur( 6px );
          -webkit-backdrop-filter: blur( 6px );
          border-radius: 10px;
          border: 2px solid rgba( 255, 255, 255, 0.18 );

          margin-bottom: 20px;
          text-align: center;
      }
      
      .dash-card label {
        display: block;
        cursor: pointer;
      }
  
      .dash-card input[type="file"] {
        display: none;
      }
  
      .dash-card p {
        text-align: center;
        margin-top: 5px;
      }

      .dash-card:hover{
          box-shadow: 0px 7px 16px -7px #601e5f;
          background-color:#761875;   
          cursor: pointer;
      }
      
      .dash-card i {
        font-size: 24px;
        color: #62a046; /* Mantén el color del ícono en el estado normal */
      }
  
      .dash-card h5 {
        color: #62a046; /* Mantén el color del texto en el estado normal */
      }
  
      .dash-card:hover i,
      .dash-card:hover h5,
      .dash-card:hover p{
        color: #fff; /* Cambia el color del ícono y el texto en el hover */
      }
      input{
        margin-top: -90px;
      }
      /* Estilos específicos para pantallas pequeñas */
        @media (max-width: 768px) {
        #disciplina {
            font-size: 14px; /* Tamaño de fuente más pequeño */
            padding: 10px; /* Espaciado interno */
        }
        p {
            font-size: 10px; /* Tamaño de fuente más pequeño */
        }
        }
  </style>
<body>
    <!-- partial:index.partial.html -->
    <div class="header"><h2 style="margin-left: 4%;margin-top: 1%; color: #fff" class="end">ENDCUT DURANGO 2024&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['username']; ?></h2></div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
    </label>
    
    <div id="sidebarMenu" style="z-index: 1;">
    <ul class="sidebarMenuInner">
            <li>
                <img src="logo_normal.jpg" width="90%" style="margin: 15px 0px 15px;"><br>
            </li>
            <li><a href="../../index.php">Inicio</a></li>
            <li><a href="../participantes/participantes.php">Participantes</a></li>
            <li><a href="../universidades/universidades.php">Universidades</a></li>
            <li><a href="../entrenadores/entrenadores.php">Entrenadores</a></li>
            <li><a href="../coordinadores/coordinadores.php">Coordinadores</a></li>
            <li><a href="../asistentes/asistentes.php">Asistentes</a></li>
            <li><a href="../medicos/medicos.php">Médicos</a></li>
            <li><a href="../staff/staff.php">Staff</a></li>
            <li><a href="#">Documentos</a></li>
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
                    <h1 style="font-weight:bold; font-size:4vmin; text-align:center;">Inicio / Documentos</h1>
                    <table>
                        <tr>
                            <td><img src="line6.png" alt="line" style="width: 101%;"></td>
                        </tr>
                    </table> <br><br>
                    <form method="POST" enctype="multipart/form-data" action="upload.php">
                    <center><label>Disciplina predeterminda</label><br></center>
                    <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
                        <input type="text" name="disciplina" id="dis" readonly="readonly" value="<?php echo $disci; ?>" style="flex: 1; margin-right: 10px;">
                        <button class="AddButtonv4" type="submit" style="margin-top: 40px;">Subir</button>
                    </div>

                    <div class="dash-table">
                        <div class="dash-card" id="kardex" style="display: none;">
                            <label for="pdfInput" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir Kardex</h5>
                            </label>
                            <input type="file" id="pdfInput" name="kardex" accept=".pdf">
                            <p id="documentStatus"></p>
                        </div>
                    
                        <div class="dash-card" id="curp" style="display: none;">
                            <label for="pdfInput2" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir Curp</h5>
                            </label>
                            <input type="file" id="pdfInput2" name="curp" accept=".pdf">
                            <p id="documentStatus2"></p>
                        </div>
                    
                        <div class="dash-card" id="cedula" style="display: none;">
                            <label for="pdfInput3" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir Cedula</h5>
                            </label>
                            <input type="file" id="pdfInput3" name="cedula" accept=".pdf">
                            <p id="documentStatus3"></p>
                        </div>
                        
                          <div class="dash-card" id="nss" style="display: none;">
                            <label for="pdfInput4" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir NSS</h5>
                            </label>
                            <input type="file" id="pdfInput4" name="nss" accept=".pdf">
                            <p id="documentStatus4"></p>
                        </div>
                        
                          <div class="dash-card" id="anexos" style="display: none;">
                            <label for="pdfInput5" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir Anexos</h5>
                            </label>
                            <input type="file" id="pdfInput5" name="anexos" accept=".pdf">
                            <p id="documentStatus5"></p>
                        </div>

                          <div class="dash-card" id="ficha" style="display: none;">
                            <label for="pdfInput6" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir ficha de registro</h5>
                            </label>
                            <input type="file" id="pdfInput6" name="registro" accept=".pdf">
                            <p id="documentStatus6"></p>
                        </div>

                        <div class="dash-card" id="certificado" style="display: none;">
                          <label for="pdfInput7" style="cursor: pointer;">
                              <i class="fa fa-upload"></i>
                              <h5>Subir Certificado</h5>
                          </label>
                          <input type="file" id="pdfInput7" name="certificado" accept=".pdf">
                          <p id="documentStatus7"></p>
                      </div>

                      <div class="dash-card" id="monografia" style="display: none;">
                        <label for="pdfInput8" style="cursor: pointer;">
                            <i class="fa fa-upload"></i>
                            <h5>Subir Monografía</h5>
                        </label>
                        <input type="file" id="pdfInput8" name="monografia" accept=".pdf">
                        <p id="documentStatus8"></p>
                    </div>

                        <div class="dash-card" id="audio" style="display: none;">
                            <label for="audioInput" style="cursor: pointer;">
                                <i class="fa fa-upload"></i>
                                <h5>Subir Audio</h5>
                            </label>
                            <input type="file" id="audioInput" name="cancion" accept="audio/*">
                            <p id="audioStatus"></p>
                        </div>
                    </div>
                    </form>
                    <br>
                    <table class="TableDesign" id="miTabla">
                            <thead>
                                <tr>
                                    <th>Disciplina</th>
                                    <th>Kardex</th>
                                    <th>Curp</th>
                                    <th>Cedula</th>
                                    <th>Nss</th>
                                    <?php if ($_SESSION['disc'] == 'Oratoria') { ?>
                                    <th>Anexos</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['disc'] == 'Ajedrez') { ?>
                                    <th>Ficha de registro</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['disc'] == 'Taekwondo') { ?>
                                    <th>Certificado</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['disc'] == 'Danza') { ?>
                                    <th>Monografía</th>
                                    <?php } ?>
                                    <?php if (($_SESSION['disc'] == 'Danza') || ($_SESSION['disc'] == 'Canto')){ ?>
                                    <th>Canción</th>
                                    <?php } ?>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $resultPaginacion->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['disciplina']; ?></td>
                                      
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['kardex']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>

                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['curp']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>

                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['cedula']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>

                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['nss']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>

                                        <?php if ($_SESSION['disc'] == 'Oratoria') { ?>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['anexos']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php } ?>

                                        <?php if ($_SESSION['disc'] == 'Ajedrez') { ?>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['registro']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php } ?>
                                        
                                        <?php if ($_SESSION['disc'] == 'Taekwondo') { ?>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['certificado']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php } ?>
                                        
                                        <?php if ($_SESSION['disc'] == 'Danza') { ?>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['monografia']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php } ?>
                                        
                                        <?php if (($_SESSION['disc'] == 'Danza') || ($_SESSION['disc'] == 'Canto')){ ?>
                                        <td class="iconsDesign">
                                            <a href="#" class="previewImage" data-image="<?php echo base64_encode($row['cancion']); ?>"><i class="fa fa-upload"></i></a>
                                        </td>
                                        <?php } ?>

                                        <td class="iconsDesign">
                                            <a href="eliminar_docs.php?id=<?php echo $row['id']; ?>" class="deleteUser" data-userid="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
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
                        <br><br><br>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    window.onload = function() {
        function mostrarBotones() {
            const inputDisciplina = document.getElementById("dis");
            const disciplina = inputDisciplina.value;

            const kardex = document.getElementById("kardex");
            const curp = document.getElementById("curp");
            const cedula = document.getElementById("cedula");
            const nss = document.getElementById("nss");
            const anexos = document.getElementById("anexos");
            const ficha = document.getElementById("ficha");
            const certificado = document.getElementById("certificado");
            const monografia = document.getElementById("monografia");
            const audio = document.getElementById("audio");

            // Oculta todos los botones al principio
            [kardex, curp, cedula, nss, anexos, ficha, certificado, monografia, audio].forEach(button => {
                button.style.display = "none";
                button.removeAttribute("required");
            });

            // Mostrar botones según el valor de la disciplina
            if (
                disciplina === "Baloncesto" ||
                disciplina === "Voleibol" ||
                disciplina === "Futbol 7" ||
                disciplina === "Futbol asociacin" ||
                disciplina === "Beisbol" ||
                disciplina === "Softbol" ||
                disciplina === "Rondalla" ||
                disciplina === "Atletismo"
            ) {
                [kardex, curp, cedula, nss].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            } else if (
                disciplina === "Oratoria" ||
                disciplina === "Mural en gis" ||
                disciplina === "Declamacion"
            ) {
                [kardex, curp, cedula, nss, anexos].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            } else if (disciplina === "Ajedrez") {
                [kardex, curp, cedula, nss, ficha].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            } else if (disciplina === "Taekwondo") {
                [kardex, curp, cedula, nss, certificado].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            } else if (disciplina === "Danza") {
                [kardex, curp, cedula, nss, audio, monografia].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            } else if (disciplina === "Canto") {
                [kardex, curp, cedula, nss, audio].forEach(button => {
                    button.style.display = "block";
                    button.setAttribute("required", "true");
                });
            }
        }

        // Asignar el evento "input" al campo de entrada para que llame a la función mostrarBotones
        const inputDisciplina = document.getElementById("dis");
        inputDisciplina.addEventListener("input", mostrarBotones);

        // Llamar a mostrarBotones inicialmente para mostrar u ocultar botones en función del valor inicial del campo de entrada
        mostrarBotones();
    };

    </script>

    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script></body>
    
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    
    <script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
</html>

