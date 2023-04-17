<?php include('../../session_user.php');
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/body.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js"></script>
<style>
.mask1111{
	position:relative;
	width:990px;
	height:644px;
	overflow:hidden;
	left: 4px;
	top: 4px;
	border:1px solid #CDCDCD;
	background:#F9F9F9;
}
.mask2222{
	position:relative;
	width:984px;
	height:638px;
	overflow:hidden;
	left: 2px;
	top: 4px;
	border:1px solid #ccc;

}
.mask3333{
	position:relative;
	width:980px;
	height:632px;
	overflow:hidden;
	left: 2px;
	top: 4px;
	background:#F9F9F9;
}
</style>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<body>
<div class="tabla1">
<script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script>
<div class="title1">
<span class="titulos">SISTEMA DE VENTAS - PROYECCION DE COMPRAS</span></div>
<div class="mask1111">
	<div class="mask2222">
		<div class="mask3333">
			<iframe src="proyeccion1.php" name="principal" width="978" height="618" scrolling="Automatic" frameborder="0" id="principal" allowtransparency="0">			
			</iframe>
  	  </div>
	</div>
   </div>
  </div>
</body>
</html>
