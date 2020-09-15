<?php
include_once('clases/claseSesiones.php');
include_once('../re.php');
//Creamos objeto de sesion, cerramos la sesion--> creamos el objeto de vistas.
$ofline=new Sesiones();
$ofline->closeSession();
$vistas=new viewHTML();

?>