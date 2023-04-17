<?php

require_once('../../session_user.php');
require_once('session_ventas.php');
require_once('../../../conexion.php');
$tt = $_REQUEST['tt']; ////rd
$vt = $_REQUEST['vt'];
$numCopias = isset($_REQUEST['numCopias']) ? $_REQUEST['numCopias'] : 1;
if (($tt == '') and ( $vt == '')) {
    $sqlVTA = "SELECT invnum FROM venta where usecod = '$usuario' and estado ='1'";
    $resultVTA = mysqli_query($conexion, $sqlVTA);
    if (mysqli_num_rows($resultVTA)) {
        while ($row = mysqli_fetch_array($resultVTA)) {
            $invnum = $row['invnum'];
            mysqli_query($conexion, "DELETE from temp_venta_bonif where invnum = '$invnum'");
            unset($_SESSION['arr_detalle_venta']);
            mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$invnum'");
            mysqli_query($conexion, "DELETE from venta where invnum = '$invnum'");
        }
    }
    $sqlVTA1 = "SELECT invnum FROM venta where usecod = '' and estado ='1'";
    $resultVTA1 = mysqli_query($conexion, $sqlVTA1);
    if (mysqli_num_rows($resultVTA1)) {
        while ($row = mysqli_fetch_array($resultVTA1)) {
            $invnum = $row['invnum'];
            mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$invnum'");
            mysqli_query($conexion, "DELETE from venta where invnum = '$invnum'");
        }
    }
}

$sqlUSU = "SELECT codloc FROM usuario where usecod = '$usuario'";
$resultUSU = mysqli_query($conexion, $sqlUSU);
if (mysqli_num_rows($resultUSU)) {
    while ($row = mysqli_fetch_array($resultUSU)) {
        $codloc = $row['codloc'];
    }
}

$sqlCLI = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
$resultCLI = mysqli_query($conexion, $sqlCLI);
if (mysqli_num_rows($resultCLI)) {
    while ($row = mysqli_fetch_array($resultCLI)) {
        $codcli = $row['codcli'];
    }
}

$date = date("Y-m-d");
$fecha = explode("-", $date);
$daysem = $fecha[2];
$messem = $fecha[1];
$yearsem = $fecha[0];

/////funcion q calcula las semanas del mes
function numberOfWeek($dia, $mes, $ano) {
    $fecha = mktime(date('H'), date('i'), date('s'), $mes, 1, $ano);
    $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
    return $numberOfWeek;
}

$sqlNROVTA = "SELECT nrovent FROM venta where sucursal = '$codloc' order by nrovent desc limit 1";
$resultNROVTA = mysqli_query($conexion, $sqlNROVTA);
if (mysqli_num_rows($resultNROVTA)) {
    while ($row = mysqli_fetch_array($resultNROVTA)) {
        $nrovent = $row['nrovent'];
    }
    $nrovent += 1;
} else {
    $nrovent = 1;
}

$sqlCOR = "SELECT correlativo FROM venta where sucursal = '$codloc' order by correlativo desc limit 1";
$resultCOR = mysqli_query($conexion, $sqlCOR);
if (mysqli_num_rows($resultCOR)) {
    while ($row = mysqli_fetch_array($resultCOR)) {
        $correlativo = $row['correlativo'];
    }
    $correlativo += 1;
} else {
    $correlativo = 1;
}

$semana = numberOfWeek($daysem, $messem, $yearsem);

if (!isset($_SESSION['venta'])) {
    mysqli_query($conexion, "INSERT INTO venta (nrovent,invfec,usecod,cuscod,forpag,estado,sucursal,tipdoc,correlativo,semana) values ('$correlativo','$date','$usuario','$codcli','E','1','$codloc','2','$correlativo','$semana')");

    $lastVentaId = mysqli_insert_id($conexion);
    $_SESSION['venta'] = $lastVentaId;
}

//error_log('Insertando Venta');
header("Location: generarhtml.php?tt=$tt&vt=$vt&numCopias=$numCopias");
?>