<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once ('../../../function_sunat.php');

$cod = $_REQUEST['cod'];     // venta anterior
//$invnumMd = $_REQUEST['invnumMd'];      // venta nueva   
$usuario = $_REQUEST['usuario'];        // usuario
$invnummovmae = $_SESSION['nota_credito'];
$lastid = 0;
//echo $cod."<br>";
//echo $invnumMd."<br>";
//echo $usuario."<br>";

$date = date("Y-m-d");
$hora = date('H:i:s a');
$sql = "SELECT usecod,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $usecod = $row['usecod'];
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT tipdoc FROM temp_venta2 where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $tipdoc = $row['tipdoc'];
    }
}

$sqlcontador = "SELECT count(*) FROM temp_detalle_venta where invnum = '$cod' and resta <> 0";
$resultcontador = mysqli_query($conexion, $sqlcontador);
if (mysqli_num_rows($resultcontador)) {
    while ($rowcontador = mysqli_fetch_array($resultcontador)) {
        $contador = $rowcontador['0'];
    }
}

if ($contador == '0') {

    mysqli_query($conexion, "DELETE from temp_detalle_venta where invnum = '$cod'");
    mysqli_query($conexion, "DELETE from temp_venta2 where invnum = '$cod'");

    echo '<script type="text/javascript">
                                    alert("Debe digitar la cantidad de los productos que van a ser devueltos y luego grabar.");
                                    window.location.href="devolucion.php";
                    </script>';

    return;
} else {
    $col_stock = "s" . sprintf('%03d', $codloc - 1);
    $NuevoCorrelativo = 0;
//RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
    $sqlXCOM = "SELECT serienotboleta,serienotfactura,numnotboleta,numnotfactura FROM xcompa  where codloc = '$codloc'";
    $resultXCOM = mysqli_query($conexion, $sqlXCOM);
    if (mysqli_num_rows($resultXCOM)) {
        while ($row = mysqli_fetch_array($resultXCOM)) {
            $serienotboleta = $row['serienotboleta'];
            $serienotfactura = $row['serienotfactura'];
            $numnotboleta = $row['numnotboleta'];
            $numnotfactura = $row['numnotfactura'];

            if ($tipdoc == '2') {
                $NuevoCorrelativo = $numnotboleta + 1;
                mysqli_query($conexion, "UPDATE xcompa set numnotboleta = '$NuevoCorrelativo' where codloc = '$codloc'");
            }
            if ($tipdoc == '1') {

                $NuevoCorrelativo = $numnotfactura + 1;
                mysqli_query($conexion, "UPDATE xcompa set numnotfactura = '$NuevoCorrelativo' where codloc = '$codloc'");
            }
        }




        $sql = "SELECT * FROM temp_venta2 where invnum = '$cod'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $cuscodV = $row['cuscod'];
                $brutoV = $row['bruto'];
                $valvenV = $row['valven'];
                $invtotV = $row['invtot'];
                $igvV = $row['igv'];
                $forpagV = $row['forpag'];
                $saldoV = $row['saldo'];
                $cosvtaV = $row['cosvta'];
                $nomclienteV = $row['nomcliente'];
                $gravadoV = $row['gravado'];
                $anotacionV = $row['anotacion'];
                //            nuevo
                $tipdocV = $row['tipdoc'];
                $nrofacturaV = $row['nrofactura'];
                $invfecV = $row['invfec'];
                $correlativoV = $row['correlativo'];

                if ($tipdocV == '2') {
                    //boleta
                    $tipdocV2 = '03';
                    $serie = "B" . $serienotboleta;
                } else {
                    //factura
                    $tipdocV2 = '01';
                    $serie = "F" . $serienotfactura;
                }

                $PrintSerie = $serie . '-' . $NuevoCorrelativo;
                ///////////////////////////////////////////////
                // $codvenV       = $row['codven'];
                // $fecvenV       = $row['fecven'];
                // $val_habilV    = $row['val_habil'];
                // $codtabV       = $row['codtab'];
                // $redondeoV     = $row['redondeo'];
                // $numtarjetV    = $row['numtarjet'];
                // $descflatV     = $row['descflat'];
                // $tipvtaV       = $row['tipvta'];
                // $montextV      = $row['montext'];
                // $ndiasV        = $row['ndias'];
                // $impresoV      = $row['impreso'];
                // $pagaconV      = $row['pagacon'];
                // $vueltoV       = $row['vuelto'];
                // $semanaV       = $row['semana'];
                // $codmedV       = $row['codmed'];
                // $inafectoV     = $row['inafecto'];
                // $anotacionV    = $row['anotacion'];
                // codven,fecven,val_habil,codtab,redondeo,numtarjet,descflat,tipvta,montext,ndias,impreso,pagacon,vuelto,semana,codmed,inafecto,
            }

            mysqli_query($conexion, "INSERT INTO nota( estado,sucursal,usecod,invfec,gravado,nomcliente,cosvta,saldo,forpag,igv,invtot,valven,bruto,nrovent,cuscod,correlativo,nrofactura,hora,tipteclaimpresa,tipdoc,invnumold,anotacion,serie_doc,tipdoc_afec,fecha_old,correlativo_doc,codnc) values ( '0','$codloc','$usuario','$date','$gravadoV','$nomclienteV','$cosvtaV','$saldoV','$forpagV','$igvV','$invtotV','$valvenV','$brutoV','$NuevoCorrelativo','$cuscodV','$NuevoCorrelativo','$PrintSerie','$hora','2','6','$cod','DEVOLUCION DE PRODUCTOS','$nrofacturaV','$tipdocV2','$invfecV','$correlativoV','07')");
            $lastid = mysqli_insert_id($conexion);
            mysqli_query($conexion, "UPDATE movmae set invtot  = '$invtotV', monto = '$invtotV', estado = '1', proceso = '0' ,fecdoc ='$date'  where invnum = '$invnummovmae'");
        }
    }


    $sql = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$invnummovmae'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numdoc = $row['numdoc'];
            $invfec = $row['invfec'];
            $tipmov = $row['tipmov'];
            $tipdoc = $row['tipdoc'];
            $usecod = $row['usecod'];
        }
    }

    $sql = "SELECT invnum,nrovent,invfec,usecod FROM nota where usecod = '$usuario' and sucursal = '$codloc' ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnumMd = $row['invnum'];
            //$numdoc    = $row['nrovent'];
            //$invfec    = $row['invfec'];
            //$usecod    = $row['usecod'];
        }
    }


    $sql = "SELECT codtemp,invnum, invfec, cuscod, usecod, codven, codpro, canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote,resta FROM temp_detalle_venta where invnum = '$cod'  and resta <> 0 ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codtemp = $row['codtemp'];
            $invnum = $row['invnum'];
            $invfec = $row['invfec'];
            $cuscod = $row['cuscod'];
            $usecod = $row['usecod'];
            $codven = $row['codven'];
            $codpro = $row['codpro'];
            $canpro = $row['canpro'];
            $fraccion = $row['fraccion'];
            $factor = $row['factor'];
            $prisal = $row['prisal'];
            $pripro = $row['pripro'];
            $cospro = $row['cospro'];
            $costpr = $row['costpr'];
            $codmar = $row['codmar'];
            $incentivo = $row['incentivo'];
            $bonif = $row['bonif'];
            $ultcos = $row['ultcos'];
            $idlote = $row['idlote'];
            $resta = $row['resta'];

            if ($resta <> "") {
                if ($fraccion == 'F') {
                    $cantidad = $resta * $factor;
                    $cantidad_kardex = $canpro;
                } else {
                    $cantidad = $resta;
                    $cantidad_kardex = 'f' . $canpro;
                }

                $sql1 = "SELECT stopro,$col_stock FROM producto where codpro = '$codpro'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $stopro = $row1['stopro'];
                        $cant_loc = $row1[1];
                    }
                }
                $total_local = $cantidad + $cant_loc;
                $total_general = $cantidad + $stopro;

                mysqli_query($conexion, "UPDATE producto set stopro = '$total_general',$col_stock  = '$total_local' where codpro = '$codpro'");

                mysqli_query($conexion, "UPDATE movlote set stock = '$total_local ' where idlote = '$idlote' and codpro = '$codpro'");

                if ($fraccion == 'T') {
                    mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,fraccion,factor,invnum,usecod,sactual,sucursal) values  ('$numdoc','$codpro','$date','1','3','$cantidad_kardex','$factor','$invnumMd','$usuario','$cant_loc','$codloc')");

                    mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro ,qtypro,qtyprf,pripro,prisal,costre,costpr,tipmov,codloc,devolucion) values ('$invnummovmae','$date','$codpro','0','$cantidad_kardex','$pripro','$prisal','0','$costpr', '$tipmov','$codloc','1')");
                } else {
                    mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$date','1','3','$cantidad_kardex','$factor','$invnumMd','$usuario','$cant_loc','$codloc')");

                    mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro ,qtypro,qtyprf,pripro,prisal,costre,costpr,tipmov,codloc,devolucion) values ('$invnummovmae','$date','$codpro','$cantidad_kardex','0','$pripro','$prisal','0','$costpr', '$tipmov','$codloc','1')");
                }
            }
            mysqli_query($conexion, "INSERT INTO detalle_nota (invnum, invfec, cuscod, usecod, codven, codpro, canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote) values ('$invnumMd ','$invfec','$cuscod','$usuario','$codven','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$cospro','$costpr','$codmar','$incentivo','$bonif','$ultcos','$idlote')");

            // mysqli_query($conexion, "UPDATE detalle_venta set candeve='$resta' where invnum = '$cod' and codpro='$codpro' ");
        }
    }







    mysqli_query($conexion, "DELETE from temp_detalle_venta where invnum = '$cod'");
    mysqli_query($conexion, "DELETE from temp_venta2 where invnum = '$cod'");

    //comentado
    mysqli_query($conexion, "UPDATE venta set activoNotaCredito='$invnumMd' where invnum = '$cod'");




    

    //=============================================================================
    //ENVIO DIRECTO DE FACTURA
    $sqlemisor = "SELECT * FROM emisor limit 1";
    $resultemisor = mysqli_query($conexion, $sqlemisor);
    if (mysqli_num_rows($resultemisor)) {
        $emisor = mysqli_fetch_array($resultemisor);
    }

    if ($emisor['send_creditnote'] == 'automatic') {
        FnGenerateXmlAndSendNc($lastid, $conexion);
    }
 
    //=============================================================================
//header('Location: ../ing_salid.php');
// header("Location: generaImpresion.php?credito=$NuevoCorrelativo");
    header("Location: generaImpresion.php?credito=$invnumMd");
}