<?php
$rol = "Comercial";
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
                        <!--<div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        -->
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
                         $.ajax({
                            type: "POST",
                            url: "action/control.php",
                            data: "Usuario="+usuario+"&Password="+password,
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