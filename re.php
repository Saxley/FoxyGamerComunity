<?php
//re-direccionar

/*viewHTML:
--Esta clase nos ayuda a redirigir a nuestras paginas, evaluando si existe una sesion (con ayuda de claseSesiones->getCurrentUser() la cual nos devuelve la sesion actual con el nombre de un usuario, si este usuario no existe, no se devuelve valor alguno)*/
class viewHTML {
  /*__construct:
  --Este constructor ejecuta una funcion que esta en esta misma clase llamada whoiam la cual nos redirige segun su logica.*/
  public function __construct() {
    include_once('php/clases/claseSesiones.php');
    $sesion = new Sesiones();
    $online = $sesion->getCurrentUser();
    //necesito enviar este $online
    $this->whoiam($online);
  }
  /*whoiam:
  --Esta funcion evalua el nombre de un usuario, si la $VARIABLE que solicita es vacia se redigira a el signIn.html para que el usuario pueda crear una sesion y almacenar su usuario, una vez que se almacena su usuario se vuelve a usar esta funcion. Si la $VARIABLE que solicita contiene un usuario, significa que hay una sesion por lo cual nos redirige al Home.html*/
  public function whoiam($sesion) {
    require 'php/diccionario/MISURL.php';
    if (empty($sesion)) {
      header("Location:$URL[2]");
      die();
    } else {
      //echo $sesion;
      header("Location:$URL[1]");
      die();
    }
  }

}

/*JS:
--Esta clase nos devuelve el nombre de usuario que este en uso en forma de arreglo, esto para que pueda ser utilizado posteriormente. Para que devuelva el arreglo se debe llamar a su funcion json()*/
class JS {
  /*json():
  --Devuelve un arreglo asociatovo del metodo getCurrentUser() del objeto Sesiones() el cual nos devuelve el nombre del usuario con una sesion activa*/
  public function json() {
    include_once('php/clases/claseSesiones.php');
    $sesion = new Sesiones();
    $online = $sesion->getCurrentUser();
    $status = array ("nombre" => $online,);

    return $status;
  }

}
?>