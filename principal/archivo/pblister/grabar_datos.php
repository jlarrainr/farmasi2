<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$p3       = $_REQUEST['p3'];
$blister  = $_REQUEST['blister'];
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];


$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}



if ($precios_por_local == 1) {
    require_once '../../../precios_por_local.php';
}


if ($precios_por_local == 1) {

    if ($zzcodloc == 1) {

        mysqli_query($conexion, "UPDATE producto set preblister = '$p3',blister = '$blister' where codpro = '$codpro'");
    } else {

        mysqli_query($conexion, "UPDATE precios_por_local set   $blister_p='$blister',$preblister_p='$preblister'  where codpro = '$codpro'");
    }
} else {

    mysqli_query($conexion, "UPDATE producto set preblister = '$p3',blister = '$blister' where codpro = '$codpro'");
}



header("Location: pventa2.php?search=$search&&val=1");
