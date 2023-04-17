<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$idacceso = $_REQUEST['idacceso'];
$item 	  = $_REQUEST['items'];
$nom      = $_REQUEST['nom'];
$sql = "SELECT item,nombre FROM acceso WHERE idacceso = '$idacceso'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result)){
while ($row = mysqli_fetch_array($result)){
	   $items           = $row['item'];
	   $nombres         = $row['nombre'];
}
}
if (($item == $items) && ($nombres == $nom))
{
	header("Location: items1.php");
}
else
{
	if ($item == $items)
	{
		$sql = "SELECT nombre FROM acceso WHERE nombre = '$nom'";
		$result = mysqli_query($conexion,$sql);
		if($row = mysqli_fetch_array($result))
		{
		header("Location: items1.php?error=1");
		}
		else
		{
		mysqli_query($conexion,"UPDATE acceso set nombre = '$nom' where idacceso = '$idacceso'");
		header("Location: items1.php");
		}
	}
	else
	{
		if ($nombres == $nom)
		{
			$sql = "SELECT item FROM acceso WHERE item = '$item'";
			$result = mysqli_query($conexion,$sql);
			if($row = mysqli_fetch_array($result))
			{
			header("Location: items1.php?error=1");
			}
			else
			{
			mysqli_query($conexion,"UPDATE acceso set item = '$item' where idacceso = '$idacceso'");
			header("Location: items1.php");
			}
		}
		else
		{
			$sql = "SELECT item,nombre FROM acceso where item = '$item' and nombre = '$nom'";
			$result = mysqli_query($conexion,$sql);
			if($row = mysqli_fetch_array($result))
			{
			header("Location: items1.php?error=1");
			}
			else
			{
			mysqli_query($conexion,"UPDATE acceso set item = '$item', nombre = '$nom' where idacceso = '$idacceso'");
			header("Location: items1.php");
			}
		}
	}
}
?>