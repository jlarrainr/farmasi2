<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
function formato($c) {
printf("%08d",  $c);
} 
$invnum = $_REQUEST['invnum'];
$sql="SELECT invnum,nrocomp,invfec,provee,invtot,codusu,preingreso,altpreingreso FROM ordmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum   = $row['invnum'];
		$nrocomp  = $row['nrocomp'];
		$invfec   = fecha($row['invfec']);
		$provee   = $row['provee'];
		$invtot   = $row['invtot'];
		$codusu   = $row['codusu'];
		$preingreso   = $row['preingreso'];
		$altpreingreso   = $row['altpreingreso'];
}
}
$sql1="SELECT despro FROM proveedor where codpro = '$provee'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$proveedor    = $row1['despro'];
}
}
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$descli    = $row['descli'];
}
}
?>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>

<body onkeyup="cerrar(event)">
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="922"><table width="935" border="0" align="center">
      <tr>
        <td width="69"><strong>NUMERO</strong></td>
        <td width="80"><?php echo formato($nrocomp)?></td>
        <td width="43"><strong>FECHA</strong></td>
        <td width="117"><?php echo $invfec?></td>
        <td width="604">&nbsp;</td>
        </tr>
    </table>
      <table width="935" border="0" align="center">
        <tr>
          <td width="69"><strong>PROVEEDOR</strong></td>
          <td width="582"><?php echo $proveedor?></td>
          <td width="74"><div align="left"><strong>USUARIO</strong></div></td>
          <td width="192"><?php echo $descli?></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="937"><table width="935" border="0" align="center">
      <tr>
        <td width="30"><strong>N&ordm;</strong></td>
        <td width="410"><strong>PRODUCTO</strong></td>
        <td width="125"><strong>MARCA</strong></td>
        <td width="80"><div align="right"><strong>CANTIDAD</strong></div></td>
        <td width="82"><div align="right"><strong>PRECIO  </strong></div></td>
        <td width="77"><div align="right"><strong>SUB TOTAL </strong></div></td>
		<td width="101"><div align="right"><strong>RESTRINGIR </strong></div></td>
      </tr>
    </table>
    <hr/>
	<?php $i= 0;
	$sql="SELECT codpro,canpro,precio_ref,mont_total,codmar,costod,confirmar FROM ordmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="935" border="0" align="center">
        <?php while ($row = mysqli_fetch_array($result)){
				$codpro    = $row['codpro'];
				$canpro    = $row['canpro'];
				$precio    = $row['precio_ref'];
				$monto_tot = $row['mont_total'];
				$costod    = $row['costod'];
				$codmar    = $row['codmar'];
				$conf      = $row['confirmar'];
				$sql1="SELECT desprod FROM producto where codpro = '$codpro'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				}
				}
				$sql1="SELECT destab FROM titultabladet where codtab = '$codmar'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
				$destab    = $row1['destab'];
				}
				}
				$i++;
		?>
		<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
          <td width="29"><?php echo $i?></td>
          <td width="410"><?php echo $desprod; if ($costod == 0){ echo " (B)";}?></td>
          <td width="125"><?php echo substr($destab,0,5)?></td>
          <td width="80"><div align="right"><?php echo $canpro?></div></td>
          <td width="82"><div align="right"><?php echo $costod?></div></td>
          <td width="77"><div align="right"><?php echo $monto_tot?></div></td>
		  <td width="102"><div align="right">
		    <?php /*
			if ($altpreingreso == 0)
			{
				if ($costod <> 0)
				{
					if ($conf == 0)
					{
					?>
					<a href="conf_detalle.php?invnum=<?php echo $invnum?>&codpro=<?php echo $codpro?>&conf=<?php echo $conf?>"> DESAUTORIZAR
					<img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" alt="AUN NO CONFIRMADO"/>
					</a>
					<?php }
					else
					{
					?>
					<a href="conf_detalle.php?invnum=<?php echo $invnum?>&codpro=<?php echo $codpro?>&conf=<?php echo $conf?>"> AUTORIZAR
					<img src="../../../images/del_16.png" width="16" height="16" border="0" alt="CONFIRMADO"/>
					</a>
					<?php }
				}
			}
			else
			{
			?>
			<font color="#990000">PREINGRESO</font>
			<?php }
			*/
			if (($preingreso == 1) and ($altpreingreso == 0))
			{
				if ($conf == 0)
				{
				?>
				<a href="conf_preingreso.php?invnum=<?php echo $invnum?>&conf=<?php echo $conf?>">
				DESAUTORIZAR</a>
				<?php }
				else
				{
				?>
				<a href="conf_preingreso.php?invnum=<?php echo $invnum?>&conf=<?php echo $conf?>">
				AUTORIZAR</a>
				<?php }
			}
			?>
</div></td>
        </tr>
		<?php }
		?>
      </table>
	<?php }
	?>
	</td>
  </tr>
</table>
<table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="935" border="0" align="center">
      <tr>
        <td width="674">&nbsp;</td>
        <td width="41"><strong>TOTAL</strong></td>
        <td width="99"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' ');?></div></td>
		<td width="103"><div align="right"></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
