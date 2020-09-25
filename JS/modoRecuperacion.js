let user = document.getElementById('user');
let leyenda = document.getElementById('leyenda');
let boton = document.getElementById('recuperar');
let linkSinDato = document.getElementById('sinDato');
let linkSinLlave = document.getElementById('llave');
let formulario = document.getElementById("formulario");
boton.addEventListener("click", enviar);

//__________RESPUESTA DEL SERVER___________
let res = document.getElementById("respuesta");
//idUser : Almacena el id 
let idUser;
//marginError : Nos da un margen de error
let marginError=0;


//________________MESSAGES_________________
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
  "Solo tienes 3 intentos, observa bien los números que recibiste",
  "Token incorrecto",
  "Llave incorrecta",
  "Usuario no registrado",//10
  "Nick incorrecto",//Fuera de uso(FDU)
  "Número celular no registrado",//(FDU)
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
  `CAMBIASTE TU CONTRASEÑA`,
  `Bloqueado`,
  //Colores 27
  'red',
  'green',
  'white'
)

//__________________LINKS_________________
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

//__________________CHECK_________________
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

//__________________SEND_________________
/*enviar():
--Esta función es para el boton. Si el texto ingresado, es correcto este BOTON se hara tipo submit, se mandara el formulario y se recibira una respuesta del parte del servidor. Esto con ayuda de la API FETCH (para mas info ver la función envio()). Muestra al usuario un mensaje para notificarle si esta bien o si ocurrio algun error.*/
function enviar() {
  //alert(getMethod());
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
      if(res.innerHTML==strings[25]){
        window.location="index.php";
      }
    }, 1000);
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
  if(marginError==2 || marginError==3){
  datos.append("tipo",1);
  }
  const url = "http://localhost:8080/php/recuperar.php";

  fetch(url, {
    method: 'post',
    body: datos
  })

  .then(response => {
    data = response.json()
    
    .then(data => {
      if (Boolean(data.text)) {
        switch(data.text){
//_________________________________________
//AQUI SE BUSCA EL ID SEGUN EL METODO
        case "Ingresa tu nick":
          idUser=data.id;
          if(Boolean(idUser)){
            if(getMethod()=="llave"){
             setMethod("intoLlave");
             showMessage(3,20,28);
            }else{
             setMethod("intoEmail");
             showMessage(1,20,28);
            }
          }else{
           showMessage(2,10,27);
          }
          break;
//_________________________________________
  //AQUI SE ENVIA EL TOKEN
  
        case "Envia el token":
           setMethod("token");
           showMessage(6,17,28);
          break;
        
        case "Token incorrecto":
           setMethod("token");
           showMessage("",8,27);
           marginError++;
           if(marginError==1){
           alert(strings[7]);
           }
          if(marginError==3){
            setMethod("bloquear");
            alert("3 intentos fallidos");
           }
          break;
          
//_________________________________________
//Aquí se cambia el password, se bloquea o da otro intento para responder la pregunta de seguridad
        case "Respuesta correcta":
           setMethod("changePass");
           showMessage(16,24,28);
          break;
        case "try Again":
           marginError++;  
           showMessage("",23,27);
           if(marginError>1){
            setMethod("bloquear");
           }else{
            setMethod("pregunta");
           }
          break;
        case "Bloqueado":
          marginError=0;
          showMessage("",26,27);
           alert("Por seguridad se bloquearon los intentos de cambiar contraseña para mas información lee los terminos y condiciones.");
          setTimeout(function() {
          window.location="index.php";
          }, 100);
          break;
//_________________________________________
//iniciar sesion con el usuario y la llave
        case "Bienvenido":
           res.innerHTML = strings[20];
          break;

//_________________________________________
//Realizar pregunta seguridad
        case "Recibido":
          strings[15]=data.quest;
          if(!Boolean(idUser)){
            idUser=data.id;
          }
          if(Boolean(idUser)>0 || data.tok=='Token recibido'){
            setMethod("pregunta");
           if(data.tok=='Token recibido'){
            showMessage(15,18,28);
           }else{
            showMessage(15,20,28);
           }
          }else{
            showMessage("",10,27);
          }
           break;
        case "Cambio exitoso":
           showMessage("",25,28);
           break;
//_________________________________________
//ERROR
        case "Error":
          showMessage("",22,27);
           break;
        default:
        res.innerHTML = "RECIBIDO";
        }
      } else {
        res.innerHTML = strings[21];
      }
    });
  })
  .catch(err => {
   console.log(err)
  });
  
  setLastAction();
}

//_________________ACCIONS_________________

/*setMethod:
--Esta funcion nos permite almacenar la accion que queremos que realice el server*/
function setMethod(nombre){
  accion = nombre;
}


/*getMethod:
--Esta funcion nos permite obtener la accion que esta en ejecucion.*/
function getMethod(){
  return accion;
}

strings['ultimaFrase']="";
/*showMessage:
--Nos ayuda a mostrar mensajes en pantalla, pide el mensaje que tentra la leyenda, el mensaje que tendra el aviso y el color del aviso.*/
function showMessage(textL,numeroTemp,color){
   if(Boolean(textL)<1){
     textL='ultimaFrase';
   }
   res.innerHTML = strings[numeroTemp];
   res.style = "background-Color:"+strings[color];
   leyenda.innerHTML = strings[textL];
   user.value = "";
}

/*setLastAction:
--Almacena el ultimo texto usado en la leyenda*/
function setLastAction(){
  strings['ultimaFrase']=leyenda.innerHTML;
}
 