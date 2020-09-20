<?php
/*$text="";
$text= 'Respuesta correcta';*/
$message=array();
$id= "12";
$message["text"]='Respuesta correcta';
$message["id"]=$id;
//$message=array('text'=>$text,'id'=>$id);
$message = json_encode($message);
echo $message;
?>