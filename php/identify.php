<?php
require 'intentoConexion.php';

$r = true;
$data;
//USAR MIRAR PARA SACAR EL ID DEL USUARIO
function mirar(mysqli $conn, $dato) {

  $mira = "SELECT * FROM datosInicio";

  $result = mysqli_query($conn, $mira);

  if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {
      $id = $row ['id'];
      $correo = $row['nick'];
      global $r;
      if ($correo == $dato) {
        global $data;
        //usar data para iniciar sesion
        $data = $id;
        $r = false;
        break;
      }
    }
  }
  mysqli_free_result($result);
}

//USAR CORRECT PARA VALIDAR PASSWORD
function correct(mysqli $conn, $passIngreso) {
  global $data;
  $analisis = "SELECT id,password FROM datosInicio WHERE id='$data'";
  $result = mysqli_query($conn, $analisis);

  $column = mysqli_fetch_array($result);

  $id = $column['id'];
  $passOficial = $column['password'];
  $passIngreso = sha1($passIngreso);

  if ($passIngreso === $passOficial && $id === $data) {
    return true;
  } else{
    return false;
  }
}
?>