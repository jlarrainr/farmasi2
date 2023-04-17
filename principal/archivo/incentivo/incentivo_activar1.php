<?php include('../../session_user.php');
require_once('../../../conexion.php');
$desc 	 = $_REQUEST['desc'];
$date1	 = $_REQUEST['date1'];
$date2	 = $_REQUEST['date2'];
$estado	 = $_REQUEST['estado'];
//echo $estado;
$sql="SELECT invnum FROM incentivado order by invnum desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invnum    = $row["invnum"];
	$invnum++;
}
}
else
{
$invnum = 1;
}
/*
if ($estado == 1)
{
mysqli_query($conexion,"UPDATE incentivado set estado = '0' where estado = '1'");
mysqli_query($conexion,"UPDATE incentivadodet set estado = '0' where estado = '1'");
}
mysqli_query($conexion,"INSERT INTO incentivado (invnum,dateini,datefin,estado,descripcion) values ('$invnum','$date1','$date2','$estado','$desc')");
*/
mysqli_query($conexion,"INSERT INTO incentivado (invnum,dateini,datefin,estado,descripcion) values ('$invnum','$date1','$date2','$estado','$desc')");
header("Location: incentivo1.php?p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros");
?>