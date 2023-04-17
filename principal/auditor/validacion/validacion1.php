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
	<link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
	<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
	<script type="text/javascript">
		window.addEvent('domready', function() {
			myCal = new Calendar({
				date1: 'Y-m-d'
			});
			myCal = new Calendar({
				date2: 'Y-m-d'
			});
		});
	</script>

	<link href="../../select2/css/select2.min.css" rel="stylesheet" />
	<script src="../../select2/jquery-3.4.1.js"></script>
	<script src="../../select2/js/select2.min.js"></script>


	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	?>
	<?php require_once("../../../funciones/calendar.php"); ?>
	<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	?>
	<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	?>
	<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	?>
	<?php require_once("local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
	?>
	<?php // require_once("../../local.php");	//LOCAL DEL USUARIO
	//$hour   = date(G);
	$date	= date('Y-m-d');
	//$date	= CalculaFechaHora($hour);
	$local = $_REQUEST['local'];
	$date1 = $_REQUEST['date1'];
	$date2 = $_REQUEST['date2'];
	$tipo  = $_REQUEST['tipo'];
	$sql = "SELECT * FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$user    = $row['nomusu'];
		}
	}

	$sql = "SELECT nlicencia FROM datagen ";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nlicencia       = $row['nlicencia'];
		}
	}

	?>
	<script>
		function salir() {
			var f = document.form1;
			f.method = "POST";
			f.target = "_top";
			f.action = "../../index.php";
			f.submit();
		}

		function validar() {
			var f = document.form1;
			if (f.date1.value == "") {
				alert("Ingrese una Fecha");
				f.date1.focus();
				return;
			}
			if (f.date2.value == "") {
				alert("Ingrese una Fecha");
				f.date2.focus();
				return;
			}
			f.method = "post";
			f.action = "validacion1.php";
			f.submit();
		}
	</script>
</head>

<body>
	<table width="100%" border="0">
		<tr>
			<td width="835"><b><u>AUDITOR DE INGRESOS: </u></b>: Se mostraran las Transferencias de Productos entre Sucursales</td>
			<td width="109">&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0">
		<tr>
			<td width="944">
				<form id="form1" name="form1">
					<table width="100%" border="0">
						<tr>
							<td width="83">FECHA INCIAL </td>
							<td width="186">
								<input type="text" name="date1" id="date1" size="12" value="<?php if ($date1 == "") {
																								echo $date;
																							} else {
																								echo $date1;
																							} ?>">
							</td>
							<td width="79">FECHA FINAL </td>
							<td width="123">
								<input type="text" name="date2" id="date2" size="12" value="<?php if ($date2 == "") {
																								echo $date;
																							} else {
																								echo $date2;
																							} ?>">
							</td>


							<td width="208"><label>
									<select name="tipo" id="tipo">
										<option value="1" <?php if ($tipo == 1) { ?> selected="selected" <?php } ?>>TRANSFERENCIAS RECIBIDAS</option>
										<option value="2" <?php if ($tipo == 2) { ?> selected="selected" <?php } ?>>TRANSFERENCIAS PENDIENTES</option>
									</select>
								</label>
							</td>

							<td width="10">
								<div align="right">LOCAL</div>
							</td>
							<td width="200">
								<select name="local" id="local">
									<?php if ($nombre_local == 'LOCAL0') { ?>
										<option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
									<?php } ?>
									<?php
									if ($nombre_local == 'LOCAL0') {
										$sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia ";
									} else {
										$sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local' ORDER BY codloc ASC LIMIT $nlicencia";
									}
									$result = mysqli_query($conexion, $sql);
									while ($row = mysqli_fetch_array($result)) {
										$loc	= $row["codloc"];
										$nloc	= $row["nomloc"];
										$nombre	= $row["nombre"];
										if ($nombre == '') {
											$locals = $nloc;
										} else {
											$locals = $nombre;
										}
									?>
										<option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nombre; ?></option>
									<?php } ?>
								</select>

							</td>


							<td width="250">
								<div align="right">
									<input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $marca ?>" />
									<input name="search" type="button" id="search" value="Buscar" onclick="validar()" class="buscar" />
									<input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
								</div>
							</td>

						</tr>
					</table>
				</form>
				<table width="100%" border="0">
					<tr>
						<td><?php /*if ($val == 1){?>MARCA BUSCADA POR: <b><u><?php echo $marca;?></u></b><?php }*/ ?></td>
						<td width="189">
							<div align="right"></div>
						</td>
					</tr>
				</table>
				<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
			</td>
		</tr>
	</table>
	<iframe src="validacion2.php?date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&tipo=<?php echo $tipo ?>&val=1" name="marco" id="marco" width="100%" height="510" scrolling="Automatic" frameborder="0" allowtransparency="0">
	</iframe>
</body>

</html>
<script>
	$('#local').select2();
	$('#tipo').select2();
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>