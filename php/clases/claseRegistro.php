<?php
//IMPORTANTE:lee los comentarios
class Registros {

  /*viewRegistro:
  --Esta funcion devuelve el $id del usuario que se esta buscando en caso de que ya exista en nuestra DB. Si el USER no existe nos devolvera un FALSE*/
  public function viewRegistro($dato) {
    require 'intentoConexion.php';
    //RELIZAR CONSULTA
    $view = "SELECT id,nick FROM datosInicio";
    /*___________
      nick es el correo
      id es el numero auto incremental
      __________*/
    $view_answer = mysqli_query($conn, $view);
    //Revisar si hay algun registro
    if (mysqli_num_rows($view_answer) > 0) {
      //GUARDAR EN UNA VARIABLE LOS REGISTROS Y RECORREELOS CON WHILE. SI NO SE ENCUENTRA EL USUARIO, DAR RESPUESTA Boleana (false), SI SE ENCUENTRA DEVOLVER EL id DEL USUARIO
      while ($row = mysqli_fetch_array($view_answer)) {
        $id = $row ['id'];
        $email = $row['nick'];
        if ($email == $dato) {
          return $id;
          break;
        }
      }
      return false;
    }
    mysqli_close($conn);
  }

  /*newRegistro:
  --Esta funcion nos permite realizar un registro en caso de que viewRegistro nos haya retornado un FALSE.Se ejecuta 2veces 1para registrar y otra para registrar la llave de emergencia.
  El ciclo de la funcion es:
    FALSE=REGISTRO.
    $id=REGISTRO DE LLAVE
  ______SI EL USUARIO YA EXISTE______
    $id=$error 'Mensaje de error'
    cerrar_conexion a DB
  */
  public function newRegistro($email, $pass, $llave) {
    require 'intentoConexion.php';
    //SI EL USUARIO NO EXISTE SE REALIZARA EL REGISTRO.

    $passEncrypt = sha1($pass);
    $llaveEncrypt = sha1($llave);


    if (!$this->viewRegistro($email)) {
      $instruccion = "INSERT INTO datosInicio(nick,password) VALUES ('$email','$passEncrypt')";
      $ejecucion = mysqli_query($conn, $instruccion);
      //ALMACENAMOS EL ID DEL USUARIO VERIFICAMOS QUE HAYA UN REGISTRO DE USUARIO Y REGISTRAMOS LA LLAVE Y EL ID COMO ID FORANEO
      if ($ejecucion) {
        $idUser = $this->viewRegistro($email);

        $instruccion = "INSERT INTO llave_emergencia (llave, id_llave, id_user) VALUES ('$llaveEncrypt','0','$idUser')";

        $ejecucion = mysqli_query($conn, $instruccion);

      } else {
        $error = 'ERROR DESCONOCIDO';
        return $error;
      }
    } else {
      $error = 'ESTE CORREO YA ESTA REGISTRADO';
      return $error;
    }
    mysqli_close($conn);
  }

  /*start:
  --Esta funcion devuelve un valor booleano TRUE si los datos de ingreso existen en la DB, y FALSE si los datos no coinciden con los de la DB.*/
  public function start($id, $pass) {
    require 'intentoConexion.php';
    $consulta = "SELECT id,password FROM datosInicio WHERE id='$id'";
    $ejecucion = mysqli_query($conn, $consulta);
    $column = mysqli_fetch_array($ejecucion);
    $idOficial = $column['id'];
    $passOficial = $column['password'];
    $passIngreso = sha1($pass);
    if ($passOficial===$passIngreso && $idOficial===$id) {
      return true;
    }else{
      return false;
    }
    mysqli_close($conn);
  }
  
  
  /**/
  public function changePassword($id,$newPass){
    return false;
  }
  
  public function questSecurity($quest){
    
  }
  public function questSecurityAnswer($answer){
    
  }
  
  public function tokenMaker(){
    
  }
  
  public function getToken(){
    
  }
  
  public function getQuestion(){
    
  }
  
  public function getAnswerQuest(){
    
  }
  
}

?>