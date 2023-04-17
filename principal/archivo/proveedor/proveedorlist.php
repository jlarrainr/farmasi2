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
</head>

<body>
<?php $cp = $_REQUEST['cp'];
$sql="SELECT codpro,despro FROM proveedor order by despro";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
<table width="370" border="0" align="center">
  <tr>
    <td><span class="Estilo3"><u>PROVEEDOR</u></span></td>
  </tr>
</table>
<div align="center"><img src="../../../images/line2.jpg" width="370" height="4" /></div>
<table width="370" border="0" align="center">
  <?php while ($row = mysqli_fetch_array($result)){
	$codpro    = $row['codpro'];
	$despro    = $row['despro'];
  ?>
  <tr bgcolor="<?php if ($cp == $codpro){?>#FFFF99<?php }else{?>#FFFFFF<?php }?>" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='<?php if ($cp == $codpro){?>#FFFF99<?php }else{?>#FFFFFF<?php }?>';">
    <td><a href="proveedor1.php?codpro=<?php echo $codpro?>" target="principal"><?php if ($cp == $codpro){?><b><?php echo $despro;?></b><?php }else{ echo $despro;}?></a></td>
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