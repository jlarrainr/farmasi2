<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/select.css" rel="stylesheet" type="text/css" />

	<link href="../../select2/css/select2.min.css" rel="stylesheet" />
	<script src="../../select2/jquery-3.4.1.js"></script>
	<script src="../../select2/js/select2.min.js"></script>

	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	require_once("../funciones/transferencia_ing.php");	//FUNCIONES DE ESTA PANTALLA
	////////////////////////////////////////////////////////////////////////////////////////////////
	?>
	<?php $sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$invnum          = $row["invnum"];		//codigo
		}
	}
	$_SESSION['transferencia_ing']	= $invnum; 	////GRABO UNA SESION CON EL MOVIMIENTO QUE ESTOY REALIZANDO
	$sql = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$codloc       = $row['codloc'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
			$user    	  = $row['nomusu'];
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	$sql = "SELECT invnum,invfec,numdoc FROM movmae where invnum = '$invnum'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$cod          = $row['invnum'];		//codgio
			$fecha        = $row['invfec'];
			$numdoc       = $row['numdoc'];
		}
	}
	///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA

	function formato($c)
	{
		printf("%08d",  $c);
	}
	function formato1($c)
	{
		printf("%06d",  $c);
	}
	$srch = isset($_REQUEST['srch']) ? ($_REQUEST['srch']) : "";
	$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";



	if ($val == 1) {
		$documento = isset($_REQUEST['documento']) ? ($_REQUEST['documento']) : "";
		$local	    = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
		$sql = "SELECT invnum FROM movmae where numdoc = '$documento' and sucursal = '$local' and sucursal1 = '$codloc' and tipmov = '2' and tipdoc = '3' and estado = '0' and proceso = '0' and val_habil = '0'";					/////OBTENGO EL DOCUMENTO
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$srch = 1;
				$codorigen       = $row['invnum'];
				mysqli_query($conexion, "UPDATE movmae set invnumrecib = '$codorigen' where invnum = '$invnum'");
			}
		} else {
			$srch = 0;
		}
	}
	$sql1 = "SELECT invnumrecib FROM movmae where invnum = '$invnum'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$invnumrecib        = $row1['invnumrecib'];		////NOMBRE DE QUIEN REALIZO LA TRANSFERENCIA
		}
	}

	if (($invnumrecib <> "") && ($invnumrecib <> 0)) {

		require_once("grabamov.php");
	}

	if ($val == '') {
		/////////////CUENTA SI AY OTROS INGRESOS PENDIENTES A ESTE MISMO LOCAL
		$sql = "SELECT count(invnum) FROM movmae where sucursal1 = '$codloc' and tipmov = '2' and tipdoc = '3' and estado = '0' and proceso = '0' and val_habil = '0'";					/////OBTENGO EL DOCUMENTO
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$cuenta          = $row[0];
			}
		}
	} else {
		$cuenta = 0;
	}

	$sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$count        = $row[0];	////CANTIDAD DE REGISTROS EN EL GRID
		}
	} else {
		$count = 0;	////CUANDO NO HAY NADA EN EL GRID
	}
	$sql = "SELECT nlicencia FROM datagen ";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nlicencia = $row['nlicencia'];
		}
	}
	?>
	<script>
		function compras3(e) {
			tecla = e.keyCode;
			var f = document.form1;
			var a = f.count.value;
			alert(a);
		}

		function compras2(e) {
			tecla = e.keyCode;
			var f = document.form1;
			var a = f.count.value;

			if (tecla == 119) {
				if (a == 0) {
					alert('No se puede grabar este Documento');
				} else {

					ventana = confirm("Desea Grabar estos datos");
					if (ventana) {
						f.method = "POST";
						f.target = "_top";
						f.action = "transferencia1_ing_reg.php";
						f.submit();
					}
				}
			}
			if (tecla == 120) {
				if ((a == 0)) {
					alert('No se puede realizar la impresi�n de este Documento');
				} else {
					f.method = "POST";
					f.target = "_top";
					f.action = "transferencia1_ing_op_reg.php";
					f.submit();
				}
			}
		}

		function grabardoc() {
			var f = document.form1;
			var a = f.count.value;
			if (a == 0) {
				alert('No se puede grabar este Documento');
			} else {

				ventana = confirm("Desea Grabar estos datos");
				if (ventana) {
					f.method = "POST";
					f.target = "_top";
					f.action = "transferencia1_ing_reg.php";
					f.submit();
				}
			}
		}

		function imprimirdoc() {
			var f = document.form1;
			var a = f.count.value;
			if ((a == 0)) {
				alert('No se puede realizar la impresi�n de este Documento');
			} else {
				f.method = "POST";
				f.target = "_top";
				f.action = "transferencia1_ing_op_reg.php";
				f.submit();
			}
		}
	</script>

	<style>
		.LETRA {
			font-family: Tahoma;
			font-size: 11px;
			line-height: normal;
			color: '#5f5e5e';
			font-weight: bold;
		}

		input {
			box-sizing: border-box;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 12px;
			background-color: white;
			background-position: 3px 3px;
			background-repeat: no-repeat;
			padding: 2px 1px 2px 5px;

		}

		.LETRA2 {
			background: #d7d7d7
		}
	</style>
</head>

<body onkeyup="compras2(event)" onload="<?php if ($cuenta > 0) { ?> popup(<?php echo $cuenta; ?>);<?php } else {
																									if ($srch == 1) { ?>sb()<?php } else { ?>sf()<?php }
																																			} ?>">
	<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
		<table width="100%" border="0">
			<tr>
				<td width="958">
					<table width="100%" border="0">
						<tr>
							<td width="606"><label>
									<div align="right">

										<input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled" />
										<input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" />
										<input name="count" type="hidden" id="count" value="<?php echo $count ?>" />
										<input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
										<input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />

										<input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar" />
										<input name="sal" type="button" id="sal" value="Salir" onclick="salir()" class="cancelar" />

									</div>
								</label></td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
					<table width="100%" border="0">
						<tr>
							<td width="76" class="LETRA">NUMERO</td>
							<td width="10"><input class="LETRA2" name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($numdoc) ?>" /></td>
							<td width="100" class="LETRA">
								<div align="right">FECHA</div>
							</td>
							<td width="148"><input name="textfield2" class="LETRA2" type="text" size="22" disabled="disabled" value="<?php echo fecha($fecha) ?>" /></td>
							<td width="288">
								<div align="right" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></div>
							</td>
						</tr>
						<tr>
							<td width="75" class="LETRA">DOCUMENTO</td>
							<td width="120">
								<input name="documento" type="text" id="documento" size="20" value="<?php echo $documento ?>" onkeyup="this.value = this.value.toUpperCase();" />
							</td>
							<td class="LETRA">
								<div align="right">LOCAL DE PROCEDENCIA </div>
							</td>
							<td width="468" colspan="2">
								<select name="local" id="local" onchange="cargarContenido()">
									<?php
									//$sql = "SELECT * FROM xcompa where codloc <> '$codigo_local' and codloc <> '1' and habil = '1'"; 
									$sql = "SELECT * FROM xcompa where habil = '1'  and  codloc <> '$codloc' order by codloc ASC LIMIT $nlicencia";
									$result = mysqli_query($conexion, $sql);
									while ($row = mysqli_fetch_array($result)) {
									?>
										<option value="<?php echo $row["codloc"] ?>" <?php if ($local == $row["codloc"]) { ?> selected="selected" <?php } ?>>
											<?php if ($row["nombre"] <> "") {
												echo $row["nombre"];
											} else {
												echo $row["nomloc"];
											} ?>
										</option>
									<?php } ?>
								</select>
								<label>
									<input name="srch" type="hidden" id="srch" value="1" />
									<input name="val" type="hidden" id="val" value="1" />
									&nbsp;&nbsp;&nbsp;
									<input type="button" name="busk" value="BUSCAR" class="buscar" <?php if ($count > 0) { ?> title="No esta permitido precargar mas de una vez el ingreso de mercaderia u otro, tiene que cancelar o salir del modulo para cargar otro documento." disabled="disabled" <?php } else { ?> onclick="validar()" <?php } ?> />
								</label>
							</td>
						</tr>


					</table>


					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
					<table width="100%" border="0">
						<tr>
							<td width="955">
								<?php
								$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
								if ($val == 1) {
									$documento = isset($_REQUEST['documento']) ? ($_REQUEST['documento']) : "";
									$local	 = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
								?>
									<iframe src="transferencia2_ing.php?doc=<?php echo $documento ?>&local=<?php echo $local ?>&val=1" name="iFrame2" width="100%" height="490" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
								<?php } else {
								?>
									<iframe src="transferencia2_ing.php" name="iFrame2" width="100%" height="490" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
								<?php }
								?>
							</td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
					<br>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
<script type="text/javascript">
	$('#local').select2();
</script>