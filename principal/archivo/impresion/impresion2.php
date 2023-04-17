<?php
echo "<META HTTP-EQUIV='refresh' CONTENT='10; URL=$PHP_SELF'>";
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<?php 
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$sql="SELECT imprapida FROM xcompa where habil = '1' and codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$imprapida    = $row["imprapida"];
}
}
$imprapida = 0;
function formato($c) {
printf("%08d",$c);
} 
function tipo($num)
{
if($num == 1)
{
$valor = "Factura";
}
if($num == 2)
{
$valor = "Boleta";
}
if($num == 3)
{
$valor = "Guia de remisi�n";
}
return $valor;
}
?>
<body>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
  <?php 
  if ($imprapida == 0)
  {
  ?>
  <table width="100%" border="0">
    <tr>
      <td width="4%">N&ordm;</td>
      <td width="10%">Nro Venta </td>
      <td width="59%">Cliente</td>
      <td width="9%"><div align="right">Monto</div></td>
	  <td width="12%"><div align="right">Tipo de Documento</div></td>
      <td width="6%"><div align="right">Imprimir</div></td>
    </tr>
  </table>
  <div align="center"><img src="../../../images/line2.png" width="98%" height="4" /></div>
  <table width="100%" border="0">
    <?php 
	$i=0;
	$sql="SELECT invnum,nrovent,invfec,usecod,invtot,tipdoc,tipdoc,cuscod FROM venta where tipdoc <> '4' and impreso = '0' and estado = '0' and invtot > 5";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
	$nrovent    = $row["nrovent"];
	$invfec    = $row["invfec"];
	$usecod    = $row["usecod"];
	$invtot    = $row["invtot"];
	$tipdoc    = $row["tipdoc"];
	$cuscod    = $row["cuscod"];
	$invnum    = $row["invnum"];
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$nomusu    = $row1['nomusu'];
		}
		}
		$sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$descli    = $row1['descli'];
		}
		}
	$i++;
	$t = $i%2;
	if ($t == 1)
	{
	$color = "#FF6600";
	}
	else
	{
	$color = "#FF0000";
	}
	?>
	<tr bgcolor="<?php echo $color?>" onmouseover="this.style.backgroundColor='#339900';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='<?php echo $color?>';">
      <td width="4%"><span class="Estilo1"><?php echo $i;?></span></td>
      <td width="10%"><span class="Estilo1"><?php echo formato($nrovent);?></span> </td>
      <td width="59%"><span class="Estilo1"><?php echo $descli;?></span></td>
      <td width="9%"><div align="right" class="Estilo1"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' ');?></div></td>
	  <td width="12%"><div align="right" class="Estilo1"><?php echo tipo($tipdoc);?></div></td>
      <td width="6%">
	  <div align="right">
	  <a href="javascript:popUpWindow('imprimirpdf.php?invnum=<?php echo $invnum?>', 10, 50, 1000, 350)">
	  <img src="../../../images/printbutton.png" width="14" height="14" border="0"/>
	  </a>
	  </div></td>
    </tr>
	<?php 
	}
	}
	?>
  </table>
  <?php }
  else
  {
  ?>
  <center>UD TIENE HABILITADO LAS IMPRESIONES DE VENTAS RAPIDAS</center>
  <?php 
  }
  ?>
</form>
</body>
</html>
