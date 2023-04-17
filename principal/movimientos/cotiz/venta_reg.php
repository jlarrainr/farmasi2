<?php
require_once('arreglaInvtot.php');
require_once("../../../conexion.php");
include('../../session_user.php');
$venta = $_SESSION['cotiz'];
require_once('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
$mont1 = $mont_bruto;   ///PRECIO BRUTO
$mont2 = $$total_des;   ///CON DESCUENTO
$mont3 = $valor_vent1;  ///PRECIO VENTA
$mont4 = $sum_igv;   ///IGV
$mont5 = $monto_total;  ///TOTAL
$hour = date('G');
$date = date("Y-m-d");
//$date	= CalculaFechaHora($hour);
$total_costo = 0;
$sql1_cotizacion_det = "SELECT COUNT(*) FROM cotizacion_det where invnum = '$venta'";
$result1_cotizacion_det = mysqli_query($conexion, $sql1_cotizacion_det);
if (mysqli_num_rows($result1_cotizacion_det)) {
    while ($row1_cotizacion_det = mysqli_fetch_array($result1_cotizacion_det)) {
        $contadoCotizacionDetalle = $row1_cotizacion_det[0];
    }
}
$sql1 = "SELECT * FROM cotizacion_det where invnum = '$venta'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codpro = $row1['codpro'];
        $date = $row1['invfec'];
        $cuscod = $row1['cuscod'];
        $usuario = $row1['usecod'];
        $codmar = $row1['codmar'];
        $canpro = $row1['canpro'];
        $cospro = $row1['cospro'];
        $costpr = $row1['costpr'];
        $fraccion = $row1['fraccion'];
        $factor = $row1['factor'];
        $prisal = $row1['prisal'];  ////PRECIO UNITARIO
        $pripro = $row1['pripro'];  ////MONTO VENTA
        $bonif = $row1['bonif'];
        $total_costo = $total_costo + $cospro;
    }
}

//$hour   = CalculaHora($hour);
$min = date('i');
$seg = date('s');

if ($hour <= 12) {
    $tim = "am";
} else {
    $tim = "pm";
}
$hora = $hour . ":" . $min . ":" . $seg . " " . $tim;

if ($contadoCotizacionDetalle > 0) {
    //echo $venta;
    //mysqli_query($conexion,"DELETE from temp_venta where invnum = '$venta'");
      //aca comente 
    // mysqli_query($conexion, "UPDATE cotizacion set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',redondeo = '$redondeo',hora = '$hora' where invnum = '$venta'");

    //codigo parchado

    $sql1 = "UPDATE cotizacion set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',redondeo = '$redondeo',hora = '$hora' where invnum = '$venta'";
        $sql1  = arreglarSql($sql1);
        $result1 = mysqli_query($conexion, $sql1);


    echo "<script>if(confirm('Deseas Imprimir esta Cotizacion')){document.location='generaImpresion.php?invnum=$venta';}else{ alert(document.location='ventas_registro.php');}</script>";
} else {

    echo "<script>if(confirm('USTED ESTA VENDIENDO EN DOS PANTALLAS AL MISMO TIEMPO NO ESTA PERIMITIDO ESTA FUNCION.')){document.location='ventas_registro.php ';}else{ alert(document.location='ventas_registro.php');}</script>";
}
//header("Location: ventas_registro.php");
//header("Location: ../../index.php");
