<?php
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../session_user.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
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
		$limit = 1050;
	}
	$res = mysqli_query($conexion, "select codpro,despro,rucpro from proveedor where ((despro like '" . $letters . "%') or (rucpro like '" . $letters . "%')) limit $limit") or die(mysqli_error());
	while ($inf = mysqli_fetch_array($res)) {
	 
		echo $inf["codpro"] . "###" . 'RUC:'.$inf["rucpro"] .' PROVEEDOR:'. $inf["despro"] . "|";
	}
}
