<?php include('../../session_user.php');
$invnummovmae = $_SESSION['nota_credito'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


	<title>Documento sin t&iacute;tulo</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
	<?php
	require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../funciones/devolucion.php");	//FUNCIONES DE ESTA PANTALLA
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES


	?>
	<style>
		.Estilo2 {
			color: #ff4b0d;
			font-size: 35px;
			/* font-weight: bold; */
		}
	</style>
</head>

<body onload="ad();">
	<?php
	$tip = $_REQUEST['tip'];
	$num = $_REQUEST['num'];
	$invnum = $_REQUEST['invnum'];

	$sql = "SELECT invnum FROM venta where (nrofactura LIKE '$num' or nrovent='$num'  ) and val_habil='0' and estado = '0'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$invnum2         = $row['invnum'];		////CODIGO DEL PRODUCTO
		}
	}




	if ($tip == 1) {
		$sql = "SELECT * FROM temp_detalle_venta where invnum = '$invnum2' and usecod='$usuario' ";
	} else {
		$sql = "SELECT * FROM temp_detalle_venta where invnum = '$invnum' and usecod='$usuario' ";
	}
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
	?>
		<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
			<div style="height: 380px;">
				<table class="celda2" width="100%">
					<?php // echo "movmae ".$invnummovmae;
					?>
					<tr height="25" style="font-size:16px;">
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">CODIGO P.</div>
						</th>
						
						<th width="362" bgcolor="#50ADEA" class="titulos_movimientos">
							<div>DESCRIPCION</div>
						</th>
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">MARCA</div>
						</th>
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">FACTOR</div>
						</th>
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">CANTIDAD</div>
						</th>

						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">P.VENTA</div>
						</th>
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center">SUB TOT</div>
						</th>
						<th bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="center"></div>
						</th>
					</tr>
					<?php $i = 0;
					while ($row = mysqli_fetch_array($result)) {
						$i++;
						$codpro         = $row['codpro'];
						$canpro         = $row['canpro'];
						$fraccion       = $row['fraccion'];
						$prisal         = $row['prisal'];
						$pripro         = $row['pripro'];
						$resta         = $row['resta'];


						$icod = $i;
						$sql1 = "SELECT porcent FROM datagen";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$porcent    = $row1['porcent'];
							}
						}
						$sql1 = "SELECT nrofactura FROM venta where invnum = '$invnum' and val_habil = '0' and tipdoc <> 4  ";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$nrofactura   = $row1['nrofactura'];
							}
						}
						$sql1 = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$desprod    = $row1['desprod'];
								$codmar     = $row1['codmar'];
								$factor     = $row1['factor'];
							}
						}
						$sql1 = "SELECT * FROM titultabla where dsgen = 'MARCA'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$ltdgen     = $row1['ltdgen'];
							}
						}
						$sql1 = "SELECT * FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$marca     = $row1['destab'];
							}
						}

						$valform = $_REQUEST['valform'];
						$cod     = $_REQUEST['cod'];
						$icod     = $_REQUEST['icod'];

						if (($valform == 1) && ($cod == $codpro) && ($icod == $i)) {
							$sql1 = "SELECT canpro,fraccion,factor FROM detalle_venta where invnum = '$invnum' and codpro='$cod'";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$fraccion_detalle	= $row1['fraccion'];
									$canpro_detalle     = $row1['canpro'];
									$factor_detalle     = $row1['factor'];
									$canproorig     	= $row1['canpro'];

									// if ($fraccion = "F") {
									// 	$canproorig = $canpro_detalle * $factor_detalle;
									// } else {
									// 	$canproorig = $canpro_detalle;
									// }
								}
							}


							// echo "invnum-- " . $invnum . "<br>";
							// echo "cod" . $cod . "<br>";
						}
						$sql1 = "SELECT * FROM temp_venta2 where invnum = '$invnum' ";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row = mysqli_fetch_array($result1)) {
								$invtot         = $row['invtot'];
								$igv            = $row['igv'];
								$valven            = $row['valven'];
							}
						}


					?>

						<tr  <?php if($resta <> 0){ ?> bgcolor="#fb9175" color="#ffffff"<?php } ?> >
							<td valign="bottom" align="center"><?php echo $codpro; ?></td>
							<td width="364" valign="bottom" title="EL FACTOR ES <?php echo $factor ?>">
								<a title="EL FACTOR ES <?php echo $factor; ?>"><?php echo $desprod ?></a> </td>
							<td valign="bottom"><?php echo $marca; ?></td>
							<td valign="bottom" align="center"><?php echo $factor; ?></td>
							<td valign="bottom">
								<div align="center">
									<?php if (($valform == 1) && ($cod == $codpro) && ($icod == $i)) { ?>

										<input type="hidden" name="canpro" value="<?php echo $canproorig; ?>" />
										<input type="hidden" name="stockpro" value="<?php echo $cant_loc; ?>" />
										<input type="hidden" name="factor" value="<?php echo $factor; ?>" />
										<input type="hidden" name="codpro" value="<?php echo $codpro; ?>" />
										<input type="hidden" name="fraccion" value="<?php echo $fraccion; ?>" />
										<input name="t1" type="text" class="input_text1" id="t1" value="<?php if ($fraccion == "T") {
																											echo $canpro;
																										} else {
																											$canpro = "c" . $canpro;
																											echo $canpro;
																										} ?>" size="15" onkeyup="precio1();" <?php if ($fraccion == "T") { ?>onKeyPress="return ent2(event)" placeholder=" En Unidades" <?php } else { ?> onKeyPress="return ent(event)" placeholder=" En Cajas" <?php } ?>autofocus="autofocus" /> <samp style="color:#FF0000" ;> <?php if ($fraccion == "T") {
																																																																																														$canproorig = "F" . $canproorig;
																																																																																														echo '< ' . $canproorig;
																																																																																													} else {
																																																																																														$canproorig = "C" . $canproorig;
																																																																																														echo '< ' . $canproorig;
																																																																																													}   ?></samp>
									<?php } else {
										if ($fraccion == "F") {
											$canpro = "c" . $canpro;
											echo $canpro;
										} else {
											$canpro = "f" . $canpro;
											echo $canpro;
										}
									} ?>
								</div>

							</td>

							<td valign="bottom">
								<div align="right"><?php echo $prisal; ?></div>
							</td>
							<td valign="bottom">
								<div align="right"><?php echo $pripro; ?></div>
							</td>
							<td valign="bottom">
								<div align="center">
									<?php if (($valform == 1) && ($cod == $codpro) && ($icod == $i)) { ?>
										<input name="number" type="hidden" id="number" />
										<input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
										<input name="invnum" type="hidden" id="invnum" value="<?php echo $invnum ?>" />
										<input name="usuario" type="hidden" id="usuario" value="<?php echo $usuario ?>" />

										<input name="nrofactura" type="hidden" id="nrofactura" value="<?php echo $nrofactura ?>" />
										<input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
										<input name="button" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
									<?php } else { ?>
										<a href="devolucion2.php?cod=<?php echo $codpro ?>&icod=<?php echo $i ?>&invnum=<?php echo $invnum ?>&valform=1"><img src="../../../images/edit_16.png" width="18" height="18" border="0" /></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php }
					?>
				</table>
			</div>
			<table width="100%" border="0">
				<tr>
					<td width="955">
						<?php
						require_once("monto.php");
						?>
						<!-- <iframe src="monto.php?invnum=<?php echo $invnum ?>" name="iFrame2" width="100%" height="410" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe> -->
					</td>
				</tr>
			</table>

		<?php } else {
		?>

			<br><br><br><br><br><br><br><br>
		<div class="botones" style="padding: 15px">
				<center>
					<h1 class='Estilo2'> NO SE ECONTRO EL COMPROBANTE INGRESADO. <h1>
							<br>
							<div align="left"> Verifique los siguientes pasos:</div><br>
							<div align="left"> Para buscar un comprobante, escriba la serie y número exactamente igual como se muestra en el ticket impreso, Ejemplo: para buscar B001-1 escribir B001-1 (No olvidar el guion intermedio) y asegurese  que el documento no este anulado o ya tenga realiado una nota de credito anterior</div>
				</center>
			</div>
		<?php }
		?>


		</form>


</body>

</html>