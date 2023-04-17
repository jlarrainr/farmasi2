<?php require_once('../../session_user.php');
require_once('../../../conexion.php');
$cod     = $_REQUEST['cod'];     // venta anterior
//$invnumMd = $_REQUEST['invnumMd'];      // venta nueva   
$usuario = $_REQUEST['usuario'];        // usuario
$invnummovmae = $_SESSION['nota_credito'];

//echo $cod."<br>";
//echo $invnumMd."<br>";
//echo $usuario."<br>";

$date = date("Y-m-d");
$hora       = date('H:i:s a');
$sql = "SELECT usecod,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $usecod    = $row['usecod'];
        $codloc    = $row['codloc'];
    }
}
$col_stock = "s".sprintf('%03d', $codloc-1);
$NuevoCorrelativo = 0;
            //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
            $sqlXCOM = "SELECT serienot,numnot FROM xcompa where codloc = '$codloc'";
            $resultXCOM = mysqli_query($conexion, $sqlXCOM);
            if (mysqli_num_rows($resultXCOM)) {
                while ($row = mysqli_fetch_array($resultXCOM)) {
                    $serienot       = $row['serienot'];
                    $numnot         = $row['numnot'];

                        $serie      = "C" . $serienot;
                        $NuevoCorrelativo = $numnot + 1;
                        mysqli_query($conexion, "UPDATE xcompa set numnot = '$NuevoCorrelativo' where codloc = '$codloc'");

                }
                $PrintSerie = $serie . '-' . $NuevoCorrelativo;

 
            
$sql = "SELECT cuscod,bruto,valven,invtot,igv,forpag,saldo,cosvta,nomcliente,gravado,anotacion FROM temp_venta2 where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $cuscodV    = $row['cuscod'];
        $brutoV    = $row['bruto'];
        $valenV    = $row['valven'];
        $invtotV    = $row['invtot'];
        $igvV    = $row['igv'];
        $forpagV    = $row['forpag'];
        $saldoV    = $row['saldo'];
        $cosvtaV    = $row['cosvta'];
        $nomclienteV    = $row['nomcliente'];
        $gravadoV    = $row['gravado'];
        $anotacionV    = $row['anotacion'];
        
         
//                mysqli_query($conexion, "INSERT INTO nota( estado = '0',sucursal ='$codloc',usecod='$usuario',invfec = '$date',gravado = '$gravadoV',nomcliente='$nomclienteV',cosvta='$cosvtaV',saldo='$saldoV',forpag='$forpagV',igv='$igvV',invtot='$invtotV',valven='$valenV',bruto= '$brutoV',nrovent = '$NuevoCorrelativo',cuscod = '$cuscodV' , correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie',hora = '$hora',anotacion = 'ddddddd' where invnum = '$invnumMd'");
                
            }
      
            mysqli_query($conexion, "INSERT INTO nota( estado,sucursal,usecod,invfec,gravado,nomcliente,cosvta,saldo,forpag,igv,invtot,valven,bruto,nrovent,cuscod,correlativo,nrofactura,hora,anotacion) values ( '0','$codloc','$usuario','$date','$gravadoV','$nomclienteV','$cosvtaV','$saldoV','$forpagV','$igvV','$invtotV','$valenV','$brutoV','$NuevoCorrelativo','$cuscodV','$NuevoCorrelativo','$PrintSerie','$hora','ddddddd')");
   
            mysqli_query($conexion,"UPDATE movmae set invtot  = '$invtotV', monto = '$invtotV', estado = '1', proceso = '0' where invnum = '$invnummovmae'");
            
    }
}

//$sql = "SELECT tipdoc FROM venta where invnum = '$invnumMd'";
//$result = mysqli_query($conexion, $sql);
//if (mysqli_num_rows($result)) {
//    while ($row = mysqli_fetch_array($result)) {
//        $tipdocV    = $row['tipdoc'];
//    }
//}
//if ($tipdocV == 5) { 

            
      
//}
//echo $serie."<BR>";
//echo $NuevoCorrelativo."<BR>";
//echo $PrintSerie."<BR>";
//echo $hora."<BR>";
//echo $date."<BR>";

$sql="SELECT invnum,nrovent,invfec,usecod FROM nota where usecod = '$usuario' and sucursal = '$codloc' ";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$invnumMd    = $row['invnum'];
    	$numdoc    = $row['nrovent'];
	$invfec    = $row['invfec'];
	$usecod    = $row['usecod'];
        
}
}


$sql = "SELECT codtemp,invnum, invfec, cuscod, usecod, codven, codpro, canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote, item,resta FROM temp_detalle_venta where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codtemp        = $row['codtemp'];
        $invnum        = $row['invnum'];
        $invfec        = $row['invfec'];
        $cuscod        = $row['cuscod'];
        $usecod        = $row['usecod'];
        $codven        = $row['codven'];
        $codpro        = $row['codpro'];
        $canpro        = $row['canpro'];
        $fraccion      = $row['fraccion'];
        $factor        = $row['factor'];
        $prisal        = $row['prisal'];
        $pripro        = $row['pripro'];
        $cospro        = $row['cospro'];
        $costpr        = $row['costpr'];
        $codmar        = $row['codmar'];
        $incentivo     = $row['incentivo'];
        $bonif         = $row['bonif'];
        $ultcos        = $row['ultcos'];
        $idlote        = $row['idlote'];
        $item        = $row['item'];
        $resta         = $row['resta'];
        if($resta <> ""){
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
                $stopro    = $row1['stopro'];
                $cant_loc  = $row1[1];
            }
        }
        $total_local = $cantidad + $cant_loc;
        $total_general = $cantidad + $stopro;

        mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', $col_stock = '$total_local' where codpro = '$codpro'");
        

        if ($fraccion == 'T') {
            mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,fraccion,factor,invnum,usecod,sactual,sucursal) values "
                    . "                                     ('$numdoc','$codpro','$date','6','6','$cantidad_kardex','$factor','$invnumMd','$usuario','$cant_loc','$codloc')");
        
           mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro ,qtypro,qtyprf,pripro,prisal,costre,costpr,tipmov) values "
                                                    . "('$invnummovmae','$date','$codpro','0','$cantidad_kardex','$pripro','$prisal','0','$costpr', '$tipmov')");
        
        } else {
            mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$date','6','6','$cantidad_kardex','$factor','$invnumMd','$usuario','$cant_loc','$codloc')");
       
             mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro ,qtypro,qtyprf,pripro,prisal,costre,costpr,tipmov) values "
                                                    . "('$invnummovmae','$date','$codpro','$cantidad_kardex','0','$pripro','$prisal','0','$costpr', '$tipmov')");
        
            
            }
}
        mysqli_query($conexion, "INSERT INTO detalle_nota (invnum, invfec, cuscod, usecod, codven, codpro, canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote, item) values ('$invnumMd ','$invfec','$cuscod','$usuario','$codven','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$cospro','$costpr','$codmar','$incentivo','$bonif','$ultcos','$idlote','$item')");
        
        
         mysqli_query($conexion, "UPDATE detalle_venta set candeve='$resta' where invnum = '$cod' and codpro='$codpro' ");
        } 
}




mysqli_query($conexion, "DELETE from temp_detalle_venta where invnum = '$cod'");
mysqli_query($conexion, "DELETE from temp_venta2 where invnum = '$cod'");

//comentado
mysqli_query($conexion, "UPDATE venta set val_habil='1' where invnum = '$cod'");

//header('Location: ../ing_salid.php');
header("Location: generaImpresion.php?credito=$NuevoCorrelativo");
