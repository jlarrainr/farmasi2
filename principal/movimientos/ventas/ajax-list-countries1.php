<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../session_user.php');
$search  = $_SESSION['search'];
if (isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])) {
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "SELECT limite FROM datagen_det";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$limit             = $row["limite"];
		}
	}
	if ($limit == 0) {
		$limit = 50;
	}
	if (($search == 1) || ($search == "")) {
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,preuni,factor,incentivado,preblister from producto where desprod like '%" . $letters . "%' and activo = '1' limit $limit order by desprod") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			$desprod = $inf["desprod"];
			$marca   = $inf['codmar'];
			$preuni  = $inf['preuni'];
			$factor  = $inf['factor'];
			$incent  = $inf['incentivado'];
			$preblister  = $inf['preblister'];
			$desprod = substr($desprod, 0, 55);
			$pcaja   = $preuni * $factor;
			$sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$destab = $row1['destab'];
					$destab = substr($destab, 0, 35);
				}
			}
			if ($incent == 1) {
				$cad = "<font color='#669900'>" . $desprod . "<u><b> MARCA = </b>" . $destab . "..." . "<b>  PRECIO CAJA = </b>" . $pcaja . "<b>  PRECIO UNITARIO = </b>" . $preuni . " <b>INCENTIVADO</b><b>   PRECIO BLISTER</b>" . $preblister . "</u></font>" . "|";
			} else {
				$cad = $desprod . "<u><b> MARCA = </b>" . $destab . "..." . "<b>  PRECIO CAJA = </b>" . $pcaja . "<b>  PRECIO UNITARIO = </b>" . $preuni . " <b>  PRECIO BLISTER = </b>" . $preblister . "</u>" . "|";
			}
			echo $inf["codpro"] . "###" . $cad;
		}
	}
	if ($search == 2)	//FAMILIA
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '" . $letters . "%' and tiptab = 'F' limit $limit order by destab") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			$destab   = $inf['destab'];
			$cad = $destab . "|";
			echo $inf["codtab"] . "###" . $cad;
		}
	}
	if ($search == 3)	//USO DE PRODUCTOS
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '" . $letters . "%' and tiptab = 'U' limit $limit order by destab") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			$destab   = $inf['destab'];
			$cad = $destab . "|";
			echo $inf["codtab"] . "###" . $cad;
		}
	}
	if ($search == 4)	//MARCAS
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '" . $letters . "%' and tiptab = 'M' limit $limit order by destab") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			echo $inf["codtab"] . "###" . $inf["destab"] . "|";
		}
	}
	if ($search == 5)	//CODIGO DE PRODUCTOS
	{
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,preuni,factor,incentivado,preblister from producto where codpro like '" . $letters . "%' and activo = '1' limit $limit order by desprod") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			$desprod = $inf["desprod"];
			$marca   = $inf['codmar'];
			$preuni  = $inf['preuni'];
			$factor  = $inf['factor'];
			$incent  = $inf['incentivado'];
			$preblister  = $inf['preblister'];
			$desprod = substr($desprod, 0, 55);
			$pcaja   = $preuni * $factor;
			$sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$destab = $row1['destab'];
					$destab = substr($destab, 0, 35);
				}
			}
			if ($incent == 1) {
				$cad = "<font color='#669900'>" . $desprod . "<u><b> MARCA = </b>" . $destab . "..." . "<b>  PRECIO CAJA = </b>" . $pcaja . "<b>  PRECIO UNITARIO = </b>" . $preuni . " <b>INCENTIVADO</b><b>   PRECIO BLISTER</b>" . $preblister . "</u></font>" . "|";
			} else {
				$cad = $desprod . "<u><b> MARCA = </b>" . $destab . "..." . "<b>  PRECIO CAJA = </b>" . $pcaja . "<b>  PRECIO UNITARIO = </b>" . $preuni . " <b>  PRECIO BLISTER = </b>" . $preblister . "</u>" . "|";
			}
			echo $inf["codpro"] . "###" . $cad;
		}
	}
	if ($search == 6)	//POR PRESENTACION
	{
		$res = mysqli_query($conexion, "select codtab,destab from titultabladet where destab like '" . $letters . "%' and tiptab = 'PRES' limit $limit order by destab") or die(mysqli_error());
		while ($inf = mysqli_fetch_array($res)) {
			$destab   = $inf['destab'];
			$cad = $destab . "|";
			echo $inf["codtab"] . "###" . $cad;
		}
	}
}
