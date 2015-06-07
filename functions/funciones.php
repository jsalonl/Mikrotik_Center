<?php
function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('<', '>',),
        array('', '',),
        $string
    );
  return $string;
}

function sanear_mac($mac){
	$mac = trim($mac);

	$mac = str_replace(
		array('','0.0.0.0','null'),
		array('00:00:00:00:00:00', '00:00:00:00:00:00', '00:00:00:00:00:00'),
		$mac
		);
	return $mac;
}

function segmento($segmento_comercial){
	if ($segmento_comercial=="8/8" ||  $segmento_comercial=="7/7") {
		$segmento_comercial = "Residencial";
	}
	else if($segmento_comercial=="6/6") {
		$segmento_comercial = "Comercial";
	}
	else if($segmento_comercial=="4/4" || $segmento_comercial=="3/3") {
		$segmento_comercial = "Corporativo";
	}
	else if($segmento_comercial=="2/2") {
		$segmento_comercial = "Pruebas o Bloqueos";
	}
	else if($segmento_comercial=="1/1") {
		$segmento_comercial = "Dedicado";
	}
	return $segmento_comercial;
}

function bandwith($ancho_banda){

	$ancho_banda = str_replace(
		array('/'),
		array('</span>/<span class="DownloadAsignado">'),
		$ancho_banda
		);
	return $ancho_banda;
}

?>