//VARIABLES
let alertaMessage=false;
let password = document.getElementById("password");
let user = document.getElementById("user");
let btn_iniciar = document.getElementById("button");

btn_iniciar.addEventListener("click",campos);

holder();
//FUNCION QUE SIRVE PARA ESCRIBIR EN EL placeholder
function holder() {
  password.placeholder = "Introduce tu contraseña";
  user.placeholder = "Introduce tu nickname";
}

//AQUI SE ANALIZA QUE LOS CAMPOS ESTEN LLENOS.

function campos() {
   btn_iniciar.type="button";
  let cuerpo = document.getElementById("fondo");
  let message;
  
  if (alertaMessage) {
    cuerpo.removeChild(cuerpo.children[0]);
    cuerpo.style.backgroundColor="black";
    alertaMessage = false;
  }

  if(user.value.length === 0|| password.value.length ===0 && alertaMessage==false) {
    message = document.createElement('p');
    cuerpo.prepend(message);
    alertaMessage = true;
    message.className = "alerta";
    message.innerHTML = "Ingresa tu usuario y contraseña";
    cuerpo.style.backgroundColor = "#ee0033";
  }else{
    btn_iniciar.type="submit";
  }
}