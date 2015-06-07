<?php

/*
Variables de Conexion Mikrotik
 */
define('USER', 'APIRestWFC'); //Usuario Mikrotik --> Debe tener todos los permisos para en sistema para aprovisionar planes PPPoE
define('PASS', 'WFC2015*!'); //Password Usuario --> Caracteres especiales para mayor complejidad
define('IP_MIKROTIK', '181.48.138.242'); //IP Publica o Privada para establecer la conexion

/*
Variables de Identidad
 */
$Identidad_Mikrotik = "Mikrotik Villavicencio";
$Marca_Licenciada = "WiFiColombia";
$copyright = "Servicios Corporativos en Telecomunicaciones S.A.S. E.S.P. &copy; <br>".date('Y')." Todos los derechos reservados";
$Autor = "Joan Salom&oacute;n Nieto L&oacute;pez";
/*
Variables de Conexion MySQL
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'usuariodb');
define('DB_PASS', '41325800');
define('DB_DB', 'gestionmk');
$conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
?>