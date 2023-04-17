<?php
require_once('../../session_user.php');
//echo $usuario;exit;
require_once('session_ventas_temp.php');
//echo "hola";exit;
$tventa        = isset($_SESSION['tventa']) ? $_SESSION['tventa'] : '';
$cotizacion   = isset($_SESSION['cotizacion']) ? $_SESSION['cotizacion'] : '';
$search       = isset($_SESSION['search']) ? $_SESSION['search'] : '';
$sum33	      = "";
$st			  = "";
$codigo_busk  = "";
$z			  = "";
$add		  = "";
$typpe		  = "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">

	<title>Documento sin t&iacute;tulo</title>
	<link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
	<link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
	<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../../funciones/ajax.js"></script>
	<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
	<?php
	require_once('../../../conexion.php');
	require_once('../../../titulo_sist.php');
	require_once('../../../funciones/highlight.php');
	require_once('calcula_monto_temp.php');
	require_once('funciones_temp/ventas_index1.php');
	require_once('funciones_temp/ventas_index2.php');
	require_once('../funciones/functions.php');
	require_once('../../../funciones/botones.php');
	require_once('funciones_temp/datos_generales.php');

	$val  = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
	$tipo =	isset($_REQUEST['tipo']) ? ($_REQUEST['tipo']) : "";

	$sql = "SELECT limite FROM datagen_det";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$limite_busk = $row['limite'];
		}
	}
	if ($resolucion == 1) {
		$charact = 40;
		$charactbonif = 10;
	} else {
		$charact = 40;
		$charactbonif = 14;
	}

	$sql1 = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$localp    = $row1['codloc'];
		}
	}
	$nommedico      = "";
	$codcolegiatura = "";

	/*$sql="SELECT nommedico,codcolegiatura FROM venta inner join medico on codmedico = codmed where invnum=$venta";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nommedico    = $row['nommedico'];
	$codcolegiatura    = $row['codcolegiatura'];
}
}
else
{
    $nommedico = "No asignado";
    $codcolegiatura = "";
}*/

	$sql1 = "SELECT priceditable FROM datagen_det";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$priceditable    = $row1['priceditable'];
		}
	}

	$sqlVenta    = "SELECT sucursal FROM venta2 where invnum = '$tventa'";
	$resultVenta = mysqli_query($conexion, $sqlVenta);
	if (mysqli_num_rows($resultVenta)) {
		while ($rowVenta = mysqli_fetch_array($resultVenta)) {
			$sucursal    = $rowVenta['sucursal'];
		}
	}

	//**CONFIGPRECIOS_PRODUCTO**//
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

	if (($val == 1) and ($tipo == 2)) {
		$campo          = "codpro";
		$operador_sql   = "=";
		$limite_sql     = "";
		if ($limite_busk > 0) {
			if ($search == "") {
				$producto =	$_REQUEST['country_ID'];
				$sql = "SELECT codpro FROM producto where codpro = '$producto' and activo = '1'";
			} else {
				$producto = $_REQUEST['codigo_busk'];
				switch ($search) {
					case 2:
						$campo = "codfam";
						break;
					case 3:
						$campo = "coduso";
						break;
					case 4:
						$campo = "codmar";
						break;
					case 6:
						$campo = "codpres";
						break;
				}
			}
		} else {
			//$acc =	$_REQUEST['acc'];
			$CampoAdic  = "";
			$acc = isset($_REQUEST['acc']) ? ($_REQUEST['acc']) : "";
			if ($acc == 1) {
				$producto       = $_REQUEST['country_ID'];
				$sql = "SELECT codpro FROM producto where codpro = '$producto' and activo = '1'";
			} else {
				$producto       = $_REQUEST['country'] . "%";
				$campo          = "desprod";
				$operador_sql   = "like";
				$CampoAdic      = "%";
				$limite_sql     = "limit 15";
			}
		}

		$add = 0;
		$sql = "SELECT codpro FROM producto where " . $campo . " " . $operador_sql . " '$producto' and activo = '1' " . $limite_sql;
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			$add = 3;
		}
	} else {
		$add  = isset($_REQUEST['add']) ? ($_REQUEST['add']) : "";
	}

	?>
	<!--<script type="text/javascript" src="funciones/js/jquery.js"></script>-->
	<script language="javascript" type="text/javascript">
		function Submit_seguro(formulario) {
			for (i = 1; i < formulario.elements.length; i++) {
				if (formulario.elements[i].type == 'submit') {
					formulario.elements[i].disabled = true
				}
			}
			formulario.submit()
			Submit_seguro = Submit_off
			return false
		}

		function Submit_off(formulario) {
			return false
		}

		var popUpWin = 0;

		function popUpWindow(URLStr, left, top, width, height) {
			if (popUpWin) {
				if (!popUpWin.closed) popUpWin.close();
			}
			popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
		}

		function incentiv() {
			////boton///
			var left = 90;
			var top = 120;
			var width = 895;
			var height = 420;
			if (popUpWin) {
				if (!popUpWin.closed) popUpWin.close();
			}
			popUpWin = open('venta_index_t2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
		}
	</script>
	<script language="javascript" src="funciones/jquery.js"></script>
	<script language="javascript">
		$(document).ready(function() {

			$('form').keypress(function(e) {
				if (e == 13) {
					return false;
				}
			});

			$('input').keypress(function(e) {
				if (e.which == 13) {
					return false;
				}
			});

		});
		var nav4 = window.Event ? true : false;

		function enteres(evt) {
			var f = document.form1;
			var key = nav4 ? evt.which : evt.keyCode;
			if (key == 13) {
				var cod = document.form1.country_ID.value;
				window.location.href = "venta_index_t2.php?cod=" + cod + "&add=1&typpe=1";
			} else {
				return false;
			}
		}

		function enteres1(evt) {
			var f = document.form1;
			var key = nav4 ? evt.which : evt.keyCode;
			if (key == 13) {
				if (f.country.value !== '') {
					document.form1.submit();
				} else {
					alert("Ingrese una descripci�0�1�0�6n");
					return false;
				}
			} else {
				return false;
			}
		}
	</script>
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

		.Estilo1 {
			color: #006699;
			font-weight: bold;
		}

		.Estilo2 {
			color: #0066CC;
			font-weight: bold;
		}

		.Estilo3 {
			color: #003300
		}
	</style>
</head>

<body onkeyup="abrir_index2(event)" onload="<?php if (($add == 1) || ($add == 2)) { ?>st();<?php } else {
																							if ($add == 3) { ?>getfocus()<?php } else { ?>sf();<?php }
																																				} ?>">
	<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
		<table width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>920<?php } ?>" height="30" border="0" align="<?php if ($resolucion == 1) { ?>left<?php } else { ?>center<?php } ?>" class="tabla2">
			<tr>
				<td width="<?php if ($resolucion == 1) { ?>20<?php } else { ?>188<?php } ?>">
					<?php
					if (strlen($ruc_cliente) > 0) {
						echo "<h2 style='color: #2a4f8c;'>FACTURA</h2>";
					}
					?>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>690<?php } else { ?>746<?php } ?>" valign="middle">
					<div align="right">
						<input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()" disabled="disabled" />
						<input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled" />
						<input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" />
						<input name="documento" type="hidden" id="documento" value="<?php echo $nrovent ?>" />
						<input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
						<input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
						<input name="CodClaveVendedor" type="hidden" id="CodClaveVendedor" value="" />
						<input name="save" type="hidden" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?> />
						<input name="ext" type="button" id="ext" value="Buscar" onclick="buscar()" class="buscar" />
						<input name="ext3" type="button" id="ext3" value="Cancelar" onclick="cancelar()" class="cancelar" />
						<input name="ext2" type="button" id="ext2" value="Salir" onclick="salir1()" class="salir" />
					</div>
				</td>
			</tr>
		</table>

		<b>
			<font color="#FF0000"><u>F2 = LISTADO DE CLIENTES</u></font> - <font color="#00CC00"><u>F5 - TIPO DE BUSQUEDA</u></font>
		</b> - <span class="Estilo3"><u><strong>
					<font color="#CC6600">F6 = TIPO DE PAGO</font>
				</strong></u></span> - <span class="Estilo2"><u>F11 = LISTADO DE PRODUCTOS INCENTIVADOS</u></span> <br />
		<u><b>Tipo de Busqueda: <?php echo $st; ?></b></u>
		<table width="<?php if ($resolucion == 1) { ?>705<?php } else { ?>908<?php } ?>" border="0">
			<tr>
				<td width="59" valign="bottom"> PRODUCTO </td>
				<td width="755">
					<?php
					if ($limite_busk > 0) {
					?>
						<input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" value="" size="<?php if ($resolucion == 1) { ?>50<?php } else { ?>65<?php } ?>" class="busk" onkeypress="enteres(event)" />
						<input type="hidden" id="country_hidden" name="country_ID" />
					<?php
					} else {
					?>
						<input name="country" type="text" id="country" size="65" class="busk" onkeypress="enteres1(event)" />
					<?php
					}
					?>
					<input type="button" name="Submit" value="Incentivos (F11)" onclick="incentiv();" /></td>
				<td width="159">
					<div align="right">
						<input name="tt" type="hidden" id="tt" value="" />
						<input name="vt" type="hidden" id="vt" value="" />
						<input name="tipo" type="hidden" id="tipo" value="2" />
						<input name="val" type="hidden" id="val" value="1" />
						<input name="activado" type="hidden" id="activado" value="<?php echo $count ?>" />
						<input name="activado1" type="hidden" id="activado1" value="<?php echo $count1 ?>" />
					</div>
					<div align="right"><span class="blues"><b>CLIENTE:</b> <?php echo $nombre_cliente ?></span></div>
				</td>
			</tr>
			<?php
			if (strlen($nommedico) > 0) {
			?>
				<tr>
					<td colspan="3">
						<div align="right"><span class="blues"><b>MEDICO:</b> <?php echo $nommedico ?> <b>COLEGIATURA:</b><?php echo $codcolegiatura; ?></span></div>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
		<br />
		<?php
		$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
		if ($val == 1) {
			if ($tipo == 2) {
				$add 		= 0;
				$cod		= 0;
				$i		= 1;

				$campo          = "codpro";
				if ($limite_busk > 0) {
					if ($search == '') {
						$producto = $_REQUEST['country_ID'];
					} else {
						$producto = $_REQUEST['codigo_busk'];

						switch ($search) {
							case 2:
								$campo = "codfam";
								break;
							case 3:
								$campo = "coduso";
								break;
							case 4:
								$campo = "codmar";
								break;
							case 6:
								$campo = "codpres";
								break;
						}
					}
					$sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where " . $campo . " = '$producto' and activo = '1' order by $tabla desc";
				} else {
					$acc 		= isset($_REQUEST['acc']) ? ($_REQUEST['acc']) : "";
					$productop 	= isset($_REQUEST['codigo_busk']) ? ($_REQUEST['codigo_busk']) : "";
					if ($productop <> "") {
						switch ($search) {
							case 2:
								$campo = "codfam";
								break;
							case 3:
								$campo = "coduso";
								break;
							case 4:
								$campo = "codmar";
								break;
							case 6:
								$campo = "codpres";
								break;
						}
						$sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where " . $campo . " = '$productop' and activo = '1' order by $tabla desc ,desprod desc";
					} else {
						if ($acc == 1) {
							$producto =	$_REQUEST['country_ID'];
							$sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where codpro = '$producto' and activo = '1' order by $tabla desc,desprod desc";
						} else {
							$producto 	= $_REQUEST['country'];
							$sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ((desprod LIKE '$producto%') or (codbar = '$producto') or (codpro = '$producto%'))  and activo = '1' order by $tabla desc,desprod desc";
						}
					}
				}
				//echo $sql;exit;
				$result = mysqli_query($conexion, $sql);
				if (mysqli_num_rows($result)) {
		?>
					<table class="celda2" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>934<?php } ?>">
						<tr>
							<td width="<?php if ($resolucion == 1) { ?>30<?php } else { ?>31<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</td>
							<td width="<?php if ($resolucion == 1) { ?>378<?php } else { ?>466<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
							<td width="<?php if ($resolucion == 1) { ?>39<?php } else { ?>80<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
								<div align="center">MARCA</div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>53<?php } else { ?>73<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
								<div align="right"><?php if ($resolucion == 1) { ?>P. Caja<?php } else { ?>PRECIO Caja<?php } ?></div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>74<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
								<div align="right"><?php if ($resolucion == 1) { ?>P. Unid<?php } else { ?>PRECIO Unid<?php } ?></div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>74<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
								<div align="right"><?php if ($resolucion == 1) { ?>P. Blis<?php } else { ?>P. Blister<?php } ?></div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>39<?php } else { ?>65<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
								<div align="right"><?php if ($resolucion == 1) { ?>S. Und<?php } else { ?>STOCK U.<?php } ?> </div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>48<?php } else { ?>41<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</td>
						</tr>
					</table>
					<table class="celda2" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>934<?php } ?>">
						<?php
						while ($row = mysqli_fetch_array($result)) {
							$codpro         = $row['codpro'];
							$desprod        = $row['desprod'];
							$codmar         = $row['codmar'];
							$pblister     	= $row['blister'];
							$preblister     = $row['preblister'];
							$referencial  	= $row['prelis'];
							$factor     	= $row['factor'];
							$incentivado    = $row['incentivado'];
							$pcostouni      = $row['pcostouni'];
							$margene     	= $row['margene'];
							$cant_loc       = $row[10];
							$prevtaMain     = $row['PrevtaMain'];
							$preuniMain     = $row['PreuniMain'];
							$prevta         = $row[13];
							$preuni         = $row[14];

							//**CONFIGPRECIOS_PRODUCTO**//
							if (($prevta == "") || ($prevta == 0)) {
								$prevta = $prevtaMain;
							}
							if (($preuni  == "") || ($preuni  == 0)) {
								$preuni  = $preuniMain;
							}

							//**FIN_CONFIGPRECIOS_PRODUCTO**//

							if (($referencial > 0) and ($referencial <> $prevta)) {
								$margenes       = ($margene / 100) + 1;
								$precio_ref     = $referencial;
								//$precio_ref     = $referencial/$factor;
								//$precio_ref     = $referencial* $factor;
								$precio_ref	= $precio_ref * $margenes;
								$desc1	        = $precio_ref - $preuni;
								if ($desc1 < 0) {
									$descuento = 0;
								} else {
									if (!(($precio_ref < 1) and ($precio_ref > 0))) {
										$precio_ref		= number_format($precio_ref, 2, '.', ',');
									}
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
							$sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$marca     = $row1['destab'];
									$marca1    = $row1['abrev'];
								}
							}
							//echo $marca1;
							$sql1 = "SELECT sum(codpro) FROM incentivadodet where codpro = '$codpro' and estado = '1' and ((codloc = '$codloc') or (codloc = '$localp'))";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$sumcodes    = $row1[0];
								}
							} else {
								$sumcodes    = 0;
							}
							if ($sumcodes <> 0) {
								$incentivado = 1;
							} else {
								$incentivado = 0;
							}
							$sql1 = "SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$desprod_bonif  	= $row1['desprod'];
								}
								$bonifi = 1;
							} else {
								$bonifi = 0;
							}
							//$sql1="SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$tventa'";
							$sql1 = "SELECT codpro FROM detalle_venta2 where codpro = '$codpro' and invnum = '$tventa'";
							$result1 = mysqli_query($conexion, $sql1);
							if (mysqli_num_rows($result1)) {
								//$control = 1;
								$control = 0;
							} else {
								$control = 0;
							}
							if (($incentivado == 1) and ($cant_loc > 0)) {
								$color = 'prodincent';
								$text  = 'text_prodincent';
							} else {
								if ($cant_loc > 0) {
									$color = 'prodnormal';
									$text  = 'text_prodnormal';
								} else {
									$color = 'prodstock';
									$text  = 'text_prodstock';
								}
							}
							if ($factor == 0) {
								$factor = 1;
							}
							++$z;
							$convert1       = $cant_loc / $factor;
							$div1    	= floor($convert1);
							$mult1		= $factor * $div1;
							$tot1		= $cant_loc - $mult1;
							if ($preuni > 0) {
							} else {
								if ($factor <> 0) {
									$preuni = $prevta / $factor;
								}
							}
							$preuni = number_format($preuni, 3, '.', ' ');
						?>
							<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
								<td width="<?php if ($resolucion == 1) { ?>30<?php } else { ?>28<?php } ?>"><b><span class="<?php echo $text ?>"><?php echo $i ?>-</span></b></td>
								<td width="<?php if ($resolucion == 1) { ?>378<?php } else { ?>466<?php } ?>">
									<?php
									if ($control == 0) { ?>
										<a id="l<?php echo $z ?>" href="venta_index_t2.php?cod=<?php echo $codpro ?>&add=1&typpe=1" class="<?php echo $color ?>"><b><?php if ($bonifi == 1) {
																																										echo substr($desprod, 0, $charact);
																																										echo " ";
																																										echo " + (B) x CAJA ";
																																										echo substr($desprod_bonif, 0, $charactbonif);
																																									} else {
																																										echo substr($desprod, 0, $charact);
																																										echo " ";
																																									} ?></b></a>
									<?php
									} else {
									?>
										<span class="<?php echo $text ?>">
											<font><b><?php if ($bonifi == 1) {
															echo substr($desprod, 0, $charact);
															echo " ";
															echo " + (B) x CAJA ";
															echo substr($desprod_bonif, 0, $charactbonif);
														} else {
															echo substr($desprod, 0, $charact);
															echo " ";
														} ?></b></font>
										</span><?php } ?></td>
								<td width="<?php if ($resolucion == 1) { ?>39<?php } else { ?>80<?php } ?>">
									<div class="<?php echo $text ?>"><b><?php if ($marca1 == "") {
																			echo substr($marca, 0, 15);
																			echo " ";
																		} else {
																			echo substr($marca1, 0, 15);
																			echo " ";
																		} ?></b></div>
								</td>
								<td width="<?php if ($resolucion == 1) { ?>53<?php } else { ?>73<?php } ?>">
									<div align="right" class="<?php echo $text ?>"><b><?php echo $prevta ?></b></div>
								</td>
								<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>72<?php } ?>">
									<div align="right" class="<?php echo $text ?>"><b><?php echo $preuni ?></b></div>
								</td>
								<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>72<?php } ?>">
									<div align="right" class="<?php echo $text ?>"><b><?php echo $preblister ?></b></div>
								</td>
								<td width="<?php if ($resolucion == 1) { ?>39<?php } else { ?>65<?php } ?>">
									<div align="right" class="<?php echo $text ?>"><b><?php echo $div1 ?> F <?php echo $tot1 ?></b></div>
								</td>
								<td width="<?php if ($resolucion == 1) { ?>48<?php } else { ?>44<?php } ?>">
									<div align="center">
										<a href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro ?>', 2, 50, 1100, 350)">
											<input name="codigo_producto" type="hidden" id="codigo_producto" value="<?php echo $codpro ?>" />
											<img src="../../../images/lens.gif" width="14" height="15" border="0" /></a>
									</div>
								</td>
							</tr>
						<?php
							++$i;
						}
						?>
					</table>
				<?php
				} else {
				?>
					<center><u><br><br>
							<span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
					</center>
		<?php
				}
			}
		}
		?>
		<?php
		$add    = isset($_REQUEST['add']) ? ($_REQUEST['add']) : "";
		$typpe  = isset($_REQUEST['typpe']) ? ($_REQUEST['typpe']) : "";
		$i = 1;
		if ($typpe == 1) {
			//echo "holaaaa";exit;
			$val = 0;
			$cod = $_REQUEST['cod'];
			$sql = "SELECT codpro,desprod,codmar,factor,costpr,stopro,pcostouni,margene,codfam,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni "
				. "FROM producto where codpro = '$cod' and activo = '1' order by desprod";
			$result = mysqli_query($conexion, $sql);
			if (mysqli_num_rows($result)) {
		?>
				<span class="Estilo1"><u>F4 = LINEA DE PRODUCTOS</u></span>
				<table class="celda2" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>934<?php } ?>">
					<tr>
						<td width="<?php if ($resolucion == 1) { ?>15<?php } else { ?>27<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</td>
						<td width="<?php if ($resolucion == 1) { ?>384<?php } else { ?>446<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
						<td width="<?php if ($resolucion == 1) { ?>42<?php } else { ?>73<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="right">
								<?php if ($resolucion == 1) { ?>
									S. UN
								<?php } else { ?>
									STOCK UNID
								<?php } ?>
							</div>
						</td>
						<td width="<?php if ($resolucion == 1) { ?>67<?php } else { ?>93<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="right">
								<?php if ($resolucion == 1) { ?>
									P. CAJA
								<?php } else { ?>
									PRECIO Caja
								<?php } ?>
							</div>
						</td>
						<td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>90<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="right">
								<?php if ($resolucion == 1) { ?>
									P. UN
								<?php } else { ?>
									PRECIO Unid
								<?php } ?>
							</div>
						</td>
						<td width="<?php if ($resolucion == 1) { ?>62<?php } else { ?>91<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="right">
								<?php if ($resolucion == 1) { ?>
									CANT
								<?php } else { ?>
									CANTIDAD
								<?php } ?>
							</div>
						</td>
						<td width="<?php if ($resolucion == 1) { ?>66<?php } else { ?>82<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">
							<div align="right">
								<?php if ($resolucion == 1) { ?>
									TOT
								<?php } else { ?>
									TOTAL
								<?php } ?>
							</div>
						</td>
					</tr>
				</table>
				<table class="celda2" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>934<?php } ?>">
					<?php
					while ($row = mysqli_fetch_array($result)) {
						$codpro         = $row['codpro'];
						$desprod        = $row['desprod'];
						$codmar         = $row['codmar'];
						$factor     	= $row['factor'];
						$costpr     	= $row['costpr'];
						$stopro     	= $row['stopro'];
						$pcostouni  	= $row['pcostouni'];
						$margene     	= $row['margene'];
						$codfam     	= $row['codfam'];
						$pblister     	= $row['blister'];
						$preblister     = $row['preblister'];
						$cant_loc_add	= $row[11];
						$prevtaMain     = $row['PrevtaMain'];
						$preuniMain     = $row['PreuniMain'];
						$prevta         = $row[14];
						$preuni         = $row[15];

						//**CONFIGPRECIOS_PRODUCTO**//
						if (($prevta == "") || ($prevta == 0)) {
							$prevta = $prevtaMain;
						}
						if (($preuni  == "") || ($preuni  == 0)) {
							$preuni  = $preuniMain;
						}

						//**FIN_CONFIGPRECIOS_PRODUCTO**//

						if (strlen($pblister) == 0) {
							$pblister = 0;
						}
						if (strlen($preblister) == 0) {
							$preblister = 0;
						}

						$sql1 = "SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$desprod_bonif  	= $row1['desprod'];
							}
							$bonif = 1;
						} else {
							$bonif = 0;
						}
						//$sql1="SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$tventa'";
						$sql1 = "SELECT codpro FROM detalle_venta2 where codpro = '$codpro' and invnum = '$tventa'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							//$control = 1;
							$control = 0;
						} else {
							$control = 0;
						}
						$convert    = $cant_loc_add / $factor;
						$div    	= floor($convert);
						$mult		= $factor * $div;
						$tot		= $cant_loc_add - $mult;
						if ($preuni > 0) {
						} else {
							if ($factor <> 0) {
								$preuni = $prevta / $factor;
							}
						}
						$preuni = number_format($preuni, 3, '.', ' ');
					?>
						<tr bgcolor="#FFFF99">
							<td width="<?php if ($resolucion == 1) { ?>15<?php } else { ?>27<?php } ?>">
								<font color="#006699" size="4"><?php echo $i ?></font>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>438<?php } else { ?>447<?php } ?>">
								<font color="#006699" size="3"><?php if ($bonif == 1) {
																	echo substr($desprod, 0, $charact);
																	echo " ";
																	echo " + (B) x CAJA ";
																	echo substr($desprod_bonif, 0, $charactbonif);
																} else {
																	echo substr($desprod, 0, $charact);
																	echo "...";
																} ?></font>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>50<?php } else { ?>72<?php } ?>">
								<div align="right"><b>
										<font color="<?php if ($cant_loc_add == 0) { ?>#FF0000<?php } else { ?>#006699<?php } ?>" size="4"><?php echo $div ?> F <?php echo $tot ?></font>
									</b></div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>92<?php } ?>">
								<b>
									<font color="#006699" size="4">
										<div align="right"><?php echo $prevta; ?></div>
									</font>
								</b>
							</td>
							<!--AQUI SE INGRESA EL PRECIO-->
							<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>90<?php } ?>">
								<label>
									<div align="right">
										<?php
										if ($control == 0) { ?>
											<input name="text2" type="hidden" id="text2" value="<?php echo $preuni ?>" />
											<input name="textprevta" type="hidden" id="textprevta" value="<?php echo $prevta ?>" />
											<input name="text222" type="text" class="cant" id="text222" value="<?php echo $preuni ?>" size="4" <?php if ($priceditable <> 1) { ?>disabled="disabled" onclick="blur()" <?php } ?> onkeyup="precio1();" onkeypress="return letraent(event);" />
										<?php
										} else {
										?>
											<font color="#006699" size="4"><?php echo '<b>';
																			echo $preuni;
																			echo '</b>'; ?></font>
										<?php
										}
										?>
									</div>
								</label>
							</td>
							<!--AQUI SE INGRESA LA CANTIDAD-->
							<td width="<?php if ($resolucion == 1) { ?>54<?php } else { ?>92<?php } ?>">
								<div align="right">
									<input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni ?>" />
									<input type="hidden" name="numero" id="numero" />
									<input type="hidden" name="codpro" id="codpro" value="<?php echo $codpro; ?>" />
									<input type="hidden" name="factor" id="factor" value="<?php echo $factor; ?>" />
									<input type="hidden" name="cant_prod" id="cant_prod" value="<?php echo $cant_loc_add; ?>" />
									<input name="pblister" type="hidden" id="pblister" value="<?php echo $pblister ?>" />
									<input name="preblister" type="hidden" id="preblister" value="<?php echo $preblister ?>" />
									<?php
									if ($control == 0) { ?>
										<input name="text1" type="text" class="cant" id="text1" onkeypress="return letracc(event);" onkeyup="precio();" size="4" />
									<?php
									}
									?>
								</div>
							</td>
							<td width="<?php if ($resolucion == 1) { ?>50<?php } else { ?>82<?php } ?>" bgcolor="#FFFF99">
								<div align="right">
									<?php
									if ($control == 0) { ?>
										<input name="text333" type="text" class="cant1" id="text333" onclick="blur()" size="4" disabled="disabled" />
										<input type="hidden" name="text3" id="text3" value="" />
									<?php
									} ?>
								</div>
							</td>
						</tr>
					<?php ++$i;
					}
					?>
				</table>
			<?php
			} else {
			?>
				<center><u><br><br>
						<span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PODUCTO CON LA DESCRIPCION INGRESADA</span></u>
				</center>
		<?php
			}
		}
		?>
		<iframe src="venta_index_t3.php" name="index2" width="<?php if ($resolucion == 1) { ?>710<?php } else { ?>935<?php } ?>" height="260" scrolling="Automatic" frameborder="0" id="index2" allowtransparency="0">
		</iframe>
		<div align="<?php if ($resolucion == 1) { ?>left<?php } else { ?>center<?php } ?>">
			<img src="../../../images/line2.png" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>907<?php } ?>" height="4" />
		</div>
		<table width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>892<?php } ?>" border="0" align="<?php if ($resolucion == 1) { ?>left<?php } else { ?>center<?php } ?>">
			<tr>
				<td width="<?php if ($resolucion == 1) { ?>90<?php } else { ?>100<?php } ?>">
					<div align="right">MONTO BRUTO </div>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>120<?php } ?>"><input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="<?php if ($resolucion == 1) { ?>8<?php } else { ?>15<?php } ?>" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($mont_bruto, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
				</td>
				<td width="39">
					<div align="right">DCTO</div>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>124<?php } ?>"><input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="<?php if ($resolucion == 1) { ?>8<?php } else { ?>15<?php } ?>" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($total_des, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
				</td>
				<td width="<?php if ($resolucion == 1) { ?>70<?php } else { ?>87<?php } ?>">
					<div align="right">V. VENTA </div>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>134<?php } ?>"><input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="<?php if ($resolucion == 1) { ?>8<?php } else { ?>15<?php } ?>" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($valor_vent1, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" /></td>
				<td width="<?php if ($resolucion == 1) { ?>70<?php } else { ?>53<?php } ?>">
					<div align="right">IGV</div>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>115<?php } ?>"><input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="<?php if ($resolucion == 1) { ?>8<?php } else { ?>15<?php } ?>" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($sum_igv, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" /></td>
				<td width="39">
					<div align="left">NETO</div>
				</td>
				<td width="<?php if ($resolucion == 1) { ?>87<?php } else { ?>134<?php } ?>">
					<div align="right">
						<input name="mont5" class="monto_tot" type="text" id="mont5" onclick="blur()" size="<?php if ($resolucion == 1) { ?>8<?php } else { ?>8<?php } ?>" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
					</div>
				</td>
			</tr>
		</table>
		<div align="<?php if ($resolucion == 1) { ?>left<?php } else { ?>center<?php } ?>">
			<img src="../../../images/line2.png" width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>907<?php } ?>" height="4" />
		</div>
		<br />
	</form>
	<?php

	/*mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); */
	?>
</body>

</html>