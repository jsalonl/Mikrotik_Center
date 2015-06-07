<?php

/*
Variables de Conexion Mikrotik
 */
define('USER', 'tu_usuario'); //Usuario Mikrotik --> Debe tener todos los permisos para en sistema para aprovisionar planes PPPoE
define('PASS', 'tu_password'); //Password Usuario --> Caracteres especiales para mayor complejidad
define('IP_MIKROTIK', 'tu_ip'); //IP Publica o Privada para establecer la conexion

/*
Variables de Identidad
 */
$Identidad_Mikrotik = "Mikrotik Villavicencio"; //nombre de tu mikrotik (para identificar)
$Marca_Licenciada = "WiFiColombia"; //Tu nombre de marca
$copyright = "Servicios Corporativos en Telecomunicaciones S.A.S. E.S.P. &copy; <br>".date('Y')." Todos los derechos reservados"; //tu copyright en caso de cambio
$Autor = "Joan Salom&oacute;n Nieto L&oacute;pez"; // Autor
/*
Variables de Conexion MySQL por defecto
Usuario de ingreso es 1121892890 y contraseña salonl
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'usuariodb');
define('DB_PASS', '41325800');
define('DB_DB', 'gestionmk');
$conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
?>