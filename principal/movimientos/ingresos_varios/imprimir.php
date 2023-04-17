<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $desemp?> - INGRESOS VARIOS</title>
<script>
function imprimir()
{
var f = document.form1;
window.print();
f.action = "../ing_salid.php";
f.method = "post";
f.submit();
}
</script>
<?php 
$invnum   	  = $_SESSION['ingresos_val'];
$sql="SELECT * FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codigo
		$fecha        = $row['invfec'];
		$refere       = $row['refere'];
		$fecdoc       = $row['fecdoc'];
		$fecven       = $row['fecven'];
		$numdoc       = $row['numdoc'];
		$ndoc         = $row['numero_documento'];
		$ndoc1        = $row['numero_documento1'];
		$plazo        = $row['plazo'];
		$val_habil    = $row['val_habil'];
		$invtot       = $row['invtot'];
		$destot       = $row['destot'];
		$valven       = $row['valven'];
		$costo        = $row['costo'];
		$igv          = $row['igv'];
}
}
?>
</head>
<body onLoad="imprimir();">
<form name="form1" id="form1">
  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
      <td width="69%"><div align="right">N Documento <?php echo $numdoc;?></div></td>
    </tr>
  </table>
  <table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%">Fecha</td>
    <td width="17%"><?php echo fecha($fecha);?></td>
    <td>&nbsp;</td>
    </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%">Doc. Referencia  </td>
    <td width="46%">TRANSFERENCIA POR INGRESOS  </td>
    <td width="9%">Monto Sist </td>
    <td width="34%"><?php echo $invtot?></td>
  </tr>
  <tr>
    <td>Referencia</td>
    <td><?php echo $refere?></td>
    <td>Monto Doc </td>
    <td><?php echo $invtot?></td>
  </tr>
</table>
<table width="98%" border="0">
  <tr>
    <td width="10%">Codigo</td>
    <td width="60%">Producto</td>
	<td width="20%">Abreviatura</td>
	<td width="10%">Cantidad</td>
  </tr>
</table>
<?php 
	$sql1="SELECT * FROM movmov where invnum = '$invnum'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	    $codpro    = $row1['codpro'];
		$qtypro    = $row1['qtypro'];	
		$qtyprf    = $row1['qtyprf'];
		$prisal    = $row1['prisal'];
		$pripro    = $row1['pripro'];
		$costre    = $row1['costre'];
		$d1        = $row1['desc1'];
		$d2        = $row1['desc2'];
		$d3        = $row1['desc3'];
		$sql11="SELECT desprod,codmar FROM producto where codpro = '$codpro'";
		$result11 = mysqli_query($conexion,$sql11);
		if (mysqli_num_rows($result11)){
		while ($row11 = mysqli_fetch_array($result11)){
				$desprod       = $row11['desprod'];
				$codmar        = $row11['codmar'];
		}}
		$sql11="SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
		$result11 = mysqli_query($conexion,$sql11);
		if (mysqli_num_rows($result11)){
		while ($row11 = mysqli_fetch_array($result11)){
				$destab       = $row11['destab'];
				$abrev        = $row11['abrev'];	
		}}
?>
<table width="98%" border="0">
  <tr>
     <td width="10%"><?php echo $codpro?></td>
	 <td width="60%"><?php echo $desprod?></td>
	 <td width="20%"><?php if ($abrev <> ""){echo $abrev; } else { echo $destab;}?></td>
	 <td width="10%"><?php if ($qtyprf <> ""){echo $qtyprf; } else { echo $qtypro;}?></td>
  </tr>
</table>
<?php 
}}
?>
</form>
</body>
</html>