
<?php

require_once('../conexion.php');

function convertir_a_numero($str)
{
	$legalChars = "%[^0-9\-\. ]%";
	$str = preg_replace($legalChars, "", $str);
	return $str;
}

$invnum = '727';
$tipmov = '1';
$tipdoc = '5';

$sqlKardex = "SELECT nrodoc, codpro, fecha,qtypro,fraccion,factor,usecod,sucursal,tipmov,tipdoc FROM kardex WHERE invnum='$invnum' and tipmov='$tipmov' and tipdoc ='$tipdoc'";
$resultKardex = mysqli_query($conexion, $sqlKardex);
if (mysqli_num_rows($resultKardex)) {
    while ($rowkardex = mysqli_fetch_array($resultKardex)) {
        $nrodoc     = $rowkardex['nrodoc'];
        $codpro     = $rowkardex['codpro'];
        $fecha      = $rowkardex['fecha'];
        $qtypro     = $rowkardex['qtypro'];
        $fraccion   = $rowkardex['fraccion'];
        $factor     = $rowkardex['factor'];
        $usecod     = $rowkardex['usecod'];
        $sucursal   = $rowkardex['sucursal'];
        $tipmov1   = $rowkardex['tipmov'];
        $tipdoc1  = $rowkardex['tipdoc'];
        
        
        $sqlproducto = "SELECT costre,costpr,factor FROM producto WHERE codpro='$codpro' ";
        $resultproducto = mysqli_query($conexion, $sqlproducto);
        if (mysqli_num_rows($resultproducto)) {
            while ($rowproducto = mysqli_fetch_array($resultproducto)) {
                
                $costre   = $rowproducto['costre'];
                $costpr   = $rowproducto['costpr'];
                $factor   = $rowproducto['factor'];
            }
        
        }
        
        
         if($qtypro >0){
             $qtypro=$qtypro;
             $fraccion='';
             $cantidad=$qtypro;
             $precio=$costre;
             $costo=$cantidad*$precio;
         }else{
             $qtypro='0';
             $fraccion=$fraccion;
             
             $numero= convertir_a_numero($fraccion);
             $cantidad=$numero;
             $precio=($costre/$factor);
             $costo=$cantidad*$precio;
             
         }
        
        
        mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,costpr,codloc) values ('$invnum','$fecha','$codpro','$qtypro','$fraccion','$precio','$precio','$costo','$costpr','$sucursal')");
         

        $sqlmov = "SELECT SUM(costre) as sumatotal FROM movmov WHERE invnum='$invnum'";
        $resultmov = mysqli_query($conexion, $sqlmov);
        if (mysqli_num_rows($resultmov)) {
            while ($rowmov = mysqli_fetch_array($resultmov)) {
                
                $sumatotal  = $rowmov['sumatotal'];
             
            }
        
        }

        mysqli_query($conexion, "INSERT INTO movmae (invnum,invfec,usecod,numdoc,invtot,tipmov,tipdoc,monto,sucursal,codusu) values ('$invnum','$fecha','$usecod','$nrodoc','$sumatotal','$tipmov1','$tipdoc1','$sumatotal','$sucursal','$usecod')");
    }
    
    
}





