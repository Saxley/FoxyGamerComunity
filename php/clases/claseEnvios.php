<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/src/Exception.php';
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';

class soporte {
  public function __construct($message,$UserCompany,$PassCompany,$email,$user) {
    if (empty($message)) {
      $message = "
    <div>
    <center><h1>BIENVENIDO</h1></center>
    </div>
    <div style=\"text-align: justify;text-indent:2px;padding-left: 2px;padding-right: 2px;color:#ff8800;\">
      Espero disfrutes formar parte de esta comunidad de desarrolladores. En caso de que tu no lo sepas, aquí tu eres un desarrollador. Te invitamos a terminar la configuración de tu cuenta, y que compartas con nosotros el tipo de desarrollador que eres.
      <center><p><b>Termina tu registro <a href=\"http://localhost:8080/RegistreContinue.php\" style=\"text-decoration=none;color=orange;\">Aquí</a></b></p></center><br>
      Sorprendenos con tus dotes artisticos, de conocimiento en lenguajes de programación o con tus dotes de comunicación.<br><br>
      Tal vez pienses que somos una organización como algunas otras, que se dedican a dar streams o simplemente que seamos una comunidad para programadores. pero esto no es del todo cierto.Aquí podrias ser el siguiente desarrollador de Pokemon, ¿porqué? Te explíco, Foxy Company intenta conectar a los dessrrolladores de 3 áreas en específico, con el fin de que compañias como Sony, Nintendo, Google, entre otras, encuentren gente capacitada, aquí puedes despegar tu carrera de desarrollo de videojuegos, diseño de videojuegos o stremer de juegos.<br><br> ¡¡¡GRACIAS!!!<br><br>
      ¿Porqué? Por formar parte de esta nueva cominidad, ayudanos a crecer y a hacer un ambiente sano, donde no importan los titulos, importan las ganas de hacer y ser. <br><br>
      Yo soy @Sax y te doy la bienvenida a formar parte del Futuro
      <pre>
        /\_/\
        \   /
         \_/  FGC
      </pre> 
    </div>";
    }
    $envio=$this->message($UserCompany, $PassCompany, $email, $user, $message);
    return $envio;
  }

  public function message($COMPANY, $Pass, $email, $user, $freeMessage) {
    //DfreeMe
    $tittle='WELCOME TO OUR COMMUNITY';
    if (empty($COMPANY)) {
      $COMPANY = 'foxyGamerCompany';
    }
    if (empty($Pass)) {
      $Pass = 'f0xy?1234';
    }
    if (empty($email)) {
      $email = 'luisarriagacarranza@gmail.com';
    }
    if (empty($user)) {
      $user = '@luis';
    }
    
    if($freeMessage=="RESPUESTA O TOKEN INCORRECTO AL INTENTAR CAMBIAR LA CONTRASEÑA"){
      $tittle="URGENTE";
      $freeMessage="<center><h1 style=\"color: red\">BANEADO</h1></center><br>$user <i>Haz respondido mal consecutivamente a tu pregunta de seguridad o el token por esta razón el cambio de contraseña se ha baneado por el día de hoy.</i><br><br><b>Si recuerdas tu contraseña podras iniciar sesión sin ninguna restricción</b>, este baneo solo es para el cambio de contraseña, si no reconoces esta actividad por favor notificanos.<p style=\"background-color:black;\"><a style=\"text-decoration:none;color:orange;\" href=\"http://localhost:8080/Reporte.php\">NO SOLICITE NINGIÚN CAMBIO DE CONTRASEÑA</a><hr style=\"width:100%; shadow\"></p><br><br><i>$user por tu comprensión muchas gracias y te invitamos a leer los terminos y condiciones de nuestra comunidad, sin nada mas que decir esperamos que tengas un lindo día UwU.</i>
      ";
    }
    if($freeMessage=="ALERTA"){
      $tittle="IMPORTANTE";
      $freeMessage="<center><h3 style='color:yellow;background-color:black;'>Hay actividad inusual con tu llave de seguridad</h3></center> <p> $user Por favor revisa que sea la llave correcta; <b>En caso de no recoconer esta actividad, notificanos de inmediato.</b></p>
        <p style=\"background-color:black;\"><a style=\"text-decoration:none;color:orange;\" href=\"http://localhost:8080/Reporte.php\">NO RECONOZCO ESTA ACTIVIDAD</a><hr style=\"width:100%; shadow\"></p>
        <br><br><i>$user por tu comprensión muchas gracias y te invitamos a leer los terminos y condiciones de nuestra comunidad, sin nada mas que decir esperamos que tengas un lindo día UwU.</i>";
    }
    if(strlen($freeMessage) < 6){
      $tittle="Solicitud de cambio de contraseña";
      $freeMessage='<i>ESTE ES TU TOKEN</i><p style="background-color=black;color:white;">En 30min este token sera invalido y no podras cambiar tu contraseña dentro de 24hrs, tendras 3 intentos pero te recomendamos que anotes bien el token</p><br><br><strong>'.$freeMessage.'</strong><p style="color:red">SI TU '.$user.' NO SOLICITASTE ESTE CAMBIO<br><a href="http://localhost:8080/Reporte.php">Notificanos</a><hr style="width:100%; shadow"></p>';
    }


    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';
    $mail->Username = $COMPANY.'@gmail.com';
    $mail->Password = $Pass;


    $mail->setFrom($COMPANY.'@gmail.com', 'FOXY COMMUNITY');
    $mail->addAddress($email, $user);
    $mail->Subject = $tittle;
    $mail->isHTML(true);
    $mail->Body = $freeMessage;
    $mail->CharSet = 'UTF-8';
    if ($mail->send()) {
      return true;
    } else {
      return false;
    }
  }
}
?>