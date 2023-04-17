<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$items  = $_REQUEST['items'];
$nombre = $_REQUEST['nombre'];
$sql1="SELECT item FROM acceso where item = '$items'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1))
{
header("Location: items.php?error=1&val=1");
}
else
{
mysqli_query($conexion,"INSERT INTO acceso(item,nombre) values ('$items','$nombre')");
header("Location: items.php?ok=1&val=1");
}
?>