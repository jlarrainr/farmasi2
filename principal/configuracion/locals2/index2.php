<?php

require_once ('../../../conexion.php'); //CONEXION A BASE DE DATOS
$text = $_REQUEST['text'];
$codloc = $_REQUEST['codloc'];
$imprapida = $_REQUEST['imprapida'];
$habil = $_REQUEST['habil'];
$todos = $_REQUEST['todos'];


if(!empty($_FILES['logo']['tmp_name']) && file_exists($_FILES['logo']['tmp_name'])) {
    $logo= addslashes(file_get_contents($_FILES['logo']['tmp_name']));
}
$linea1 = $_REQUEST['linea1'];
$linea2 = $_REQUEST['linea2'];
$linea3 = $_REQUEST['linea3'];
$linea4 = $_REQUEST['linea4'];
$linea5 = $_REQUEST['linea5'];
$linea6 = $_REQUEST['linea6'];
$linea7 = $_REQUEST['linea7'];
$linea8 = $_REQUEST['linea8'];
$linea9 = $_REQUEST['linea9'];
$pie1 = $_REQUEST['pie1'];
$pie2 = $_REQUEST['pie2'];
$pie3 = $_REQUEST['pie3'];
$pie4 = $_REQUEST['pie4'];
$pie5 = $_REQUEST['pie5'];
$pie6 = $_REQUEST['pie6'];
$pie7 = $_REQUEST['pie7'];
$pie8 = $_REQUEST['pie8'];
$pie9 = $_REQUEST['pie9'];

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

mysqli_query($conexion, "update ticket set linea1 = '$linea1',linea2 = '$linea2',linea3 = '$linea3',linea4 = '$linea4',linea5 = '$linea5',linea6 = '$linea6',linea7 = '$linea7',linea8 = '$linea8',linea9 = '$linea9',pie1 = '$pie1',pie2 = '$pie2',pie3 = '$pie3',pie4 = '$pie4',pie5 = '$pie5',pie6 = '$pie6',pie7 = '$pie7',pie8 = '$pie8',pie9 = '$pie9' where sucursal = '$codloc'");
//echo $linea1."<br>";
//echo $linea."<br>";

header("Location: index1.php?srch=1&local=$codloc");
?>