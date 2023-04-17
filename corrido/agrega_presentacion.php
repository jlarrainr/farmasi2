<?php
require_once('conexion.php');


$sql= "SELECT Clase FROM `producto_farmasol` GROUP by Clase";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $nombre   = $row['Clase'];
      $nombre= trim($nombre);
       
       
       //echo '$nombre = '. $nombre."<br>";
       mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,abrev) values ('CAT','$nombre','$nombre')");
    
        
    }
    
     
}
$sql= "SELECT codtab,destab FROM `titultabladet` WHERE tiptab='CAT' ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codtab   = $row['codtab'];
        $destab   = $row['destab'];
       
       
       mysqli_query($conexion, "UPDATE producto_farmasol set codigo_presen = '$codtab' WHERE Clase='$destab' ");
       
    
        
    }
    
     
}