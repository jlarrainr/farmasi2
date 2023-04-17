<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
$search  = $_SESSION['searchcot'];
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])){
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql="SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
		 $limit             = $row["limite"];
    }
	}
	if ($limit == 0)
	{
	$limit = 50;
	}
	$res = mysqli_query($conexion,"select codpro,desprod,codmar,preuni,factor,incentivado from producto where desprod like '".$letters."%' limit $limit") or die(mysqli_error());
	while($inf = mysqli_fetch_array($res))
	{
		$desprod = $inf["desprod"];
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
		echo $inf["codpro"]."###".$cad;
	}
}
?>
