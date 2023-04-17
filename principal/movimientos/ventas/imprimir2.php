<?php require_once('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php'); //CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$venta   = $_SESSION['venta'];
$sql = "SELECT * FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
	}
}
function formato($c)
{
	printf("%08d",  $c);
}
function formato1($c)
{
	printf("%06d",  $c);
}
require_once('calcula_monto.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>IMPRESION DE VENTA</title>
	<link href="../../../css/print.css" rel="stylesheet" type="text/css" />

	<SCRIPT LANGUAGE="JavaScript">
		// <!--
		function imprimir() {
			if (window.print)
				window.print()
			else
				alert("Disculpe, su navegador no soporta esta opci�n.");
		}
		// -->
	</SCRIPT>
	<?php if ($forpag == 'E') {
		$forma_pago = 'EFECTIVO';
	}
	if ($forpag == 'T') {
		$forma_pago = 'TARJETA';
	}
	if ($forpag == 'C') {
		$forma_pago = 'CREDITO';
	}
	?>
	<script>
		function escapes(e) {
			tecla = e.keyCode
			if (tecla == 27) {
				document.form1.action = "imprimir.php";
				document.form1.submit();
				//window.close();
			}
		}
	</script>
</head>

<body onkeyup="escapes(event)">
	<form name="form1" id="form1">
		<table width="869" border="0" bordercolor="#666666">
			<tr>
				<td>
					<div align="center"><a href="javascript:imprimir()"><b>COMPROBANTE DE PAGO</b></a></div>
					<table width="857" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
						<tr>
							<td>
								<table width="847" border="0">
									<tr>
										<td width="128"><strong>NRO DE VENTA </strong></td>
										<td width="311"><?php echo formato($invnum) ?></td>
										<td width="182">
											<div align="right"><strong>FORMA DE PAGO </strong></div>
										</td>
										<td width="208"><?php echo $forma_pago ?></td>
									</tr>
									<tr>
										<td><strong>FECHA</strong></td>
										<td><?php echo $invfec ?></td>
										<td>
											<div align="right"><strong>VENDEDOR</strong></div>
										</td>
										<td><?php echo $user ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>
					<table width="857" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
						<tr>
							<td width="26"><strong>N&ordm;</strong></td>
							<td width="278"><strong>DESCRIPCION</strong></td>
							<td width="158">
								<div align="center"><strong>MARCA</strong></div>
							</td>
							<td width="89">
								<div align="center"><strong>PRECIO REF </strong></div>
							</td>
							<td width="70">
								<div align="center"><strong>DCTOS</strong></div>
							</td>
							<td width="76">
								<div align="center"><strong>CANTIDAD</strong></div>
							</td>
							<td width="68">
								<div align="center"><strong>PRECIO</strong></div>
							</td>
							<td width="74">
								<div align="center"><strong>SUB TOTAL </strong></div>
							</td>
						</tr>
					</table>
					<table width="857" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
						<tr>
							<td>
								<table width="851" border="0" align="center">
									<?php $i = 1;
									if (isset($_SESSION['arr_detalle_venta'])) {
										$arr_detalle_venta = $_SESSION['arr_detalle_venta'];
									} else {
										$arr_detalle_venta = array();
									}
									if (!empty($arr_detalle_venta)) {
										foreach ($arr_detalle_venta as $row) {
											$codpro       = $row['codpro'];		//codgio
											$canpro       = $row['canpro'];
											$fraccion     = $row['fraccion'];
											$factor       = $row['factor'];
											$prisal       = $row['prisal'];
											$pripro       = $row['pripro'];
											$fraccion     = $row['fraccion'];
											if ($fraccion == "F") {
												$cantemp = $canpro * $factor;
											} else {
												$cantemp = $canpro;
											}
											$sql1 = "SELECT codpro,desprod,codmar,factor,costpr,stopro,incentivado,prelis,prevta,preuni FROM producto where codpro = '$codpro'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$codpro     = $row1['codpro'];
													$desprod    = $row1['desprod'];
													$codmar     = $row1['codmar'];
													$factor     = $row1['factor'];
													$costpr     = $row1['costpr'];  ///COSTO PROMEDIO
													$stopro     = $row1['stopro'];	///STOCK EN UNIDADES DEL PRODUCTO GENERAL
													$cant       = $row1['cant'];	///STOCK EN UNIDADES DEL PRODUCTO POR LOCAL
													$idlocal    = $row1['idlocal'];	///CODIGO DEL LOCAL
													$inc	    = $row1['incentivado'];
													$referencial = $row1['prelis'];
													$prevta		= $row1['prevta'];
													$preuni     = $row1['preuni'];
												}
											}
											if (($referencial <> 0) and ($referencial <> $prevta)) {
												$precio_ref     = $referencial / $factor;
												$desc1	        = $precio_ref - $preuni;
												if ($desc1 < 0) {
													$descuento = 0;
												} else {
													$descuento      = (($precio_ref - $preuni) / $precio_ref) * 100;
												}
											} else {
												$precio_ref		= $preuni;
												$descuento		= 0;
											}
											$sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$ltdgen     = $row1['ltdgen'];
												}
											}
											$sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$marca     = $row1['destab'];
												}
											}
									?>
											<tr>
												<td width="20" class="main_text">
													<font size="-1"><?php echo $i ?></font>
												</td>
												<td width="276" class="main_text">
													<font size="-1"><?php echo $desprod; ?></font>
												</td>
												<td width="157" class="main_text">
													<font size="-1"><?php echo $marca ?></font>
												</td>
												<td width="87" class="main_text">
													<div align="right">
														<font size="-1"><?php echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' '); ?></font>
													</div>
												</td>
												<td width="68" class="main_text">
													<div align="right">
														<font size="-1"><?php echo $numero_formato_frances = number_format($descuento, 0, '.', ' '); ?></font>%
													</div>
												</td>
												<td width="74" class="main_text">
													<div align="right">
														<font size="-1">
															<?php if ($fraccion == "T") {
																echo $canpro;
															}
															if ($fraccion == "F") {
																$canpro = "c" . $canpro;
																echo $canpro;
															} ?>
														</font>
													</div>
												</td>
												<td width="67" class="main_text">
													<div align="right">
														<font size="-1"><?php echo $prisal; ?></font>
													</div>
												</td>
												<td width="68" class="main_text">
													<div align="right">
														<font size="-1"><?php echo $pripro; ?></font>
													</div>
												</td>
											</tr>
										<?php $i++;
										}
									}
									if ($i < 38) {
										while ($i <= 22) {
										?>
											<tr>
												<td width="20" class="main_text">&nbsp;</td>
												<td width="276" class="main_text">&nbsp;</td>
												<td width="157" class="main_text">&nbsp;</td>
												<td width="87" class="main_text">&nbsp;</td>
												<td width="68" class="main_text">&nbsp;</td>
												<td width="74" class="main_text">&nbsp;</td>
												<td width="67" class="main_text">&nbsp;</td>
												<td width="68" class="main_text">&nbsp;</td>
											</tr>
									<?php $i++;
										}
									}
									?>
								</table>

							</td>
						</tr>
					</table>
					<br>
					<table width="857" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
						<tr>
							<td width="168">
								<div align="center"><strong>MONTO BRUTO&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $numero_formato_frances = number_format($mont_bruto, 2, '.', ' '); ?></strong></div>
							</td>
							<td width="170">
								<div align="center"><strong>DCTO&nbsp&nbsp;&nbsp;&nbsp;
										<?php echo $numero_formato_frances = number_format($total_des, 2, '.', ' '); ?></strong></div>
							</td>
							<td width="169">
								<div align="center"><strong>V.VENTA&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $numero_formato_frances = number_format($valor_vent1, 2, '.', ' '); ?></strong></div>
							</td>
							<td width="169">
								<div align="center"><strong>IGV&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $numero_formato_frances = number_format($sum_igv, 2, '.', ' '); ?></strong></div>
							</td>
							<td width="169">
								<div align="center"><strong>NETO&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' '); ?></strong></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>