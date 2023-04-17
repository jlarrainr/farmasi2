<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("funciones/minimo.php");	//COLORES DE LOS BOTONES
$codpro = $_REQUEST['codpro'];
$marca  = $_REQUEST['country_ID'];
$sql1="SELECT desprod FROM producto where codpro = '$codpro'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$desproducto = $row1["desprod"];
}
}
$sql1="SELECT destab FROM titultabladet where codtab = '$marca'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$destab = $row1["destab"];
}
}
$cr  = $_REQUEST['cr'];
if ($cr == "")
{
$cr = 1;
}
$ccr = $_REQUEST['ccr'];
?>
<script>
window.onload = function()
{
  var row = document.getElementById("myTab").rows;
  row[<?php echo $cr?>].scrollIntoView(false);
}
function act()
{
var mark = document.form1.marca.value;
window.opener.location.href="salir.php?mark=<?php echo $marca?>";
self.close();
}
</script>
<script language="JavaScript">
<!--
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	//window.close();
	var f    = document.form1;
	var prod = f.codpro.value;
	var marc = f.marca.value;
	var cxr  = f.ccr.value;
	document.form1.target = "mark";
	window.opener.location.href="salir1.php?prod="+prod+"&marca="+marc+"&cr="+cxr;
	self.close();
	}
}
function mini()
{
document.getElementById('l<?php echo $cr?>').focus()
document.form1.minim.focus();
}
function numero(e) {
tecla=e.keyCode
  if (tecla == 27)
  {
	document.form1.codloc.value = "";
	document.form1.codpro.value = "";
	document.form1.marca.value = "";
	document.form1.action = "stockmin3.php"
	document.form1.submit();
  }
}
var nav4 = window.Event ? true : false;
function numeros1(evt) 
{
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	   var f = document.form1;
       f.method = "post";
       f.action ="stockmin3_reg.php";
       f.submit();
	}
	else
	{
	return (key <= 13 || (key >= 48 && key <= 57));
	}
}
//-->
</script>
<title><?php echo $desproducto?></title>
</head>
<body onkeyup="cerrar(event)" onload="mini();">
<?php $sql="SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
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
			$blister  	= $row['blister'];
}
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
  <table width="888" border="0" align="center" class="tabla2">
    <tr>
      <td width="882" class="text_combo_select">
	  <table width="850" border="0" align="center">
          <tr>
            <td width="303"><b><?php echo $desprod?></b></td>
            <td width="271"><b>LABORATORIO:</b> <?php echo $destab?> </td>
			<td width="205">
			<strong>
			  <input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc?>" />
			  <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
			  <input name="marca" type="hidden" id="marca" value="<?php echo $marca?>" /> 
			</strong>
		      <input name="ccr" type="hidden" id="ccr" value="<?php echo $ccr?>" /></td>
			  <td width="85">
			  </td>
          </tr>
      </table></td>
    </tr>
  </table>
  <table width="888" border="0" align="center" class="tabla2">
    <tr>
      <td width="880"><table width="794" border="0" align="center">
        <tr>
          <td class="text_combo_select"><strong>TIENDA</strong></td>
          <td width="111" class="text_combo_select"><div align="right"><strong>STOCK MINIMO </strong></div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="888" border="0" align="center" class="tabla2">
	<tr>
      <td width="880">
	  <table width="794" border="0" align="center" id="myTab">
        <?php $valform = $_REQUEST['valform'];
		$local   = $_REQUEST['local'];
		$cr = 1;
		$sql1="SELECT codloc,nomloc FROM xcompa order by codloc";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$codloc     = $row1['codloc'];
		$nomloc     = $row1['nomloc'];
		if ($nomloc == 'LOCAL0')
		{
		$stock_min = $m00;
		}
		if ($nomloc == 'LOCAL1')
		{
		$stock_min = $m01;
		}
		if ($nomloc == 'LOCAL2')
		{
		$stock_min = $m02;
		}
		if ($nomloc == 'LOCAL3')
		{
		$stock_min = $m03;
		}
		if ($nomloc == 'LOCAL4')
		{
		$stock_min = $m04;
		}
		if ($nomloc == 'LOCAL5')
		{
		$stock_min = $m05;
		}
		if ($nomloc == 'LOCAL6')
		{
		$stock_min = $m06;
		}
		if ($nomloc == 'LOCAL7')
		{
		$stock_min = $m07;
		}
		if ($nomloc == 'LOCAL8')
		{
		$stock_min = $m08;
		}
		if ($nomloc == 'LOCAL9')
		{
		$stock_min = $m09;
		}
		if ($nomloc == 'LOCAL10')
		{
		$stock_min = $m10;
		}
		if ($nomloc == 'LOCAL11')
		{
		$stock_min = $m11;
		}
		if ($nomloc == 'LOCAL12')
		{
		$stock_min = $m12;
		}
		if ($nomloc == 'LOCAL13')
		{
		$stock_min = $m13;
		}
		if ($nomloc == 'LOCAL14')
		{
		$stock_min = $m14;
		}
		if ($nomloc == 'LOCAL15')
		{
		$stock_min = $m15;
		}
		if ($nomloc == 'LOCAL16')
		{
		$stock_min = $m16;
		}
		?>
		<tr <?php if (($valform == 1) and ($local == $codloc)){?>bgcolor="#FFCC66"<?php } else{?> onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';"<?php }?>>
          <td>
		  <a id="l<?php echo $cr;?>" href="stockmin3.php?valform=1&codpro=<?php echo $codpro?>&local=<?php echo $codloc?>&country_ID=<?php echo $marca?>&cr=<?php echo $cr?>&ccr=<?php echo $ccr?>"><?php echo $nomloc?>		  </a>		  </td>
          <td width="111">
		  <div align="right">
		  
		  <?php if (($valform == 1) and ($local == $codloc)){?>
		    <?php ?>
            <input name="minim" type="text" id="minim" size="4" value="<?php echo $stock_min?>" onkeypress="return numeros1(event);"/>
			<input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc?>" />
			<input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
			<input name="country_ID" type="hidden" id="country_ID" value="<?php echo $marca?>" />
			<input name="cr" type="hidden" id="cr" value="<?php echo $cr?>" />
			<input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR"/>
			<input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR"/>
		  <?php }
		  else
		  {
		  echo $stock_min;
		  }
		  ?>
          </div>		  </td>
        </tr>
		<?php $c++;
		$cr++;
		}
		}
		?>
      </table></td>
    </tr>
  </table>
</form>
<?php }	////CIERRO EL IF DE LA CONSULTA
?>
</body>
</html>