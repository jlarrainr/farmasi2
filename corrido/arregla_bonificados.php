<?php
require_once('../conexion.php');
 function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
$sqlX = "SELECT invnum, qtypro, qtyprf, codpro FROM `movmov` WHERE pripro='0' and costre='0' ORDER BY  invnum  ";
$resultX = mysqli_query($conexion, $sqlX);
if (mysqli_num_rows($resultX)) {
    while ($rowX = mysqli_fetch_array($resultX)) {
        $invnum  = $rowX[0];
        $qtypro  = $rowX[1];
        $qtyprf = $rowX[2];
        $codpro  = $rowX[3];
        
        $sqlY = "SELECT costre,costpr,factor FROM `producto` WHERE codpro='$codpro' ";
        $resultY = mysqli_query($conexion, $sqlY);
         if (mysqli_num_rows($resultY)) {
           while ($rowY = mysqli_fetch_array($resultY)) {
             $costre = $rowY[0];
              $costpr  = $rowY[1];
              $factor = $rowY[2];
            }
        }
        
        if ($qtypro<>'0'){
            $cantidaC=$qtypro;
            $pPromedio=$costre;
             $subTotal=$pPromedio*$cantidaC;
        }else{
            $cantidaC=convertir_a_numero($qtyprf);
            $pPromedio=$costre/$factor;
            $subTotal=$pPromedio*$cantidaC;
        }
        
        
         mysqli_query($conexion, "UPDATE movmov set costre = '$subTotal', pripro='$pPromedio' where invnum = '$invnum' and codpro='$codpro'");
        
        
        
        
        
        
    }
    
    
}