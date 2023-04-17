<?php
require_once('../conexion.php');
require_once('session_user.php');
$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $sucursal = $row1['codloc'];
    }
}
//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);



$mess = date('Y-m');
$Ffecha = date("Y-m", strtotime('+1 month', strtotime($mess)));
$mesdos = $Ffecha;
$D1 = $mess . "-00";
$D2 = $mesdos . "-00";

$sql1 = "SELECT codpro,idlote from movlote where STR_TO_DATE(vencim, '%m/%Y') <= '$D1' AND  stock > 0  ";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codpro = $row1[0];
        $idlote = $row1[1];

        $sql = "SELECT $tabla FROM producto  WHERE codpro = '$codpro'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $stock_producto = $row[0];
            }
        }
        if ($stock_producto <= 0) {
            mysqli_query($conexion, "UPDATE movlote set stock = '0' where idlote = '$idlote'");
        }
    }
}
header("Location: index.php?entra=1");
