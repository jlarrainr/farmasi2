<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="css/style1.css" rel="stylesheet" type="text/css" />
	<link href="css/style2.css" rel="stylesheet" type="text/css" />
	<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
	<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("funciones/minimo.php");	//COLORES DE LOS BOTONES
	$codpro = $_REQUEST['codpro'];
	$marca  = $_REQUEST['country_ID'];
	$sql1 = "SELECT desprod FROM producto where codpro = '$codpro'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$desproducto = $row1["desprod"];
		}
	}
	$sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$destab = $row1["destab"];
		}
	}
	$cr  = $_REQUEST['cr'];
	if ($cr == "") {
		$cr = 1;
	}
	$ccr = $_REQUEST['ccr'];
	?>
	<script>
		window.onload = function() {
			var row = document.getElementById("myTab").rows;
			row[<?php echo $cr ?>].scrollIntoView(false);
		}

		function act() {
			var mark = document.form1.marca.value;
			window.opener.location.href = "salir.php?mark=<?php echo $marca ?>";
			self.close();
		}
	</script>
	<script language="JavaScript">
		// <!--
		// function cerrar(e) {
		// 	tecla = e.keyCode
		// 	if (tecla == 27) {
		// 		//window.close();
		// 		var f = document.form1;
		// 		var prod = f.codpro.value;
		// 		var marc = f.marca.value;
		// 		var cxr = f.ccr.value;
		// 		document.form1.target = "mark";
		// 		window.opener.location.href = "salir1.php?prod=" + prod + "&marca=" + marc + "&cr=" + cxr;
		// 		self.close();
		// 	}
		// }

		// function mini() {
		// 	document.getElementById('l<?php echo $cr ?>').focus()
		// 	document.form1.minim.focus();
		// }

		// function numero(e) {
		// 	tecla = e.keyCode
		// 	if (tecla == 27) {
		// 		document.form1.codloc.value = "";
		// 		document.form1.codpro.value = "";
		// 		document.form1.marca.value = "";
		// 		document.form1.action = "stockmin3.php"
		// 		document.form1.submit();
		// 	}
		// }
		// var nav4 = window.Event ? true : false;

		// function numeros1(evt) {
		// 	var key = nav4 ? evt.which : evt.keyCode;
		// 	if (key == 13) {
		// 		var f = document.form1;
		// 		f.method = "post";
		// 		f.action = "stockmin3_reg.php";
		// 		f.submit();
		// 	} else {
		// 		return (key <= 13 || (key >= 48 && key <= 57));
		// 	}
		// }
		// //
		// -->
	</script>
	<title><?php echo $desproducto ?></title>
</head>

<body onkeyup="cerrar(event)" onload="mini();">
	<?php $sql = "SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister FROM producto where codpro = '$codpro'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$codpro     = $row['codpro'];
			$desprod    = $row['desprod'];
			$stopro     = $row['stopro'];
			$factor     = $row['factor'];
			$m00     	= $row['m00'];
			$m01     	= $row['m01'];
			$m02    	= $row['m02'];
			$m03     	= $row['m03'];
			$m04     	= $row['m04'];
			$m05     	= $row['m05'];
			$m06     	= $row['m06'];
			$m07     	= $row['m07'];
			$m08     	= $row['m08'];
			$m09     	= $row['m09'];
			$m10    	= $row['m10'];
			$m11     	= $row['m11'];
			$m12     	= $row['m12'];
			$m13     	= $row['m13'];
			$m14     	= $row['m14'];
			$m15     	= $row['m15'];
			$m16     	= $row['m16'];
			$blister  	= $row['blister'];
		}
		for ($i = 0; $i <= 5; $i++) {
			$dates[$i] =  date("d-m-Y", mktime(0, 0, 0, date("m") - $i, date("d"), date("Y"))) . '<br>';
			list($dcar, $mcar, $ycar) = split('[/.-]', $dates[$i]);
			$m[$i] = $mcar;
			$y[$i] = $ycar;
			if ($m[$i] == 1) {
				$mes[$i] = "ENE";
			}
			if ($m[$i] == 2) {
				$mes[$i] = "FEB";
			}
			if ($m[$i] == 3) {
				$mes[$i] = "MAR";
			}
			if ($m[$i] == 4) {
				$mes[$i] = "ABR";
			}
			if ($m[$i] == 5) {
				$mes[$i] = "MAY";
			}
			if ($m[$i] == 6) {
				$mes[$i] = "JUN";
			}
			if ($m[$i] == 7) {
				$mes[$i] = "JUL";
			}
			if ($m[$i] == 8) {
				$mes[$i] = "AGO";
			}
			if ($m[$i] == 9) {
				$mes[$i] = "SET";
			}
			if ($m[$i] == 10) {
				$mes[$i] = "OCT";
			}
			if ($m[$i] == 11) {
				$mes[$i] = "NOV";
			}
			if ($m[$i] == 12) {
				$mes[$i] = "DIC";
			}
		}
	?>
		<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
			<table width="100%" border="0" align="center" class="tabla2">
				<tr>
					<td width="882" class="text_combo_select">
						<table width="100%" border="0" align="center">
							<tr>
								<td width="303"><b><?php echo $desprod ?></b></td>
								<td width="271"><b>LABORATORIO:</b> <?php echo $destab ?> </td>
								<td width="205">
									<strong>
										<input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc ?>" />
										<input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
										<input name="marca" type="hidden" id="marca" value="<?php echo $marca ?>" />
									</strong>
									<input name="ccr" type="hidden" id="ccr" value="<?php echo $ccr ?>" /></td>
								<td width="85">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" border="0" align="center" class="tabla2">
				<tr>
					<td width="880">
						<table width="100%" border="0" align="center">
							<tr>
								<td width="87" class="text_combo_select"><strong>TIENDA</strong></td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[5] ?></strong></div>
								</td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[4] ?></strong></div>
								</td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[3] ?></strong></div>
								</td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[2] ?></strong></div>
								</td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[1] ?></strong></div>
								</td>
								<td width="47" class="text_combo_select">
									<div align="right"><strong><?php echo $mes[0] ?></strong></div>
								</td>
								<td width="104" class="text_combo_select">
									<div align="right"><strong>PROM DE VENTAS </strong></div>
								</td>
								<td width="74" class="text_combo_select">
									<div align="right"><strong>MAX VENTA </strong></div>
								</td>
								<td width="90" class="text_combo_select">
									<div align="right"><strong>MIN VENTA </strong></div>
								</td>
								<td width="111" class="text_combo_select">
									<div align="right"><strong>STOCK MINIMO </strong></div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" border="0" align="center" class="tabla2">
				<tr>
					<td width="880">
						<table width="100%" border="0" align="center" id="myTab">
							<?php
							$valform = $_REQUEST['valform'];
							$local   = $_REQUEST['local'];
							$cr = 1;
							$sql1 = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1' order by codloc";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$codloc     = $row1['codloc'];
									$nomloc	    = $row1['nomloc'];
									$nom2       = $row1['nombre'];
									if ($nom2 <> "") {
										$nombre_local = $nom2;
									} else {
										$nombre_local = $nomloc;
									}
									if ($nomloc == 'LOCAL0') {
										$stock_min = $m00;
									}
									if ($nomloc == 'LOCAL1') {
										$stock_min = $m01;
									}
									if ($nomloc == 'LOCAL2') {
										$stock_min = $m02;
									}
									if ($nomloc == 'LOCAL3') {
										$stock_min = $m03;
									}
									if ($nomloc == 'LOCAL4') {
										$stock_min = $m04;
									}
									if ($nomloc == 'LOCAL5') {
										$stock_min = $m05;
									}
									if ($nomloc == 'LOCAL6') {
										$stock_min = $m06;
									}
									if ($nomloc == 'LOCAL7') {
										$stock_min = $m07;
									}
									if ($nomloc == 'LOCAL8') {
										$stock_min = $m08;
									}
									if ($nomloc == 'LOCAL9') {
										$stock_min = $m09;
									}
									if ($nomloc == 'LOCAL10') {
										$stock_min = $m10;
									}
									if ($nomloc == 'LOCAL11') {
										$stock_min = $m11;
									}
									if ($nomloc == 'LOCAL12') {
										$stock_min = $m12;
									}
									if ($nomloc == 'LOCAL13') {
										$stock_min = $m13;
									}
									if ($nomloc == 'LOCAL14') {
										$stock_min = $m14;
									}
									if ($nomloc == 'LOCAL15') {
										$stock_min = $m15;
									}
									if ($nomloc == 'LOCAL16') {
										$stock_min = $m16;
									}
									$sum0 = 0;
									$sum1 = 0;
									$sum2 = 0;
									$sum3 = 0;
									$sum4 = 0;
									$sum5 = 0;
							?>
									<tr <?php if (($valform == 1) and ($local == $codloc)) { ?>bgcolor="#FFCC66" <?php } else { ?> onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';" <?php } ?>>
										<td width="87">
											<a id="l<?php echo $cr; ?>" href="stockmin3.php?valform=1&codpro=<?php echo $codpro ?>&local=<?php echo $codloc ?>&country_ID=<?php echo $marca ?>&cr=<?php echo $cr ?>&ccr=<?php echo $ccr ?>"><?php echo $nombre_local; ?>
											</a>
										</td>
										<td width="47">
											<div align="right">
												<?php
												$mes		= $m[5];
												$year		= $y[5];
												//echo $mes;
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum5     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum55     = $row2[0];
													}
												}
												//echo ($sum5 + $sum55);
												$vent5 = ($sum5 + $sum55);
												$caja5 = intval($vent5 / $factor);
												$frac5 = (($vent5 / $factor) - intval($vent5 / $factor)) * $factor;
												echo "C" . $caja5;
												echo " ";
												echo "f" . $frac5;
												?>
											</div>
										</td>
										<td width="47">
											<div align="right">
												<?php $mes		= $m[4];
												$year		= $y[4];
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum4     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum44     = $row2[0];
													}
												}
												//echo ($sum4 + $sum44);
												$vent4 = ($sum4 + $sum44);
												$caja4 = intval($vent4 / $factor);
												$frac4 = (($vent4 / $factor) - intval($vent4 / $factor)) * $factor;
												echo "C" . $caja4;
												echo " ";
												echo "f" . $frac4;
												?>
											</div>
										</td>
										<td width="47">
											<div align="right">
												<?php $mes		= $m[3];
												$year		= $y[3];
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum3     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum33     = $row2[0];
													}
												}
												//echo ($sum3 + $sum33);
												$vent3 = ($sum3 + $sum33);
												$caja3 = intval($vent3 / $factor);
												$frac3 = (($vent3 / $factor) - intval($vent3 / $factor)) * $factor;
												echo "C" . $caja3;
												echo " ";
												echo "f" . $frac3;
												?>
											</div>
										</td>
										<td width="47">
											<div align="right">
												<?php $mes		= $m[2];
												$year		= $y[2];
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum2     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum22     = $row2[0];
													}
												}
												//echo ($sum2 + $sum22);
												$vent2 = ($sum2 + $sum22);
												$caja2 = intval($vent2 / $factor);
												$frac2 = (($vent2 / $factor) - intval($vent2 / $factor)) * $factor;
												echo "C" . $caja2;
												echo " ";
												echo "f" . $frac2;
												?>
											</div>
										</td>
										<td width="47">
											<div align="right">
												<?php $mes		= $m[1];
												$year		= $y[1];
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum1     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum11     = $row2[0];
													}
												}
												//echo ($sum1 + $sum11);
												$vent1 = ($sum1 + $sum11);
												$caja1 = intval($vent1 / $factor);
												$frac1 = (($vent1 / $factor) - intval($vent1 / $factor)) * $factor;
												echo "C" . $caja1;
												echo " ";
												echo "f" . $frac1;
												?>
											</div>
										</td>
										<td width="47">
											<div align="right">
												<?php $mes		= $m[0];
												$year		= $y[0];
												$sql2 = "SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum0     = $row2[0];
													}
												}
												$sql2 = "SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$sum00     = $row2[0];
													}
												}
												//echo ($sum0 + $sum00);
												$vent0 = ($sum0 + $sum00);
												$caja0 = intval($vent0 / $factor);
												$frac0 = (($vent0 / $factor) - intval($vent0 / $factor)) * $factor;
												echo "C" . $caja0;
												echo " ";
												echo "f" . $frac0;
												?>
											</div>
										</td>
										<td width="104">
											<div align="right">
												<?php //echo $factor;
												//$prom = ($sum0 + $sum1 + $sum2 + $sum3 + $sum4 + $sum5 + $sum00 + $sum11 + $sum22 + $sum33 + $sum44 + $sum55)/6;
												//echo $numero_formato_frances = number_format($prom, 2, '.', ' ');
												$prom = ($vent0 + $vent1 + $vent2 + $vent3 + $vent4 + $vent5) / 6;
												//$cajaprom = intval($prom/$factor);
												//$fracprom = (($prom/$factor) - intval($prom/$factor)) * $factor;
												//echo "C".$cajaprom; echo " "; echo "f".$fracprom;
												echo $numero_formato_frances = number_format($prom, 2, '.', ' ');
												$rr  = 0;
												$max = 0;
												$min = 0;
												while ($rr < 6) {
													$t = '$vent' . $rr;
													if ($max < $t) {
														$max = $t;
													}
													$rr++;
												}
												$rr  = 0;
												//$min = $vent0;
												while ($rr < 6) {
													$t = '$vent' . $rr;
													if ($min > $t) {
														$min = $t;
													}
													$rr++;
												}
												?>
											</div>
										</td>
										<td width="74">
											<div align="right">
												<?php echo $max; ?>
											</div>
										</td>
										<td width="90">
											<div align="right">
												<?php echo $min; ?>
											</div>
										</td>
										<td width="111">
											<div align="right">

												<?php if (($valform == 1) and ($local == $codloc)) { ?>
													<?php ?>
													<input name="minim" type="text" id="minim" size="4" value="<?php echo $stock_min ?>" onkeypress="return numeros1(event);" />
													<input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc ?>" />
													<input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
													<input name="country_ID" type="hidden" id="country_ID" value="<?php echo $marca ?>" />
													<input name="cr" type="hidden" id="cr" value="<?php echo $cr ?>" />
													<input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
													<input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR" />
												<?php } else {
													echo $stock_min;
												}
												?>
											</div>
										</td>
									</tr>
							<?php $c++;
									$cr++;
								}
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</form>
	<?php }	////CIERRO EL IF DE LA CONSULTA
	?>
</body>

</html>