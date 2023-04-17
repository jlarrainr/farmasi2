<?php

include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$country_ID = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
$country = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$inicio = isset($_REQUEST['inicio']) ? ($_REQUEST['inicio']) : "";
$pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
$tot_pag = isset($_REQUEST['tot_pag']) ? ($_REQUEST['tot_pag']) : "";
$registros = isset($_REQUEST['registros']) ? ($_REQUEST['registros']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$SoloCompras = isset($_REQUEST['SoloCompras']) ? ($_REQUEST['SoloCompras']) : "";


$de = "De Local";
$a = "A Local";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />



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
            font-size: 12px;
            font-weight: 900;
        }

        .strikeout {
            text-decoration: line-through;
            color: red;
        }
    </style>
</head>
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$date = date('d/m/Y');
$hour = date("G");
$min = date("i");
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$dat1 = $date1;
$dat2 = $date2;
if (strlen($date1) > 0) {
    $date1 = fecha1($date1);
}
if (strlen($date2) > 0) {
    $date2 = fecha1($date2);
}

function formato($c)
{
    printf("%06d", $c);
}

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}
?>

<body>
    <table width="100%" border="0">
        <tr>
            <td width="1120">
                <table width="100%" border="0">
                    <tr>
                        <td width="278"><strong><?php echo $desemp ?> </strong></td>
                        <td width="563">
                            <div align="center"><strong>REPORTE DE KARDEX DE PRODUCTOS</strong></div>
                        </td>
                        <td width="278">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="278"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="565">
                            <div align="center"><b><?php
                                                    if ($val == 1) {
                                                        echo $country;
                                                    }
                                                    ?></b></div>
                        </td>
                        <td width="276">
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <div align="center"><b>
                                    <?php
                                    if ($val == 1) {
                                        echo "FECHAS ENTRE :";
                                        echo $dat1;
                                        echo " AL ";
                                        echo $dat2;
                                    }
                                    ?>
                                </b>
                            </div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
        $sql = "SELECT tipmov,tipdoc FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' GROUP BY nrodoc,tipmov,tipdoc,invnum,eliminado,qtypro,fraccion,fecha,numlote   order by fecha,codkard";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $tipmov = $row['tipmov'];
                $tipdoc = $row['tipdoc'];
            }
        }
    ?>


        <table width="100%" border="1" cellpadding="0" cellspacing="0" id="customers">
            <tr>
                <th><strong>FECHA</strong></th>
                <th>
                    <div align="center"><strong>HORA MVMT </strong></div>
                </th>
                <th>
                    <div align="center"><strong>N&ordm; LOTE </strong></div>
                </th>
                <th>
                    <div align="center"><strong>N&ordm; INT </strong></div>
                </th>
                <th>
                    <div align="center"><strong>TIPO DE MOV </strong></div>
                </th>
                <th>
                    <div align="center"><strong>N&ordm; DOC </strong></div>
                </th>
                <th>
                    <div align="center"><strong>PROVEEDOR/CLIENTE</strong></div>
                </th>
                <th>
                    <div align="center"><strong>DE LOCAL</strong></div>
                </th>
                <th>
                    <div align="center"><strong>A LOCAL</strong></div>
                </th>
                <th>
                    <div align="center"><strong>FACTOR</strong></div>
                </th>
                <th>
                    <div align="center"><strong>USUARIO</strong></div>
                </th>
                <th>
                    <div align="center"><strong>CANT</strong></div>
                </th>
                <th>
                    <div align="center"><strong>P.COSTO</strong></div>
                </th>
                <th>
                    <div align="center"><strong>HISTOR. STOCK </strong></div>
                </th>
            </tr>
            <?php

            if ($SoloCompras == 1) {
                $sql = "SELECT fecha,codkard,nrodoc,tipmov,tipdoc,qtypro,fraccion,factor,sactual,invnum,preciocompra,eliminado,numlote,transferenciaVenta,fechainterna  FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' and tipmov = 1  and tipdoc = 1  GROUP BY nrodoc,tipmov,tipdoc,invnum,eliminado,qtypro,fraccion,fecha,numlote,sactual   order by fecha,codkard";
            } else {
                $sql = "SELECT fecha,codkard,nrodoc,tipmov,tipdoc,qtypro,fraccion,factor,sactual,invnum,preciocompra,eliminado,numlote,transferenciaVenta,fechainterna  FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local'  GROUP BY nrodoc,tipmov,tipdoc,invnum,eliminado,qtypro,fraccion,fecha,numlote,sactual  order by fecha,codkard";
            }
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $codkard = $row['codkard'];
                    $fecha = $row['fecha'];
                    $nrodoc = $row['nrodoc'];
                    $tipmov = $row['tipmov'];
                    $tipdoc = $row['tipdoc'];
                    $qtypro = $row['qtypro'];
                    $fraccion = $row['fraccion'];
                    $factor = $row['factor'];
                    $sactual = $row['sactual'];
                    $invnum = $row['invnum'];
                    $preciocompra = $row['preciocompra'];
                    $eliminado = $row['eliminado'];
                    $numlote = $row['numlote'];
                    $transferenciaVenta = $row['transferenciaVenta'];
                    $fechainterna = $row['fechainterna'];
                    $horaFechaInterna = date("g:i:s a", strtotime($fechainterna));


                    if ($eliminado == 1) {
                        $cssTachado = 'class="strikeout"';
                    } else {
                        $cssTachado = '';
                    }
                    $ver = 0;
                    $car = 0;
                    //$saldoactual = 0;
                    ///////////////////////////////////////////////////////////////////////////////////
                    if ($tipmov == 1) {
                        $signo = "+ ";
                        $sig = 'mas';
                        if ($tipdoc == 1) {
                            $desctip = "INGRESO POR COMPRA";
                        }
                        if ($tipdoc == 2) {
                            $desctip = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
                        }
                        if ($tipdoc == 3) {
                            $desctip = "DEVOLUCION EN BUEN ESTADO";
                        }
                        if ($tipdoc == 4) {
                            $desctip = "CANJE AL LABORATORIO";
                        }
                        if ($tipdoc == 5) {
                            $desctip = "OTROS INGRESOS";
                        }
                    }
                    if ($tipmov == 2) {
                        $signo = "- ";
                        $sig = 'menos';
                        if ($tipdoc == 1) {
                            $desctip = "SALIDAS VARIAS";
                        }
                        if ($tipdoc == 2) {
                            $desctip = "GUIAS DE REMISION";
                        }
                        if ($tipdoc == 3) {

                            if ($transferenciaVenta != 0) {
                                $desctip = "SALIDA POR TRANSFERENCIA DE SUCURSAL CON VENTA";
                            } else {
                                $desctip = "SALIDA POR TRANSFERENCIA DE SUCURSAL ";
                            }
                        }
                        if ($tipdoc == 4) {
                            $desctip = "CANJE PROVEEDOR ";
                        }
                        if ($tipdoc == 5) {
                            $desctip = "PRESTAMOS CLIENTE ";
                        }
                        if ($tipdoc == 6) {
                            $desctip = "SALIDAS VARIAS POR LOTE ";
                        }
                    }

                    ///////////////////////////////////////////////////////////////////////////////////
                    $hora = '';
                    if (($tipmov == 1) || ($tipmov == 1)) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";

                        $sql1 = "SELECT invnum,numero_documento,numero_documento1,forpag,cuscod,hora,usecod FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];
                                $numero_documento = $row1['numero_documento'];
                                $numero_documento1 = $row1['numero_documento1'];
                                $forpag = $row1['forpag'];
                                $cuscod = $row1['cuscod'];
                                $usecod = $row1['usecod'];
                                $hora = date("g:i a", strtotime($row1['hora']));
                            }
                        }
                    }
                    $refere = '';
                    $hora = '';
                    if (($tipmov == 1) || ($tipmov == 5)) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $sql1 = "SELECT invnum,numero_documento,numero_documento1,forpag,cuscod,refere,hora,usecod FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];
                                $numero_documento = $row1['numero_documento'];
                                $numero_documento1 = $row1['numero_documento1'];
                                $forpag = $row1['forpag'];
                                $cuscod = $row1['cuscod'];
                                $refere = $row1['refere'];
                                $horax = $row1['hora'];
                                $usecod = $row1['usecod'];
                                if ($horax == '0000-00-00 00:00:00') {
                                    $hora = '';
                                } else {
                                    $hora = date("g:i:s a", strtotime($row1['hora']));
                                }
                            }
                        }
                    }


                    $hora = '';
                    if (($tipmov == 2) || ($tipmov == 1)) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $sql1 = "SELECT invnum,cuscod,refere,hora,usecod FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];


                                $cuscod = $row1['cuscod'];
                                $refere = $row1['refere'];
                                $horax = $row1['hora'];
                                $usecod = $row1['usecod'];
                                if ($horax == '0000-00-00 00:00:00') {
                                    $hora = '';
                                } else {
                                    $hora = date("g:i:s a", strtotime($row1['hora']));
                                }
                            }
                        }
                    }

                    if ((($tipmov == 2) && ($tipdoc == 3))) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";

                        $sucursal = '';
                        $de_local_salida = '';
                        $a_local_salida = '';
                        $hora = '';
                        $sql1 = "SELECT invnum,invnumrecib,usecod,cuscod,tipmov,tipdoc,sucursal,sucursal1,refere,hora FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $de_local = '';
                            $sucursal = '';
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum         = $row1['invnum'];
                                $invnumrecib    = $row1['invnumrecib'];
                                $usecod         = $row1['usecod'];
                                $cuscod         = $row1['cuscod'];
                                $tipmovm        = $row1['tipmov'];
                                $tipdocm        = $row1['tipdoc'];
                                $sucursal       = $row1['sucursal'];
                                $sucursal1      = $row1['sucursal1'];
                                $refere         = $row1['refere'];
                                $horax = $row1['hora'];
                                if ($horax == '0000-00-00 00:00:00') {
                                    $hora = '';
                                } else {
                                    $hora = date("g:i:s a", strtotime($row1['hora']));
                                }

                                $de_local_salida = '';
                                $sql1 = "SELECT nombre FROM xcompa WHERE codloc='$sucursal'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $de_local_salida = $row1['nombre'];
                                    }
                                } else {
                                    $de_local_salida = '';
                                }

                                $a_local_salida = '';
                                $sql1_destino = "SELECT nombre FROM xcompa WHERE codloc='$sucursal1'";
                                $result1_destino = mysqli_query($conexion, $sql1_destino);
                                if (mysqli_num_rows($result1_destino)) {
                                    while ($row1_destino = mysqli_fetch_array($result1_destino)) {
                                        $a_local_salida = $row1_destino['nombre'];
                                    }
                                } else {
                                    $a_local_salida = '';
                                }
                            }
                        }
                    } else {
                        $de_local_salida = '';
                        $a_local_salida = '';
                    }


                    if ((($tipmov == 1) && ($tipdoc == 2))) {
                        $sucursal = '';
                        $sucursal1 = '';
                        $de_local_ingreso = '';
                        $a_local_ingreso = '';
                        $sql1 = "SELECT invnum,invnumrecib,usecod,cuscod,tipmov,tipdoc,sucursal,sucursal1,refere FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $de_local_ingreso = '';
                            $a_local_ingreso = '';
                            $sucursal = '';
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];
                                $invnumrecib = $row1['invnumrecib'];
                                $usecod = $row1['usecod'];
                                $cuscod = $row1['cuscod'];
                                $tipmovm = $row1['tipmov'];
                                $tipdocm = $row1['tipdoc'];
                                $sucursal = $row1['sucursal'];
                                $sucursal1 = $row1['sucursal1'];
                                $refere = $row1['refere'];

                                $a_local_ingreso = '';
                                $sql1 = "SELECT nombre FROM xcompa WHERE codloc='$sucursal'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $a_local_ingreso = $row1['nombre'];
                                    }
                                } else {
                                    $a_local_ingreso = '';
                                }

                                $de_local_ingreso = '';
                                $sql1_destino = "SELECT nombre FROM xcompa WHERE codloc='$sucursal1'";
                                $result1_destino = mysqli_query($conexion, $sql1_destino);
                                if (mysqli_num_rows($result1_destino)) {
                                    while ($row1_destino = mysqli_fetch_array($result1_destino)) {
                                        $de_local_ingreso = $row1_destino['nombre'];
                                    }
                                } else {
                                    $de_local_ingreso = '';
                                }
                            }
                        }
                    } else {
                        $de_local_ingreso = '';
                        $a_local_ingreso = '';
                    }


                    if ($de_local_ingreso <> '') {

                        $de_local = $de_local_ingreso;
                    } else {

                        $de_local = $de_local_salida;
                    }

                    if ($a_local_ingreso <> '') {

                        $a_local = $a_local_ingreso;
                    } else {

                        $a_local = $a_local_salida;
                    }




                    $sql1 = "SELECT nomloc FROM xcompa WHERE codloc='$sucursal1'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $nomloc2 = $row1['nomloc'];
                        }
                    }

                    if (($tipmov == 9) || ($tipmov == 10)) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM venta where invfec = '$fecha' and nrovent = '$nrodoc'";
                        $sql1 = "SELECT invnum,usecod,cuscod,hora,nrofactura FROM venta where invfec = '$fecha' and invnum = '$invnum'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];
                                $usecod = $row1['usecod'];
                                $cuscodven = $row1['cuscod'];
                                $hora = $row1['hora'];
                                $nrofactura = $row1['nrofactura'];
                            }
                        }

                        $sql1_DV = "SELECT costpr,canpro FROM detalle_venta WHERE invnum= '$invnum' and codpro = '$country_ID'  ";
                        $result1_DV = mysqli_query($conexion, $sql1_DV);
                        if (mysqli_num_rows($result1)) {
                            while ($row1_DV = mysqli_fetch_array($result1_DV)) {
                                $cospro_dv = $row1_DV['costpr'];
                                $canpro2 = $row1_DV['canpro'];


                                $cospro_dv = $canpro2 * $cospro_dv;
                            }
                        }



                        $sql1 = "SELECT descli FROM cliente where codcli = '$cuscodven'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $descli2 = $row1['descli'];
                            }
                        }
                    }
                    if (($tipmov == 11) || ($tipmov == 11)) {
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
                        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
                        $sql1 = "SELECT invnum,usecod,cuscod,sucursal,sucursal1,hora,refere FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];
                                $usecod = $row1['usecod'];
                                $cuscod = $row1['cuscod'];
                                $sucursal = $row1['sucursal'];
                                $sucursal1 = $row1['sucursal1'];
                                // $hora = $row1['hora'];
                                $refere = $row1['refere'];

                                $horax = $row1['hora'];
                                if ($horax == '0000-00-00 00:00:00') {
                                    $hora = '';
                                } else {
                                    $hora = date("g:i:s a", strtotime($row1['hora']));
                                }
                            }
                        }
                    }

                    /*   $sqlkl="SELECT IdLote FROM kardexlote WHERE codkard ='$codkard' and IdLote <>'0'";
                          $resultkl = mysqli_query($conexion,$sqlkl);
                          if (mysqli_num_rows($resultkl)){
                          while ($rowkl = mysqli_fetch_array($resultkl)){
                          $idlote   = $rowkl['IdLote'];
                          }}
                         */
                    $sqllo = "SELECT numlote FROM movlote WHERE idlote='$numlote'";
                    $resultlo = mysqli_query($conexion, $sqllo);
                    if (mysqli_num_rows($resultlo)) {
                        while ($rowlo = mysqli_fetch_array($resultlo)) {
                            $numlote2 = $rowlo['numlote'];
                        }
                    }


                    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $user = $row1['nomusu'];
                        }
                    }


                    if ($cuscod <> 0) {
                        $sql1 = "SELECT despro FROM proveedor where codpro = '$cuscod'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $descli = $row1['despro'];
                            }
                        }
                    } else {
                        $cudcod = 0;
                        $descli = "";
                    }
                    ///////////////////////////////////////////////////////////////////////////////////
                    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 1)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "ANULACION DE COMPRA";
                        $ver = 0;
                    }
                    if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 1)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ANULACION DE SALIDAS VARIAS";
                        $ver = 0;
                    }
                    if (($tipmov == 2) && ($tipdoc == 6) && ($eliminado == 1)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ANULACION DE SALIDAS VARIAS POR LOTE";
                        $ver = 0;
                    }
                    if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 3)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ACTIVACION DE SALIDAS VARIAS";
                        $ver = 0;
                    }
                    if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 3)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ACTIVACION DE SALIDAS VARIAS POR LOTE";
                        $ver = 0;
                    }
                    if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 1)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ANULACION SALIDA POR TRANSFERENCIA";
                        $ver = 0;
                    }
                    if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 1)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "ANULACION OTROS INGRESOS";
                        $ver = 0;
                    }
                    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 3)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ACTIVACION DE COMPRA";
                        $ver = 0;
                    }
                    //2-3-3

                    if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 1)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "INGRESO POR TRANSFERENCIA DE SUCURSAL ANULADO";
                        $ver = 0;
                    }
                    if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 2)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "INGRESO POR TRANSFERENCIA DE SUCURSAL HABILITADA";
                        $ver = 0;
                    }
                    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 2)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "SALIDA POR TRANFERENCIA HABILITADA";
                        $ver = 0;
                    }
                    if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 3)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "ACTIVACION OTROS INGRESOS";
                        $ver = 0;
                    }
                    if (($tipmov == 9) && ($tipdoc == 9)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "VENTA";
                        $ver = 1;
                    }
                    if (($tipmov == 10) && ($tipdoc == 9)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "VENTA DESHABILITADA";
                        $ver = 1;
                    }

                    if (($tipmov == 6) && ($tipdoc == 6)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "NOTA DE CREDITO";
                        $ver = 1;
                    }

                    if (($tipmov == 10) && ($tipdoc == 10)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "VENTA HABILITADA";
                        $ver = 1;
                    }
                    ////si cambia esto ojo en reporte de kardex por marca
                    if (($tipmov == 11) && ($tipdoc == 11)) {
                        $signo = "+ ";
                        $sig = 'mas';
                        $desctip = "INGRESO DE BONIF";
                    }
                    if (($tipmov == 9) && ($tipdoc == 11)) {
                        $signo = "- ";
                        $sig = 'menos';
                        $desctip = "VENTAS POR BONIF";
                        $ver = 1;
                    }
                    // error_log("Contadores: " . $factor . " " . $qtypro . " " . $descuenta . " Car: " . $car . " " . $sactual);
                    if ($factor == 1) {
                        if ($qtypro <> "") {
                            $cant = $qtypro;
                            $descuenta = $cant * $factor;
                            $car = $descuenta;
                            $cant_desc = "C" . $cant;
                        }
                        //echo $qtypro;
                        if ($fraccion <> "") {
                            $cant = convertir_a_numero($fraccion);
                            $descuenta = $cant;
                            $car = $descuenta;
                            $cant_desc = "C" . $cant;
                        }
                    } else {
                        if ($qtypro <> "") {
                            $cant = $qtypro;
                            $descuenta = $cant * $factor;
                            $car = $descuenta;
                            $cant_desc = "C" . $cant;
                        }
                        //echo $qtypro;
                        if ($fraccion <> "") {
                            $cant = convertir_a_numero($fraccion);
                            $descuenta = $cant;
                            $car = $descuenta;
                            $cant_desc = "f" . $cant;
                        }
                    }
                    error_log("Contadores: " . $factor . " " . $qtypro . " " . $descuenta . " Car: " . $car . " " . $sactual);
                    if ($sig == 'mas') {
                        //$saldoactual = $car + $saldoactual;
                        $saldoactual = $car + $sactual;
                    } else {
                        //$saldoactual = $saldoactual - $car;
                        $saldoactual = $sactual - $car;
                    }
                    if ($ver == 1) {
                        $dir = 'ver_venta_usu.php?invnum=' . $invnum;
                    } else {
                        // $dir = 'ver_movimiento1.php?invnum=' . $invnum . '&tex=' . $desctip;
                        $dir = 'ver_movimiento.php?invnum=' . $invnum . '&tex=' . $desctip;
                    }

                    $convert1 = $saldoactual / $factor;
                    //$div1       = floor($convert1);

                    $div1 = ((int) ($convert1));
                    $UNI1 = ($saldoactual - ($div1 * $factor));
            ?>
                    <tr <?php echo $cssTachado; ?>>
                        <td><?php echo fecha($fecha) ?></td>
                        <td><?php echo ($eliminado == 0) ?   $hora :  $horaFechaInterna; ?></td>
                        <td><?php
                            if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 0)) {
                                echo strtoupper($numlote2);
                            }
                            if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 0)) {
                                echo strtoupper($numlote2);
                            }
                            ?></td>
                        <td>
                            <a href="javascript:popUpWindow('<?php echo $dir ?>', 10, 50, 1000, 350)">
                                <?php echo formato($invnum); ?></a>
                        </td>
                        <td>
                            <div><?php echo $desctip ?></div>
                        </td>
                        <td>
                            <div><?php
                                    if (($tipmov == 1) && ($tipdoc == 1)) {
                                        echo  $numero_documento . '-' . $numero_documento1;
                                    } elseif (($tipmov == 9) && ($tipdoc == 9) || (($tipmov == 10) && ($tipdoc == 9))) {
                                        echo $nrofactura;
                                    } else {
                                        echo formato($nrodoc);
                                    }
                                    ?></div>
                        </td>
                        <td>
                            <div><?php
                                    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 0)) {
                                        echo substr($descli, 0, 70);
                                    }
                                    if (($tipmov == 9) && ($tipdoc == 9) && ($eliminado == 0)) {
                                        echo substr($descli2, 0, 70);
                                    }
                                    if (($tipmov == 10) && ($tipdoc == 9) && ($eliminado == 0)) {

                                        echo substr($descli2, 0, 70);
                                    }
                                    if (($tipmov == 1) && ($tipdoc == 5)) {
                                        echo strtoupper($refere);
                                    }
                                    if (($tipmov == 2) && ($tipdoc == 1)) {
                                        echo strtoupper($refere);
                                    }
                                    if (($tipmov == 2) && ($tipdoc == 3)) {
                                        echo strtoupper($refere);
                                    }
                                    ?></div>
                        </td>


                        <td>
                            <div align="center"><?php
                                                echo $de_local;
                                                ?></div>
                        </td>
                        <td>
                            <div align="center"><?php
                                                echo $a_local;
                                                ?></div>
                        </td>

                        <td>
                            <div align="center"><?php echo $factor; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo substr($user, 0, 70) ?></div>
                        </td>
                        <td>
                            <div align="center"><?php
                                                echo $signo;
                                                echo $cant_desc
                                                ?></div>
                        </td>
                        <td>
                            <div align="center"><?php if (($tipmov == 9) && ($tipdoc == 9) && ($eliminado == 0)) {
                                                    echo $cospro_dv;
                                                } else {
                                                    echo $preciocompra;
                                                }  ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo stockcaja($saldoactual, $factor); ?></div>
                        </td>
                    </tr>
                <?php

                }
            } else {
                ?>
                <td colspan="14">
                    <center>
                        <h2>NO SE PUDO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</h2>
                    </center>
                </td>
            <?php
            }

            ?>
        </table>
    <?php
    }
    ?>
</body>

</html>