<?php
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

$sql = "SELECT count(*) FROM detalle_venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$count        = $row[0];
	}
} else {
	$count = 0;
}
$sql = "SELECT count(*) FROM detalle_venta where invnum = '$venta' and canpro = '0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$count1        = $row[0];
	}
} else {
	$count1 = 0;
}
$sql = "SELECT count(*) FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$count2        = $row[0];
	}
} else {
	$count2 = 0;
}
$sql1 = "SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$porcent    = $row1['porcent'];
	}
}

$sqlVenta    = "SELECT sucursal FROM venta where invnum = '$venta'";
$resultVenta = mysqli_query($conexion, $sqlVenta);
if (mysqli_num_rows($resultVenta)) {
	while ($rowVenta = mysqli_fetch_array($resultVenta)) {
		$sucursal    = $rowVenta['sucursal'];
	}
}

//CONFIGPRECIOS_PRODUCTO
$nomlocalG  = "";
$sqlLocal   = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
	while ($rowLocal = mysqli_fetch_array($resultLocal)) {
		$nomlocalG    = $rowLocal['nomloc'];
	}
}

$TablaPrevtaMain = "prevta";
$TablaPreuniMain = "preuni";
if ($nomlocalG <> "") {
	if ($nomlocalG == "LOCAL1") {
		$TablaPrevta = "prevta1";
		$TablaPreuni = "preuni1";
	} else {
		if ($nomlocalG == "LOCAL2") {
			$TablaPrevta = "prevta2";
			$TablaPreuni = "preuni2";
		} else {
			$TablaPrevta = "prevta";
			$TablaPreuni = "preuni";
		}
	}
} else {
	$TablaPrevta = "prevta";
	$TablaPreuni = "preuni";
}
//**FIN_CONFIGPRECIOS_PRODUCTO**//

$mont_bruto = 0;
$valor_vent1 = 0;
$monto_total = 0;
$sql1 = "SELECT codpro,canpro,fraccion,factor,prisal,pripro,costpr,codmar,bonif FROM detalle_venta where invnum = '$venta'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$codpro    = $row1['codpro'];
		$canpro    = $row1['canpro'];
		$fraccion  = $row1['fraccion'];
		$factor    = $row1['factor'];
		$prisal    = $row1['prisal'];
		$pripro    = $row1['pripro'];
		$costpr    = $row1['costpr'];
		$codmar    = $row1['codmar'];
		$bonif     = $row1['bonif'];
		if ($bonif <> 1) {
			$sql2 = "SELECT igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,codpro FROM producto where codpro = '$codpro'";
			$result2 = mysqli_query($conexion, $sql2);
			if (mysqli_num_rows($result2)) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$igv            = $row2['igv'];
					$factor         = $row2['factor'];
					$codpro         = $row2['codpro'];
					if (($zzcodloc == 1) && ($precios_por_local == 1)) {
						$referencial    = $row2['prelis'];
						$margene        = $row2['margene'];
						$prevtaMain     = $row2['PrevtaMain'];
						$preuniMain     = $row2['PreuniMain'];
						$prevta         = $row2[6];
						$preuni         = $row2[7];
					} elseif ($precios_por_local == 0) {
						$referencial    = $row2['prelis'];
						$margene        = $row2['margene'];
						$prevtaMain     = $row2['PrevtaMain'];
						$preuniMain     = $row2['PreuniMain'];
						$prevta         = $row2[6];
						$preuni         = $row2[7];
					}

					if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

						$sql_precio = "SELECT $prelis_p,$margene_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
						$result_precio = mysqli_query($conexion, $sql_precio);
						if (mysqli_num_rows($result_precio)) {
							while ($row_precio = mysqli_fetch_array($result_precio)) {
								$referencial = $row_precio[0];
								$margene = $row_precio[1];
								$prevtaMain = $row_precio[2];
								$preuniMain = $row_precio[3];
								$prevta = $row_precio[2];
								$preuni = $row_precio[3];
							}
						}
					}
				}
			}
			//**CONFIGPRECIOS_PRODUCTO**//
			if (($prevta == "") || ($prevta == 0)) {
				$prevta = $prevtaMain;
			}
			if (($preuni  == "") || ($preuni  == 0)) {
				$preuni  = $preuniMain;
			}
			//**FIN_CONFIGPRECIOS_PRODUCTO**//

			if (($referencial <> 0) and ($referencial <> $prevta)) {
				$margenes       = ($margene / 100) + 1;
				$precio_ref     = $referencial;
				//$precio_ref     = $referencial/$factor;
				//$precio_ref     = $referencial*$factor;
				$precio_ref		= $precio_ref * $margenes;
			} else {
				$precio_ref		= $preuni;
			}
			if ($fraccion == 'T') {
				$cantidad_comp = $canpro;
			} else {
				$cantidad_comp = $canpro * $factor;
			}
			if ($fraccion == 'T') {
				$sum_mont1 = ($precio_ref / $factor) * $cantidad_comp;
			} else {
				$sum_mont1 = $precio_ref * $canpro;
			}
			//$sum_mont1 = $precio_ref * $cantidad_comp;
			$mont_bruto = $mont_bruto + $sum_mont1;
			if ($igv == 1) {
				if ($fraccion == 'T') {
					$valor_vent		= ($prisal / (($porcent / 100) + 1)) * $cantidad_comp;
				} else {
					$valor_vent		= ($prisal / (($porcent / 100) + 1)) * $canpro;
				}
				$valor_vent1	+=  $valor_vent;
			} else {
				if ($fraccion == 'T') {
					$valor_vent     = ($prisal * $cantidad_comp);
				} else {
					$valor_vent     = ($prisal * $canpro);
				}
				$valor_vent1	+=  $valor_vent;
			}
			$monto_total	+= $pripro;
		}
	}
} else {
}
//$t = 0.1;
$t = 0.0;
$r = $monto_total;
/*$nnn = $monto_total;
$nnn = $numero_formato_frances = number_format($nnn, 2, '.', ' ');
$aux = (string)$nnn;
$decimal = substr($aux, strpos($aux,"."));
$decimal  = explode(".",$nnn);
$decimal  = $decimal[1];
$n = (floor($monto_total*10)/10); 
$rr= $valor_vent1;
$nn= (floor($valor_vent1*10)/10); 
if (($decimal%10) <> 0)
{
$monto_total    = $n + $t;
$valor_vent1    = $nn + $t;
}
else
{
$monto_total    = $n;
$valor_vent1    = $nn;
}*/
$total_des		= $mont_bruto - $valor_vent1;
$sum_igv		= ($monto_total - $valor_vent1);
$redondeo		= $monto_total - $r;
