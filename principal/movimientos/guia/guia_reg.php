<?php

 error_reporting(E_ALL);
 ini_set('display_errors', '1');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
include('../../session_user.php');
require_once('../../../titulo_sist.php');
require_once '../../../convertfecha.php';
require_once('../../../function_sunat.php');

$sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $user    = $row1['nomusu'];
        $codloc   = $row1['codloc'];
    }
}

// INFORMACION PRINCIPAL 
$tipoBusqueda                                   = $_REQUEST['tipoBusqueda'];                                    //issueDate
$invnum                                         = $_REQUEST['invnum'];
//
// INFORMACION PRINCIPAL 
$fechaEmision                                   = fecha1($_REQUEST['fechaEmision']);                            //issueDate
$hora                                           = date('H:m:s');                                                 //issueTime
$despatchAdviceTypeCode                         = "09";                                                          //$despatchAdviceTypeCode(para codigo de guia de remision remitente)
$puertoAeropuerto                               = $_REQUEST['puertoAeropuerto'];                                //firstArrivalPortLocation
$datosContenedor                                = $_REQUEST['datosContenedor'];                                 //transportEquipmentId
$envioPorTercero                                = $_REQUEST['envioPorTercero'];                                 //----------------
//DATOS DEL DESTINATARIO
$tipoDocumentoIdentidad                         = $_REQUEST['tipoDocumentoIdentidad'];                          //despatchSchemeID
$numeroDocumentoDestinatario                    = $_REQUEST['numeroDocumentoDestinatario'];                     //deliverycustomeracountid
$empresaDestino                                 = $_REQUEST['empresaDestino'];                                  //deliveryname 
//DATOS DEL ENVIO
$motivoTranslado                                = $_REQUEST['motivoTranslado'];                                 //handlingCode
$descripcionMotivoTraslado                      = $_REQUEST['descripcionMotivoTraslado'];                       //information
$indicadorTransbordoProgramado                  = $_REQUEST['indicadorTransbordoProgramado'];                   // splitConsignmentIndicator
$pesoBrutoTotalBienes                           = $_REQUEST['pesoBrutoTotalBienes'];                            //grossWeightMeasure
$unidadMedidaPesoBruto                          = $_REQUEST['unidadMedidaPesoBruto'];                           //unitCodeWeightMeasure
$numeroBultosPaquetes                           = $_REQUEST['numeroBultosPaquetes'];                            //totalUnitQuantity
$modalidadTraslado                              = $_REQUEST['modalidadTraslado'];                               //transportModeCode
$fechaInicioTraslado                            = $_REQUEST['fechaInicioTraslado'];                              //startDate
//TRANSPORTISTA (transporte publico)
$tipoDocumentoIdentidadTransportista            = $_REQUEST['tipoDocumentoIdentidadTransportista'];             //deliverySchemeID
$numeroDocumentoTransportista                   = $_REQUEST['numeroDocumentoTransportista'];                    //carrierPartyId
$empresaTransportista                           = $_REQUEST['empresaTransportista'];                            //carrierPartyName
//TRANSPORTISTA (transporte privado)
$tipoDocumentoIdentidadTransportistaPrivado     = $_REQUEST['tipoDocumentoIdentidadTransportistaPrivado'];      //driverPersonschemeId
$numeroDocumentoTransportistaPrivado            = $_REQUEST['numeroDocumentoTransportistaPrivado'];             //driverPersonId 
$empresaTransportistaPrivado                    = $_REQUEST['empresaTransportistaPrivado'];                     //licensePlateId 
$licenciaConductor                              = $_REQUEST['licenciaConductor'];                     //licensePlateId 
//DIRECCION PUNTO DE PARTIDA

$sql = "select CONCAT(departamento, ' - ',provincia,' - ',distrito) as direccionUbi,ubigeo,direccion from ticket where id='$codloc' ";
$result = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_array($result)) {
    $direccionUbi    = $row["direccionUbi"];
    $ubigeo1 = $row["ubigeo"];
    $direccion = $row["direccion"];
}
$UbigeoPartida  = $ubigeo1;
$direccionDePartida  = $direccion;

//$UbigeoPartida                                  = $_REQUEST['UbigeoPartida'];                                   //originAddressId          
//$direccionDePartida                             = $_REQUEST['direccionDePartida'];                              //originAddressStreetName
//DIRECCION PUNTO DE LLEGADA
$UbigeoLlegada                                  = $_REQUEST['UbigeoLlegada'];                                   //deliveryAddressId
$direccionDeLlegada                             = $_REQUEST['direccionDeLlegada'];
$descripcionNotas                           = $_REQUEST['descripcionNotas'];
//deliveryStreetName


//echo '<script>alert("' . $fechaInicioTraslado . '")</script>';


// mysqli_query($conexion, "INSERT INTO sd_despatch (issueDate,
// issueTime,
// despatchAdviceTypeCode,
// firstArrivalPortLocation,
// note,
// transportEquipmentId,
// despatchSchemeID,
// deliveryCustomerAccountID,
// deliveryname ,
// handlingCode,
// information,
// splitConsignmentIndicator,
// grossWeightMeasure,
// unitCodeWeightMeasure,
// totalUnitQuantity,
// transportModeCode,
// startDate,
// deliverySchemeID,
// carrierPartyId,
// carrierPartyName,
// driverPersonschemeId,
// driverPersonId,
// licensePlateId,
// originAddressId,
// originAddressStreetName,
// deliveryAddressId,
// deliveryStreetName,
// sucursal,
// invnumold,
// driverPersonLicense) values 
//   ('$fechaEmision',
// '$hora',
// '$despatchAdviceTypeCode',
// '$puertoAeropuerto',
// '$descripcionNotas',
// '$datosContenedor',
// '$tipoDocumentoIdentidad',
// '$numeroDocumentoDestinatario',
// '$empresaDestino',
// '$motivoTranslado',
// '$descripcionMotivoTraslado',
// '$indicadorTransbordoProgramado',
// '$pesoBrutoTotalBienes',
// '$unidadMedidaPesoBruto',
// '$numeroBultosPaquetes',
// '$modalidadTraslado',
// '$fechaInicioTraslado',
// '$tipoDocumentoIdentidadTransportista',
// '$numeroDocumentoTransportista',
// '$empresaTransportista',
// '$tipoDocumentoIdentidadTransportistaPrivado',
// '$numeroDocumentoTransportistaPrivado',
// '$empresaTransportistaPrivado',
// '$UbigeoPartida',
// '$direccionDePartida',
// '$UbigeoLlegada',
// '$direccionDeLlegada',
// '$zzcodloc',
// '$invnum',
// '$licenciaConductor')");
// $id_CabeceraGuia = mysqli_insert_id($conexion);

$sql1="INSERT INTO sd_despatch (issueDate,
issueTime,
despatchAdviceTypeCode,
firstArrivalPortLocation,
note,
transportEquipmentId,
despatchSchemeID,
deliveryCustomerAccountID,
deliveryname ,
handlingCode,
information,
splitConsignmentIndicator,
grossWeightMeasure,
unitCodeWeightMeasure,
totalUnitQuantity,
transportModeCode,
startDate,
deliverySchemeID,
carrierPartyId,
carrierPartyName,
driverPersonschemeId,
driverPersonId,
licensePlateId,
originAddressId,
originAddressStreetName,
deliveryAddressId,
deliveryStreetName,
sucursal,
invnumold,
driverPersonLicense) values 
  ('$fechaEmision',
'$hora',
'$despatchAdviceTypeCode',
'$puertoAeropuerto',
'$descripcionNotas',
'$datosContenedor',
'$tipoDocumentoIdentidad',
'$numeroDocumentoDestinatario',
'$empresaDestino',
'$motivoTranslado',
'$descripcionMotivoTraslado',
'$indicadorTransbordoProgramado',
'$pesoBrutoTotalBienes',
'$unidadMedidaPesoBruto',
'$numeroBultosPaquetes',
'$modalidadTraslado',
'$fechaInicioTraslado',
'$tipoDocumentoIdentidadTransportista',
'$numeroDocumentoTransportista',
'$empresaTransportista',
'$tipoDocumentoIdentidadTransportistaPrivado',
'$numeroDocumentoTransportistaPrivado',
'$empresaTransportistaPrivado',
'$UbigeoPartida',
'$direccionDePartida',
'$UbigeoLlegada',
'$direccionDeLlegada',
'$zzcodloc',
'$invnum',
'$licenciaConductor')";


$result1=mysqli_query($conexion, $sql1);

$id_CabeceraGuia = mysqli_insert_id($conexion);


echo $sql1;



//RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
$NuevoCorrelativo = 0;
$sqlXCOM = "SELECT seriegui,numgui FROM xcompa where codloc = '$zzcodloc'";
$resultXCOM = mysqli_query($conexion, $sqlXCOM);
if (mysqli_num_rows($resultXCOM)) {
    while ($row = mysqli_fetch_array($resultXCOM)) {
        $seriegui = $row['seriegui'];
        $numgui = $row['numgui'];


        $serie = "T" . $seriegui;
        $NuevoCorrelativo = $numgui + 1;

        mysqli_query($conexion, "UPDATE xcompa set numgui = '$NuevoCorrelativo' where codloc = '$zzcodloc'");
    }
    $NuevoCorrelativo = str_pad($NuevoCorrelativo, 8, '0', STR_PAD_LEFT);

    $PrintSerie = $serie . '-' . $NuevoCorrelativo;
    mysqli_query($conexion, "UPDATE sd_despatch set despatch_id = '$PrintSerie'  where despatch_uid = '$id_CabeceraGuia'");
}


$sqlEmisor = "SELECT ruc,razon_social FROM emisor where id = '$zzcodloc'";
$resultEmisor = mysqli_query($conexion, $sqlEmisor);
if (mysqli_num_rows($resultEmisor)) {
    while ($row = mysqli_fetch_array($resultEmisor)) {
        $ruc = $row['ruc'];
        $razon_social = $row['razon_social'];
    }

    mysqli_query($conexion, "UPDATE sd_despatch set partyIdentification  = '$ruc',despatchAssignedAccountID  = '$ruc', partyName ='$razon_social', despatchName ='$razon_social', deliverySchemeID='6'  where despatch_uid = '$id_CabeceraGuia'");
}



if ($tipoBusqueda == 1) {

    $sqlventa = "SELECT nrofactura FROM venta where invnum = '$invnum'";
    $resultVenta = mysqli_query($conexion, $sqlventa);
    if (mysqli_num_rows($resultVenta)) {
        while ($row = mysqli_fetch_array($resultVenta)) {
            $nrofactura = $row['nrofactura'];
        }

        mysqli_query($conexion, "UPDATE sd_despatch set serie_doc  = '$nrofactura',tipo_afectacion='1'  where despatch_uid = '$id_CabeceraGuia'");
    }
} else if ($tipoBusqueda == 2) {


    $sqlMov = "SELECT numdoc FROM movmae where invnum = '$invnum'";
    $resultMov = mysqli_query($conexion, $sqlMov);
    if (mysqli_num_rows($resultMov)) {
        while ($row = mysqli_fetch_array($resultMov)) {
            $numdoc = $row['numdoc'];
        }

        mysqli_query($conexion, "UPDATE sd_despatch set serie_doc  = '$numdoc',tipo_afectacion='2'  where despatch_uid = '$id_CabeceraGuia'");
    }
}





if ($tipoBusqueda == 1) {
    //VENTAS

    $consulta = "
  	    SELECT DV.codpro as codigo, 
  	    DV.canpro as cantidad,
  	    P.desprod as descripcion , 
  	    DV.prisal as precio, 
  	    DV.pripro as subTotal 
  	    FROM detalle_venta DV 
  	    INNER JOIN producto P 
  	    on P.codpro=DV.codpro WHERE invnum='$invnum'";
} else if ($tipoBusqueda == 2) {
    //TRANSFERENCIA

    $consulta = "SELECT M.codpro as codigo, 
  	    IF(M.qtypro != '' , M.qtypro,  M.qtyprf) as cantidad,
        P.desprod as descripcion , 
  	    M.pripro as precio, 
  	    M.costre as subTotal
		FROM movmov M
  	    INNER JOIN producto P 
  	    on P.codpro=M.codpro WHERE invnum='$invnum'";

    //echo '<script>alert("' . $tipoBusqueda . '")</script>'; 


}


$sqlEmisor1 = "SELECT ruc FROM emisor where id = '$zzcodloc'";
$resultEmisor1 = mysqli_query($conexion, $sqlEmisor1);
if (mysqli_num_rows($resultEmisor1)) {
    while ($row = mysqli_fetch_array($resultEmisor1)) {
        $ruc1 = $row['ruc'];
    }
}



$resultDetalle = mysqli_query($conexion, $consulta);
if (mysqli_num_rows($resultDetalle)) {
    while ($row = mysqli_fetch_array($resultDetalle)) {

        $i++;
        $codigo        = $row['codigo'];
        $cantidad      = $row['cantidad'];
        $descripcion   = $row['descripcion'];
        $precio        = $row['precio'];
        $subTotal      = $row['subTotal'];
        $subTotalNeto = $row['subTotal'] / (1 + (18 / 100));
        $subTotalIGV =  $subTotal - $subTotalNeto;



        $lineId                         = $i;
        $deliveredQuantity              = $row['cantidad'];
        $unitCode                       = 'NIU';
        $nameProduct                    = $row['descripcion'];
        $sellersItemIdentification      = $row['codigo'];
        $partyIdentification            = $ruc1;
        $amountPrice                    = $row['precio'];
        $amountTotal                    = $row['subTotal'];
        $codeCurrency                   = 'PEN';
        $taxReasonCode                  = '10';
        $amountTaxted                   = number_format($subTotalNeto, 2, '.', '');
        $igvTax                         = number_format($subTotalIGV, 2, '.', '');
        $despatch_uid                   = $id_CabeceraGuia;
        $codProducto                    = $row['codigo'];





        $detalleGuia = "INSERT INTO sd_despatch_line (
    		     
    		    
    		    lineId,
    		    deliveredQuantity,
    		    unitCode,
    		    nameProduct,
    		    sellersItemIdentification,
    		    partyIdentification,
    		    amountPrice,
    		    amountTotal,
    		    codeCurrency,
    		    taxReasonCode,
    		    amountTaxted,
    		    igvTax,
    		    despatch_uid,
    		    despatch_id,
                codProducto)
    		    
    		    VALUES (
    		    '$lineId',
    		    '$deliveredQuantity',
    		    '$unitCode',
    		    '$nameProduct',
    		    '$sellersItemIdentification',
    		    '$partyIdentification',
    		    '$amountPrice',
    		    '$amountTotal',
    		    '$codeCurrency',
    		    '$taxReasonCode',
    		    '$amountTaxted',
    		    '$igvTax',
    		    '$despatch_uid',
    		    '$PrintSerie',
                '$codProducto')";

        mysqli_query($conexion, $detalleGuia);
    }
}

if ($tipoBusqueda == 1) {

    mysqli_query($conexion, "UPDATE venta set guiaRemision='1' where invnum = '$invnum'");
} else if ($tipoBusqueda == 2) {

    mysqli_query($conexion, "UPDATE movmae set guiaRemision='1' where invnum = '$invnum'");
}


FnGenerateGuiaXmlAndSend($despatch_uid, $conexion);

//parchado Adrian guia_ref.php
echo "<script>
   if(confirm('Deseas Imprimir esta Guia de Remision')){
   var urlr = 'imprimir.php?invnum=$invnum&despatch_id=$PrintSerie&despatch_uid=$despatch_uid';
   
   
   
    document.location = urlr;
    //window.open(urlr, '_blank').focus();
    
    //document.location='guia1.php?val=0';
    

   }
   
   else
   
   { 
   document.location='guia1.php?val=0';}
   </script>";

 
 
 
 
 //header("Location: guia1.php?val=0"); 
