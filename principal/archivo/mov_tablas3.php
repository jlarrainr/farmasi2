<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link href="css/body.css" rel="stylesheet" type="text/css" />
	<link href="css/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tables_consult.css" rel="stylesheet" type="text/css" />
	<link href="../../css/style.css" rel="stylesheet" type="text/css" />
	<title>Documento sin t&iacute;tulo</title>
	<?php require_once("../../conexion.php"); ?>
	<?php require_once("funciones/mov_tablas.php"); ?>
	<?php require_once("../../funciones/functions.php"); ?>
	<?php require_once("../../funciones/funct_principal.php"); ?>
	<?php require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
	?>
	<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>

	<!--<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>-->
                    <link href="../select2/css/select2.min.css" rel="stylesheet" />
                    <script src="../select2/jquery-3.4.1.js"></script>
                    <script src="../select2/js/select2.min.js"></script>

	<style type="text/css">
		/* <!--
.Estilo1 {font-size: 11px}
--> */
	</style>
</head>

<body onLoad="st();">
	<br>
	<?php $tipo	= $_POST['tipo'];
	$sql = "SELECT cdgen,dsgen,ltdgen FROM titultabla where ltdgen = '$tipo'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$cdgen                 = $row["cdgen"];
			$dsgen                 = $row["dsgen"];
			$ltdgen                = $row["ltdgen"];
		}
	}
	?>
	<form name="form1" id="form1">
		<table width="100%" align="center" class="demoTable">
			<caption>
				<span class="Estilo1">REGISTRO - <?php echo $dsgen ?> </span>
			</caption>
			<thead>
				<tr>

					<th width="91">
						<div align="left">ABREVIATURA </div>
					</th>
					<th width="467">
						<div align="left">DESCRIPCION </div>
					</th>

				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2">
						<div align="center">
							<div align="right">
								<input name="btn" type="hidden" id="btn" value="1" />
								<input name="cod" type="hidden" id="cod" value="<?php echo $cdgen ?>" />
								<input name="tipo" type="hidden" id="tipo" value="<?php echo $ltdgen ?>" />
								<input name="tipodes" type="hidden" id="tipodes" value="<?php echo $dsgen ?>" />
								<input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir" />
								<input type="reset" name="limp" id="limp" value="Limpiar" class="limpiar" />
								<input type="submit" name="back" value="Regresar" onClick="atras_movtablas3()" class="regresar" />
								<input type="button" name="exit" value="Salir" onClick="salir1()" class="salir" />
							</div>
						</div>
					</td>
				</tr>
			</tfoot>
			<tbody>

				<tr>
					<td><b>
							<center><?php if ($dsgen == "MARCA") { ?><input type="text" name="abrev" size="4" maxlength="4" onKeyUp="this.value = this.value.toUpperCase();"  /><?php } else { ?>"<?php echo $ltdgen; ?>"<?php } ?></center>
						</b></td>
					<td>
						<center><label>
								<div align="left">
									<?php if ($tipo == "P") {
									?>
										DEPARTAMENTO
										<select name="departamento" class="Estilodany" id="departamento" style="width: 300px">
											<?php
											$sql = "SELECT * FROM titultabladet where tiptab = 'D' order by destab";
											$result = mysqli_query($conexion, $sql);
											while ($row = mysqli_fetch_array($result)) {
												$marca = $row["codtab"];
											?>
												<option value="<?php echo $row["codtab"] ?>" <?php if ($codmar == $marca) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
											<?php } ?>
										</select>
										<hr />
									<?php }
									?>
									<?php if ($tipo == "TDOC") {
										/*
			  ?>
			  CAMPO
			  <select name="tdoc">
			   <option value="nrovent">NRO VENTA</option>
			    <option value="hora">HORA DE VENTA</option>
				<option value="invfec">FECHA</option>
				<option value="descli">NOMBRE CLIENTE</option>
				<option value="nomusu">ABRV USUARIO</option>
				<option value="forpag">FORMA PAGO</option>
				<option value="cuscod">CODIGO CLIENTE</option>
			    <option value="dircli">DIRECCION CLIENTE</option>
			    <option value="bruto">VALOR BRUTO</option>
				<option value="valven">VALOR VTA</option>
				<option value="igv">VALOR DEL IGV</option>
				<option value="invtot">NETO A PAGAR</option>
				<option value="montext">MONTO EN LETRAS</option>
				<option value="ruccli">RUC CLIENTE</option>
		      </select>
			  <?php */
									?>
										<input name="tdoc" type="text" id="tdoc" />
									<?php }
									?>
									<?php if ($tipo == "DIST") {
									?>
										PROVINCIA
										<select name="provincia" class="Estilodany" id="provincia" style="width: 300px">
											<?php
											$sql = "SELECT * FROM titultabladet where tiptab = 'P' order by destab";
											$result = mysqli_query($conexion, $sql);
											while ($row = mysqli_fetch_array($result)) {
												$marca = $row["codtab"];
											?>
												<option value="<?php echo $row["codtab"] ?>" <?php if ($codmar == $marca) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
											<?php } ?>
										</select>
										<hr />
									<?php }
									?>
									<input name="desc" type="text" id="desc" size="70" onKeyUp="this.value = this.value.toUpperCase();" />
									<label>
										<input type="button" name="Submit" value="Grabar" onclick="save_movtabla3()" class="grabar" />
									</label>
								</div>
							</label>
						</center>
					</td>
				</tr>

			</tbody>
		</table>
	</form>
</body>

</html>

<script>
	$('#provincia').select2();
	$('#departamento').select2();
</script>