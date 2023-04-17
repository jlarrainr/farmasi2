<?php include('../../session_user.php');
require_once('../../../conexion.php');
$ckigv      = $_REQUEST['ckigv'];
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$ok  	 = $_REQUEST['ok'];
$busca_prov	 = $_REQUEST['busca_prov'];
$codtemp = $_REQUEST['codtemp'];
if ($cod <> "") {

/*

	$sql = "SELECT  invnum where codtemp = '$codtemp' and tipbon ";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$invnum          = $row[0];		//codigo
		}
	}
*/
	mysqli_query($conexion, "DELETE from tempmovmov where codtemp = '$cod'");
	
	
	
	mysqli_query($conexion, "DELETE from tempmovmov_bonif where codtemp = '$cod'");
	mysqli_query($conexion, "DELETE from templote where codtemp = '$cod'  ");
}
if ($codtemp <> "") {
	$text1 = $_POST['text1'];	///cantidad ingresada
	$text2 = $_POST['text2'];	///precio sin descuentos y sin igv
	$text3 = $_POST['text3'];	///descuento1
	$text4 = $_POST['text4'];	///descuento2
	$text5 = $_POST['text5'];	///descuento3
	$text6 = $_POST['text6'];	///nuevo precio	
	$text7 = $_POST['text7'];	///total por item
	$costpr = $_POST['costpr']; ///costo promedio antiguo
	$stopro = $_POST['stockpro']; ///stock antiguo
	$factor = $_POST['factor']; ///factor
	$number = $_POST['number']; ///factor
	$number2 = $_POST['number2']; ///factor

	if ($number == "") {
		$number = $number2;
	}

	$sql = "SELECT s000+s001+s002+s003+S004+s005+s006+s007+s008+s009 as stoctal FROM producto inner join tempmovmov on producto.codpro = tempmovmov.codpro where codtemp = '$codtemp'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$stopro2          = $row["stoctal"];		//codigo
			$tmargene        = $row["tmargene"];		//codigo
			$tprevta         = $row["tprevta"];		//codigo
		}
	}
	if ($number == 0) {
		/////HALLAR NUEVO COSTO PROMEDIO
		$promedio = ((($stopro2 / $factor) * $costpr) + ($text1 * $text6)) / (($stopro2 / $factor) + $text1);
	} else {
		function convertir_a_numero($str)
		{
			$legalChars = "%[^0-9\-\. ]%";

			$str = preg_replace($legalChars, "", $str);
			return $str;
		}
		$text_char =  convertir_a_numero($text1);
		$promedio = (($stopro2 * $costpr) + ($text_char * $text6)) / ($stopro2 + $text_char);
	}
	if ($number == 0) {
		mysqli_query($conexion, "UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', prisal = '$text2', desc1 = '$text3', desc2 = '$text4', desc3 = '$text5', pripro = '$text6', costre = '$text7',costpr= '$promedio' where codtemp = '$codtemp'");
	} else {
		mysqli_query($conexion, "UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', prisal = '$text2', desc1 = '$text3', desc2 = '$text4', desc3 = '$text5', pripro = '$text6', costre = '$text7',costpr= '$promedio' where codtemp = '$codtemp'");
	}
}
header("Location: compras1.php?ok=4&busca_prov=$busca_prov&ckigv=$ckigv");
