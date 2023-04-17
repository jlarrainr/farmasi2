<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$grup = $_REQUEST['grup'];
$sql = "SELECT nomgrup FROM grupo_user WHERE nomgrup = '$grup'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result))
{
	header("Location: acceso_grup.php?error=1&val=1");
}
else
{
mysqli_query($conexion,"INSERT INTO grupo_user(nomgrup) values ('$grup')");
header("Location: acceso_grup.php?ok=1&val=1");
}
?>