<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum = $_SESSION['ingresos_val'];
$ref	= $_REQUEST['ref'];
$ref =strtoupper($ref)  ;

mysqli_query($conexion,"UPDATE movmae set refere = '$ref' where invnum = '$invnum'");
//echo $invnum;
?>