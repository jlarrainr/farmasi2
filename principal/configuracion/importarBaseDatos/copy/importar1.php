<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" language="JavaScript1.2" src="menu/stmenu.js"></script>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/select_pro.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
</head>
<body onload="sf();">
<div class="mask1">
	<div class="mask2">
		<div class="mask3">
		  <iframe src="index.php" name="iFrame1" width="666" height="618" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True"></iframe>
        </div>
	</div>
</div>
</body>
</html>
