<?php
require 'clases/claseRegistro.php';
require 'diccionario/MISURL.php';
$usuario = $_POST['user'];
$accion=$_POST['accion'];

if (empty($usuario)) {

  $message= 'Campo vacio';
 
} else { 
  $id=viewRegistro($usuario);
  $message=new array();
  switch($accion){
    case "llave":
      $message["message"]= 'Bienvenido';
      break;
    case "externo":
      $message["message"]= 'Envia el token';
      break;
    case "tradicional":
      $message["message"]= 'Recibido';
      break;
    case "token":
      $message["message"]= 'Token recibido';
      break;
    case "pregunta":
      $message["message"]= 'Respuesta correcta';
      break;
  }
  $message["id"]= $id;
}
header("Content-Type:application/json;charset=UTF-8");
$message=json_encode($message);
echo  $message;

?>
$messages["message"]= 'Respuesta correcta';
      $messages["id"]= $id;
      $message=json_encode($messages);
      echo  $message;