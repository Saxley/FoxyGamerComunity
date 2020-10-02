<?php
//IMPORTANTE:lee los comentarios
class Registros{
//________EJECUSION DE CONSULTAS___________
  /*Conectar:
  --Funcion simple que ejecuta consultas a mysql y retorna un valor false si hay un error.*/
  public function Conectar($ejecucion) {
    require 'intentoConexion.php';
    $resultado = false;
    $hacer = mysqli_query($conn, $ejecucion);
    if (!$hacer) {
      $resultado = false;
    } else {
      $resultado = true;
    }
    return $resultado;

    mysqli_close($conn);
  }
//__________BUSQUEDA USUARIOS______________
  /*viewRegistro:
  --Esta funcion devuelve el $id del usuario que se esta buscando en caso de que ya exista en nuestra DB. Si el USER no existe nos devolvera un FALSE*/
  public function viewRegistro($dato) {
    require 'intentoConexion.php';
    //RELIZAR CONSULTA
    $view = "SELECT id,email,nick FROM datosInicio";
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
        $email = $row['email'];
        $nick = $row['nick'];
        if ($email == $dato || $nick == $dato) {
          return $id;
          break;
        }
      }
      return false;
    }
    mysqli_close($conn);
  }

//____________NEW REGISTROS________________
  /*newRegistro:
  --Esta funcion nos permite realizar un registro en caso de que viewRegistro nos haya retornado un FALSE.Se ejecuta 2veces 1para registrar y otra para registrar la llave de emergencia.
  El ciclo de la funcion es:
    FALSE=REGISTRO.
    $id=REGISTRO DE LLAVE
  ______SI EL USUARIO YA EXISTE______
    $id=$error 'Mensaje de error'
    cerrar_conexion a DB
  */
  public function newRegistro($email, $pass, $llave, $nick) {
    //SI EL USUARIO NO EXISTE SE REALIZARA EL REGISTRO.
    $passEncrypt = sha1($pass);
    $llaveEncrypt = sha1($llave);
    $nick = "@".$nick;
    $error = 'ERROR DESCONOCIDO';
    if (!$this->viewRegistro($email) && !$this->viewRegistro($nick)) {
      $instruccion = "INSERT INTO datosInicio(email,password,nick) VALUES ('$email','$passEncrypt','$nick')";
      $ejecucion =$this->Conectar($instruccion);

      //ALMACENAMOS EL ID DEL USUARIO VERIFICAMOS QUE HAYA UN REGISTRO DE USUARIO Y REGISTRAMOS LA LLAVE Y EL ID COMO ID FORANEO
      if ($ejecucion) {
        $idUser = $this->viewRegistro($email);
        $instruccion = "INSERT INTO llave_emergencia (llave, id_llave, id_user) VALUES ('$llaveEncrypt','0','$idUser')";
        $ejecucion =$this->Conectar( $instruccion);
        if ($ejecucion) {
          $instruccion = "INSERT INTO token (id_user) VALUES ('$idUser')";
          $ejecucion =$this->Conectar($instruccion);
         if($ejecucion){
          include_once 'claseEnvios.php';
          include 'diccionario/MISURL.php';
          $sendToken=new soporte('','','',$email,$nick);
          return  header("Location:$URL[0]");
         }
        } else {
          return $error;
        }
      } else {
        return $error;
      }
    } else {
      $error = 'ESTE CORREO YA ESTA REGISTRADO';
      return $error;
    }
  }
  
  /*setQuestSecurity:
  --Nos deja almacenar una pregunta de seguridad, esta pregunta se nos solicitara en caso de querer cambiar nuestro password*/
  public function setQuestSecurity($quest, $id) {
    $setQuest = "UPDATE datosInicio set questSecurity='$quest' where id='$id'";
    $res = $this->Conectar($setQuest);
  }

  /*setQuestSecurityAnswer:
  --Esta funcion nos ayuda a almacenar la respuesta a la pregunta que otorgamos anteriormente.*/
  public function setQuestSecurityAnswer($answer, $id) {
    $setAnswer = "UPDATE datosInicio set answerQuestS='$answer' where id='$id'";
    $res = $this->Conectar($setAnswer);
  }
  
//___________INICIO DE SESION______________
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
    if ($passOficial === $passIngreso && $idOficial === $id) {
      return true;
    } else {
      return false;
    }
    mysqli_close($conn);
  }

//_________CAMBIO DE CONTRASEÑA____________
  /*changePassword:
  --Esta funcion nos permite cambiar la contraseña atraves de Update, se recibe el id y el password, se encrypta y se almacena en la DB*/
  public function changePassword($id, $newPass) {
    $passEncrypt = sha1($newPass);
    $updatePass = "UPDATE datosInicio set password='$passEncrypt' where id='$id'";
    $res = $this->Conectar($updatePass);
    if (!$res) {
      return false;
    } else {
      return true;
    }
  }


  /*getQuestion:
  --Nos permite traer la pregunta de seguridad. Esto ocurre solo cuando queremos cambiar la contraseña.*/
  public function getQuestion($id) {
    require 'intentoConexion.php';
    $consulta = "SELECT id,questSecurity FROM datosInicio WHERE id='$id'";
    $ejecucion = mysqli_query($conn, $consulta);
    $column = mysqli_fetch_array($ejecucion);
    $question = $column['questSecurity'];
    return $question;
    mysqli_close($conn);
  }

  /*getAnswerQuest:
  --Nos permite traer la respuesta almacenada que otorgamos. Esto para evaluarla con la respuesta que ingrese el usuario en caso de que este quiera cambiar la contraseña de su cuenta.(el usuario jamas tendra acceso a la respuesta esto es automatizado por el server.)*/
  public function getAnswerQuest($id) {
    require 'intentoConexion.php';
    $consulta = "SELECT id,answerQuestS FROM datosInicio WHERE id='$id'";
    $ejecucion = mysqli_query($conn, $consulta);
    $column = mysqli_fetch_array($ejecucion);
    $answer = $column['answerQuestS'];
    return $answer;
    mysqli_close($conn);
  }

  /*chance:
  --Esta funcion nos da el semaforo verde o rojo para cambiar el password.*/
  public function chance($confirm, $id) {
    if ($confirm) {
      $setChance = "UPDATE datosInicio set changePass='1' where id='$id'";
      $res = $this->Conectar($setChance);
      return $res;
    }
  }

  /*chanceFinish:
  --Finaliza el chance, devolviendo a este a su valor original y suma 1 al historial de cambio de password, con el historial podremos dar un limite y el usuario no podra sobre cargar nuestra DB*/
  public function chanceFinish($id) {
    $chanceFinish = "UPDATE datosInicio set changePass='0' where id='$id'";
    $res = $this->Conectar($chanceFinish);
    return $res;
  }

  /*getToken:
  --Busca el token en nuestra DB y lo retorna para poder evaluarlo con el token que el usuario ingrese.*/
  public function getToken($id) {
    require 'intentoConexion.php';
    $get = "SELECT token,id_user FROM token WHERE id_user='$id'";
    $ejecucion = mysqli_query($conn, $get);
    $column = mysqli_fetch_array($ejecucion);
    $token = $column['token'];

    return $token;
  mysqli_close($conn);
  }
  
  /*equalToken:
  --Esta funcion solicita el token a la base de datos con la función getToken y lo compara con el token que el usuario ingrese, si son iguales manda palomita verde y borra la solicitud del token. En caso contrario de la comparacion manda false*/
  public function equalToken($id,$token) {
    $TOT=$this->timeOutToken($id);
    $tokenTemp=$this->getToken($id);
    $token=md5($token);
    if($tokenTemp==$token && !$TOT){
      $deleteAddToken = "UPDATE datosInicio set addToken='0' where id='$id'";
      $setToken = $this->Conectar($deleteAddToken);
    
      $deleteToken = "UPDATE token set token='' where id_user='$id'";
      $setToken = $this->Conectar($deleteToken);
    
      return true;
    }else{
      return false;
    }
  }
  /*timeOutToken:
  Esta funcion borrara el token*/
  private function timeOutToken($id){
    require 'intentoConexion.php';
    $consulta="SELECT id_user,time FROM token WHERE id_user=$id";
    $ejecucion=mysqli_query($conn,$consulta);
    $row = mysqli_fetch_array($ejecucion);
    $time=$row['time'];
    $date=new fecha(); 
    $timeNow=$date->fechaServer();
    $horaNow=$date->digital($timeNow[1]);
    $horaToken=$date->digital($time);
    if($horaNow>$horaToken+3000){
      $deleteAddToken = "UPDATE datosInicio set addToken='0' where id='$id'";
      $setToken = $this->Conectar($deleteAddToken);
      $deleteToken = "UPDATE token set token='' where id_user='$id'";
      $setToken = $this->Conectar($deleteToken);
      return true;
    }else{
      return false;
    }
  }
  
//___________CREACION DEL TOKEN___________
  /*tokenMaker:
  --Como su nombre lo dice, retorna un token el cual se hace aqui.*/
  public function tokenMaker($id,$emailDestino) {
   require 'intentoConexion.php';
//_________________________________________
    $day = getdate();
    do {
      $token = random_int($day['seconds'], $day[0]);
      $token = ceil(sqrt($token));
    }while (strlen($token) != 4);
    settype($token, 'string');
//_________________________________________
    
    $consulta = "UPDATE datosInicio set addToken='1' where id='$id'";
    $setToken = $this->Conectar($consulta);
    
    if ($setToken) {
      $date=new fecha();
      $hora=$date->fechaServer();
      $h=$hora[1];
      $tokenEnc=md5($token);
      $consulta = "UPDATE token set token='$tokenEnc', time='$h' where id_user='$id'";
      $setToken = $this->Conectar($consulta);
      if ($setToken) {  
        include_once 'claseEnvios.php';
        $getUser="SELECT nick,id FROM datosInicio WHERE id='$id'";
        $consulta= mysqli_query($conn,$getUser);
        $row = mysqli_fetch_array($consulta);
        $nick=$row['nick'];
        
        $sendToken=new soporte($token,'','',$emailDestino,$nick);
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  mysqli_close($conn);
  }
  
  
//________________BANEOS__________________
  /*baneo:
  --Esta funcion nos permite banear usuarios, los datos se almacenaran en 2 tablas el primero es para saber si la cuenta esta baneada esto desde la tabla datosInicio columna bann con ella sabremos si el usuario esta baneado, la segunda tabla es la de baneo la cual almacenara todos los baneos que tengan los usuarios, los baneos pueden ser de 2tipos, por 1día y permanentes, los baneos de 1 día seran por faltas simples y por seguridad de los mismos usuarios, un cambio de contraseña fallido seria razón para banear, cuando se banea al usuario se le enviara un mail a su email registrado esto para avisar de actividad sospechosa, tambien se haran baneos de este estilo por reportes de comportamiento agresivo o de insultos, los baneos permanentes seran por plagio, actividad de desnudos entre otros similares */
  public function baneo($id,$tipo) {
  require 'intentoConexion.php';
  $consulta="select bann,id from datosInicio where id='$id'";
  $ejecucion=mysqli_query($conn,$consulta);
  $dato=mysqli_fetch_array($ejecucion);
  $dato=$dato['bann'];
  $ban;
  
  if($dato!=1){
    $setBan="UPDATE datosInicio set bann='1' where id='$id'";
    $ban=$this->Conectar($setBan);
  }else{
    $ban=true;
  }
  if($ban){
    $date=new fecha();
    $time=$date->fechaServer();
    
    $razon='';
    if($tipo==1)$razon="RESPUESTA O TOKEN INCORRECTO AL INTENTAR CAMBIAR LA CONTRASEÑA";
    
     $setBan="INSERT INTO baneo(id_user,motivo,tipo,tiempo,hora) VALUES('$id','$razon','$tipo','$time[0]','$time[1]')";
     $ban=$this->Conectar($setBan);
     if($ban){
      include_once 'claseEnvios.php';
      $getMAIL="SELECT nick,email,id FROM datosInicio WHERE id='$id'";
      $consulta= mysqli_query($conn,$getMAIL);
      $row = mysqli_fetch_array($consulta);
      $emailDestino=$row['email'];
      $nick=$row['nick'];
      $sendToken=new soporte($razon,'','',$emailDestino,$nick);
     }
    }
  mysqli_close($conn);
  }
  
  /*getBann:
  --Nos devuelve un true si el usuario esta con bann y un false si no tiene bann.*/
  public function getBann($id){
    require 'intentoConexion.php';
    $consulta="SELECT id,bann FROM datosInicio WHERE id=$id";
    $ejecucion=mysqli_query($conn,$consulta);
    $row = mysqli_fetch_array($ejecucion);
    $b=$row['bann'];
    if($b==1){
      return true;
    }else{
      return false;
    }
    mysqli_close($conn);
  }
  
  /*deleteBann:
  --Esta funcion nos ayuda a borrar el ban de datosInicio, IMPORTANTE:esta misma funcion nos ayudara mas adelante a decidir a quien no quitar ban.*/
  public function deleteBann($id){
    require 'intentoConexion.php';
    $consulta="SELECT id_user,tiempo,hora,tipo FROM baneo WHERE id_user=$id";
    $ejecucion=mysqli_query($conn,$consulta);
    $row = mysqli_fetch_array($ejecucion);
    $tipo=$row['tipo'];
    $tipo=settype($tipo,"int");
    $fe=$row['tiempo'];
    $fe=settype($fe,"string");
    $hora=$row['hora'];
    $date=new fecha();
    $time=$date->fechaServer();
    $horaBan=$date->digital($hora);
    $horaNow=$date->digital($time[1]);
    switch($tipo){
      case  1:
        if($fe!=$time[0] && $horaNow>$horaBan){
         $consulta="UPDATE datosInicio set bann='0' where id='$id'";
         $ejecutar=mysqli_query($conn,$consulta);
         return true;
        }else{
          return false;
        }
        break;
      case  2:
        if($fe!=$time[0] && $horaNow>$horaBan){
         $consulta="UPDATE datosInicio set bann='0' where id='$id'";
         $ejecutar=mysqli_query($conn,$consulta);
         return true;
        }else{
          return false;
        }
        break;
      case  3:
        if($fe!=$time[0] && $horaNow>$horaBan){
         $consulta="UPDATE datosInicio set bann='0' where id='$id'";
         $ejecutar=mysqli_query($conn,$consulta);
         return true;
        }else{
          return false;
        }
        break;
    }
    mysqli_close($conn);
  }
  

//_________SESION POR LLAVE________________
  /*sesionEmeegencia:
  Esta funcion nos permitira iniciar sesion con nuestra llave, se nos aconsejara cambiar nuestro password en configuraciones, estara la opción de omitir.*/
  public function sesionEmergencia($id,$llave) {
    require 'intentoConexion.php';
    $consulta = "SELECT id_user,llave FROM llave_emergencia WHERE id_user='$id'";
    $ejecucion = mysqli_query($conn, $consulta);
    $column = mysqli_fetch_array($ejecucion);
    $llaveOficial = $column['llave'];

    if ($llaveOficial == $llave) {
      return true;
    } else {
      return false;
    }
    mysqli_close($conn);
  }
}

//ESTA CLASE TIENE EL OBJETIVO DE DEVOLVER LA FECHA Y LA HORA. nota: Se puede hacer con el constructor, antes de hacerlo revisar todo el codigo
class fecha{
  /*fechaServer
  --Devuelve fecha y hora en strings, ambas en un arreglo*/
  public function fechaServer(){
    $d=array();
    $date = getdate();
    $d[0]=$this->getFecha($date);
    $d[1]=$this->getHora($date);
    return $d;
  }
  /*getFecha:
  --Devuelve la fecha en formato date para mariadb*/
  private function getFecha($date){
    $day= $date['mday'];
    $month= $date['mon'];
    $year= $date['year']; 
  
    $date=$year.'-'.$month.'-'.$day;
    return $date;
  }
  /*getHora:
  --Devuelve la hora como una cadena*/
  private function getHora($date){
    $seconds= $date['seconds'];
    $minutes= $date['minutes'];
    $hours= $date['hours']; 
  
    $date=$hours.':'.$minutes.':'.$seconds;
    return $date;
  }
  /*digital:
  --Su unico objetivo es devolver la hora como un numero entero.*/
  public function digital($time){
    $num;
    for($i=0;$i<strlen($time);$i++){
        if($time[$i]==":"){
          $time[$i]=" ";
        }else{
          $num=$num.$time[$i];
        }
      }
      settype($num,'int');
      return $num;
  }
}

?>