<?php
include('../../../session_user.php');
require_once('../../../../conexion.php'); //CONEXION A BASE DE 
require_once('../../../../titulo_sist.php'); //CONEXION A BASE DE 


$sql_usuario = "SELECT nomusu  FROM usuario where usecod = '$usuario'";
$result_usuario = mysqli_query($conexion, $sql_usuario);
if (mysqli_num_rows($result_usuario)) {
	while ($row_usuario = mysqli_fetch_array($result_usuario)) {
		$nomusu = $row_usuario['nomusu'];
	}
}


$fecha_actual = date('Y/m/d');
$hora_actual = date("H:i:s");

$entrada = $_REQUEST['entrada'];
$id_arqueo = $_REQUEST['id_arqueo'];


$inicio_caja = $_REQUEST['inicio_caja'];


if ($entrada == 1) {

	mysqli_query($conexion, "INSERT INTO arqueo_caja( codigo_usuario,fecha_inicio,monto_inicio,hora_inicio,estado) VALUES ('$usuario','$fecha_actual','$inicio_caja','$hora_actual','0')");
} elseif ($entrada == 2) {

	$monto_cierre = $_REQUEST['monto_cierre'];
	$monto_agregado = $_REQUEST['monto_agregado'];
	$detalle_monto_agregado = $_REQUEST['detalle_monto_agregado'];

	$venta_efectivo = $_REQUEST['venta_efectivo'];
	$venta_credito = $_REQUEST['venta_credito'];
	$venta_tarjeta = $_REQUEST['venta_tarjeta'];


	if ($monto_cierre == $venta_efectivo) {
		$comparativa = '0';
	} elseif ($monto_cierre > $venta_efectivo) {
		$comparativa = '1';
	} elseif ($monto_cierre < $venta_efectivo) {
		$comparativa = '2';
	}

	$sqlx = "SELECT * FROM arqueo_caja where codigo_usuario= '$usuario' ORDER by id DESC LIMIT 1 ";

	$resultx = mysqli_query($conexion, $sqlx);
	if (mysqli_num_rows($resultx)) {
		while ($rowx = mysqli_fetch_array($resultx)) {
			$id    = $rowx['id'];
		}
	}

	if ($id != '') {
		mysqli_query($conexion, "UPDATE arqueo_caja set monto_cierre  = '$monto_cierre',monto_agregado='$monto_agregado',detalle_monto_agregado='$detalle_monto_agregado',fecha_cierre='$fecha_actual',hora_cierre='$hora_actual',venta_efectivo='$venta_efectivo',venta_credito='$venta_credito',venta_tarjeta='$venta_tarjeta',comparativa='$comparativa' ,estado='1'    where codigo_usuario = '$usuario' and id = '$id'");
	}
} elseif ($entrada == 3) {

	$monto_cierre = $_REQUEST['monto_cierre'];
	$monto_agregado = $_REQUEST['monto_agregado'];
	$detalle_monto_agregado = $_REQUEST['detalle_monto_agregado'];

	$venta_efectivo = $_REQUEST['venta_efectivo'];
	$venta_credito = $_REQUEST['venta_credito'];
	$venta_tarjeta = $_REQUEST['venta_tarjeta'];


	if ($monto_cierre == $venta_efectivo) {
		$comparativa = '0';
	} elseif ($monto_cierre > $venta_efectivo) {
		$comparativa = '1';
	} elseif ($monto_cierre < $venta_efectivo) {
		$comparativa = '2';
	}


	if ($id_arqueo != '') {
		mysqli_query($conexion, "UPDATE arqueo_caja set monto_cierre  = '$monto_cierre',monto_agregado='$monto_agregado',detalle_monto_agregado='$detalle_monto_agregado',fecha_cierre='$fecha_actual',hora_cierre='$hora_actual',venta_efectivo='$venta_efectivo',venta_credito='$venta_credito',venta_tarjeta='$venta_tarjeta',comparativa='$comparativa' ,estado='1'    where codigo_usuario = '$usuario' and id = '$id_arqueo'");
	}

	$to = "fallascfcsystem@gmail.com";
	$subject = "PROBLEMAS DE CIERRE DE CAJA";
	// $message = $desemp . " esta vendiendo con multiples pantallas el usuario :" . $nomusu .;
	$message = $desemp . ' ,el usuario = ' . $nomusu . 'con codigo : ' . $usuario . " ,esta haciendo un cierre de caja de un dia que no le corresponde, comunicarse con el representante de '. $desemp .', para comunicarle lo sucedido, gracias .";
	$headers = "From: www.farmasis.site" . "\r\n";
	mail($to, $subject, $message, $headers);
}

if ($entrada == 1) {
	header("Location: arqueo_caja.php?close=1");
} else {
	header("Location: arqueo_caja.php?close=2");
}
