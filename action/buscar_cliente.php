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


function searchString($texto,$cadena){
	if (preg_match("/".$cadena."/", $texto)){
		return true;
	}else{
		return false;
	}
}

if ($_POST['criterio'] == ""){
	echo "Ingrese un criterio de busqueda";
}else{

$message = $_POST['criterio'];


if ($API->connect(IP_MIKROTIK, USER, PASS)) {
		   $API->write("/log/getall");
		   $API->write('/cancel',false);
		   $READ = $API->read(false);
		   $ARRAY = $API->parse_response($READ);
		   //print_r($ARRAY);
		   echo "<br />";
		   	if(count($ARRAY)>0){
		   		for($x=0;$x<=count($ARRAY);$x++){ //Clasifico errores del Log.
		   			if (preg_match("/".$message."/i", $ARRAY[$x]["message"])) {
		   				if(searchString($ARRAY[$x]["message"],"authentication failed")){
		   					echo "<p><strong>".$ARRAY[$x]["time"]. "</strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;" . 
		   					$ARRAY[$x]["message"],"authentication failed"."</p>";
		   				}else{
		   					echo "<p><strong>".$ARRAY[$x]["time"]. "</strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; <span style=\"color:#666;\">" . 
		   					$ARRAY[$x]["message"]."</span></p>";
		   				}
		   			}
		   		}
			}
}else{
	echo "No hay conexion";
}
}
?>