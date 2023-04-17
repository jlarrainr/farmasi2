<?php

include('../../session_user.php');
require_once('../../../conexion.php');
$invnum = $_REQUEST['invnum'];
$codpro = $_REQUEST['codpro'];
$codloc = $_REQUEST['codloc'];

mysqli_query($conexion, "delete from incentivadodet where codpro = '$codpro' and invnum = '$invnum' and codloc = '$codloc'");

//mysqli_query($conexion, "UPDATE incentivadodet set estado=0, esta_desa=1 where codpro = '$codpro' and invnum = '$invnum' and codloc = '$codloc'");

mysqli_query($conexion, "UPDATE producto set incentivado='0' where codpro = '$codpro'");
header("Location: incentivohist2.php?invnum=$invnum");
?>