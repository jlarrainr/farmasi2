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


if ($logo <> "") {
    
    
    if ($todos == 1) {
        mysqli_query($conexion, "update xcompa set logo='$logo' ");
    } else {
        mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '$imprapida',habil = '$habil',logo='$logo' where codloc = '$codloc'");
    }
} else {
    mysqli_query($conexion, "update xcompa set nombre = '$text',imprapida = '$imprapida',habil = '$habil' where codloc = '$codloc'");
}
header("Location: index1.php?srch=1&local=$codloc");
?>