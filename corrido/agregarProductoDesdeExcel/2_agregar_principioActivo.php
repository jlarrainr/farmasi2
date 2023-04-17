<?php
require_once('../../conexion.php');

mysqli_query($conexion, "DELETE FROM `titultabladet` WHERE  tiptab='F' ");

$sql= "SELECT principioActivo FROM `producto_Excel` GROUP by principioActivo";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $principioActivo   = $row['principioActivo'];
        $principioActivo= trim($principioActivo);
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('F','$principioActivo','$principioActivo')");
    
    }
}


$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='F' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       mysqli_query($conexion, "UPDATE producto_Excel set codigo_principioActivo = '$codtab' WHERE principioActivo='$destab' ");
    }
}