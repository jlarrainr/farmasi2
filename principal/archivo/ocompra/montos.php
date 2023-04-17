<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/boton_graba.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<style type="text/css">

.Estilo1 {
	color: #FF0000;
	font-weight: bold;
	font-size: 16px;
}
.Estilo2 {
	font-size: 16px;
	font-weight: bold;
}
.Estilo3 {
	color: #333333;
	font-weight: bold;
}

</style>
</head>
<body>
<?php $sql="SELECT invtot,provee FROM ordmae where invnum = '$ord_compra'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invtot = $row[0];
	$provee = $row[1];
}
	$sql1="SELECT despro FROM proveedor where codpro = '$provee'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$proveedor = $row1[0];
	}
	}
}
else
{
$invtot = "0.00";
}
$sql="SELECT sum(canpro) FROM ordmov where invnum = '$ord_compra'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$sumcan = $row[0];
}
}
if ($sumcan == "")
{
$sumcan = 0;
}
?>
<table width="100%" border="0" bgcolor="#FFFFCC">
  <tr>
    <td><table width="100%" border="0" align="center" bgcolor="#FFFFCC">
      <tr>
        <td width="100" valign="bottom" class="text_combo_select"><strong>TOTAL PEDIDOS </strong></td>
        <td width="194" valign="bottom"><span class="Estilo2"><b><?php echo $sumcan?> CAJAS</b></span></td>
		<td width="407" valign="bottom"><span class="Estilo3"><?php echo $proveedor?></span></td>
		<td width="81" valign="bottom" class="text_combo_select"><div align="right"><strong>MONTO TOTAL </strong></div></td>
        <td width="65" valign="bottom"><div align="right" class="Estilo1"><b><?php echo $invtot?></b></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
