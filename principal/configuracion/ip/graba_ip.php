<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
$local	= $_POST['local'];
$ip  	= $_POST['ip'];
$sql = "SELECT ip FROM numberip WHERE ip = '$ip'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result))
{
header("Location: ip1.php?error=2");
}
else
{
mysqli_query($conexion,"INSERT INTO numberip (ip,codloc) values ('$ip','$local')");
header("Location: ip1.php?ok=1"); 
}
?>