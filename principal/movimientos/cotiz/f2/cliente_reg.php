<?php include('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once ('../../../../conexion.php');
$nom     = $_REQUEST['nom'];
$dni	 = $_REQUEST['dni'];
$ruc	 = $_REQUEST['ruc'];
$fono	 = $_REQUEST['fono'];
$fono1	 = $_REQUEST['fono1'];
$mail	 = $_REQUEST['mail'];
$sql1="SELECT codcli FROM cliente order by codcli desc limit 1";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codcli    = $row1['codcli'];
}
$codcli++;
}
else
{
$codcli = 1;
}
mysqli_query($conexion, "INSERT INTO cliente (codcli,descli,dnicli,ruccli,telcli,telcli1,email,codusu) values ('$codcli','$nom','$dni','$ruc','$fono','$fono1','$mail','$usuario')");
//$sql="SELECT codcli,descli FROM cliente where descli = '$nom'";
//$result = mysqli_query($conexion,$sql);
/*if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codcli         = $row["codcli"];
	$descli         = $row["descli"];
	mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
	mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
}
}
*/
mysqli_query($conexion, "UPDATE cotizacion set cuscod = '$codcli' where invnum = '$venta'");
	mysqli_query($conexion, "UPDATE cotizacion_det set cuscod = '$codcli' where invnum = '$venta'");
//echo $codcli;
//echo "<br>";
//echo $venta;
header("Location: f2.php?close=2");
?>