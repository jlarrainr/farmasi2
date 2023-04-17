<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../archivo/css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
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
          <td><div align="center"><strong>CORRECCI&Oacute;N DE STOCK DE ART&Iacute;CULOS : <?php echo $p1?></strong></div></td>
          </tr>
      </table>
	  <div align="center"><img src="../../../images/line2.png" width="931" height="4" /></div>
	<table width="897" border="0" align="center">
      <tr>
        <td width="881"><strong>PRODUCTO
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=1&tip=1&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="master2.php?val=1&p1=<?php echo $p1?>&ord=1&tip=2&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>		
		</td>
        <td width="16"><strong>CORREGIR</td>
      </tr>
    </table>
	<div align="center"><img src="../../../images/line2.png" width="931" height="4" /></div>
	<table width="897" border="0" align="center">
	<?php $z = 0;
	///////////////////////////////////////////////////////SOLO SE INGRESA EL TEXT0
	if ($ord == "")
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where desprod like '$p1%' LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto order by desprod LIMIT $inicio, $registros";	
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR PRODUCTO
	if ($ord == 1)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where desprod like '$p1%' order by desprod $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto order by desprod $dtip LIMIT $inicio, $registros";
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR MARCA
	if ($ord == 2)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where desprod like '$p1%' order by destab $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab order by destab $dtip LIMIT $inicio, $registros";	
		}
	}
	///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR STOCK
	if ($ord == 3)
	{
		if ($val == 1)
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where desprod like '$p1%' order by stopro $dtip LIMIT $inicio, $registros";
		}
		else
		{
	$sql="SELECT codpro,desprod,codfam,codmar,stopro, s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto order by stopro $dtip LIMIT $inicio, $registros";	
		}
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
	$s000		= 0;
	$s001		= 0;
	$s002		= 0;
	$s003		= 0;
	$s004		= 0;
	$s005		= 0;
	$s006		= 0;
	$s007		= 0;
	$s008		= 0;
	$s009		= 0;
	$s010		= 0;
	$s011		= 0;
	$s012		= 0;
	$s013		= 0;
	$s014		= 0;
	$s015		= 0;
	$s016		= 0;
		$codpro     = $row['codpro'];
		$desprod    = $row['desprod'];
		$stopro     = $row['stopro'];
		$codfam     = $row['codfam'];
		$codmar     = $row['codmar'];
		$s000    = $row['s000'];
		$s001    = $row['s001'];
		$s002    = $row['s002'];
		$s003    = $row['s003'];
		$s004    = $row['s004'];
		$s005    = $row['s005'];
		$s006    = $row['s006'];
		$s007    = $row['s007'];
		$s008    = $row['s008'];
		$s009    = $row['s009'];
		$s010    = $row['s010'];
		$s011    = $row['s011'];
		$s012    = $row['s012'];
		$s013    = $row['s013'];
		$s014    = $row['s014'];
		$s015    = $row['s015'];
		$s016    = $row['s016'];
		$stockpro = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016;
		$z++;
	?>
      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="871">
		<?php echo substr($desprod,0,75)?>
		</td>
        <td width="26">

		<?php 
		if ($stockpro <> $stopro)
		{
		?>
		<img src="../../../images/del_16.png" border="0"/>
		<?php
		}
		else
		{
		?>
		<img src="../../../images/icon-16-checkin.png" border="0"/>
		<?php 
		}
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
