<?php

include_once 're.php';
 /*Este objeto proviene de re.php el cual nos redirige a nuestras paginas*/
 $data=new JS();
 $myJSON=json_encode($data->json());
 print_r($myJSON);
//$vistas=new viewHTML();
 ?>