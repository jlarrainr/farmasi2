<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');

//error_log("Ventas 4");
$numero             = $_REQUEST['numero'];
$agot               = $_REQUEST['agot'];
$cuscod             = $_REQUEST['cuscod'];
$codpro             = $_REQUEST['codpro'];
$agotado            = $_REQUEST['agotado'];
$invfec             = $_REQUEST['invfec'];
$pcunit             = $_REQUEST['pcunit'];
$factor             = $_REQUEST['factor'];
$sucursal           = $_REQUEST['sucursal'];
$codmar             = $_REQUEST['codmar'];
$codfam             = $_REQUEST['codfam'];
$coduso             = $_REQUEST['coduso'];
$ppc                = $_REQUEST['ppc'];

if ($numero == 0) {
    if ($agot == 1) {
        mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','T','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
    }
} else {
    if ($agot == 1) {
        mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','F','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
    }
}

header("Location: venta_index2.php");
