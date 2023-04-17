<?php include('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
$codcli = $_REQUEST['codcli'];
$sql="SELECT * FROM cliente where codcli = '$codcli'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codcli         = $row["codcli"];
	$descli         = $row["descli"];
	$dnicli         = $row["dnicli"];
	mysqli_query($conexion, "UPDATE cotizacion set cuscod = '$codcli' where invnum = '$venta'");
	mysqli_query($conexion, "UPDATE cotizacion_det set cuscod = '$codcli' where invnum = '$venta'");
}
}
?>
<script>
	location.href='../venta_index2.php';
</script>