<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$ok  	 = $_REQUEST['ok'];
$codtemp = $_POST['codtemp'];
if ($cod <> ""){
mysqli_query($conexion,"DELETE from tempmovmov where codtemp = '$cod'");
}
if ($codtemp <> ""){
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
$sql="SELECT stopro FROM producto inner join tempmovmov on producto.codpro = tempmovmov.codpro where codtemp = '$codtemp'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$stopro          = $row["stopro"];		//codigo
		$tmargene        = $row["tmargene"];		//codigo
		$tprevta         = $row["tprevta"];		//codigo
}
}
if ($number == 0)
{
/////HALLAR NUEVO COSTO PROMEDIO
$promedio = ((($stopro/$factor) * $costpr)+($text1*$text6))/(($stopro/$factor)+$text1);
}
else
{
	function convertir_a_numero($str)
	{
	  $legalChars = "%[^0-9\-\. ]%";
	
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
	}
$text_char =  convertir_a_numero($text1);
$promedio = ((($stopro/$factor) * $costpr)+(($text_char/$factor)*$text6))/(($stopro/$factor)+($text_char/$factor));
}
if ($number == 0)
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', prisal = '$text2', desc1 = '$text3', desc2 = '$text4', desc3 = '$text5', pripro = '$text6', costre = '$text7',costpr= '$promedio' where codtemp = '$codtemp'");
}
else
{
mysqli_query($conexion,"UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', prisal = '$text2', desc1 = '$text3', desc2 = '$text4', desc3 = '$text5', pripro = '$text6', costre = '$text7',costpr= '$promedio' where codtemp = '$codtemp'");
}
}
header("Location: compras1.php?ok=0"); 
?>