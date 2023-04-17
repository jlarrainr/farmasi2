<?php 
require_once('../../session_user.php');
require_once ('../../../conexion.php');
$invnum   	    = $_SESSION['transferencia_ing'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<title>IMPRESION DE VENTA</title>
<script>
function escapes(){
	window.close();
}
function cargar() {
    var f = document.form1;
	var rd = f.rd.value; 
	f.method = "post";
	f.target = "self";
	self.close();
	parent.opener.location='impresion.php';
}
</script>
</head>
<body onload="cargar();">
          <form id="form1" name="form1">
	      <input name="rd" type="hidden" id="rd" value="<?php echo $rd;?>"/>
          </form>
</body>
</html>
