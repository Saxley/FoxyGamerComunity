
let user = document.getElementById('user');
let leyenda = document.getElementById('leyenda');
let boton = document.getElementById('recuperar');
let linkSinDato = document.getElementById('sinDato');
let linkSinLlave = document.getElementById('llave');
let formulario = document.getElementById("formulario");
//______RESPUESTA DEL SERVER___________
let res = document.getElementById("respuesta");
let idUser;
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
  "Tengo llave de recuperación",
  //Alerta 15
  "Pregunta seguridad",
  "Introduce tu nueva contraseña",
  //res 17
  `REVISA TU CORREO`,
  `Token correcto`,
  `REVISA TU CORREO`,
  `RECIBIDO`,
  `CAMPO VACÍO`,
  //Error 22
  `ERROR DESCONOCIDO`,
  "Respuesta incorrecta",
  "Respuesta correcta",
  //Cambio exitoso 25
  `CAMBIASTE TU CONTRASEÑA`
)

let accion="tradicional";
/*Estas 3 funciones cambian el mensaje de los links.*/
function llave() {
  if (linkSinLlave.innerHTML == strings[5]) {
    nnC();
  } else {
    leyenda.innerHTML = strings[2];
    linkSinDato.innerHTML = strings[13];
    linkSinLlave.innerHTML = strings[5];
    setMethod("llave");
  }
}
function otra() {
  if (linkSinDato.innerHTML == strings[5]) {
    nnC();
  } else { 
    leyenda.innerHTML = strings[2];
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
  let res=true;
  for (let caracter of cadenaArreglo) {
    switch (caracter) {
      case "/":
        res= false;
        break;
      case ";":
        res= false;
        break;
      case "'":
        res= false;
        break;
      case "\"":
        res= false;
        break;
    }
    if(!res) break;
  }
  return res;
}

/*enviar():
--Esta función es para el boton. Si el texto ingresado, es correcto este BOTON se hara tipo submit, se mandara el formulario y se recibira una respuesta del parte del servidor. Esto con ayuda de la API FETCH (para mas info ver la función envio()). Muestra al usuario un mensaje para notificarle si esta bien o si ocurrio algun error.*/
function enviar() {
  let analisis = revisar(user.value);
  boton.type="button";
  user.style.color = "white";
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
--Esta funcion envia los datos al servidor para que sean procesados, esto con ayuda de API fetch, creamos un objeto de tipo de FormData el cual contendra nuestro formulario, mandamos dicho formulario por el metodo post y con e.preventDefault() evitamos que se vea en nuestra barra de direcciones. Realizamos 2promesas , la primera sera recibir un json y la segunda poder usar ese json, cuando tenemos el json lo evaluamos con un if y si es lo que esperabamos permitimos que ocurra una accion.*/
function envio(e) {
  
  e.preventDefault();
  
  let datos = new FormData(formulario);
  datos.append("accion",getMethod());
  if(Boolean(idUser)){
  datos.append("id",idUser);
  }
  const url = "http://localhost:8080/php/recuperar.php";

  fetch(url, {
    method: 'post',
    body: datos
  })

  .then(function(response) {
    data = response.json()
    
    .then(function(data) {
       
      if (Boolean(data.text)) {
        res.style = "background-Color:green";
        switch(data.text){
        //AQUI SE BUSCA EL ID SEGUN EL METODO
        case "Ingresa tu nick":
          idUser=data.id;
          user.value = "";
          if(getMethod()=="llave"){
           leyenda.innerHTML = strings[3];
           res.innerHTML = strings[20];
           setMethod("intoLlave");
          }else{
           leyenda.innerHTML = strings[1];
           res.innerHTML = strings[20];
           setMethod("intoEmail");
          }
          break;
          
        //AQUI SE ENVIA EL TOKEN
        case "Envia el token":
           setMethod("token");
           res.innerHTML = strings[17];
           leyenda.innerHTML = strings[6];
           user.value = "";
          break;
        case "Token recibido":
           setMethod("pregunta");
           res.innerHTML = strings[18];
           leyenda.innerHTML = strings[15];
           user.value = "";
          break;
          
        //Aquí se cambia el password
        case "Respuesta correcta":
           setMethod("changePass");
           res.innerHTML = strings[24];
           leyenda.innerHTML = strings[16];
           user.value = "";
          break;
          
        //iniciar sesion con el usuario y la llave
        case "Bienvenido":
           res.innerHTML = strings[20];
          break;
          
        //Realizar pregunta seguridad
        case "Recibido":
           idUser=data.id;
           res.innerHTML = strings[20];
           setMethod("pregunta");
           leyenda.innerHTML = strings[15];
           user.value = "";
           break;
        case "Cambio exitoso":
           res.innerHTML = strings[25];
           user.value = "";
           break;
        //ERROR
        case "Error":
           res.style = "background-Color:red";
           res.innerHTML = strings[22];
           user.value = "";
           break;
        default:
        res.innerHTML = strings[20];
        }
      } else {
        res.innerHTML = strings[21];
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