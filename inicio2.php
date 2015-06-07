<?php
include("../../includes/variables.php");
include("layouts/menu.php");
require('apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="SISTEMA DE GESTION - WIFICOLOMBIA">
    <title>Sistema de Gesti&oacute;n <?php echo $Identidad_Mikrotik ;?></title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
</head>
<body>
<div id="layout">
<?php if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;?>
    
    <?= $menu;?>
    <div id="main">
        <div class="header">
            <h1>INICIO</h1>
            <h2>Resumen de RouterBoard</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Información del equipo</h2>
            <p>
            <?php 
            //Enviamos el comando
            $API->write("/system/identity/getall",true); 
            //Leemos la respuesta y la mandamos a una variable
            $READ = $API->read(false);
            //Parseamos el resultado (Lo hacemos facil de leer)
            $ARRAY = $API->parse_response($READ);
            //Consulta del estado de la interfaz
            ?>
                <table class="pure-table">
                    <thead>
                        <tr>
                            <th>Nombre Equipo</th>
                            <th>Modelo</th>
                            <th>Serial</th>
                            <th>CPU</th>
                            <th>Temperatura</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><?= $ARRAY[0]['name'];?></td>
            <?php 
            //Enviamos el comando
            $API->write("/system/routerboard/getall",true); 
            //Leemos la respuesta y la mandamos a una variable
            $READ = $API->read(false);
            //Parseamos el resultado (Lo hacemos facil de leer)
            $ARRAY = $API->parse_response($READ);
            ?>
                            <td><?= $ARRAY[0]['model']?></td>
                            <td><?= $ARRAY[0]['serial-number']?></td>
            <?php 
            //Enviamos el comando
            $API->write("/system/resource/getall",true); 
            //Leemos la respuesta y la mandamos a una variable
            $READ = $API->read(false);
            //Parseamos el resultado (Lo hacemos facil de leer)
            $ARRAY = $API->parse_response($READ);
            ?>
                            <td><?= $ARRAY[0]['cpu-load']."%";?></td>
            <?php 
            //Enviamos el comando
            $API->write("/system/health/getall",true); 
            //Leemos la respuesta y la mandamos a una variable
            $READ = $API->read(false);
            //Parseamos el resultado (Lo hacemos facil de leer)
            $ARRAY = $API->parse_response($READ);
            ?>
                            <td><?= $ARRAY[0]['cpu-temperature']."&ordm;C";?></td>
                        </tr>
                    </tbody>
                </table>
            </p>

        </div>
    </div>
    <?php
    }else{
        echo "No hay conexion";
    }

?>
</div>
<script src="js/ui.js"></script>
</body>
</html>
