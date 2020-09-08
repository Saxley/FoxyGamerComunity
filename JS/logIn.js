let alertaMessage = false;

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
  let message = document.createElement('p');

  contain.before(message);
  if (alertaMessage) {
    cuerpo.removeChild(cuerpo.children[0]);
    cuerpo.style.backgroundColor = "black";
    alertaMessage = false;
  }
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
  }else{
    btn_registro.type="submit";
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