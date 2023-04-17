<?php
require_once('../conexion.php');
/////////////////////////////
 
$localOrigen = '2';
$localDestino = '1';

/////////////////////

$sqlOrigen = "SELECT nomloc,nombre FROM xcompa where codloc = '$localOrigen'";
$resultOrigen = mysqli_query($conexion, $sqlOrigen);
if (mysqli_num_rows($resultOrigen)) {
    while ($row = mysqli_fetch_array($resultOrigen)) {
        $nomlocalG = $row['nomloc'];
        $nombre = $row['nombre'];
    }
}


$numero_xcompaOrigen = substr($nomlocalG, 5, 2);
$tablaOrigen = "s" . str_pad($numero_xcompaOrigen, 3, "0", STR_PAD_LEFT);
$fechaActual = date('Y-m-d');



$sqlDestino= "SELECT nomloc,nombre FROM xcompa where codloc = '$localDestino'";
$resultDestino = mysqli_query($conexion, $sqlDestino);
if (mysqli_num_rows($resultDestino)) {
    while ($row = mysqli_fetch_array($resultDestino)) {
        $nomlocalG = $row['nomloc'];
        $nombre = $row['nombre'];
    }
}


$numero_xcompaDestino = substr($nomlocalG, 5, 2);
$tablaDestino = "s" . str_pad($numero_xcompaDestino, 3, "0", STR_PAD_LEFT);

echo "local origen: " . $tablaOrigen . '<br>';

echo "local destino: " . $tablaDestino;


$sql = "SELECT codpro,factor,$tablaOrigen,stopro FROM producto  WHERE  $tablaOrigen>0 ORDER BY codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro    = $row['codpro'];
        $factor    = $row['factor'];
        $stopro    = $row['stopro'];
        $stock_unidadesOrigen    = $row[2];
        
        
        $sql = "SELECT codpro,factor,$tablaDestino,stopro FROM producto  WHERE  codpro='$codpro' ORDER BY codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro    = $row['codpro'];
        $factor    = $row['factor'];
        $stopro    = $row['stopro'];
        $stock_unidadesDestino    = $row[2];
        
        
    } 
}
        
        
        $nuevoStock= $stock_unidadesDestino + $stock_unidadesOrigen;
        
         mysqli_query($conexion, "UPDATE producto set $tablaDestino = '$nuevoStock' where codpro = '$codpro'");

        /////////////////////////
       // if ($stock_unidades < 0) {
            
            $sactual = 0;
            $cant_unid = $stock_unidadesOrigen;
            $cant_local = $stock_unidadesOrigen - $cant_unid;
            
            $stock_unidades_sin = $stock_unidadesOrigen;
            
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
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values 
                                            ('0','$codpro','$fechaActual','1','5','$cantidad_kardex','','$factor','0','2','$sactual','$localDestino')");
            } else {
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values 
                                            ('0','$codpro','$fechaActual','1','5','0','$cantidad_kardex','$factor','0','2','$sactual','$localDestino')");
            }
            
            
            
    ///SACAR EL STOCK ACTUAL DE LA TABLA ORIGEN
    
    
            
            
            
      //  } 
    }
}