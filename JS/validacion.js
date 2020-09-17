/*Esta funcion nos trae un .json del php al que se lo solicitemos*/
function phpData(url) {

  const xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.status == 200 && this.readyState == 4) {
      let datos = JSON.parse(this.responseText);
      validarData(datos);
      //return datos;
    }

  }
}

/*Nos ayuda a saber si el .json tiene contenido con Boolean recibimos un 1 si tenemos algo dentro y un 0 si esta vacio*/
function validarData(datos) {
  const online = Boolean(datos.nombre);
  if (!online) {
    let body = document.getElementById("body");
    body.remove();
    window.location = "signIn.html";
  } else {
    if (hereNot()) {
      alert("BIENVENIDE "+datos.nombre);
    }
   
  }

}


/*Si hay una sesion abierta el usuario no tiene acceso a las paginas de iniciar sesion, registro o recuperarCuenta, esta funcion ayuda a redirigir al usuario en caso de que intente entrar.*/
function hereNot() {
  
  let ubi = window.location;
  let ubiNot = new Array(
    'http://localhost:8080/logIn.html',
    'http://localhost:8080/signIn.html',
    'http://localhost:8080/recuperarCuenta.html'
  );

  for (let url of ubiNot) {
    if (ubi == url) {
      document.body.remove();
      window.location = "Home.html";
      return true;
    }
  }
}

//URL de donde solicitaremos el JSON.Ver si esta funcion puede retornar el json para usarlo en otra funcion
let url = 'http://localhost:8080/dataUserJSON.php';
//funcion
phpData(url);
//Ver si esto sirve => validarData(phpData(url));