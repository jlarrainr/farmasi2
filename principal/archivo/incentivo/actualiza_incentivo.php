<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$desc	= $_REQUEST['d'];
$invnum	= $_REQUEST['inv'];
mysqli_query($conexion,"UPDATE incentivado set descripcion = '$desc' where invnum = '$invnum'");
?>