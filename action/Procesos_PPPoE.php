<?php
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
sleep(1);
require("../../../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
include("../layouts/menu.php");
require('../apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
if ($API->connect(IP_MIKROTIK, USER, PASS)) {
    //Creacion Usuarios PPPoE Usermanager
    $customer = "admin";
    $name = $_POST['name'];
    $phone = $_POST['no_id'];
    $user = strtolower($_POST['user']);
    $password = $_POST['password'];
    $plan = $_POST['plan'];
    $perfil = "5 minutos";
    $comentarios = $_POST['comentarios'];
    $fecha_activacion = date('Y-m-d');
        if(isset($user) || isset($password) || isset($plan)){
            //valido nombre usuario
            $API->write("/tool/user-manager/user/getall",false);
            $API->write('?name='.$user,true);
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);
            //Crea usuario, customer y password
            if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
                echo "Error: El nombre no puede estar duplicado, el proceso no termino.";
            }else{
            $API->write("/tool/user-manager/user/add",false);
            $API->write("=customer=".$customer,false);
            $API->write("=name=".$user,false);
            $API->write("=first-name=".$name,false);
            $API->write("=phone=".$phone,false);
            $API->write("=comment="."Fecha activacion ".$fecha_activacion." - ".$comentarios,false);
            $API->write("=password=".$password,true);
            $READ = $API->read(false);
            // Final Inserción
            $creado = "si";
            if ($creado== "si") {
                // Asigna perfil
                $API->write("/tool/user-manager/user/create-and-activate-profile",false);
                $API->write("=numbers="."\"".$user."\"",false);
                $API->write("=customer=".$customer,false);
                $API->write("=profile=".$plan,true);
                $READ = $API->read(false);
                echo 1;
            } else {
                echo "No se asigno plan";
            }
            }
        }else{
            echo("Hay datos sin definir");
            $creado = "no";
        }
}else{
        echo "No hay conexion";
    }
?>