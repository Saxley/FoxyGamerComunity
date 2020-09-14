<?php
include_once 'clases/claseRegistro.php';

$nuevoRegistro=new Registros();
$email = $_POST['correo'];
$password =$_POST['contraseñaVerify'];
$llave = $_POST['llave'];

echo $nuevoRegistro -> newRegistro($email,$password,$llave);

/*
require 'intentoConexion.php';
include 'identify.php';

$email = $_POST['correo'];
$password = sha1($_POST['contraseñaVerify']);
$llave = sha1($_POST['llave']);

//FUNCION TRAIDA DE identify.php,Nos ayuda a saber si los usuarios ya estan registrados en nuestra databases.
mirar($conn, $email);

//Si el resultado de mirar es verdad se Registrara al usuario, si es false, se le notificara que ese correo ya esta siendo usado.
if ($r) {
  //echo ' BIENVENIDO';

  $registro = "INSERT INTO datosInicio(nick,password) VALUES ('$email','$password')";

  $resultado = mysqli_query($conn, $registro);

  if ($resultado) {
    
     mirar($conn, $email);
     echo $data;
    $registro = "INSERT INTO llave_emergencia (llave, id_llave, id_user) VALUES ('$llave','0','$data')";
    $resultado = mysqli_query($conn, $registro);

  } else {
    echo 'OCURRIO UN ERROR CON LA CREACION DE TU LLAVE';
  }
} else {
  echo ' ESTE CORREO YA ESTA REGISTRADO';
}
mysqli_close($conn);*/
/*
NOTA:AGREGAR EL ENCRYPTADO DE CONTRASEÑA,AGREGAR MAS CAMPOS A LA BASE DE DATOS, REVISAR QUE EL USUARIO POR REGISTRAR NO EXISTA YA EN MI BASE DE DATOS.

0rden:------------------------------------
###VERIFICAR QUE EL USUARIO NO EXISTA EN ESTA BASE DE DATOS.
###VERIFICAR QUE EL NICKNAME ESTA DISPONIBLE.

###REGISTRAR AL USUARIO.

###ENCRYPTAR CONTRASEÑA/usar encryptacion binaria mediante javascript, luego encryptar con php el binario/
###CREAR LLAVE DE SEGURIDAD /crear una llave aleatoria que tenga 4 codigos, (encryptacion en base7,encryptacion en base 8, encryptacion en base 2, encryptacion en base 16)/
+++Pasar la llave de encryptacion a base 10.
+++Enviar la llave al correo del usuario.

###ALMACENAR LLAVE EN UNA BASE DE DATOS LLAMADA 'sesionPorLlave'

###REDIRECCIONAR A FORMULARIOS DE PERSONALIZACION DE CUENTA /crear estos formularios y sus bases de datos correspondientes/
+++0bjetivos personales.
+++0bjetivos profesionales.
+++Pasion y dedicacion.

###Redireccionar a el home ♡♡Dar la bienvenida de ingreso♡♡.
###Dar opcion de ver Guia de entorno.
###Incentivar a hacer su primera publicacion y/o actividad
*/
?>