<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$codloc	 = $_REQUEST['codloc'];
$codpro	 = $_REQUEST['codpro'];
$minim	 = $_REQUEST['minim'];
$marca	 = $_REQUEST['marca'];
$cr  	 = $_REQUEST['cr'];
$ccr  	 = $_REQUEST['ccr'];
$sql1="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$nomloc     = $row1['nomloc'];
}
}
		if ($nomloc == 'LOCAL0')
		{
		$campo = 'm00';
		}
		if ($nomloc == 'LOCAL1')
		{
		$campo = 'm01';
		}
		if ($nomloc == 'LOCAL2')
		{
		$campo = 'm02';
		}
		if ($nomloc == 'LOCAL3')
		{
		$campo = 'm03';
		}
		if ($nomloc == 'LOCAL4')
		{
		$campo = 'm04';
		}
		if ($nomloc == 'LOCAL5')
		{
		$campo = 'm05';
		}
		if ($nomloc == 'LOCAL6')
		{
		$campo = 'm06';
		}
		if ($nomloc == 'LOCAL7')
		{
		$campo = 'm07';
		}
		if ($nomloc == 'LOCAL8')
		{
		$campo = 'm08';
		}
		if ($nomloc == 'LOCAL9')
		{
		$campo = 'm09';
		}
		if ($nomloc == 'LOCAL10')
		{
		$campo = 'm10';
		}
		if ($nomloc == 'LOCAL11')
		{
		$campo = 'm11';
		}
		if ($nomloc == 'LOCAL12')
		{
		$campo = 'm12';
		}
		if ($nomloc == 'LOCAL13')
		{
		$campo = 'm13';
		}
		if ($nomloc == 'LOCAL14')
		{
		$campo = 'm14';
		}
		if ($nomloc == 'LOCAL15')
		{
		$campo = 'm15';
		}
		if ($nomloc == 'LOCAL16')
		{
		$campo = 'm16';
		}
		if ($cr <> 17)
		{
		$cr++;
		}
		else
		{
		$cr = 1;
		}
		mysqli_query($conexion,"UPDATE producto set $campo = '$minim' where codpro = '$codpro'");
header("Location: stockmin3.php?codpro=$codpro&country_ID=$marca&cr=$cr&ccr=$ccr&val=1");
?>
