<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
include('../../session_user.php');
require_once '../../../convertfecha.php';
$id_cuota                   = $_REQUEST['id'];
$codigoProveedor              = $_REQUEST['proveedor'];
$tipoDocumento              = $_REQUEST['tipdoc'];      //tipo de documento CONTADO = 1,....
$formaPago                  = $_REQUEST['forpag'];      //forma de pago efectivo = E, DEPOSITO= D
$montoPago                  = $_REQUEST['montoSaldoText'];        //  el monto que se paga
$banco                      =  $_REQUEST['banco'];       // banco
$nrobanco                   = $_REQUEST['nrobanco'];    // numero de operacion de banco
$fechapagoReprogramacion    = $_REQUEST['date1'];  
$saldo_deuda                = $_REQUEST['antiguo'];     // antiguo
$sald                       = $_REQUEST['saldoPendienteHidden'];       // la diferencia
$textoCuota                       = $_REQUEST['textoCuota'];       // la diferencia
$fechaPagoReprogrHidden                       = fecha1($_REQUEST['fechaPagoReprogrHidden']);       // la diferencia
$banco  = ($banco ==0)?'':$banco;
//echo '$fechaPagoReprogrHidden = '.$fechaPagoReprogrHidden."<br>";
$fechapagoReprogramacion = fecha1($fechapagoReprogramacion);
$montoPago = round($montoPago, 2);
$sald = round($sald, 2);

$fechapago = date("Y-m-d");
$hora =date('H:m:s');

$resta = $saldo_deuda - $montoPago;

 /*
echo '$id_cuota = '.$id_cuota."<br>";
echo '$codigoProveedor = '.$codigoProveedor."<br>";
echo '$tipoDocumento = '.$tipoDocumento."<br>";
echo '$formaPago = '.$formaPago."<br>";
echo '$montoPago = '.$montoPago."<br>";
echo '$banco = '.$banco."<br>";
echo '$nrobanco = '.$nrobanco."<br>";
echo '$fechapagoReprogramacion = '.$fechapagoReprogramacion."<br>";
echo '$saldo_deuda = '.$saldo_deuda."<br>";
echo '$sald = '.$sald."<br>";
echo '$resta = '.$resta."<br>";
*/
 
 
if($banco <> ''){
    
    if (!is_numeric($banco)) {
        $banco = strtoupper($banco);
        mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('B','$banco')");
        $id_banco = mysqli_insert_id($conexion);
        $banco = $id_banco;
    }
    
}


mysqli_query($conexion, "INSERT INTO cuentaPorPagarDetalle (tipoDocumento, id_cuota, formaPago, montoPago, usuario,hora,codigoCliente,fechapago,banco,nrobanco,saldo_deuda,fechaplazo,textoCuota,montoTotal,fecha_pago_cuota) values ('$tipoDocumento', '$id_cuota', '$formaPago', '$montoPago', '$usuario','$hora','$codigoProveedor','$fechapago','$banco','$nrobanco','$resta','$fechapagoReprogramacion','$textoCuota','$saldo_deuda','$fechaPagoReprogrHidden')");
 



$sql2="UPDATE movmae set monto_deuda = '$resta',fecha_pago_reprogramacion='$fechapagoReprogramacion'  where invnum = '$id_cuota' and cuscod = '$codigoProveedor' AND tipmov='1' AND tipdoc='1' and val_habil ='0' and plazo > 0 ";

mysqli_query($conexion, $sql2);


 
header("Location: por_pagar1.php?valid=1&val=1&proveedor=$codigoProveedor"); 
 
 