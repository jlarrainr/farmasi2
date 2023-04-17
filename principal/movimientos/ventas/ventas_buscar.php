<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
$_SESSION['cotizacion']	= '';
require_once('../../../conexion.php');
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once('../tabla_local.php'); //////CODIGO Y NOMBRE DEL LOCAL
$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$codloc    = $row1['codloc'];
	}
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$nomloc    = $row['nomloc'];
	}
}

if (isset($_SESSION['arr_detalle_venta'])) {
	$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
	$arr_detalle_venta = array();
}

if (!empty($arr_detalle_venta)) {
	foreach ($arr_detalle_venta as $row) {
		$codpro        = $row['codpro'];		/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
		$canpro        = $row['canpro'];		////CODIGO DEL PRODUCTO
		$fraccion      = $row['fraccion'];
		/////////////DATOS DEL PRODUCTO
		$sql1 = "SELECT stopro,factor,$tabla FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$stopro    = $row1['stopro'];
				$factor    = $row1['factor'];
				$cant_loc  = $row1[2];
			}
		}
		if ($fraccion == "F") {
			$canpro = $canpro * $factor;
		}
		$total_general = $stopro + $canpro;
		$total_local   = $cant_loc + $canpro;
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
	}
}
unset($_SESSION['arr_detalle_venta']);
mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$venta'");
mysqli_query($conexion, "DELETE from venta where invnum = '$venta'");
mysqli_close($conexion);
header("Location: ventas.php");
