<?php include('../../session_user.php');
require_once ('../../../conexion.php');
require_once ('../../../convertfecha.php');
$invnum = $_SESSION['compras'];
$date1	= fecha1($_REQUEST['date1']);
$n1		= $_REQUEST['n1'];
$n2		= $_REQUEST['n2'];
$moneda	= $_REQUEST['moneda'];
$plazo	= $_REQUEST['plazo'];
$date2	= fecha1($_REQUEST['date2']);
$fpag	= $_REQUEST['fpag'];
mysqli_query($conexion,"UPDATE movmae set fecdoc = '$date1', numero_documento = '$n1', numero_documento1 = '$n2', moneda = '$moneda',plazo = '$plazo',fecven = '$date2',forpag = '$fpag' where invnum = '$invnum'");
echo $invnum;
?>