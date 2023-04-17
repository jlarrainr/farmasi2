<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $desemp?> - PREINGRESOS</title>
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
$invnum   	  = $_SESSION['compraspreg'];
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
    <td width="80%">&nbsp;</td>
    <td width="7%"><div align="right">N.I</div></td>
    <td width="13%"><?php echo $invnum?></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%">Fecha</td>
    <td width="17%"><?php echo fecha($fecha)?></td>
    <td width="8%">Fecha Vcmto </td>
    <td width="21%"><?php echo fecha($fecven)?></td>
	<td width="9%">Plazo </td>
    <td width="34%"><?php echo $plazo?></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%">Doc. Referencia  </td>
    <td width="46%">ORDEN DE COMPRA </td>
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
    <td width="6%">Cantidad</td>
    <td width="38%">Producto</td>
    <td width="7%"><div align="right">V. Compra </div></td>
    <td width="7%"><div align="right">Fijo</div></td>
    <td width="7%"><div align="right">Dcto1</div></td>
    <td width="7%"><div align="right">Dcto2</div></td>
    <td width="7%"><div align="right">Dcto3</div></td>
    <td width="7%"><div align="right">Revate</div></td>
    <td width="7%"><div align="right">Costo</div></td>
	 <td width="7%"><div align="right">P.Vta</div></td>
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
		$sql11="SELECT desprod FROM producto where codpro = '$codpro'";
		$result11 = mysqli_query($conexion,$sql11);
		if (mysqli_num_rows($result11)){
		while ($row11 = mysqli_fetch_array($result11)){
				$desprod       = $row11['desprod'];		//codigo
				}}
?>
<table width="98%" border="0">
  <tr>
    <td width="6%"><?php if ($qtyprf <> ""){echo $qtyprf; } else { echo $qtypro;}?></td>
    <td width="38%"><?php echo $desprod?></td>
    <td width="7%"><div align="right"><?php echo $prisal?></div></td>
    <td width="7%"><div align="right"></div></td>
    <td width="7%"><div align="right"><?php echo $d1?></div></td>
    <td width="7%"><div align="right"><?php echo $d2?></div></td>
    <td width="7%"><div align="right"><?php echo $d3?></div></td>
    <td width="7%"><div align="right">0.00</div></td>
    <td width="7%"><div align="right"><?php echo $costre?></div></td>
    <td width="7%"><div align="right"><?php echo $pripro?></div></td>
  </tr>
</table>
<?php 
}}
?>
</form>
</body>
</html>