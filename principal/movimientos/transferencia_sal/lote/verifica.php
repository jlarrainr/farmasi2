<?php include('../../../session_user.php');
$invnum  = $_SESSION['transferencia_sal'];
require_once ('../../../../conexion.php');
$numero  = $_REQUEST['country'];
$codpro  = $_REQUEST['codpro'];
if ($numero <> "")
{
		mysqli_query($conexion, "UPDATE tempmovmov set numlote = '$numero' where invnum = '$invnum' and codpro = '$codpro'");
}
header("Location: lote.php?cod=$codpro");
?>