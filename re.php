<?php
//ver que onda con el session_start
function tiempo($online) {
  include 'php/diccionario/MISURL.php';
  if ($online) {
    
    header("Location:$URL[1]");
    die();
  } else {
    header("Location:$URL[2]");
    die();
  }
}

?>