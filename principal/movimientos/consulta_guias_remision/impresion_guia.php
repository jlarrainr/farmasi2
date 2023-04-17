<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
include('../../session_user.php');
require_once '../../../convertfecha.php';
require_once('../../phpqrcode/qrlib.php');

//$invnum =  $_REQUEST['invnum'];  // con este dato vas a ajlar en la tabla este es su id
$despatch_uid = $_REQUEST['despatch_uid'];



//$despatch_id = $_REQUEST['despatch_id'];



$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../movimientos/ventas/temp' . DIRECTORY_SEPARATOR;

$PNG_WEB_DIR = '../movimientos/ventas/temp/';
$filename = $PNG_TEMP_DIR . 'ventas.png';
$matrixPointSize = 3;
$errorCorrectionLevel = 'L';
$framSize = 3; //Tama?????o en blanco
$filename = $PNG_TEMP_DIR . 'test' . $despatch_uid . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
    
    
    $sql = "SELECT codloc FROM usuario where usecod = '$usuario'  ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $sucursal = $row['codloc'];
    }
}



$sqlDrogueria = "SELECT drogueria FROM datagen_det";
$resultDrogueria = mysqli_query($conexion, $sqlDrogueria);
if (mysqli_num_rows($resultDrogueria)) {
    while ($rowDrogueria = mysqli_fetch_array($resultDrogueria)) {
        $drogueria    = $rowDrogueria['drogueria'];
      
    }
}




 $sqlUsuX = "SELECT logo,seriegui FROM xcompa where codloc = '$sucursal'";
    $resultUsu2 = mysqli_query($conexion, $sqlUsuX);
    if (mysqli_num_rows($resultUsu2)) {
        while ($row = mysqli_fetch_array($resultUsu2)) {
            $logo = $row['logo'];
            $seriegui = $row['seriegui'];
            
        }
    } 


    $serieQR = "T" . $seriegui;
    
    $sqlticket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,sucursal_ruc,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9  FROM ticket where sucursal = '$sucursal'";
    $resultTicket= mysqli_query($conexion, $sqlticket);
    if (mysqli_num_rows($resultTicket)) {
        while ($row = mysqli_fetch_array($resultTicket)) {
            $linea1 = $row['linea1'];
            $linea2 = $row['linea2'];
            $linea3 = $row['linea3'];
            $linea4 = $row['linea4'];
            $linea5 = $row['linea5'];
            $linea6 = $row['linea6'];
            $linea7 = $row['linea7'];
            $linea8= $row['linea8'];
            $linea9 = $row['linea9'];
            $sucursal_ruc = $row['sucursal_ruc'];
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
    
    //consultar Despatch_line items Adrian - impresion_guia.php
    $sqlDespatch = "SELECT lineid, deliveredQuantity, unitCode, nameProduct FROM sd_despatch_line WHERE despatch_uid= '$despatch_uid'";
    $resultDespatch = mysqli_query($conexion, $sqlDespatch);
    
    //consultar Despatch remitente y destinatario Adrian - impresion_guia.php
    
    $sqlDespatch2 = "SELECT despatch_id,deliverycustomeraccountid,deliveryname,partyidentification,partyname,originAddressStreetName,deliveryStreetName,carrierPartyName,issueDate,issueTime,startDate,unitCodeWeightMeasure,grossWeightMeasure,totalUnitQuantity,handlingCode,information,note,transportModeCode,licensePlateId FROM sd_despatch WHERE despatch_uid = '$despatch_uid' LIMIT 1;";
    $resultDespatch2 = mysqli_query($conexion, $sqlDespatch2);
    
    if (mysqli_num_rows($resultDespatch2)) {
        while ($row = mysqli_fetch_array($resultDespatch2)) 
        {
            //destinatario
            
            $despatch_id = $row['despatch_id'];
            $deliverycustomeraccountid = $row['deliverycustomeraccountid'];
            $deliveryname = $row['deliveryname'];
            //remitente
            $partyidentification = $row['partyidentification'];
            $partyname = $row['partyname'];
            //direcciones
            $originAddressStreetName = $row['originAddressStreetName'];
            $deliveryStreetName = $row['deliveryStreetName'];
            
            $carrierPartyName = $row['carrierPartyName'];//nombre_transportista
            
            $issueDate = $row['issueDate'];//fecha_incio
            $issueTime = $row['issueTime'];//hora
            $startDate = $row['startDate']; //inicio
            
            //unidad medida
            $unitCodeWeightMeasure = $row['unitCodeWeightMeasure'];
            //peso bruto
            $grossWeightMeasure = $row['grossWeightMeasure'];
            //numero de bultos
            $totalUnitQuantity = $row['totalUnitQuantity'];
            //Motivo Translado
            $handlingCode = $row['handlingCode'];
            $handlingCodeString = "";
            $transportModeCode = $row['transportModeCode'];
            $licensePlateId = $row['licensePlateId'];

            

            
            
            switch($handlingCode)
            {
                case "01": 
                    $handlingCodeString = "VENTA";
                    break;
                case "02": 
                    $handlingCodeString = "COMPRA";
                    break;
                case "04": 
                    $handlingCodeString = "TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA";
                    break;
                case "08": 
                    $handlingCodeString = "IMPORTACION";
                    break;
                case "09": 
                    $handlingCodeString = "EXPORTACION";
                    break;
                case "13": 
                    $handlingCodeString = "OTROS";
                    break;
                case "14": 
                    $handlingCodeString = "VENTA SUJETA A CONFIRMACION DEL COMPRADOR";
                    break;
                case "18": 
                    $handlingCodeString = "TRASLADO EMISOR ITINERANTE CP";
                    break;
                case "19": 
                    $handlingCodeString = "TRASLADO A ZONA PRIMARIA";
                    break;
            }
            
            //Descripcion del trslado = 
            $information = $row['information'];
            //observacion = notas
            $note = $row['note'];
        }
    } 
    

    
    //aqui pones todas las validaciones
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <title>Document</title>

     <script>
         
             
             function imprimir() {
            var f = document.form1;
            window.print();
            //self.close();
            <?php
            echo "parent.opener.location='ventas1.php?val=0';";
            
            ?>
            
           window.onafterprint = function(){
                   self.close();
                }
            
        }
        
    </script>
 
</head>



<body onload="imprimir()">
    <form name="form1" id="form1">
      
      
      
      
         <?php include 'impresionGuia.php'; ?>
      
    </form>
</body>

</html>