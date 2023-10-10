<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login/login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ENDCUT DURANGO 2024</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="logo_chico.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
      margin: 20px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      z-index: -1; /* Colocar detrás de la barra lateral */
    }
    
    .dash-table a{
        text-decoration: none;
        color: #62a046;
    }

    .dash-card {
      background-color:#e4e4e4;
      padding: 20px;
      text-align: center;
      border-radius: 5px;

      background: rgba(190, 190, 190, 0.288);
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 6px );
        -webkit-backdrop-filter: blur( 6px );
        border-radius: 10px;
        border: 2px solid rgba( 255, 255, 255, 0.18 );
    }
    .dash-card:hover{
        box-shadow: 0px 7px 16px -7px #601e5f;
	    background-color:#761875;   
        color: #fff;
        cursor: pointer;
    }
    
    .dash-card i {
      font-size: 24px;
    }
  </style>
<body>
    <!-- partial:index.partial.html -->
    <div class="header"><h2 style="margin-left: 4%;margin-top: 1%; color: #fff">ENDCUT DURANGO 2024</h2></div>
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
            <li><a href="#">Inicio</a></li>
            <li><a href="views/participantes/participantes.php">Participantes</a></li>
            <li><a href="views/universidades/universidades.php">Universidades</a></li>
            <li><a href="views/entrenadores/entrenadores.php">Entrenadores</a></li>
            <li><a href="views/coordinadores/coordinadores.php">Coordinadores</a></li>
            <li><a href="views/asistentes/asistentes.php">Asistentes</a></li>
            <li><a href="views/medicos/medicos.php">Médicos</a></li>
            <li><a href="views/staff/staff.php">Staff</a></li>
            <li><a href="views/documentos/documentos.php">Documentos</a></li>
            <li><a href="views/usuario/usuarios.php">Usuarios</a></li>
            <li><a href="login/logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

    <div id='center' class="main center">
        <div style="margin: 10%;">
            <div className="d-flex">
                <div>
                    <h1 style="font-weight:bold; font-size:4vmin; text-align:center;">Inicio</h1>
                    <table>
                        <tr>
                            <td><img src="line6.png" alt="line"  width="100%"></td>
                        </tr>
                    </table><br>
                    
                    <div class="dash-table">
                        <a href="views/participantes/participantes.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Participantes</h5>
                            </div> 
                        </a>
                        <a href="views/entrenadores/entrenadores.php">
                            <div class="dash-card">
                                <i class="fa fa-check"></i>
                                <h5>Registro de Entrenadores</h5>
                            </div>
                        </a>
                        <a href="views/coordinadores/coordinadores.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Coordinadores</h5>
                            </div>
                        </a>
                        <a href="views/asistentes/asistentes.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Asistentes</h5>
                            </div>
                        </a>
                        <a href="views/universidades/universidades.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Universidades</h5>
                            </div>
                        </a>
                        <a href="views/medicos/medicos.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Médicos</h5>
                            </div>
                        </a>
                        <a href="views/staff/staff.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Staff</h5>
                            </div>
                        </a>
                        <a href="views/documentos/documentos.php">
                            <div class="dash-card">
                            <i class="fa fa-check"></i>
                            <h5>Registro de Documentos</h5>
                            </div>
                        </a>
                        <?php if ($_SESSION['tipo'] == 'superadmin') { ?>
                        <a href="views/usuario/usuarios.php">
                            <div class="dash-card">
                                <i class="fa fa-check"></i>
                                <h5>Registro de Usuarios</h5>
                            </div>
                        </a>
                        <?php } ?>
                      </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script></body>
    
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    
    <script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    

</html>