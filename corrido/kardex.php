<?php require_once('conexion.php');
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
$sql="SELECT codpro FROM kardex group by codpro order by codpro";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$codpro    = $row['codpro'];
		$cant_act   = 0;
		$sql1="SELECT codkard,tipmov,tipdoc,qtypro,fraccion,factor FROM kardex where codpro = '$codpro' order by fecha,codkard";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$tipmov    = $row1['tipmov'];
			$tipdoc    = $row1['tipdoc'];
			$qtypro    = $row1['qtypro'];
			$fraccion  = $row1['fraccion'];
			$factor    = $row1['factor'];
			$codkard   = $row1['codkard'];
			if ($factor == 0)
			{
			$factor = 1;
			}
			if ($qtypro <> '')
			{
				$cant  = $qtypro * $factor;
			}
			if ($fraccion <> '')
			{
				$cant  = convertir_a_numero($fraccion);
			}
			if ($tipmov == 1)
			{
				$signo = 'mas';
			}
			if ($tipmov == 2)
			{
				$signo = 'menos';
			}
			if (($tipmov == 9) && ($tipdoc == 9))
			{
				$signo = 'menos';
			}
			if (($tipmov == 10) && ($tipdoc == 9))
			{
				$signo = 'mas';
			}
			if (($tipmov == 10) && ($tipdoc == 10))
			{
				$signo = 'menos';
			}
			if (($tipmov == 11) && ($tipdoc == 11))
			{
				$signo = 'mas';
			}
			if (($tipmov == 9) && ($tipdoc == 11))
			{
				$signo = 'menos';
			}
			mysqli_query($conexion,"update kardex set sactual = '$cant_act' where codkard = '$codkard'");
			if ($signo == 'mas')
			{
			$cant_act = $cant_act + $cant;
			}
			else
			{
			$cant_act = $cant_act - $cant;
			}
		}
		}
}
}
?>