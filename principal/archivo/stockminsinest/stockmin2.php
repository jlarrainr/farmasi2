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
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
<?php /*?><link href="css/seleccion.css" rel="stylesheet" type="text/css" /><?php */?>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("funciones/minimo.php");	//COLORES DE LOS BOTONES
$cr = $_REQUEST['cr'];
?>
<script>
window.onload = function()
{
  var row = document.getElementById("myTab").rows;
  row[<?php echo $cr?>].scrollIntoView(false);
}
function getfocus(){
document.getElementById('l<?php echo $cr?>').focus()
}
</script>
<script>
function todos()
{
var f = document.form1;
f.tip.value = 0;
f.action="stockmin2.php";
f.submit();
}
function foco(e)
{
tecla=e.keyCode;
	if (tecla == 113)
	{
	var f = document.form1; f.desc.focus();
	f.desc.value="";
	}
	if (tecla == 114)
	{
	var f = document.form1;
	f.tip.value = 0;
	f.action="stockmin2.php";
	f.submit();
	}
}
</script>
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
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
}
a:active {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
} 
.Estilo1 {
	color: #006699;
	font-weight: bold;
}
.Estilo2 {
	color: #0066CC;
	font-weight: bold;
}
.Estilo3 {color: #003300}
</style>
</head>
<body onload="getfocus();" id="body" onkeyup="foco(event)">
<?php $val      = $_REQUEST['val'];
$t        = $_REQUEST['tip'];
$cod_prod = $_REQUEST['codpro'];
if ($val == 1)
{
$marca    = $_REQUEST['marca'];
if ($t==1)
{
$desc = $_REQUEST['desc'];
$sql="SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister FROM producto where codmar = '$marca' and desprod like '$desc%'";
}
else
{
$sql="SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister FROM producto where codmar = '$marca'";
}
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
  <table width="924" border="0" align="center">
    <tr>
      <td width="115">BUSCAR POR NOMBRE </td>
      <td>
        <input name="desc" type="text" id="desc" size="60" value="(F2 = BUSQUEDA DE PRODUCTOS)"/>
        <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
        <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod_prod?>" />
        <input name="marca" type="hidden" id="marca" value="<?php echo $marca?>" />
        <input name="tip" type="hidden" id="tip" value="1" />
      <input type="button" name="Submit" value="Todos los productos (F3)" onclick="todos();"/></td>
    </tr>
  </table>
  <table width="924" border="0" align="center" class="tabla2">
    <tr>
      <td><table width="916" border="0" align="center">
        <tr>
		  <td width="14"></td>
		  <td width="14"></td>
          <td width="444" class="text_combo_select"><strong>NOMBRE DEL PRODUCTO</strong></td>
          <td width="79" class="text_combo_select"><div align="right"><strong>BLISTER</strong></div></td>
		  <td width="130" class="text_combo_select"><div align="right"><strong>TOT DE STOCK ACTUAL </strong></div></td>
          <td width="129" class="text_combo_select"><div align="right"><strong>TOT DE STOCK MINIMO </strong></div></td>
          <td width="94" class="text_combo_select"><div align="right"><strong>FALTANTE</strong></div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="924" border="0" align="center">
	<tr>
      <td>
	  <table width="916" border="0" align="center" id="myTab">
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
			$min		= $m00 + $m01 + $m02 + $m03 + $m04 + $m05 + $m06 + $m07 + $m08 + $m09 + $m10 + $m11 + $m12 + $m13 + $m14 + $m15 + $m16;			////COMO STOCK GENERAL - MINIMOS
			if ($factor == 0)
			{
			$factor 	= 1;
			$convert    = $stopro/$factor;
			}
			else
			{
			$convert    = $stopro/$factor;
			}
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
		  <tr <?php if ($codpro == $cod_prod){?>bgcolor="#FFFF99" <?php } else{?> onmouseover="this.style.backgroundColor='#EAEDEF';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';"<?php }?>>
		    <td width="14">
			<a href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro?>', 10, 50, 1000, 350)">
			  <img src="../../../images/lens.gif" width="14" height="15" border="0"/>			 
			</a>			
			</td>
			<td width="14">
			<a href="javascript:popUpWindow('ver_blister.php?cod=<?php echo $codpro?>&cr=<?php echo $cr?>', 250, 200, 500, 20)">
			  <img src="../../../images/blister.gif" width="12" height="12" border="0"/>			 
			</a>			
			</td>  
            <td width="444">
			<?php //echo $cr;
			?>
			<a id="l<?php echo $cr;?>" href="javascript:popUpWindow('stockmin3.php?codpro=<?php echo $codpro?>&country_ID=<?php echo $marca?>&val=1&ccr=<?php echo $cr?>', 40, 90, 920, 360)">
			<font size="3"><?php if ($codpro == $cod_prod){?><b><?php echo $desprod?></b><?php } else { echo $desprod; }?></font>			</a>		</td>
            <td width="79">
			<div align="right">
			<strong>
			  <?php if ($blister == 0)
				{
			  	echo '<font color="#FF0000">'; echo $blisters; echo '</font>';
				}
				else
				{
				echo $blisters;
				}
			  ?>
            </strong>			
			</div>
			</td>
			<td width="130"><div align="right"><?php echo $div?> F <?php echo $tot?></div></td>
            <td width="129"><div align="right">
			<?php if(($blister <> "") || ($factor == 0)){?>
			<?php echo $div1?> F <?php echo $tot1?> U
			<?php }else{?>
			<?php echo $div1?> F
			<?php }?>
			</div></td>
            <td width="94">
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
          </tr>
		  <?php $cr++;
		  }
		  ?>
      </table>
	  </td>
    </tr>
  </table>
</form>
<?php }	////CIERRO EL IF DE LA CONSULTA
else
{
?>
<br><br><br><br><br><br><br><br><center>NO SE LOGRO ENCONTRAR PRODUCTOS CON LA MARCA INDICADA</center>
<?php }
}	////CIERRO EL IF DEL VAL
include('funciones/teclas.php');
?>
</body>
</html>
