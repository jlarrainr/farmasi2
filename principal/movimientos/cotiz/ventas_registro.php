<?php

include('../../session_user.php');
require_once('../../../conexion.php');
$sql = "SELECT * FROM cotizacion where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
        mysqli_query($conexion, "DELETE from cotizacion_det where invnum = '$invnum'");
        mysqli_query($conexion, "DELETE from cotizacion where invnum = '$invnum'");
    }
}
$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcli = $row['codcli'];
    }
}
$sql = "SELECT invnum FROM cotizacion order by invnum desc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcotiz = $row['invnum'];
    }
    $codcotiz++;
} else {
    $codcotiz = 1;
}
$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
//echo $date;
mysqli_query($conexion, "INSERT INTO cotizacion (invnum,invfec,usecod,cuscod,forpag,estado,sucursal) values ('$codcotiz','$date','$usuario','$codcli','E','1','$codloc')");
header("Location: venta_index.php");
