<?php
/*
  $invoice->payableAmountExempt = $valven; //total sin igv
  $invoice->currencyLegend = "SOLES"; // monto en letras
  $invoice->igvTaxAmount = $porcent; // igv
  $invoice->payableAmount = $invtot; //total con igv
 */



## COMPROBANTE MANUAL  001-000001
## FACTURA F001-0000001
## BOLETA B001-0000001
## NOTA CREDITO DE FACTURA FC01-00001 
## NOTA CREDITO DE BOLETA BC01-00001
## NOTA DEBITO DE FACTURA FD01-00001
## NOTA DEBITO DE BOLETA BD01-00001
$invoice->id = $invnum; // numero de comprobante


$invoice->issueDate = date("Y-m-d");
## TIPO DOCUMENTO
## 01 = FACTURA
## 03 = BOLETA
## 07 = NOTA DE CREDITO
## 08 = NOTA DE DEBITO
$invoice->invoiceTypeCode = $TipoDocumento; // tipo de documento
##SI ES NOTA DE CREDITO O DEBITO
if ($TipoDocumento == '07' || $TipoDocumento = '08') {
    //REFERENCIA
    $this->idReference = "F001-00001"; // EL DOCUMENTO A MODIFICAR FACTURA O BOLETA F001-000001
    $this->responseCode = "01"; //
    $this->descriptionReference = "MOTIVO DE ANULACION";
    $this->documentTypeReference = "03"; // TIPO DE DOCUMENTO A MODIFICAR 01,03
}

$invoice->idDocument = $invnum; // numero de comprobante
$invoice->profileID = "0101";
$invoice->issueDate = date("Y-m-d");
$invoice->issueTime = date("h:i:s");
$invoice->note = "SOLES";

//CLIENTE
$invoice->additionalAccountID = $TipoDocCli; // 6= ruc , 1= dni
$invoice->idCustomer = $DocumentoCli; // ruc o dni del cliente
$invoice->registrationName = $descli; // nombre
$invoice->customerTelefono = "";
$invoice->customerDireccion = $dircli;
$invoice->customerUbigeo = "";
$invoice->customerEmail = "";
$invoice->customerPlaca = "";

$invoice->numInternal = ""; //Nro interno
$invoice->dateExpiration = ""; //Fecha de Vencimiento
$invoice->numSerie = "";
$invoice->addressDelivery = "";

//OTROS
$invoice->addressCustomer = "";
$invoice->observation = "datos de prueba";
$invoice->flagDownloadDoc = "1";

$details = array();
$secuencia = 1;
$sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta'";
$resultDet = mysqli_query($conexion, $sqlDet);
if (mysqli_num_rows($resultDet)) {
    while ($row = mysqli_fetch_array($resultDet)) {
        $codpro = $row['codpro'];
        $canpro = $row['canpro'];
        $factor = $row['factor'];
        $prisal = $row['prisal'];
        $pripro = $row['pripro'];
        $fraccion = $row['fraccion'];
        $idlote = $row['idlote'];

        $sqlProd = "SELECT desprod,igv FROM producto where codpro = '$codpro'";
        $resultProd = mysqli_query($conexion, $sqlProd);
        if (mysqli_num_rows($resultProd)) {
            while ($row1 = mysqli_fetch_array($resultProd)) {
                $desprod = $row1['desprod'];
                $igv = $row1['igv'];
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
            $Producto = substr($desprod, 0, 25) . "-" . $numlote;
        } else {
            $Producto = substr($desprod, 0, 25);
        }
        $TotalcIGV = $prisal * $canpro;

        if ($igv == 1) {
            $TotalsIGV = $TotalcIGV / (1 + ($porcent / 100));
        } else {
            $TotalsIGV = $TotalcIGV;
        }
        $line = new invoiceline();
        $line->id = $secuencia;
        $line->price = $prisal; //precio del producto
        $line->lineExtensionAmount = $TotalsIGV; //total sin igv		
        $line->taxAmount = $Porcentaje; //igv		
        $line->priceAmount = $TotalcIGV; //total inc igv
        $line->itemDescription = $Producto;
        $line->codeProduct = $codpro;
        $line->invoicedQuantity = $canpro;
        $line->invoicedQuantityPrint = $canpro;
        $line->sequenceItem = $secuencia;
        $line->taxableAmount = $TotalcIGV; // toal con ifv
        $secuencia++;
        array_push($details, $line);
    }
}


/* foreach ($detalle as $item) 
  {
  $line = new invoiceline();
  $line->id = $secuencia;
  $line->price = "118";//precio del producto
  $line->lineExtensionAmount = "100"; //total sin igv
  $line->taxAmount = "18"; //igv
  $line->priceAmount = "118"; //total inc igv
  $line->itemDescription = "producto de prueba";
  $this->codeProduct = "1000";
  $line->invoicedQuantity = "1";
  $line->invoicedQuantityPrint = "1";
  $line->sequenceItem = $secuencia;
  $line->taxableAmount = "118"; // toal con ifv
  $secuencia++;
  array_push($details, $line);
  } */
$cliente = new SoapClient($ws);
$fichero = $cliente->sendInvoicePdf('usrprd', 'usrprd', $invoice, $details);
$tipo = "application/pdf";
header("Content-type: $tipo");
header("Content-Disposition: attachment;filename='" . basename($fichero) . "'");
print $fichero;
//header("Location: venta_index.php");