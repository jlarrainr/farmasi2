<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');
require_once('../../../titulo_sist.php');
$ct = 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $desemp ?></title>
	<link href="../css2/css/style1.css" rel="stylesheet" type="text/css" />
	<link href="../css2/css/tablas.css" rel="stylesheet" type="text/css" />
	<style>
		.siniformacion {
			font-family: Tahoma;
			font-size: 20px;
			line-height: normal;
			color: #e65a3d;
			padding: 20px;
			font-weight: bold;
			/*margin-top:  20px;*/
		}

		#boton {
			background: url('../../../images/save_16.png') no-repeat;
			border: none;
			width: 16px;
			height: 16px;
		}

		#boton1 {
			background: url('../../../images/x2.png') no-repeat;
			border: none;
			width: 26px;
			height: 26px;
		}

		a:link,
		a:visited {
			color: #0066CC;
			border: 0px solid #e7e7e7;
			text-decoration: none;
		}

		a:hover {
			background: #fff;
			border: 0px solid #ccc;
			font-size: 15px;
			color: #ec5e5c;
			background-color: #FFFF66;
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

		/* para las tablas */
		/* #customers a {
			text-decoration: none;

		}

		#customers a:hover {
			text-decoration: solid;
			font-size: 15px;

		} */

		#customers {
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#customers th {
			border: 1px solid #ddd;
			padding: 1px;

		}

		#customers td {
			border: 1px solid #ddd;
			padding: 5px;
			font-size: 12px;
		}

		#customers tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#customers tr:hover {
			background-color: #FFFF66;
		}

		#customers th {
			padding: 2px;
			text-align: left;
			background-color: #2e91d2;
			color: white;
			font-size: 15px;
		}
	</style>
	<?php $cr = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
	?>
	<script>
		function validar_grid() {
			var f = document.form1;
			f.method = "POST";
			f.action = "digemid2.php";
			f.submit();
		}

		function validar_prodd() {
			/*var f = document.form1;
		       if ((f.p1.value == "") || (f.p1.value == 0))
                {
                    alert("Ingrese codigo de la DIGEMID ");
                    f.p1.focus();
                    return;
                }
                if ((f.cod_generico.value == "") || (f.cod_generico.value == 0))
                {
                    alert("Ingrese codigo generico ");
                    f.cod_generico.focus();
                    return;
                }*/
			mensaje = confirm("Desea grabar estos datos?");

			if (mensaje) {

				var f = document.form1;
				f.method = "post";
				f.action = "grabar_datos.php";
				f.submit();
			}
		}

		function sf() {
			document.form1.p1.focus();
		}
		var nav4 = window.Event ? true : false;

		function ent(evt) {
			var key = nav4 ? evt.which : evt.keyCode;
			if (key == 13) {

				/*	 var f = document.form1;
		       if ((f.p1.value == "") || (f.p1.value == 0))
                {
                    alert("Ingrese codigo de la DIGEMID ");
                    f.p1.focus();
                    return;
                }
                if ((f.cod_generico.value == "") || (f.cod_generico.value == 0))
                {
                    alert("Ingrese codigo generico ");
                    f.cod_generico.focus();
                    return;
                }*/
				mensaje = confirm("Desea grabar estos datos?");

				if (mensaje) {

					var f = document.form1;
					f.method = "post";
					f.action = "grabar_datos.php";
					f.submit();
				}
			} else {
				return (key <= 13 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57));
			}
		}
	</script>
</head>
<?php


require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");	//LOCAL DEL USUARIO
require_once("../../local.php");	//LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";

$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$user    = $row['nomusu'];
		$sucursal    = $row['codloc'];
	}
}
function formato($c)
{
	printf("%08d", $c);
}
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
$ckdigemid = isset($_REQUEST['ckdigemid']) ? ($_REQUEST['ckdigemid']) : "";


if ($valform == 1) {
	$colspan = '2';
	$accion = 'GRABAR / CANCELAR';
} else {
	$colspan = '1';
	$accion = 'MODIFICAR';
}


//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
	while ($rowLocal = mysqli_fetch_array($resultLocal)) {
		$nomlocalG = $rowLocal['nomloc'];
	}
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

?>

<body <?php if ($valform == 1) { ?>onload="sf();" <?php } else { ?> onload="getfocus();" <?php } ?> id="body">
	<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
		<table width="100%" border="0" class="tabla2">
			<tr>
				<td width="951">
					<table width="100%" border="0" align="center">
						<tr>

							<td width="75%">
								<div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
							</td>
							<td width="25%">
								<div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
							</td>
						</tr>
					</table>
					<img src="../../../images/line2.png" width="100%" height="4" />

					<?php if ($val <> "") {


						if ($val == 1) {
							if ($ckdigemid == 1) {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where desprod like '%$search%'   and covid = '1'  and eliminado='0' order by desprod ";
							} else {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where desprod like '%$search%' and eliminado='0'  order by desprod ";
							}

							//	echo '$val1';
						}


						if ($val == 2) {
							if ($ckdigemid == 1) {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where codmar = '$search' and covid = '1'  and eliminado='0'  order by desprod ";
							} else {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where codmar = '$search'  and eliminado='0'  order by desprod ";
							}
							//	echo '$val2';
						}

						if ($val == 3) {
							if ($ckdigemid == 1) {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where covid = '1' and eliminado='0'   order by codmar ";
							} else {
								$sql = "SELECT codpro,desprod,digemid,stopro,codmar,$tabla,factor,cod_generico,covid,registrosanitario FROM producto where eliminado='0'  order by codmar ";
							}
							//	echo '$val3 = '. '$ckdigemid = '.$ckdigemid;
						}

						$result = mysqli_query($conexion, $sql);
						if (mysqli_num_rows($result)) {
					?>
							<table width="100%" border="1" align="center" id="customers">
								<tr>
									<th width="3%"><strong>N</strong></th>
									<th width="5%">
										<div align="center"><strong>CODIGO</strong></div>
									</th>
									<th width="30%"><strong>PRODUCTO</strong></th>
									<th width="5%">
										<div align="center"><strong>FACTOR</strong></div>
									</th>
									<th width="15%">
										<div align="center"><strong>MARCA</strong></div>
									</th>
									<th width="10%"><strong>STOCK UNID</strong></th>
									<th width="2%" align="center"> <strong>ACTIVO PARA COVID</strong> </th>

									<th width="7%">
										<div align="center"><strong>DIGEMID </strong></div>
									</th>
									<th width="7%">
										<div align="center"><strong>COD. GENERICO </strong></div>
									</th>
									<th width="7%">
										<div align="center"><strong>REG. SANITARIO </strong></div>
									</th>
									<th colspan=" <?php echo $colspan; ?>">
										<div align="center"><strong><?php echo $accion; ?></strong></div>
									</th>
								</tr>

								<?php $cr = 1;
								$cont = 1;
								while ($row = mysqli_fetch_array($result)) {
									$i++;
									$codpro         = $row['codpro'];
									$desprod        = $row['desprod'];
									$digemid         = $row['digemid'];
									$codmar         = $row['codmar'];
									$stopro         = $row[5];
									$factor         = $row['factor'];
									$cod_generico         = $row['cod_generico'];
									$covid         = $row['covid'];
									$registrosanitario         = $row['registrosanitario'];

									$tex_covid = ($covid == 1) ? '<b>SI</b>' : '<b>NO</b>';

									$sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$destab    = $row1['destab'];
										}
									}
									if ($ct == 1) {
										$color = "#99CCFF";
									} else {
										$color = "#FFFFFF";
									}
									$t = $cont % 2;
									if ($t == 1) {
										$color = "#D2E0EC";
									} else {
										$color = "#ffffff";
									}
									$cont++;
								?>
									<tr>
										<th>
											<?php echo $i; ?>
										</th>
										<td align="center">
											<?php echo $codpro; ?>
										</td>
										<td>
											<a tabindex="1" id="l<?php echo $cr; ?>" href="digemid2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>&ckdigemid=<?php echo $ckdigemid ?>"><?php echo $desprod ?></a>
										</td>



										<td>
											<div align="center"><?php echo $factor ?></div>
										</td>

										<td>
											<div align="center"><?php echo $destab ?></div>
										</td>


										<td>
											<div align="center"><?php echo stockcaja($stopro, $factor); ?></div>
										</td>


										<td>
											<div align="center">
												<?php if (($valform == 1) and ($codpros == $codpro)) {
												?>

													<input name="covid" type="checkbox" id="covid" value="1" <?php if ($covid == 1) { ?>checked="checked" <?php } ?> />
												<?php } else {
													echo $tex_covid;
												}
												?>
											</div>
										</td>
										<td>
											<div align="center">
												<?php if (($valform == 1) and ($codpros == $codpro)) {
												?>

													<input name="p1" type="text" id="p1" size="8" value="<?php echo $digemid ?>" onkeypress="return ent(event);" onkeypress="return decimal(event);" />
												<?php } else {
													echo $digemid;
												}
												?>
											</div>
										</td>
										<td>
											<div align="center">
												<?php if (($valform == 1) and ($codpros == $codpro)) {
												?>

													<input name="cod_generico" type="text" id="cod_generico" size="8" value="<?php echo $cod_generico ?>" onkeypress="return ent(event);" onkeypress="return decimal(event);" />
												<?php } else {
													echo $cod_generico;
												}
												?>
											</div>
										</td>

										<td>
											<div align="center">
												<?php if (($valform == 1) and ($codpros == $codpro)) {
												?>

													<input name="registrosanitario" type="text" id="registrosanitario" size="8" value="<?php echo $registrosanitario ?>"  />
												<?php } else {
													echo $registrosanitario;
												}
												?>
											</div>
										</td>


										<?php if (($valform == 1) and ($codpros == $codpro)) { ?>
											<td>
												<div align="center">

													<input name="val" type="hidden" id="val" value="<?php echo $val ?>" />

													<input name="ckdigemid" type="hidden" id="ckdigemid" value="<?php echo $ckdigemid ?>" />
													<input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
													<input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
													<input name="button" type="button" id="boton" onclick="validar_prodd()" alt="GUARDAR" />
													<!-- <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" /> -->
												</div>
											</td>
											<td>
												<div align="center">
													<input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
												</div>
											</td>
										<?php
										} else {
										?>
											<td colspan=" <?php echo $colspan; ?>">
												<div align="center">
													<a href="digemid2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>&ckdigemid=<?php echo $ckdigemid ?>">
														<img src="../../../images/add1.gif" width="14" height="15" border="0" /> </a>
												</div>
											</td>

										<?php }
										?>
									</tr>
								<?php }
								?>
							</table>
						<?php $cr++;
						} else {
						?>


							<div class="siniformacion">
								<center>
									No se logro encontrar informacion con los datos ingresados
								</center>
							</div>

					<?php
						}
					}
					?>
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>