<?php
sleep(1);
include("../../../includes/variables.php");
session_start();
if ($_POST['Usuario']=="") {
    echo "Usuario no puede estar vac&iacute;o";
}elseif ($_POST['Password'] == ""){
    echo "Password no puede estar vac&iacute;o";
} else {

if(isset($_POST['Usuario']) && isset($_POST['Password']))
{
// username and password sent from Form
$username=mysqli_real_escape_string($conexiondb,$_POST['Usuario']); 
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
echo "Autenticado";
}else{
    echo "No existe usuario";
}
}
}
?>