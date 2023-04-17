<?php include('../../session_user.php');
$invnum  = $_SESSION['ord_compra'];
require_once ('../../../conexion.php');
$codord       = $_REQUEST['codord'];
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
//////////////////////////////////////////////DATOS DE LA TABLA ORDMOV
$sqlq="SELECT * FROM ordmov where codpro = '$codprobon' and codord = '$codord' and invnum = '$invnum' and mont_total <> '0'";
$resultq = mysqli_query($conexion,$sqlq);
if (mysqli_num_rows($resultq)){
while ($rowq = mysqli_fetch_array($resultq)){
		$qtypro    = $rowq['canpro'];
		$pripro    = $rowq['costod'];	//precio incluyendo el descuento e igv
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
	$cant_unid = $qtypro;
////////////////////////////////////////////CASO= SE BONIFICA POR EL MISMO PRODUCTO CON CAJAS
if ($letra == "C")
{
	if ($codpro == $codprobon)
	{
	$pru         = ($cant_unid * $pripro * (1 - ($desc1/100)) * (1 - ($desc2 /100)) * (1 - ($desc3/100)) * (1 + ($porcent/100)));
	$pru1		 = ($cant_unid + $bonif_can);
	$precio_real = ($pru/$pru1);
	$precio_ordmov = $precio_real;
	$precio_ordmov = number_format($precio_ordmov,2,'.',',');
	$mont_tot	   = $precio_ordmov * $cant_unid;
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
	}
}
if ($letra == "U")
{
		//echo $codpro;
		//echo $codprobon;
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
	if ($codpro == $codprobon)
	{
	$precio_ordmov = $precio_real;
	$precio_ordmov = number_format($precio_ordmov,2,'.',',');
	$mont_tot	   = $precio_ordmov * $cant_unid;
	}
}
///////////////////////////////////////////////////////////////////////
$precio_real  = number_format($precio_real,2,'.',',');
//echo $precio_ordmov;
mysqli_query($conexion,"DELETE FROM tempordmov_bonif where invnum = '$invnum' and codord = '$codord'");
$sqlq="SELECT * FROM tempordmov_bonif where codord = '$codord' and invnum = '$invnum' and codord  = '$codord'";
$resultq = mysqli_query($conexion,$sqlq);
if (mysqli_num_rows($resultq)){
mysqli_query($conexion,"UPDATE tempordmov_bonif set codpro= '$codpro',codprobon= '$codprobon', canbon = '$bonif_can', tipbon= '$letra', costo_real = '$precio_real' where invnum = '$invnum' and codord = '$codord'");
}
else
{
mysqli_query($conexion,"INSERT INTO tempordmov_bonif (invnum,codord,codpro,codprobon,canbon,tipbon,costo_real) values ('$invnum','$codord','$codpro','$codprobon','$bonif_can','$letra','$precio_real')");
}
//mysqli_query($conexion,"UPDATE ordmov set costod= '$precio_ordmov',mont_total= '$mont_tot' where invnum = '$invnum' and codpro = '$codprobon'");
mysqli_query($conexion,"UPDATE ordmov set canbon= '$bonif_can',tipbon= '$letra' where invnum = '$invnum' and codord  = '$codord'");
////////////////////////////////////////////
header("Location: productos1.php"); 
?>