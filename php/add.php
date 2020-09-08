<?php
require 'intentoConexion.php';

$email = $_POST['correo'];
$password = $_POST['contraseñaVerify'];


$consulta = "INSERT INTO datosInicio(nick,password) VALUES ('$email','$password') ";

$resultado = mysqli_query($conn, $consulta);
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

mysqli_close($conn);

?>