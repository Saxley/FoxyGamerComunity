/*Asinc:
--Esta clase nos permite trabajar con fetch, enviar y recibir informacion del servidor.*/
export default class Asinc {
  /*enviar:
  --Recibe una url,un metodo de envio,el id del formulario a enviar, el id de donde se va recibir la info y el id del usuario,esto último es para almacenar el id en caso de que sea necesario buscarlo.*/
  enviar(url, metodo, idformulario,idMessage,idUser) {
    const formulario = document.getElementById(idformulario);
    const MessageBox = document.getElementById(idMessage);
    const identificador = document.getElementById(idUser);
    const meto = metodo;
    const link = url;
    let info;

    let t=formulario.addEventListener("submit", (function (e) {
      e.preventDefault();
      let datos = new FormData(formulario);
      fetch(link, {
        method: meto,
        body: datos
      })
      .then(response => {
        data = response.json()
        .then(data => {
          if(Boolean(data.id)){
            identificador.value=data.id;
          }
          MessageBox.innerHTML = data.peticion;
        })
      })
      .catch(err=> {
        MessageBox.innerHTML = err;
      })
    }));
 
  }
  
}