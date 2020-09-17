/*performance.navigation.type(1):
  Detecta que se accedio a la pagina, recargando la misma*/
 if(performance.navigation.type == 1){
      window.location="index.php";
}
/*performance.navigation.type(2):
  Detecta que se accedio a la pagina desde el historial*/
 if(performance.navigation.type == 2){
      window.location="index.php";
}