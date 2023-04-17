<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('../montos_text.php');
require_once('../../../titulo_sist.php');

require('fpdf/fpdf.php');    //CONEXION A FPDF
require_once('../../reportes/MontosText.php');
include "../../phpqrcode/qrlib.php";
require_once('calcula_monto2.php');


$venta = $_SESSION['venta'];

function limpia_espacios($cadena)
{
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}
function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
//OBTENGO LOS DATOS DE LA VENTA
$sqlV = "SELECT tipdoc,cuscod FROM venta where invnum = '$venta'";
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row1 = mysqli_fetch_array($resultV)) {
        $tipdoc = $row1['tipdoc'];          //4=TICKET, 2=BOLETA, 1=FACTURA
        $cuscod = $row1['cuscod'];
    }
}
$sqlCli = "SELECT email FROM cliente where codcli = '$cuscod' and descli <> 'PUBLICO EN GENERAL'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {

        $emailcli = $row["email"];
    }
}

if (strlen($emailcli) > 0) {


    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

    $PNG_WEB_DIR = 'temp/';

    $filename = $PNG_TEMP_DIR . 'ventas.png';
    $matrixPointSize = 3;
    $errorCorrectionLevel = 'L';
    $framSize = 3; //Tama?????o en blanco
    $seriebol = "B001";
    $seriefac = "F001";
    $serietic = "T001";
    $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,val_habil,icbpertotal FROM venta where invnum = '$venta'";

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
            $icbper_total = $row['icbpertotal'];
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
        if ($tipdoc == 1) {
            $serie = "F" . $seriefac;
        }
        if ($tipdoc == 2) {
            $serie = "B" . $seriebol;
        }
        if ($tipdoc == 4) {
            $serie = "T" . $serietic;
        }
        if ($tipdoc == 6) {
            $serie = "C" . $serienot;
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

    $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";

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
            $sqlProdDet = "SELECT igv,icbper FROM producto where codpro = '$codproDet'";
            $resultProdDet = mysqli_query($conexion, $sqlProdDet);
            if (mysqli_num_rows($resultProdDet)) {
                while ($row1 = mysqli_fetch_array($resultProdDet)) {
                    $igvVTADet = $row1['igv'];
                    $icbper = $row1['icbper'];
                }
            }

            if (($igvVTADet == 0)) {
                $MontoDetalle = $prisalDet * $canproDet;
                $SumInafectos = $SumInafectos + $MontoDetalle;
                $SumInafectos = number_format($SumInafectos, 2, '.', '');
            }
        }
    }
    $SumGrabado = $SumGrabado - $icbper_total;
    mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
    /* $sqllogo = "SELECT logo FROM xcompa where codloc = '$sucursal'";
                $resullogo = mysqli_query($conexion, $sqllogo);
                if (mysqli_num_rows($resullogo)) {
                    while ($row = mysqli_fetch_array($resullogo)) {
                        $logo =$row['logo'];
                    }
                }*/

    define('EURO', chr(128));

    //$pdf = new FPDF('P','mm',array(80,150));
    $pdf = new FPDF('P', 'mm', array(80, 350));
    $pdf->AddPage();

    // CABECERA
    //global $logo;
    global $linea1;
    global $linea2;
    global $linea3;
    global $linea4;
    global $linea5;
    global $linea6;
    global $linea7;
    global $linea8;
    global $linea9;
    global $tipdoc;

    $pdf->SetFont('Helvetica', '', 7);
    if ($linea1 <> "") {
        $pdf->Cell(57, 4, $linea1, 0, 1, 'C');
    }
    if ($linea2 <> "") {
        $pdf->Cell(57, 4, $linea2, 0, 1, 'C');
    }
    if ($linea3 <> "") {
        $pdf->Cell(57, 4, $linea3, 0, 1, 'C');
    }
    if ($linea4 <> "") {
        $pdf->Cell(57, 4, $linea4, 0, 1, 'C');
    }
    if ($linea5 <> "") {
        if ($tipdoc <> 4) {
            $pdf->Cell(57, 4, $linea5, 0, 1, 'C');
        }
    }
    if ($linea6 <> "") {
        $pdf->Cell(57, 4, $linea6, 0, 1, 'C');
    }
    if ($linea7 <> "") {
        $pdf->Cell(57, 4, $linea7, 0, 1, 'C');
    }
    if ($linea8 <> "") {
        $pdf->Cell(57, 4, $linea8, 0, 1, 'C');
    }
    if ($linea9 <> "") {
        $pdf->Cell(57, 4, $linea9, 0, 1, 'C');
    }



    // DATOS FACTURA     
    $horan = substr($hora, 0, 5);

    $TextDocN = $TextDoc . '-' . $nrofactura;
    global $invfec;
    global $horan;
    global $nomusu;
    global $nomusu;
    global $anotacion;
    global $descli;
    global $ruccli;
    global $tipdoc;
    global $dircli;
    global $pstcli;
    global $TextDocN;

    $pdf->Ln(3);
    $pdf->Cell(20, 4, 'FECHA:', 0, 0, '');
    $pdf->Cell(5, 4, $invfec, 0, 1, '');

    $pdf->Cell(20, 4, 'HORA:', 0, 0, '');
    $pdf->Cell(5, 4, $horan, 0, 1, '');

    $pdf->Cell(20, 4, 'VENDEDOR:', 0, 0, '');
    $pdf->Cell(5, 4, $nomusu, 0, 1, '');

    $pdf->Cell(20, 4, 'F. PAGO:', 0, 0, '');
    $pdf->Cell(5, 4, $forma, 0, 1, '');

    if ($anotacion <> "") {
        $pdf->Cell(20, 4, 'ANOTACION:', 0, 0, '');
        $pdf->Cell(5, 4, $anotacion, 0, 1, '');
    }
    $pdf->Cell(20, 4, 'CLIENTE:', 0, 0, '');
    $pdf->Cell(5, 4, $descli, 0, 1, '');

    if (($ruccli <> "") and ($tipdoc == 1)) {
        $pdf->Cell(20, 4, 'RUC:', 0, 0, '');
        $pdf->Cell(5, 4, $ruccli, 0, 1, '');
    }
    if (strlen($dircli) > 0) {
        $pdf->Cell(20, 4, 'DIRECCION:', 0, 0, '');
        $pdf->Cell(5, 4, $dircli, 0, 1, '');
    }
    if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL")) {
        $pdf->Cell(20, 4, 'PUNTOS:', 0, 0, '');
        $pdf->Cell(5, 4, $pstcli, 0, 1, '');
    }
    $pdf->Cell(60, 0, '', 'T');
    $pdf->Ln(2);
    $pdf->Cell(60, 4, $TextDocN, 0, 1, 'C');

    $pdf->Cell(60, 0, '', 'T');
    $pdf->Ln(0);



    $i = 1;
    $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
    $resultDet = mysqli_query($conexion, $sqlDet);
    if (mysqli_num_rows($resultDet)) {

        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(8, 10, 'CANT', 0, 0, 'L');
        $pdf->Cell(18, 10, 'DESCRIPCION', 0, 0, 'L');
        $pdf->Cell(10, 10, 'MARCA', 0, 0, 'L');
        $pdf->Cell(10, 10, 'P.UNIT', 0, 0, 'L');
        $pdf->Cell(10, 10, 'S.TOTAL', 0, 0, 'L');
        $pdf->Ln(8);
        $pdf->Cell(60, 0, '', 'T');
        $pdf->Ln(2);
        while ($row = mysqli_fetch_array($resultDet)) {
            $codpro = $row['codpro'];
            $canpro = $row['canpro'];
            $factor = $row['factor'];
            $prisal = $row['prisal'];
            $pripro = $row['pripro'];
            $fraccion = $row['fraccion'];
            $idlote = $row['idlote'];
            $factorP = 1;
            $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
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
            // if (mysqli_num_rows($resulLote))
            //{
            //    while ($row1 = mysqli_fetch_array($resulLote))
            //    {
            //        $numlote    = $row1['numlote'];
            //       $vencim     = $row1['vencim'];
            //    }
            // }
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
            // PRODUCTOS

            global $cantemp;
            global $producto;
            global $marca;
            global $prisal;
            global $Cantidad;
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->Cell(10, 0, $cantemp, 0, 0, 'R');
            $pdf->MultiCell(30, 4, $producto, 0, 'L');
            $pdf->Cell(35, -5, $marca, 0, 0, 'R');
            $pdf->Cell(10, -5, number_format($prisal, 2, '.', ''), 0, 0, 'R');
            $pdf->Cell(15, -5, number_format($prisal * $Cantidad, 2, '.', ''), 0, 0, 'R');
            $pdf->Ln(1);
        }
    }
    mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");



    // SUMATORIO DE LOS PRODUCTOS Y EL IVA
    global $SumGrabado;
    global $SumInafectos;
    global $igv;
    global $invtot;
    global $pagacon;
    global $vuelto;
    //$pdf->Ln(2);
    $pdf->Cell(60, 0, '', 'T');
    $pdf->Ln(2);

    $pdf->Cell(35, 10, '', 0);
    $pdf->Cell(10, 10, 'GRAVADA:', 0);
    $pdf->Cell(15, 10, number_format($SumGrabado, 2, '.', ''), 0, 0, 'R');
    $pdf->Ln(3);

    $pdf->Cell(35, 10, '', 0);
    $pdf->Cell(10, 10, 'INAFECTO:', 0);
    $pdf->Cell(15, 10, number_format($SumInafectos, 2, '.', ''), 0, 0, 'R');
    $pdf->Ln(3);

    $pdf->Cell(35, 10, '', 0);
    $pdf->Cell(10, 10, 'IGV:', 0);
    $pdf->Cell(15, 10, $igv, 0, 0, 'R');
    $pdf->Ln(3);

    $pdf->Cell(35, 10, '', 0);
    $pdf->Cell(10, 10, 'TOTAL:', 0);
    $pdf->Cell(15, 10, $invtot, 0, 0, 'R');
    $pdf->Ln(4);

    $pdf->Cell(8, 10, 'SON:', 0);
    $pdf->Cell(25, 10, numtoletras($invtot), 0);
    //$pdf->Cell(15, 10, numtoletras($invtot),0,0,'C');
    $pdf->Ln(3);

    $pdf->Cell(5, 10, 'PAGO:', 0);
    $pdf->Cell(15, 10, 'S/' . $pagacon, 0, 0, 'R');
    $pdf->Ln(3);

    $pdf->Cell(5, 10, 'VUELTO:', 0);
    $pdf->Cell(15, 10, 'S/' . $vuelto, 0, 0, 'R');
    $pdf->Ln(3);



    // PIE DE PAGINA
    global $pie1;
    global $pie2;
    global $pie3;
    global $pie4;
    global $pie5;
    global $pie6;
    global $pie7;
    global $pie8;
    global $pie9;
    global $venta;
    global $SerieQR;

    global $correlativo;
    global $igv;
    global $invtot;
    global $invfec;
    global $filename;
    global $errorCorrectionLevel;
    global $matrixPointSize;
    global $framSize;
    $pdf->Ln(9);
    $pdf->SetFont('Helvetica', '', 8);
    if ($pie1 <> "") {
        $pdf->Cell(60, 0, $pie1, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie2 <> "") {
        $pdf->Cell(60, 0, $pie2, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie3 <> "") {
        $pdf->Cell(60, 0, $pie3, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie4 <> "") {
        $pdf->Cell(60, 0, $pie4, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie5 <> "") {
        $pdf->Cell(60, 0, $pie5, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie6 <> "") {
        $pdf->Cell(60, 0, $pie6, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie7 <> "") {
        $pdf->Cell(60, 0, $pie7, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie8 <> "") {
        $pdf->Cell(60, 0, $pie8, 0, 1, 'C');
        $pdf->Ln(3);
    }
    if ($pie9 <> "") {
        $pdf->Cell(60, 0, $pie9, 0, 1, 'C');
        $pdf->Ln(3);
    }
    $pdf->Cell(60, 0, 'N. I. -' . $venta, 0, 1, 'C');
    $pdf->Ln(3);
    QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
    $pdf->Cell(17, 10, '', 0);
    $pdf->Image($PNG_WEB_DIR . basename($filename));


    $nombrepdf = limpia_espacios($descli) . $SerieQR . zero_fill($correlativo, 8) . $venta;

    $caperta = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temppdf' . DIRECTORY_SEPARATOR;

    //$pdf->Output( $caperta.'sdasdassssqss.pdf', 'F');  
    //$nombrepdf = 'Esto es una prueba';
    $pdf->Output($caperta . basename($nombrepdf) . '.pdf', 'F');


    //                    PARA ENVIAR CORREO ELECTRONICO
    //Recipiente
    $to = $emailcli;

    //remitente del correo
    $from = 'soprtefarmasis@hotmail.com';
    $fromName = 'FARMASIS';

    //Asunto del email
    $subject = $desemp;

    //Ruta del archivo adjunto
    $file = $caperta . $nombrepdf . '.pdf';

    //Contenido del Email
    $htmlContent = '<h1>Comprobante de Pago en Caja</h1>
                    <p>Estimado(a).' . $descli . ', por el presente se le remite una copia de su comprobante, debido a la compra realizada en nuestra empresa ' . $desemp . '.</p>';

    //Encabezado para informaciè´¸n del remitente
    $headers = "De: $fromName" . " <" . $from . ">";

    //Limite Email
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    //Encabezados para archivo adjunto 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    //lémite multiparte
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    //preparaciè´¸n de archivo
    if (!empty($file) > 0) {
        if (is_file($file)) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($file, "rb");
            $data = @fread($fp, filesize($file));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                "Content-Description: " . basename($files[$i]) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    //Enviar EMail
    $mail = @mail($to, $subject, $message, $headers, $returnpath);

    unlink($file);
}
