

function phpData(url){
  
  const xhr = new XMLHttpRequest();
  xhr.open("GET",url,true);
  xhr.send();
  
  xhr.onreadystatechange=function(){
     if(this.status==200 && this.readyState==4){
       let datos= JSON.parse(this.responseText);
         validarData(datos);
     }
  
  }
}

function validarData(datos){
const online= Boolean(datos.nombre);
         if(!online){
           let body=document.getElementById("body");
           body.remove();
           window.location = "signIn.html";
         }else{  
           alert("iniciaste sesion con "+datos.nombre);
         }
}
let url='http://localhost:8080/dataUserJSON.php';
 phpData(url);