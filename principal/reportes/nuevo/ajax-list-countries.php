<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])){
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	/*$sql="SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
		 $limit             = $row["limite"];
    }
	}
	*/
	//$res = mysqli_query($conexion,"select codpro,desprod from producto where desprod like '".$letters."%' limit $limit") or die(mysqli_error());
	$t = $letters/1;
	if($t == 0)
	{
		$caracter = "*";
		if (strpos($letters, $caracter) !== false) 
		{
		$res = mysqli_query($conexion,"select P.codpro,P.desprod,TD.destab from producto P inner join titultabladet TD on TD.codtab = P.codmar where P.codpro like '".$letters."%' and P.eliminado='0'") or die(mysqli_error());
		}
		else
		{
		$res = mysqli_query($conexion,"select P.codpro,P.desprod,TD.destab from producto P inner join titultabladet TD on TD.codtab = P.codmar where P.desprod like '".$letters."%' and P.eliminado='0'") or die(mysqli_error());
		}
	}
	else
	{
	$res = mysqli_query($conexion,"select P.codpro,P.desprod,TD.destab from producto P inner join titultabladet TD on TD.codtab = P.codmar where P.desprod like '".$letters."%' and P.eliminado='0'") or die(mysqli_error());
	}
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysqli_fetch_array($res)){
		echo $inf["codpro"]."###".$inf["desprod"].'-Marca: '.$inf["destab"]."|";
//                echo $inf["desprod"].'-Marca: '.$inf["destab"]."|";
//              echo $inf["desprod"].'-Marca: '.$inf["destab"]."|";
	}	
}
?>
