
<?php

require_once('../conexion.php');

function convertir_a_numero($str)
{
	$legalChars = "%[^0-9\-\. ]%";
	$str = preg_replace($legalChars, "", $str);
	return $str;
}

$invnum = '5';
$tipmov = '9';
$tipdoc = '9';





$sqlKardex = "SELECT  codpro, qtypro,fraccion,factor FROM kardex WHERE invnum='$invnum' and tipmov='$tipmov' and tipdoc ='$tipdoc'";
$resultKardex = mysqli_query($conexion, $sqlKardex);
if (mysqli_num_rows($resultKardex)) {
    while ($rowkardex = mysqli_fetch_array($resultKardex)) {
        
        $codpro     = $rowkardex['codpro'];
        
        $qtypro     = $rowkardex['qtypro'];
        $fraccion   = $rowkardex['fraccion'];
        $factor     = $rowkardex['factor'];

        $sqlventa = "SELECT invnum,invfec,cuscod,usecod FROM venta WHERE invnum='$invnum'";
        $resultventa = mysqli_query($conexion, $sqlventa);
        if (mysqli_num_rows($resultventa)) {
            while ($rowventa = mysqli_fetch_array($resultventa)) {

                $invnum   = $rowventa['invnum'];
                $invfec   = $rowventa['invfec'];
                $cuscod   = $rowventa['cuscod'];
                $usecod   = $rowventa['usecod'];
                
            }
        
        }
       
        
        
        $sqlproducto = "SELECT codpro,preuni,prevta,factor,codmar FROM producto WHERE codpro='$codpro' ";
        $resultproducto = mysqli_query($conexion, $sqlproducto);
        if (mysqli_num_rows($resultproducto)) {
            while ($rowproducto = mysqli_fetch_array($resultproducto)) {

                $codpro   = $rowproducto['codpro'];
                $preuni   = $rowproducto['preuni'];
                $prevta   = $rowproducto['prevta'];
                $factor   = $rowproducto['factor'];
                $codmar   = $rowproducto['codmar'];
            }
        
        }
        
        
         if($qtypro >0){
             $qtypro=$qtypro;
             $fraccion='F';
             $cantidad=$qtypro;
             $precio=$prevta;
             $costo=$cantidad*$precio;
             
         }else{
             $qtypro='0';
             $fraccion1=$fraccion;
             $fraccion='T';
             
             
             $numero= convertir_a_numero($fraccion1);
             $cantidad=$numero;
             $precio=$preuni;
             $costo=$cantidad*$precio;
             
             
         }
        
        
        mysqli_query($conexion, "INSERT INTO detalle_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar) values ('$invnum','$invfec','$cuscod','$usecod','$codpro','$cantidad','$fraccion','$factor','$precio','$costo','$codmar')");

       // mysqli_query($conexion, "INSERT INTO movmae (invnum,invfec,usecod,numdoc,qtyprf,pripro,costre,costpr) values ('$invnum','$fecha','$codpro','$qtypro','$fraccion','$precio','$costo','$costpr')");
       
       
       
        
        echo  '-------datos kardex---------------------' . "<br>";
        echo  'invnumventa          = ' . $invnum . "<br>";
        echo  'codpro          = ' . $codpro . "<br>";
        echo  'qtypro          = ' . $qtypro . "<br>";
        echo  'fraccion          = ' . $fraccion . "<br>";
        
        echo  'factor          = ' . $factor . "<br>";


        echo  '-------datos producto---------------------' . "<br>";
        echo  'codpro          = ' . $codpro . "<br>";
        echo  'preuni          = ' . $preuni . "<br>";
        echo  'prevta          = ' . $prevta . "<br>";
        echo  'factor          = ' . $factor . "<br>";
        echo  'codmar          = ' . $codmar . "<br>";
        echo  'cantidad          = ' . $cantidad . "<br>";
        echo  'precio          = ' . $precio . "<br>";
        echo  'costo          = ' . $costo . "<br>";




        echo  '-------datos venta---------------------' . "<br>";
        echo  'invnum          = ' . $invnum . "<br>";
        echo  'invfec          = ' . $invfec . "<br>";
        echo  'cuscod          = ' . $cuscod . "<br>";
        echo  'usecod          = ' . $usecod . "<br>";
      
     
     
        
    
    
    
    
    
    }





   



    
    
}

