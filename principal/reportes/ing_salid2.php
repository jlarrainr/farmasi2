<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .Estilo1 {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;
        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 15px;
            font-weight: 900;
        }
    </style>
</head>
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $users = $row['nomusu'];
    }
}

function formato($c)
{
    printf("%06d", $c);
}

$date = date('d/m/Y');
$hour = date(G);
//$hour   = CalculaHora($hour);
$min = date(i);
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$vals = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
$desc = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
$desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$mov = isset($_REQUEST['mov']) ? ($_REQUEST['mov']) : "";
$user = isset($_REQUEST['user']) ? ($_REQUEST['user']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$SCliente = isset($_REQUEST['SCliente']) ? ($_REQUEST['SCliente']) : "";
$SProveedor = isset($_REQUEST['SProveedor']) ? ($_REQUEST['SProveedor']) : "";
$SSucursal = isset($_REQUEST['SSucursal']) ? ($_REQUEST['SSucursal']) : "";
$dat1 = $date1;
$dat2 = $date2;
$date1 = fecha1($date1);
$date2 = fecha1($date2);
isset($_REQUEST['ck']) ? $ck = $_REQUEST['ck'] : $ck = 0;
/////////////////////////////////////////////
if ($mov == 1) {
    $desc_mov = "TODOS LOS MOVIMIENTOS";
}
if ($mov == 2) {
    $desc_mov = "SOLAMENTE INGRESOS";
}
if ($mov == 3) {
    $desc_mov = "SOLAMENTE SALIDAS";
}
if ($mov == 4) {
    $desc_mov = "COMPRAS";
}
if ($mov == 5) {
    $desc_mov = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 6) {
    $desc_mov = "DEVOLUCION EN BUEN ESTADO";
}
if ($mov == 7) {
    $desc_mov = "CANJE AL LABORATORIO";
}
if ($mov == 8) {
    $desc_mov = "OTROS INGRESOS";
}
if ($mov == 9) {
    $desc_mov = "SALIDAS VARIAS";
}
if ($mov == 10) {
    $desc_mov = "GUIAS DE REMISION";
}
if ($mov == 11) {
    $desc_mov = "SALIDA POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 12) {
    $desc_mov = "CANJE PROVEEDOR";
}
if ($mov == 13) {
    $desc_mov = "PRESTAMOS CLIENTE";
}


if ($user == 1) {
    $desc_user = " PROVEEDOR";
}
if ($user == 2) {
    $desc_user = "PROVEEDOR";
}
if ($user == 3) {
    $desc_user = "SUCURSAL";
}

function callCliente($conexion, $Codigo)
{
    $sql = "SELECT descli FROM cliente where codcli = " . $Codigo . " order by descli";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            return $row["codcli"];
        }
    } else {
        return "";
    }
}

function callProveedor($conexion, $Codigo)
{
    $sql = "SELECT codpro,despro FROM proveedor where codpro = " . $Codigo . " order by despro";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            return $row["despro"];
        }
    } else {
        return "";
    }
}

function callSucursal($conexion, $Codigo)
{
    $sql = "SELECT codloc,nomloc,nombre FROM xcompa where habil = 1 and codloc = " . $Codigo . " order by nomloc";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $Nombre = $row["nombre"];
            $NomLoc = $row["nomloc"];
            if ($Nombre <> "") {
                return $Nombre;
            } else {
                if ($NomLoc <> "") {
                    return $NomLoc;
                } else {
                    return "";
                }
            }
        }
    } else {
        return "";
    }
}

/////////////////////////////////////////////
if ($local <> 'all') {
    $sql = "SELECT nomloc FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td width="260"><strong><?php echo $desemp ?> </strong></td>
            <td width="380">
                <div align="center"><strong>REPORTE DE INGRESOS Y SALIDAS -
                        <?php
                        if ($local == 'all') {
                            echo 'TODAS LAS SUCURSALES';
                        } else {
                            echo $nomloc;
                        }
                        ?>
                    </strong></div>
            </td>
            <td width="260">
                <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
            </td>
        </tr>
        <tr>
            <td width="267"><strong><?php echo $desc_mov ?></strong></td>
            <td width="366">
                <div align="center"><b><?php if ($val == 1) { ?>NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php
                                                                                                                    echo $desc1;
                                                                                                                }
                                                                                                                if ($vals == 2) {
                                                                                                                    ?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php
                                                                                                                                                                    echo $date2;
                                                                                                                                                                }
                                                                                                                                                                    ?></b></div>
            </td>
            <td width="267">
                <div align="right">USUARIO:<span class="text_combo_select"><?php echo $users ?></span></div>
            </td>
        </tr>
    </table>
    <?php
    if (($val == 1) || ($vals == 2)) {
    ?>

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php
                    $ScriptAdic = "";
                    if ($SCliente <> "") {
                        if (($mov == 1) || ($mov == 10) || ($mov == 13)) {
                            $ScriptAdic = "  cuscod = $SCliente and ";
                        }
                    }
                    if ($SProveedor <> "") {
                        if (($mov == 1) || ($mov == 4) || ($mov == 7) || ($mov == 12)) {
                            $ScriptAdic = "  cuscod = $SProveedor and ";
                        }
                    }
                    if ($SSucursal <> "") {
                        //TODOS LOS MOVIMIENTOS
                        if ($mov == 1) {
                            $ScriptAdic = "  (sucursal = $SSucursal OR sucursal1 = $SSucursal) and ";
                        } else {
                            //INGRESO POR TRANSFERENCIA DE SUCURSAL O SOLAMENTE INGRESOS
                            if (($mov == 5) || ($mov == 2)) {
                                $ScriptAdic = "  sucursal = $SSucursal and ";
                            }
                            //SALIDAS DE TRANSFEENCIAS X SUCURSALES O SOLAMENTE SALIDAS
                            if (($mov == 11) || ($mov == 3)) {
                                $ScriptAdic = "  sucursal1 = $SSucursal and ";
                            }
                        }
                    }

                    if ($val == 1) {
                        if ($local == 'all') {
                            if ($mov == 1) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' order by invfec,numdoc";
                            }
                            if ($mov == 2) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' order by invfec,numdoc";
                            }
                            if ($mov == 3) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' order by invfec,numdoc";
                            }
                            if ($mov == 4) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '1' order by invfec,numdoc";
                            }
                            if ($mov == 5) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '2' order by invfec,numdoc";
                            }
                            if ($mov == 6) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '3' order by invfec,numdoc";
                            }
                            if ($mov == 7) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '4' order by invfec,numdoc";
                            }
                            if ($mov == 8) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and tipdoc = '5' order by invfec,numdoc";
                            }
                            if ($mov == 9) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '1' order by invfec,numdoc";
                            }
                            if ($mov == 10) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '2' order by invfec,numdoc";
                            }
                            if ($mov == 11) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '3' order by invfec,numdoc";
                            }
                            if ($mov == 12) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '4' order by invfec,numdoc";
                            }
                            if ($mov == 13) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and tipdoc = '5' order by invfec,numdoc";
                            }
                        } else {

                            if ($mov == 1) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 2) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 3) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 4) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra,sucursal,numero_documento,numero_documento1,forpag,hora FROM " . $ScriptAdic . " movmae where numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 and tipdoc = '1' order by invfec,numdoc";
                            }
                            if ($mov == 5) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 and tipdoc = '2' order by invfec,numdoc";
                            }
                            if ($mov == 6) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 and tipdoc = '3' order by invfec,numdoc";
                            }
                            if ($mov == 7) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 and tipdoc = '4' order by invfec,numdoc";
                            }
                            if ($mov == 8) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '1' and sucursal = '$local' and invtot <> 0 and tipdoc = '5' order by invfec,numdoc";
                            }
                            if ($mov == 9) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 and tipdoc = '1' order by invfec,numdoc";
                            }
                            if ($mov == 10) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 and tipdoc = '2' order by invfec,numdoc";
                            }
                            if ($mov == 11) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 and tipdoc = '3' order by invfec,numdoc";
                            }
                            if ($mov == 12) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 and tipdoc = '4' order by invfec,numdoc";
                            }
                            if ($mov == 13) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " numdoc between '$desc' and '$desc1' and tipmov = '2' and sucursal = '$local' and invtot <> 0 and tipdoc = '5' order by invfec,numdoc";
                            }
                        }
                    }
                    if ($vals == 2) {
                        if ($local == 'all') {
                            if ($mov == 1) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and invtot <> 0  order by invfec,numdoc";
                            }
                            if ($mov == 2) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and invtot <> 0  order by invfec,numdoc";
                            }
                            if ($mov == 3) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2'  and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 4) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '1' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 5) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '2' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 6) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '3' and invtot <> 0order by invfec,numdoc";
                            }
                            if ($mov == 7) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '4'and invtot <> 0  order by invfec,numdoc";
                            }
                            if ($mov == 8) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '5' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 9) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '1' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 10) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '2' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 11) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '3' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 12) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '4'  and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 13) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '5'and invtot <> 0  order by invfec,numdoc";
                            }
                        } else {
                            if ($mov == 1) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 2) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 3) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 4) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,nro_compra,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '1' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 5) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '2' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 6) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '3' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 7) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '4' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 8) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '1' and tipdoc = '5' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 9) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '1' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 10) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '2' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 11) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '3' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 12) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '4' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                            if ($mov == 13) {
                                $sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot,sucursal,numero_documento,numero_documento1,forpag,hora FROM movmae where " . $ScriptAdic . " invfec between '$date1' and '$date2' and tipmov = '2' and tipdoc = '5' and sucursal = '$local' and invtot <> 0 order by invfec,numdoc";
                            }
                        }
                    }
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                    ?>
                        <table width="100%" border="0" align="center" id="customers">


                            <tr align="center">
                                <?php
                                if (($ck == 0) and ($mov == 4)) {
                                ?>
                                    <th><strong>FECHA/HORA</strong></th>
                                    <th>
                                        <div><strong>COD INTERNO</strong></div>
                                    </th>
                                    <th colspan="2">
                                        <div><strong>NRO DOCUMENTO</strong></div>
                                    </th>
                                    <th>
                                        <div><strong>LOCAL</strong></div>
                                    </th>
                                    <th width="200" colspan="2">
                                        <div><strong>PROVEEDOR </strong></div>
                                    </th>


                                    <th>
                                        <div align="right"><strong>NETO</strong></div>
                                    </th>
                                    <?php
                                } else {
                                    if (($ck == 1) and ($mov == 4)) {
                                    ?>
                                        <th><strong>FECHA/HORA</strong></th>
                                        <th>
                                            <div><strong>MONTO AFECTO</strong></div>
                                        </th>
                                        <th>
                                            <div><strong>MONTO INAFECTO</strong></div>
                                        </th>
                                        <th>
                                            <div><strong>IGV</strong></div>
                                        </th>
                                        <th>
                                            <div align="right"><strong>NETO</strong></div>
                                        </th>
                                    <?php
                                    } else {
                                    ?>
                                        <th><strong>FECHA/HORA</strong></th>
                                        <th>
                                            <div><strong>COD INTERNO</strong></div>
                                        </th>
                                        <th colspan="2">
                                            <div><strong>NRO DOCUMENTO</strong></div>
                                        </th>
                                        <th>
                                            <div><strong>LOCAL</strong></div>
                                        </th>
                                        <th>
                                            <div align="center"><strong>TIPO MOV </strong></div>
                                        </th>
                                        <th width="200" colspan="2">
                                            <div><strong><?php echo $desc_user ?></strong></div>
                                        </th>
                                        <th>
                                            <div><strong>REFERENCIA</strong></div>
                                        </th>
                                        <th>
                                            <div align="right"><strong>MONTO</strong></div>
                                        </th>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $invfec = $row['invfec'];
                                $invnum = $row['invnum'];
                                $tipmov = $row['tipmov'];
                                $tipdoc = $row['tipdoc'];
                                $numdoc = $row['numdoc'];
                                $cuscod = $row['cuscod'];
                                $refere = $row['refere'];
                                $monto = $row['invtot'];
                                $sucursal = $row['sucursal'];
                                $numero_documento = $row['numero_documento'];
                                $numero_documento1 = $row['numero_documento1'];
                                $forpag = $row['forpag'];
 $hora = date("g:i a", strtotime($row['hora']));
                                $forpag = strtoupper($forpag);

$forpagTexto='';
if($forpag =='F'){
    $forpagTexto="Factura";
}elseif($forpag =='B'){
     $forpagTexto="Boleta";
}elseif($forpag =='G'){
     $forpagTexto="Guia";
}elseif($forpag =='O'){
     $forpagTexto="Otros";
}


                                if ($refere == "") {
                                    $refere = "--------------------------------";
                                }

                                if ($numero_documento <> "") {
                                    $documento = $numero_documento . "-" . $numero_documento1;
                                } else {
                                    $documento = "";
                                }

                                if ($cuscod <> 0) {
                                    $sql1 = "SELECT despro,rucpro FROM proveedor where codpro = '$cuscod'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $despro = $row1['despro'];
                                            $rucpro = $row1['rucpro'];
                                        }
                                    }
                                    $rucpro = 'RUC: ' . $rucpro;
                                } else {
                                    $despro = '';
                                    $rucpro = '';
                                }

                                if ($tipmov == 1) {
                                    if ($tipdoc == 1) {
                                        $desctip = "INGRESO POR COMPRA";
                                    }
                                    if ($tipdoc == 2) {
                                        $desctip = "INGRESO POR TRANSF";
                                    }
                                    if ($tipdoc == 3) {
                                        $desctip = "DEVOLUCI�N";
                                    }
                                    if ($tipdoc == 4) {
                                        $desctip = "CANJE AL LABORATORIO";
                                    }
                                    if ($tipdoc == 5) {
                                        $desctip = "OTROS INGRESOS";
                                    }
                                }
                                if ($tipmov == 2) {
                                    if ($tipdoc == 1) {
                                        $desctip = "SALIDAS VARIAS";
                                    }
                                    if ($tipdoc == 2) {
                                        $desctip = "GUIAS DE REMISION";
                                    }
                                    if ($tipdoc == 3) {
                                        $desctip = "SALIDA POR TRANSF";
                                    }
                                    if ($tipdoc == 4) {
                                        $desctip = "CANJE PROVEEDOR ";
                                    }
                                    if ($tipdoc == 5) {
                                        $desctip = "PRESTAM CLIENTE ";
                                    }
                                }
                                if (($tipmov == 9) && ($tipdoc == 9)) {
                                    $desctip = "VENTA";
                                }
                                if (($tipmov == 10) && ($tipdoc == 9)) {
                                    $desctip = "VENTA DESHAB";
                                }
                                if (($tipmov == 10) && ($tipdoc == 10)) {
                                    $desctip = "VENTA HAB";
                                }
                                if (($tipmov == 11) && ($tipdoc == 11)) {
                                    $desctip = "ING DE BONIF";
                                }
                                if (($tipmov == 9) && ($tipdoc == 11)) {
                                    $desctip = "VENTAS POR BONIF";
                                }
                                $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $nomloc = $row1['nomloc'];
                                        $nombre = $row1['nombre'];
                                    }
                                }
                                if ($nombre <> "") {
                                    $nomloc = $nombre;
                                }
                                if ($tipmov == 4) {
                                    $nro_compra = $row['nro_compra'];

                                    if ($cuscod <> 0) {
                                        $sql1 = "SELECT despro,rucpro FROM proveedor where codpro = '$cuscod'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $despro = $row1['despro'];
                                                $rucpro = $row1['rucpro'];
                                            }
                                        }

                                        $rucpro = 'RUC: ' . $rucpro;
                                    } else {
                                        $despro = '';
                                        $rucpro = '';
                                    }
                                }
                                if ($tipmov == 1) {
                                    $desctip_mov = "INGRESO";
                                } else {
                                    $desctip_mov = "SALIDA";
                                }


                                /* $SCliente   = isset($_REQUEST['SCliente'])? ($_REQUEST['SCliente']) : "";
                                      $SProveedor = isset($_REQUEST['SProveedor'])? ($_REQUEST['SProveedor']) : "";
                                      $SSucursal  = isset($_REQUEST['SSucursal'])? ($_REQUEST['SSucursal']) : ""; */
                                /* echo "TIPMOV=".$tipmov."<br>";
                                      echo "TIPDOC=".$tipdoc."<br><br>"; */

                                //INGRESOS
                                $DatosClienteProvSuc = "";
                                if ($local <> 'all') {
                                    if ($tipmov == 1) {
                                        //PROVEEDOR
                                        if ($tipdoc == 1) {
                                            if ($SProveedor <> "") {
                                                $DatosClienteProvSuc = callProveedor($conexion, $SProveedor);
                                            }
                                        }
                                        //SUCURSAL
                                        if ($tipdoc == 2) {
                                            if ($SSucursal <> "") {
                                                $DatosClienteProvSuc = callSucursal($conexion, $SSucursal);
                                            }
                                        }
                                        //CLIENTES
                                        if ($tipdoc == 3) {
                                            if ($SCliente <> "") {
                                                $DatosClienteProvSuc = callCliente($conexion, $SCliente);
                                            }
                                        }
                                        //PROVEEDOR
                                        if ($tipdoc == 4) {
                                            if ($SProveedor <> "") {
                                                $DatosClienteProvSuc = callProveedor($conexion, $SProveedor);
                                            }
                                        }
                                        /* if ($tipdoc == 5)
                                              {

                                              } */
                                        //PROVEEDOR
                                        if ($tipdoc == 6) {
                                            if ($SProveedor <> "") {
                                                $DatosClienteProvSuc = callProveedor($conexion, $SProveedor);
                                            }
                                        }
                                    }
                                    //SALIDAS
                                    if ($tipmov == 2) {
                                        /* if ($tipdoc == 1)
                                              {

                                              } */
                                        //CLIENTE
                                        if ($tipdoc == 2) {
                                            if ($SCliente <> "") {
                                                $DatosClienteProvSuc = callCliente($conexion, $SCliente);
                                            }
                                        }
                                        //SUCURSAL
                                        if ($tipdoc == 3) {
                                            if ($SSucursal <> "") {
                                                $DatosClienteProvSuc = callSucursal($conexion, $SSucursal);
                                            }
                                        }
                                        //PROVEEDOR
                                        if ($tipdoc == 4) {
                                            if ($SProveedor <> "") {
                                                $DatosClienteProvSuc = callProveedor($conexion, $SProveedor);
                                            }
                                        }
                                        //CLIENTE
                                        if ($tipdoc == 5) {
                                            if ($SCliente <> "") {
                                                $DatosClienteProvSuc = callCliente($conexion, $SCliente);
                                            }
                                        }
                                    }
                                }
                            ?>
                                <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>
                                    <?php
                                    if (($ck == 0) and ($mov == 4)) {
                                    ?>
                                        <td align="center"><?php echo fecha($invfec).' - '.$hora; ?></td>

                                        <td align="center">
                                            <div>
                                                <a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum ?>&val=<?php echo $val ?>&vals=<?php echo $vals ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&mov=<?php echo $mov ?>&user=<?php echo $user ?>&local=<?php echo $local ?>&tex=<?php echo $desctip ?>', 20, 90, 1250, 500)"><?php echo formato($invnum) ?></a></div>
                                        </td>
                                        <td>
                                            <div><strong> <?php echo $forpagTexto; ?> </strong> <?php echo $documento ?></div>
                                        </td>
                                        <td align="center">
                                            <div><?php echo $nomloc ?></div>
                                        </td>
                                        <td><?php echo $despro; ?></td>
                                        <td><?php echo $rucpro ?></td>

                                        <td>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ''); ?></div>
                                        </td>
                                        <?php
                                    } else {
                                        if (($ck == 1) and ($mov == 4)) {
                                        ?>
                                            <td><strong><a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum ?>&val=<?php echo $val ?>&vals=<?php echo $vals ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&mov=<?php echo $mov ?>&user=<?php echo $user ?>&local=<?php echo $local ?>&tex=<?php echo $desctip ?>', 20, 90, 1250, 500)"><?php echo fecha($invfec) ?></a></strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ''); ?></div>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td align="center">
                                                <?php echo fecha($invfec).' - '.$hora ?>
                                            </td>
                                            <td align="center">
                                                <div>
                                                    <a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum ?>&val=<?php echo $val ?>&vals=<?php echo $vals ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&mov=<?php echo $mov ?>&user=<?php echo $user ?>&local=<?php echo $local ?>&tex=<?php echo $desctip ?>', 20, 90, 1250, 500)"><?php echo formato($numdoc) ?></a></div>
                                            </td>
                                            <td align="center">
                                                <div> <?php echo $forpagTexto; ?>  </div>
                                            </td>
                                            <td align="center">
                                                <div> <?php echo $documento ?></div>
                                            </td>
                                            <td align="center">
                                                <div><?php echo $nomloc; ?></div>
                                            </td>
                                            <td>
                                                <div align="center"><?php /* echo $desctip_mov */ echo $desctip; ?></div>
                                            </td>
                                            <td width="100">
                                                <div><?php
                                                        if ($despro <> "") {
                                                            echo $despro;
                                                        } else {
                                                            echo $DatosClienteProvSuc;
                                                        }
                                                        ?></div>
                                            </td>
                                            <td width="100"><?php echo $rucpro; ?></td>
                                            <td align="center"><?php if ($refere <> "") { ?><?php echo $refere; ?><?php } ?></td>
                                            <td>
                                                <div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ''); ?></div>
                                            </td>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    <?php
                    } else {
                    ?>
                        <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </td>
            </tr>
        </table>
    <?php }
    ?>
</body>

</html>