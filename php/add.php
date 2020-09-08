<?php
require 'intentoConexion.php';
$email = $_POST['correo'];
$password = $_POST['contraseñaVerify'];

echo 'este es el '. $email . 'esta es la '.$password;

$consulta = "INSERT INTO datosInicio(nick,password) VALUES ('$email','$password') ";

$resultado = mysqli_query($conn, $consulta);

if (!$resultado) {
  ?>
  <h3>Error al registrarse</h3>
  <?php
} else {
  ?>
  <h3>BIENVENIDO A NUESTRA COMUNIDAD</h3>
  <?php
} 
mysqli_close($conn);

?>