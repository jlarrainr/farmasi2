<?php include('../../session_user.php');
$invnum  = $_SESSION['compraspreg'];
$ok  	 = $_REQUEST['ok'];
require_once ('../../../conexion.php');
$codtemp      = $_REQUEST['codtemp'];
$codprobon    = $_REQUEST['codprobon'];			/////PRODUCTO DE ORIGEN ----> DISKETTE
$country_ID   = $_REQUEST['country_ID'];		/////PRODUCTO QUE PUEDE SER POR OTRO  -----> LAPICERO
$bonif_can    = $_REQUEST['bonif_can'];	
$tipbonif     = $_REQUEST['tipbonif'];	
$numero       = $_REQUEST['nnum'];	
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}	
///////////////////////////////////////////PORCENTAJES
$sql="SELECT porcent FROM datagen";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$porcent    = $row['porcent'];
}
}
///////////////////////////////////////////
if ($country_ID == "")
{
$codpro = $codprobon;
}
else
{
$codpro = $country_ID;
}
if ($numero == 1)					////ESTOY INGRESANDO CAJAS CON LA LETRA U
{		
	/////FUNCION PARA CONVERTIR NUMERO
	$bonif_can	= convertir_a_numero($bonif_can);
	$letra		= "U";
}
else
{
	$letra		= "C";
}
//////////////////////////////////////////////DATOS DE LA TABLA TEMPORAL
$sqlq="SELECT * FROM tempmovmov where codpro = '$codprobon' and codtemp = '$codtemp' and invnum = '$invnum'";
$resultq = mysqli_query($conexion,$sqlq);
if (mysqli_num_rows($resultq)){
while ($rowq = mysqli_fetch_array($resultq)){
		$qtypro    = $rowq['qtypro'];
		$qtyprf    = $rowq['qtyprf'];
		$pripro    = $rowq['pripro'];	//precio incluyendo el descuento e igv
		$desc1     = $rowq['desc1'];
		$desc2     = $rowq['desc2'];
		$desc3     = $rowq['desc3'];
}	
}
////////////////////////////////////////////FACTOR DEL PRODUCTO A BONIFICAR
$sqlq="SELECT factor FROM producto where codpro = '$codprobon'";
$resultq = mysqli_query($conexion,$sqlq);
if (mysqli_num_rows($resultq)){
while ($rowq = mysqli_fetch_array($resultq)){
		$factor    = $rowq['factor'];
}
}
////////////////////////////////////////////OBTENGO LAS CANTIDADES UNITARIAS COMPRADAS
if ($qtyprf <> "")
{
	$text_char = convertir_a_numero($qtyprf);
	$cant_unid = $text_char;
}
else
{
	$cant_unid = $qtypro * $factor;

}
////////////////////////////////////////////CASO= SE BONIFICA POR EL MISMO PRODUCTO CON CAJAS
if ($letra == "C")
{
	if ($codpro == $codprobon)
	{
	/*$precio_real = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)))/($cant_unid + $bonif_can);*/
	$pru         = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)));
	$pru1		 = ($cant_unid + $bonif_can);
	$precio_real = ($pru/$pru1);
	}
	////////////////////////////////////////////CASO = SE BONIFICA CON OTRO PRODUCTO CON CAJAS
	if ($codpro <> $codprobon)
	{
		$sqlq="SELECT costre FROM producto where codpro = '$codpro'";
		$resultq = mysqli_query($conexion,$sqlq);
		if (mysqli_num_rows($resultq)){
		while ($rowq = mysqli_fetch_array($resultq)){
				$costre    = $rowq['costre'];
		}
		}
	$pru         = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)));
	$pru1		 = ($bonif_can * $costre);
	$pru2		 = $cant_unid;
	$precio_real = ($pru - $pru1)/$pru2;
	/*$precio_real = (($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)))) - ($bonif_can * $costre)/($cant_unid);*/
	}
}
if ($letra == "U")
{
		$sqlq="SELECT costre FROM producto where codpro = '$codpro'";
		$resultq = mysqli_query($conexion,$sqlq);
		if (mysqli_num_rows($resultq)){
		while ($rowq = mysqli_fetch_array($resultq)){
				$costre    = $rowq['costre'];
		}
		}
	$pru         = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)));
	$pru1		 = ($bonif_can * $costre);
	$pru2		 = $cant_unid;
	$precio_real = ($pru - $pru1)/$pru2;
	//$precio_real = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100))) - ($bonif_can * $costre)/($cant_unid);
	/*echo $pru;
	echo '<br>';
	echo $pru1;
	echo '<br>';
	echo $pru2;
	echo '<br>';
	echo $precio_real;
	echo '<br>';
	echo $cant_unid;
	echo '<br>';
	echo $pripro;
	echo '<br>';
	echo $desc1;
	echo '<br>';
	echo $desc2;
	echo '<br>';
	echo $desc3;
	echo '<br>';
	echo $porcent;
	echo '<br>';
	echo $bonif_can;
	echo '<br>';
	echo $costre;
	echo '<br>';
	echo $cant_unid;
	echo '<br>';
	*/
}
///////////////////////////////////////////////////////////////////////
$precio_real  = number_format($precio_real,2,'.',',');
mysqli_query($conexion,"DELETE FROM tempmovmov_bonif where invnum = '$invnum' and codtemp = '$codtemp'");
$sqlq="SELECT * FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$invnum' and codpro = '$codpro'";
$resultq = mysqli_query($conexion,$sqlq);
if (mysqli_num_rows($resultq)){
mysqli_query($conexion,"UPDATE tempmovmov_bonif set codpro= '$codpro',codprobon= '$codprobon', canbon = '$bonif_can', tipbon= '$letra', costo_real = '$precio_real' where codtemp = '$codtemp' and invnum = '$invnum'");
}
else
{
mysqli_query($conexion,"INSERT INTO tempmovmov_bonif (invnum,codtemp,codpro,codprobon,canbon,tipbon,costo_real) values ('$invnum','$codtemp','$codpro','$codprobon','$bonif_can','$letra','$precio_real')");
}
////////////////////////////////////////////
header("Location: compras3.php?ok=1"); 
?>