<?php include('../../session_user.php');
require_once('../../../conexion.php');
$invnum = $_REQUEST['invnum'];
$conf   = $_REQUEST['conf'];
if ($conf == 1)
{
$confx = 0;
}
else
{
$confx = 1;
}
mysqli_query($conexion,"UPDATE ordmae set confirmado = '$confx' where invnum = '$invnum'");
mysqli_query($conexion,"UPDATE ordmov set confirmar = '$confx' where invnum = '$invnum'");
header("Location: preingreso2.php");
?>