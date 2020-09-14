<?php
require 'datos.php';

$conn=mysqli_connect($server,$usuario,$contraseña,$basedatos);
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}
 
//echo "Conectado";
?>