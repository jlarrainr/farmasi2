<?php
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../session_user.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
if (isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])) {
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);


	$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {

			$sucursal    = $row['codloc'];
		}
	}
	//**CONFIGPRECIOS_PRODUCTO**//
	$nomlocalG = "";
	$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
	$resultLocal = mysqli_query($conexion, $sqlLocal);
	if (mysqli_num_rows($resultLocal)) {
		while ($rowLocal = mysqli_fetch_array($resultLocal)) {
			$nomlocalG = $rowLocal['nomloc'];
		}
	}


	$numero_xcompa = substr($nomlocalG, 5, 2);
	$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

	$sql = "SELECT limite FROM datagen_det";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$limit             = $row["limite"];
		}
	}
	if ($limit == 0) {
		$limit = 1050;
	}

	$healthy=array("ñ","Ñ");
    $yummy =array("&ntilde;","&Ntilde;" );


    $limpiacadena = str_replace($healthy, $yummy, $letters);


	$t = is_numeric($limpiacadena);
	if ($t == 0) {
		$caracter = "*";
		if (strpos($limpiacadena, $caracter) !== false) {
			$res = mysqli_query($conexion, "select codpro,desprod,codmar,$tabla,factor from producto where ((codpro like '" . $limpiacadena . "%') or (codbar like '" . $limpiacadena . "%'))  and eliminado='0' order by desprod limit $limit") or die(mysqli_error());
		} else {
			$res = mysqli_query($conexion, "select codpro,desprod,codmar,$tabla,factor from producto where ((desprod like '" . $limpiacadena . "%') or (codbar like '" . $limpiacadena . "%')) and eliminado='0' order by desprod limit $limit") or die(mysqli_error());
		}
	} else {
		$res = mysqli_query($conexion, "select codpro,desprod,codmar,$tabla,factor from producto where ((codpro like '" . $limpiacadena . "%')  or (codbar like '" . $limpiacadena . "%')) and eliminado='0' order by desprod limit $limit") or die(mysqli_error());
	}
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while ($inf = mysqli_fetch_array($res)) {
		$codpro  = $inf["codpro"];
		$desprod = $inf["desprod"];
		$marca   = $inf['codmar'];
		$tabla_local   = $inf[3];
		$factor   = $inf['factor'];


		$stock2 = stockcaja($tabla_local, $factor);
		$sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$destab = $row1['destab'];
				$destab = substr($destab, 0, 35);
			}
		}
		$cad = $codpro . "<b> - </b>" . $desprod  . "<b> LAB - </b>" . $destab . "<b> STOCK = </b>" . $stock2 . "|";
		echo $inf["codpro"] . "###" . $cad;
	}
}
