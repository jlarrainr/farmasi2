<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');        //CONEXION A BASE DE DATOS
require_once('../montos_text.php');
$rd              = $_REQUEST['tt'];  //rd
//$venta     = $_REQUEST['vt'];
$venta     = $_SESSION['venta'];
require_once('session_ventas.php');
require_once('venta_reg1.php');        //GRABO EL DETALLE DE VENTA
/////////////////////////////////////////////
$rd          = strtoupper($rd);
mysqli_query($conexion, "update venta set tipdoc = '$rd' where invnum = '$venta'");
$sql = "SELECT codimpresion FROM impresion where codlocal = '$sucursal'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        $formatoxsucursal1 = '1';
} else {
        $formatoxsucursal1 = '0';
}
$sql = "SELECT codformato FROM formato where sucursal = '$sucursal'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        $formatoxsucursal2 = '1';
} else {
        $formatoxsucursal2 = '0';
}
$sql = "SELECT coddet FROM xcompadetalle where codloc = '$sucursal'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        $formatoxsucursal3 = '1';
} else {
        $formatoxsucursal3 = '0';
}
if (($formatoxsucursal1 == 1) and ($formatoxsucursal2 == 1) and ($formatoxsucursal3 == 1)) {
        $formatoxsucursal = $sucursal;
} else {
        $formatoxsucursal = 1; ////tomo la configuracion del local central
}
$sql = "SELECT imprapida FROM xcompa where codloc = '$sucursal'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $imprapida    = $row["imprapida"]; ////puede ser 0 o 1 o ""
        }
}

function cambiarFormatoFecha($fecha)
{
        list($anio, $mes, $dia) = explode("-", $fecha);
        return $dia . "-" . $mes . "-" . $anio;
}
function cambiarFormatoFecha1($fecha)
{
        list($anio, $mes, $dia) = explode("/", $fecha);
        return $dia . "/" . $mes . "/" . $anio;
}
$sql = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $invnum       = $row['invnum'];                //codgio
                $nrovent      = $row['nrovent'];
                $invfec       = $row['invfec'];
                $cuscod       = $row['cuscod'];
                $usecod       = $row['usecod'];
                $codven       = $row['codven'];
                $forpag       = $row['forpag'];
                $fecven       = $row['fecven'];
                $sucursal     = $row['sucursal'];
                $correlativo  = $row['correlativo'];
                $nomcliente   = $row['nomcliente'];
                $pagacon      = $row['pagacon'];
                $vuelto       = $row['vuelto'];
                if ($forpag == 'E') {
                        $forma_pago = 'EFECTIVO';
                }
                if ($forpag == 'T') {
                        $forma_pago = 'TARJETA';
                }
                if ($forpag == 'C') {
                        $forma_pago = 'correlativo';
                }
                //$invfec = cambiarFormatoFecha($invfec);
                $var['nrovent'] = $correlativo;
                $var['invfec']  = fecha($invfec);
                //$var[invfec]  = $invfec;
                $var['cuscod']  = $cuscod;
                $var['usecod']  = $usecod;
                $var['forpag']  = $forma_pago;
                $var['mont_bruto']   = $mont_bruto;
                $var['total_es']     = $total_es;
                $var['valor_vent1']  = $valor_vent1;
                $var['sum_igv']      = $sum_igv;
                $var['monto_total']  = $monto_total;
                $var['nomcliente']  = $nomcliente;
                $var['pagacon']      = $pagacon;
                $var['vuelto']       = $vuelto;
        }
}
//echo $var[invfec]; exit;
$sql = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $nomusu         = $row['abrev'];
                $var['nomusu']  = $nomusu;
        }
}
$sql = "SELECT desemp,rucemp,telefonoemp FROM datagen";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $desemp                 = $row['desemp'];
                $rucemp                 = $row['rucemp'];
                $telefonoemp            = $row['telefonoemp'];
                $var['desemp']          = $desemp;
                $var['rucemp']          = $rucemp;
                $var['telefonoemp']     = $telefonoemp;
        }
}
$sql = "SELECT descli,dircli,ruccli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $descli         = $row['descli'];
                $dircli         = $row['dircli'];
                $ruccli         = $row['ruccli'];
                $var['dircli']  = $dircli;
                $var['ruccli']  = $ruccli;
        }
}
$sql = "SELECT count(invnum) FROM detalle_venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $countdetventa     = $row[0];
        }
}
function muestra($y)
{
        $vea = "";
        global $codpro;
        global $desprod;
        global $marca;
        global $precio_ref;
        global $descuento;
        global $fraccion;
        global $canpro;
        global $prisal;
        global $pripro;
        global $fcanti;
        global $fmarca;
        global $fcodpro;
        global $fpreuni;
        global $fmonto;
        global $fdescuento;
        global $fnom;
        global $fref;
        if ($fcanti == $y) {
                if ($fraccion == "T") {
                        $vea = "F" . $canpro;
                }
                if ($fraccion == "F") {
                        $canpro = "C" . $canpro;
                        $vea = $canpro;
                }
        }
        if ($fmarca == $y) {
                $vea = $marca;
        }
        if ($fcodpro == $y) {
                $vea = $codpro;
        }
        if ($fpreuni == $y) {
                $vea = $prisal;
        }
        if ($fmonto == $y) {
                $vea = $pripro;
        }
        if ($fdescuento == $y) {
                $vea = $numero_formato_frances = number_format($descuento, 0, '.', ' ');
        }
        if ($fnom == $y) {
                $vea = $desprod;
        }
        if ($fref == $y) {
                $vea = $numero_formato_frances = number_format($precio_ref, 2, '.', ' ');
        }
        return $vea;
}
function ancho($u)
{
        $vae = "";
        global $fcanti;
        global $fmarca;
        global $fcodpro;
        global $fpreuni;
        global $fmonto;
        global $fdescuento;
        global $fnom;
        global $fref;
        global $anchocod;
        global $anchonom;
        global $anchomarca;
        global $anchoreferencial;
        global $anchodescuento;
        global $anchocantidad;
        global $anchoprecio;
        global $anchosubtotal;
        if ($fcanti == $u) {
                $vae = $anchocantidad;
        }
        if ($fmarca == $u) {
                $vae = $anchomarca;
        }
        if ($fcodpro == $u) {
                $vae = $anchocod;
        }
        if ($fpreuni == $u) {
                $vae = $anchoprecio;
        }
        if ($fmonto == $u) {
                $vae = $anchosubtotal;
        }
        if ($fdescuento == $u) {
                $vae = $anchodescuento;
        }
        if ($fnom == $u) {
                $vae = $anchonom;
        }
        if ($fref == $u) {
                $vae = $anchoreferencial;
        }
        return $vae;
}
function formato($c)
{
        printf("%08d",  $c);
}

function formato1($c)
{
        printf("%06d",  $c);
}
function otipen($g)
{
        global $fcanti;
        global $fmarca;
        global $fcodpro;
        global $fpreuni;
        global $fmonto;
        global $fdescuento;
        global $fnom;
        global $fref;
        if ($fcanti == $g) {
                $vae = "CANTIDAD";
        }
        if ($fmarca == $g) {
                $vae = "MARCA";
        }
        if ($fcodpro == $g) {
                $vae = "CODIGO";
        }
        if ($fpreuni == $g) {
                $vae = "PRECIO";
        }
        if ($fmonto == $g) {
                $vae = "SUB TOTAL";
        }
        if ($fdescuento == $g) {
                $vae = "DCTOS";
        }
        if ($fnom == $g) {
                $vae = "DESCRIPCION";
        }
        if ($fref == $g) {
                $vae = "PRECIO REF";
        }
        return $vae;
}
function impresora($c)
{
        if ($c == 1) //factura
        {
                $print = "lpt4";
        }
        if ($c == 2) //boleta
        {
                $print = "lpt3";
        }
        if ($c == 4) //ticket copia
        {
                $print = "lpt2";
        }
        if ($c == 5) //ticket copia
        {
                $print = "lpt1";
        }
        return $print;
}
$_SESSION['codigo_user'] = $_SESSION['UsuarioPrincipal'];
if ($imprapida == 1) {
        $rd                                = $_REQUEST['tt'];
        $valor_imprimir = $_REQUEST['tt']; ///impresion rapida sobre local
        require_once("generatxt_venta.php");
        header("Location: venta_index.php");
} else {
        $rd                                 = $_REQUEST['tt'];
        $valor_imprimir  = $_REQUEST['tt']; ////PRIMERO IMPRIMO UNA COPIA
        //$impresora  = $_REQUEST['impresora']; ////PRIMERO IMPRIMO UNA COPIA
        //require_once("generatxt_venta.php");
        //$tip = 4;
        //header("generatxt_venta_copy.php");
        //require_once("generatxt_venta_copy.php");
        header("Location: generatxt_venta_copy.php?rd=$rd&vt=$venta&xs=$formatoxsucursal");
        //header("Location: venta_index.php");
}
