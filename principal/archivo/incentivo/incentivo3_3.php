<?php include('../../session_user.php');
require_once('../../../conexion.php');
$val     = $_REQUEST['val'];
$tip     = $_REQUEST['tip'];
$p1      = $_REQUEST['p1'];
$ord     = $_REQUEST['ord'];
$invnum  = $_REQUEST['invnum'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
$codpro  = $_REQUEST['codpro'];
$sql="SELECT invnum FROM incentivado where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invnum    = $row['invnum'];
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INCENTIVO NUMERO <?php echo $invnum?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.Estilo3 {color: #FFFFFF; font-weight: bold; }

</style>
</head>
<body>
<form name="form1">

<table width="100%" border="0">
    <tr>
    <th bgcolor="#50ADEA"><span class="Estilo3">SUCURSAL</span></th>
  </tr>
    
<?php $sql="SELECT codloc FROM incentivadodet where invnum = '$invnum' and codpro = '$codpro' order by codloc";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codloc    = $row['codloc'];
	$sql1="SELECT nombre FROM xcompa where codloc = '$codloc' and habil = '1'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	$nomloc    = $row1['nombre'];
	}
	}
?>
  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
	<td ><a href="incentivo3.php?codpro=<?php echo $codpro;?>&local=<?php echo $codloc?>&val=<?php echo $val?>&valform=1&p1=<?php echo $p1?>&ord=<?php echo $ord?>&tip=<?php echo $tip?>&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>&incent=<?php echo $invnum?>" target="marco2"><?php echo $nomloc?></a></td>
  </tr>
<?php }
}
?>
</table>
</form>
</body>
</html>
