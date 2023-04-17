<?php require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
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
			background-color: #FFFF99;
			color: #0066CC;
			border: 0px solid #ccc;
		}

		a:active {
			background-color: #FFFF99;
			color: #0066CC;
			border: 0px solid #ccc;
		}
	</style>
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
	require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
	require_once('../../local.php');	//LOCAL DEL USUARIO
	?>
	<script>
		function tarjet() {
			document.form1.tarjeta.focus();
		}

		function cerrar(e) {
			tecla = e.keyCode
			if (tecla == 27) {
				window.close();
			}
			if (tecla == 13) {
				var f = document.form1;
				f.action = "credit_card1.php";
				f.method = "post";
				f.submit();
			}
		}

		function cerrar_popup(valor) {
			//ventana=confirm("Desea Grabar este Cliente");
			var prod = valor;
			document.form1.target = "venta_principal";
			window.opener.location.href = "salir.php?prod=" + prod;
			self.close();
		}

		function saves() {
			var f = document.form1;
			if ((f.num.value == "") || (f.num.value == 0)) {
				alert("DEBE INGRESAR LOS NUMEROS DE LA TARJETA");
				f.num.focus();
				return;
			}
			f.action = "credit_card1.php";
			f.method = "post";
			f.submit();
		}
		var nav4 = window.Event ? true : false;

		function enters(evt) {
			// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
			var key = nav4 ? evt.which : evt.keyCode;
			alert(tecla);
			if (key == 13) {
				document.form1.Submit.focus();
			}
			return (key == 8 || key == 37 || key == 39 || (key >= 48 && key <= 57));
		}
	</script>
	<title>MODULO DE VENTAS</title>
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		<!--
		.Estilo3 {
			color: #FFFFFF
		}

		body {
			background-color: #FFFFCC;
		}

		select {
			width: 260px;
		}
		-->
	</style>
</head>
<?php $sql = "SELECT codtab,numtarjet FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codtabs    = $row['codtab'];
		$numtarjet  = $row['numtarjet'];
	}
}
?>

<body onload="tarjet()" onkeyup="cerrar(event)">
	<form name="form1">
		<table width="500" border="0">
			<tr>
				<td bgcolor="#50ADEA"><span class="Estilo3">TARJETA</span></td>
				<td bgcolor="#FFFFCC"><select name="tarjeta" id="tarjeta">
				    <option value="0">Seleccione una Tarjeta...</option>
						<?php $sql = "SELECT * FROM tarjeta    order by nombre";
						$result = mysqli_query($conexion, $sql);
						while ($row = mysqli_fetch_array($result)) {
						?>
							<option value="<?php echo $row['id'] ?>" <?php if ($codtab == $row['id']) { ?>selected="selected" <?php } ?>><?php echo $row['nombre'] ?></option>
						<?php }
						?>
					</select>
					<input type="button" name="Submit" value="Grabar" onclick="saves()" />
				</td>
			</tr>
			<tr>
				<td width="82" bgcolor="#50ADEA"><span class="Estilo3">TARJETA</span></td>
				<td width="324" bgcolor="#FFFFCC">
					<input name="num" type="text" id="num" onkeypress="return enters(event);" value="<?php echo $numtarjet ?>" /></td>
			</tr>
		</table>
	</form>
</body>

</html>


<script type="text/javascript">

	$("#tarjeta").select2({
		placeholder: "sometext",
		allowClear: false,
		tags: true
	});
</script>