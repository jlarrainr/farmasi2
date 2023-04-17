<?php include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
</head>
<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min	= date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$codpro = $_REQUEST['codpro'];
if ($local <> 'all')
{
	$sql="SELECT nomloc FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$nomloc    = $row['nomloc'];
	}
	}
}
$sql="SELECT desprod,destab,s000 FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where codpro = '$codpro' and producto.eliminado='0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$desprod    = $row['desprod'];
	$destab     = $row['destab'];
	$s000       = $row['s000'];
}
}
?>
<body>
<table width="930" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?></strong></td>
        <td width="380"><div align="center"><strong>REPORTE DE STOCK POR LOTES </strong></div></td>
        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>

    </table>
      <table width="914" border="0">
        <tr>
          <td width="134">&nbsp;</td>
          <td width="633"><div align="center"></div></td>
          <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
        </tr>
      </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="916" border="0">
      <tr>
        <td width="78"><strong>PRODUCTO</strong></td>
        <td width="828"><?php echo $desprod?></td>
      </tr>
      <tr>
        <td><strong>MARCA</strong></td>
        <td><?php echo $destab?></td>
      </tr>
      <tr>
        <td><strong>STOCK</strong></td>
        <td><?php echo $s000?></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <td width="33"><strong>N&ordm;</strong></td>
        <td width="428"><div align="left"><strong>LOTE </strong></div></td>
		<td width="358"><div align="left"><strong>FECHA VENCIMIENTO  </strong></div></td>
		<td width="358"><div align="left"><strong>LOCAL</strong></div></td>
		<td width="89"><div align="right"><strong>STOCK </strong></div>		  <div align="center"></div></td>
		</tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php $c = 0;
	$sql="SELECT numlote,vencim,stock, codloc FROM movlote where codpro = '$codpro'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
		$numlote      = $row['numlote'];
		$vencim       = $row['vencim'];
		$stock1       = $row['stock'];
		$codloc       = $row['codloc'];
		$c++;
	  ?>
	  <tr>
        <td width="33"><?php echo $c;?></td>
        <td width="428"><?php echo $numlote;?></td>
		<td width="358"><?php echo $vencim;?></td>
		<td width="358"><?php echo $codloc;?></td>
		<td width="89"><div align="right"><?php echo $stock1;?></div></td>
		</tr>
	  <?php }
	  ?>
    </table>
	<?php }
	?>
	</td>
  </tr>
</table>
</body>
</html>
