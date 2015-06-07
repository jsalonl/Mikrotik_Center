<?php 
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
require("../../../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
require('../apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
if ($API->connect(IP_MIKROTIK, USER, PASS)) {
    //Creacion de Queues Simples
    $name = $_POST["name"];
    $identificacion = $_POST["no_id"];
    $user = $_POST["user"];
    $target = $_POST["target"];
    $download = trim($_POST["Download"], 'K');
    $prioridad = $_POST["Segmento"];
    if ($name == "") {
        echo "Nombre no puede estar vac&iacute;o";
    } elseif ($identificacion == ""){
        echo "Debe ingresar un n&uacute;mero de documento";
    } elseif (!filter_var($target, FILTER_VALIDATE_IP)){
        echo "Debe ingresar una IP V&aacute;lida";
    }else{
    if ($prioridad == "1/1") {
        $uploadCalculado = 1;
    }elseif ($prioridad == "4/4") {
        $uploadCalculado = 0.75;
    }elseif ($prioridad == "6/6") {
        $uploadCalculado = 0.50;
    }
    elseif ($prioridad == "8/8") {
        $uploadCalculado = 0.25;
    }
    $mask = "/32";
    $upload = ($download*$uploadCalculado);
    $bytesUpload = ($upload*1024);
    $bytesDownload = ($download*1024);
    $total_canal = $bytesUpload."/".$bytesDownload;
    $insertar = "1";
            $API->write("/queue/simple/getall",false);
           $API->write("?target=".$target.$mask,true);
           $READ = $API->read(false);
           $ARRAY = $API->parse_response($READ);
            if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
                    echo "Error: La IP No puede estar repetida.";
                }else{
                    $API->write("/queue/simple/add",false);
                    $API->write("=name=".$user,false);
                    $API->write("=target=".$target,false);
                    $API->write("=max-limit=".$total_canal,false);
                    $API->write("=limit-at=".$total_canal,false);
                    $API->write("=priority=".$prioridad,false);
                    $API->write("=place-before=".$insertar,true);
                    $READ = $API->read(false);
                    echo("1");
                }
    }
}else{
        echo "No hay conexion";
    }
?>