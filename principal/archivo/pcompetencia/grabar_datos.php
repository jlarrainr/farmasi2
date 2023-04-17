<?php include('../../session_user.php');
require_once('../../../conexion.php');
$p1       = $_REQUEST['p1'];
$p2       = $_REQUEST['p2'];
$p3       = $_REQUEST['p3'];
$p4       = $_REQUEST['p4'];
$p5       = $_REQUEST['p5'];
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
mysqli_query($conexion,"UPDATE producto set pcomp1 = '$p1', pcomp2 = '$p2',pcomp3 = '$p3', pcomp4 = '$p4', pcomp5 = '$p5' where codpro = '$codpro'");
header("Location: pcompetencia2.php?codpro=$codpro&val=1");
?>