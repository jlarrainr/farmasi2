<?php

include('../../session_user.php');
require_once ('../../../conexion.php');
$transferencia_ing = $_SESSION['transferencia_ing'];
$doc = $_REQUEST['doc'];
$val = $_REQUEST['val'];
$local = $_REQUEST['local'];
$number = $_REQUEST['number'];
$produc = $_REQUEST['produc'];
$text1 = $_REQUEST['text1']; ///cantidad ingresada
$text2 = $_REQUEST['text2']; ///precio promedio
$text3 = $_REQUEST['text3']; ///total
$invnumrecib = $_REQUEST['invnumrecib'];
/* $sql="SELECT codtemp FROM tempmovmov order by codtemp limit 1";
  $result = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($result)){
  while ($row = mysqli_fetch_array($result)){
  $codtemp       = $row[0];
  }
  $codtemp = $codtemp + 1;
  }
  else
  {
  $codtemp = 1;
  } */
if ($number == 0) {
    $sql1 = "INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr,invnumrecib) values ('$transferencia_ing','$produc','$text1','$text2','777','$text2','$invnumrecib')";
    mysqli_query($conexion, $sql1);
//	if (mysqli_errno($conexion))
//		error_log("Agrega Linea Temp SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
} else {
    $sql1 = "INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr,invnumrecib) values ('$transferencia_ing','$produc','$text1','$text2','888','$text2','$invnumrecib')";
    mysqli_query($conexion, $sql1);
//	if (mysqli_errno($conexion))
//		error_log("Agrega Linea Temp SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
}
$pagina = 'transferencia2_ing.php?val=' . $val . '&doc=' . $doc . '&local=' . $local . '&local=' . $local;
header("Location: $pagina");
?>