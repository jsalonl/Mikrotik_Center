<?php
$usuario = "Usuario";
$rol = "Comercial";
include("../../includes/variables.php");
include("layouts/menu.php");
require('apimikrotik.php');
require('functions/funciones.php');
$API = new routeros_api();
$API->debug = false;
?>
<!doctype html>
<html lang="es" ng-app>
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
            <h1>Interfaces</h1>
            <h2>Resumen de Interfaces</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Información General</h2>
            <hr>
            <form class="pure-form pure-form-stacked" id="Crear_Cliente_Queue" action="action/Procesos_Queue.php" method="POST">
                <fieldset>
                    <label for="name">Nombre Cliente</label>
                    <input name="name" id="name" type="text">
                    <label for="target">Dirección IP</label>
                    <input name="target" id="target" type="text">
                    <label for="Download">Velocidad Descarga</label>
                    <input name="Download" id="Download" type="text" class="Kbytes">
                    <!--
                    <label for="Upload">Velocidad Subida</label>
                    <input name="Upload" id="Upload" type="text" class="Kbytes">
                    -->
                    <label for="Segmento">Segmento</label>
                    <select name="Segmento">
                        <option value="8/8">Residencial</option>
                        <option value="6/6">Comercial</option>
                        <option value="4/4">Corporativo</option>
                        <option value="1/1">Dedicado</option>
                    </select>
                    <button type="submit" class="pure-button pure-button-primary">Sign in</button>
                </fieldset>
            </form>
        </div>
    </div>
    <?php
    }else{
        echo "No hay conexion";
    }

?>
</div>
<!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
            <!-- END PLUGINS -->  
<script type="text/javascript">
    jQuery(document).ready(function() {
        $('.Kbytes').blur(function(){
                if( this.value.indexOf('K') == -1 ){
                this.value = this.value + 'K';
                }
            });
        $("#Crear_Cliente_Queue").submit(function(){
            $.ajax({
               type: "POST",
               url: 'action/Procesos_Queue.php',
               data: $("#Crear_Cliente_Queue").serialize(), // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                   alert(data); // Mostrar la respuestas del script PHP.
                   $("#Crear_Cliente_Queue input").val("");
               }
            });
            return false;
        });
    });
</script>
</body>
</html>
