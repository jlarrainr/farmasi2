<?php
require_once('conexion.php');


$sql= "SELECT nombre FROM `producto_farmasol` GROUP by nombre";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $nombre   = $row['nombre'];
       
       
       
       //echo '$nombre = '. $nombre."<br>";
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('M','$nombre','$nombre')");
    
        
    }
    
     
}


$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='M' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       
       
       mysqli_query($conexion, "UPDATE producto_farmasol set codigo_marca = '$codtab' WHERE nombre='$destab' ");
       //echo '$nombre = '. $nombre."<br>";
       //mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('M','$nombre','$nombre')");
    
        
    }
    
     
}