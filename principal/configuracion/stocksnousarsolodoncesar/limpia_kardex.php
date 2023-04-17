<?php
require_once('../../../conexion.php');
require_once('locales.php');
/*
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
$sql="select codpro,sucursal from kardex group by codpro,sucursal order by codpro";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro     = $row['codpro'];
	$sucursal   = $row['sucursal'];
	$sql1="SELECT nomloc FROM xcompa where codloc = '$sucursal'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$nomloc    = $row1['nomloc'];}}
	$tabla = locals($nomloc);
	$saldoactual = 0;
	$tipmov = 0;
	$tipdoc = 0;
	$qtypro = 0;
	$fraccion = 0;
	$factor = 0;
	$car    = 0;
	$sql1="select tipmov,tipdoc,qtypro,fraccion,factor,sactual from kardex where codpro = '$codpro' and sucursal = '$sucursal' order by fecha,codkard";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$tipmov    = $row1['tipmov'];
			$tipdoc    = $row1['tipdoc'];
			$qtypro    = $row1['qtypro'];
			$fraccion  = $row1['fraccion'];
			$factor    = $row1['factor'];
			$sactual   = $row1['sactual'];
			$car	   = 0;
			$sig       = "";
			if ($tipmov == 1)
			{
				$sig   = 'mas';
			}
			if ($tipmov == 2)
			{
				$sig   = 'menos';
			}
			if (($tipmov == 9) && ($tipdoc == 9))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 10) && ($tipdoc == 9))
			{
				$sig   = 'mas';
			}
			if (($tipmov == 10) && ($tipdoc == 10))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 11) && ($tipdoc == 11))
			{
				$sig   = 'mas';
			}
			if (($tipmov == 9) && ($tipdoc == 11))
			{
				$sig   	 = 'menos';
			}
			if ($factor == 1)
			{
				if ($qtypro <> "")
				{
					$cant      = $qtypro;
					$descuenta = $cant * $factor;
					$car	   = $descuenta;
				}
				if ($fraccion <> "")
				{
					$cant      = convertir_a_numero($fraccion);
					$descuenta = $cant;
					$car	   = $descuenta;
				}
			}
			else
			{
				if ($qtypro <> "")
				{
					$cant      = $qtypro;
					$descuenta = $cant * $factor;
					$car	   = $descuenta;
				}
				if ($fraccion <> "")
				{
					$cant      = convertir_a_numero($fraccion);
					$descuenta = $cant;
					$car	   = $descuenta;
				}
			}
			if ($sig == 'mas')
			{
			$saldoactual = $car + $saldoactual;
			}
			else
			{
			$saldoactual = $saldoactual - $car;
			}
		}
		}
		mysqli_query($conexion,"UPDATE producto set $tabla = '$saldoactual' where codpro = '$codpro'");
}
}
$sql="select codpro from kardex group by codpro order by codpro";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro     = $row['codpro'];
	$stockpro   = 0;
	$s000		= 0;
	$s001		= 0;
	$s002		= 0;
	$s003		= 0;
	$s004		= 0;
	$s005		= 0;
	$s006		= 0;
	$s007		= 0;
	$s008		= 0;
	$s009		= 0;
	$s010		= 0;
	$s011		= 0;
	$s012		= 0;
	$s013		= 0;
	$s014		= 0;
	$s015		= 0;
	$s016		= 0;
	$sql1="SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where codpro = '$codpro'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	$s000 = 0;
	$s001 = 0;
	$s002 = 0;
	$s003 = 0;
	$s004 = 0;
	$s005 = 0;
	$s006 = 0;
	$s007 = 0;
	$s008 = 0;
	$s009 = 0;
	$s010 = 0;
	$s011 = 0;
	$s012 = 0;
	$s013 = 0;
	$s014 = 0;
	$s015 = 0;
	$s016 = 0;
		$s000    = $row1['s000'];
		$s001    = $row1['s001'];
		$s002    = $row1['s002'];
		$s003    = $row1['s003'];
		$s004    = $row1['s004'];
		$s005    = $row1['s005'];
		$s006    = $row1['s006'];
		$s007    = $row1['s007'];
		$s008    = $row1['s008'];
		$s009    = $row1['s009'];
		$s010    = $row1['s010'];
		$s011    = $row1['s011'];
		$s012    = $row1['s012'];
		$s013    = $row1['s013'];
		$s014    = $row1['s014'];
		$s015    = $row1['s015'];
		$s016    = $row1['s016'];
		$stockpro = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016;
		mysqli_query($conexion,"UPDATE producto set stopro = '$stockpro' where codpro = '$codpro'");
	}}
}}
*/
$sql1="SELECT codpro FROM producto order by codpro";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codpro  = $row1['codpro'];
	$local   = 0;
	mysqli_query($conexion,"UPDATE producto set stopro = '$local', s000 = '$local', s001 = '$local', s002 = '$local', s003 = '$local', s004 = '$local', s005 = '$local', s006 = '$local', s007 = '$local', s008 = '$local', s009 = '$local', s010 = '$local', s011 = '$local', s012 = '$local', s013 = '$local', s014 = '$local', s015 = '$local', s016 = '$local' where codpro = '$codpro'");
}}
header("Location: master1.php");
?>