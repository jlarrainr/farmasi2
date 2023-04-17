<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
######SUNAT######
require_once('lib/documents.php');
require_once('lib/documentsline.php');
include_once 'lib/en_letras.php';


$rd     = isset($_REQUEST['rd']) ? ($_REQUEST['rd']) : "";
$venta  = isset($_REQUEST['vt']) ? ($_REQUEST['vt']) : "";

require_once('calcula_monto2.php');

$MarcaImpresion = 0;
$sqlP = "SELECT porcent,desemp,rucemp,telefonoemp,direccionemp,MarcaImpresion FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $porcent        = $row['porcent'];
        $desemp         = $row['desemp'];
        $rucemp         = $row['rucemp'];
        $telefonoemp    = $row['telefonoemp'];
        $direccionemp   = $row['direccionemp'];
        $MarcaImpresion = $row["MarcaImpresion"];
    }
}

$sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,nrofactura FROM venta where invnum = '$venta'";
$resultV = mysqli_query($conexion, $sqlV);
if (mysqli_num_rows($resultV)) {
    while ($row = mysqli_fetch_array($resultV)) {
        $invnum         = $row['invnum'];
        $nrovent        = $row['nrovent'];
        $invfec         = cambiarFormatoFecha($row['invfec']);
        $cuscod         = $row['cuscod'];
        $usecod         = $row['usecod'];
        $codven         = $row['codven'];
        $forpag         = $row['forpag'];
        $fecven         = $row['fecven'];
        $sucursal       = $row['sucursal'];
        $correlativo    = $row['correlativo'];
        $nomcliente     = $row['nomcliente'];
        $pagacon        = $row['pagacon'];
        $vuelto         = $row['vuelto'];
        $valven         = $row['valven'];
        $igvVta         = $row['igv'];
        $invtot         = $row['invtot'];
        $hora           = $row['hora'];
        $tipdoc         = $row['tipdoc'];
        $nrofactura     = $row['nrofactura'];
    }
}

$SumInafectos = 0;
//$SumGrabado   = 0;
$sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta'";
$resultDetTot = mysqli_query($conexion, $sqlDetTot);
if (mysqli_num_rows($resultDetTot)) {
    while ($row = mysqli_fetch_array($resultDetTot)) {
        $igvVTADet     = 0;
        $codproDet     = $row['codpro'];
        $canproDet     = $row['canpro'];
        $factorDet     = $row['factor'];
        $prisalDet     = $row['prisal'];
        $priproDet     = $row['pripro'];
        $fraccionDet   = $row['fraccion'];
        $sqlProdDet    = "SELECT igv FROM producto where codpro = '$codproDet'";
        $resultProdDet = mysqli_query($conexion, $sqlProdDet);
        if (mysqli_num_rows($resultProdDet)) {
            while ($row1 = mysqli_fetch_array($resultProdDet)) {
                $igvVTADet        = $row1['igv'];
            }
        }
        if ($igvVTADet == 0) {
            $MontoDetalle = $prisalDet * $canproDet;
            $SumInafectos = $SumInafectos + $MontoDetalle;
        }
    }
}
$SumGrabado = $invtot - ($igvVta + $SumInafectos);

$sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
$resultMarca = mysqli_query($conexion, $sqlMarca);
if (mysqli_num_rows($resultMarca)) {
    while ($row1 = mysqli_fetch_array($resultMarca)) {
        $ltdgen     = $row1['ltdgen'];
    }
}

$sqlCli = "SELECT descli,dircli,ruccli,dnicli FROM cliente where codcli = '$cuscod'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {
        $descli = $row['descli'];
        $dircli = $row['dircli'];
        $ruccli = $row['ruccli'];
        $dnicli = $row['dnicli'];
    }
}

$CountItemDetalle = 0;
$sqlDetC = "SELECT count(*) FROM detalle_venta where invnum = '$venta'";
$resultDetC = mysqli_query($conexion, $sqlDetC);
if (mysqli_num_rows($resultDetC)) {
    while ($row = mysqli_fetch_array($resultDetC)) {
        $CountItemDetalle = $row['0'];
    }
}
if (($ruccli <> "") and ($tipdoc == 1)) {
    $TipoDocCli = 6;
    $DocumentoCli = $ruccli;
} else {
    $TipoDocCli = 1;
    $DocumentoCli = $dnicli;
}

if ($rd == "1") {
    //FACTURA
    $TipoDocumento = "01";
}
if ($rd == "2") {
    //BOLETA
    $TipoDocumento = "03";
}
if ($rd == "4") {
    //TICKET
    $TipoDocumento = "03";
}

function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "-" . $mes . "-" . $anio;
}

###SUNAT####
######
## consultar por el id y obtienes del comprobante, yde los iguales a los campos
## de la clases

$documents = new documents();
$ws = "http://198.38.93.205:8080/saptiwsfilesbeta/FacElecImplService?wsdl";
$rucemp = "20603089635";


//INFORMACION DE LA EMISOR PARA el PDF      
// POR FAV INGRESA LOS DATOS DEL EMISOR DE LA BOTICA
$documents->companyName = $desemp;
$documents->companyPhone = $telefonoemp;
$documents->companyEmail = "";
$documents->companyWeb = "www.farmasis.site";
$documents->companyAddress = $direccionemp;

//DATOS GNERALES DEL DOCUMENTO
//aqui debe de poner la seria del documento 
//BOLETA = B JEMPLO B001
//FACTURA = F EJEMPLO F001
$serie = "F001";
if ($TipoDocumento == '03') {
    $serie = "B001";
}
$id_document = $serie . "-" . $correlativo;
$documents->idDocument = $id_document; //NUMERO DE COMPROBANTES
$documents->profileID = "0101"; //NO MODIFICAR
$documents->issueDate = date("Y-m-d");
// FECHA DE EMISION
$documents->documentDueDate = date("Y-m-d");
// FECHA DE EMISION
$documents->issueTime = date("h:i:s");
//HORA DE EMISION
$letras = new en_letras();
$documents->note = $letras->valor_en_letras($invtot);
$documents->lineCountNumeric = $CountItemDetalle; //NUMERO DE ITEMS DE DETALLE
$documents->documentCurrencyCode = "PEN"; //TIPO DE MONEDA
$documents->documentCurrency = "PEN"; //TIPO DE MONEDA
$documents->invoiceTypeCode = $TipoDocumento; //TIPO DE DOCUMENTO 01=FACTURA,03=BOLETA,07=NCREDITO,08=NOTADEBITO
$documents->orderReference = ""; //SI TIENE NUMERO DE ORDEN SE COLOCA OOPCIONAL
$documents->documentNumGuia = "";
$documents->documentNumNotaPedido = "";
$documents->documentCondition = "CONTADO";
$documents->documentNumInterno = "";
$documents->observation = "VENTA";

//DATOS DEL EMISOR NO MODIFICAR
// POR FAV INGRESA LOS DATOS DEL EMISOR DE LA BOTICA NO ES LO MISMO? SI PERO UNO
// ES PARA LA SUNAT OTRO ES PARA EL PDF - ESTO MODIFICO?????????????????????????????????
$documents->supplierPartyName = $desemp; //ESTO ES RUC? SI
$documents->supplierCompanyID = $rucemp;
$documents->supplierSchemeID = "6";
$documents->supplierRegistrationAddress = "0000";
$documents->supplierTaxSchemeID = "-";
$documents->documentPorcentTax = $porcent;


//DATOS DE CLIENTE
/*
 * CUANDO SEA BOLETA Y NO TENGA DNI DEBE DE IR ASI 
 * POR FAVOR VALIDAR ESO.
  $documents->customerPartyName = "PUBLICO GENERAL;
  $documents->customerCompanyID = "0"; //esta en blanco
  $documents->customerSchemeID = "0";
 */
if ($descli == '') {
    $documents->customerPartyName = "PUBLICO GENERAL";
    $documents->customerCompanyID = "0"; //esta en blanco
    $documents->customerSchemeID = "0";
} else {
    $documents->customerPartyName = $descli;
    $documents->customerCompanyID = $DocumentoCli; //esta en blanco
    $documents->customerSchemeID = $TipoDocCli;
}

$documents->customerRegistrationAddress = "0000";
$documents->customerPlaca = "";
$des_ubigeo = "";
$documents->customerDireccion = $dircli;
$documents->customerTaxSchemeID = "-";
$documents->customerTelefono = "";
$documents->customerUbigeo = "";
$documents->customerEmail = "";


##datos varios 
$documents->pctDetraction = "";
$documents->accountDetraction = "";
$documents->amountDetraction = "";
$documents->flagDetraction = "";
$documents->netoDetraction = "";

##referncia
if ($TipoDocumento == '07' || $TipoDocumento == '08') {
    $documents->referenceID = ""; //F001-0000200";
    $documents->responseCode = ""; //"01";
    $documents->responseCodeName = ""; //"SISTEMAS";
    $documents->referenceDescription = ""; //"ERROR DE SISTEMAS";
    $documents->referenceDocumentTypeCode = ""; //"01";
}

/**
 * POR FAVOR AQUI VALIDAR APESAR DE QUE LA BOLETA NO TENGA IGV
 * INTERNAMENTE SI ES UNA OPEREACION GRAVADA SE DEBE DE CALCULAR EL 
 * IGV , NO DEBE DE SER 0
 * $documents->taxTotal
 * $documents->gravadaTaxAmount
 */
//DATOS TOTALES
$documents->taxTotal = number_format($invtot - $valven, 2, '.', ''); //ACA VA EL TOTAOL DEL IGV, NO EL PROCENTAJE
/*if ($igvVta > 0)
{
    $documents->gravadaTaxableAmount = $valven;  //TOTAL GRAVADA
    $documents->inafectoTaxableAmount = "0.0";
}
else
{
    $documents->gravadaTaxableAmount = "0.0";
    $documents->inafectoTaxableAmount = $valven;
}*/

mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");

$documents->gravadaTaxableAmount = number_format($SumGrabado, 2, '.', '');  //TOTAL GRAVADA
$documents->inafectoTaxableAmount = number_format($SumInafectos, 2, '.', '');
$documents->gravadaTaxAmount = $igvVta; // //ACA VA EL TOTAOL DEL IGV, NO EL PROCENTAJE
$documents->exoneradoTaxableAmount = "0.0";
$documents->exoneradoTaxAmount = "0.0";

$documents->inafectoTaxAmount = "0.0";
$documents->gratuitoTaxableAmount = "0.0";
$documents->gratuitoTaxAmount = "0.0";
$documents->lineExtensionAmount = $valven; // TOTAL SIN IGV
$documents->taxInclusiveAmount = "0.0";
$documents->allowanceTotalAmount = "0.0";
$documents->prepaidAmount = "0.00";
$documents->payableAmount = $invtot; //TOTAL INCLUOID IGV
$documents->isAllowanceCharge = "false"; // NO MODIFICAR
$documents->documentTotalDescuentos = "0.00"; // NO MODIFICAR
$documents->documentTotalIsc = "0.00"; // NO MODIFICAR
$documents->uidStore = "1"; // NO MODIFICAR
$documents->chargeIndicator = ""; // NO MODIFICAR
$documents->chargeAmount = "0.0"; // NO MODIFICAR
$documents->allowanceChargeReasonCode = ""; // NO MODIFICAR
$documents->multiplierFactorNumeric = ""; // NO MODIFICAR
$documents->chargeBaseAmount = ""; // NO MODIFICAR

$documents->flagSendSunat = "FALSE"; // DETERMINA EL ENVIO A SUNAT EN LINEA O DESPUES

$details = array();
$secuencia = 1;
$sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta'";
$resultDet = mysqli_query($conexion, $sqlDet);
if (mysqli_num_rows($resultDet)) {
    while ($row = mysqli_fetch_array($resultDet)) {
        $codpro     = $row['codpro'];
        $canpro     = $row['canpro'];
        $factor     = $row['factor'];
        $prisal     = $row['prisal'];
        $pripro     = $row['pripro'];
        $fraccion   = $row['fraccion'];
        $idlote     = $row['idlote'];

        $sqlProd = "SELECT desprod,igv,codmar FROM producto where codpro = '$codpro'";
        $resultProd = mysqli_query($conexion, $sqlProd);
        if (mysqli_num_rows($resultProd)) {
            while ($row1 = mysqli_fetch_array($resultProd)) {
                $desprod    = $row1['desprod'];
                $igv        = $row1['igv'];
                $codmar     = $row1['codmar'];
            }
        }

        $marca = "";
        $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
        $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
        if (mysqli_num_rows($resultMarcaDet)) {
            while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                $marca     = $row1['destab'];
                $abrev     = $row1['abrev'];
                if ($abrev == '') {
                    $marca = substr($marca, 0, 4);
                } else {
                    $marca = substr($abrev, 0, 4);
                }
            }
        }

        $numlote = "";
        $sqlLote = "SELECT numlote FROM movlote where idlote = '$idlote'";
        $resulLote = mysqli_query($conexion, $sqlLote);
        if (mysqli_num_rows($resulLote)) {
            while ($row1 = mysqli_fetch_array($resulLote)) {
                $numlote = $row1['numlote'];
            }
        }

        if ($igv == 1) {
            $Porcentaje = $porcent;
        } else {
            $Porcentaje = "0";
        }

        if ($numlote <> "") {
            $Producto = $desprod . "-" . $numlote;
        } else {
            $Producto = $desprod;
        }
        if ($MarcaImpresion == 1) {
            $desprod = $desprod . "-" . $marca;
        }
        $TotalcIGV = $prisal * $canpro;

        $line = new documentsline();

        if ($igv == 1) {
            $TotalsIGV = $TotalcIGV / (1 + ($porcent / 100));
            $taxAmount = $TotalcIGV - $TotalsIGV;
            ##GRAVADO   
            $line->percent = 18;
            $line->taxSchemeId = "1000";
            $line->taxSchemeName = "IGV";
            $line->taxTypeCode = "VAT";
            $line->taxCategoryId = "S";
            $line->taxExemptionReasonCode = "10";
        } else {
            $TotalsIGV = $TotalcIGV;
            $taxAmount = 0;
            ##INAFECTO  
            $line->percent = "0.00";
            $line->taxSchemeId = "9998";
            $line->taxSchemeName = "INA";
            $line->taxTypeCode = "FRE";
            $line->taxCategoryId = "O";
            $line->taxExemptionReasonCode = "30";
        }
        $line->idLine = $secuencia;
        $line->quantity = $canpro;
        $line->unitCode = "NIU";
        $line->lineExtensionAmount = number_format($TotalcIGV - $taxAmount, 2, '.', '');
        $line->priceAmount = number_format($TotalcIGV, 2, '.', ''); //$prisal
        $line->priceTypeCode = "01";
        $line->taxableAmount = number_format($TotalcIGV - $taxAmount, 2, '.', ''); // SI ES 118 ENTONCES EL IGV ES 18 SOLES ESO VA AUIQ
        $line->chargeAmount = "0.00";
        ##IGUALMENTE SE DEBE DE CALCULAR EL IGV EN EL DETALLE POR CAD ITEM
        ##$line->taxAmount
        ##$line->taxSubtotal 
        $line->taxAmount = number_format($taxAmount, 2, '.', '');
        // DEBE DE IR EL IGV 45 PERO ESTA MANNDO EL SUBTOTAL 
        $line->taxSubtotal = number_format($taxAmount, 2, '.', '');
        // DEBE DE IR CERO
        $line->payableAmount = number_format($TotalcIGV, 2, '.', '');


        $line->description = $Producto;
        $line->sellersItemIdentification = "10000000";
        $line->itemClassificationCode = "10000000";
        $line->price = $prisal;
        $line->isAllowanceCharge = "false";
        $line->chargeIndicator = "";
        $line->allowanceChargeReasonCode = "";
        $line->chargeBaseAmount = "";
        $line->taxAmountIsc = "";
        $line->taxableAmountIsc = "";
        $line->taxSubtotalIsc = "";
        $line->multiplierFactorNumeric = "";
        $line->percentIsc = "";
        array_push($details, $line);
    }
}

try {
    libxml_disable_entity_loader(false);

    $options = array(
        'soap_version' => SOAP_1_1,
        'exceptions' => true,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );

    $cliente = new SoapClient($ws, $options);

    $wKey = $rucemp . "-" . $TipoDocumento . "-" . $id_document;
    $result = $cliente->SendInvoiceFile("", "", "TICKET", $documents, $details);
    if ($result->sunatCode == '0' || $result->sunatCode == '-2') {
        header("Content-type: application/pdf");
        header("Content-Disposition: inline;filename=" . $wKey . ".pdf");
        print  $result->file;
    } else {
        echo $result->sunatMessage;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
