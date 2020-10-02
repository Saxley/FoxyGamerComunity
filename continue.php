<?php
include_once './php/clases/claseEje.php';
$buscar = new busqueda;
$message = array();
$textBox = $_POST['formInput'];
$accion = $_POST['accion'];
$id_user = $_POST['idUser'];
//$sqlArr : Es un arreglo que contiene los nombres de las columnas de nuestra tabla
$sqlArr = array(
  'id_user',
  'nombre',
  'apellido',
  'edad',
  'pais',
  'estado',
  'ciudad',
  'numero_celular',
  'questSecurity',
  'answerQuestS',
  'pregunta_seguridad',
  'respuesta',
  "¡Registrado con exito!"
);
/*Este if analiza que $textBox tenga dentro suyo información. En caso de que no contenga nada, el arreglo $message almacenara una respuesta la cual lo notifique.
Ya para terminar se envia el $message y se transforma en un archivo json con json_encode.
Si $textBox el switch que le sigue evalua el $accion el cual contiene la accion que debe realizarse. Cada caso de $accion hara con $textBox cosas distintas, desde consultas simples, traer datos o actualizar la tabla. Y al final enviamos la columna en la nos encontramos, para que javascript de esta forma sepa que mostrar en pantalla*/
if (!empty($textBox)) {
  switch ($accion) {
    case 'nick':
      $verify=$buscar->comparar('nick',$textBox,'datosInicio');
      if($verify){
        $res = $buscar->getBusqueda($arr = array('id'), 'nick', $textBox, 'datosInicio');
        $Registros = $buscar->comparar('id_user',$res[1],'datosUsuario');
        if (!$Registros) {
        $message['peticion'] = $sqlArr[1];
        $message['id'] = $res[1];
        }else{
        $message['peticion'] = $sqlArr[12];
       }
      }else{
        $message['peticion'] = 'Usuario no encontrado';
      }
      break;
    case 'nombre':
      if ($buscar->insertar($arr = array($id_user, $textBox), $arrV = array($sqlArr[0], $sqlArr[1]), 'datosUsuario')) {
        $message['peticion'] = $sqlArr[2];
      }
      break;
    default:
      for($i=0;$i<count($sqlArr);$i++) {
        $tabla='datosUsuario';
        $where='id_user';
        if($sqlArr[$i]=='pregunta_seguridad' || $sqlArr[$i]=='respuesta'){
            $tabla='llave_emergencia';
        }
        if($sqlArr[$i]=='questSecurity' || $sqlArr[$i]=='answerQuestS'){
            $tabla='datosInicio';
            $where='id';
        }
        if ($accion == $sqlArr[$i]){
         $buscar->actualizar($arr = array($sqlArr[$i]), $arrV = array($textBox),$tabla, $where, $id_user); 
        if($sqlArr[$i+1]=='questSecurity' ||
        $sqlArr[$i+1]=='pregunta_seguridad'
        ){
        $message['peticion'] = 'Pregunta de seguridad para cambio de contraseña y/o llave';
        break;
        }else if($sqlArr[$i+1]=='respuesta' ||
        $sqlArr[$i+1]=='answerQuestS'
        ){
        $message['peticion'] = 'Respuesta';
        break;
        }else{
        $message['peticion'] = $sqlArr[$i+1];
        break;
        }
        }
      }
    }
  } else {
    $message['peticion'] = 'porfavor ingresa informacion';
  }
  $message = json_encode($message);
  echo $message;
?>