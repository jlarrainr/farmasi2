<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
$codpro       = $_REQUEST['codpro'];
$cr           = $_REQUEST['cr'];
$codmar       = $_REQUEST['codmar'];
$price        = $_REQUEST['price'];
$dcto1        = $_REQUEST['dcto1'];
$dcto2        = $_REQUEST['dcto2'];
$dcto3        = $_REQUEST['dcto3'];
$pedido       = $_REQUEST['pedido'];
$tots_dcto    = $_REQUEST['tots_dcto'];
$montos       = $_REQUEST['montos'];
$canbon       = $_REQUEST['bonif'];
$numero       = $_REQUEST['numero'];
$pfinal       = $_REQUEST['pfinal'];
$sql1="SELECT factor,blister FROM producto where codpro= '$codpro'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$factor     = $row1[0];
$blister     = $row1[1];
}
}
if (($blister == 0) or ($blister == 1))
{
$tipcanpro = 1;
}
else
{
$tipcanpro = 0;
}
if ($canbon <> "")
{
	if ($numero == 1)					////ESTOY INGRESANDO CAJAS CON LA LETRA U
	{
		function convertir_a_numero($str)
		{
		  $legalChars = "%[^0-9\-\. ]%";
		
		  $str=preg_replace($legalChars,"",$str);
		  return $str;
		}							/////FUNCION PARA CONVERTIR NUMERO
		$canbon		= convertir_a_numero($canbon);
		$letra		= "U";
	}
	else
	{
		if ($bonif <> 0)
		{
		$letra		= "C";
		}
	}
}
$sql1="SELECT codpro,invnum FROM ordmov where invnum= '$ord_compra' and codpro = '$codpro'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1))
{
mysqli_query($conexion,"UPDATE ordmov set canpro='$pedido',desc1='$dcto1',desc2='$dcto2',desc3='$dcto3',precio_ref='$price',costod='$tots_dcto',mont_total='$montos',canbon = '$canbon',tipbon = '$letra',tipcanpro = '$tipcanpro', pfinal = '$pfinal' where invnum= '$ord_compra' and codpro = '$codpro'");
}
else
{
/*
echo "orden compra ".$ord_compra;
echo '<br>';
echo "marca ".$codmar;
echo '<br>';
echo "codigo prod ".$codpro;
echo '<br>';
echo 'pedido '.$pedido;
echo '<br>';
echo 'descto 1 '.$dcto1;
echo '<br>';
echo 'descto 2 '.$dcto2;
echo '<br>';
echo 'descto 3 '.$dcto3;
echo '<br>';
echo 'precio '.$price;
echo '<br>';
echo 'tot dscto '.$tots_dcto;
echo '<br>';
echo 'montos '.$montos;
echo '<br>';
echo 'canbon '.$canbon;
echo '<br>';
echo 'letra '.$letra;
echo '<br>';
echo 'factor '.$factor;
echo '<br>';
*/
mysqli_query($conexion,"INSERT INTO ordmov(invnum,codmar,codpro,canpro,desc1,desc2,desc3,precio_ref,costod,mont_total,canbon,tipbon,factor,tipcanpro,pfinal) values ('$ord_compra','$codmar','$codpro','$pedido','$dcto1','$dcto2','$dcto3','$price','$tots_dcto','$montos','$canbon','$letra','$factor','$tipcanpro','$pfinal')");
}
$sql1="SELECT sum(mont_total) FROM ordmov where invnum= '$ord_compra'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$sum     = $row1[0];
}
}
mysqli_query($conexion,"UPDATE ordmae set invtot = '$sum' where invnum = '$ord_compra'");
header("Location: productos.php?tip=2&val=0&cr=$cr");
?>