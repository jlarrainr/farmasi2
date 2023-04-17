<?php require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../session_user.php');
$search  = $_SESSION['search'];
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])){
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$limit = 15;
	if (($search == 1) || ($search == ""))
	{
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,preuni,factor,incentivado from producto where desprod like '".$letters."%' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$desprod = $inf['desprod'];
			$marca   = $inf['codmar'];
			$preuni  = $inf['preuni'];
			$factor  = $inf['factor'];
			$incent  = $inf['incentivado'];
			$desprod = substr($desprod,0,55);
			$pcaja   = $preuni * $factor;
			$sql1="SELECT destab FROM titultabladet where codtab = '$marca'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
					$destab = $row1['destab'];
					$destab = substr($destab,0,35);
			}
			}
			if ($incent == 1)
			{
			$cad = "<font color='#669900'>".$desprod."<u><b> MARCA = </b>".$destab."..."."<b>  PRECIO CAJA = </b>".$pcaja."<b>  PRECIO UNITARIO = </b>".$preuni." <b>INCENTIVADO</b></u></font>"."|";
			}
			else
			{
			$cad = $desprod."<u><b> MARCA = </b>".$destab."..."."<b>  PRECIO CAJA = </b>".$pcaja."<b>  PRECIO UNITARIO = </b>".$preuni." </u>"."|";
			}
			echo $inf['codpro']."###".$cad;
		}
	}
	if ($search == 2)	//FAMILIA
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '".$letters."%' and tiptab = 'F' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$destab   = $inf['destab'];
			$cad = $destab."|";
			echo $inf['codtab']."###".$cad;
		}
	}
	if ($search == 3)	//USO DE PRODUCTOS
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '".$letters."%' and tiptab = 'U' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$destab   = $inf['destab'];
			$cad = $destab."|";
			echo $inf['codtab']."###".$cad;
		}
	}
	if ($search == 4)	//MARCAS
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '".$letters."%' and tiptab = 'M' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			echo $inf['codtab']."###".$inf['destab']."|";
		}
	}
	if ($search == 5)	//CODIGO DE PRODUCTOS
	{
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,preuni,factor,incentivado from producto where codpro like '".$letters."%' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$desprod = $inf['desprod'];
			$marca   = $inf['codmar'];
			$preuni  = $inf['preuni'];
			$factor  = $inf['factor'];
			$incent  = $inf['incentivado'];
			$desprod = substr($desprod,0,55);
			$pcaja   = $preuni * $factor;
			$sql1="SELECT destab FROM titultabladet where codtab = '$marca'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
					$destab = $row1['destab'];
					$destab = substr($destab,0,35);
			}
			}
			if ($incent == 1)
			{
			$cad = "<font color='#669900'>".$desprod."<u><b> MARCA = </b>".$destab."..."."<b>  PRECIO CAJA = </b>".$pcaja."<b>  PRECIO UNITARIO = </b>".$preuni." <b>INCENTIVADO</b></u></font>"."|";
			}
			else
			{
			$cad = $desprod."<u><b> MARCA = </b>".$destab."..."."<b>  PRECIO CAJA = </b>".$pcaja."<b>  PRECIO UNITARIO = </b>".$preuni." </u>"."|";
			}
			echo $inf['codpro']."###".$cad;
		}
	}
	if ($search == 6)	//POR PRESENTACION
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '".$letters."%' and tiptab = 'PRES' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$destab   = $inf['destab'];
			$cad = $destab."|";
			echo $inf['codtab']."###".$cad;
		}
	}
}
?>
