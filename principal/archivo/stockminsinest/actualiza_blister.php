<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$cr  	 = $_REQUEST['cr'];
$codpro	 = $_REQUEST['codpro'];
$bli	 = $_REQUEST['blister'];
$marca	 = $_REQUEST['marca'];
mysqli_query($conexion,"UPDATE producto set blister='$bli' where codpro = '$codpro'");
header("Location: stockmin1.php?codpro=$codpro&country_ID=$marca&cr=$cr&val=1");
?>
