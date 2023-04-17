<?php
include_once 'lib/documents.php';
include_once 'lib/documentsline.php';

$documents = new documents();

$ws = "http://sap-ti-cloud.com:7180/saptiws/FacElecImplService?wsdl";

//INFORMACION DE LA EMISOR PARA LE PDF
$documents->companyName = "SAP TI CONSULTING";
$documents->companyPhone = "8989239823";
$documents->companyEmail = "rommelrmr@gmail.com";
$documents->companyWeb = "www.";
$documents->companyAddress = "manco capac";

//DATOS GNERALES DEL DOCUMENTO
$documents->idDocument = "F001-0000200"; //NUMERO DE COMPROBANTES
$documents->profileID = "0101"; //NO MODIFICAR
$documents->issueDate = "2018-10-06"; // FECHA DE EMISION
$documents->documentDueDate = "2018-10-06"; // FECHA DE EMISION
$documents->issueTime = "13:25:51"; //HORA DE EMISION
$documents->note = "NOVENTA Y 100";
$documents->lineCountNumeric = 1; //NUMERO DE ITEMS DE DETALLE
$documents->documentCurrencyCode ="PEN"; //TIPO DE MONEDA
$documents->documentCurrency = "PEN"; //TIPO DE MONEDA
$documents->invoiceTypeCode = "01"; //TIPO DE DOCUMENTO 01=FACTURA,03=BOLETA,07=NCREDITO,08=NOTADEBITO
$documents->orderReference = "O001"; //SI TIENE NUMERO DE ORDEN SE COLOCA OOPCIONAL
$documents->documentNumGuia = "G001";
$documents->documentNumNotaPedido = "P0001";
$documents->documentCondition = "CONTADO";
$documents->documentNumInterno = "001";
$documents->observation = "PEDIDO";

//DATOS DEL EMISOR NO MODIFICAR
$documents->supplierPartyName = "SAP TI CONSULTING";
$documents->supplierCompanyID = "20600471580";
$documents->supplierSchemeID = "6";
$documents->supplierRegistrationAddress = "0000";
$documents->supplierTaxSchemeID = "-";
$documents->documentPorcentTax = "18.00";

//DATOS DE CLIENTE
$documents->customerPartyName = "CLIENTE SACC";
$documents->customerCompanyID = "20600471580";
$documents->customerSchemeID = "6";
$documents->customerRegistrationAddress = "0000";
$documents->customerPlaca = "";
$des_ubigeo = "";
$documents->customerDireccion = "AVENIDA" . ' ' . $des_ubigeo;
$documents->customerTaxSchemeID = "-";
$documents->customerTelefono = "9012092";
$documents->customerUbigeo = "150101";
$documents->customerEmail = "rommelrmr@gmail.com";

/*
if ($insert_header['type_document'] == '08' || $insert_header['type_document'] == '07') {
    $documents->referenceID = $insert_header['num_reference'];
    $documents->responseCode = $insert_header['code_type_reference'];
    $documents->responseCodeName = $insert_header['code_type_reference_name'];
    $documents->referenceDescription = $insert_header['description_sustenance'];
    $documents->referenceDocumentTypeCode = $insert_header['type_reference'];
}
*/

$documents->pctDetraction = "";
$documents->accountDetraction = "";
$documents->amountDetraction = "";
$documents->flagDetraction = "";
$documents->netoDetraction = "";


//DATOS TOTALES
$documents->taxTotal = "100.00"; // TOTAL SIN IGV
$documents->gravadaTaxableAmount = "100";  //TOTAL GRAVADA
$documents->gravadaTaxAmount = "18"; // IGV
$documents->exoneradoTaxableAmount = "0.0";
$documents->exoneradoTaxAmount = "0.0";
$documents->inafectoTaxableAmount = "0.0";
$documents->inafectoTaxAmount = "0.0";
$documents->gratuitoTaxableAmount = "0.0";
$documents->gratuitoTaxAmount = "0.0";
$documents->lineExtensionAmount = "0.0"; // TOTAL SIN IGV
$documents->taxInclusiveAmount = "0.0";
$documents->allowanceTotalAmount = "0.0";
$documents->prepaidAmount = "0.00";
$documents->payableAmount = "118.00"; //TOTAL INCLUOID IGV
$documents->isAllowanceCharge = "false"; // NO MODIFICAR
$documents->documentTotalDescuentos = "0.00"; // NO MODIFICAR
$documents->documentTotalIsc = "0.00"; // NO MODIFICAR

$documents->flagSendSunat="TRUE";

$details = array();
$secuencia = 1;


    $line = new documentsline();
    $line->idLine = "1";
    $line->quantity = "1";
    $line->unitCode = "NIU";
    $line->lineExtensionAmount = number_format("100", 2, '.', '');
    $line->priceAmount = number_format(100.00, 2, '.', '');
    $line->priceTypeCode = "01";
    $line->taxAmount = "18.00";
    $line->taxableAmount = number_format(100, 2, '.', '');
    $line->taxSubtotal = number_format(100, 2, '.', '');
    $line->percent = 18;
    $line->chargeAmount = "0.00";
    $line->taxSchemeId = "1000";
    $line->taxSchemeName = "IGV";
    $line->taxTypeCode = "VAT";
    $line->taxCategoryId = "S";
    $line->taxExemptionReasonCode = "10";
    $line->description = "COD PROD 0129";
    $line->sellersItemIdentification = "10000000";
    $line->itemClassificationCode = "10000000";
    $line->price = 118.00;
    $line->isAllowanceCharge = "false";
    array_push($details, $line);
 


$cliente = new SoapClient($ws);
$wKey = "20600471580" . "-" ."01" . "-" ."F001-0000200";

##RESULTADO DEL ENVIO
$result = $cliente->sendInvoice("","",$documents, $details);

var_dump($result);