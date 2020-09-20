


let user = document.getElementById('user');
let leyenda = document.getElementById('leyenda');
let boton = document.getElementById('recuperar');
let linkSinDato = document.getElementById('sinDato');
let linkSinLlave = document.getElementById('llave');
let formulario = document.getElementById("formulario");
//______RESPUESTA DEL SERVER___________
let res = document.getElementById("respuesta");

boton.addEventListener("click", enviar);

/*Arreglo que almacena los mensajes a mostrar*/
let strings = new Array(
  "Danos tu correo, número o nickname",
  "Introduce el correo donde quieres recíbir el código",
  "Introduce tu nick",
  "Introduce tu llave",
  "Revisa tu correo",
  "Conozco mis datos",
  //Introducir 6
  "Introduce los 4 digitos",
  //Alertas 7
  "Solo tienes 3 intentos mas, observa bien los números que recibiste",
  "Clave incorrecta",
  "Llave incorrecta",
  "Correo incorrecto",
  "Nick incorrectto",
  "Número celular no registrado",
  "No recuerdo ninguno",
  "Tengo llave de recuperación"
)

let accion="tradicional";
/*Estas 3 funciones cambian el mensaje de los links.*/
function llave() {
  if (linkSinLlave.innerHTML == strings[5]) {
    nnC();
  } else {
    leyenda.innerHTML = strings[3];
    linkSinDato.innerHTML = strings[13];
    linkSinLlave.innerHTML = strings[5];
    setMethod("llave");
  }
}
function otra() {
  if (linkSinDato.innerHTML == strings[5]) {
    nnC();
  } else {
    leyenda.innerHTML = strings[1];
    linkSinLlave.innerHTML = strings[14];
    linkSinDato.innerHTML = strings[5];
    setMethod("externo");
  }
}
function nnC() {
  leyenda.innerHTML = strings[0];
  linkSinDato.innerHTML = strings[13];
  linkSinLlave.innerHTML = strings[14];
  setMethod("tradicional");
}

/*revisar():
--Esta función revisa el texto que se ingreso en el input, para que no puedan mandar consultas a la base de datos*/
function revisar(cadena) {
  let cadenaArreglo = cadena.split("");
  for (let caracter of cadenaArreglo) {
    switch (caracter) {
      case "/":
        return false;
        break;
      case ";":
        return false;
        break;
      case "'":
        return false;
        break;
      case "\"":
        return false;
        break;
    }
  }
  return true;
}

/*enviar():
--Esta función es para el boton. Si el texto ingresado, es correcto este BOTON se hara tipo submit, se mandara el formulario y se recibira una respuesta del parte del servidor. Esto con ayuda de la API FETCH (para mas info ver la función envio()). Muestra al usuario un mensaje para notificarle si esta bien o si ocurrio algun error.*/
function enviar() {
  let analisis = revisar(user.value);
  if (analisis) {
    boton.type = "submit";
    formulario.addEventListener("submit", envio);
    res.style = "display:flex";
    res.style = "text-align:center";
    setTimeout(function() {
      res.style = "display:none";
    }, 2000);
  } else {
    res.style = "display:none";
    user.style.color = "red";
  }
}

/*envio(e):
--Esta funcion envia los datos al servidor para que sean procesados, esto con ayuda de API fetch, creamos un objeto de tipo de FormData el cual contendra nuestro formulario, mandamos dicho formulario por el metodo post y con e.preventDefault() evitamos que se vea en nuestra barra de direcciones. Realizamos 2promesas , la primera sera recibir un json y la segunda poder usar ese json, cuando tenemos el json lo evaluamos con un if y si es lo que esperabamos permitimos que ocurra una accion.s*/
function envio(e) {
  e.preventDefault();
  let datos = new FormData(formulario);
 // datos.append("accion",getMethod());
  const url = "http://localhost:8080/php/recuperar.php";

  fetch(url, {
    method: 'post',
    body: datos
  })

  .then(function(response) {
    data = response.json()

    .then(function(data) {
      if (data === "Recibido") {
        res.innerHTML = `RECIBIDO`;
        res.style = "background-Color:green";
      } else {
        res.innerHTML = `CAMPO VACÍO`;
      }
    });

  });
}

function setMethod(nombre){
  accion = nombre;
}

function getMethod(){
  return accion;
}


//_______________original____________
let user = document.getElementById('user');
let leyenda = document.getElementById('leyenda');
let boton = document.getElementById('recuperar');
let linkSinDato = document.getElementById('sinDato');
let linkSinLlave = document.getElementById('llave');
let formulario = document.getElementById("formulario");
let res = document.getElementById("respuesta");

boton.addEventListener("click", enviar);


let strings = new Array(
  "Danos tu correo, número o nickname",
  "Introduce el correo donde quieres recíbir el código",
  "Introduce tu nick",
  "Introduce tu llave",
  "Revisa tu correo",
  "Conozco mis datos",
  //Introducir 6
  "Introduce los 4 digitos",
  //Alertas 7
  "Solo tienes 3 intentos mas, observa bien los números que recibiste",
  "Clave incorrecta",
  "Llave incorrecta",
  "Correo incorrecto",
  "Nick incorrectto",
  "Número celular no registrado",
  "No recuerdo ninguno",
  "Tengo llave de recuperación"
)


function llave() {
  if (linkSinLlave.innerHTML == strings[5]) {
    nnC();
  } else {
    leyenda.innerHTML = strings[3];
    linkSinDato.innerHTML = strings[13];
    linkSinLlave.innerHTML = strings[5];
  }
}
function otra() {
  if (linkSinDato.innerHTML == strings[5]) {
    nnC();
  } else {
    leyenda.innerHTML = strings[1];
    linkSinLlave.innerHTML = strings[14];
    linkSinDato.innerHTML = strings[5];
  }
}
function nnC() {
  leyenda.innerHTML = strings[0];
  linkSinDato.innerHTML = strings[13];
  linkSinLlave.innerHTML = strings[14];
}


function enviar() {
  let analisis = revisar(user.value);
  if (analisis) {
    boton.type = "submit";
    formulario.addEventListener("submit", envio);
    res.style = "display:flex";
    res.style = "text-align:center";
    setTimeout(function() {
      res.style = "display:none";
    }, 2000);
  } else {
    res.style = "display:none";
    user.style.color = "red";
  }
}

function revisar(cadena) {
  let cadenaArreglo = cadena.split("");
  for (let caracter of cadenaArreglo) {
    switch (caracter) {
      case "/":
        return false;
        break;
      case ";":
        return false;
        break;
      case "'":
        return false;
        break;
      case "\"":
        return false;
        break;
    }
  }
  return true;
}


function envio(e) {
  e.preventDefault();
  let datos = new FormData(formulario);
  const url = "http://localhost:8080/php/recuperar.php";

  fetch(url, {
    method: 'post',
    body: datos
  })

  .then(function(response) {
    data = response.json()

    .then(function(data) {

      if (data === "Recibido") {
        res.innerHTML = `RECIBIDO`;
        res.style = "background-Color:green";
      } else {
        res.innerHTML = `CAMPO VACÍO`;
      }
    });

  });
}


