<?php
require_once('../../conexion.php');

mysqli_query($conexion, "DELETE FROM `titultabladet` WHERE  tiptab='U' ");
$sql= "SELECT accionTerapeutica FROM `producto_Excel` GROUP by accionTerapeutica";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $accionTerapeutica   = $row['accionTerapeutica'];
        $accionTerapeutica= trim($accionTerapeutica);
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('U','$accionTerapeutica','$accionTerapeutica')");
    
    }
}


$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='U' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       mysqli_query($conexion, "UPDATE producto_Excel set codigo_accionTerapeutica = '$codtab' WHERE accionTerapeutica='$destab' ");
    }
}