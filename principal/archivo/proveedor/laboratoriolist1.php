<?php include('../../session_user.php');
require_once('../../../conexion.php');
$cp         = $_REQUEST['cp'];
$codtab     = $_REQUEST['codtab'];
$st         = $_REQUEST['st'];
if ($st == 0)
{
$st = 1;
}
else
{
$st = 0;
}
$sql="SELECT coddet,state FROM provlab where codpro = '$cp' and codtab='$codtab'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	$sihay = 1;
}
else
{
	$sihay = 0;
}
if ($sihay == 1)
{
mysqli_query($conexion,"UPDATE provlab set state = '$st' where codpro = '$cp' and codtab='$codtab'");
}
else
{
mysqli_query($conexion,"INSERT INTO provlab (codpro,codtab,state) values ('$cp','$codtab','$st')");
}
header("Location: proveedor1.php?codpro=$cp");
?>