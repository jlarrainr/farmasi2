<?php require_once('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
?>
<script>
	location.href = '../venta_index2.php';
</script>