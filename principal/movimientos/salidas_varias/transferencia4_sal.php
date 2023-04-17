<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$codtemp = $_POST['codtemp'];
if ($cod <> ""){
mysqli_query($conexion,"DELETE from tempmovmov where codtemp = '$cod'");
}
if ($codtemp <> ""){
$text1 = $_POST['text1'];	///cantidad ingresada

$text2 = $_POST['text2x'];	///precio promedio
$text3 = $_POST['subtotal2'];	///total

$number = $_POST['number']; ///factor
if ($costpr == 0)
{
$costpr = 1;
}
if ($number == 0)
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', pripro = '$text3', costre = '$text2',costpr= '$text3' where codtemp = '$codtemp'");
}
else
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', pripro = '$text3', costre = '$text2',costpr= '$text3' where codtemp = '$codtemp'");
}
}
header("Location: salidas_varias1.php"); 
?>