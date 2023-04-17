<?php include('../../session_user.php');
require_once('../../../conexion.php');
$pventa   = $_REQUEST['pventa'];
$codpro   = $_REQUEST['codpro'];
$factor   = $_REQUEST['factor'];
$marca    = $_REQUEST['marca'];
$val      = $_REQUEST['val'];
$preuni   = $pventa/$factor;
mysqli_query($conexion,"UPDATE producto set prevta = '$pventa', preuni = '$preuni',modifpcosto = '1' where codpro = '$codpro'");
header("Location: ingresos2.php?marca=$marca&val=1");
?>