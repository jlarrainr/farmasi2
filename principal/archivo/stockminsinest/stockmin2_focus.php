<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<link href="css/seleccion.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("funciones/minimo.php");	//COLORES DE LOS BOTONES
$cr = $_REQUEST['cr'];
?>
<script>
window.onload = function()
{
<?php //$cr = $_REQUEST['cr'];
//$pr = $_REQUEST['cr'];
?>
  var row = document.getElementById("myTab").rows;
  row[<?php echo $cr?>].scrollIntoView(false);
}
function getfocus(){
document.getElementById('l<?php echo $cr?>').focus()
}
</script>
</head>
<body onload="getfocus();" id="body">
<?php $val      = $_REQUEST['val'];
$cod_prod = $_REQUEST['codpro'];
if ($val == 1)
{
$marca    = $_REQUEST['marca'];
$sql="SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister FROM producto where codmar = '$marca'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
<table id="table" cellspacing="0" onselectstart="return false">
 <thead>
  <tr id="head">
  <th width="10">N�</th>
  <th width="434">NOMBRE DEL PRODUCTO</th>
  <th width="79">BLISTER</th>
  <th width="130">TOT DE STOCK ACTUAL</th>
  <th width="129">TOT DE STOCK MINIMO</th>
  <th width="94">FALTANTE</th>
  <th width="14">&nbsp;</th>
  </tr>
 </thead>
 <tbody id="tbody">
		 <?php $cr = 1;
	 	   while ($row = mysqli_fetch_array($result)){
		    $codpro     = $row['codpro'];
			$desprod    = $row['desprod'];
			$stopro     = $row['stopro'];
			$factor     = $row['factor'];
			$m00     	= $row['m00'];
			$m01     	= $row['m01'];
			$m02    	= $row['m02'];
			$m03     	= $row['m03'];
			$m04     	= $row['m04'];
			$m05     	= $row['m05'];
			$m06     	= $row['m06'];
			$m07     	= $row['m07'];
			$m08     	= $row['m08'];
			$m09     	= $row['m09'];
			$m10    	= $row['m10'];
			$m11     	= $row['m11'];
			$m12     	= $row['m12'];
			$m13     	= $row['m13'];
			$m14     	= $row['m14'];
			$m15     	= $row['m15'];
			$m16     	= $row['m16'];
			$blisters  	= $row['blister'];
			$min		= $m00 + $m01 + $m02 + $m03 + $m04 + $m05 + $m06 + $m07 + $m08 + $m09 + $m10 + $m11 + $m12 + $m13 + $m14 + $m15 + $m16;										////COMO STOCK GENERAL - MINIMOS
			$convert    = $stopro/$factor;
			$convertmin = $min/$factor;
			$div    	= floor($convert);			////PARTE ENTERA DEL STOCK GENERAL
			$div1    	= floor($convertmin);		////PARTE ENTERA DEL STOCK MINIMOS
			$mult		= $factor * $div;			
			$mult1      = $factor * $div1;
			$tot		= $stopro - $mult;			/////OBTENGO EL RESIDUO DEL STOCK GENERAL
			$tot1       = $min - $mult1;			/////OBTENGO EL RESIDUO DEL STOCK MINIMO
			//$r			= $stopro - $min;
			$r			= $min - $stopro;
			if ($r<0)
			{
			$c    = 0;
			$r    = $r * (-1);
			$desc = "SOBRAN";
			}
			else
			{
			$c    = 1;
			$desc = "FALTAN";
			}
			$div2       = $r/$factor;
			$div2    	= floor($div2);
			$mult2      = $factor * $div2;
			$tot2       = $r - $mult2;
		  ?>
	  <tr <?php if ($codpro == $cod_prod){ ?> id="this"<?php }?>>
	      <td></td>
		  <td>
		  <a id="l<?php echo $cr;?>" href="stockmin1.php?codpro=<?php echo $codpro?>&country_ID=<?php echo $marca?>&val=1&cr=<?php echo $cr?>" target="mark">
			<font size="3"><?php if ($codpro == $cod_prod){?><b><?php echo $desprod?></b><?php } else { echo $desprod; }?></font></a></td>
		  <td><div align="right"><?php echo $blisters?></div></td>
		  <td><div align="right"><?php echo $div?> F <?php echo $tot?></div></td>
		  <td><div align="right"><?php echo $div1?> F <?php echo $tot1?></div></td>
		  <td>
		    <div align="right">
			<?php if ($c==1)
			{
			?>
			<font color="#990000"><b><?php echo $desc?> <?php echo $div2?> F <?php echo $tot2?></b></font>
			<?php }
			else
			{
			?>
			<?php echo $desc?> <?php echo $div2?> F <?php echo $tot2?>
			<?php }
			?>
			</div>
		  </td>
		  <td>
		 <a href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro?>', 2, 50, 1100, 350)">
		 <img src="../../../images/lens.gif" width="14" height="15" border="0"/>			  
		 </a>
		  </td>
	  </tr>
	  <?php $cr++;
	   }
	  ?>
 </tbody>
</table>
<?php include('funciones/teclas.php');?>
</form>
<?php }	////CIERRO EL IF DE LA CONSULTA
else
{
?>
<br><br><br><br><br><br><br><br><center>NO SE LOGRO ENCONTRAR PRODUCTOS CON LA MARCA INDICADA</center>
<?php }
}	////CIERRO EL IF DEL VAL
?>
</body>
</html>
