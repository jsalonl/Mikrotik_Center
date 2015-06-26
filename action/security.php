<?php
/*
Control de seguridad para visualizacion de módulos
 */
//Tomamos el ID De la sesión iniciada
$id = $_SESSION['ID']; 
//Consultamos el ID de la sesion para que concuerde con los datos en la BD
$result=mysqli_query($conexiondb,"SELECT * FROM usuarios WHERE ID=".$id.";"); 
$count=mysqli_num_rows($result);
//ejecutamos la sentencia para traer los datos
$res=mysqli_fetch_array($result,MYSQLI_ASSOC);
//asignamos las variables desde la BD
$nombre = $res['Nombre']; 
$email = $res['Email']; 
$telefono = $res['Telefono']; 
$identificacion = $res['Identificacion']; 
 //Traemos el nivel de acceso desde la base de datos
$nivel_acceso = $res['Nivel_Acceso']; 
//Ejecutamos el control de acceso, asignando a cada valor un perfil, el mas alto es 1 y disminuye sucesivamente
if ($nivel_acceso=="1") {
	$privilegio = "NOC";
} elseif ($nivel_acceso=="2") {
	$privilegio = "Ejecutivo";
} elseif ($nivel_acceso=="3") {
	$privilegio = "Comercial";
} elseif ($nivel_acceso=="4") {
	$privilegio = "SAC";
} elseif ($nivel_acceso=="5") {
	$privilegio = "Tecnico";
}else{
	$privilegio = "Tercerizados";
}
//Parametro para que solo se visualicen los modulos contenidos dentro de la funcion
$solo_NOC=($privilegio=="NOC");
//
$solo_ejecutivo=($privilegio=="Ejecutivo");
//
$solo_comercial=($privilegio=="Comercial");
//
$solo_tecnico=($privilegio=="Tecnico");
//
$solo_SAC=($privilegio=="SAC");
//
$solo_tercerizados=($privilegio=="Tercerizados");
//Cerramos la conexión con la Base de datos
mysqli_close($conexiondb);

$id_mkt = $_SESSION['id_mkt'];
//Consultamos el ID de la sesion para que concuerde con los datos en la BD
$conexiondbmkt = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
$resultado=mysqli_query($conexiondbmkt,"SELECT * FROM mikrotiks WHERE id_mkt=".$id_mkt.";"); 
$conteo=mysqli_num_rows($resultado);
//ejecutamos la sentencia para traer los datos
$ref=mysqli_fetch_array($resultado,MYSQLI_ASSOC);
//asignamos las variables desde la BD
$nombre_mkt = $ref['nombre_mkt']; 
?>