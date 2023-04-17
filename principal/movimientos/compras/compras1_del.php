<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
	while ($row = mysqli_fetch_array($resultP)) {
		$precios_por_local = $row['precios_por_local'];
	}
}
if ($precios_por_local  == 1) {
	require_once '../../../precios_por_local.php';
}

$invnum	 = $_POST['cod'];
$ok  	 = $_POST['ok'];
$sql = "SELECT codpro FROM tempmovmov where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codpro    = $row['codpro'];

		if ($precios_por_local == 1) {

			if (($zzcodloc == 1)) {

				mysqli_query($conexion, "UPDATE producto set tcosto = '0',tmargene = '0',tprevta= '0',tpreuni = '0' where codpro = '$codpro'");
			} else {

				mysqli_query($conexion, "UPDATE precios_por_local set $tcosto_p = '0',$tmargene_p = '0',$tprevta_p= '0',$tpreuni_p = '0' where codpro = '$codpro'");
			}
		} else {

			mysqli_query($conexion, "UPDATE producto set tcosto = '0',tmargene = '0',tprevta= '0',tpreuni = '0' where codpro = '$codpro'");
		}
	}
}
mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$invnum'");
mysqli_query($conexion, "DELETE from tempmovmov_bonif where invnum = '$invnum'");
mysqli_query($conexion, "DELETE from movmov where invnum = '$invnum'");
mysqli_query($conexion, "DELETE from templote where invnum = '$invnum'");
mysqli_query($conexion, "DELETE from movmae where invnum = '$invnum'");
header("Location: ../ing_salid.php");
