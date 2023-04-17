<?php
require_once('conexion.php');
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1))
{
    while ($row1 = mysqli_fetch_array($result1)){
           $porcent    = $row1['porcent'];
    }
}
$sql= "SELECT invnum FROM venta 
       WHERE invtot = 0 AND estado = 0 AND val_habil =0";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $invnum = $row['invnum'];
        $mont_bruto  = 0;
        $monto_total = 0;
        $valor_vent1 = 0;
        $sqlX= "SELECT codpro,canpro,fraccion,factor,prisal,pripro 
                FROM detalle_venta 
                WHERE invnum = $invnum";
         $resultX = mysqli_query($conexion,$sqlX);	
         if (mysqli_num_rows($resultX))
         {
             while ($rowX = mysqli_fetch_array($resultX))
             {
                $codpro    = $rowX['codpro'];
		$canpro    = $rowX['canpro'];
		$fraccion  = $rowX['fraccion'];
		$factor    = $rowX['factor'];
		$prisal    = $rowX['prisal'];
		$pripro    = $rowX['pripro'];
                $sql2="SELECT igv,prelis,factor,prevta,margene,preuni FROM producto where codpro = '$codpro'";
                $result2 = mysqli_query($conexion,$sql2);
                if (mysqli_num_rows($result2)){
                while ($row2 = mysqli_fetch_array($result2)){
                    $igv            = $row2['igv'];
                    $referencial    = $row2['prelis'];
                    $factor         = $row2['factor'];
                    $prevta         = $row2['prevta'];
                    $margene        = $row2['margene'];
                    $preuni         = $row2['preuni'];
                }
                }
                if (($referencial <> 0) and ($referencial <> $prevta))
                {
                        $margenes       = ($margene/100)+1;
                        $precio_refX    = $referencial;
                        $precio_ref	= $precio_refX * $margenes;
                }
                else
                {
                        $precio_ref	= $preuni;
                }
                if ($fraccion =='T')			
                {
                        $cantidad_comp = $canpro;
                }
                else
                {
                        $cantidad_comp = $canpro * $factor;
                }
                if ($fraccion =='T')			
                {
                        $sum_mont1 = ($precio_ref/$factor) * $cantidad_comp;
                }
                else
                {
                        $sum_mont1 = $precio_ref * $canpro;
                }
                if ($igv == 1)
                {
                        if ($fraccion =='T')			
                        {
                        $valor_vent	= ($prisal/(($porcent/100)+1))*$cantidad_comp;
                        }
                        else
                        {
                        $valor_vent	= ($prisal/(($porcent/100)+1))*$canpro;
                        }
                        $valor_vent1	= $valor_vent1 + $valor_vent;
                }
                else
                {
                        if ($fraccion =='T')			
                        {
                        $valor_vent     = ($prisal * $cantidad_comp);
                        }
                        else
                        {
                        $valor_vent     = ($prisal * $canpro);
                        }
                        $valor_vent1	= $valor_vent1 + $valor_vent;
                }
                $mont_bruto  = $mont_bruto + $sum_mont1;
                $monto_total = $monto_total + $pripro;
            }
            $r           = $monto_total;
            $sum_igv	 = ($monto_total - $valor_vent1);
            $redondeo	 = $monto_total - $r;
            $mont1	 = $mont_bruto;			///PRECIO BRUTO
            $mont3	 = $valor_vent1;		///PRECIO VENTA
            $mont4	 = $sum_igv;			///IGV
            $mont5	 = $monto_total;		///TOTAL
            mysqli_query($conexion,"UPDATE venta set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',redondeo = '$redondeo' where invnum = '$invnum'");
         }
    }
}
?>
