<?php require_once('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../../conexion.php');
$nommedico     = $_REQUEST['nommedico'];
$colegiatura	 = $_REQUEST['colegiatura'];
$especialidad	 = $_REQUEST['especialidad'];

// echo $especialidad;

if (is_numeric($especialidad)) {
	$sql1 = "SELECT id,nombre FROM especialidad_medica where id = '$especialidad' ";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$destab    = $row1['nombre'];
		}
	}
} else {
	$especialidad = strtoupper($especialidad);
	mysqli_query($conexion, "INSERT INTO especialidad_medica (nombre ) values ('$especialidad')");
	$id_especial = mysqli_insert_id($conexion);
	$destab = $especialidad;
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

mysqli_query($conexion, "INSERT INTO medico (nommedico,codcolegiatura,TIPO) values ('$nommedico','$colegiatura','$destab')");
mysqli_query($conexion, "UPDATE cotizacion set codmed = '$codmed' where invnum = '$venta'");
// mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codmed' where invnum = '$venta'");


header("Location: f3.php?close=2");
