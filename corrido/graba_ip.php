<?php require_once('conexion.php');	//CONEXION A BASE DE DATOS
$local	= $_POST['local'];
$ip  	= $_POST['ip'];
		$sql = "SELECT ip FROM numberip WHERE ip = '$ip'";
		$result = mysqli_query($conexion,$sql);
		if($row = mysqli_fetch_array($result))
		{
		header("Location: agrega_ip.php?error=2");
		}
		else
		{
		mysqli_query($conexion,"INSERT INTO numberip (ip,codloc) values ('$ip','$local')");
		header("Location: agrega_ip.php?ok=1"); 
		}
?>