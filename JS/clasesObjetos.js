/*Objetoz:
--Esta clase nos permite crear objetos de cualquier tipo,nos da un identificador x default en caso de que no elijamos ninguno. Esto para poder trabajar con el. Una vez creado se puede manipular al antojo, De igual forma contamos con metodos de agregar al documento o agregar a un hijo del documento(intoInBody,intoChildtoChild), en caso de que quieras cambiar un id puedes usar la funcion setId.


El metodo de agregar es con appendChild por este motivo agrega al final de cada elemento.

intoChildtoChild:
  Solamente colocamos el id donde queremos colocar el elemento y el elemento.

setId:
  Con setId puedes hacerlo siguiendo la jerarquia de tu body colocando document.body.children[numero].id y el id que quieres, si conoces el id del objeto al cual de lo quieres cambiar, colocalo y posteriormente el nuevo id
*/
class Objetoz {
//_______________CREAR_____________________
  crear(objeto, identificador) {
    let objetoHTML = document.createElement(objeto);
    if (Boolean(identificador)) {
      objetoHTML.id = identificador;
    } else {
      identificador = "FoxyElement";
      for (let i = 0; i < document.body.children.length; i++) {
        let getid = document.body.children[i];
        while (getid.id == identificador) {
          identificador = "FoxyElement"+i.toString();
        }
        objetoHTML.id = identificador;
      }
    }
    return objetoHTML;
  }

//__________AGREGAR AL DOCUMENTO___________
  intoInBody(objeto) {
    let d = document.body.appendChild(objeto);
    return d;
  }

  intoChildtoChild(id,objeto){
    let objetoID=document.getElementById(id);
    objetoID.appendChild(objeto);
  }
  
//_____________CAMBIAR ID__________________
  setId(identificador,newId){
    let change=document.getElementById(identificador);
    change.id=newId;
  }
  
}

/*ObjetozStyle:
--Esta clase extiende de Objetoz y almacena etiquetas prediseñadas. Para usarlo basta con llamar a su metodo crear el cual hereda de Objetoz, una vez este creado indicamos el estilo que queremos para nuestro objeto, estos objetos solicitan informacion para agregar a sus sub elementos.*/
export default class ObjetozStyle extends Objetoz {

  formStyleAjax(leyenda, etiqueta, place, bt,link1,link2,identificador) {
    
    let formulario=document.getElementById(identificador);
    formulario.className="formulario";
    //_______Creacion del elementos_______
    let fieldset = this.crear('fieldset',leyenda);
    let div=this.crear('div',leyenda+'Div');
    let legend = this.crear('legend',leyenda+'Legend');
    let label = this.crear('label',leyenda+'Label');
    let input = this.crear('input',leyenda+'Input');
    let boton = this.crear('button',leyenda+'Button');
    let footer = this.crear('footer',leyenda+'Footer');
    let code = this.crear('code',leyenda+'Code');
    let a = this.crear('a',leyenda+'A');
    let a$ = this.crear('a',leyenda+'A2');
    
    //______Texto en pantalla_____
    legend.innerHTML = leyenda;
    label.innerHTML = etiqueta;
    input.placeholder = place;
    boton.innerHTML = bt;  
    a.innerHTML = link1;
    a$.innerHTML = link2;  
    //________Clases para css______
    a.className="links";
    a$.className="links";
    label.className="tag_label";
    input.className = "box_text_registro";
    boton.className = "box_button";  
    div.className = "designsubform";  
    footer.className = "Opciones";  
    //________Agregar al document__________
    this.intoChildtoChild(identificador, fieldset);
    this.intoChildtoChild(fieldset.id,div);
    this.intoChildtoChild(fieldset.id, legend);
    this.intoChildtoChild(fieldset.id, footer);
    
    this.intoChildtoChild(div.id, label);
    this.intoChildtoChild(div.id, input);
    this.intoChildtoChild(div.id, boton);
   
    this.intoChildtoChild(footer.id, code);
    this.intoChildtoChild(code.id, a);
    this.intoChildtoChild(code.id, a$);
  }
  
  formStyleDefault(leyenda, etiqueta, place, bt,identificador) {
    let fieldset = this.crear('fieldset',leyenda);
    let legend = this.crear('legend',leyenda+'Legend');
    let label = this.crear('label',leyenda+'Label');
    let input = this.crear('input',leyenda+'Input');
    let boton = this.crear('button',leyenda+'Button');


    fieldset.style = "color:black";
    legend.innerHTML = leyenda;
    label.innerHTML = etiqueta;
    input.placeholder = place;
    boton.innerHTML = bt;

    this.intoChildtoChild(identificador, fieldset);
    this.intoChildtoChild(fieldset.id, legend);
    this.intoChildtoChild(fieldset.id, label);
    this.intoChildtoChild(fieldset.id, input);
    this.intoChildtoChild(fieldset.id, boton);
  }
  
  formStyleLogin(leyenda, etiqueta, place, bt,identificador) {
    let fieldset = this.crear('fieldset',leyenda);
    let legend = this.crear('legend',leyenda+'Legend');
    let label = this.crear('label',leyenda+'Label');
    let input = this.crear('input',leyenda+'Input');
    let boton = this.crear('button',leyenda+'Button');


    fieldset.style = "color:black";
    legend.innerHTML = leyenda;
    label.innerHTML = etiqueta;
    input.placeholder = place;
    boton.innerHTML = bt;

    this.intoChildtoChild(identificador, fieldset);
    this.intoChildtoChild(fieldset.id, legend);
    this.intoChildtoChild(fieldset.id, label);
    this.intoChildtoChild(fieldset.id, input);
    this.intoChildtoChild(fieldset.id, boton);
  }
}