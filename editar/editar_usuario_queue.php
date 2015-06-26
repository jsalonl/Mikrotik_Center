<?php
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
require("../../../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
include("../layouts/menu.php");
require('../apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
?>
<!DOCTYPE html>
<html lang="es">
    <head>        
        <!-- META SECTION -->
        <meta name="description" content="SISTEMA DE GESTION - WIFICOLOMBIA">
        <title>Sistema de Gesti&oacute;n <?php echo $Identidad_Mikrotik ;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="<?php echo $Autor ?>">
        
        <link rel="icon" href="../favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="../css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <?php if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;?>
             <?= $menu; ?>
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>   
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                   
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Edici&oacute;n Usuarios</a></li>
                    <li><a href="#">Usuarios Queue Simple</a></li>
                </ul>
                <!-- END BREADCRUMB -->
                
                    <div class="page-title">
                        <h2 style="margin: 20px;">Informaci&oacute;n General</h2>
                    </div>

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <div class="row"><!-- Inicia Fila Row -->
                	<div class="col-md-5">
                		<form role="form" id="Get_Info" action="../action/get_clients_queue.php" method="POST">
                			<div class="form-horizontal">
                			<div class="form-group"><!-- Inicia Grupo Control -->
                				<label class="col-md-4 control-label">Escoja el Usuario</label>
                				<div class="col-md-8"><!--Inicia Columna md-8-->
                				<select name="Usuario" id="Usuario" class="control-select select-definido">
		                                        <!-- Traemos los Usuarios de los Queues y los imprimimos en cada option -->
		                                        <?php
		                                                    $API->write("/queue/simple/getall",true);   
		                                                    $READ = $API->read(false);
		                                                    $ARRAY = $API->parse_response($READ);
		                                                    if(count($ARRAY)>0){   // si hay mas de 1 queue.
		                                                        for($x=0;$x<count($ARRAY);$x++){
		                                                            $name = sanear_string($ARRAY[$x]['name']);
		                                                            $id_umkt = ($ARRAY[$x]['.id']);
		                                                            $datos_queue = "<option value='$id_umkt'>".$name."</option>";
		                                                            echo $datos_queue;
		                                                            //var_dump($ARRAY);
		                                                        }
		                                                        }else{ // si no hay ningun binding
		                                                            echo "<option value=''>No hay ningún usuario en Queue Simple</option>";
		                                                        }
		                                                    ?>
		                                        <!-- -->
                                        		</select>
                                        		</div><!-- Termina  Columna md-8-->
                                        	</div><!-- Termina Grupo Control -->
                                        	</div>
                                        </form>
                            </div>
                        </div><!-- Termina Fila Row -->

                        <div class="row" id="Info_Form"> <!-- Inicia Preloader de Formulario -->
                        </div> <!-- Termina Preloader de Formulario -->

                        	<!-- Formulario-->
		<div class="row" id="Get_Form"><!-- Inicia Fila Row-->
		<div class="block">
			<h3 style="text-align: center; color:#13B21B">Datos Actuales</h3>
			<br>
			<div class="col-md-5"><!-- Inicio Columna md-5 -->
			<form role="form" id="DatosTraidos"  method="POST">
			<div class="form-horizontal"><!-- Inicia Div Formulario Horizontal-->
				<div class="form-group">
					<label class="col-md-4 control-label">Usuario Actual</label>
					<div class="col-md-8">
					<input type="text" class="form-control" name="actual_user" id="actual_user" readonly="yes">
					</div>
				</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Plan Actual</label>
				<div class="col-md-8">
				<input type="text" name="plan_actual" id="plan_actual" class="form-control" readonly="yes">
				</div>
			</div>
			</div><!--  Div Formulario Horizontal -->
			</div><!-- Termina Columna md-5 -->
			<div class="col-md-5"> <!-- Inicio Columna md-5-->
			<div class="form-horizontal"><!-- Inicio Div formulario Horizontal -->
				<div class="form-group"> <!-- Inicio Grupo Control -->
					<label class="col-md-4 control-label">Direcci&oacute;n IP</label>
					<div class="col-md-8">
					<input type="text" class="form-control" name="target_actual" id="target_actual" readonly="yes">
					</div>
				</div> <!-- Termina Grupo Control -->
				<div class="form-group"> <!-- Inicia Grupo Control -->
					<label class="col-md-4 control-label">Tasa Descarga Actual</label>
					<div class="col-md-8">
					<input type="text" class="form-control Kbytes" id="download_actual" readonly="yes">
					</div>
				</div> <!-- Termina Grupo Control -->
				<div class="form-group">
				<label class="col-md-8 control-label">&iquest;Editar Valores?</label>
					<div class="col-md-2">
					<label class="switch">
						<input type="checkbox" id="Editar_Valores" >
						<span></span>
					</label>
					</div>
				</div>
			</div><!-- Termina Div Formulario Horizontal-->
			</div><!-- Termina Columna md-5 -->
			</form>
		</div>
		</div><!-- Termina Fila Row -->
		<!-- Termina Formulario -->
                                    <div class="row" id="Edicion_Queues"><!-- Inicia Fila Row Formulario De Edicion-->
                                    <form id="Editar_Queue">
                                    <h3 style="text-align: center; color:#13B21B">Formulario de edicion</h3>
                                    <br>
                                    <div class="col-md-5">
                                    <div class="form-horizontal">
                                    		<input type="hidden" name="ID_Usuario_MKT" id="ID_Usuario_MKT">
	                                    <div class="form-group">
	                                    		<label class="col-md-4 control-label">Nombre</label>
	                                    		<div class="col-md-8">
	                                    		<input type="text" id="edit_name" name="edit_name" class="form-control" placeholder="Nombre Completo de Cliente">
	                                        </div>
	                                    </div>
	                                    <div class="form-group">
	                                    		<label class="col-md-4 control-label">Tasa de descarga</label>
	                                    		<div class="col-md-8">
	                                    		<input type="text" name="edit_download" id="edit_download" class="form-control Kbytes" placeholder="">
	                                    		</div>
	                                    </div>
	                                    <div class="form-group">
	                                    		<label class="col-md-4 control-label">Nueva IP</label>
	                                    		<div class="col-md-8">
	                                    		<input type="text" name="edit_download" id="edit_download" class="form-control" placeholder="Nueva IP">
	                                        </div>
	                                    </div>
                                    </div>
                                    </div>	

                                    <div class="col-md-5">
                                    <div class="form-horizontal">
                                    		<div class="form-group">
                                    			<label class="col-md-4 control-label">Nuevo Identificacion</label>
                                    			<div class="col-md-8">
                                    			<input type="text" name="edit_no_id" id="edit_no_id" class="form-control" placeholder="Ingrese n&uacute;mero identificaci&oacute;n">
                                        		</div>
                                        	</div>
                                        	<div class="form-group">
                                        	<label class="col-md-4 control-label">Plan Nuevo</label>
                                        	<div class="col-md-8">
                                        		<select name="edit_Segmento" id="edit_Segmento" class="control-select select">
                                        			<option value="8/8">Residencial</option>
                                        			<option value="6/6">Comercial</option>
                                        			<option value="4/4">Corporativo</option>
                                        			<option value="1/1">Dedicado</option>
                                        		</select>
                                        	</div>
                                        	</div>
                                        	<div class="form-group">
                                    			<label class="col-md-4 control-label">Nombre de Usuario</label>
                                    			<div class="col-md-8">
                                    			<input type="text" name="edit_user" id="edit_user" class="form-control" placeholder="Ingrese n&uacute;mero identificaci&oacute;n">
                                        		</div>
                                        	</div>
                                        	
                                    </div>
                                    </div>
                                    </form>
                                    </div> <!-- Termina Formulario de edicion-->
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
            <?php
    }else{
        echo "No hay conexion";
    }

?>
        </div>
        <!-- END PAGE CONTAINER -->
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out">&iquest;</span>Cerrar <strong>Sesi&oacute;n</strong> ?</div>
                    <div class="mb-content">
                        <p>&iquest;Esta seguro que desea salir?</p>
                        <p>Presione No si desea continuar trabajando. Presione Si para salir del sistema de forma segura.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?=$salir;?>" class="btn btn-success btn-lg">Si</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
        <!-- START PRELOADS -->
        <audio id="audio-alert" src="../audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="../audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->             
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>                
        <!-- END PLUGINS -->
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='../js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="../js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="../js/plugins.js"></script>        
        <script type="text/javascript" src="../js/actions.js"></script>        
        <!-- END TEMPLATE -->
        <script type="text/javascript">
            jQuery(document).ready(function() {
            	$("#Get_Form").hide();
            	$("#Edicion_Queues").hide();
            	$('#edit_no_id').blur(function(){
            		var user_name = $('#edit_name').val();
            		var user = user_name.replace(/\s+/g, '');
            		var user_id = $('#edit_no_id').val();
            		$('#edit_user').val(user_id+"-"+user);
            	});
            	$("#Usuario").change(function(){
            	var dato_usuario = $('#Usuario').val(); // Tomamos el ID del campo Usuario para ejecutar la consulta
            	//Ejecutamos la consulta por medio de Ajax
            		$.ajax({
            			type: "POST",
                        		url: '../action/get_clients_queue.php',
                        		data: "Usuario="+dato_usuario, //
                        		dataType: "JSON",
                        		success: function(data){
	                        		$("#Get_Form").fadeIn();
	                       		$("#Info_Form").hide();
	                       		if(data[0].Canal=="1/1" || data[0].Canal=="2/2"){
	                       			var canal = "Dedicado";
	                       		}else if (data[0].Canal=="4/4" || data[0].Canal=="3/3"){
	                       			var canal = "Corporativo";
	                       		}else if (data[0].Canal=="6/6"){
	                       			var canal = "Comercial";
	                       		}else if (data[0].Canal=="8/8"){
	                       			var canal = "Residencial";
	                       		}else{
	                       			var canal = "Pruebas";
	                       		}
	                       		$("#actual_user").val(data[0].nombre);
	                       		var arr = (data[0].BW).split('/'); //Separamos Carga y Descarga
	                       		var ip_actual = (data[0].IP).replace('/32',''); //Remplazamos la mascara 32 para solo imprimir la IP
	                       		var descarga = Math.round((arr[1]/1024));
	                       		$("#download_actual").val(descarga + "K"); //Traemos Solo valor de descarga
	                       		$("#plan_actual").val(canal);
	                       		$("#target_actual").val(ip_actual);
	                       		$("#ID_Usuario_MKT").val(dato_usuario);
                                },
                                beforeSend:function(){
                                    $("#Info_Form").html('<i class="fa fa-spinner fa-spin"></i> Enviando datos, por favor espere');
                                },
                                error: function(data){
                                    console.log("error"+data);
                                }
                    });
            		//Evitamos cambios en el formulario
            		return false;
                    });
    $("Edicion_Queues").submit(function(){
        
    });
	$('.Kbytes').blur(function(){
		if( this.value.indexOf('K') == -1 ){
			this.value = this.value + 'K';
		}
	});
	$("#Editar_Valores").click(function(){
		var check_editar = $("#Editar_Valores").prop('checked', true);
		if(check_editar){
			$("#Edicion_Queues").fadeIn();
		}else{
			$("#Edicion_Queues").fadeOut();
		}
	});
	$('#Notificacion').click(function(){
		$(this).fadeOut();
	});
	});
        </script>
    <!-- END SCRIPTS -->                  
    <!-- Notificacion --> 
    <ul id="Notificacion">
    <li>
    <div class="info_noty">
    <span class="noty_text"></span></div></li></ul>
    </body>
</html>