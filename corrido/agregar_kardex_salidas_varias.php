<?php
require_once('conexion.php');
/////////////////////////////7
//$local = '6';
//$local = '5';
$local = '1';
/////////////////////777

$sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomlocalG = $row['nomloc'];
        $nombre = $row['nombre'];
    }
}

$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$fechaActual = date('Y-m-d');
//////////////////////// PASOS////////////////////////
// 1-$tabla > 0
// 2-$tabla < 0
$sql = "SELECT codpro,factor,$tabla,stopro FROM producto   WHERE $tabla > 0 ORDER BY codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro    = $row['codpro'];
        $factor    = $row['factor'];
        $stopro    = $row['stopro'];
        $stock_unidades    = $row[2];

        /////////////////////////
        if ($stock_unidades > 0) {
            $sactual = $stock_unidades;
            $cant_unid = $stock_unidades;
            $cant_local = $stock_unidades - $cant_unid;
            if ($factor == 1) {
                $cantidad_kardex =  $stock_unidades;
            } else {
                $cantidad_kardex = 'f' . $stock_unidades;
            }
            if ($stopro > 0) {
                $stopro = $stopro - $cant_unid;
            } else {
                $stopro = $stopro + $cant_unid;
            }
            // echo '$cantidad_kardex =' . $cantidad_kardex, "<br>";
            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            if ($factor == 1) {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','2','1','$cantidad_kardex','','$factor','0','2','$sactual','$local')");
            } else {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','2','1','0','$cantidad_kardex','$factor','0','2','$sactual','$local')");
            }
        } else {
            $sactual = $stock_unidades;
            $cant_unid = $stock_unidades;
            $cant_local = $stock_unidades - $cant_unid;
            $stock_unidades_sin = substr($stock_unidades, 1);
            if ($factor == 1) {
                $cantidad_kardex =  $stock_unidades_sin;
                // $sactual = $stock_unidades_sin;
            } else {
                $cantidad_kardex = 'f' . $stock_unidades_sin;
                //$sactual = $stock_unidades_sin;
            }
            if ($stopro > 0) {
                $stopro = $stopro;
            } else {
                $stopro = $stopro;
            }
            // echo '$cantidad_kardex =' . $cantidad_kardex, "<br>";
            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            if ($factor == 1) {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','1','5','$cantidad_kardex','','$factor','0','2','$sactual','$local')");
            } else {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','1','5','0','$cantidad_kardex','$factor','0','2','$sactual','$local')");
            }
        }
    }
}
