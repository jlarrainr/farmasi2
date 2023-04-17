<?php require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../../funciones/funct_principal.php');
require_once('../../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../../funciones/botones.php');	//COLORES DE LOS BOTONES
?>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFFFCC;
}
-->
</style>
</head>
<?php $cod = $_REQUEST['cod'];
if ($cod <> '')
{
$sql="SELECT desprod,codfam FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$desprod         = $row['desprod'];
	$codfam          = $row['codfam'];
}
}
$sql="SELECT destab FROM titultabladet where codtab = '$codfam'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$destab          = $row['destab'];
}
}
function formato($c) {
printf("%08d",  $c);
} 
?>
</head>
<body>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
<div align="center">
  <table width="565" border="0">
    <tr>
      <td width="74" valign="top">NRO DE VENTA </td>
      <td width="481" valign="top">
	  <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($venta)?>"/>      </td>
    </tr>
    <tr>
      <td valign="top">PRODUCTO</td>
      <td valign="top"><input name="nom2" type="text" id="nom2" size="60" value="<?php echo $desprod?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td valign="top">FAMILIA</td>
      <td valign="top">
	  <input name="nom2" type="text" id="nom2" size="60" value="<?php echo $destab?>" disabled="disabled"/></td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="570" height="4" />
  <table width="565" border="0">
    <tr>
      <td width="471"><strong>PRODUCTOS</strong></td>
      <td width="84"><div align="right"><strong>STOCK</strong></div></td>
    </tr>
  </table>
  <?php include ('../funciones/datos_generales.php');
  $sql="SELECT desprod,$tabla FROM producto where codfam = '$codfam'";
  $result = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($result)){
  ?>
  <table width="565" border="0">
    <?php while ($row = mysqli_fetch_array($result)){
	$desprod          = $row['desprod'];
	$stock            = $row[1];
	
	?>
	<tr>
      <td width="471"><?php echo $desprod?></td>
      <td width="84"><div align="right"><?php echo $stock?></div></td>
    </tr>
	<?php }
	?>
  </table>
  <?php }
  else
  {
  ?>
  <center>NO SE LOGRO ENCONTRAR PRODUCTOS CON LA FAMILIA INDICADA</center>
  <?php }
  ?>
</div>
<div align="center"><br>
</div>
</form>
<?php }
else
{
?>
<center>UD DEBE INDICAR UN PRODUCTO PARA REALIZAR ESTA FUNCION</center>
<?php }
?>
</body>
</html>
