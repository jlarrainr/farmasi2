<?php include('../../session_user.php');
require_once('../../../conexion.php');
$invnum  			= $_SESSION['transferencia_sal_val'];
$cod	 			= $_REQUEST['cod'];			////CODIGO DEL PRODUCTO EN EL LOCAL
$idlote_lote	 	= $_REQUEST['idlote_lote'];			////CODIGO DEL PRODUCTO EN EL LOCAL
$text1   			= $_REQUEST['text1'];	///cantidad ingresada
$text2   			= $_REQUEST['text2'];	///precio promedio
$text3   			= $_REQUEST['text3'];	///total
$number  			= $_REQUEST['number']; ///factor
$subtotal  			= $_REQUEST['subtotal2']; ///factor
$codtemp  			= $_REQUEST['codtemp']; ///factor



// echo '$invnum = ' . $invnum . "<br>";
// echo '$cod = ' . $cod . "<br>";
// echo '$idlote_lote = ' . $idlote_lote . "<br>";
// echo '$text1 = ' . $text1 . "<br>";
// echo '$text2 = ' . $text2 . "<br>";
// echo '$text3 = ' . $text3 . "<br>";
// echo '$number = ' . $number . "<br>";
// echo '$subtotal = ' . $subtotal . "<br>";
// echo '$codtemp = ' . $codtemp . "<br>";




if ($number == 0) {

	mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr,idlote_salida) values ('$invnum','$cod','$text1','$subtotal','$text3','$subtotal','$idlote_lote')");
} else {

	mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr,idlote_salida) values ('$invnum','$cod','$text1','$subtotal','$text3','$subtotal','$idlote_lote')");
}
header("Location: salidas_varias_lote1.php");
