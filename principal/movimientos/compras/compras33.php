<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$invnum  = $_SESSION['compras'];
$ok  	 = $_REQUEST['ok'];

$sqldatagen = "SELECT precios_por_local,porcent FROM datagen";
$resultdatagen = mysqli_query($conexion, $sqldatagen);
if (mysqli_num_rows($resultdatagen)) {
	while ($rodatagen = mysqli_fetch_array($resultdatagen)) {
		$precios_por_local = $rodatagen['precios_por_local'];
		$porcent    = $rodatagen['porcent'];
	}
}
if ($precios_por_local  == 1) {
	require_once '../../../precios_por_local.php';
}

function convertir_a_numero($str)
{
	$legalChars = "%[^0-9\-\. ]%";
	$str = preg_replace($legalChars, "", $str);
	return $str;
}


$codtemp      = $_REQUEST['codtemp'];
$codprobon    = $_REQUEST['codprobon'];			//!PRODUCTO DE ORIGEN  
$country_ID   = $_REQUEST['country_ID'];		//!PRODUCTO QUE PUEDE SER POR OTRO  
$bonif_can    = $_REQUEST['bonif_can'];
$tipbonif     = $_REQUEST['tipbonif'];
$numero       = $_REQUEST['nnum'];
$countryL       = strtoupper($_REQUEST['countryL']);
$mesL           = $_REQUEST['mesL'];
$yearsL         = $_REQUEST['yearsL'];


// echo 'codtemp == ' . $codtemp .  '<br>';
// echo 'codprobon == ' . $codprobon .  '<br>';
// echo 'country_ID == ' . $country_ID .  '<br>';
// echo 'bonif_can == ' . $bonif_can .  '<br>';
// echo 'tipbonif == ' . $tipbonif .  '<br>';
// echo 'numero == ' . $numero .  '<br>';
// echo 'countryL == ' . $countryL .  '<br>';
// echo 'mesL == ' . $mesL .  '<br>';
// echo 'yearsL == ' . $yearsL .  '<br>';

$cuento = strlen($mesL);
if ($cuento == '2') {
	$mes = $mesL;
} else {
	$mes = '0' . $mesL;
}
if (($mes != '') && ($yearsL != '')) {
	$vencim = $mes . '/' . $yearsL;
} else {
	$vencim = '';
}
// ────────────────────────────────────────────────────────────────────────────────
//? PARA COMPARAR SI ES EL MISMO PRODUCTO AL QUE SE ESTA BONIFICANDO O NO --> INICIO
// ────────────────────────────────────────────────────────────────────────────────

if (($country_ID == '') || ($country_ID == $codprobon)) {
	// echo 'el mismo producto'  .  '<br>';
	$codproParaBonificar = $codprobon;
} else {
	// echo 'otro producto'  .  '<br>';
	$codproParaBonificar = $country_ID;
}
// ────────────────────────────────────────────────────────────────────────────────
//? PARA COMPARAR SI ES EL MISMO PRODUCTO AL QUE SE ESTA BONIFICANDO O NO --> FIN
// ────────────────────────────────────────────────────────────────────────────────
// echo 'codproParaBonificar == ' . $codproParaBonificar .  '<br>';

$sqlq = "SELECT factor FROM producto where codpro = '$codproParaBonificar'";
$resultq = mysqli_query($conexion, $sqlq);
if (mysqli_num_rows($resultq)) {
	while ($rowq = mysqli_fetch_array($resultq)) {

		$factorbonificado    = $rowq['factor'];
	}
}
if ($factorbonificado == 1) {
	$letra		= "C";
	$bonif_can	= convertir_a_numero($bonif_can);
} else {
	if ($numero == 1) {
		$bonif_can	= convertir_a_numero($bonif_can);
		$letra		= "U";
	} else {
		$letra		= "C";
	}
}

// echo '$codprobon = ' . $codprobon . '<br>';
// echo '$codtemp = ' . $codtemp . '<br>';
// echo '$invnum = ' . $invnum . '<br>';

//////////////////////////////////////////////DATOS DE LA TABLA TEMPORAL
$sqlq = "SELECT * FROM tempmovmov where codpro = '$codprobon' and codtemp = '$codtemp' and invnum = '$invnum'";
$resultq = mysqli_query($conexion, $sqlq);
if (mysqli_num_rows($resultq)) {
	while ($rowq = mysqli_fetch_array($resultq)) {
		$codpro    = $rowq['codpro'];
		$qtypro    = $rowq['qtypro'];
		$qtyprf    = $rowq['qtyprf'];
		$pripro    = $rowq['pripro'];	//precio incluyendo el descuento e igv
		$desc1     = $rowq['desc1'];
		$desc2     = $rowq['desc2'];
		$desc3     = $rowq['desc3'];
	}
}


////////////////////////////////////////////FACTOR DEL PRODUCTO A BONIFICAR
$sqlq = "SELECT factor FROM producto where codpro = '$codprobon'";
$resultq = mysqli_query($conexion, $sqlq);
if (mysqli_num_rows($resultq)) {
	while ($rowq = mysqli_fetch_array($resultq)) {
		$factor    = $rowq['factor'];
	}
}

////////////////////////////////////////////OBTENGO LAS CANTIDADES UNITARIAS COMPRADAS
if ($qtyprf <> "") {
	$text_char = convertir_a_numero($qtyprf);
	$cant_unid = $text_char;
} else {
	$cant_unid = $qtypro * $factor;
}
// echo '$qtyprf = ' . $qtyprf . '<br>';

////////////////////////////////////////////CASO= SE BONIFICA POR EL MISMO PRODUCTO CON CAJAS
if ($letra == "C") {
	if ($codpro == $codprobon) {
		/*$precio_real = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)))/($cant_unid + $bonif_can);*/
		$pru         = ($cant_unid * $pripro * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100)) * (1 + ($porcent / 100)));
		$pru1		 = ($cant_unid + $bonif_can);
		$precio_real = ($pru / $pru1);
	}
	////////////////////////////////////////////CASO = SE BONIFICA CON OTRO PRODUCTO CON CAJAS
	if ($codpro <> $codprobon) {
		$sqlq = "SELECT costre,codpro,factor FROM producto where codpro = '$codpro'";
		$resultq = mysqli_query($conexion, $sqlq);
		if (mysqli_num_rows($resultq)) {
			while ($rowq = mysqli_fetch_array($resultq)) {

				$codpro    = $rowq['codpro'];
				$factor2    = $rowq['factor'];
				if (($zzcodloc == 1) && ($precios_por_local == 1)) {
					$costre    = $rowq['costre'];
				} elseif ($precios_por_local == 0) {
					$costre    = $rowq['costre'];
				}

				if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

					$sql_precio = "SELECT $costre_p FROM precios_por_local where codpro = '$codpro'";
					$result_precio = mysqli_query($conexion, $sql_precio);
					if (mysqli_num_rows($result_precio)) {
						while ($row_precio = mysqli_fetch_array($result_precio)) {
							$costre    = $row_precio[0];
						}
					}
				}
			}
		}
		$pru         = ($cant_unid * $pripro * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100)) * (1 + ($porcent / 100)));
		$pru1		 = ($bonif_can * $costre);
		$pru2		 = $cant_unid;
		$precio_real = ($pru - $pru1) / $pru2;
		/*$precio_real = (($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)))) - ($bonif_can * $costre)/($cant_unid);*/
	} else {
		$sqlq = "SELECT costre,codpro,factor FROM producto where codpro = '$codpro'";
		$resultq = mysqli_query($conexion, $sqlq);
		if (mysqli_num_rows($resultq)) {
			while ($rowq = mysqli_fetch_array($resultq)) {
				$codpro    = $rowq['codpro'];
				$factor2    = $rowq['factor'];
			}
		}
	}
}
if ($letra == "U") {
	$sqlq = "SELECT costre,codpro,factor FROM producto where codpro = '$codpro'";
	$resultq = mysqli_query($conexion, $sqlq);
	if (mysqli_num_rows($resultq)) {
		while ($rowq = mysqli_fetch_array($resultq)) {
			$codpro    = $rowq['codpro'];
			$factor2    = $rowq['factor'];

			if (($zzcodloc == 1) && ($precios_por_local == 1)) {
				$costre    = $rowq['costre'];
			} elseif ($precios_por_local == 0) {
				$costre    = $rowq['costre'];
			}

			if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

				$sql_precio = "SELECT $costre_p FROM precios_por_local where codpro = '$codpro'";
				$result_precio = mysqli_query($conexion, $sql_precio);
				if (mysqli_num_rows($result_precio)) {
					while ($row_precio = mysqli_fetch_array($result_precio)) {
						$costre    = $row_precio[0];
					}
				}
			}
		}
	}
	$pru         = ($cant_unid * $pripro * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100)) * (1 + ($porcent / 100)));
	$pru1		 = ($bonif_can * $costre);
	$pru2		 = $cant_unid;
	$precio_real = ($pru - $pru1) / $pru2;
}
///////////////////////////////////////////////////////////////////////
$precio_real  = number_format($precio_real, 2, '.', ',');

mysqli_query($conexion, "DELETE FROM tempmovmov_bonif where invnum = '$invnum' and codtemp = '$codtemp'");

$sqlq = "SELECT * FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$invnum' and codpro = '$codpro'";
$resultq = mysqli_query($conexion, $sqlq);
if (mysqli_num_rows($resultq)) {
	mysqli_query($conexion, "UPDATE tempmovmov_bonif set codpro= '$codpro',codprobon= '$codproParaBonificar', canbon = '$bonif_can', tipbon= '$letra', costo_real = '$precio_real',numlote='$countryL',vencim='$vencim',factor='$factorbonificado'   where codtemp = '$codtemp' and invnum = '$invnum'");
} else {

	mysqli_query($conexion, "INSERT INTO tempmovmov_bonif (invnum,codtemp,codpro,codprobon,canbon,tipbon,costo_real,numlote,vencim,factor,tipbonif) values ('$invnum','$codtemp','$codpro','$codproParaBonificar','$bonif_can','$letra','$precio_real','$countryL','$vencim','$factorbonificado',$tipbonif)");
}
////////////////////////////////////////////
header("Location: compras3.php?ok=4");
