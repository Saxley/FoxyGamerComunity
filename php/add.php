<?php
require 'intentoConexion.php';

$email = $_POST['correo'];
$password = $_POST['contraseñaVerify'];
$llave = $_POST['llave'];

//$consulta = "INSERT INTO datosInicio(nick,password) VALUES ('$email','$password') ";
$consulta ="INSERT INTO datosInicio(nick,password) VALUES ('$email','$password')";

$resultado = mysqli_query($conn, $consulta);

if($resultado){
$consulta ="INSERT INTO llave_emergencia(llave,id_llave,id_user) VALUES ('$llave','0','0')";
$resultado = mysqli_query($conn, $consulta);

}else{
  echo 'no se registro nada';
}
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

‐--------‐-‐-------------------------------
ESTE PEDASO DE CODIGO FUE COMENTADO PORQUE VERIFICAR QUE LOS CAMPOS ESTEN LLENOS, ES REALIZADO POR JAVASCRIPT Y DE IGUAL FORMA QUE ESTEN SINCRONIZADAS LAS CONTRASEÑAS.
if (!$resultado) {
  ?>
  <h3 class="alerta">Error al registrarse</h3>
  <?php
} else {
  ?>
  <h3 class="alertaR">BIENVENIDO A NUESTRA COMUNIDAD</h3>
  <style>
    .alertaR {
      background-color: #55ff55;
      width: 100%;
      height: 30px;
      color: black;
      font-family: 'Roboto Slab', serif;
      font-size: 15px;
      font-weight: bold;
      text-align: center;
    }
  </style>
  <?php
}
*/
mysqli_close($conn);

?>