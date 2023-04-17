<?php 
include('../../session_user.php');
require_once('../../../conexion.php');

$Nuevocontvistos = 0;
$sql1 = "SELECT contvistos FROM datagen";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
      $contvistos    = $row1['contvistos'];
      
      
      $Nuevocontvistos = $contvistos + 1;
        mysqli_query($conexion, "UPDATE datagen set contvistos = '$Nuevocontvistos' ");
      
      
    }
    
    
  }
  
  header("Location: ventas_registro.php"); 