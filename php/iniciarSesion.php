<?php
include_once 'clases/claseRegistro.php';
include_once 'clases/claseSesiones.php';
include_once '../re.php';

//GUARDAMOS LOS DATOS EN VARIABLES LOCALES.
$email = $_POST['user'];
$password = $_POST['password'];

//Creamos los objetos de Registro y Sesiones los cuales provienen de las clases y nos ayudan a iniciar sesion y a validar nuestros datos ingresados
$check= new Registros();
$nuevaSesion=new Sesiones();

/*Llamamos a 2 funciones de registro, viewRegistro y start para mas info ir a clases/claseRegistros.php*/
$id=$check->viewRegistro($email);
$start=$check->start($id,$password);

//creamos una variable sesion que nos ayudara a almacenar el nombre del usuario que inicio sesion.
$session;
/*Evaluamos el resultado de la variable $start, si el resultado es TRUE llamaremos a 2 funciones de claseRegistro.php, primero a setCurrentUser() despues a getCurrentUser (para mas info revisar claseRegistros.php). 

--Despues creamos nuestro objeto $vistas cual nos redirigira(para mas info sobre el objeto revisar re.php)*/
if($start){
  $nuevaSesion->setCurrentUser($email);
  $session=$nuevaSesion->getCurrentUser();
}
  $vistas=new viewHTML();
?>