<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum  = $_SESSION['transferencia_sal'];
$vendedor= $_REQUEST['vendedor']; 
$local   = $_REQUEST['local']; 
mysqli_query($conexion,"UPDATE movmae set codusu = '$vendedor',sucursal1 = '$local' where invnum = '$invnum'");
header("Location: transferencia1_sal.php"); 
?>