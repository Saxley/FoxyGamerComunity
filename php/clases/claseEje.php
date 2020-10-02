<?php
class busqueda {
  /*Conectar:
  --Esta funcion consulta a la base de datos*/
  private function Conectar($ejecucion) {
    require 'php/intentoConexion.php';
    $hacer = mysqli_query($conn, $ejecucion);
    return $hacer;
    mysqli_close($conn);
  }
  /*comparar:
  --Esta funcion nos ayuda a comparar el dato que le pasemos con los que esten en la base de datos.*/
  public function comparar($dato,$datoB,$tabla) {
     $consulta="SELECT * FROM $tabla"; 
     $respuesta= $this->Conectar($consulta);
     $datoText="'".$dato."'";
     if($respuesta){
       while($colum = mysqli_fetch_array($respuesta)){
         $dColum=$colum[$dato];
         if($dColum==$datoB){
           return true;
         }
       }
       return false;
     }
  }
  /*getBusqueda:
  --Esta funcion nos trae de la base de datos informacion.*/
  
  public function getBusqueda($queBuscas, $apartirDe, $datoQueConoces, $deQuien) {
    $text_arr = '';
    foreach ($queBuscas as $info) {
      $text_arr = $info.','.$text_arr;
    }
    $text_arr = $text_arr.$apartirDe;
    $c = "SELECT $text_arr FROM $deQuien WHERE $apartirDe='$datoQueConoces'";
    $consulta = $this->Conectar($c);
    if ($consulta) {
      $colum = mysqli_fetch_array($consulta);

      for ($i = 0; $i < count($colum)/2; $i++) {
        $queBuscas[$i] = $colum[$i];
      }
      $queBuscas = array_reverse ($queBuscas);
      return $queBuscas;
    }
  }
  /*actualizar:
  --Esta funcion nos ayuda a actualizar nuestras tablas en la base de datos*/
  public function actualizar($updateData, $Change, $table, $where, $dataWhere) {
    $text_arr = '';
    for ($i = 0; $i < count($updateData); $i++) {
      if ($i != count($updateData)-1) {
        $text_arr = $updateData[$i].'='."'".$Change[$i]."'".','.$text_arr;
      } else {
        $text_arr = $text_arr.$updateData[$i].'='."'".$Change[$i]."'";
      }
    }
    $actualizar = "update $table set $text_arr WHERE $where='$dataWhere'";

    $exjecute = $this->Conectar($actualizar);
    return $exjecute;
  }
  /*insertar:
  --Esta funcion nos ayuda a insertar en nuestra base de datos.*/
  public function insertar($queIngresar, $dondeIngresar, $table) {
    $text_arr= array();
    for ($i = 0; $i < count($queIngresar); $i++) {
      if($i!=(count($queIngresar)-1)){
      $text_arr[0]="'".$queIngresar[$i]."'".','.$text_arr[0];
      $text_arr[1]=$dondeIngresar[$i].','.$text_arr[1];
      }else{
      $text_arr[0]=$text_arr[0]."'".$queIngresar[$i]."'";
      $text_arr[1]=$text_arr[1].$dondeIngresar[$i];
      }
    }
    $actualizar = "insert into $table($text_arr[1]) values($text_arr[0])";

    $exjecute = $this->Conectar($actualizar);
  
    return $exjecute;
  }
}