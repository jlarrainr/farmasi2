<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$sql="SELECT invnum FROM remesa where codusu = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		mysqli_query($conexion,"DELETE from remesa where invnum = '$invnum'");
		mysqli_query($conexion,"DELETE from gasres where invnum = '$invnum'");
}
}
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codloc    = $row['codloc'];
}
}
$hour   = date(G);
$date   = date("Y-m-d");
//$date	= CalculaFechaHora($hour);
$sql="SELECT numremesa FROM remesa order by numremesa desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$numremesa    = $row['numremesa'];
}
$numremesa = $numremesa + 1;
}
else
{
	$numremesa = 1;
}
//$hour   = CalculaHora($hour);
$min	= date(i);
$seg	= date(s);
if ($hour <= 12)
{
    $tim    = "am";
}
else
{
    $tim    = "pm";
}
$hora	= $hour.":".$min.":".$seg." ".$tim;
mysqli_query($conexion,"INSERT INTO remesa (numremesa,fecha,codusu,estado,sucursal,hora) values ('$numremesa','$date','$usuario','1','$codloc','$hora')");
header("Location: remesas.php");
?>