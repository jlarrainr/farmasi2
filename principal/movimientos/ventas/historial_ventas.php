<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<?php
	require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once('../../../titulo_sist.php');
	include('../../local.php');
	$codpro = $_REQUEST['codpro'];
	?>
	<script>
		// Si usuario pulsa tecla ESC, cierra ventana
		function getfocus1() {
			document.getElementById('l1').focus();
		}

		function cerrar(e) {
			tecla = e.keyCode
			if (tecla == 27) {
				window.close();
			}
		}

		function cerrar_popup(valor) {
			//ventana=confirm("Desea Grabar este Cliente"+valor);
			var accionte = valor;

			document.form1.target = "venta_principal";
			window.opener.location.href = "saliraccionte.php?accionte=" + accionte;
			self.close();
		}
	</script>
	<?php
	function formato($c)
	{
		printf("%08d", $c);
	}
	?>
	<title>ACCION TERAPEUTICA</title>
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
	<?php echo $codpro ?>

</body>

</html>