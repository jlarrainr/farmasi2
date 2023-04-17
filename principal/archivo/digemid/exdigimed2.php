<?php include('../../session_user.php');
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_digemid_DATA.xls");

$ckdigemid = isset($_REQUEST['ckdigemid3']) ? ($_REQUEST['ckdigemid3']) : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../titulo_sist.php');
	?>
	<?php require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
	?>
	<?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	?>
	<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	?>
	<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	?>
	<?php // require_once("tabla_local.php");	//LOCAL DEL USUARIO
	?>
	<?php require_once("../../local.php");	//LOCAL DEL USUARIO

	//	$sql="SELECT P.codpro,P.desprod,P.stopro,P.digemid,P.s000, V.sucursal  from producto AS P INNER JOIN  detalle_venta AS DV on P.codpro =  DV.codpro INNER JOIN venta AS V on DV.Invnum = V.Invnum WHERE sucursal = 1 AND P.s000 >=1 AND P.s002>=1 ORDER BY codpro asc";
	//	$sql="SELECT P.codpro,P.desprod,P.stopro,P.preuni,P.prevta ,P.digemid,P.s000, V.sucursal  from producto AS P INNER JOIN  detalle_venta AS DV on P.codpro =  DV.codpro INNER JOIN venta AS V on DV.Invnum = V.Invnum WHERE sucursal = 1 AND P.s000 >=1  ORDER BY codpro asc";
	?>

</head>

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


$sql1 = "SELECT CodEstab FROM datagen";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row = mysqli_fetch_array($result1)) {
		$CodEstab    = $row['CodEstab'];
	}
}

$sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row = mysqli_fetch_array($result1)) {
		$user    = $row['nomusu'];
		$sucursal    = $row['codloc'];
	}
}
$sql2 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
$result2 = mysqli_query($conexion, $sql2);
if (mysqli_num_rows($result2)) {
	while ($row = mysqli_fetch_array($result2)) {
		$nomlocalG    = $row['nomloc'];
	}
}

$date   = date('d/m/Y');
$hour  = date('G');

$min	= date('i');
if ($hour <= 12) {
	$hor    = "am";
} else {
	$hor    = "pm";
}

$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);









?>




<body <?php ?>onload="sf();" <?php ?>>
	<?php if ($ckdigemid <> 1) { ?>

		<table width="100%" border="1" align="center">




			<?php
			$i = 0;
			$sql3 = "SELECT codpro,desprod,preuni,prevta ,digemid,codmar,factor  from producto WHERE  digemid <> 0 and $tabla > 0 ORDER BY codpro ASC ";
			$result3 = mysqli_query($conexion, $sql3);

			if (mysqli_num_rows($result3)) {
			?>

				<tr>
					<!--            <td width="38"><strong>N�</strong></td>-->
					<th width="10%">
						<div align="center"><strong>C. Producto </strong></div>
					</th>
					<th width="10%">
						<div align="center"><strong>Digemid </strong></div>
					</th>
					<th width="10%">
						<div align="center"><strong>Pre. Producto</strong></div>
					</th>
					<th width="10%">
						<div align="center"><strong>Pre. unid. Producto</strong></div>
					</th>
					<th width="25%">
						<div align="center"><strong>PRODUCTO</strong></div>
					</th>
					<th width="15%">
						<div align="center"><strong>MARCA</strong></div>
					</th>
				</tr>
				<?php

				while ($row = mysqli_fetch_array($result3)) {

					$codpro          = $row['codpro'];
					$desprod         = $row['desprod'];
					$codmar         = $row['codmar'];
					$factor         = $row['factor'];
					$digemid         = $row['digemid'];

					if (($zzcodloc == 1) && ($precios_por_local == 1)) {
						$prevta          = $row['prevta'];
						$preuni          = $row['preuni'];
					} elseif ($precios_por_local == 0) {
						$prevta          = $row['prevta'];
						$preuni          = $row['preuni'];
					}
					if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

						$sql_precio = "SELECT $prevta_p,$preuni_p   FROM precios_por_local where codpro = '$codpro'";
						$result_precio = mysqli_query($conexion, $sql_precio);
						if (mysqli_num_rows($result_precio)) {
							while ($row_precio = mysqli_fetch_array($result_precio)) {
								$prevta = $row_precio[0];
								$preuni = $row_precio[1];
							}
						}
					}
					if ($preuni == 0) {
						$preuni = $prevta / $factor;
					}

					$sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
					$result1 = mysqli_query($conexion, $sql1);
					if (mysqli_num_rows($result1)) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$destab    = $row1['destab'];
						}
					}
					$i++;

				?>
					<tr>



						<td align="center"><?php echo $codpro ?></td>
						<td align="center"><?php echo $digemid ?></td>
						<td align="center"><?php echo $prevta ?></td>

						<td align="center"><?php if ($factor == 1) {
												echo $numero_formato_frances = number_format($prevta, 2, '.', ' ');;
											} else {
												echo $numero_formato_frances = number_format($preuni, 2, '.', ' ');;
											} ?></td>

						<td align="center"><?php echo $desprod ?></td>
						<td align="center"><?php echo $destab ?></td>

					</tr>






			<?php

				}
			}
			?>
		</table>

	<?php } else { ?>

		<!--covidddddddd-->
		<table width="200" border="1" align="center">

			<tr>

				<td width="20">
					<div align="center"><strong>CodEstab </strong></div>
				</td>
				<td width="20">
					<div align="center"><strong>CodProdG </strong></div>
				</td>
				<td width="49">
					<div align="center"><strong>CodProdE</strong></div>
				</td>
				<td width="77">
					<div align="center"><strong>Stock</strong></div>
				</td>
				<td width="130">
					<div align="center"><strong>Preciov</strong></div>
				</td>
			</tr>

			<tr>
				<?php
				$i = 0;
				$sql3 = "SELECT codpro,desprod,preuni,prevta,digemid,codmar,factor,$tabla  from producto WHERE  digemid <> 0 and $tabla > 0 and covid='1' ORDER BY codpro ASC ";
				$result3 = mysqli_query($conexion, $sql3);

				if (mysqli_num_rows($result3)) {


					while ($row = mysqli_fetch_array($result3)) {

						$codpro          = $row['codpro'];
						$desprod         = $row['desprod'];
						$codmar         = $row['codmar'];
						$factor         = $row['factor'];
						$digemid         = $row['digemid'];
						$prevta          = $row['prevta'];
						$preuni          = $row['preuni'];
						$stock          = $row[7];


						if ($preuni == 0) {
							$preuni = $prevta / $factor;
						}

						$sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$destab    = $row1['destab'];
							}
						}
						$i++;

				?>
						<td width="20" align="center"><?php echo $CodEstab ?></td>
						<td width="20" align="center"><?php echo $codpro ?></td>

						<td width="49" align="center"><?php echo $digemid ?></td>

						<td width="77" align="center"><?php echo $stock ?></td>
						<td width="77" align="center"><?php if ($factor == 1) {
															echo $numero_formato_frances = number_format($prevta, 2, '.', ' ');;
														} else {
															echo $numero_formato_frances = number_format($preuni, 2, '.', ' ');;
														} ?></td>




			</tr>


	<?php

					}
				}
	?>
		</table>

	<?php } ?>

</body>

</html>