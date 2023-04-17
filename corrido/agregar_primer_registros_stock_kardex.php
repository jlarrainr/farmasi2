<?php
require_once('../conexion.php');
/////////////////////////////7
 mysqli_query($conexion, "UPDATE producto set stoini = 0");
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

$sql = "SELECT codpro,factor,$tabla,stopro FROM producto   WHERE   $tabla>0 ORDER BY codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro    = $row['codpro'];
        $factor    = $row['factor'];
        $stopro    = $row['stopro'];
        $stock_unidades    = $row[2];

        /////////////////////////
       // if ($stock_unidades < 0) {
            
            $sactual = 0;
            $cant_unid = $stock_unidades;
            $cant_local = $stock_unidades - $cant_unid;
            
            $stock_unidades_sin = $stock_unidades;
            
            if ($factor == 1) {
                $cantidad_kardex =  $stock_unidades_sin;
                
            } else {
                $cantidad_kardex = 'f' . $stock_unidades_sin;
                
            }
            if ($stopro > 0) {
                $stopro = $stopro;
            } else {
                $stopro = $stopro;
            }
            
           
            if ($factor == 1) {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','1','5','$cantidad_kardex','','$factor','0','2','$sactual','$local')");
            } else {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('0','$codpro','$fechaActual','1','5','0','$cantidad_kardex','$factor','0','2','$sactual','$local')");
            }
      //  } 
    }
}

$sqlP = "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,codpro,stoini FROM producto  order by codpro";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $codpro = $row['codpro'];
        $s000   = $row['s000'];
        $s001   = $row['s001'];
        $s002   = $row['s002'];
        $s003   = $row['s003'];
        $s004   = $row['s004'];
        $s005   = $row['s005'];
        $s006   = $row['s006'];
        $s007   = $row['s007'];
        $s008   = $row['s008'];
        $s009   = $row['s009'];
        $s010   = $row['s010'];
        $s011   = $row['s011'];
        $s012   = $row['s012'];
        $s013   = $row['s013'];
        $s014   = $row['s014'];
        $s015   = $row['s015'];
        $s016   = $row['s016'];
        $s017   = $row['s017'];
        $s018   = $row['s018'];
        $s019   = $row['s019'];
        $s020   = $row['s020'];
        $stoini = $row['stoini'];
        $Stotal = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016 + $s017 + $s018 + $s019 + $s020;
        mysqli_query($conexion, "UPDATE producto set stopro ='$Stotal' where codpro = $codpro");
    }
}
