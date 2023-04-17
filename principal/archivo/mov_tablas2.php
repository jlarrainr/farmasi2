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
	<style type="text/css">
		.Estilo1 {
			font-size: 11px
		}
	</style>
	<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
	<script>
		function sf() {
			document.form1.srch.focus();
		}

		function enter(e) {
			key = e.keyCode;
			var f = document.form1;
			if (key == 13) {
				if (f.srch.value == "") {
					alert("UD DEBE INGRESAR UN TEXTO PARA BUSCAR");
					f.srch.focus();
					return;
				}
				f.val.value = 1;
				f.action = "mov_tablas2.php";
				f.method = "post";
				f.submit();
			} else {
				return;
			}
		}
	</script>
</head>

<body onload="sf();">
	<br>
	<?php
	$cod   = $_REQUEST['cod'];
	$error = $_REQUEST['error'];
	$del   = $_REQUEST['del'];
	$up    = $_REQUEST['up'];
	$ok    = $_REQUEST['ok'];
	$val   = $_REQUEST['val'];
	$sql = "SELECT dsgen,ltdgen FROM titultabla where cdgen = '$cod'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$dsgen                 = $row["dsgen"];
			$ltdgen                = $row["ltdgen"];
		}
	}
	?>
	<table width="100%" align="center" class="demoTable" id="customers">
		<caption>
			<span class="Estilo1">LISTADO DE TABLAS - <?php echo $dsgen ?>
				<b>
					<?php if ($error == '1') {
					?>
						<font color="#FF0000">ERROR!</font>
						<font color="#FFFF66"> - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS.</font>
					<?php }
					if ($ok == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO GRABAR EXITOSAMENTE LOS DATOS</font>
					<?php }
					if ($up == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO ACTUALIZAR EL PRODUCTO SELECCIONADO</font>
					<?php }
					if ($del == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO ELIMINAR EL PRODUCTO INDICADO</font>
					<?php }
					?>
				</b> </span>
		</caption>

		<tr>
			<td colspan="<?php if ($dsgen == "MARCA") { ?>5<?php } else { ?> 4<?php } ?>">
				<div align="center">
					<form method="post" name="form1" id="form1">
						<div align="right">
							<b><u>BUSCAR</u></b>&nbsp&nbsp
							<input name="srch" type="text" id="srch" size="50" onkeypress="return enter(event);" placeholder=" BUSCAR <?php echo $dsgen ?>..." />
							<input name="val" type="hidden" id="val" />
							<input name="cod" type="hidden" id="cod" value="<?php echo $cod ?>" />
							<input name="tipo" type="hidden" id="tipo" value="<?php echo $ltdgen ?>" />
							<input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir" />
							<input type="button" name="nuevo" value="Nuevo" onClick="nuevo_movtablas2()" class="nuevo" />
							<input type="button" name="back" value="Regresar" onClick="atras_movtablas2()" class="regresar" />
							<input type="button" name="exit" value="Salir" onClick="salir1()" class="salir" />
						</div>
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th width="62">
				<div align="center">N&ordm;</div>
			</th>
			<th width="325">
				<div align="left">Nombre </div>
			</th>
			<?php if ($dsgen == "MARCA") { ?><th width="113">
					<div align="left">Abrev </div>
				</th><?php } ?>
			<th width="22">
				<div align="left"></div>
			</th>
			<th width="24">
				<div align="left"></div>
			</th>

		</tr>

		<?php
		$i = 0;
		if ($val == 1) {
			$srch = $_REQUEST['srch'];
			if ($srch <> '*') {
				$sql = "SELECT codtab,destab,abrev FROM titultabladet where tiptab = '$ltdgen' and destab like '$srch%' order by destab";
			} else {
				$sql = "SELECT codtab,destab,abrev FROM titultabladet where tiptab = '$ltdgen' order by destab";
			}
		} else {
			$sql = "SELECT codtab,destab,abrev FROM titultabladet where tiptab = '$ltdgen' order by destab";
		}
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$i++;
				$codtab                 = $row["codtab"];
				$destab                 = $row["destab"];
				$abrev                  = $row["abrev"];

		?>
				<tr>
					<td>
						<div align="center"><?php echo $i ?> </div>
					</td>
					<td><?php echo $destab ?></td>
					<?php if ($dsgen == "MARCA") { ?><td><?php echo $abrev ?></td><?php } ?>
					<td>
						<center>
							<a href="mov_tablas5.php?cod=<?php echo $codtab ?>&tipo=<?php echo $ltdgen ?>">
								<img src="../../images/edit_16.png" border="0" height="14" width="14" /></a>
						</center>
					</td>
					<td>
						<center>
							<a href="mov_tablas6.php?cod=<?php echo $codtab ?>"><img src="../../images/del_16.png" border="0" width="14" height="14" /></a>
						</center>
					</td>
				</tr>
		<?php }
		}
		?>

	</table>
</body>

</html>