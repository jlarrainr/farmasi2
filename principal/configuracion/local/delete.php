<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$local	= $_REQUEST['local'];
$nom 	= $_REQUEST['nom'];
$val 	= $_REQUEST['val'];
$tip 	= $_REQUEST['tip'];
$tipdocu 	= $_REQUEST['tipdocu'];
$codformato 	= $_REQUEST['codformato'];
mysqli_query($conexion,"delete from formato where codformato = '$codformato'");
header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu"); 
?>