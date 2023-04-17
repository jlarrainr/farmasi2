<?php require_once('../../../conexion.php');
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
$tarjeta = $_REQUEST['tarjeta'];
$num     = $_REQUEST['num'];
mysqli_query($conexion, "UPDATE venta set codtab = '$tarjeta',numtarjet= '$num' where invnum = '$venta'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<script>
		function cerrar() {
			window.close();
		}
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
</head>

<body onLoad="cerrar();">
</body>

</html>