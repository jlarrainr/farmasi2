<?php 
include('session_user.php');
require_once('../conexion.php');
require_once('../titulo_sist.php');
$telefono = $_REQUEST['telefono'];
$to = "eduarbe.13@gmail.com";
$subject = "PIDE INFORMACION";
//$message = $desemp.' ,Telefono = '.$telefonoemp. " pide informacion por mensaje solicitado.";
$message = $desemp.' ,Telefono = '.$telefono. " pide informacion por mensaje solicitado.";
//$headers = "From: www.farmasis.site" . "\r\n" . "CC: destinatarioencopia@email.com";
$headers = "From: www.farmasis.site" . "\r\n"  ;
 
mail($to, $subject, $message, $headers);
  

 $fecha_actual = date('Y-m-d');
//mysqli_query($conexion, "UPDATE datagen set fecha_mensaje = '$fecha_actual' ");
      
      
   
  
header("Location: index.php"); 