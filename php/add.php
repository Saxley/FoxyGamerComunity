<?php
include_once 'clases/claseRegistro.php';

//CREAMOS nuestro objeto sesiom y hacemos variables locales los datos ingresados.
$nuevoRegistro=new Registros();
$email = $_POST['correo'];
$password =$_POST['contraseñaVerify'];
$llave = $_POST['llave'];


echo $nuevoRegistro -> newRegistro($email,$password,$llave);
/*
NOTA:AGREGAR EL ENCRYPTADO DE CONTRASEÑA,AGREGAR MAS CAMPOS A LA BASE DE DATOS, REVISAR QUE EL USUARIO POR REGISTRAR NO EXISTA YA EN MI BASE DE DATOS.

0rden:------------------------------------
###VERIFICAR QUE EL USUARIO NO EXISTA EN ESTA BASE DE DATOS. ***Listo***
###VERIFICAR QUE EL NICKNAME ESTA DISPONIBLE.

###REGISTRAR AL USUARIO.***Listo***

###ENCRYPTAR CONTRASEÑA/usar encryptacion binaria mediante javascript, luego encryptar con php el binario/***Listo***
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