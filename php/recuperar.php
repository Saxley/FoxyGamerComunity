<?php
include_once 'clases/claseRegistro.php';
require 'diccionario/MISURL.php';
$usuario = $_POST['user'];
$accion=$_POST['accion'];

function buscarId(){
  global $usuario;
  $buscar=new Registros();
  $id=$buscar->viewRegistro($usuario);
  return $id;
}

function newPass($id,$pass){
$buscar=new Registros();
$res=$buscar->changePassword($id,$pass);
if($res){
  return true;
  }else{
  return false;
  }
}

if (empty($usuario)) {

  $message= 'Campo vacio';
  $message=json_encode($message);
 
} else { 
  $message=array();
  switch($accion){
    //Se recibe el nick,Se busca el id
    case "llave":
      $message["text"]="Ingresa tu nick";
      $id=buscarId();
      $message["id"]=$id;
      break;
    case "externo":
      $message["text"]= "Ingresa tu nick";
      $id=buscarId();
      $message["id"]=$id;
      break;
    //se recibe la llave
    case "intoLlave":
      $message["text"]="Bienvenido";
      break;
    //Se recibe el correo externo y se envia el token
    case "intoEmail":
      $message["text"]= "Envia el token";
      break;
    //Se recibe el token
    case "token":
      $message["text"]= "Token recibido";
      break;
    //Se recibe el correo y se busca el id
    case "tradicional":
      $id=buscarId();
      $message["id"]=$id;
      $message["text"]= "Recibido";
      break;
    //Se recibe la respuesta de la pregunta
    case "pregunta":
      $message["text"]= "Respuesta correcta";
      break;
    //Se recibe la nueva contraseña y se cambia
    case "changePass":
      global $usuario;
      $pass=$usuario;
      $id=$_POST["id"];
      if(newPass($id,$pass)){
        $message["text"]= "Cambio exitoso";
      }else{
        $message["text"]= "Error";
      }
      break;
  }
  
  $message=json_encode($message);
}


echo  $message;

?>
      