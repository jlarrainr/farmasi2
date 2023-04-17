<?php require_once('../../session_user.php');
 require_once('../../../conexion.php');
$venta   = $_SESSION['venta'];

$text = isset($_REQUEST['text']) ? $_REQUEST['text'] : "";
$passwordCambio = isset($_REQUEST['opcion']) ? $_REQUEST['opcion'] : "";

 

$sqldatagen = "SELECT diasCuotasVentas,diasCuotasVentasPassword FROM datagen ";
$resultdatagen = mysqli_query($conexion, $sqldatagen);
if (mysqli_num_rows($resultdatagen)) {
	while ($rowdatagen = mysqli_fetch_array($resultdatagen)) {
		$diasCuotasVentasDatagen    = $rowdatagen['diasCuotasVentas'];
		$diasCuotasVentasPassword    = $rowdatagen['diasCuotasVentasPassword'];
	}
}


mysqli_query($conexion, "INSERT INTO intentoCambioPassword(idVenta,diasCambio,diasPredeterminado,diasCuotasVentasPassword,passwordCambio) VALUES ('$venta','$text','$diasCuotasVentasDatagen' ,'$diasCuotasVentasPassword','$passwordCambio')");
echo $venta;
