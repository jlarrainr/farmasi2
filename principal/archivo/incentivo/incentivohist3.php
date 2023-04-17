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
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	document.form1.target = "marco1";
	window.opener.location.href="salir.php?val=<?php echo $val?>&p1=<?php echo $p1?>&ord=<?php echo $ord?>&tip=<?php echo $tip?>&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>";
	self.close();
	}
}
</script>
<!--
<style type="text/css">

.Estilo3 {color: #FFFFFF; font-weight: bold; }

</style>-->
</head>
<body onkeyup="cerrar(event)">
<form name="form1">
<table width="747">
  <tr>
    <td ><center><b><u>INCENTIVO NUMERO <?php echo $invnum?></u></b></center></td>
  </tr>
</table>
<table width="747" border="0" bgcolor="#50ADEA">
  <tr>
    <td width="69"><span class="Estilo3">CODIGO</span></td>
    <td width="294"><span class="Estilo3">PRODUCTO</span></td>
	<td width="140"><span class="Estilo3">LABORATORIO</span></td>
	<td width="72"><div align="right"><span class="Estilo3">COSTO</span></div></td>
	<td width="69"><div align="right"><span class="Estilo3">P. VTA </span></div></td>
	<!--<td width="77"><div align="right"><span class="Estilo3">MONTO A PAGAR </span></div></td>-->
    </tr>
</table>
<table width="747" border="0">
  <?php $i=1;
  $sql="SELECT producto.codpro,desprod,pcostouni,prevta,codmar,cuota FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' order by desprod";
  $result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codpro         = $row['codpro'];
		$desprod        = $row['desprod'];
		$pcostouni      = $row['pcostouni'];
		$prevta         = $row['prevta'];
		$codmar         = $row['codmar'];
		$cuota          = $row['cuota'];
		$sql1="SELECT destab FROM titultabladet where codtab = '$codmar'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$destab    = $row1['destab'];
		}
		}
  ?>
  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
    <td width="69"><?php echo $codpro?></td>
    <td width="294"><?php echo $desprod?></td>
	<td width="140"><?php echo $destab?></td>
	<td width="72"><div align="right"><?php echo $pcostouni?></div></td>
	<td width="69"><div align="right"><?php echo $prevta?></div></td>
	<!--<td width="77"><div align="right"><?php echo $cuota?></div></td> -->
    </tr>
  <?php $i++;
  }
  }
  else
  {
  ?>
  <center>No se logr� encontrar registros para este Numero de Incentivo</center>
  <?php }
  ?>
</table>
</form>
</body>
</html>
