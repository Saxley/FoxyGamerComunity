let alertaMessage = false;
let llave;
let notificar = false;
let notificarP = false;
nombre = document.getElementById("nombre");
correo = document.getElementById("correo");
contraseña = document.getElementById("contraseña");
confirmar = document.getElementById("contraseñaVerify");
btn_registro = document.getElementById("button");

btn_registro.addEventListener("click", campos);

holder();

function holder() {
  contraseña.placeholder = "Introduce tu contraseña";
  nombre.placeholder = "Introduce tu nombre";
  confirmar.placeholder = "Confirma tu contraseña";
  correo.placeholder = "Introduce tu nombre";
}

function campos() {
  let contain = document.getElementById('contenedor');
  let cuerpo = document.getElementById("fondo");
  let form = document.getElementById("form");
  let message = document.createElement('p');

  contain.before(message);

  if (alertaMessage) {
    cuerpo.removeChild(cuerpo.children[0]);
    cuerpo.style.backgroundColor = "black";
    alertaMessage = false;
  }

  let n$mbre = nombre.value;
  let c$rreo = correo.value;
  let c$ntrasena = contraseña.value;
  let c$nfirmar = confirmar.value;

  analisisCampo(n$mbre, c$rreo, c$ntrasena, c$nfirmar);

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
    form.append(eLlave);
    btn_registro.type = "submit";
  }
}

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

/* leer y mejorar
function scriptPHP(agregar) {
    let form=document.getElementById("form");
    let phpScript = document.createElement('script');
  if (agregar) {
    btn_registro.type="submit";
    cuerpo.appendChild(phpScript);
    phpScript.type = "text/php";
    phpScript.src = "php/add.php";
    form.action="php/add.php"
  } else {
    alert('fallo el registro');
  }
}*/