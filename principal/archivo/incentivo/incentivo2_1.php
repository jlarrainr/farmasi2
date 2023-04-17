<?php include('../../session_user.php');
require_once('../../../conexion.php');
$val     = $_REQUEST['val'];
$p1      = $_REQUEST['p1'];
$ord     = $_REQUEST['ord'];
$codpro  = $_REQUEST['codpro'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
$sql="SELECT invnum FROM incentivado where estado = '1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invnum    = $row["invnum"];
}
}
mysqli_query($conexion,"UPDATE incentivadodet set estado = '1' where codpro = '$codpro' and invnum = '$invnum'");
mysqli_query($conexion,"UPDATE producto set incentivado = '1' where codpro = '$codpro'");
header("Location: incentivo3.php?cod=$codpro&p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&valform=1");
?>