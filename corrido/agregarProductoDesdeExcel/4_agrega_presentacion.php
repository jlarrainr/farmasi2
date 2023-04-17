<?php
require_once('../../conexion.php');

mysqli_query($conexion, "DELETE FROM `titultabladet` WHERE  tiptab='PRES' ");
$sql= "SELECT presentacion FROM `producto_Excel` GROUP by presentacion";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $presentacion   = $row['presentacion'];
      $presentacion= trim($presentacion);
       
       
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('PRES','$presentacion','$presentacion')");
    
        
    }
    
     
}
$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='PRES' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       
       mysqli_query($conexion, "UPDATE producto_Excel set codigo_presentacion = '$codtab' WHERE presentacion='$destab' ");
       
    }
}