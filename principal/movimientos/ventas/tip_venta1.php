<?php require_once('../../../conexion.php');
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
$tradio  = $_REQUEST['tradio'];
$num     = $_REQUEST['num'];
$tarjeta = $_REQUEST['tarjeta'];
$numeroCuota = $_REQUEST['numeroCuota'];
$ventaDiasCuotas = $_REQUEST['textPasswordCambio'];
$cambioDias = $_REQUEST['cambioDias'];


$sqldatagen = "SELECT diasCuotasVentas,diasCuotasVentasPassword FROM datagen ";
$resultdatagen = mysqli_query($conexion, $sqldatagen);
if (mysqli_num_rows($resultdatagen)) {
	while ($rowdatagen = mysqli_fetch_array($resultdatagen)) {
		$diasCuotasVentasDatagen    = $rowdatagen['diasCuotasVentas'];
		$diasCuotasVentasPassword    = $rowdatagen['diasCuotasVentasPassword'];
	}
}

if($cambioDias==0){
    $ventaDiasCuotas=$diasCuotasVentasDatagen;
}

$sql = "SELECT  cuscod FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$cuscod = $row['cuscod'];
	}
}

$sqlCli = "SELECT codcli FROM cliente where  descli like '%PUBLICO EN GENERAL%'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {

                $codcli = $row['codcli'];
            }
        }
        
        if($cuscod == $codcli){
            if($tradio =='C'){
                $tradio='E';
                $numeroCuota='0';
                $ventaDiasCuotas='0';
            }
           
        }


if($tarjeta <> ''){
    
    if (!is_numeric($tarjeta)) {
        $tarjeta = strtoupper($tarjeta);
        mysqli_query($conexion, "INSERT INTO tarjeta (nombre ) values ('$tarjeta')");
        $id_tarjeta = mysqli_insert_id($conexion);
        $tarjeta = $id_tarjeta;
    }
    
}


if($tradio == 'E'){
    
    $numeroCuota='0';
    $ventaDiasCuotas='0';
    
}


mysqli_query($conexion, "UPDATE venta set forpag = '$tradio',codtab = '$tarjeta',numtarjet = '$num',numeroCuota='$numeroCuota',ventaDiasCuotas = '$ventaDiasCuotas' where invnum = '$venta'");
header("Location: tip_venta.php?close=1");



