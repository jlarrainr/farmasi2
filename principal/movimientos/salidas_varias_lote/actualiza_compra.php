<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum = $_SESSION['transferencia_sal_val'];
$ref	= $_REQUEST['ref'];
mysqli_query($conexion,"UPDATE movmae set refere = '$ref' where invnum = '$invnum'");
//echo $invnum;
?>