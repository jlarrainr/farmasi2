<?php

require_once ('../../conexion.php'); //CONEXION A BASE DE DATOS
if (isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])) {
    $letters = $_REQUEST['letters'];
    //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
    /* $sql="SELECT limite FROM datagen_det";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
      while ($row = mysqli_fetch_array($result)){
      $limit             = $row["limite"];
      }
      }
     */
    //$res = mysqli_query($conexion,"select codpro,desprod from producto where desprod like '".$letters."%' limit $limit") or die(mysqli_error());
    $t = $letters / 1;
    $res = mysqli_query($conexion, "select codtab,destab from titultabladet where tiptab = 'M' and destab like '" . $letters . "%'") or die(mysqli_error());
    #echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
    while ($inf = mysqli_fetch_array($res)) {
        echo $inf["codtab"] . "###" . $inf["destab"] . "|";
    }
}
?>
