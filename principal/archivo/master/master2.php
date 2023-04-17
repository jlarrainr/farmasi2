<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
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
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 }
 a:active {
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 } 
</style>
<script>
function getfocus(){
document.getElementById('l1').focus()
}
function validar_prod()
{
var f = document.form1;
f.method = "post";
f.action = "master2_1.php";
f.submit();
}
function validar_grid()
{
var f = document.form1;
f.method = "post";
f.action = "master2.php";
f.submit();
}
var nav4 = window.Event ? true : false;
function cerrar(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 27)
	{
	document.form1.submit();
	}
}
</script>
<style>
#boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
#boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
</style>
</head>
<?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$val 	 = $_REQUEST['val'];
$p1	 	 = $_REQUEST['p1'];
$ord 	 = $_REQUEST['ord'];
$tip 	 = $_REQUEST['tip'];
$valform = $_REQUEST['valform'];
$cod     = $_REQUEST['cod'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
if ($tip == 1)
{
$dtip = "ASC";
}
if ($tip == 2)
{
$dtip = "DESC";
}
?>
<body onload="getfocus();" onkeyup="cerrar(event)">
<form id="form1" name="form1" method = "post">
<?php if (($val == 1) || ($val == 3))
{
?>
<table width="940" border="0" class="tabla2">
  <tr>
    <td width="941">
	  <table width="931" border="0" align="center">
        <tr>
          <td><div align="center"><strong>MAESTRO DE ART&Iacute;CULOS : <?php echo $p1?></strong></div></td>
          </tr>
      </table>
	  <div align="center"><img src="../../../images/line2.png" width="931" height="4" /></div>
	<table width="931" border="0" align="center">
      <tr>
        <td width="334"><strong>PRODUCTO
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=1&tip=1&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=1&tip=2&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>		
		</td>
        <td width="326"><strong>MARCA
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=2&tip=1&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=2&tip=2&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>		</td>
        <td width="257"><strong>USO DEL PRODUCTO
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=3&tip=1&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=3&tip=2&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>		</td>
      </tr>
    </table>
	<div align="center"><img src="../../../images/line2.png" width="931" height="4" /></div>
	<table width="931" border="0" align="center">
	<?php $z = 0;
	///////////////////////////////////////////////////////SOLO SE INGRESA EL TEXT0
	if ($ord == "")
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto where desprod like '$p1%' LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto order by desprod LIMIT $inicio, $registros";	
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR PRODUCTO
	if ($ord == 1)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto where desprod like '$p1%' order by desprod $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto order by desprod $dtip LIMIT $inicio, $registros";
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR MARCA
	if ($ord == 2)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where desprod like '$p1%' order by destab $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab order by destab $dtip LIMIT $inicio, $registros";	
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR STOCK
	if ($ord == 3)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto where desprod like '$p1%' order by stopro $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro FROM producto order by stopro $dtip LIMIT $inicio, $registros";	
		}
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codpro     = $row['codpro'];
		$desprod    = $row['desprod'];
		$stopro     = $row['stopro'];
		$codfam     = $row['codfam'];
		$codmar     = $row['codmar'];
		$sql1="SELECT destab FROM titultabladet where codtab ='$codmar'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$destab     = $row1['destab'];
		}
		}
		$sql1="SELECT destab FROM titultabladet where codtab ='$codfam'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$destab1     = $row1['destab'];
		}
		}
		$z++;
	?>
      <tr <?php if (($valform == 1) && ($cod == $codpro)){?> bgcolor="#FFCC33"<?php } else {?>onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';"<?php }?>>
        <td width="334">
		<?php if (($valform == 1) && ($cod == $codpro))
		{
		?>
		<input type="text" name="prod" size="40" value="<?php echo $desprod?>"/>
		<?php }
		else
		{
		?>
		<a id="l<?php echo $z;?>" href="master2.php?cod=<?php echo $codpro?>&p1=<?php echo $p1?>&val=1&valform=1&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>"><?php echo substr($desprod,0,75)?></a>
		<?php }
		?>		
		</td>
        <td width="326">
		<?php if (($valform == 1) && ($cod == $codpro))
		{
		?>
          <select name="mark" id="mark">
            <?php 
				$sql1 = "SELECT * FROM titultabladet where tiptab = 'M' order by destab"; 
				$result1 = mysqli_query($conexion,$sql1); 
				while ($row1 = mysqli_fetch_array($result1)){ 
				$codtab	= $row1["codtab"];
				$destab	= $row1["destab"];
				?>
            <option value="<?php echo $row1["codtab"]?>" <?php if ($codmar == $codtab){?> selected="selected"<?php }?>><?php echo $row1["destab"] ?></option>
            <?php } ?>
          </select>
		  <?php }
		  else
		  {
		  echo substr($destab,0,55);
		  }
		  ?>
		  </td>
        <td width="257">
		<?php if (($valform == 1) && ($cod == $codpro))
		{
		?>
          <select name="use" id="use">
            <?php 
				$sql1 = "SELECT * FROM titultabladet where tiptab = 'F' order by destab"; 
				$result1 = mysqli_query($conexion,$sql1); 
				while ($row1 = mysqli_fetch_array($result1)){ 
				$codtab	= $row1["codtab"];
				$destab	= $row1["destab"];
				?>
            <option value="<?php echo $row1["codtab"]?>" <?php if ($codfam == $codtab){?> selected="selected"<?php }?>><?php echo $row1["destab"] ?></option>
            <?php } ?>
          </select>
		  <?php }
		  else
		  {
		  echo substr($destab1,0,55);
		  }
		  ?>
		  <?php if (($valform == 1) && ($cod == $codpro))
		  {
		  ?>
		  <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>"/>
		  <input type="hidden" name="p1" value="<?php echo $p1?>"/>
		  <input type="hidden" name="ord" value="<?php echo $ord?>"/>
		  <input type="hidden" name="val" value="<?php echo $val?>"/>
		  <input type="hidden" name="inicio" value="<?php echo $inicio?>"/>
		  <input type="hidden" name="pagina" value="<?php echo $pagina?>"/>
		  <input type="hidden" name="tot_pag" value="<?php echo $tot_pag?>"/>
		  <input type="hidden" name="registros" value="<?php echo $registros?>"/>
		  <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>
          <input name="button" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
		  <?php }
		  ?>
		  </td>
      </tr>
    <?php }
	}
    ?>
    </table></td>
  </tr>
</table>
<?php }
?>
</form>
</body>
</html>
