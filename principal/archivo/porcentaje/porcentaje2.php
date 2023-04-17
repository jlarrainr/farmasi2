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
</head>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
///////LOCAL0
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL0'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc     = $row1['codloc'];
}
}
///////LOCAL1
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL1'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc1     = $row1['codloc'];
}
}
///////LOCAL2
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL2'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc2     = $row1['codloc'];
}
}
///////LOCAL3
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL3'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc3     = $row1['codloc'];
}
}
///////LOCAL4
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL4'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc4     = $row1['codloc'];
}
}
///////LOCAL5
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL5'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc5     = $row1['codloc'];
}
}
///////LOCAL6
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL6'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc6     = $row1['codloc'];
}
}
///////LOCAL7
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL7'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc7     = $row1['codloc'];
}
}
///////LOCAL8
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL8'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc8     = $row1['codloc'];
}
}
///////LOCAL9
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL9'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc9     = $row1['codloc'];
}
}
///////LOCAL10
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL10'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc10     = $row1['codloc'];
}
}
///////LOCAL11
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL11'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc11     = $row1['codloc'];
}
}
///////LOCAL12
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL12'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc12     = $row1['codloc'];
}
}
///////LOCAL13
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL13'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc13     = $row1['codloc'];
}
}
///////LOCAL14
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL14'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc14     = $row1['codloc'];
}
}
///////LOCAL15
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL15'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc15     = $row1['codloc'];
}
}
///////LOCAL16
$sql1="SELECT codloc FROM xcompa where nomloc ='LOCAL16'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$codloc16     = $row1['codloc'];
}
}
$val = $_REQUEST['val'];
$p1	 = $_REQUEST['p1'];
$p2	 = $_REQUEST['p2'];
$ord = $_REQUEST['ord'];
$tip = $_REQUEST['tip'];
if ($tip == 1)
{
$dtip = "ASC";
}
if ($tip == 2)
{
$dtip = "DESC";
}
?>
<body>
<?php if ($val == 1)
{
?>
<table width="1044" border="0" class="tabla2">
  <tr>
    <td width="1036">
	<table width="612" border="0" align="center">
      <tr>
        <td width="606"><div align="left"><strong>PORCENTAJES DE UTILIDAD ENTRE <?php echo $p1?> % AL <?php echo $p2?> %</strong></div></td>
      </tr>
    </table>
	<div align="center"><img src="../../../images/line2.png" width="1400" height="4" /></div>
	<table width="1400" border="0" align="center">
      <tr>
        <td width="443"><strong>PRODUCTO
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=1&tip=1"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=1&tip=2"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>
		</td>
        <td width="341"><strong>MARCA
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=2&tip=1"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=2&tip=2"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>
		</td>
        <td width="75"><strong>UTILIDAD
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=3&tip=1"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>
		<a href="porcentaje2.php?val=1&p1=<?php echo $p1?>&p2=<?php echo $p2?>&ord=3&tip=2"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a></strong>
		</td>
        <td width="27"><div align="right"><strong>L0</strong></div></td>
        <td width="27"><div align="right"><strong>L1</strong></div></td>
        <td width="27"><div align="right"><strong>L2</strong></div></td>
        <td width="27"><div align="right"><strong>L3</strong></div></td>
        <td width="27"><div align="right"><strong>L4</strong></div></td>
        <td width="27"><div align="right"><strong>L5</strong></div></td>
        <td width="27"><div align="right"><strong>L6</strong></div></td>
        <td width="27"><div align="right"><strong>L7</strong></div></td>
        <td width="27"><div align="right"><strong>L8</strong></div></td>
        <td width="27"><div align="right"><strong>L9</strong></div></td>
        <td width="27"><div align="right"><strong>L10</strong></div></td>
        <td width="27"><div align="right"><strong>L11</strong></div></td>
        <td width="27"><div align="right"><strong>L12</strong></div></td>
        <td width="27"><div align="right"><strong>L13</strong></div></td>
        <td width="27"><div align="right"><strong>L14</strong></div></td>
        <td width="27"><div align="right"><strong>L15</strong></div></td>
		<td width="27"><div align="right"><strong>L16</strong></div></td>
      </tr>
    </table>
	<div align="center"><img src="../../../images/line2.png" width="1400" height="4" /></div>
	<table width="1400" border="0" align="center">
	<?php if ($ord == "")
	{
	$sql="SELECT codpro,desprod,margene,codfam,codmar FROM producto where margene between '$p1' and '$p2'";
	}
	if ($ord == 1)
	{
	$sql="SELECT codpro,desprod,margene,codfam,codmar FROM producto where margene between '$p1' and '$p2' order by desprod $dtip";
	}
	if ($ord == 2)
	{
	$sql="SELECT codpro,desprod,margene,codfam,codmar FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where margene between '$p1' and '$p2' order by destab $dtip";
	}
	if ($ord == 3)
	{
	$sql="SELECT codpro,desprod,margene,codfam,codmar FROM producto where margene between '$p1' and '$p2' order by margene $dtip";
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codpro     = $row['codpro'];
		$desprod    = $row['desprod'];
		$margene    = $row['margene'];
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
		$sum = 0;
		$sum1= 0;
		$sum2= 0;
		$sum3= 0;
		$sum4= 0;
		$sum5= 0;
		$sum6= 0;
		$sum7= 0;
		$sum8= 0;
		$sum9= 0;
		$sum10=0;
		$sum11=0;
		$sum12=0;
		$sum13=0;
		$sum14=0;
		$sum15=0;
		$sum16=0;
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc1'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum1     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc2'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum2     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc3'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum3     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc4'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum4     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc5'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum5     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc6'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum6     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc7'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum7     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc8'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum8     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc9'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum9     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc10'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum10     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc11'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum11     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc12'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum12     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc13'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum13     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc14'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum14     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc15'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum15     = $row1[0];
		}
		}
		$sql1="SELECT sum(pripro) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where codpro ='$codpro' and sucursal = '$codloc16'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$sum16     = $row1[0];
		}
		}
	?>
      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="443"><?php echo substr($desprod,0,75)?></td>
        <td width="341"><?php echo substr($destab,0,55)?></td>
        
        <td width="75"><div align="center"><?php echo $margene?> %</div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum1, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum2, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum3, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum4, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum5, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum6, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum7, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum8, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum9, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum10, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum11, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum12, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum13, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum14, 2, '.', ' ');?></div></td>
        <td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum15, 2, '.', ' ');?></div></td>
		<td width="27"><div align="right"><?php echo $numero_formato_frances = number_format($sum16, 2, '.', ' ');?></div></td>
      </tr>
    <?php }
	}
    ?>
    </table></td>
  </tr>
</table>
<?php }
?>
</body>
</html>
