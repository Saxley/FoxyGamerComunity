//VARIABLES QUE SE USAN PARA NOTIFICAR Y O ALMACENAR VALORES TEMP
let alertaMessage = false;
let llave;
let notificar = false;
let notificarP = false;

//LLAMADA A ELEMENTOS
nombre = document.getElementById("nombre");
correo = document.getElementById("correo");
contraseña = document.getElementById("contraseña");
confirmar = document.getElementById("contraseñaVerify");
btn_registro = document.getElementById("button");
btn_registro.addEventListener("click", campos);

holder();
//FUNCION QUE SIRVE PARA ESCRIBIR EN EL HOLDER LA CUAL DEBE SER LLAMADA DESDE EL INICIO
function holder() {
  contraseña.placeholder = "Introduce tu contraseña";
  nombre.placeholder = "Introduce tu nombre";
  confirmar.placeholder = "Confirma tu contraseña";
  correo.placeholder = "Introduce tu nombre";
}

//FUNCION QUE DETECTA EL CLICK EN EL BOTON Y EVALUA LOS CAMPOS DE TEXTOS, LOS CUALES QUIEREN ENVIAR INFORMACIÓN.
function campos() {
  //ELEMENTOS QUE USARA LA FUNCION DEL DOM.
  let contain = document.getElementById('contenedor');
  let cuerpo = document.getElementById("fondo");
  let form = document.getElementById("form");
  let message = document.createElement('p');
//ELEMENTOS QUE AGREGAREMOS AL DOM.
  contain.before(message);

//EVALUA UN VALOR BOLEANO Y ELIMINA EL HIJO DEL DOM QUE SE INDICA
  if (alertaMessage) {
    cuerpo.removeChild(cuerpo.children[0]);
    cuerpo.style.backgroundColor = "black";
    alertaMessage = false;
  }
//ALAMACEN DE LA INFORMACION DE LOS INPUTS
  let n$mbre = nombre.value;
  let c$rreo = correo.value;
  let c$ntrasena = contraseña.value;
  let c$nfirmar = confirmar.value;
//FUNCION QUE ESTA MAS ABAJO.
  analisisCampo(n$mbre, c$rreo, c$ntrasena, c$nfirmar);

//AQUI SE EVALUAN LOS CAMPOS, SE VERIFICA QUE ESTEN LLENOS, COINCIDAN, SEAN CORRECTOS, EN CASO DE NO CUMPLIR ALGO, NOTIFICAN AL USUARIO QUE ALGO NO ESTA BIEN EN SU REGISTRO.
  if (nombre.value == "" || correo.value == "" || contraseña.value == "" || confirmar.value == "" && alertaMessage === false) {
    alertaMessage = true;
    message.className = "alerta";
    message.innerHTML = "Todos los campos son obligatorios";
    cuerpo.style.backgroundColor = "#ee0033";
  } else if (contraseña.value != confirmar.value) {
    alertaMessage = true;
    message.className = "alertaP";
    message.innerHTML = "Las contraseñas no coinciden";
    cuerpo.style.backgroundColor = "#F1C40F";
  } else if (notificar) {
    alertaMessage = true;
    message.className = "alertaP";
    cuerpo.style.backgroundColor = "#F1C40F";
    if (notificar == true && notificarP == false) {
      message.innerHTML = "Evita usar signos o espacios";
    } else if (notificar == true && notificarP == true) {
      alert("La contraseña debe tener un minimo de 8 caracteres\n Te recomendamos el uso de signos para que sea mas segura");
      message.innerHTML = "Contraseña muy corta";
      notificarP = false;
    }
    notificar = false;
  } else {
    //colocar llave en base de datos
    let eLlave=document.createElement('input');
    eLlave.hidden="disable";
    eLlave.name="llave";
    eLlave.value=llave;
    form.appendChild(eLlave);
    btn_registro.type = "submit";
  }
}

//FUNCION QUE ANALISA LETRA POR LETRA PARA EVITAR QUE ENVIEN CODIGO AL SERVIDOR DESDE EL EQUIPO DEL USUARIO.
function analisisCampo(a, b, c, d) {
  let encrypt;
  let arreglos = [];
  let cadenaNueva = "";
  arreglos[0] = a.split("");
  arreglos[1] = b.split("");
  arreglos[2] = c.split("");
  arreglos[3] = d.split("");
  let analisis;
  for (var i in arreglos) {
    for (var j in arreglos[i]) {
      analisis = arreglos[i][j];
      if (i == 0 || i == 1) {
        switch (analisis) {
          case " ":
            arreglos[i][j] = "_";
            for (var nC of arreglos[i]) {
              cadenaNueva = cadenaNueva+nC;
            }
            if (i == 0) {
              nombre.value = cadenaNueva;
              nombre.style.color = 'red';
            } else if (i == 1) {
              correo.value = cadenaNueva;
              correo.style.color = "red";
            }
            //notifica el espacio y marca la forma correcta
            notificar = true;
            break;
          case "/":
            notificar = true;
            break;
          case ";":
            notificar = true;
            break;
          case "*":
            notificar = true;
            break;
          case '"':
            notificar = true;
            break;
          case "'":
            notificar = true;
            break;
          case '&':
            notificar = true;
            break;
          case "|":
            notificar = true;
            break;
        }
      } else if (i == 2) {
        if (arreglos[i].length < 8) {
          notificar = true;
          notificarP = true;
        }
      }
      //CREACION DE LA LLAVE DE SEGURIDAD.
      if (i == 3 || i == 2 && notificar === false) {
        analisis = analisis.charCodeAt();
        analisis = analisis.toString(2);
        arreglos[i][j] = analisis;
        encrypt = 0+parseInt(analisis, 16);
        //Llave por si piedes tu contraseña
        llave = encrypt;
      }
    }
  }
}
