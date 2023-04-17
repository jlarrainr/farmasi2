<?php

include('../session_user.php');
require_once ('../../conexion.php');
require_once('../../convertfecha.php'); 

 
$vencimiento = trim($_REQUEST['vencimiento']);
$numeroLote= strtoupper(trim($_REQUEST['numeroLote']));
$idlote= $_REQUEST['idlote'];
 

mysqli_query($conexion, "UPDATE movlote set  numlote='$numeroLote',vencim='$vencimiento' where idlote = '$idlote'");
echo $invnum;
