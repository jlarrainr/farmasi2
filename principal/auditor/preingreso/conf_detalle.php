<?php include('../../session_user.php');
require_once('../../../conexion.php');
$invnum = $_REQUEST['invnum'];
$codpro = $_REQUEST['codpro'];
$conf   = $_REQUEST['conf'];
if ($conf == 1)
{
$confx = 0;
}
else
{
$confx = 1;
}
mysqli_query($conexion,"UPDATE ordmov set confirmar = '$confx' where invnum = '$invnum' and codpro = '$codpro'");
header("Location: ver_compras.php?invnum=$invnum");
?>