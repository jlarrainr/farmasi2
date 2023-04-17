<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
$codip	= $_REQUEST['codip'];
$ip  	= $_REQUEST['ip'];
$sql = "SELECT ip FROM numberip WHERE ip = '$ip' and codip <> '$codip'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result))
{
header("Location: ip2.php?error=2");
}
else
{
mysqli_query($conexion,"update numberip set ip = '$ip' where codip = '$codip'");
header("Location: ip2.php?ok=1"); 
}
?>