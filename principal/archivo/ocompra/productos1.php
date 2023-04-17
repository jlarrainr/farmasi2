<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<link href="css/boton_graba.css" rel="stylesheet" type="text/css" />
	<link href="css/style2.css" rel="stylesheet" type="text/css" />
	<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
	<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../../funciones/ajax.js"></script>
	<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
	<link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
	<script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	require_once("funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("funciones/compra.php");	//COLORES DE LOS BOTONES
	function formato($c)
	{
		printf("%08d", $c);
	}
	$codigo = $_REQUEST['codpro'];
	$val    = $_REQUEST['val'];
	$pp     = $_REQUEST['pp'];
	$sql = "SELECT limite_compra FROM datagen_det";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$limite_compra = $row["limite_compra"];
		}
	}
	$sql1 = "SELECT porcent FROM datagen";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$porcent    = $row1['porcent'];
		}
	}
	$cr = $_REQUEST['cr'];
	if ($cr == '') {
		$cr = 0;
	}
	?>
	<style>
		a:link,
		a:visited {
			color: #0066CC;
			border: 0px solid #e7e7e7;
		}

		a:hover {
			background: #fff;
			border: 0px solid #ccc;
		}

		a:focus {
			background-color: #FFFF66;
			color: #0066CC;
			border: 0px solid #ccc;
		}

		a:active {
			background-color: #FFFF66;
			color: #0066CC;
			border: 0px solid #ccc;
		}

		#myTab {
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#myTab td,
		#myTab th {
			border: 1px solid #ddd;
			padding: 3px;
		}

		#myTab td a {
			color: #4d9ff7;
			font-weight: bold;
			font-size: 15px;
			text-decoration: none;
		}

		#myTab #total {
			text-align: center;
			background-color: #fe5050;
			color: white;
			font-size: 16px;
			font-weight: 900;
		}

		#myTab tr:nth-child(even) {
			background-color: #f0ecec;
		}

		#myTab tr:hover {
			background-color: #ddd;
		}

		#myTab th {
			text-align: center;
			background-color: #50adea;
			color: white;
			font-size: 12px;
			font-weight: 900;
		}
	</style>
	<script>
		function letrau(evt) {
			var key = nav4 ? evt.which : evt.keyCode;
			return (key == 85 || key == 117 || key <= 13 || (key >= 48 && key <= 57));
		}
	</script>
	<script>
		function act_ck() {
			if (document.form1.cck.checked) {
				document.form1.bonif.disabled = false;
				document.form1.bonif.focus();
			} else {
				document.form1.bonif.disabled = true;
			}
		}

		function grabar() {
			<?php $sql = "SELECT sum(invtot) FROM ordmae where invnum = '$ord_compra'";
			$result = mysqli_query($conexion, $sql);
			if (mysqli_num_rows($result)) {
				while ($row = mysqli_fetch_array($result)) {
					$invtot = $row[0];
				}
			} else {
				$invtot = 0;
			}
			///////////////////////////////////////////////////////////////
			$sql = "SELECT codord FROM ordmov where invnum = '$ord_compra' and canbon <> 0";
			$result = mysqli_query($conexion, $sql);
			if (mysqli_num_rows($result)) {
				while ($row = mysqli_fetch_array($result)) {
					$codord = $row["codord"];
					$sql1 = "SELECT invnum,codord FROM tempordmov_bonif where invnum = '$ord_compra' and codord = '$codord'";
					$result1 = mysqli_query($conexion, $sql1);
					if (mysqli_num_rows($result1)) {
					} else {
						$nohay = 1;
					}
				}
			}
			///////////////////////////////////////////////////////////////
			if ($invtot == 0) {
			?>
				alert("No se puede grabar esta Orden de Compra");
				return;
				<?php } else {
				if ($nohay == 1) {
				?>
					alert("Debe registrar las Bonificaciones");
					return;
				<?php } else {
				?>
					var f = document.form3;
					ventana = confirm("�Desea Grabar esta Orden de Compra?");
					if (ventana) {
						f.method = "post";
						f.target = "_top";
						f.action = "graba_compra.php";
						f.submit();
					}
			<?php }
			}
			?>
		}

		function bot1() {
			document.form3.pp.value = 1;
			document.form3.method = "post";
			document.form3.submit();
		}

		function bot2() {
			document.form3.pp.value = 2;
			document.form3.method = "post";
			document.form3.submit();
		}

		function bot3() {
			document.form3.pp.value = 3;
			document.form3.method = "post";
			document.form3.submit();
		}

		function tecc(evt) {
			var f = document.form3;
			var key = nav4 ? evt.which : evt.keyCode;
			if (key == 118) {
				document.form3.pp.value = 1;
				document.form3.method = "post";
				document.form3.submit();
			}
			if (key == 119) {
				document.form3.pp.value = 2;
				document.form3.method = "post";
				document.form3.submit();
			}
			if (key == 120) {
				document.form3.pp.value = 3;
				document.form3.method = "post";
				document.form3.submit();
			}
		}

		function tippbon() {
			var tip = document.form2.tipbonif.value;
			if (tip == 1) {
				document.form2.country.disabled = true;
				document.form2.country.value = "";
			}
			if (tip == 2) {
				document.form2.country.disabled = false;
				document.form2.country.focus();
			}
		}

		function validar_bonif() {
			var tip = document.form2.tipbonif.value;
			if (tip == 2) {
				if (document.form2.country_ID.value == "") {
					alert("Ingrese el nombre del Producto");
					document.form2.country.focus();
					return;
				}
			}
			if (document.form2.bonif_can.value == "") {
				alert("Ingrese la Cantidad a Ingresar");
				document.form2.bonif_can.focus();
				return;
			}
			var v1 = document.form2.bonif_can.value; //CANTIDAD 
			var valor = isNaN(v1);
			if (valor == true) ////NO ES NUMERO
			{
				document.form2.nnum.value = 1; ////avisa que no es numero
			} else {
				document.form2.nnum.value = 0; ////avisa que es numero
			}
			document.form2.method = "post";
			document.form2.action = "productos33.php";
			document.form2.submit();
		}
		window.onload = function() {
			var row = document.getElementById("myTab").rows;
			row[<?php echo $cr ?>].scrollIntoView(false);
		}

		function getfocus() {
			document.getElementById('l<?php echo $cr ?>').focus()
		}
	</script>
</head>

<body onload="<?php if ($val == 1) { ?>ttext()<?php } else { ?>getfocus()<?php } ?>" onkeyup="tecc(event)">
	<?php echo $val; ?>
	<table width="100%" border="0">
		<tr>
			<td width="100%">
				<form id="form3" name="form3" onKeyUp="highlight(event)" onClick="highlight(event)">
					<table width="100%" border="0" bgcolor="#FFFFCC">
						<tr>
							<td width="30%">
								<input name="pp" type="hidden" id="pp" value="" />
								<div align="center"><strong>&quot;F7&quot;</strong>=
									<input type="button" name="Submit2" value="TODOS LOS PRODUCTOS" class="modificar" onclick="bot1()" />
								</div>
							</td>
							<td width="30%">
								<div align="center"><strong>&quot;F8&quot;</strong>=
									<input type="button" name="Submit3" value="PRODUCTOS CON PEDIDO" class="modificar" onclick="bot2()" />
								</div>
							</td>
							<td width="30%">
								<div align="center"><strong>&quot;F9&quot;</strong>=
									<input type="button" name="Submit4" value="PRODUCTOS SIN PEDIDO" class="modificar" onclick="bot3()" />
								</div>
							</td>
							<td width="10%">
								<div align="right">
									<input name="Submit" type="button" onclick="grabar()" class="grabarventa" value="GRABAR ORDEN DE COMPRA" />
								</div>
							</td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="900" height="4" /> </div>
				</form>
				<?php $i = 0;
				if (($pp == 1) || ($pp == "") || ($pp == "3")) {
					$sql = "SELECT codpro,desprod,prelis,blister,factor,stopro,codmar,igv,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,fecord FROM producto inner join temp_marca on producto.codmar = temp_marca.codtab where invnum= '$ord_compra' and activo1 = '1' order by desprod";
				}
				if ($pp == 2) {
					$sql = "SELECT producto.codpro,desprod,prelis,blister,producto.factor,stopro,producto.codmar,igv,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,fecord FROM ordmov inner join producto on ordmov.codpro = producto.codpro inner join temp_marca on producto.codmar = temp_marca.codtab where temp_marca.invnum= '$ord_compra' and ordmov.invnum = '$ord_compra' and activo1 = '1' order by desprod";
				}
				$result = mysqli_query($conexion, $sql);
				if (mysqli_num_rows($result)) {
					$codord   = $_REQUEST['codord'];
					$codprod1 = $_REQUEST['codprod1'];
					$bon	  = $_REQUEST['bon'];
					if ($bon == 1) {
				?>
						<table width="100%" class="celda2">
							<tr>
								<td class="titulos_movimientos" bgcolor="#50ADEA">INGRESO DE BONIFICACIONES </td>
							</tr>
						</table>
						<form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
							<?php $sqlq = "SELECT codpro,canbon,tipbon FROM ordmov where codord = '$codord' and invnum = '$ord_compra' and mont_total <> '0'";
							$resultq = mysqli_query($conexion, $sqlq);
							if (mysqli_num_rows($resultq)) {
								while ($rowq = mysqli_fetch_array($resultq)) {
									$codprobon        = $rowq["codpro"];	////PRODUCTO ORIGINAL
									$canbonbon        = $rowq["canbon"];	////CANTIDAD BONIFICABLE
									$tipbon           = $rowq["tipbon"];	////SI ES POR CAJA O POR UNIDAD
								}
							}
							$sqlq = "SELECT codpro,canbon,tipbon FROM tempordmov_bonif where codord = '$codord' and invnum = '$ord_compra'";
							$resultq = mysqli_query($conexion, $sqlq);
							if (mysqli_num_rows($resultq)) {
								while ($rowq = mysqli_fetch_array($resultq)) {
									$codprobon1        = $rowq["codpro"];	////PRODUCTO BONIFICABLE
									$canbonbon1        = $rowq["canbon"];
									$tipbon1           = $rowq["tipbon"];
									$tyt			   = 1;
								}
							} else {
								$tyt = 0;
							}
							$sqlq = "SELECT desprod FROM producto where codpro = '$codprobon'";
							$resultq = mysqli_query($conexion, $sqlq);
							if (mysqli_num_rows($resultq)) {
								while ($rowq = mysqli_fetch_array($resultq)) {
									$desprodbon       = $rowq["desprod"];
								}
							}
							if ($tyt == 1) {
								$sqlq = "SELECT desprod FROM producto where codpro = '$codprobon1'";
								$resultq = mysqli_query($conexion, $sqlq);
								if (mysqli_num_rows($resultq)) {
									while ($rowq = mysqli_fetch_array($resultq)) {
										$desprodbon1      = $rowq["desprod"];
									}
								}
							}
							?>
							<table width="100%" border="0" bgcolor="#FFFFCC" class="celda2">
								<tr>
									<td width="86"><strong>PRODUCTO</strong></td>
									<td width="479"><?php echo $desprodbon ?></td>
									<td width="94">
										<div align="right"><strong>TIPO DE BONIF </strong></div>
									</td>
									<td width="260"><label>
											<select name="tipbonif" onchange="tippbon()">
												<option value="1">EL MISMO PRODUCTO</option>
												<option value="2">OTRO PRODUCTO</option>
											</select>
										</label>
									</td>
								</tr>
							</table>
							<table width="100%" border="0" bgcolor="#FFFFCC" class="celda2">
								<tr>
									<td width="85"><strong>BONIFICACION</strong></td>
									<td width="503">
										<input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="80" disabled="disabled" value="<?php if ($tyt == 1) {
																																																echo $desprodbon1;
																																															} else {
																																																echo $desprodbon;
																																															} ?>" />
										<input type="hidden" id="country_hidden" name="country_ID" value="<?php if ($tyt == 1) {
																												echo $codprobon1;
																											} ?>" /></td>
									<td width="67">
										<div align="right"><strong>CANTIDAD </strong></div>
									</td>
									<td width="251">
										<input name="bonif_can" type="text" id="bonif_can" size="5" onkeypress="return letrau(event)" value="<?php if ($tyt == 1) {
																																					echo $canbonbon1;
																																					if ($tipbon1 == "U") {
																																						echo "U";
																																					}
																																				} else {
																																					echo $canbonbon;
																																					if ($tipbon == "U") {
																																						echo "U";
																																					}
																																				} ?>" />
										<input name="nnum" type="hidden" id="nnum" />
										<input name="codord" type="hidden" id="codord" value="<?php echo $codord ?>" />
										<input name="codprobon" type="hidden" id="codprobon" value="<?php echo $codprobon ?>" />
										<input type="button" name="Submit" value="Grabar" onclick="validar_bonif()" />
										<input type="submit" name="Submit2" value="Cancelar" />
									</td>
								</tr>
							</table>
						</form>
						<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
					<?php }
					?>
					<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
						<table width="100%" border="0" id="myTab">
							<thead id="Topicos_Cabecera_Datos">
								<tr>
									<th width="2"><span class="Estilo8"></span></th>
									<th width="2"><span class="Estilo8"></span></th>
									<th width="2"><span class="Estilo8"></span></th>
									<th width="236"><span class="Estilo8">PRODUCTO</span></th>
									<th width="54"><span class="Estilo8">CODPROD</span></th>
									<th width="81">
										<div align="right" class="Estilo8">PRECIO</div>
									</th>
									<th width="53">
										<div align="right" class="Estilo8">DTO1</div>
									</th>
									<th width="58">
										<div align="right" class="Estilo8">DTO2</div>
									</th>
									<th width="59">
										<div align="right" class="Estilo8">DTO3</div>
									</th>
									<th width="63">
										<div align="right" class="Estilo8">TOT DTO </div>
									</th>
									<th width="63">
										<div align="right" class="Estilo8">PEDIDO</div>
									</th>
									<th width="52">
										<div align="right" class="Estilo8">BONIF</div>
									</th>
									<th width="52">
										<div align="right" class="Estilo8">P. FINAL</div>
									</th>
									<th width="82">
										<div align="right" class="Estilo8">MONTO NETO </div>
									</th>
									<th width="2">
										<div align="right" class="Estilo8"> </div>
									</th>
									<th width="12">&nbsp;</th>
								</tr>
							</thead>
							<tbody id="gtnp_Listado_Datos">
								<?php $cr = 0;
								//$hour   = date(G);
								$dater	= date('Y-m-d');
								//$dater	= CalculaFechaHora($hour);
								while ($row = mysqli_fetch_array($result)) {
									$canbon 	= "";
									$codpro     = $row['codpro'];
									$desprod    = $row['desprod'];
									$prelis     = $row['prelis'];
									$blister    = $row['blister'];
									$factor     = $row['factor'];
									$stopro     = $row['stopro'];
									$codmar     = $row['codmar'];
									$fecord     = $row['fecord'];
									$igv        = $row['igv'];
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
									//$dater          = date('Y-m-d');
									$tot        = 0;
									$ax			= 0;
									$bx         = 0;
									if ($factor == 0) {
										$factor = 1;
									}
									if ($fecord == "") {
										$fecha = $dater;
									} else {
										$fecha = $fecord;
									}
									list($ycar1, $mcar1, $dcar1) = split('[/.-]', $fecha);
									list($ycar2, $mcar2, $dcar2) = split('[/.-]', $dater);
									$ano1 = $ycar1;
									$mes1 = $mcar1;
									$dia1 = $dcar1;
									//defino fecha 2
									$ano2 = $ycar2;
									$mes2 = $mcar2;
									$dia2 = $dcar2;
									/////////////////////////////////////////
									//calculo timestam de las dos fechas
									$timestamp1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
									$timestamp2 = mktime(4, 12, 0, $mes2, $dia2, $ano2);
									//resto a una fecha la otra
									$segundos_diferencia = $timestamp1 - $timestamp2;
									//echo $segundos_diferencia;
									//convierto segundos en d�as
									$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
									//obtengo el valor absoulto de los d�as (quito el posible signo negativo)
									$dias_diferencia = abs($dias_diferencia);
									//quito los decimales a los d�as de diferencia
									$dias_diferencia = floor($dias_diferencia);
									/////////////////////////////////////////////////////////////
									$min		= $m00 + $m01 + $m02 + $m03 + $m04 + $m05 + $m06 + $m07 + $m08 + $m09 + $m10 + $m11 + $m12 + $m13 + $m14 + $m15 + $m16;
									if (($blister == 0) || ($blister == 1)) {
										if ($factor == 1) {
											$tot    = $min - $stopro;
										} else {
											$ax     = round($stopro / $factor);
											$tot    = ($min - $ax);
										}
									}
									if ($blister > 1) {
										if ($factor == 1) {
											$tot    = $min - $stopro;
										} else {
											$ax     = round($min / $factor);
											$bx     = round($stopro / $factor);
											$tot    = ($ax - $bx);
										}
									}
									$d = 0;
									$sql1 = "SELECT codord,codpro,canpro,desc1,desc2,desc3,precio_ref,costod,mont_total,canbon,tipbon,pfinal FROM ordmov where invnum= '$ord_compra' and codpro = '$codpro'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$codord     = $row1['codord'];
											$codpross   = $row1['codpro'];
											$canpro     = $row1['canpro'];
											$desc1      = $row1['desc1'];
											$desc2      = $row1['desc2'];
											$desc3      = $row1['desc3'];
											$precio_ref = $row1['precio_ref'];
											$costod     = $row1['costod'];
											$mont_total = $row1['mont_total'];
											$canbon     = $row1['canbon'];
											$tipbon     = $row1['tipbon'];
											$pfinal     = $row1['pfinal'];
											$d = 1;
										}
									} else {
										$d = 0;
										$canpro     = "";
										$desc1      = "";
										$desc2      = "";
										$desc3      = "";
										$precio_ref = "";
										$costod     = "";
										$mont_total = "";
										$pfinal     = "";
									}
									$sql1 = "SELECT canbon FROM tempordmov_bonif where codprobon = '$codpro'"; /////consulta del producto principal y si tiene bonificacion
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										$ccbon = 1;
									} else {
										$ccbon = 0;
									}
									if (($pp == "") || ($pp == 1) || ($pp == 2) || (($pp == 3) && ($codpro <> $codpross))) {
								?>
										<?php /*?><tr <?php if ($codigo == $codpro){?>bgcolor="#FFFF99"<?php } else{?> onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='<?php if ($d == 1){?>#FFFF99<?php } else {?>#ffffff<?php }?>';" onclick='marcame(this)' <?php }?>><?php */ ?>
										<tr onmouseover="this.style.backgroundColor='#CCFFCC';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#FFFFFF';">
											<td width="14" valign="bottom">
												<a href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro ?>', 10, 50, 1000, 350)">
													<img src="../../../images/lens.gif" width="14" height="15" border="0" /> </a> </td>
											<td width="17" valign="bottom">
												<?php if ($d == 1) {
												?>
													<a href="javascript:popUpWindow('observacion.php?cod=<?php echo $codpro ?>', 50, 90, 570, 135)">
														<img src="../../../images/obs.gif" width="16" height="16" border="0" /> </a>
												<?php }
												?>
											</td>
											<td width="18">
												<center>
													<?php if ($canbon <> 0) { ?>
														<a href="productos1.php?codprod1=<?php echo $codpro ?>&codord=<?php echo $codord ?>&bon=1">
															<img src="<?php if ($ccbon == 0) { ?>../../../images/tickr.gif<?php } else { ?>../../../images/tickg.gif<?php } ?>" width="16" height="16" border="0" title="REGISTRO DE BONIFICACION" /> </a>
													<?php } ?>
												</center>
											</td>
											<td width="175" valign="bottom">
												<?php if ($codigo == $codpro) {
												?>
													<font color="#009933">
														<b><u>
																<?php echo substr($desprod, 0, 65);
																echo "...";
																?>
															</u></b>
													</font>
												<?php } else {
												?>
													<a id="l<?php echo $cr; ?>" href="productos.php?tip=3&codpro=<?php echo $codpro ?>&cr=<?php echo $cr ?>" target="compra_index1">
														<?php echo substr($desprod, 0, 65);
														echo "..."; ?> 
													</a>
												<?php }
												?>
												</a>
											</td>
											<td width="66" valign="bottom"><?php echo formato($codpro); ?></td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="price" type="text" id="price" size="5" onKeyPress="return decimal(event)" value="<?php if ($d == 1) {
																																							echo $precio_ref;
																																						} else {
																																							echo $prelis;
																																						} ?>" onKeyUp="precio();" />
													<?php } else {
														if ($d == 1) {
															echo $precio_ref;
														} else {
															echo $prelis;
														}
													}
													?>
												</div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="dcto1" type="text" id="dcto1" onKeyPress="return decimal(event)" onKeyUp="precio();" size="5" maxlength="6" value="<?php if ($d == 1) {
																																															echo $desc1;
																																														} else {
																																															echo "0";
																																														} ?>" />
													<?php } else {
														if ($d == 1) {
															echo $desc1;
														}
													}
													?>
												</div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="dcto2" type="text" id="dcto2" onKeyPress="return acceptNum(event)" onKeyUp="precio();" size="5" maxlength="6" value="<?php if ($d == 1) {
																																																echo $desc2;
																																															} else {
																																																echo "0";
																																															} ?>" />
													<?php } else {
														if ($d == 1) {
															echo $desc2;
														}
													}
													?>
												</div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="dcto3" type="text" id="dcto3" onKeyPress="return acceptNum(event)" onKeyUp="precio();" size="5" maxlength="6" value="<?php if ($d == 1) {
																																																echo $desc3;
																																															} else {
																																																echo "0";
																																															} ?>" />
													<?php } else {
														if ($d == 1) {
															echo $desc3;
														}
													}
													?>
												</div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="tot_dcto" type="text" id="tot_dcto" size="5" onKeyPress="return acceptNum(event)" onclick="blur()" disabled="disabled" value="<?php if ($d == 1) {
																																																		echo $costod;
																																																	} else {
																																																		echo $prelis;
																																																	} ?>" />
													<?php } else {
														if ($d == 1) {
															echo $costod;
														}
													}
													?>
												</div>
												<div align="right"></div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="pedido" type="text" id="pedido" size="5" onKeyPress="return acceptNum(event)" value="<?php if ($d == 1) {
																																								echo $canpro;
																																							} else {
																																								echo $tot;
																																							} ?>" onKeyUp="precio();" />
													<?php } else {
														if ($d == 1) {
															echo $canpro;
														} else {
															echo $tot;
														}
													}
													?>
												</div>
											</td>
											<td width="52" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input type="checkbox" name="cck" onclick="act_ck()" <?php if ($canbon <> "") { ?>checked="checked" <?php } ?> />
														<input name="bonif" type="text" id="bonif" size="5" onkeypress="return letrau(event)" <?php if ($canbon == "") { ?>disabled="disabled" <?php } ?> value="<?php if ($canbon <> "") {
																																																						echo $canbon;
																																																						if ($tipbon == "U") {
																																																							echo "u";
																																																						}
																																																					} ?>" />
													<?php } else {
														if ($d == 1) {
															echo $canbon;
															if ($tipbon == "C") {
																echo " CAJAS";
															}
															if ($tipbon == "U") {
																echo " UNIDADES";
															}
														}
													}
													?>
												</div>
											</td>
											<td width="52" valign="bottom">
												<div align="right">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="pfinal" type="text" id="pfinal" size="5" value="<?php echo $pfinal ?>" onKeyPress="return decimal(event)" />
													<?php } else {
														echo $pfinal;
													} ?>
												</div>
											</td>
											<td width="60" valign="bottom">
												<div align="right">
													<?php if ($igv == 1) {
														$igv_porcentaje = (1 + ($porcent / 100));
														$igv_porcentaje	= number_format($igv_porcentaje, 2, '.', ',');
														$tot_descuent	= $igv_porcentaje * $prelis;
														$tot_descuent	= number_format($tot_descuent, 2, '.', ',');
													} else {
														$tot_descuent   = $prelis;
													}
													if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="monto" type="text" id="monto" size="5" disabled="disabled" value="<?php if ($d == 1) {
																																			echo $mont_total;
																																		} else {
																																			echo ($tot_descuent * $tot);
																																		} ?>" />
														<?php /*?><input name="monto" type="text" id="monto" size="5" disabled="disabled" value="<?php echo $mont_total?>"/><?php */ ?>
													<?php } else {
														if ($d == 1) {
															echo $mont_total;
														}
													}
													?>
												</div>
											</td>
											<td width="17" valign="bottom">
												<div align="center">
													<?php if (($val == 1) and ($codigo == $codpro)) {
													?>
														<input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
														<input name="tots_dcto" type="hidden" id="tots_dcto" value="<?php if ($d == 1) {
																														echo $costod;
																													} else {
																														echo $tot_descuent;
																													} ?>" />
														<input name="montos" type="hidden" id="montos" value="<?php if ($d == 1) {
																													echo $mont_total;
																												} else {
																													echo ($tot_descuent * $tot);
																												} ?>" />
														<input name="codmar" type="hidden" id="codmar" value="<?php echo $codmar ?>" />
														<input name="porcentaje" type="hidden" value="<?php if ($igv == 1) {
																											echo $porcent;
																										} ?>" />
														<input name="cr" type="hidden" id="cr" value="<?php echo $cr ?>" />
														<input name="numero" type="hidden" id="numero" />
														<input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
														<?php } else {
														if ($dias_diferencia >= $limite_compra) {
														?>
															<a href="productos.php?tip=3&val=1&codpro=<?php echo $codpro ?>" target="compra_index1">
																<img src="../../../images/add.gif" width="14" height="15" border="0" /> </a>
															<?php } else {
															if ($fecord == "") {
															?>
																<a href="productos.php?tip=3&val=1&codpro=<?php echo $codpro ?>" target="compra_index1">
																	<img src="../../../images/add.gif" width="14" height="15" border="0" /> </a>
															<?php } else {
															?>
																<img src="../../../images/lock_16.png" width="14" height="15" border="0" />
													<?php }
														}
													}
													?>
												</div>
											</td>
											<td width="17" valign="bottom">
												<?php if ($d == 1) {
												?>
													<div align="center">
														<a href="productos1_del.php?codpro=<?php echo $codpro; ?>&codord=<?php echo $codord ?>&cr=<?php echo $cr ?>" target="compra_index1"><img src="../../../images/del_16.png" width="16" height="16" border="0" /></a></div>
													<?php } else {
													if (($val == 1) and ($codigo == $codpro)) {
													?>
														<a href="productos.php?tip=3" target="compra_index1"><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /></a>
												<?php }
												}
												?>
											</td>
										</tr>
								<?php }
									$cr++;
								}
								?>
							</tbody>
						</table>
					<?php }
					?>
					</form>
			</td>
		</tr>
	</table>
</body>

</html>

<script>
	$(document).ready(function() {
			$('#myTab').DataTable({
				"pageLength": 50,
				language: {
					"sProcessing": "Procesando...",
					"sLengthMenu": "Mostrar _MENU_ registros",
					"sZeroRecords": "No se encontraron resultados",
					"sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
					"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix": "",
					"sSearch": "Buscar:",
					"sUrl": "",
					"sInfoThousands": ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst": "Primero",
						"sLast": "Ãltimo",
						"sNext": "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					},
					"buttons": {
						"copy": "Copiar",
						"colvis": "Visibilidad"
					}
				}
			});
			var table = $('#myTab').DataTable();
 
$('div.dataTables_filter input', table.table().container()).focus();
		}

	);
</script>