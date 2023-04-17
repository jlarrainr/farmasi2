
<?php

require_once('conexion.php');

function convertir_a_numero($str)
{
	$legalChars = "%[^0-9\-\. ]%";
	$str = preg_replace($legalChars, "", $str);
	return $str;
}

$invnum = '21019';
$tipmov = '2';
$tipdoc = '3';

$sqlKardex = "SELECT nrodoc, codpro, fecha,qtypro,fraccion,factor,usecod,sucursal FROM kardex WHERE invnum='$invnum' and tipmov='$tipmov' and tipdoc ='$tipdoc'";
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
        
        
        //mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr) values ('$invnum','$fecha','$codpro','$qtypro','$fraccion','$precio','$costo','$costpr')");
    }
    
    
}





