<?php require_once ('../../../conexion.php');
//$invnum  = $_SESSION['compras'];
$ncompra = $_REQUEST['nrocompra'];
$prov    = $_REQUEST['alfa1'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function cerrar(){
	//document.form1.target = "_top";
	window.opener.location.href="compras_busca.php?nrocompra=<?php echo $ncompra?>&alfa1=<?php echo $prov?>";
	self.close();
}
</script>
</head>
<body onload="cerrar()">
<form name="form1">
</form>
</body>
</html>
