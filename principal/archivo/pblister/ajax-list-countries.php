<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
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



	$sql = "SELECT codloc from usuario WHERE usecod ='$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$local    = $row['codloc'];
		}
	}


	$sql = "SELECT nomloc FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nomloc    = $row['nomloc'];
		}
	}


	//echo $nomloc;
	if ($nomloc == "LOCAL0") {
		$columna = 's000';
	}
	if ($nomloc == "LOCAL1") {
		$columna = 's001';
	}
	if ($nomloc == "LOCAL2") {
		$columna = 's002';
	}
	if ($nomloc == "LOCAL3") {
		$columna = 's003';
	}
	if ($nomloc == "LOCAL4") {
		$columna = 's004';
	}
	if ($nomloc == "LOCAL5") {
		$columna = 's005';
	}
	if ($nomloc == "LOCAL6") {
		$columna = 's006';
	}
	if ($nomloc == "LOCAL7") {
		$columna = 's007';
	}
	if ($nomloc == "LOCAL8") {
		$columna = 's008';
	}
	if ($nomloc == "LOCAL9") {
		$columna = 's009';
	}
	if ($nomloc == "LOCAL10") {
		$columna = 's010';
	}
	if ($nomloc == "LOCAL11") {
		$columna = 's011';
	}
	if ($nomloc == "LOCAL12") {
		$columna = 's012';
	}
	if ($nomloc == "LOCAL13") {
		$columna = 's013';
	}
	if ($nomloc == "LOCAL14") {
		$columna = 's014';
	}
	if ($nomloc == "LOCAL15") {
		$columna = 's015';
	}
	if ($nomloc == "LOCAL16") {
		$columna = 's016';
	}
	if ($nomloc == "LOCAL17") {
		$columna = 's017';
	}
	if ($nomloc == "LOCAL18") {
		$columna = 's018';
	}
	if ($nomloc == "LOCAL19") {
		$columna = 's019';
	}
	if ($nomloc == "LOCAL20") {
		$columna = 's020';
	}

	if ($limit == 0) {
		$limit = 50;
	}
	$t = is_numeric($letters);
	if ($t == 0) {
		$caracter = "*";
		if (strpos($letters, $caracter) !== false) {
			$res = mysqli_query($conexion, "select codpro,desprod,codmar,$columna,factor from producto where ( codpro = '" . $letters . "' or codbar like '" . $letters . "' )  and eliminado = '0' order by desprod limit $limit") or die(mysqli_error());
		} else {
			$res = mysqli_query($conexion, "select codpro,desprod,codmar,$columna,factor from producto where desprod like '" . $letters . "%' and eliminado = '0'  order by desprod limit $limit") or die(mysqli_error());
		}
	} else {
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,$columna,factor from producto where (codpro = '" . $letters . "' or codbar like '" . $letters . "%') and eliminado = '0' order by desprod limit $limit") or die(mysqli_error());
	}
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while ($inf = mysqli_fetch_array($res)) {
		$codpro  = $inf["codpro"];
		$desprod = $inf["desprod"];
		$marca   = $inf['codmar'];
		$stockloc   = $inf[3];
		$factor   = $inf["factor"];
		$sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$destab = $row1['destab'];
				$destab = substr($destab, 0, 35);
			}
		}
		$stockloc = stockcaja($stockloc, $factor);

		//$cad = $codpro . " - <b>PROD = </b>" . $desprod . "..." . "<b>LAB = </b>" . $destab . "|";

		$cad = "<b>COD = </b>" . $codpro . " - <b>PROD = </b>" . $desprod . "..." . "<b>LAB = </b>" . $destab . " - <b>STOCK = </b>" . $stockloc . "|";
		echo $inf["codpro"] . "###" . $cad;
	}
}
