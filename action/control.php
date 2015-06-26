<?php
sleep(1);
include("../../../includes/variables.php");
session_start();
if ($_POST['Usuario']=="") {
    echo "Usuario no puede estar vac&iacute;o";
}elseif ($_POST['Password'] == ""){
    echo "Password no puede estar vac&iacute;o";
}elseif ($_POST['mikrotik'] == ""){
    echo "Seleccione un mkt";
} else {

if(isset($_POST['Usuario']) && isset($_POST['Password']))
{
// username and password sent from Form
$username=mysqli_real_escape_string($conexiondb,$_POST['Usuario']);
// username and password sent from Form
$id_mkt=$_POST['mikrotik'];
//Here converting passsword into MD5 encryption. 
$password=sha1(mysqli_real_escape_string($conexiondb,$_POST['Password'])); 

$result=mysqli_query($conexiondb,"SELECT * FROM usuarios WHERE Identificacion='$username' and Password='$password'");
$count=mysqli_num_rows($result);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
mysqli_close($conexiondb);
// If result matched $username and $password, table row  must be 1 row
if($count==1)
{
$_SESSION['Authenticated']="1";
$_SESSION['ID']=$row['ID'];
$_SESSION['Nivel_Acceso']=$row['Nivel_Acceso'];
$acceso = $_SESSION['Nivel_Acceso'];

//Consultamos ID Mkt
$conexiondbmkt = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
$consultamkt=mysqli_query($conexiondbmkt,"SELECT * FROM mikrotiks WHERE id_mkt='$id_mkt'");
$cuenta=mysqli_num_rows($consultamkt);
$filer=mysqli_fetch_array($consultamkt,MYSQLI_ASSOC);
mysqli_close($conexiondbmkt);
if($cuenta==1){
	$_SESSION['id_mkt']=$filer['id_mkt'];
	$_SESSION['nombre_mkt']=$filer['nombre_mkt'];
	echo "Autenticado";
}
//echo "Autenticado";
}else{
    echo "No existe usuario Asociado";
}
}
}
?>