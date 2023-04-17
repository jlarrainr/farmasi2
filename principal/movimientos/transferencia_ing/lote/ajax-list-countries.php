<?php require_once ('../../../../conexion.php');	//CONEXION A BASE DE DATOS
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])){
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysqli_query($conexion, "select numlote from movlote where numlote like '$letters%' limit 1") or die(mysqli_error());
	if (mysqli_num_rows($res)){
		while($inf = mysqli_fetch_array($res)){
			echo $inf["numlote"]."###".$inf["numlote"]."|";
		}	
	}
}
?>
