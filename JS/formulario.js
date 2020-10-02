//revisar los archivos desde donde se importo
import ObjetozStyle from "./clasesObjetos.js";
import Asinc from "./clasesAsinc.js";


document.body.className="fondo";
/*Creamos un objeto de tipo ObjetozStyle.
1.-Llamamos a su metodo crear.
2.-Modificamos los atributos de nuestros objetos creados desde crear.
3.-El metodo formStyleAjax recibe como parametro nuestro id de formulario y los values que queremos para sus etiquetas.
4.-Llamamos por el id a los objetos que mas vamos a utilizar.
5.-Les damos nombre para poder usarlos en php.
6.-Agregamos un listener al boton.
7.-Creamos un nuevo objeto de tipo Asinc.
8.-Llamamos a su metodo enviar y le pasamos los atributos que nos solicita.*/
const object=new ObjetozStyle();
let div=object.crear("div","contenedor");
let formulario=object.crear("form","Luisito");
let input=object.crear("input","accion");
let idUser=object.crear("input","idUser");

input.style="display:none";
input.setAttribute("name",'accion');
idUser.style="display:none";
idUser.setAttribute("name",'idUser');
object.intoInBody(div);
object.intoChildtoChild("contenedor",formulario);

div.className="contenedor";
object.formStyleAjax("Setting acount","nick","Write here","Siguiente","","","Luisito");
object.setId("Setting acountButton","botoncito");

//______NAMES_____
let textBox=document.getElementById("Setting acountInput");
let labelBox=document.getElementById("Setting acountLabel");
let btn=document.getElementById("botoncito");
btn.before(input);
btn.before(idUser);

btn.type="submit";
textBox.setAttribute("name","formInput");
let conta=0;
btn.addEventListener("click", me => {
  input.value=labelBox.innerHTML;
  if(input.value=="Usuario no encontrado"){
    input.value="nick";
  }
  if(input.value=="¡Registrado con exito!" && conta==0){
    conta=5;
    alert("Usted ya configuro su cuenta. Si quiere modificar su cuenta le invitamos a realizarlo desde configuraciones. \n1.-Inicia Sesion.\n2.-Vaya a su perfil.\n3.-Busque el menú configuraciones.\n4.-Busque mis datos.\n5.-Busque actualizar datos.")
  }
  if(input.value=="numero_celular"){
    alert("Acontinuacion se te solicitaran 2 preguntas y 2 respuestas, esto nos ayudara en caso de que olvides tu contraseña, porfavor coloca preguntas que solo tu sepas la respuesta");
  }
  if(input.value=="Pregunta de seguridad para cambio de contraseña y/o llave" || input.value=="Respuesta"){
    conta++;
  }
  switch(conta){
      case 1:
      input.value="questSecurity";
      break;
      case 2:
      input.value="answerQuestS";
      break;
      case 3:
      input.value="pregunta_seguridad";
      break;
      case 4:
      input.value="respuesta";
      textBox.style="display:none";
      btn.innerHTML="INICIAR SESION";
      
      conta++;
      break;
      case 5:
      textBox.value="bye";
      labelBox.innerHTML="bye";
      window.location="index.php";
      break;
    }
  setTimeout(function() {
  textBox.value="";
  }, 100);
});

const saludo=new Asinc();
saludo.enviar("./continue.php","post","Luisito","Setting acountLabel","idUser");