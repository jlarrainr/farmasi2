<?php 
require_once ('../conexion.php');


////////////////////////////////////////

$invnumOld      = '1334';

////////////////////////////////////////


$fechaActual    =date('Y-m-d');
mysqli_query($conexion, "INSERT INTO venta (invfec) values ('$fechaActual')");
$invnumNew = mysqli_insert_id($conexion);


$sql="SELECT * FROM venta where invnum = '$invnumOld' ";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$sucursal           = $row['sucursal'];
		$tipdoc             = $row['tipdoc'];
		$cuscod             = $row['cuscod'];
		$usecod             = $row['usecod'];
		$bruto              = $row['bruto'];
		$valven             = $row['valven'];
		$invtot             = $row['invtot'];
		$igv                = $row['igv'];
		$forpag             = $row['forpag'];
		$numeroCuota        = $row['numeroCuota'];
		$ventaDiasCuotas    = $row['ventaDiasCuotas'];
		$saldo              = $row['saldo'];
		$fecven             = $row['fecven'];
		$estado             = $row['estado'];
		$val_habil          = 0;
		$cosvta             = $row['cosvta'];
		$hora               = date('H:i:s a');
		$nomcliente         = $row['nomcliente'] ;
		$pagacon            = $row['pagacon'] ;
		$vuelto             = $row['vuelto'] ;
		$codmed             = $row['codmed'] ;
		$inafecto           = $row['inafecto'] ;
		$tipteclaimpresa    = $row['tipteclaimpresa'] ;
		$gravado            = $row['gravado'] ;
		 
		 
		 
		 
		  $NuevoCorrelativo = 0;
                //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
                $sqlXCOM = "SELECT seriebol,seriefac,serietic,numbol,numfac,numtic,correlativo_venta FROM xcompa where codloc = '$sucursal'";
                $resultXCOM = mysqli_query($conexion, $sqlXCOM);
                if (mysqli_num_rows($resultXCOM)) {
                    while ($row = mysqli_fetch_array($resultXCOM)) {
                        $seriebol = $row['seriebol'];
                        $seriefac = $row['seriefac'];
                        $serietic = $row['serietic'];
                        $numbol = $row['numbol'];
                        $numfac = $row['numfac'];
                        $numtic = $row['numtic'];
                        $correlativo_venta = $row['correlativo_venta'];
                        // BOLETA
                        if ($tipdoc == 1) {
                            $serie = "F" . $seriefac;
                            $NuevoCorrelativo = $numbol + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numbol = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                        // FACTURA
                        if ($tipdoc == 2) {
                            $serie = "B" . $seriebol;
                            $NuevoCorrelativo = $numfac + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numfac = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                        //TICKET
                        if ($tipdoc == 4) {
                            $serie = "T" . $serietic;
                            $NuevoCorrelativo = $numtic + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numtic = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                    }
                    $PrintSerie = $serie . '-' . $NuevoCorrelativo;
                    mysqli_query($conexion, "UPDATE venta set nrovent = '$NuevoCorrelativo', correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie',correlativo_venta='$correlativo_venta_suma' where invnum = '$invnumNew'");
                }
                
		
		mysqli_query($conexion,"UPDATE venta set sucursal='$sucursal',tipdoc='$tipdoc',cuscod='$cuscod',usecod='$usecod',bruto='$bruto',valven='$valven',invtot='$invtot',igv='$igv',forpag='$forpag', numeroCuota='$numeroCuota',ventaDiasCuotas='$ventaDiasCuotas',saldo='$saldo',fecven='$fecven',estado='$estado',val_habil='$val_habil',cosvta='$cosvta',hora='$hora',nomcliente='$nomcliente',pagacon='$pagacon',vuelto='$vuelto',codmed='$codmed',inafecto='$inafecto',tipteclaimpresa='$tipteclaimpresa',gravado='$gravado' where invnum = '$invnumNew'");

}
}
 
$sqlP = "SELECT cuscod,usecod,codven,codpro, canpro,fraccion,factor,prisal,pripro,cospro,costpr,codmar,incentivo,bonif,ultcos,idlote,icbperfactor,icbpersubtotal FROM detalle_venta where invnum = '$invnumOld' ";
            $resultP = mysqli_query($conexion, $sqlP);
            if (mysqli_num_rows($resultP)) {
                while ($row = mysqli_fetch_array($resultP)) {
                    $cuscod     = $row['cuscod'];
                    $usecod     = $row['usecod'];
                    $codven     = $row['codven'];
                    $codpro     = $row['codpro'];
                    $canpro     = $row['canpro'];
                    $fraccion   = $row['fraccion'];
                    $factor     = $row['factor'];
                    $prisal     = $row['prisal'];
                    $pripro     = $row['pripro'];
                    $cospro     = $row['cospro'];
                    $costpr     = $row['costpr'];
                    $codmar     = $row['codmar'];
                    $incentivo  = $row['incentivo'];
                    $bonif      = $row['bonif'];
                    $ultcos     = $row['ultcos'];
                    $idlote     = $row['idlote'];
                    $icbperfactor = $row['icbperfactor'];
                    $icbpersubtotal = $row['icbpersubtotal'];
                    
                    
                    
                  mysqli_query($conexion, "INSERT INTO detalle_venta (invfec,invnum,cuscod,usecod,codven,codpro, canpro,fraccion,factor,prisal,pripro,cospro,costpr,codmar,incentivo,bonif,ultcos,idlote,icbperfactor,icbpersubtotal) values ('$fechaActual','$invnumNew','$cuscod','$usecod','$codven','$codpro', '$canpro','$fraccion','$factor','$prisal','$pripro','$cospro','$costpr','$codmar','$incentivo','$bonif','$ultcos','$idlote','$icbperfactor','$icbpersubtotal')");  
                }
            }



 
 