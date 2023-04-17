<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
$tt         = isset($_REQUEST['tt']) ? $_REQUEST['tt'] : "";
$vt         = isset($_REQUEST['vt']) ? $_REQUEST['vt'] : "";
$date       = date("Y-m-d");
$fecha      = explode("-", $date);
$daysem     = $fecha[2];
$messem     = $fecha[1];
$yearsem    = $fecha[0];

/////funcion q calcula las semanas del mes
function numberOfWeek($dia, $mes, $ano)
{
    $Hora = date("H");
    $Min  = date("i");
    $Sec  = date("s");
    $fecha = mktime($Hora, $Min, $Sec, $mes, 1, $ano);
    $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
    return $numberOfWeek;
}

// Determina la columna saldo por local
function tablaslocal($nomloc)
{
    // Tomar los ultimos digitos de "nomloc" para construir el nombre de columna saldo de local
    $numero = substr($nomloc, 5, 2);
    $tabla = "s" . str_pad($numero, 3, "0", STR_PAD_LEFT);
    return $tabla;
}

///////////////////////////////////////
if (($tt == '') and ($vt == '')) {
    // Recupera venta de usuario
    $sql = "SELECT invnum,invfec,nomloc FROM venta inner join xcompa on sucursal = codloc where usecod = '$usuario' and estado ='1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum    = $row['invnum'];
            $invfec    = $row['invfec'];
            $sucursal  = tablaslocal($row['nomloc']);
            // Elimina venta registrada
            //                error_log('Borrando venta 1');
        }
    }
    // Busca ventas sin codigo de usuario, estado = 1 y de fecha distinta al dÃ­a
    $sql = "SELECT invnum FROM venta where usecod = '' and estado ='1' and invfec <> '$date'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum    = $row['invnum'];
            // Eliminar venta inconsistente
            mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$invnum'");
            //                error_log('Borrando venta 2');
            mysqli_query($conexion, "DELETE from venta where invnum = '$invnum'");
        }
    }
    // Ubicar registros de venta
    if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
    } else {
        $arr_detalle_venta = array();
    }
    $contArray = 0;
    if (!empty($arr_detalle_venta)) {
        $arrAux = array();
        foreach ($arr_detalle_venta as $row) {
            $invnum    = $row['invnum'];
            // Determinar el estado de venta ubicada
            $sql1 = "SELECT estado FROM venta where invnum = '$invnum'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $estado    = $row1['estado'];
                    // Si el estado de venta es 0, eliminar la fila
                    if ($estado != 0) {
                        $arrAux[] = $row;
                    }
                }
            }
            $contArray++;
        }
        $_SESSION['arr_detalle_venta'] = $arrAux;
    }
}

// Tomar datos para la venta (local, cliente, numero de venta, correlativo)
$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc    = $row['codloc'];
    }
}
$sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcli    = $row['codcli'];
    }
}
//echo $date;
$nrovent = 1;
$sql = "SELECT nrovent FROM venta where sucursal = '$codloc' order by nrovent desc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nrovent = $row['nrovent'] + 1;
    }
    //$nrovent = $nrovent + 1;
}

$correlativo = 1;
$sql = "SELECT correlativo FROM venta where sucursal = '$codloc' order by correlativo desc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $correlativo    = $row['correlativo'] + 1;
    }
}
$semana = numberOfWeek($daysem, $messem, $yearsem);
//error_log('==================');
header("Location: venta_index.php");
