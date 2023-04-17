<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$codtemp = $_POST['codtemp'];
if ($cod <> ""){
mysqli_query($conexion,"DELETE from tempmovmov where codtemp = '$cod'");
mysqli_query($conexion,"DELETE from templote where codtemp = '$cod'  ");
}
if ($codtemp <> ""){
$text1 = $_POST['text1'];	///cantidad ingresada
$text2 = $_POST['text2'];	///precio promedio
$text3 = $_POST['text3'];	///total
$numlote = $_POST['numlote'];	///total
$mesL = $_REQUEST['mesL']; ///vencimiento
$yearsL = $_REQUEST['yearsL']; ///vencimiento
$locall = $_REQUEST['locall']; ///local
$usu = $_REQUEST['usu']; ///usuario
$number = $_POST['number']; ///factor


$cuento = strlen($mesL);
if ($cuento == '2') {
    $mes = $mesL;
} else {
    $mes = '0' . $mesL;
}

$textven = $mes . "/" . $yearsL;



if ($costpr == 0)
{
$costpr = 1;
}
if ($number == 0)
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', prisal = '$text3', costre = '$text2',costpr= '$text3',numlote='$numlote' where codtemp = '$codtemp'");
mysqli_query($conexion,"UPDATE templote set numerolote = '$numlote', vencim ='$textven',registrado='$usu',codloc='$locall' where codtemp = '$codtemp'");
}
else
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', prisal = '$text3', costre = '$text2',costpr= '$text3',numlote='$numlote' where codtemp = '$codtemp'");
mysqli_query($conexion,"UPDATE templote set numerolote = '$numlote', vencim ='$textven',registrado='$usu',codloc='$locall' where codtemp = '$codtemp'");
}
}
header("Location: ingresos_varios1.php"); 
?>