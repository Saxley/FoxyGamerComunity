<?php
/*__________________________________________
 Aquí solicitamos el arreglo de re.php. Creamos un objeto JS() y llamamos a su metodo json() cuando recibimos el arreglo lo transformamos a formato json con ayuda de json_encode y lo imprimimos para que pueda ser usado
__________________________________________*/

include_once 're.php';
//header: Nos sirve para que el json pueda interpretar acentos latinos y caracteres que use utf-8
header('Content-Type:application/json;charset=utf-8');
 $data=new JS();
 $myJSON=json_encode($data->json());
 
 
 print_r($myJSON);
 
 ?>