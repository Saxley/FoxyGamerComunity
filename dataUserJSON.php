<?php

include_once 're.php';

 $data=new JS();
 $myJSON=json_encode($data->json());
 
 
 print_r($myJSON);
 
 ?>