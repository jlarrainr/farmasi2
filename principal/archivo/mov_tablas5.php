<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="css/body.css" rel="stylesheet" type="text/css" />
	<link href="css/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tables_consult.css" rel="stylesheet" type="text/css" />
	<link href="../../css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
	<title>Documento sin t&iacute;tulo</title>
	<?php require_once("../../conexion.php"); ?>
	<?php require_once("funciones/mov_tablas.php"); ?>
	<?php require_once("../../funciones/functions.php"); ?>
	<?php require_once("../../funciones/funct_principal.php"); ?>
	<?php require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
	?>
	<style type="text/css">
		/* <!--
		.Estilo1 {
			font-size: 11px
		}
		--> */
	</style>
</head>

<body onLoad="st();">
	<br>
	<?php $codtab	= $_REQUEST['cod'];
	$tipo			= $_REQUEST['tipo'];
	$sql = "SELECT tiptab,destab,abrev,campo FROM titultabladet where codtab = '$codtab'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$tiptab                 = $row["tiptab"];
			$destab                 = $row["destab"];
			$abrev                  = $row["abrev"];
			$descbrev               = $row["campo"];
		}
	}
	$sql = "SELECT cdgen,dsgen FROM titultabla where ltdgen = '$tiptab'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$cdgen                 = $row["cdgen"];
			$dsgen                 = $row["dsgen"];
		}
	}
	?>
	<form name="form1" id="form1">
		<table width="100%" align="center" class="demoTable">
			<caption>
				<span class="Estilo1">MODIFICAR - <?php echo $dsgen ?> </span>
			</caption>
			<thead>
				<tr>

					<th width="95">
						<div align="left">ABREVIATURA </div>
					</th>
					<?php if ($dsgen == "MARCA") { ?><th width="93">
							<div align="left">ABREV. MARCA </div>
						</th><?php } ?>
					<th width="366">
						<div align="left"> DESCRIPCION</div>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="<?php if ($dsgen == "MARCA") { ?>3<?php } else { ?>2<?php } ?>">
						<div align="center">

							<div align="right">
								<input name="codtab" type="hidden" id="codtab" value="<?php echo $codtab ?>" />
								<input name="btn" type="hidden" id="btn" value="2" />
								<input name="cod" type="hidden" id="cod" value="<?php echo $cdgen ?>" />
								<input name="tipo" type="hidden" id="tipo" value="<?php echo $tiptab ?>" />
								<input name="tipodes" type="hidden" id="tipodes" value="<?php echo $dsgen ?>" />
								<input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir" />
								<input type="button" name="back" value="Regresar" onClick="back_movtabla5()" class="regresar" />
								<input type="button" name="exit" value="Salir" onClick="salir1()" class="salir" />
							</div>

						</div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php if ($tipo == "TDOC") {
				?>
					<tr>
						<td>
							<b>
								<center>CAMPO</center>
							</b>
						</td>
						<td>
							<?php /*?><select name="tdoc">
			    <option value="nrovent" <?php if ($descbrev == 'nrovent'){?>selected="selected"<?php }?>>NRO VENTA</option>
			    <option value="hora" <?php if ($descbrev == 'hora'){?>selected="selected"<?php }?>>HORA DE VENTA</option>
				<option value="invfec" <?php if ($descbrev == 'invfec'){?>selected="selected"<?php }?>>FECHA</option>
				<option value="descli" <?php if ($descbrev == 'descli'){?>selected="selected"<?php }?>>NOMBRE CLIENTE</option>
				<option value="nomusu" <?php if ($descbrev == 'nomusu'){?>selected="selected"<?php }?>>ABRV USUARIO</option>
				<option value="forpag" <?php if ($descbrev == 'forpag'){?>selected="selected"<?php }?>>FORMA PAGO</option>
				<option value="cuscod" <?php if ($descbrev == 'cuscod'){?>selected="selected"<?php }?>>CODIGO CLIENTE</option>
			    <option value="dircli" <?php if ($descbrev == 'dircli'){?>selected="selected"<?php }?>>DIRECCION CLIENTE</option>
			    <option value="bruto" <?php if ($descbrev == 'bruto'){?>selected="selected"<?php }?>>VALOR BRUTO</option>
				<option value="valven" <?php if ($descbrev == 'valven'){?>selected="selected"<?php }?>>VALOR VTA</option>
				<option value="igv" <?php if ($descbrev == 'igv'){?>selected="selected"<?php }?>>VALOR DEL IGV</option>
				<option value="invtot" <?php if ($descbrev == 'invtot'){?>selected="selected"<?php }?>>NETO A PAGAR</option>
				<option value="montext" <?php if ($descbrev == 'montext'){?>selected="selected"<?php }?>>MONTO EN LETRAS</option>
				<option value="ruccli" <?php if ($descbrev == 'ruccli'){?>selected="selected"<?php }?>>RUC CLIENTE</option>
		      </select>
			  <?php */ ?>
							<input name="tdoc" type="text" id="tdoc" value="<?php echo $descbrev; ?>" />
						</td>
					</tr>
				<?php }
				?>
				<tr>
					<td><b>
							<center>"<?php echo $tiptab ?>"</center>
						</b></td>
					<?php if ($dsgen == "MARCA") { ?>
						<td>
							<center>
								<div align="left">
									<input name="abrev" type="text" id="abrev" onKeyUp="this.value = this.value.toUpperCase();" value="<?php if ($abrev == "") {
																																			echo $destab;
																																		} else {
																																			echo $abrev;
																																		} ?>" size="6" maxlength="5" />
								</div>
							</center>
						</td>
					<?php } ?>

					<td>
						<center>
							<div align="left">
								<input name="desc" type="text" id="desc" size="55" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $destab ?>" />
								<input type="button" name="Submit" value="Grabar" onclick="save_movtabla5()" class="grabar" />
							</div>
						</center>
					</td>
				</tr>

			</tbody>
		</table>
	</form>
</body>

</html>