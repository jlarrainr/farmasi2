<?php

require_once('fpdf/fpdf.php');
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
require_once('MontosText.php');
require_once('../phpqrcode/qrlib.php');
require_once('../movimientos/ventas/calcula_monto2.php');

$venta = $_REQUEST['venta'];

function cambiarFormatoFecha($fecha) {
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

function zero_fill($valor, $long = 0) {
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
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



$sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,val_habil,numeroCuota,ventaDiasCuotas "
        . "FROM venta where invnum = '$venta'";
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
        $nomusu = $row['abrev'];
        $nomusu2 = $row['nomusu'];
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



define('EURO', chr(128));

$pdf = new FPDF('P', 'mm', 'A4');

$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
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
//$pdf->Cell(150,$textypos,$linea1,0,1,'C');


$pdf->SetFont('Helvetica', '', 7);
if ($linea1 <> "") {
    $pdf->Cell(150, $textypos, $linea1, 0, 1, 'C');
}
if ($linea2 <> "") {
    $pdf->Cell(150, $textypos, $linea2, 0, 1, 'C');
}
if ($linea3 <> "") {
    $pdf->Cell(150, $textypos, $linea3, 0, 1, 'C');
}
if ($linea4 <> "") {
    $pdf->Cell(150, $textypos, $linea4, 0, 1, 'C');
}
if ($linea5 <> "") {
    if ($tipdoc <> 4) {
        $pdf->Cell(150, $textypos, $linea5, 0, 1, 'C');
    }
}
if ($linea6 <> "") {
    $pdf->Cell(150, $textypos, $linea6, 0, 1, 'C');
}
if ($linea7 <> "") {
    $pdf->Cell(150, $textypos, $linea7, 0, 1, 'C');
}
if ($linea8 <> "") {
    $pdf->Cell(150, $textypos, $linea8, 0, 1, 'C');
}
if ($linea9 <> "") {
    $pdf->Cell(150, $textypos, $linea9, 0, 1, 'C');
}
$pdf->Image('logo2.jpeg', 10, 10, 47, 18, 'JPG');

$horan = substr($hora, 0, 5);
$TextDocN = $TextDoc . '-' . $nrofactura;
if ($forpag == 'E') {
    $smss = 'EFECTIVO';
}
if ($forpag == 'C') {
    $smss = 'CREDITO';
}
if ($forpag == 'T') {
    $smss = 'TARJETA';
}
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
global $TextDoc;
global $nrofactura;
global $smss;
global $nomusu2;


$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(55);
$pdf->setX(10);
$pdf->Cell(5, $textypos, 'Nombre');
//$pdf->SetFont('Arial','',10);     aqui corta la negrita
$pdf->setY(60);
$pdf->setX(10);
$pdf->Cell(5, $textypos, 'Direccion');
$pdf->setY(65);
$pdf->setX(10);
$pdf->Cell(5, $textypos, 'Ruc');
$pdf->setY(70);
$pdf->setX(10);
$pdf->Cell(5, $textypos, 'Forma de Pago');
$pdf->SetFont('Arial', '', 10);

///////////////////
$pdf->SetFont('Arial', '', 8);
$pdf->setY(55);
$pdf->setX(35);
$pdf->Cell(5, $textypos, ':' . $descli);
//$pdf->SetFont('Arial','',10);     aqui corta la negrita
$pdf->setY(60);
$pdf->setX(35);
$pdf->Cell(5, $textypos, ':' . $dircli);
$pdf->setY(65);
$pdf->setX(35);
$pdf->Cell(5, $textypos, ':' . $ruccli);
$pdf->setY(70);
$pdf->setX(35);
$pdf->Cell(5, $textypos, ':' . $smss);
$pdf->SetFont('Arial', '', 10);

// Agregamos los datos del cliente
$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(55);
$pdf->setX(125);
$pdf->Cell(5, $textypos, 'Fecha emision');
//$pdf->SetFont('Arial','',10);    
$pdf->setY(60);
$pdf->setX(125);
$pdf->Cell(5, $textypos, 'Moneda');
$pdf->setY(65);
$pdf->setX(125);
$pdf->Cell(5, $textypos, '');
$pdf->setY(70);
$pdf->setX(125);
$pdf->Cell(5, $textypos, 'Usuario');
$pdf->SetFont('Arial', '', 10);

/////////////////////////////
// Agregamos los datos del cliente
$pdf->SetFont('Arial', '', 8);
$pdf->setY(55);
$pdf->setX(150);
$pdf->Cell(5, $textypos, ':' . $invfec);
//$pdf->SetFont('Arial','',10);    
$pdf->setY(60);
$pdf->setX(150);
$pdf->Cell(5, $textypos, ':' . 'SOLES');
$pdf->setY(65);
$pdf->setX(150);
$pdf->Cell(5, $textypos, '');
$pdf->setY(70);
$pdf->setX(150);
$pdf->Cell(5, $textypos, ':' . $nomusu2);
$pdf->SetFont('Arial', '', 10);

$texto1 = "" . $linea5 . "\n$TextDoc\n" . $nrofactura;

//$texto1="RUC: ".'$reg1[0]'."\nDireccion: ".'$reg1[1]'."\nNIF: ".'$reg1[2]';
$pdf->SetXY(122, 10);
$pdf->MultiCell(75, 7, $texto1, 1, "C");

/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(70);
$pdf->setX(135);
$pdf->Ln();
/////////////////////////////
//// Array de Cabecera

$header = array("COD", "CANT", "DESCRIPCION", "U.M.", "V. UNIT", "P. UNIT", "V. VENTA");
//// Arrar de Productos
/* $products = array(
  array("0010",2, "Producto Eduardo 1",2,2,120,0),
  array("0024",2, "Producto Eduardo 2",2,5,80,0),
  array("0001",2, "Producto Eduardo 3",2,1,40,0),
  array("0001",2, "Producto Eduardo 4",2,5,80,0),
  array("0001",2, "Producto Eduardo 5",2,4,30,0),
  array("0001",2, "Producto Eduardo 6",2,7,80,0),
  ); */
// Column widths
$w = array(15, 15, 95, 17, 17, 17, 17);
$i = 1;
$sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
$resultDet = mysqli_query($conexion, $sqlDet);
if (mysqli_num_rows($resultDet)) {
    // Header
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    // Data
    $total = 0;
    $i = 0;
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
        global $codpro;
        global $cantemp;
        global $producto;
        global $marca;
        global $prisal;
        global $pripro;
        global $Cantidad;
        global $i;
        $pdf->SetFont('Helvetica', '', 7);

        $pdf->Cell($w[0], 6, $codpro, '1', 0, 'C');
        $pdf->Cell($w[1], 6, $cantemp, '1', 0, 'C');
        $pdf->Cell($w[2], 6, $producto, 1);
        $pdf->Cell($w[3], 6, 'S/.', '1', 0, 'C');
        $pdf->Cell($w[4], 6, number_format($prisal, 2, '.', ''), '1', 0, 'C');
        $pdf->Cell($w[5], 6, number_format($pripro, 2, '.', ''), '1', 0, 'R');
        $pdf->Cell($w[6], 6, number_format($prisal * $Cantidad, 2, '.', ''), '1', 0, 'R');

        $pdf->Ln();
        $total+=$row[3] * $row[2];
        $i++;
    }
}
/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales
////EL ALTO DE LA CAJA SE TOTAL
//$yposdinamic = 60 + ($i*10);
$yposdinamic = 70 + ($i * 10);
$pdf->setY($yposdinamic);
$pdf->setX(235);
$pdf->Ln();
/////////////////////////////
global $SumGrabado;
global $SumInafectos;
global $igv;
global $invtot;
global $pagacon;
global $vuelto;
$header = array("", "");
$data2 = array(
    array("GRAVADA", number_format($SumGrabado, 2, '.', '')),
    array("INAFECTO", number_format($SumInafectos, 2, '.', '')),
    array("IGV", $igv),
    array("TOTAL", $invtot),
);
// Column widths
$w2 = array(25, 25);
// Header

$pdf->Ln();
// Data
/* foreach($data2 as $row)
  {

  $pdf->Cell($w2[0],6,$row[0],1);
  $pdf->Cell($w2[1],6,number_format($row[1], 2, '.', ''),'1',0,'R');


  $pdf->Ln();
  } */
$pdf->setX(10);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(39, 5, 'GRAVADA', 1, 0, 'C');
$pdf->Cell(39, 5, 'INAFECTO', 1, 0, 'C');
$pdf->Cell(39, 5, 'xxxxxxx', 1, 0, 'C');
$pdf->Cell(39, 5, 'IGV', 1, 0, 'C');
$pdf->Cell(38, 5, 'TOTAL', 1, 0, 'C');

$pdf->Ln();
$pdf->setX(10);
$pdf->SetFont('Helvetica', '', 6);
$pdf->Cell(39, 5, number_format($SumGrabado, 2, '.', ''), 1, 0, 'C');
$pdf->Cell(39, 5, number_format($SumInafectos, 2, '.', ''), 1, 0, 'C');
$pdf->Cell(39, 5, 'xxxxxxx', 1, 0, 'C');
$pdf->Cell(39, 5, $igv, 1, 0, 'C');
$pdf->Cell(38, 5, $invtot, 1, 0, 'C');

$pdf->Ln();
/////////////////////////////

$yposdinamic += (count($data2) * 10);
$pdf->SetFont('Arial', 'B', 10);

$pdf->setY($yposdinamic);
$pdf->setX(70);
$pdf->Cell(55, $textypos, "TERMINOS Y CONDICIONES", 0, 0, 'C');
//$pdf->SetFont('Arial','',10);    

$pdf->setY($yposdinamic + 10);
$pdf->setX(70);
$pdf->Cell(55, $textypos, "El cliente se compromete a pagar la factura.", 0, 0, 'C');
$pdf->setY($yposdinamic + 20);
$pdf->setX(70);
$pdf->Cell(55, $textypos, "FARMASIS EN PRUEBA NO TOCAR", 0, 0, 'C');




$pdf->output();
