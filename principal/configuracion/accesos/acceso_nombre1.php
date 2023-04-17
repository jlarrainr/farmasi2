<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$grup = $_REQUEST['grup'];
$codgrup = $_REQUEST['codu'];

$grup1 = strtoupper($grup);

$sql = "SELECT nomgrup FROM grupo_user WHERE nomgrup = '$grup1'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result))
{
	header("Location: acceso_nombre.php?error=1&val=1");
}
else
{
mysqli_query($conexion,"UPDATE grupo_user set nomgrup='$grup1' where codgrup = '$codgrup'");
header("Location: acceso_nombre.php?ok=1&val=1");
}
?>
?>