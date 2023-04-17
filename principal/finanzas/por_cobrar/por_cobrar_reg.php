<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
include('../../session_user.php');
require_once '../../../convertfecha.php';
$id_cuota                   = $_REQUEST['id'];
$codigoCliente              = $_REQUEST['cliente'];
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
echo '$codigoCliente = '.$codigoCliente."<br>";
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


mysqli_query($conexion, "INSERT INTO venta_cuotas_detalle (tipoDocumento, id_cuota, formaPago, montoPago, usuario,hora,codigoCliente,fechapago,banco,nrobanco,saldo_deuda,fechaplazo,textoCuota,montoTotal,fecha_pago_cuota) values ('$tipoDocumento', '$id_cuota', '$formaPago', '$montoPago', '$usuario','$hora','$codigoCliente','$fechapago','$banco','$nrobanco','$resta','$fechapagoReprogramacion','$textoCuota','$saldo_deuda','$fechaPagoReprogrHidden')");
mysqli_query($conexion, "UPDATE venta_cuotas set montoCobro = '$resta',fecha_pago_reprogramacion='$fechapagoReprogramacion' where id = '$id_cuota'  ");
 
header("Location: por_cobrar1.php?valid=1&val=1&cliente=$codigoCliente"); 
 
