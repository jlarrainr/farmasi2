<?php require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
$codmed = $_REQUEST['codmed'];
$sql="SELECT codmed,nommedico,codcolegiatura FROM medico where codmed = '$codmed'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codmed           = $row["codmed"];
	$nommedico        = $row["nommedico"];
	$codcolegiatura   = $row["codcolegiatura"];
	mysqli_query($conexion, "UPDATE venta set codmed = '$codmed' where invnum = '$venta'");
	mysqli_query($conexion, "UPDATE temp_venta set codmed = '$codmed' where invnum = '$venta'");
}
}
?>
<script>
	location.href='../venta_index2.php';
</script>