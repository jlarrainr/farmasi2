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
<style type="text/css">
<!--
.Estilo3 {color: #3366CC; font-weight: bold; }
-->
</style>
<script>
function alls()
{
var f = document.form1;
f.action="laboratioriolist.php";
f.val.value = 0;
f.submit();
}
function provs()
{
var f = document.form1;
f.action="laboratioriolist.php";
f.val.value = 1;
f.submit();
}
</script>
</head>
<body>
<?php $cp  = $_REQUEST['cp'];
$val = $_REQUEST['val'];
if ($val == "")
{
$val = 0;
}
$sql="SELECT despro FROM proveedor where codpro = '$cp'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$despro    = $row['despro'];
}
}
?>
<table width="510" border="0" align="center">
  <tr>
    <td><u><span class="Estilo3">LABORATORIOS <?php if ($despro <> ""){?></span><font color="#990000"><b>- <?php echo $despro; }?></b></font></u></td>
  </tr>
</table>
<div align="center"><img src="../../../images/line2.jpg" width="510" height="4" /></div>
<?php if ($cp <>'')
{
?>
<form id="form1" name="form1">
  <table width="510" border="0" align="center">
    <tr>
      <td width="34">&nbsp;</td>
      <td width="332">
        <div align="right">
          <input name="val" type="hidden" id="val" />
          <input name="cp" type="hidden" id="cp" value="<?php echo $cp;?>" />
          <input type="button" name="Submit2" value="Laboratorios del Proveedor" onclick="provs()"/>
        </div>
      </td>
      <td width="130">
        <div align="right">
          <input type="button" name="Submit" value="Todos los Laboratorios" onclick="alls()"/>
        </div>
      </td>
    </tr>
  </table>
  <div align="center"><img src="../../../images/line2.jpg" width="510" height="4" /></div>
</form>
<?php }
if ($val == 0)
{
$sql="SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab";
}
else
{
$sql="SELECT titultabladet.codtab,destab FROM titultabladet inner join provlab on titultabladet.codtab = provlab.codtab where tiptab = 'M' and codpro = '$cp' order by destab";
}
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
<table width="510" border="0" align="center">
  <?php while ($row = mysqli_fetch_array($result)){
	$codtab    = $row['codtab'];
	$destab    = $row['destab'];
	$yes	   = 0;
	if ($cp <>'')
	{
	$sql1="SELECT coddet,state FROM provlab where codpro = '$cp' and codtab='$codtab'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$coddet    = $row1['coddet'];
		$state     = $row1['state'];
		$yes	   = 1;
	}
	}
	else
	{
	$state = 0;
	$yes = 0;
	}
	}
  ?>
  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
    <td width="458"><?php echo $destab;?></td>
	<td width="18"><?php if (($yes == 1) and ($state == 1)){?><img src="../../../images/icon-16-checkin.png" /><?php }?></td>
	<td width="20"><?php if ($cp <> ''){ ?> <a href="laboratoriolist1.php?cp=<?php echo $cp?>&codtab=<?php echo $codtab?>&st=<?php echo $state?>" target="principal"><?php if ($state == 0){?><img src="../../../images/add.gif" border="0"/><?php }else{?><img src="../../../images/del_16.png" border="0"/><?php } ?></a><?php }?></td>
  </tr>
  <?php }
  ?>
</table>
<?php }
else
{
?>
<center><u><font color="#990000">NO EXISTEN REGISTROS</font></u></center>
<?php }
?>
</body>
</html>