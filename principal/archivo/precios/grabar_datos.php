<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$p1       = $_REQUEST['p1'];
$p2       = $_REQUEST['p2'];
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];
$factor   = $_REQUEST['factor'];
$margene1   = $_REQUEST['pCaja'];
$p3       = $_REQUEST['p3'];
$costpr   = $_REQUEST['costpr'];
$utlcos   = $_REQUEST['utlcos'];
$blister   = $_REQUEST['blister'];
$preblister   = $_REQUEST['preblister'];

$opPrevta2   = $_REQUEST['opPrevta2'];
$opPrevta3   = $_REQUEST['opPrevta3'];
$opPrevta4   = $_REQUEST['opPrevta4'];
$opPrevta5   = $_REQUEST['opPrevta5'];
$opPreuni2   = $_REQUEST['opPreuni2'];
$opPreuni3   = $_REQUEST['opPreuni3'];
$opPreuni4   = $_REQUEST['opPreuni4'];
$opPreuni5   = $_REQUEST['opPreuni5'];

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
                $precios_por_local = $row['precios_por_local'];
        }
}

$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
                $codloc = $row1['codloc'];
        }
}
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
        while ($rowLocal = mysqli_fetch_array($resultLocal)) {
                $nomlocalG = $rowLocal['nomloc'];
        }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);


$sqlProducto = "SELECT $tabla FROM producto";
$resultProducto = mysqli_query($conexion, $sqlProducto);
if (mysqli_num_rows($resultProducto)) {
        while ($rowProducto = mysqli_fetch_array($resultProducto)) {
                $stock = $rowProducto[0];
        }
}



if ($precios_por_local == 1) {
        require_once '../../../precios_por_local.php';
}


if ($costpr == 0) {

        if ($precios_por_local == 1) {

                if ($zzcodloc == 1) {

                        mysqli_query($conexion, "UPDATE producto set utlcos = '$p1', costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1' ,blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5'  where codpro = '$codpro'");
                } else {

                        mysqli_query($conexion, "UPDATE precios_por_local set $utlcos_p = '$p1', $costpr_p = '$p1',$costre_p = '$p1', $prevta_p = '$p2',$preuni_p = '$p3', $margene_p = '$margene1', $blister_p='$blister',$preblister_p='$preblister'  where codpro = '$codpro'");
                }
        } else {

                mysqli_query($conexion, "UPDATE producto set utlcos = '$p1', costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
        }


        header("Location: precios2.php?search=$search&val=$val");
} else {

if($utlcos >0){
    if ($stock > 0) {

                if ($precios_por_local == 1) {
                        if ($zzcodloc == 1) {
                                mysqli_query($conexion, "UPDATE producto set costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                        } else {
                                mysqli_query($conexion, "UPDATE precios_por_local set  $costre_p = '$p1', $prevta_p = '$p2',$preuni_p = '$p3', $margene_p = '$margene1', $blister_p ='$blister',$preblister_p ='$preblister'  where codpro = '$codpro'");
                        }
                } else {
                        mysqli_query($conexion, "UPDATE producto set costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                }
        } else {

                if ($precios_por_local == 1) {
                        if ($zzcodloc == 1) {
                                mysqli_query($conexion, "UPDATE producto set costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                        } else {
                                mysqli_query($conexion, "UPDATE precios_por_local set  $costpr_p = '$p1', $costre_p = '$p1', $prevta_p = '$p2',$preuni_p = '$p3', $margene_p = '$margene1', $blister_p ='$blister',$preblister_p ='$preblister'  where codpro = '$codpro'");
                        }
                } else {
                        mysqli_query($conexion, "UPDATE producto set  costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                }
        }
}else{
    if ($stock > 0) {

                if ($precios_por_local == 1) {
                        if ($zzcodloc == 1) {
                                mysqli_query($conexion, "UPDATE producto set utlcos = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                        } else {
                                mysqli_query($conexion, "UPDATE precios_por_local set $utlcos_p = '$p1', $costre_p = '$p1', $prevta_p = '$p2',$preuni_p = '$p3', $margene_p = '$margene1', $blister_p ='$blister',$preblister_p ='$preblister'  where codpro = '$codpro'");
                        }
                } else {
                        mysqli_query($conexion, "UPDATE producto set utlcos = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                }
        } else {

                if ($precios_por_local == 1) {
                        if ($zzcodloc == 1) {
                                mysqli_query($conexion, "UPDATE producto set utlcos = '$p1', costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                        } else {
                                mysqli_query($conexion, "UPDATE precios_por_local set $utlcos_p = '$p1', $costpr_p = '$p1', $costre_p = '$p1', $prevta_p = '$p2',$preuni_p = '$p3', $margene_p = '$margene1', $blister_p ='$blister',$preblister_p ='$preblister'  where codpro = '$codpro'");
                        }
                } else {
                        mysqli_query($conexion, "UPDATE producto set utlcos = '$p1', costpr = '$p1',costre = '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1',blister='$blister',preblister='$preblister', opPrevta2='$opPrevta2',opPrevta3='$opPrevta3',opPrevta4='$opPrevta4',opPrevta5='$opPrevta5',opPreuni2='$opPreuni2',opPreuni3='$opPreuni3',opPreuni4='$opPreuni4',opPreuni5='$opPreuni5' where codpro = '$codpro'");
                }
        }
}
        


        header("Location: precios2.php?search=$search&val=$val");
}
