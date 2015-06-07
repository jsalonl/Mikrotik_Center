<?php
$usuario = "Usuario";
$rol = "Comercial";
include("../../../includes/variables.php");
include("../layouts/menu.php");
require('../apimikrotik.php');
require('../functions/funciones.php');
$API = new routeros_api();
$API->debug = false;
$plan = $_REQUEST['plan'];
if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;
	$API->write("/tool/user-manager/user/getall",false);
            	$API->write('?name='.$plan,true);
	$READ = $API->read(false);
	$ARRAY = $API->parse_response($READ);
		if(count($ARRAY)>0){   // si hay mas de 1 queue.
			for($x=0;$x<count($ARRAY);$x++){
			//$precio = $ARRAY[$x]['price'];
			$price = $ARRAY[$x]['price'];
			echo $price;
			}
		}else{ // si no hay ningun binding
			echo "No hay Ningun Plan.";
		}
}else{
        echo "No hay conexion";
}