<?php $nom = $_REQUEST['nom'];
$trozos = explode(" ", $nom);
$nom    = $trozos[0]; 
$ape    = $trozos[1]; 
$ape1   = $trozos[2]; 
$nom	= substr($nom, 0, 1);
$ape	= substr($ape, 0, 1);
$ape1	= substr($ape1, 0, 1);
echo $nom.$ape.$ape1;
?>