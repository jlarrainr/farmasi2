<?php include('../../session_user.php');
$venta   = $_SESSION['cotiz'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<?php
	require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../titulo_sist.php');
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	?>
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
	$sql = "SELECT * FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$codloc    = $row['codloc'];
		}
	}
	$sql = "SELECT * FROM xcompa where codloc = '$codloc'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nomloc    = $row['nomloc'];
		}
	}
	$cod	 = $_REQUEST['cod'];
	$sql = "SELECT * FROM producto where codpro = '$cod'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$codfam         = $row['codfam'];
			$factor         = $row['factor'];
			$codpro         = $row['codpro'];


			if (($zzcodloc == 1) && ($precios_por_local == 1)) {

				$margene        = $row['margene'];
				$costre         = $row['costre'];
				$prevta         = $row['prevta'];
				$preuni         = $row['preuni'];
			} elseif ($precios_por_local == 0) {

				$margene        = $row['margene'];
				$costre         = $row['costre'];
				$prevta         = $row['prevta'];
				$preuni         = $row['preuni'];
			}

			if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

				$sql_precio = "SELECT $margene_p,$costre_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
				$result_precio = mysqli_query($conexion, $sql_precio);
				if (mysqli_num_rows($result_precio)) {
					while ($row_precio = mysqli_fetch_array($result_precio)) {
						$margene        = $row_precio[0];
						$costre         = $row_precio[1];
						$prevta         = $row_precio[2];
						$preuni         = $row_precio[3];
					}
				}
			}





			$sql1 = "SELECT * FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$marca        = $row1['destab'];
				}
			}
			$sql1 = "SELECT * FROM titultabladet where tiptab = 'F' and codtab = '$codfam'";
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$familia      = $row1['destab'];
				}
			}
		}
	}
	?>
	<title><?php echo $desprod ?></title>
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.Estilo1 {
			color: #FFFFFF
		}

		.Estilo2 {
			color: #FF0000
		}
	</style>
</head>

<body>
	<table class="tabla2" width="632" border="0">
		<tr>
			<td width="624">
				<table width="617" border="0" align="center">
					<tr>
						<td width="75" class="main1_text">DESCRIPCION</td>
						<td width="532"><?php echo $desprod ?></td>
					</tr>
					<tr>
						<td class="main1_text">MARCA</td>
						<td><?php echo $marca ?></td>
					</tr>
					<tr>
						<td class="main1_text">LINEA</td>
						<td><?php echo $familia ?></td>
					</tr>
					<tr>
						<td class="main1_text">FACTOR</td>
						<td><?php echo $factor ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="632" border="0" bgcolor="#50ADEA">
		<tr>
			<td width="544">
				<div align="center" class="Estilo1">
					<div align="left">PRODUCTO</div>
				</div>
			</td>
			<td width="78">
				<div align="center" class="Estilo1">
					<div align="right">STOCK</div>
				</div>
			</td>
		</tr>
	</table>
	<?php $sql = "SELECT * FROM producto where codfam = '$codfam'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
	?>
		<table width="632" border="0">
			<?php while ($row = mysqli_fetch_array($result)) {
				$codigo         = $row['codpro'];
				$desprod        = $row['desprod'];
				$codmar         = $row['codmar'];
				$codfam         = $row['codfam'];
				$factor         = $row['factor'];
				$s000      		= $row['s000'];
				$s001      		= $row['s001'];
				$s002      		= $row['s002'];
				$s003      		= $row['s003'];
				$s004      		= $row['s004'];
				$s005      		= $row['s005'];
				$s006      		= $row['s006'];
				$s007      		= $row['s007'];
				$s008      		= $row['s008'];
				$s009      		= $row['s009'];
				$s010      		= $row['s010'];
				$s011      		= $row['s011'];
				$s012      		= $row['s012'];
				$s013      		= $row['s013'];
				$s014      		= $row['s014'];
				$s015      		= $row['s015'];
				$s016      		= $row['s016'];


				if (($zzcodloc == 1) && ($precios_por_local == 1)) {

					$margene        = $row['margene'];
					$costre         = $row['costre'];
					$prevta         = $row['prevta'];
					$preuni         = $row['preuni'];
				} elseif ($precios_por_local == 0) {

					$margene        = $row['margene'];
					$costre         = $row['costre'];
					$prevta         = $row['prevta'];
					$preuni         = $row['preuni'];
				}

				if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

					$sql_precio = "SELECT $margene_p,$costre_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codigo'";
					$result_precio = mysqli_query($conexion, $sql_precio);
					if (mysqli_num_rows($result_precio)) {
						while ($row_precio = mysqli_fetch_array($result_precio)) {
							$margene        = $row_precio[0];
							$costre         = $row_precio[1];
							$prevta         = $row_precio[2];
							$preuni         = $row_precio[3];
						}
					}
				}





				if ($nomloc == "LOCAL0") {
					$cant_loc = $s000;
				}
				if ($nomloc == "LOCAL1") {
					$cant_loc = $s001;
				}
				if ($nomloc == "LOCAL2") {
					$cant_loc = $s002;
				}
				if ($nomloc == "LOCAL3") {
					$cant_loc = $s003;
				}
				if ($nomloc == "LOCAL4") {
					$cant_loc = $s004;
				}
				if ($nomloc == "LOCAL5") {
					$cant_loc = $s005;
				}
				if ($nomloc == "LOCAL6") {
					$cant_loc = $s006;
				}
				if ($nomloc == "LOCAL7") {
					$cant_loc = $s007;
				}
				if ($nomloc == "LOCAL8") {
					$cant_loc = $s008;
				}
				if ($nomloc == "LOCAL9") {
					$cant_loc = $s009;
				}
				if ($nomloc == "LOCAL10") {
					$cant_loc = $s010;
				}
				if ($nomloc == "LOCAL11") {
					$cant_loc = $s011;
				}
				if ($nomloc == "LOCAL12") {
					$cant_loc = $s012;
				}
				if ($nomloc == "LOCAL13") {
					$cant_loc = $s013;
				}
				if ($nomloc == "LOCAL14") {
					$cant_loc = $s014;
				}
				if ($nomloc == "LOCAL15") {
					$cant_loc = $s015;
				}
				if ($nomloc == "LOCAL16") {
					$cant_loc = $s016;
				}
			?>
				<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td width="544"><?php if ($codigo == $cod) { ?><b><?php echo $desprod ?></b><?php } else {
																								echo $desprod;
																							} ?></td>
					<td width="78">
						<div align="right"><?php if ($codigo == $cod) { ?><b><?php echo $cant_loc ?></b><?php } else {
																										echo $cant_loc;
																									} ?></div>
					</td>
				</tr>
			<?php }
			?>
		</table>
	<?php }
	?>
</body>

</html>