<?php include('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$remesa   	= $_SESSION['remesa'];
$ingreso 	= $_REQUEST['ingreso'];
$referencia = $_REQUEST['referencia'];
$m 			= $_REQUEST['m'];
$monto 		= $_REQUEST['monto'];
$state 		= $_REQUEST['state'];
$t   		= $_REQUEST['t'];
if ($t == 1)
{
mysqli_query($conexion,"INSERT INTO gasres (invnum,codtab,refere,moneda,monto,estado,tiptab) values ('$remesa','$ingreso','$referencia','$m','$monto','$state','G')");
}
if ($t == 2)
{
$codt   		= $_REQUEST['codt'];
mysqli_query($conexion,"UPDATE gasres set codtab = '$ingreso',refere = '$referencia',moneda = '$m',monto = '$monto',estado = '$state' where invnum = '$remesa' and tiptab = '$codt'");
}
header("Location: f7.php?val=0");
?>