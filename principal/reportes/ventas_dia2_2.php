<?php
require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../funciones/calendar.php");
require_once('../../funciones/highlight.php');
require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS








function pintaDatos($Valor)
{
	if ($Valor <> "") {
		return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
	}
}
function zero_fill($valor, $long = 0)
{
	return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script>
		function imprimir() {

			window.print();
			window.history.go(-2)

			f.submit();
		}
	</script>
	<style type="text/css">
		body,
		table {
			line-height: 80%
		}

		.letras {
			font-size: 18px;
		}

		.letras1 {
			font-size: 20px;
		}

		.letras22 {
			font-weight: 700;
			background: black;
			color: white;
			font-size: 19px;
		}

		.letras22x {
			font-size: 19px;
		}

		.letras12 {
			font-size: 20px;

			font-weight: 700px;

		}

		.letras121 {
			font-size: 25px;

			font-weight: 800px;

		}
	</style>
	<style>
		body,
		table {
			font-family: courier;
			font-size: 6px;
			font-weight: normal;
		}
	</style>
	<style type="text/css" media="print">
		div.page {
			writing-mode: tb-rl;
			height: 80%;
			margin: 10% 0%;
		}
	</style>
</head>

<body onload="imprimir()">
	<style type="text/css">
		.Estilo1 {
			color: #FF0000;
			font-weight: bold;
		}
	</style>
	<?php
	$date1 = $_REQUEST['date1'];
	$date2 = $_REQUEST['date2'];
	$local = $_REQUEST['local'];
	$ck = $_REQUEST['ck'];
	$val = $_REQUEST['val'];
	$vals = $_REQUEST['vals'];
	$ckloc = $_REQUEST['ckloc'];
	$ckprod = $_REQUEST['ckprod'];

	$from = $_REQUEST['from'];
	$until = $_REQUEST['until'];
	$valTipoDoc = $_REQUEST['valTipoDoc'];
	$tipoDoc = $_REQUEST['tipoDoc'];

	$hour  = date('G');
	//$hour   = CalculaHora($hour);
	$min	= date('i');
	if ($hour <= 12) {
		$hor    = "am";
	} else {
		$hor    = "pm";
	}
	if ($local <> 'all') {
		$sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
		$result = mysqli_query($conexion, $sql);
		while ($row = mysqli_fetch_array($result)) {
			$nloc	= $row["nomloc"];
			$nombre	= $row["nombre"];
			if ($nombre == '') {
				$locals = $nloc;
			} else {
				$locals = $nombre;
			}
		}
	}
	$dat1 = $date1;
	$dat2 = $date2;
	$date1 = fecha1($dat1);
	$date2 = fecha1($dat2);




	?>


	<div class="pagina">


		<table width="100%" height="50" border="1">
			<tr class="letras12">
				<td class="letras12" width="300" align="left" height="20"><strong>
						<pre><?php echo $desemp ?></pre></strong></td>

				<td class="letras12" width="260">
					<div class="letras12" align="right">
						<strong>
							<pre>FECHA </pre></strong>

						<strong>
							<pre> <?php echo date('d/m/Y'); ?></pre></strong>

					</div>
				</td>
			</tr>
			<tr>

				<td align="left" colspan="2" class="letras121" height="26">
					<div align="left" class="letras121" align="left">
						<strong>
							<pre>REPORTE DE CIERRE DEL DIA - <?php if ($local == 'all') {
																	echo 'TODAS LAS SUCURSALES';
																} else {
																	echo $locals;
																} ?></pre></strong>
					</div>
				</td>

			</tr>

			<tr>

				<td class="letras121" height="23" colspan="2" width="633">
					<div class="letras121" align="center"><b> DOCUMENTO ENTRE EL </b></div>
				</td>


			</tr>
			<br>
			<tr>


				<td class="letras121" colspan="2" width="633">
					<div class="letras121" align="center"><b><?php echo $from; ?> Y EL <?php echo $until; ?></b></div> </b>
	</div>
	</td>

	</tr>
	</table>



	<?php
	if (($ck == '') && ($ck1 == '')) {
		if (($valTipoDoc == 1)) {
	?>
			<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center">
							<tr>
								<?php if ($ckloc == 1) { ?>
									<td width="102" class="letras"><strong>
											<h1>LOC</h1>
										</strong></td>
								<?php } ?>
								<td width="<?php if ($ckloc == 1) { ?>200<?php } else { ?>300<?php } ?>" align="center" class="letras"><strong>
										<h1>VENDEDOR</h1>
									</strong></td>
								<!--<td width="87"><div align="right"><strong><h1># VENTAS</h1> </strong></div></td>-->
								<td width="61" class="letras">
									<div align="right"><strong>
											<h1>TOTAL</h1>
										</strong></div>
								</td>
								<!--    <td width="90"><div align="right"><strong>UTILIDAD</strong></div></td>-->
							</tr>
						</table>
					</td>
				</tr>
			</table>


			<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<?php
						$zz = 0;
						if ($valTipoDoc == 1) {
							if ($local == 'all') {
								if ($ckloc == 1) {
									$sql = "SELECT usecod,sucursal FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0'  group by usecod,sucursal order by sucursal, nrovent";
								} else {
									$sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  and invtot <> '0' group by usecod order by sucursal, nrovent";
								}
							} else {

								$sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and invtot <> '0'  and estado = '0' group by usecod order by sucursal, nrovent";
							}
						}

						$result = mysqli_query($conexion, $sql);
						if (mysqli_num_rows($result)) {
						?>
							<table width="100%" border="0" align="center">
								<?php while ($row = mysqli_fetch_array($result)) {
									$usecod    = $row['usecod'];
									$sucurs    = $row['sucursal'];

									if ($ckloc == 1) {
										$sucurs    = $row['sucursal'];
									}
									///////USUARIO QUE REALIZA LA VENTA
									$sql1 = "SELECT nomusu,abrev FROM usuario where  usecod = '$usecod'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$user    = $row1['nomusu'];
											$abrev    = $row1['abrev'];
											if ($ckloc == 1) {
												$user2 = substr($user, 0, 16);
											} else {
												$user2 = substr($user, 0, 22);
											}
										}
									}
									$e = 0;
									$t = 0;
									$c = 0;
									$e_tot = 0;
									$t_tot = 0;
									$c_tot = 0;
									$deshabil 	  = 0;
									$deshabil_tot = 0;
									$habil_tot    = 0;
									$count = 0;
									$sumpripro = 0;
									$sumpcosto = 0;
									$porcentaje = 0;
									$Rentabilidad = 0;
									if ($valTipoDoc == 1) {
										if ($local == 'all') {
											if ($ckloc == 1) {
												$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
											} else {
												$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  order by sucursal";
											}
										} else {
											$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local'  and estado = '0' order by sucursal";
										}
									}

									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$invnum    = $row1["invnum"];
											$forpag    = $row1["forpag"];
											$val_habil = $row1["val_habil"];
											$total     = $row1["invtot"];
											$sucursal  = $row1["sucursal"];
											$hora  = $row1["hora"];
											if ($ckloc == 1) {
												if ($sucursal <> $suc[$zz]) {
													$zz++;
													$suc[$zz] = $sucursal;
												}
											} else {
												if ($usecod <> $suc[$zz]) {
													$zz++;
													$suc[$zz] = $usecod;
												}
											}
											$sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
											$result3 = mysqli_query($conexion, $sql3);
											while ($row3 = mysqli_fetch_array($result3)) {
												$nloc	= $row3["nomloc"];
												$nombre	= $row3["nombre"];
												if ($nombre == '') {
													$sucur = $nloc;
												} else {
													$sucur = $nombre;
												}
											}
											if ($val_habil == 0) {
												if ($forpag == "E") {
													$e = $e + 1;
													$e_tot = $e_tot + $total;
													$e_tot1[$zz] = $e_tot1[$zz] + $total;
												}
												if ($forpag == "T") {
													$t = $t + 1;
													$t_tot = $t_tot + $total;
													$t_tot1[$zz] = $t_tot1[$zz] + $total;
												}
												if ($forpag == "C") {
													$c = $c + 1;
													$c_tot = $c_tot + $total;
													$c_tot1[$zz] = $c_tot1[$zz] + $total;
												}

												$sql2 = "SELECT cospro,pripro,canpro,fraccion,factor,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
												$result2 = mysqli_query($conexion, $sql2);
												if (mysqli_num_rows($result2)) {
													while ($row2 = mysqli_fetch_array($result2)) {
														$pcostouni    = $row2["cospro"]; //costo del producto x caja
														$pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
														$canpro       = $row2['canpro'];
														$fraccion     = $row2['fraccion'];
														$factor       = $row2['factor'];
														$prisal       = $row2['prisal']; //precio de venta x unidad
														$costpr       = $row2['costpr']; //costo del producto x unidad

														if ($fraccion == "T") {
															$RentPorcent  = (($prisal - $costpr) * $canpro);
															$Rentabilidad = $Rentabilidad + $RentPorcent;

															//$precio_costo = $pcostouni;
														} else {
															$RentPorcent  = (($prisal - $costpr) * $canpro);
															$Rentabilidad = $Rentabilidad + $RentPorcent;
														}
													}
												}
											}
											if ($val_habil == 1) {
												$deshabil++;
												$deshabil_tot = $deshabil_tot + $total;
												$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
											} else {
												$habil_tot = $habil_tot + $total;
												$habil_tot1[$zz] = $habil_tot1[$zz] + $total;
											}
											$count++;
										}
									}
									$rentabilidad       = $Rentabilidad;
									$rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;

									if (($suc[$zz - 1] <> "") and ($suc[$zz - 1] <> $suc[$zz])) {
								?>
										<tr bgcolor="#CCCCCC">


											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="5">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> "><strong>
														<h3>efc</h3>
													</strong></div>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="220">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz - 1], 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="500">
												<div align="center" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> "><strong>
														<h3>tar/otros</h3>
													</strong></div>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="240">
												<div align="left" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz - 1], 2, '.', ' ') + number_format($t_tot1[$zz - 1], 2, '.', ' ') + number_format($deshabil_tot1[$zz - 1], 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="57">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> "><strong>
														<h3>TOT</h3>
													</strong></div>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> " width="220">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?> ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz - 1], 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>

										</tr>
									<?php } ?>
									<tr>
										<?php if ($ckloc == 1) { ?><td width="30" class="letras">
												<h1><?php echo $sucur ?></h1>
											</td><?php } ?>
										<td colspan="6" align="center" class="letras" height="46px">
											<h1><?php echo $abrev ?></h1>
										</td>


									</tr>
									<?php if ($ckloc == 1) { ?>
										<tr>



											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="12">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  "><strong>
														<h3>efc</h3>
													</strong></div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="3100">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="450">
												<div align="center" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  "><strong>
														<h3>tar/otros</h3>
													</strong></div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="320">
												<div align="left" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ') + number_format($t_tot, 2, '.', ' ') + number_format($deshabil_tot, 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="67">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  "><strong>
														<h3>TOT
													</strong></div>
											</td>
											<td class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  " width="90">
												<div align="right" class="<?php if ($ckloc == 1) { ?>letras22x<?php } else { ?>letras1<?php } ?>  ">
													<h3>
														<pre><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' '); ?></pre>
													</h3>
												</div>
											</td>




										</tr>
									<?php } ?>

								<?php } ?>
							</table>
							<?php if ($zz == 1) { ?>
								<table width="100%" border="0" align="center">
									<tr bgcolor="#CCCCCC">


										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="5">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  "><strong>
													<h3>efc</h3>
												</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="220">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  ">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="500">
											<div align="center" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  "><strong>
													<h3>tar/otros</h3>
												</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="240">
											<div align="left" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  ">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="57">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  "><strong>
													<h3>TOT
												</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  " width="220">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>  ">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>

									</tr>
								</table>
							<?php } else {
							?>
								<table width="100%" border="0" align="center">
									<tr bgcolor="#CCCCCC">

										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>   " width="5">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>"><strong>efc</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>" width="220">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?> font-size:7px<?php } else { ?>letras1<?php } ?>" width="500">
											<div align="center" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>"><strong>
													<h3>tar/otros</h3>
												</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>" width="240">
											<div align="left" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>" width="57">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>"><strong>
													<h3>TOT
												</strong></div>
										</td>
										<td class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>" width="220">
											<div align="right" class="<?php if ($ckloc == 1) { ?>letras22<?php } else { ?>letras1<?php } ?>">
												<h3>
													<pre><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></pre>
												</h3>
											</div>
										</td>

									</tr>
								</table>
							<?php } ?>
						<?php } else { ?>
							 <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
						<?php } ?>
					</td>
				</tr>
			</table>
	<?php }
	} ?>
	</DIV>
</body>

</html>