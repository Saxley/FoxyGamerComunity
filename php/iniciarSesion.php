<?php
//cambiar direcciones cuando se tenga el host
require 'diccionario/MISURL.php';
require 'intentoConexion.php';
include 'identify.php';
include '../re.php';

$email = $_POST['user'];
$password = $_POST['password'];
mirar($conn, $email);
if ($r) {
  tiempo(false);
} else {
  if (correct($conn, $password)) {
    tiempo(true);
  } else {
    tiempo(false);
  }
}
mysqli_close($conn);

?>