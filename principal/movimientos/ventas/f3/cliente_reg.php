<?php require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');
$nommedico     = $_REQUEST['nommedico'];
$colegiatura	 = $_REQUEST['colegiatura'];
$especialidad	 = $_REQUEST['especialidad'];

$sql1 = "SELECT codtab,destab FROM titultabladet where codtab = '$especialidad' ";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$destab    = $row1['destab'];
	}
}
$sql1 = "SELECT codmed FROM medico order by codmed desc limit 1";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$codmed    = $row1['codmed'];
	}
	++$codmed;
} else {
	$codmed = 1;
}
mysqli_query($conexion, "INSERT INTO medico (codmed,nommedico,codcolegiatura,TIPO) values ($codmed,'$nommedico','$colegiatura','$destab')");
mysqli_query($conexion, "UPDATE venta set codmed = '$codmed' where invnum = '$venta'");
// mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codmed' where invnum = '$venta'");
header("Location: f3.php?close=2");
