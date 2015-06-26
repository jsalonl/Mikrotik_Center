<?php 
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
sleep(1);
require("../../../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
require('../apimikrotik.php');
$API = new routeros_api();
$API->debug = false;

$arrayResponse = array();

$ID_User = $_POST['Usuario'];
//$ID_User = "*46BF";

if ($API->connect(IP_MIKROTIK, USER, PASS)) {
	$API->write("/queue/simple/getall",false);
	$API->write('?.id='.$ID_User,true);
	$READ = $API->read(false);
	$ARRAY = $API->parse_response($READ);
	if(count($ARRAY)>0){ //Buscamos el valor ingresado en el POST
		for($x=0;$x<count($ARRAY);$x++){
			$name=sanear_string($ARRAY[$x]['name']);
			$target = sanear_string($ARRAY[$x]['target']);
			$priority = $ARRAY[$x]['priority'];
			$limit_at = $ARRAY[$x]['limit-at'];
			$arrayResponse[] = array("status" => "successful", "mensaje" => "Exitoso",
			"nombre" => "$name", "IP" => "$target", "Canal" => "$priority", "BW" => "$limit_at");
		}
	}else{ // si no hay ningun binding
		$arrayResponse[] = array("status" => "error", "mensaje" => "No existen registros con este ID");
	}
}else{
	$arrayResponse[] = array("status" => "error", "mensaje" => "No hay conexi&oacute;n Con MKT");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($arrayResponse);

//var_dump($arrayResponse);
?>