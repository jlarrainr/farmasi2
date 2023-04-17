<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum = $_SESSION['transferencia_sal'];
$ref	= $_REQUEST['ref'];
$vend	= $_REQUEST['vend'];
$local	= $_REQUEST['local'];

$ref	= strtoupper($ref);
mysqli_query($conexion,"UPDATE movmae set refere = '$ref',codusu = '$vend',sucursal1 = '$local' where invnum = '$invnum'");
?>