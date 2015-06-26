<?php
include("../../includes/variables.php");
?>
<!DOCTYPE html>
<html lang="es" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Sistema de Gesti&oacute;n <?php echo $Identidad_Mikrotik ;?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="<?php echo $Autor ?>">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <!--<div class="login-logo"></div>-->
                <div class="login-body" id="caja-form">
                    <div class="login-title"><strong>Bienvenido</strong>, Por favor ingrese</div>
                    <div class="login-title" id="info"></div>
                    <form action="action/control.php" class="form-horizontal" method="post" id="Validacion">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="Usuario" id="Usuario" placeholder="Usuario"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="Password" id="Password" placeholder="Contrase&ntilde;a"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <select name="mikrotik" id="mikrotik" class="form-control">
                                <option value="">Mikrotik a Gestionar</option>
                                <?php
                                $conexionbase = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
                                $consulta = "SELECT * FROM mikrotiks";
                                $extraer = $conexionbase->query($consulta);
                                while ($fila = $extraer->fetch_array())
                                {
                                    $id_mkt = $fila['id_mkt'];
                                    $nombre_mkt = $fila['nombre_mkt'];
                                    echo "<option value='$id_mkt'>".$nombre_mkt."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block">Ingresar</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        <p><?php echo $copyright ;?></p>
                    </div>
                    <div class="pull-right">
                        <a href="#">Acuerdo Privacidad</a>
                    </div>
                </div>
            </div>
            
        </div>
            <!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
            <!-- END PLUGINS --> 
            <script type="text/javascript">
                $(document).ready(function(){
                   $("#Validacion").submit(function(){
                        usuario=$("#Usuario").val();
                        password=$("#Password").val();
                        mikrotik=$("#mikrotik").val();
                         $.ajax({
                            type: "POST",
                            url: "action/control.php",
                            data: $("#Validacion").serialize(),
                            success: function(html){
                              if(html=='Autenticado')
                              {
                                $("body").load("inicio.php").hide().fadeIn(1500).delay(6000);
                              }
                              else
                              {
                                    $("#caja-form").effect( "shake", {times:3}, 600);
                                    $("#info").html('<span class="span-error">' + html + '</span>');
                              }
                            },
                            beforeSend:function()
                            {
                                 $("#info").html('<i class="fa fa-spinner fa-spin"></i>Espere')
                            }
                        });
                         return false;
                    });
                });
</script>
    </body>
</html>