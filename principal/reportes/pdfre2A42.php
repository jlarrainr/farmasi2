<?php
//require_once('fpdf/fpdf.php');
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS

require_once('../phpqrcode/qrlib.php');
require_once('../movimientos/ventas/calcula_monto2.php');

require_once('MontosText.php');
$venta = $_REQUEST['venta'];
$doc = $_REQUEST['doc'];

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<p style:'text-align:center'>" . $Valor . "</p>";
    }
}
function pintaDatosTitle($Valor)
{
    if ($Valor <> "") {
        return $Valor;
    } else {
        return "------ . ------";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        function imprimir() {
            //alert("consult_compras1.php?pageno=<?php echo $pag ?>&numero=<?php echo $numerox ?>");
            var f = document.form1;
            window.print();
            self.close();
            <?php
            // echo "parent.opener.location='reg_venta1.php';";
            ?>
            //f.action = "ingresos_varios.php";
            //f.method = "post";
            //f.submit();
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            line-height: 1.15;
            width: 100%;
            height: 100%;
        }

        body {
            width: 100%;
            margin: 0;
            font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
        }

        section {
            padding: 5px;
            border: 2px solid #0a6fc2;
            width: 98%;
            height: 98%;
            border-radius: 15px;
        }

        .bodyy {
            width: 100%;
            margin-bottom: 10px;
            height: 160px;
            display: flex;
            flex-direction: row;
        }

        .title {
            font-size: 13px;
            max-height: 160px;
        }

        .text_principal {
            text-align: center;
            font-size: 15px;
            font-weight: 600;
        }

        .title2 {
            max-height: 160px;
        }

        .div_ruc {
            height: 80px;
            border: 2px solid #0a6fc2;
            border-radius: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .div_ruc p {
            font-size: 15px;
        }

        .boleta {
            font-size: 16px;
            font-weight: bold;
            color: #474B56;
            text-transform: uppercase;
        }

        .data_cliente {
            width: 100%;
            border: 1px solid #474B56;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .data_cliente2 {
            width: 90%;
            padding: 6px 20px;
        }

        .table_cabe {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .letracabe {
            font-size: 12px;
        }

        .letra2 {
            font-size: 22px;
        }

        .table_1,
        p {
            margin: 1px;
            font-size: 87.5%;
        }

        .table_cabe,
        p {
            margin: 1px;
        }

        .table_1 {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .thra1 {
            padding: 2px;
            font-weight: 900;
            font-size: 14px;
        }

        .thra1cabe {
            font-weight: 900;
            font-size: 9px;
        }

        .tdra {
            padding: 3px;
            font-size: 14px;
        }

        .tdracabe {
            border: 1px solid #000;
            font-size: 9px;
            border: 1.5px solid #ffffff;
        }

        .thra {
            border: 1px solid #000;
            padding: 5px;
            border: 1.5px solid #474B56;
            font-size: 14px;
        }

        .table_cabe th:first-child {
            font-size: 9px;
            width: 9%;
        }

        .table_cabe th:nth-child(2) {
            font-size: 9px;
            width: 20%;
        }

        .table_cabe th:nth-child(3) {
            font-size: 9px;
            width: 9%;
        }

        .table_cabe th:nth-child(4) {
            font-size: 9px;
            width: 20%;
        }

        .table_cabe td:first-child {
            width: 20%;
            font-size: 9px;
        }

        .table_cabe td:nth-child(2) {
            width: 20%;
            font-size: 9px;
        }

        .table_cabe td:nth-child(3) {
            width: 20%;
            font-size: 9px;
        }

        .table_cabe td:last-child(4) {
            width: 20%;
            font-size: 9px;
        }

        .table_2 {
            width: 100%;
            border-collapse: collapse;
            border: none;

        }

        .table_2,
        p {
            margin: 1px;
            font-size: 87.5%;

        }

        .table_2 th {
            font-size: 12px;
            background: black;
            color: white;
        }

        .table_2x {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .table_2x td:first-child {
            width: 50px;
            height: 55px;
            font-size: 11px;

        }

        .table_2x td:nth-child(2) {
            width: 50px;

            font-size: 11px;
        }

        .table_2x td:nth-child(3) {

            width: 200px;

            font-size: 11px;
        }

        .table_2x td:nth-child(4) {
            width: 80px;

            font-size: 11px;
        }

        .table_2x td:nth-child(5) {
            width: 80px;

            font-size: 11px;
        }

        .table_2x td:nth-child(6) {
            width: 70px;

            font-size: 11px;
        }

        .table_2x td:nth-child(7) {
            width: 70px;

            font-size: 11px;
        }

        .table_2x td:nth-child(8) {
            width: 70px;

            font-size: 11px;
        }

        .table_2 th:first-child {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(2) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(3) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(4) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(5) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(6) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(7) {
            background: black;
            color: white;
        }

        .table_2 th:nth-child(8) {
            background: black;
            color: white;
        }

        .div_total {
            border-top: 1px solid #474B56;
            border-bottom: 1px solid #474B56;
        }

        .div_end {
            text-align: center;
            margin-bottom: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .footer_1 {
            /* width: 30% */
        }

        .footer_2 {
            /* width: 30%; */
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .footer_3 {
            /* width: 30% */
        }

        .letra {
            font-size: 16px;
        }

        .f1 {
            float: left;


        }

        .f3 {
            float: left;
            width: 15%;

            margin-right: 5px;
        }

        .f4 {

            float: left;
            width: 20%;



        }

        .money {
            font-weight: 800;
            padding-left: 65%;
        }

        .money2 {
            border: 1px solid #474B56;
            font-weight: 800;
            margin-left: 6px;
            margin-bottom: 6px;
        }



        .table_T {
            line-height: 100%;
            font-family: times;
            font-size: 11px;
            font-weight: normal;
        }

        .table_T2 {
            line-height: 100%;
            font-family: times;
            font-size: 11px;
            font-weight: normal;
        }
    </style>
</head>

<?php

function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../movimientos/ventas/temp' . DIRECTORY_SEPARATOR;

$PNG_WEB_DIR = '../movimientos/ventas/temp/';

$filename = $PNG_TEMP_DIR . 'ventas.png';
$matrixPointSize = 3;
$errorCorrectionLevel = 'L';
$framSize = 3; //Tama?????o en blanco
$seriebol = "B001";
$seriefac = "F001";
$serietic = "T001";
$filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';



if ($doc == 4) {
    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,val_habil,serie_doc,fecha_old FROM nota where invnum = '$venta'";
} else {
    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,val_habil,numeroCuota,ventaDiasCuotas FROM venta where invnum = '$venta'";
}
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row = mysqli_fetch_array($resultV)) {
        $invnum = $row['invnum'];
        $nrovent = $row['nrovent'];
        $invfec = cambiarFormatoFecha($row['invfec']);
        $cuscod = $row['cuscod'];
        $usecod = $row['usecod'];
        $codven = $row['codven'];
        $forpag = $row['forpag'];
        $fecven = $row['fecven'];
        $sucursal = $row['sucursal'];
        $correlativo = $row['correlativo'];
        $nomcliente = $row['nomcliente'];
        $pagacon = $row['pagacon'];
        $vuelto = $row['vuelto'];
        $valven = $row['valven'];
        $igv = $row['igv'];
        $invtot = $row['invtot'];
        $hora = $row['hora'];
        $tipdoc = $row['tipdoc'];
        $tipteclaimpresa = $row['tipteclaimpresa'];
        $anotacion = $row['anotacion'];
        $nrofactura = $row['nrofactura'];
        $val_habil = $row['val_habil'];
        $serie_doc = $row['serie_doc'];
        $fecha_old = cambiarFormatoFecha($row['fecha_old']);


        if ($doc != '4') {
            $numeroCuota = $row['numeroCuota'];
            $ventaDiasCuotas = $row['ventaDiasCuotas'];
        } else {
            $numeroCuota = 0;
            $ventaDiasCuotas = 0;
        }


        $docafectado = $serie_doc . " FECHA :" . $fecha_old;

        $sqlXCOM = "SELECT seriebol,seriefac,serietic FROM xcompa where codloc = '$sucursal'";
        $resultXCOM = mysqli_query($conexion, $sqlXCOM);
        if (mysqli_num_rows($resultXCOM)) {
            while ($row = mysqli_fetch_array($resultXCOM)) {
                $seriebol = $row['seriebol'];
                $seriefac = $row['seriefac'];
                $serietic = $row['serietic'];
            }
        }
    }
}


$sqlUsu = "SELECT logo FROM xcompa where codloc = '$sucursal'";
$resultUsu = mysqli_query($conexion, $sqlUsu);
if (mysqli_num_rows($resultUsu)) {
    while ($row = mysqli_fetch_array($resultUsu)) {
        $logo = $row['logo'];
    }
}
if ($forpag == "E") {
    $forma = "EFECTIVO";
}
if ($forpag == "C") {
    $forma = "CREDITO";
}
if ($forpag == "T") {
    $forma = "TARJETA";
}
if ($tipdoc == 6) {
    $serie = "C" . $serienot;
}
//F9
if ($tipteclaimpresa == "2") {
    if ($tipdoc == 1) {
        $serie = "F" . $seriefac;
    }
    if ($tipdoc == 2) {
        $serie = "B" . $seriebol;
    }
    if ($tipdoc == 4) {
        $serie = "T" . $serietic;
    }
} else { //F8
    $serie = $correlativo;
}

if ($tipdoc == 1) {
    $TextDoc = "Factura electronica";
}
if ($tipdoc == 2) {
    $TextDoc = "Boleta de Venta electronica";
}
if ($tipdoc == 4) {
    $TextDoc = "";
}
if ($tipdoc == 6) {
    $TextDoc = "Nota de credito";
}
$SerieQR = $serie;
//TOMO LOS PATRAMETROS DEL TICKET
$sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
    . "FROM ticket where sucursal = '$sucursal'";
$resultTicket = mysqli_query($conexion, $sqlTicket);
if (mysqli_num_rows($resultTicket)) {
    while ($row = mysqli_fetch_array($resultTicket)) {
        $linea1 = $row['linea1'];
        $linea2 = $row['linea2'];
        $linea3 = $row['linea3'];
        $linea4 = $row['linea4'];
        $linea5 = $row['linea5'];
        $linea6 = $row['linea6'];
        $linea7 = $row['linea7'];
        $linea8 = $row['linea8'];
        $linea9 = $row['linea9'];
        $pie1 = $row['pie1'];
        $pie2 = $row['pie2'];
        $pie3 = $row['pie3'];
        $pie4 = $row['pie4'];
        $pie5 = $row['pie5'];
        $pie6 = $row['pie6'];
        $pie7 = $row['pie7'];
        $pie8 = $row['pie8'];
        $pie9 = $row['pie9'];
    }
} else {
    $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
        . "FROM ticket where sucursal = '1'";
    $resultTicket = mysqli_query($conexion, $sqlTicket);
    if (mysqli_num_rows($resultTicket)) {
        while ($row = mysqli_fetch_array($resultTicket)) {
            $linea1 = $row['linea1'];
            $linea2 = $row['linea2'];
            $linea3 = $row['linea3'];
            $linea4 = $row['linea4'];
            $linea5 = $row['linea5'];
            $linea6 = $row['linea6'];
            $linea7 = $row['linea7'];
            $linea8 = $row['linea8'];
            $linea9 = $row['linea9'];
            $pie1 = $row['pie1'];
            $pie2 = $row['pie2'];
            $pie3 = $row['pie3'];
            $pie4 = $row['pie4'];
            $pie5 = $row['pie5'];
            $pie6 = $row['pie6'];
            $pie7 = $row['pie7'];
            $pie8 = $row['pie8'];
            $pie9 = $row['pie9'];
        }
    }
}
$sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
$resultUsu = mysqli_query($conexion, $sqlUsu);
if (mysqli_num_rows($resultUsu)) {
    while ($row = mysqli_fetch_array($resultUsu)) {
        $nomusu2 = $row['abrev'];
        $nomusu = $row['nomusu'];
    }
}

$MarcaImpresion = 0;
$sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion,diasCuotasVentas FROM datagen";
$resultDataGen = mysqli_query($conexion, $sqlDataGen);
if (mysqli_num_rows($resultDataGen)) {
    while ($row = mysqli_fetch_array($resultDataGen)) {
        $desemp = $row['desemp'];
        $rucemp = $row['rucemp'];
        $telefonoemp = $row['telefonoemp'];
        $MarcaImpresion = $row["MarcaImpresion"];
        $diasCuotasVentas = $row["diasCuotasVentas"];
    }
}
$departamento = "";
$provincia = "";
$distrito = "";
$pstcli = 0;
$sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos,dnicli FROM cliente where codcli = '$cuscod'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {
        $descli = $row['descli'];
        $dnicli = $row['dnicli'];
        $dircli = $row['dircli'];
        $ruccli = $row['ruccli'];
        $dptcli = $row['dptcli'];
        $procli = $row['procli'];
        $discli = $row['discli'];
        $pstcli = $row['puntos'];
    }
    if (strlen($dircli) > 0) {
        //VERIFICO LOS DPTO, PROV Y DIST
        if (strlen($dptcli) > 0) {
            //                $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
            $sqlDPTO = "SELECT name FROM departamento where id = '$dptcli'";
            $resultDPTO = mysqli_query($conexion, $sqlDPTO);
            if (mysqli_num_rows($resultDPTO)) {
                while ($row = mysqli_fetch_array($resultDPTO)) {
                    $departamento = $row['name'];
                }
            }
        }
        if (strlen($procli) > 0) {
            $sqlDPTO = "SELECT name FROM provincia where id = '$procli'";
            $resultDPTO = mysqli_query($conexion, $sqlDPTO);
            if (mysqli_num_rows($resultDPTO)) {
                while ($row = mysqli_fetch_array($resultDPTO)) {
                    $provincia = " | " . $row['name'];
                }
            }
        }

        if (strlen($discli) > 0) {
            $sqlDPTO = "SELECT name FROM distrito where id = '$discli'";
            $resultDPTO = mysqli_query($conexion, $sqlDPTO);
            if (mysqli_num_rows($resultDPTO)) {
                while ($row = mysqli_fetch_array($resultDPTO)) {
                    $distrito = " | " . $row['name'];
                }
            }
        }
        $Ubigeo = $departamento . $provincia . $distrito;
        if (strlen($Ubigeo) > 0) {
            $dircli = $dircli . "  - " . $Ubigeo;
        }
    }
}
$SumInafectos = 0;
if ($doc == 4) {
    $sqlDetTot = "SELECT * FROM detalle_nota where invnum = '$venta'";
} else {
    $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
}
$resultDetTot = mysqli_query($conexion, $sqlDetTot);
if (mysqli_num_rows($resultDetTot)) {
    while ($row = mysqli_fetch_array($resultDetTot)) {
        $igvVTADet = 0;
        $codproDet = $row['codpro'];
        $canproDet = $row['canpro'];
        $factorDet = $row['factor'];
        $prisalDet = $row['prisal'];
        $priproDet = $row['pripro'];
        $fraccionDet = $row['fraccion'];
        $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet' and eliminado='0'";
        $resultProdDet = mysqli_query($conexion, $sqlProdDet);
        if (mysqli_num_rows($resultProdDet)) {
            while ($row1 = mysqli_fetch_array($resultProdDet)) {
                $igvVTADet = $row1['igv'];
            }
        }
        if ($igvVTADet == 0) {
            $MontoDetalle = $prisalDet * $canproDet;
            $SumInafectos = $SumInafectos + $MontoDetalle;
        }
    }
}
$SumGrabado = $invtot - ($igv + $SumInafectos);


if ($val_habil == 1) {
    $anulado = "ANULADO";
}
?>

<body onload="imprimir()">

    <form name="form1" id="form1">
        <section>
            <div class="bodyy">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="30%">
                                <div class="title2">
                                    <?php if ($logo <> "") { ?>
                                        <img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " />



                                    <?php } else { ?>
                                        <hr>
                                        <img class="mb-4" src="../../../LOGOINDEX.png" alt="" style="width:auto;height:auto;" width="72" height="72">
                                    <?php } ?> 
                                </div>
                            </td>
                            <td width="40%">
                                <div class="title">
                                    <p class="text_principal"><?php echo pintaDatosTitle($linea1); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea2); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea3); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea4); ?></p>

                                    <?php if ($tipdoc <> 4) { ?>
                                        <p style="text-align: left"> <?php echo pintaDatosTitle($linea5); ?> </p>
                                    <?php } ?>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea6); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea7); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea8); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea9); ?></p>
                                </div>
                            </td>
                            <td width="30%">
                                <div class="div_ruc">
                                    <?php if ($tipdoc <> 4) { ?>
                                        <p> <?php echo $linea5; ?> </p>
                                    <?php } ?>
                                    <p class="boleta">
                                        <?php echo $TextDoc; ?>
                                    </p>
                                    <!-- <p ><?php echo $serie . '-' . zero_fill($correlativo, 8) . " " . $anulado; ?></p>-->
                                    <p> <?php echo $nrofactura . " " . $anulado; ?> </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="data_cliente">
                <table class="table_cabe">
                    <tr>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">Nombre:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo $descli; ?></font>
                            </p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">Fecha emision:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo $invfec; ?></font>
                            </p>
                        </th>

                    </tr>
                    <tr>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">Direcci&oacute;n:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo $dircli; ?></font>
                            </p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">Moneda:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo "soles"; ?></font>
                            </p>
                        </th>

                    </tr>
                    <tr>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">RUC:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo $ruccli; ?></font>
                            </p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe"><?php if ($doc == 4) { ?>Doc Afectado :<?php } ?></p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php
                                        if ($doc == 4) {
                                            echo $docafectado;
                                        }
                                        ?></font>
                            </p>
                        </th>

                    </tr>
                    <tr>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe"><?php if ($doc <> 4) { ?> Forma de pago:<?php } ?></p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php
                                        if ($doc <> 4) {
                                            echo $forma;
                                        }
                                        ?></font>
                            </p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">Usuario:</p>
                        </th>
                        <th align="left" class="thra1cabe">
                            <p class="letracabe">
                                <font><?php echo $nomusu; ?></font>
                            </p>
                        </th>
                    </tr>
                </table>
            </div>


            <?php if ($numeroCuota > 0) { ?>

                <div class="title_div" style="width: 100%">
                    <div class="data_cliente">
                        <table class="table_2">
                            <tr>
                                <th># CUOTA</th>
                                <th>FECHA EMISION</th>
                                <th>FECHA VENCIMIENTO</th>
                            </tr>
                            <tr>
                                <th colspan='3'>
                                    <hr>
                                </th>
                            </tr>

                            <?php for ($iCuota = 1; $iCuota <= $numeroCuota; $iCuota++) {
                                $nuevosDias = $diasCuotasVentas * $iCuota;
                                //$date1 =  $invfec;
                                $fechaPago = date("d/m/Y", strtotime($date1 . "+ $nuevosDias days"));

                                //$fechaPago = date("Y/m/d", strtotime($date1 . "+ $nuevosDias day"));
                            ?>


                                <tr>
                                    <td style="text-align: center;"><?php echo $iCuota; ?></td>
                                    <td style="text-align: center;"><?php echo $invfec; ?></td>
                                    <td style="text-align: center;"><?php echo $fechaPago; ?></td>
                                </tr>
                            <?php } ?>
                        </table>



                    </div>
                </div>
            <?php } ?>


            <?php
            if ($tipdoc == 1) { ?>
                <br>
            <?php } ?>





            <table class="table_2" style="width: 100%;" frame="hsides" rules="groups">

                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="left" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
                <?php
                $i = 1;
                if ($doc == 4) {
                    $sqlDet = "SELECT * FROM detalle_nota where invnum = '$venta' and canpro <> '0'";
                } else {
                    $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
                }
                $resultDet = mysqli_query($conexion, $sqlDet);
                if (mysqli_num_rows($resultDet)) {
                ?>
                    <thead>
                        <tr>
                            <th class="thra" style="width: 20px;">N°</th>
                            <th class="thra" style="width: 40px;">CODIGO</th>
                            <th class="thra" style="width: 40px;">MARCA</th>
                            <th class="thra" style="width: 30px;">CANT.</th>
                            <th class="thra" style="width: 340px;">DESCRIPCION</th>
                            <th class="thra" style="width: 40px;">LOTE</th>
                            <th class="thra" style="width: 40px;">VENCIMIENTO</th>
                            <th class="thra" style="width: 74px;">U.M.</th>
                            <th class="thra" style="width: 67px;">V. UNITA</th>
                            <th class="thra" style="width: 64px;">P. UNITA</th>
                            <th class="thra" style="width: 64px;">VALOR VENTA</th>
                        </tr>
                    </thead>

                    <!-- </table>
                            
                            <TABLE class="table_2x"  style="border: 1px solid #00FF00; width: 100%;"  frame="hsides" rules="groups">-->

                    <tbody class="lista_productos">
                        <?php
                        while ($row = mysqli_fetch_array($resultDet)) {
                            $codpro = $row['codpro'];
                            $canpro = $row['canpro'];
                            $factor = $row['factor'];
                            $prisal = $row['prisal'];
                            $pripro = $row['pripro'];
                            $fraccion = $row['fraccion'];
                            $idlote = $row['idlote'];
                            $factorP = 1;
                            $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro' and eliminado='0'";
                            $resultProd = mysqli_query($conexion, $sqlProd);
                            if (mysqli_num_rows($resultProd)) {
                                while ($row1 = mysqli_fetch_array($resultProd)) {
                                    $desprod = $row1['desprod'];
                                    $codmar = $row1['codmar'];
                                    $factorP = $row1['factor'];
                                }
                            }
                            if ($fraccion == "F") {
                                $cantemp = "C" . $canpro;
                            } else {
                                if ($factorP == 1) {
                                    $cantemp = $canpro;
                                } else {
                                    $cantemp = "F" . $canpro;
                                }
                            }
                            $Cantidad = $canpro;
                            $numlote = "......";
                            $vencim = "";
                            $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                            $resulLote = mysqli_query($conexion, $sqlLote);
                            if (mysqli_num_rows($resulLote)) {
                                while ($row2 = mysqli_fetch_array($resulLote)) {
                                    $numlote    = $row2['numlote'];
                                    $vencim     = $row2['vencim'];
                                }
                            }
                            $sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                            $resultMarca = mysqli_query($conexion, $sqlMarca);
                            if (mysqli_num_rows($resultMarca)) {
                                while ($row1 = mysqli_fetch_array($resultMarca)) {
                                    $ltdgen = $row1['ltdgen'];
                                }
                            }
                            $marca = "";
                            $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                            $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                            if (mysqli_num_rows($resultMarcaDet)) {
                                while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                    $marca = $row1['destab'];
                                    $abrev = $row1['abrev'];
                                    if ($abrev == '') {
                                        $marca = substr($marca, 0, 4);
                                    } else {
                                        $marca = substr($abrev, 0, 4);
                                    }
                                }
                            }
                            $producto = $desprod;
                        ?>

                            <tr>
                                <td width="40" align="center">
                                    <p><?php echo $i; ?></p>
                                </td>
                                <td width="40" align="center">
                                    <p><?php echo $codpro; ?></p>
                                </td>
                                <td width="40" align="center">
                                    <p><?php echo $marca; ?></p>
                                </td>
                                <td width="30" align="center">
                                    <p><?php echo $cantemp; ?></p>
                                </td>
                                <td width="350">
                                    <p><?php echo $producto; ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo $numlote; ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo $vencim; ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo 'UND'; ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo $row2[0]; ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo number_format($prisal, 2, '.', ''); ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></p>
                                </td>
                            </tr>

                        <?php
                            $i++;
                        }
                        for ($n = $i; $n <= 20; $n++) {
                            # code...
                        ?>
                            <tr>
                                <td width="40px" color="#fffff" align="center">&nbsp;</td>
                                <td width="40px" align="center">&nbsp;</td>
                                <td width="50" align="center">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                                <td width="60">&nbsp;</td>
                            </tr>
                    <?php
                        }
                    }
                    //  mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
                    ?>

                    </tbody>
            </table>
            <div class="div_total">
                <p class="letra">Son: <?php echo numtoletras($invtot); ?></p>
            </div>

            <div class="div_end">
                <table width="99%">
                    <tbody>
                        <tr>
                            <td width="33%">
                                <div class="footer_1">
                                    <?php
                                    echo pintaDatos($pie1);
                                    echo pintaDatos($pie2);
                                    echo pintaDatos($pie3);
                                    echo pintaDatos($pie4);
                                    echo pintaDatos($pie5);
                                    echo pintaDatos($pie6);
                                    echo pintaDatos($pie7);
                                    echo pintaDatos($pie8);
                                    echo pintaDatos($pie9);
                                    echo pintaDatos('N. I. -' . $venta);
                                    ?>
                                </div>
                            </td>
                            <td width="33%">
                                <div class="footer_2">
                                    <?php
                                    if (($tipdoc == 1) || ($tipdoc == 2)) {
                                        QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
                                        echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" />';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td width="33%">
                                <div class="footer_3">
                                    <table class="table_1">
                                        <tbody>
                                            <tr>
                                                <td class="thra1">OP. GRAVADA</td>
                                                <?php if ($tipdoc == 4) { ?>

                                                    <td class="tdra">
                                                    <center><?php echo 'S/' . number_format($invtot, 2, '.', ''); ?></center>
                                                </td>
                                                   
                                                <?php  }else { ?>

                                                    <td class="tdra">
                                                    <center><?php echo 'S/' . number_format($SumGrabado, 2, '.', ''); ?></center>
                                                </td>
                                                    
                                                    <?php  } ?>
                                                
                                               
                                            </tr>
                                            <tr>
                                                <td class="thra1">OP. INAFECTA</td>
                                                <td class="tdra">
                                                    <center><?php echo 'S/' . number_format($SumInafectos, 2, '.', ''); ?></center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="thra1">OP. EXONERADA</td>
                                                <td class="tdra">
                                                    <center><?php echo 'S/ 0.00' ?></center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="thra1">IGV</td>

                                                <?php if ($tipdoc == 4) { ?>

                                                    <td class="tdra">
                                                    <center><?php echo 'S/ 0.00' ?></center>
                                                </td>
                                                    <?php  }else { ?>
                                                        <td class="tdra">
                                                    <center><?php echo 'S/' . $igv; ?></center>
                                                </td>


                                                        <?php  } ?>
                                                
                                            </tr>
                                            <tr>
                                                <td class="thra1">IMPORTE TOTAL(S/)</td>
                                                <td class="tdra">
                                                    <center><?php echo $invtot; ?></center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </form>

</body>

</html>