<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('../ventas/MontosText.php');


$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}

$credito = $_REQUEST['credito'];

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>

<html>
<!-- SALE SEGUNDA  -->


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script>
        function imprimir() {
            var f = document.form1;
            window.print();
            f.action = "generaImpresion2.php?<?php echo ("credito=$credito") ?>";
            f.method = "post";
            f.submit();
        }
    </script>
    <style>
        body,
        table {
            font-size: 12px;
            font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<?php

function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

include "../../phpqrcode/qrlib.php";
$filename = $PNG_TEMP_DIR . 'ventas.png';

$matrixPointSize = 3;
$errorCorrectionLevel = 'L';
$framSize = 3;


$serienot = "C001";
// $seriefac           = "F001";
// $serietic           = "T001";
$filename = $PNG_TEMP_DIR . 'test' . $credito . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
require_once('calcula_monto2.php');
$sqlV = "SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,serie_doc,tipdoc_afec,fecha_old FROM nota where invnum = '$credito'";
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row = mysqli_fetch_array($resultV)) {
        $invnum = $row['invnum'];
        $nrovent = $row['nrovent'];
        $invfec = $row['invfec'];
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
        $cod_doc = $row['serie_doc'];
        $tipdoc_afec = $row['tipdoc_afec'];
        $fecha_old = $row['fecha_old'];

        $sqlXCOM = "SELECT serienotboleta,serienotfactura FROM xcompa where codloc = '$sucursal'";
        $resultXCOM = mysqli_query($conexion, $sqlXCOM);
        if (mysqli_num_rows($resultXCOM)) {
            while ($row = mysqli_fetch_array($resultXCOM)) {
                $serienotboleta = $row['serienotboleta'];
                $serienotfactura = $row['serienotfactura'];
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
//F9
if ($tipteclaimpresa == "2") {

    if ($tipdoc_afec == 03) {
        $serie = "B" . $serienotboleta;
    } else {
        $serie = "F" . $serienotfactura;
    }
} else { //F8
    $serie = $correlativo;
}

if ($tipdoc == 6) {
    $TextDoc = "Nota de credito";
}

$SerieQR = $serie;

//TOMO LOS PATRAMETROS DEL TICKET
$sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '$sucursal'";
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
    $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '1'";
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
        $nomusu = $row['abrev'];
        $nomusu2 = $row['nomusu'];
    }
}

$MarcaImpresion = 0;
$sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
$resultDataGen = mysqli_query($conexion, $sqlDataGen);
if (mysqli_num_rows($resultDataGen)) {
    while ($row = mysqli_fetch_array($resultDataGen)) {
        $desemp = $row['desemp'];
        $rucemp = $row['rucemp'];
        $telefonoemp = $row['telefonoemp'];
        $MarcaImpresion = $row["MarcaImpresion"];
    }
}
$departamento = "";
$provincia = "";
$distrito = "";
$pstcli = 0;
$sqlCli = "SELECT descli,dnicli,dircli,ruccli,puntos,dptcli,procli,discli FROM cliente where codcli = '$cuscod'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {
        $descli = $row['descli'];
        $dnicli = $row['dnicli'];
        $dircli = $row['dircli'];
        $ruccli = $row['ruccli'];
        $pstcli = $row['puntos'];
        $dptcli = $row['dptcli'];
        $procli = $row['procli'];
        $discli = $row['discli'];
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
$sqlDetTot = "SELECT * FROM detalle_nota where invnum = '$credito' and canpro <> '0'";
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
        $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet'";
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
?>



<body onload="imprimir()">
    <?php
    require_once('bodyimprimenota.php');
    //echo 'credito' . $credito;
    ?>

</body>

</html>