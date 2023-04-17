<?php require_once("../../conexion.php");
$cod	= $_REQUEST['cod'];
$sql="SELECT descli FROM cliente where codcli = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
$i++;
$desc                 = $row["descli"];
}
}
else
{
$desc = "CLIENTE NO ENCONTRADO";
}
echo $desc;
?>