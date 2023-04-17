<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$ip  	= $_REQUEST['ip'];
$nom  	= $_REQUEST['local'];
require_once('detecta_ip.php');
$ip		= $detect_ip;
$sql = "SELECT ip FROM numberip WHERE ip = '$ip' and codloc = '$nom'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result))
{
header("Location: index1.php?error=2");
}
else
{
mysqli_query($conexion,"INSERT INTO numberip (ip,codloc) values ('$ip','$nom')");
header("Location: index1.php?ok=1"); 
}
?>