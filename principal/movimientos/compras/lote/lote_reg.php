<?php include('../../../session_user.php');
$invnum  = $_SESSION['compras'];
require_once('../../../../conexion.php');
$codtempfiltro  = $_REQUEST['codtempfiltro'];
$numero  = $_REQUEST['country'];
$codpro  = $_REQUEST['codpro'];
$mes2     = $_REQUEST['mes'];
$years   = $_REQUEST['years'];


$cuento = strlen($mes2);
if ($cuento == '2') {
	$mes = $mes2;
} else {
	$mes = '0' . $mes2;
}

$numero = strtoupper($numero);

$vencimiento = $mes . "/" . $years;
//echo $country;
//echo '<br>';
//echo $numero;
$sql1 = "SELECT numlote,vencim FROM movlote where numlote = '$numero'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$numlote        = $row1['numlote'];
		$vencimi        = $row1['vencim'];
	}
	$numlote = strtoupper($numlote);
	/////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
	$sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro'  and codtemp ='$codtempfiltro'";
	$result2 = mysqli_query($conexion, $sql2);
	if (mysqli_num_rows($result2)) {
		mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi' where invnum = '$invnum' and codpro = '$codpro' and codtemp ='$codtempfiltro'");
	} else {
		mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim) values ('$invnum','$numlote','$codpro','$vencimi')");
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
	/////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
	/*$sql2="SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro' and codtemp ='$codtempfiltro'";
	$result2 = mysqli_query($conexion,$sql2);
	if (mysqli_num_rows($result2))
	{*/
	mysqli_query($conexion, "UPDATE templote set numerolote = '$numero',vencim = '$vencimiento' where invnum = '$invnum' and codpro = '$codpro' and codtemp ='$codtempfiltro'");

	mysqli_query($conexion, "UPDATE tempmovmov set numlote = '$numero' where invnum = '$invnum' and codpro = '$codpro' and codtemp ='$codtempfiltro'");
	/*}
	else
	{
	mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro) values ('$invnum','$numero','$vencimiento','$codpro')");
	}*/
	////////////////////////////////////////////////////////////////////////////////////////////////////
}
//mysqli_query($conexion,"truncate TABLE templote");
header("Location: lote.php?cod=$codpro&codtempfiltro=$codtempfiltro&close=1");
