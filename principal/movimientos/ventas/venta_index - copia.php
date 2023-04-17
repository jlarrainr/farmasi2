<?php require_once('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<?php if ($resolucion == 1)
{
?>
<link href="css/tablas_pek.css" rel="stylesheet" type="text/css" />
<?php }
else
{
?>
<link href="css/tablas_med.css" rel="stylesheet" type="text/css" />
<?php }
?>
<link href="../../css/body.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../funciones/functions.php');	//DESHABILITA TECLAS?>
<?php 
$cancel = $_REQUEST['cancel'];
$tt     = $_REQUEST['tt'];
$vt     = $_REQUEST['vt'];
?>
<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
<script>
function sss()
{
alert("VENTA CANCELADA. PRESIONE ACEPTAR PARA CONTINUAR");
}
var popUpWin=0;
function impresion()
{
////boton///
var left  = 90;
var top   = 120;
var width = 500;
var height= 400;
if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open('imprimirpdf.php?rd=<?php echo $tt;?>&vt=<?php echo $vt?>', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
</script>
</head>
<body <?php if($cancel == 1){?>onload="sss();"<?php } else { if($tt <> ''){ ?>onload="impresion();"<?php }}?>>
<div class="tabla1">
<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>
<div class="title1">
<span class="titulos">SISTEMA DE VENTAS - Movimiento de Mercaderias
</span></div>
<div class="mask1111">
	<div class="mask2222">
		<div class="mask3333">
		      <?php $activado  = $_REQUEST['activado'];
			  $activado1 = $_REQUEST['activado1'];
			  $tipo 	 = $_REQUEST['tipo'];
			  $val       = $_REQUEST['val'];
			  $producto  = $_REQUEST['producto'];
			  ?>
			<iframe src="venta_index1.php?activado=<?php echo $activado?>&activado1=<?php echo $activado1?>&tipo=<?php echo $tipo?>&val=<?php echo $val?>&producto=<?php echo $producto?>" name="venta_principal" width="<?php if ($resolucion == 1){?>738<?php }else{?>978<?php }?>" height="624" scrolling="Automatic" frameborder="0" id="venta_principal" allowtransparency="0">
			</iframe>
  	    </div>
	</div>
   </div>
  </div>
</body>
</html>
