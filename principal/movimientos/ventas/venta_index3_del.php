<?php
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
$cod	 = $_REQUEST['cod'];		///CODIGO DEL TEMPORAL UTILIZADO PARA ELIMINAR


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


if (isset($_SESSION['arr_detalle_venta'])) {
	$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
	$arr_detalle_venta = array();
}

if (!empty($arr_detalle_venta)) {
	if (isset($arr_detalle_venta[$cod])) {
		$row = $arr_detalle_venta[$cod];
		$codpro        = $row['codpro'];		/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
		$canpro        = $row['canpro'];		////CODIGO DEL PRODUCTO
		$fraccion      = $row['fraccion'];
		/////////////DATOS DEL PRODUCTO



		$sql1 = "SELECT stopro,factor,$tabla,codprobonif,codpro FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$stopro     = $row1['stopro'];
				$factor     = $row1['factor'];
				$codpro     = $row1['codpro'];
				$cant_loc   = $row1[2];

				if (($zzcodloc == 1) && ($precios_por_local == 1)) {
					$codprobonif = $row1['codprobonif'];
				} elseif ($precios_por_local == 0) {
					$codprobonif = $row1['codprobonif'];
				}

				if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

					$sql_precio = "SELECT $codprobonif_p FROM precios_por_local where codpro = '$codpro'";
					$result_precio = mysqli_query($conexion, $sql_precio);
					if (mysqli_num_rows($result_precio)) {
						while ($row_precio = mysqli_fetch_array($result_precio)) {
							$codprobonif = $row_precio[0];
						}
					}
				}
			}
		}
		$sql1 = "SELECT codpro,codkey,cajas FROM temp_vent_bonif where invnum = '$venta' and codprobonif = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$codprox   = $row1['codpro'];
				$codkey    = $row1['codkey'];
				$cajas     = $row1['cajas'];
				$sql2 = "SELECT cajas,unid FROM ventas_bonif_unid where codkey = '$codkey'";
				$result2 = mysqli_query($conexion, $sql2);
				if (mysqli_num_rows($result2)) {
					while ($row2 = mysqli_fetch_array($result2)) {
						$cajas1    = $row2['cajas'];
						$unid1     = $row2['unid'];
					}
				}
				$sql2 = "SELECT stopro,$tabla FROM producto where codpro = '$codprox'";
				$result2 = mysqli_query($conexion, $sql2);
				if (mysqli_num_rows($result2)) {
					while ($row2 = mysqli_fetch_array($result2)) {
						$stockx    = $row2['stopro'];
						$locx      = $row2[1];
					}
				}
				$totcaja = $cajas + $cajas1;
				$unidadesx = $cajas * $unid1;
				$stockxx   = $stockx + $unidadesx;
				$locxx     = $locx + $unidadesx;
			}
		}
		if ($fraccion == "F") {
			$canpro = $canpro * $factor;
		}
		$total_general = $stopro + $canpro;
		$total_local	= $cant_loc + $canpro;
	}
}
$arrAux = array();
$intAux = 0;
foreach ($arr_detalle_venta as $detalle) {
	$codpro = $detalle['codpro'];
	if (isset($detalle['bonif2'])) {
		$bonif2 = $detalle['bonif2'];
	} else {
		$bonif2 = '';
	}

	// echo '$intAux = ' . $intAux . "<br>";
	// echo '$cod = ' . $cod . "<br>";
	// echo '$codpro = ' . $codpro . "<br>";
	// echo '$codprobonif = ' . $codprobonif . "<br>";
	// echo '$bonif2 = ' . $bonif2 . "<br>";
	// echo '-------------------' . "<br>";

	if ($intAux != $cod   && ($codpro != $codprobonif || $bonif2 != 1)) {
		$arrAux[] = $detalle;
	}
	$intAux++;
}

$_SESSION['arr_detalle_venta'] = $arrAux;
mysqli_query($conexion, "DELETE from temp_venta_bonif where invnum = '$venta' and codprobonif = '$codpro'");

mysqli_close($conexion);
header("Location: venta_index1.php");
