function phpData(url) {

  const xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.status == 200 && this.readyState == 4) {
      let datos = JSON.parse(this.responseText);
      validarData(datos);
    }

  }
}

function validarData(datos) {
  const online = Boolean(datos.nombre);
  if (!online) {
    let body = document.getElementById("body");
    body.remove();
    window.location = "signIn.html";
  } else {
    if (hereNot()) {
      alert("BIENVENIDE "+datos.nombre);
    }
   
  }

}

function hereNot() {
  /* var ubi=window.location;
  alert(ubi);*/
  let ubi = window.location;
  let ubiNot = new Array(
    'http://localhost:8080/logIn.html',
    'http://localhost:8080/signIn.html',
    'http://localhost:8080/recuperarCuenta.html'
  );

  for (let url of ubiNot) {
    if (ubi == url) {
      document.body.remove();
      window.location = "Home.html";
      return true;
    }
  }
}
let url = 'http://localhost:8080/dataUserJSON.php';
phpData(url);
//hereNot();