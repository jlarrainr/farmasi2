<?php

include('../../../session_user.php');
$invnum = $_SESSION['ingresos_val'];
//error_log("Session Lote_reg Aux: ".$_SESSION['ingresos_val']);
//error_log("invnum ".$invnum);
require_once ('../../../../conexion.php');
$numero = $_REQUEST['country'];
$codpro = $_REQUEST['codpro'];
$mes = $_REQUEST['mes'];
$years = $_REQUEST['years'];
$vencimiento = $mes . "/" . $years;
//error_log("numero ".$numero);
//error_log("codpro ".$codpro);
$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
//error_log("codloc de lote ".$codloc);
$sql1 = "SELECT numlote,vencim FROM movlote where numlote = '$numero' and codpro = '$codpro' and codloc='$codloc'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $numlote = $row1['numlote'];
        $vencimi = $row1['vencim'];
    }
    /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
    $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro' and codloc='$codloc'";
    $result2 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result2)) {
//		error_log("PRUEBA============");
        mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi' where invnum = '$invnum' and codpro = '$codpro' and codloc='$codloc'");
    } else {
//		error_log("PRUEB2A============");
        mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim, codloc) values ('$invnum','$numlote','$codpro','$vencimi', '$codloc')");
    }
////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
/////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
    $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro' and codloc='$codloc'";
    $result2 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result2)) {
//		error_log("PRUEBA3============");
        mysqli_query($conexion, "UPDATE templote set numerolote = '$numero',vencim = '$vencimiento' where invnum = '$invnum' and codpro = '$codpro' and codloc='$codloc'");
    } else {
//		error_log("PRUEBA4============");
        mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro, codloc) values ('$invnum','$numero','$vencimiento','$codpro', '$codloc')");
//		error_log("INSERT INTO templote (invnum,numerolote,vencim,codpro, codloc) values ('$invnum','$numero','$vencimiento','$codpro', '$codloc')");
    }
////////////////////////////////////////////////////////////////////////////////////////////////////
}
header("Location: lote.php?cod=$codpro");
?>