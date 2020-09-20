<?php

/*Sesiones:
--Nos permite crear una sesion.
  setCurrentUser():Nos permite almacenar el nombre de quien inicio sesion cuando se le llama como metodo, pide como parametro una variable.
  getCurrentUser():Nos devuelve el nombre de quien esta en sesion, si setCurrentUser() no fue llamado regresara un elemento vacio.
  closeSession():Nos ayuda a cerrar la sesion que se inicia cuando la clase es instanciada.*/
class Sesiones{
  
  public function __construct(){
    session_start();
  }
  
  public function setCurrentUser($user){
    $_SESSION['user']=$user;
  }
  
  public function getCurrentUser(){
    return $_SESSION['user'];
  }
  
  public function closeSession(){
    session_unset();
    session_destroy();
  }
}

?>