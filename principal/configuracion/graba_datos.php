<?php

include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../convertfecha.php');

$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $sucursal = $row['codloc'];
    }
}
$sql = "SELECT 	nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia          = $row["nlicencia"];
    }
}

$btn = $_REQUEST['btn'];
if ($btn == 1) {

    $desc                   = $_REQUEST['desc'];
    $direccionemp           = $_REQUEST['dir'];
    $rucemp                 = $_REQUEST['ruc'];
    $igv                    = $_REQUEST['igv'];
    $fechavenci             = $_REQUEST['date1'];
    $nopaga                 = $_REQUEST['nopaga'];
    $vencipro               = $_REQUEST['vencipro'];
    $recordarsunat          = $_REQUEST['recordarsunat'];
    $fecha_mensaje          =  $_REQUEST['date2'];
    $alerta_masiva_sistema  =  $_REQUEST['alerta_masiva_sistema'];
    $precios_por_local      =  $_REQUEST['precios_por_local'];
    $arqueo_caja            =  $_REQUEST['arqueo_caja'];
    $TicketDefecto          =  $_REQUEST['TicketDefecto'];
    $numerocopias           =  $_REQUEST['numerocopias'];
    $formadeimpresion       =  $_REQUEST['formadeimpresion'];
    $ventablister           =  $_REQUEST['ventablister'];
    $venf8                  =  $_REQUEST['venf8'];
    $puntosdiv              =  $_REQUEST['puntosdiv'];
    $TicketDefectoMayorA    =  $_REQUEST['TicketDefectoMayorA'];
    $anular_venta_vendedor  =  $_REQUEST['anular_venta_vendedor'];

    $drogueria              = $_REQUEST['drogueria'];
    $selva                  = $_REQUEST['selva'];
    $codigo_hash            = $_REQUEST['codigo_hash'];
    
    $for_continuo           = $_REQUEST['for_continuo'];
    $priceditable           = $_REQUEST['priceditable'];
    
    $usuariosEspeciales_ArqueoCaja= $_REQUEST['usuariosEspeciales_ArqueoCaja'];
    


    $desc = remplazar_string($desc);
    $direccionemp = remplazar_string($direccionemp);




    if ($nlicencia == 1) {
        $precios_por_local = '0';
    } else {
        $precios_por_local = $precios_por_local;
    }
    if ($fechavenci == '') {
        $fechavenci = '0000-00-00';
    } else {
        $fechavenci = fecha1($fechavenci);
    }

    if ($fecha_mensaje == '') {
        $fecha_mensaje = '0000-00-00';
    } else {
        $fecha_mensaje = fecha1($fecha_mensaje);
    }
    // echo    '$desc' . $desc . "<br>";
    // echo    '$direccionemp' . $direccionemp . "<br>";
    // echo    '$rucemp' . $rucemp . "<br>";
    // echo    '$igv' . $igv . "<br>";
    // echo    '$fechavenci' . $fechavenci . "<br>";
    // echo    '$rucemp' . $fechavenci . "<br>";
    // echo    '$rucemp' . $rucemp . "<br>";


if($drogueria == 1){
    mysqli_query($conexion, "update producto set lote = '1' ,lotec='0' ");
}else{
     mysqli_query($conexion, "update producto set lote = '0' ,lotec='1' ");
}

if($selva == 1){
    mysqli_query($conexion, "update producto set igv = '0'   ");
}else{
     mysqli_query($conexion, "update producto set igv = '1'   ");
}

    // $va = "update datagen set desemp  = '$desc', direccionemp = '$direccionemp', rucemp = '$rucemp', porcent = '$igv', fechavenci  = '$fechavenci', nopaga ='$nopaga' ,vencipro ='$vencipro',recordarsunat ='$recordarsunat',fecha_mensaje ='$fecha_mensaje',alerta_masiva_sistema='$alerta_masiva_sistema',precios_por_local='$precios_por_local',arqueo_caja='$arqueo_caja',TicketDefecto = '$TicketDefecto',numerocopias = '$numerocopias',formadeimpresion = '$formadeimpresion',ventablister = '$ventablister', venf8 = '$venf8', puntosdiv = '$puntosdiv',TicketDefectoMayorA='$TicketDefectoMayorA',anular_venta_vendedor ='$anular_venta_vendedor'";

    // // echo $va;
    mysqli_query($conexion, "update datagen set desemp  = '$desc', direccionemp = '$direccionemp', rucemp = '$rucemp', porcent = '$igv', fechavenci  = '$fechavenci', nopaga ='$nopaga' ,vencipro ='$vencipro',recordarsunat ='$recordarsunat',fecha_mensaje ='$fecha_mensaje',alerta_masiva_sistema='$alerta_masiva_sistema',precios_por_local='$precios_por_local',arqueo_caja='$arqueo_caja',TicketDefecto = '$TicketDefecto',numerocopias = '$numerocopias',formadeimpresion = '$formadeimpresion',ventablister = '$ventablister', venf8 = '$venf8', puntosdiv = '$puntosdiv',TicketDefectoMayorA='$TicketDefectoMayorA',anular_venta_vendedor ='$anular_venta_vendedor',codigo_hash='$codigo_hash',usuariosEspeciales_ArqueoCaja='$usuariosEspeciales_ArqueoCaja' ");


    mysqli_query($conexion, "update xcompa set for_continuo = '$for_continuo' where codloc = '$sucursal'");
    mysqli_query($conexion, "update datagen_det set drogueria = '$drogueria',priceditable='$priceditable', selva='$selva'  ");


    header("Location: datos_gen.php");
}
if ($btn == 2) {
    $pas1 = $_REQUEST['pas1'];
    $pas2 = $_REQUEST['pas2'];
    $pas3 = $_REQUEST['pas3'];
    /* mysqli_query($conexion,"update datagen set adminuser  = '$pas1', paramsist = '$pas2', colorbut = '$pas3'");
      header("Location: password1.php"); */
}
if ($btn == 3) {
    $text = $_REQUEST['text'];
    $text1 = $_REQUEST['text1'];
    $text2 = $_REQUEST['text2'];
    $text3 = $_REQUEST['text3'];
    $text4 = $_REQUEST['text4'];
    $text5 = $_REQUEST['text5'];
    $text6 = $_REQUEST['text6'];
    $text7 = $_REQUEST['text7'];
    $text8 = $_REQUEST['text8'];
    $text9 = $_REQUEST['text9'];
    $text10 = $_REQUEST['text10'];
    $text11 = $_REQUEST['text11'];
    $text12 = $_REQUEST['text12'];
    $text13 = $_REQUEST['text13'];
    $text14 = $_REQUEST['text14'];
    $text15 = $_REQUEST['text15'];
    $text16 = $_REQUEST['text16'];
    $text17 = $_REQUEST['text17'];
    $text18 = $_REQUEST['text18'];
    $text19 = $_REQUEST['text19'];
    $text20 = $_REQUEST['text20'];
    if ($text18 == "") {
        mysqli_query($conexion, "update color_modulo set primero  = '$text', anterior = '$text1', siguiente = '$text2', ultimo = '$text3',ver='$text4', nuevo='$text5',modificar='$text6',eliminar='$text7',grabar='$text8',buscar='$text9',preliminar='$text10',imprimir='$text11',consulta='$text12',salir='$text13',prodstock='$text14',prodincent= '$text15',prodnormal ='$text16', cancelar = '$text17', regresar = '$text19', limpiar = '$text20'");
    } else {
        mysqli_query($conexion, "update color_modulo set primero  = '$text18', anterior = '$text18', siguiente = '$text18', ultimo = '$text18',ver='$text18', nuevo='$text18',modificar='$text18',eliminar='$text18',grabar='$text18',buscar='$text18',preliminar='$text18',imprimir='$text18',consulta='$text18',salir='$text18',prodstock='$text18',prodincent= '$text18',prodnormal ='$text18', cancelar = '$text18', regresar = '$text18', limpiar = '$text18'");
    }
    header("Location: color1.php");
}
if ($btn == 4) {
    $ckvendedorventa = isset($_REQUEST['ckvendedorventa']) ? $_REQUEST['ckvendedorventa'] : 0;
    $cliente = $_REQUEST['cliente'];
    $ventas = $_REQUEST['ventas'];
    $vendedor = $_REQUEST['vendedor'];
    $limit = $_REQUEST['limit'];
    $limit2 = $_REQUEST['limit2'];
    $msg = $_REQUEST['msjventa'];
    $minunid = $_REQUEST['minunid'];
    $utldmin = $_REQUEST['utldmin'];
    $p1 = $_REQUEST['p1'];
    $p2 = $_REQUEST['p2'];
    $p3 = $_REQUEST['p3'];
    $p4 = $_REQUEST['p4'];
    $p5 = $_REQUEST['p5'];
    $p6 = $_REQUEST['p6'];
    $p7 = $_REQUEST['p7'];
    $p8 = $_REQUEST['p8'];
    $p9 = $_REQUEST['p9'];
    $p10 = $_REQUEST['p10'];
    $auditor = $_REQUEST['auditor'];
    $p11 = $_REQUEST['p11'];
    $rd1 = $_REQUEST['rd1'];  ///COMPRA POR 1 0 POR 2
    $rd2 = $_REQUEST['rd2'];  ///VENTA POR 1 O POR 2
    $drogueria = $_REQUEST['drogueria'];  ///VENTA POR 1 O POR 2
    if ($rd1 == 1) {
        $c2 = "";
        $c1 = 1;
    } else {
        $c1 = "";
        $c2 = 1;
    }
    if ($rd2 == 1) {
        $v2 = "";
        $v1 = 1;
    } else {
        $v1 = "";
        $v2 = 1;
    }
    mysqli_query($conexion, "update datagen_det set vendedorventa='$ckvendedorventa',codcli  = '$cliente', condv = '$ventas', prodact = '$p1', incigv = '$p2', cosigv = '$p3', nomarc = '$p4', codaut = '$p5', afeigv = '$p6', unalm = '$p7', ventalm = '$p8', ingalm = '$p9', comcod = '$c1', comnom = '$c2', ventcod = '$v1', ventnom = '$v2', limite = '$limit', limite_compra = '$limit2', mensaje = '$msg',unidminrepo = '$minunid',utldmin = '$utldmin', priceditable = '$p10', focuscotiz = '$p11', auditor = '$auditor',drogueria='$drogueria'");
    header("Location: val_predeterm1.php");
}
