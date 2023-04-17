<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum  = $_SESSION['transferencia_sal_val'];
$cod	 = $_REQUEST['cod'];			////CODIGO DEL PRODUCTO EN EL LOCAL
$text1   = $_REQUEST['text1'];	///cantidad ingresada
$text2   = $_REQUEST['text2'];	///precio promedio
$text3   = $_REQUEST['text3'];	///total
$number  = $_REQUEST['number']; ///factor
$subtotal  = $_REQUEST['subtotal2']; ///factor

$sql="SELECT codtemp FROM tempmovmov order by codtemp desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codtemp       = $row[0];	
}	
$codtemp = $codtemp + 1;
}
else
{
$codtemp = 1;
}
if ($number == 0)
{
//mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");
mysqli_query($conexion,"INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr) values ('$invnum','$cod','$text1','$subtotal','$text3','$subtotal')");
}
else
{
//mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtyprf,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");
mysqli_query($conexion,"INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr) values ('$invnum','$cod','$text1','$subtotal','$text3','$subtotal')");
}
header("Location: salidas_varias1.php"); 
?>