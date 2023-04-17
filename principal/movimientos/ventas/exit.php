<?php
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
$mont5	 = $monto_total;		///TOTAL
$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$total_costo = 0;
$sql1 = "SELECT cuscod,usecod,sucursal FROM venta where invnum = '$venta'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$cuscod    = $row1['cuscod'];
		$usecod    = $row1['usecod'];
		$sucursal  = $row1['sucursal'];
	}
}
if (isset($_SESSION['arr_detalle_venta'])) {
	$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
	$arr_detalle_venta = array();
}
if (!empty($arr_detalle_venta)) {
	foreach ($arr_detalle_venta as $row1) {
		$codpro    = $row1['codpro'];
		$date	   = $row1['invfec'];
		$cuscod    = $row1['cuscod'];
		$usuario   = $row1['usecod'];
		$codmar    = $row1['codmar'];
		$canpro    = $row1['canpro'];
		$cospro    = $row1['cospro'];
		$costpr    = $row1['costpr'];
		$fraccion  = $row1['fraccion'];
		$factor    = $row1['factor'];
		$prisal    = $row1['prisal'];		////PRECIO UNITARIO
		$pripro    = $row1['pripro'];		////MONTO VENTA
		$total_costo = $total_costo + $cospro;
		if ($fraccion == "T") {
			$fraccion = "T";
			$cantidad_kardex = "f" . $canpro;
		} else {
			$fraccion = "F";
			$cantidad_kardex = $canpro;
		}
		mysqli_query($conexion, "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$codmar','$cospro','$costpr')");
	}
}

unset($_SESSION['arr_detalle_venta']);
mysqli_query($conexion, "UPDATE venta set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo' where invnum = '$venta'");

mysqli_close($conexion);

header("Location: ventas_registro.php");
