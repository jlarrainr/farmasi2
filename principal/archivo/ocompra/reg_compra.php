<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$sql1="SELECT valor FROM preing";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $valor        = $row1['valor'];
}
}
if ($valor == '')
{
$valor = 0;
}
$sql="SELECT invnum FROM ordmae where codusu = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		mysqli_query($conexion,"DELETE from ordmov where invnum = '$invnum'");
		mysqli_query($conexion,"DELETE from ordmae where invnum = '$invnum'");
		mysqli_query($conexion,"DELETE from temp_marca where invnum = '$invnum'");
}
}
$sql="SELECT nrocomp FROM ordmae order by nrocomp desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$nrocomp    = $row['nrocomp'];
		$nrocomp 	= $nrocomp + 1;
}
}
else
{
$nrocomp 	= 1;
}
//$hour   = date(G);
$date	= date('Y-m-d');
//$date	= CalculaFechaHora($hour);
mysqli_query($conexion,"INSERT INTO ordmae (nrocomp,invfec,codusu,estado,preingreso) values ('$nrocomp','$date','$usuario','1','$valor')");
header("Location: ocompra_index.php");
?>