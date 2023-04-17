<?php $sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}
$sql="SELECT cuscod FROM venta where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$cuscod    = $row['cuscod'];
}
}
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nombre_cliente    = $row['descli'];
}
}
if ($nomloc == "LOCAL0")
{
	$tabla = 's000';
}
if ($nomloc == "LOCAL1")
{
	$tabla = 's001';
}
if ($nomloc == "LOCAL2")
{
	$tabla = 's002';
}
if ($nomloc == "LOCAL3")
{
	$tabla = 's003';
}
if ($nomloc == "LOCAL4")
{
	$tabla = 's004';
}
if ($nomloc == "LOCAL5")
{
	$tabla = 's005';
}
if ($nomloc == "LOCAL6")
{
	$tabla = 's006';
}
if ($nomloc == "LOCAL7")
{
	$tabla = 's007';
}
if ($nomloc == "LOCAL8")
{
	$tabla = 's008';
}
if ($nomloc == "LOCAL9")
{
	$tabla = 's009';
}
if ($nomloc == "LOCAL10")
{
	$tabla = 's010';
}
if ($nomloc == "LOCAL11")
{
	$tabla = 's011';
}
if ($nomloc == "LOCAL12")
{
	$tabla = 's012';
}
if ($nomloc == "LOCAL13")
{
	$tabla = 's013';
}
if ($nomloc == "LOCAL14")
{
	$tabla = 's014';
}
if ($nomloc == "LOCAL15")
{
	$tabla = 's015';
}
if ($nomloc == "LOCAL16")
{
	$tabla = 's016';
}
?>