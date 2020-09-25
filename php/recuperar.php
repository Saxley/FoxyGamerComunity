<?php
include_once 'clases/claseRegistro.php';
require 'diccionario/MISURL.php';
$usuario = $_POST['user'];
$accion=$_POST['accion'];


//_________________BANNEO__________________
/*bloquear:
Esta funcion crea un objeto de tipo registros y llama a su metodl baneo al cual le pasaremos los argumentos de id y tipo. Con tipo nos referimos al tipo de ban que tendra la cuenta.*/
function bloquear($id,$tipo){
  $bann=new Registros();
  $bann->baneo($id,$tipo);
}

function getBloqueo($id){
  $bann=new Registros();
  $bann->getBann($id);
  return $bann;
}

//__________CREA Y EVALUA TOKEN___________
/*solicitarToken:
--Crea un objeto de tipo Registros y llama a su metodo tokenMaker, el cual envia un email con un token*/
function solicitarToken($id){
  global $usuario;
  $crearToken=new Registros();
  $res=$crearToken->tokenMaker($id,$usuario);
  if($res){
    return true;
  }else{
    return false;
  }
}

/*validarToken:
--Crea un objeto de tipo registros y llama a su metodo equalToken el cual recibe y evalua los token.*/
function validarToken($id){
  global $usuario;
  $validarToken=new Registros();
  $res=$validarToken->equalToken($id,$usuario);
  if(!$res){
    return false;
  }else{
    return true;
  }
}

//_____________BUSQUEDA ID________________
/*buscarId:
--Crea un objeto Registros y llama a el metodo viewRegistro el cual nos devuelve el id segun el correo o el nick ingresado*/
function buscarId(){
  global $usuario;
  $buscar=new Registros();
  $id=$buscar->viewRegistro($usuario);
  return $id;
}
//_______PREGUNTAS Y RESPUESTAS____________
/*getQuest:
--Crea un objeto Registros y llama al metodo getQuest para retornar la pregunta de seguridad del usuario.*/
function getQuest($id){
  $quest=new Registros();
  $enviar=$quest->getQuestion($id);
  return $enviar;
}

/*getAnswer:
--Crea un objeto Registros y llama a sus metodos getAnswerQuest el cual nos trae de base de datos la respuesta correcta a una pregunta y chance el cual si los valores ingresados cumplen las caracteristicas nos devuelve luz verde para cambiar el password. La funcion equal evalua las respuestas y es local.*/
function getAnswer($id){
  global $usuario;
  $answer=new Registros();
  $Evaluar=$answer->getAnswerQuest($id);
  $res=equal($Evaluar,$usuario);
  $chance=$answer->chance($res,$id);
  return $chance;
}

/*equal:
--Esta funcion evalua que los strings ingresados sean identicos, retorna true si lo son y false si no se cumple la igualdad.*/
function equal($answerOrigin,$answerInto){
  if($answerInto==$answerOrigin){
    return true;
  }else{
    return false;
  }
}

//__________CAMBIO DEL PASS_______________
/*newPass:
--Crea un objeto Registros y llama a su metodo changePassword, se ingresan los parametros de id y password nueva. Retorna true si se cumplio el cambio o false si el cambio fracaso*/
function newPass($id,$pass){
$buscar=new Registros();
$res=$buscar->changePassword($id,$pass);
if($res){
  return true;
  }else{
  return false;
  }
}

/*finish:
--Crea un objeto Registros y llama a si metodo chanceFinish.*/
function finish($id){
$Cambio=new Registros();
$Cambio->chanceFinish($id);
}

//____________JSON REQUEST________________
/*Este if evalua si el campo esta vacio retorn un json notificandolo, si no esta vacio evalua los dstos recibidos por el formularioatravez del $accion sabremos que funciones llamar y que mensajes enviar como respuesta.*/
if (empty($usuario)) {

  $message= 'Campo vacio';
  $message=json_encode($message);
 
} else { 
  $message=array();
  switch($accion){
//_____________CASE TRADICIONAL____________
    
  /*Se recibe el correo y se busca el id, se busca la pregunta de seguridad.
      °°°JSON CONTAIN:°°°
      ### ID USUARIO            ###
      ### PREGUNTA DE SEGURIDAD ###
      ### ACCION A HACER        ###*/
    case "tradicional":
      $id=buscarId();
      $quest=getQuest($id);
      $message["id"]=$id;
      $message["quest"]= $quest;
      $message["text"]= "Recibido";
      break;
      
  /*Se recibe la respuesta de la pregunta, se llama a ls funcion getAnswer y segun su respuesta enviaremos intentar de nuevo o Respuesta correcta.
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "pregunta":
      $id=$_POST["id"];
      if(getAnswer($id)){
      $message["text"]= "Respuesta correcta";
      }else{
      $message["text"]= "try Again";
      }
      break;
      
  /*Se bloquea x 24hrs el cambio de contraseña si el usuario fallo mas de 2 veces en la pregunta de seguridad.
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "bloquear":
      $id=$_POST["id"];
      $tipo=$_POST["tipo"];
      if(!getAnswer($id)){
      $message["text"]= "Bloqueado";
      bloquear($id,$tipo);
      }else{
      $message["text"]= "Respuesta correcta";
      }
      break;
//_________________BUSCA__________________
    
  /*Se recibe el nick,Se busca el id
      °°°JSON CONTAIN:°°°
      ### ID USUARIO            ###
      ### ACCION A HACER        ###*/
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
//__________ _CASE TOKEN__ ________________
   
  /*Se recibe el correo externo y se envia el token  
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "intoEmail":
      $id=$_POST["id"];
      $accion=solicitarToken($id);
      if($accion){
      $message["text"]= "Envia el token";
      }
      break;
      
  /*Se recibe el token y se envia para su evaluacion.En caso de ser incorrecto notificara 1vez que solo hay 3 intentos y se indicara revisar el correo nuevamente.
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "token":
      $id=$_POST["id"];
      $res=validarToken($id);
      if($res){
        $quest=getQuest($id);
        $message["quest"]= $quest;
        $message["text"]= "Recibido";
        $message["tok"]= "Token recibido";
      }else{
        $message["text"]= "Token incorrecto";
      }
      break;
//________________CASE LLAVE_______________
    
  /*Se recibe la llave y se iniciara sesion
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "intoLlave":
      $message["text"]="Bienvenido";
      break;
//_____________CASE LUZ VERDE______________
    
  /*Se recibe la nueva contraseña, id y se cambia el password.
      °°°JSON CONTAIN:°°°
      ### ACCION A HACER ###*/
    case "changePass":
      global $usuario;
      $pass=$usuario;
      $id=$_POST["id"];
      if(newPass($id,$pass)){
        finish($id);
        $message["text"]= "Cambio exitoso";
      }else{
        $message["text"]= "Error";
      }
      break;
  }
  header('Content-Type:application/json;charset=utf-8');
  $message=json_encode($message);
}
//_________________PRINT__________________
echo  $message;
?>
      