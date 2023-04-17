<?php

require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
$text = $_REQUEST['text'];
$codloc = $_REQUEST['codloc'];
$imprapida = $_REQUEST['imprapida'];
$habil = $_REQUEST['habil'];
$todos = $_REQUEST['todos'];


if (!empty($_FILES['logo']['tmp_name']) && file_exists($_FILES['logo']['tmp_name'])) {
    $logo = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
}
$linea1 = trim($_REQUEST['linea1']);
$linea2 = trim($_REQUEST['linea2']);
$linea3 = trim($_REQUEST['linea3']);
$linea4 = trim($_REQUEST['linea4']);
$linea5 = trim($_REQUEST['linea5']);
$linea6 = trim($_REQUEST['linea6']);
$linea7 = trim($_REQUEST['linea7']);
$linea8 = trim($_REQUEST['linea8']);
$linea9 = trim($_REQUEST['linea9']);
$pie1 = trim($_REQUEST['pie1']);
$pie2 = trim($_REQUEST['pie2']);
$pie3 = trim($_REQUEST['pie3']);
$pie4 = trim($_REQUEST['pie4']);
$pie5 = trim($_REQUEST['pie5']);
$pie6 = trim($_REQUEST['pie6']);
$pie7 = trim($_REQUEST['pie7']);
$pie8 = trim($_REQUEST['pie8']);
$pie9 = trim($_REQUEST['pie9']);

$direccion = trim($_REQUEST['direccion']);
$distrito = trim($_REQUEST['distrito']);
$provincia = trim($_REQUEST['provincia']);
$departamento = trim($_REQUEST['departamento']);
$ubigeo = trim($_REQUEST['ubigeo']);

if ($logo <> "") {


    if ($todos == 1) {
        mysqli_query($conexion, "update xcompa set logo='$logo' ");
    } else {
        //   mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '$imprapida',habil = '$habil',logo='$logo' where codloc = '$codloc'");
        mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '1',habil = '1',logo='$logo' where codloc = '$codloc'");
    }
} else {
    // mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '$imprapida',habil = '$habil' where codloc = '$codloc'");
    mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '1',habil = '1' where codloc = '$codloc'");
}

mysqli_query($conexion, "update ticket set linea1 = '$linea1',linea2 = '$linea2',linea3 = '$linea3',linea4 = '$linea4',linea5 = '$linea5',linea6 = '$linea6',linea7 = '$linea7',linea8 = '$linea8',linea9 = '$linea9',pie1 = '$pie1',pie2 = '$pie2',pie3 = '$pie3',pie4 = '$pie4',pie5 = '$pie5',pie6 = '$pie6',pie7 = '$pie7',pie8 = '$pie8',pie9 = '$pie9',direccion = '$direccion',distrito = '$distrito',provincia = '$provincia',departamento = '$departamento',ubigeo = '$ubigeo' where sucursal = '$codloc'");
//echo $linea1."<br>";
//echo $linea."<br>";

header("Location: index1.php?srch=1&local=$codloc");
