<?php
require_once('../../conexion.php');

mysqli_query($conexion, "DELETE FROM `titultabladet` WHERE  tiptab='M' ");



$sql= "SELECT nombreMarca FROM `producto_Excel` GROUP by nombreMarca";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $nombreMarca   = $row['nombreMarca'];
       $nombreMarca= trim($nombreMarca);
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('M','$nombreMarca','$nombreMarca')");
    
    }
}


$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='M' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       mysqli_query($conexion, "UPDATE producto_Excel set codigo_marca = '$codtab' WHERE nombreMarca='$destab' ");
    }
}