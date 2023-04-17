<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}
$invnum = $_SESSION['compras'];
$cod = $_REQUEST['cod'];
$ok = $_REQUEST['ok'];
$text1 = $_REQUEST['text1']; ///cantidad ingresada
$text2 = $_REQUEST['text2']; ///precio sin descuentos y sin igv
$text3 = $_REQUEST['text3']; ///descuento1
$text4 = $_REQUEST['text4']; ///descuento2
$text5 = $_REQUEST['text5']; ///descuento3
$text6 = $_REQUEST['text6']; ///nuevo precio	
$text7 = $_REQUEST['text7']; ///total por item
$costpr = $_REQUEST['costpr']; ///costo promedio antiguo
$stopro = $_REQUEST['stockpro']; ///stock antiguo
$factor = $_REQUEST['factor']; ///factor
$bonifi = $_REQUEST['bonifi'];
$number = $_REQUEST['number'];
$ckigv = $_REQUEST['ckigv'];
$price = $_REQUEST['price'];  ///precio de costo
$price1 = $_REQUEST['price1'];  ///margen
$price2 = $_REQUEST['price2'];  ///precio venta
$price3 = $_REQUEST['price3'];  ///precio venta unit
$xfactor = $_REQUEST['factor'];
$numero = strtoupper($_REQUEST['countryL']);
$codpro = $_REQUEST['codpro'];
$mes2 = $_REQUEST['mesL'];
$years = $_REQUEST['yearsL'];
$rsanitario = $_REQUEST['rsanitario'];
$digemid = $_REQUEST['digemid'];
$valor='0';
$cuento = strlen($mes2);
if ($cuento == '2') {
    $mes = $mes2;
} else {
    $mes = '0' . $mes2;
}

$vencimiento = $mes . "/" . $years;
/////////////BLISTER
$p3 = $_REQUEST['p3'];
$blister = $_REQUEST['blister'];
///////////stock mini
$codloc = $_REQUEST['codloc'];
$minim = $_REQUEST['minim'];
$marca = $_REQUEST['marca'];
$cr = $_REQUEST['cr'];
$ccr = $_REQUEST['ccr'];
if ($xfactor >= 2) {
} else {
    $price3 = $price2;
    //    echo $price2;
    //    echo $price3;
    //    sleep(1); // Se detiene 2 segundos en continuar la ejecuci�1�70�1�710�1�70�1�771�1�70�1�710�1�70�1�756n
}


$busca_prov = $_REQUEST['busca_prov'];

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";

    $str = preg_replace($legalChars, "", $str);
    return $str;
}

$sql = "SELECT invnum FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum_filtro = $row["invnum"];  //codigo

    }
}

// //echo $invnum_filtro;
if (($invnum_filtro == 0) || ($invnum_filtro == '')) {

    header("Location: compras1.php?ok=5&filtro=1");
} else {
    if ($ckigv == 1) {
        $ConIgv = 1;
    } else {
        $ConIgv = 0;
    }

    /////CONTEO DE CODIGO DE LA TABLA TEMPORAL
    $sql = "SELECT codtemp FROM tempmovmov order by codtemp desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codtemp = $row[0];
        }
        $codtemp = $codtemp + 1;
    } else {
        $codtemp = 1;
    }



    $sql_usuario = "SELECT codloc FROM usuario where usecod = '$usuario'";
    $result_usuario = mysqli_query($conexion, $sql_usuario);
    if (mysqli_num_rows($result_usuario)) {
        while ($row_usuario = mysqli_fetch_array($result_usuario)) {
            $codloc = $row_usuario['codloc'];
        }
    }



    //**CONFIGPRECIOS_PRODUCTO**//
    $nomlocalG = "";
    $sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
    $resultLocal = mysqli_query($conexion, $sqlLocal);
    if (mysqli_num_rows($resultLocal)) {
        while ($rowLocal = mysqli_fetch_array($resultLocal)) {
            $nomlocalG = $rowLocal['nomloc'];
        }
    }


    $numero_xcompa = substr($nomlocalG, 5, 2);
    $tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);



    $sqlP = "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,$tabla FROM producto where codpro='$codpro' ";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {

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
            $stock_local   = $row[21];

            $Stotal = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016 + $s017 + $s018 + $s019 + $s020;
        }
    }

    if ($precios_por_local  == 1) {
        $stopro = $stock_local;
    } else {
        $stopro = $Stotal;
    }


    if ($number == 0) {
        //cajas
      
        $promedio = ((($stopro / $factor) * $costpr) + ($text1 * $text6)) / (($stopro / $factor) + $text1);
    } else {
        
        //unidad
        $text_char = convertir_a_numero($text1);
        $promedio =  ( (($stopro  * $costpr) + ($text_char * ($text6 * $factor )))/ ($stopro  + $text_char));
      /*  $promedio =  ( (((30* 70.80  ) + ((30                    * ($text6*$factor)) / (($stopro  + $text_char )))            ;
        $promedio =  ( (((30                 * 70.80  ) + ((30                    * (1.18 * 60)) / ((30  + 30 )))            ;
        $promedio =  ( (((2124 ) + ((30                    * (70.80)) / ((60 )))            ;
        $promedio =  ( (((2124 ) + ((2124) / ((60 )))            ;
        $promedio =  ( (( 4248 / (60 ))            ;
        */
       /* echo '$text_char = '.$text_char ."<br>";
        echo '$promedio = '.$promedio ."<br>";
        echo '$stopro = '.$stopro ."<br>";
        echo '$factor = '.$factor ."<br>";
        echo '$costpr = '.$costpr ."<br>";
        echo '$text6 = '.$text6 ."<br>";
        */
    }
    

    
    $contador_de_ingreos = 0;
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $contador_de_ingreos = $row[0];  //codigo
        }
        $contador_de_ingreos += 1;
    } else {
        $contador_de_ingreos = 1;
    }

    if ($number == 0) {
        $sql = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' AND codpro = '$cod'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {

            // PARA LOS PRODUCTOS QUE SE REPITEN AL CARGARLO
            if ($bonifi == 1) {

                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','$text1','','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','$text1','','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            } else {

                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','$text1','','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','$text1','','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            }
        } else {

            if ($bonifi == 1) {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','$text1','','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','$text1','','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            } else {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','$text1','','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','$text1','','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            }
        }
    } else {
        $sql = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' AND codpro = '$cod'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            // PARA LOS PRODUCTOS QUE SE REPITEN AL CARGARLO
            if ($bonifi == 1) {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','','$text1','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','','$text1','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            } else {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','','$text1','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','','$text1','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            }
        } else {
            if ($bonifi == 1) {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','','$text1','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,canbon,tipbon,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','','$text1','$text2','1','U','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                 $id_tempmovmov = mysqli_insert_id($conexion);
            } else {
                //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv) values ('$codtemp','$invnum','$cod','','$text1','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv')");
                mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,prisal,desc1,desc2,desc3,pripro,costre,costpr,conigv,numlote,digemid,registrosanitario,orden) values ('$invnum','$cod','','$text1','$text2','$text3','$text4','$text5','$text6','$text7','$promedio','$ConIgv','$numero','$digemid','$rsanitario','$contador_de_ingreos')");
                $id_tempmovmov = mysqli_insert_id($conexion);
                
            }
        }
    }

   if (($numero <> '') && ($numero <> '0') ){
    $sql1 = "SELECT numlote,vencim FROM movlote where numlote = '$numero' and eliminado ='0'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $numlote = $row1['numlote'];
            $vencimi = $row1['vencim'];
        }
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$cod' and numerolote='$numero'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }



            mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi', codtemp ='$codtemp',registrado='$usuario' where invnum = '$invnum' and codpro = '$cod'");
        } else {
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }

            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim,codloc,codtemp,registrado) values ('$invnum','$numlote','$cod','$vencimi','$codloc','$codtemp','$usuario')");
        }
        $valor='1';
       
        ////////////////////////////////////////////////////////////////////////////////////////////////////
    } else {
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote,vencim FROM templote where invnum = '$invnum'   and numerolote='$numero'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $numero = $row2['numerolote'];
                $vencimiento = $row2['vencim'];
            }
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }


           // mysqli_query($conexion, "UPDATE templote set numerolote = '$numero',vencim = '$vencimiento', codtemp ='$codtemp',registrado='$usuario'  where invnum = '$invnum' and codpro = '$cod'");
            mysqli_query($conexion, " DELETE FROM `tempmovmov` WHERE codtemp='$id_tempmovmov' ");
            $valor='2';
        } else {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }

            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro,codloc,codtemp,registrado) values ('$invnum','$numero','$vencimiento','$cod','$codloc','$codtemp','$usuario')");
           $valor='0';
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////

    }
} else {
        $valor = '0';
    }


    if ($precios_por_local == 1) {

        if (($zzcodloc == 1)) {

            mysqli_query($conexion, "UPDATE producto set preblister = '$p3',blister = '$blister' where codpro = '$cod'");
        } else {
            mysqli_query($conexion, "UPDATE precios_por_local set $preblister_p = '$p3',$blister_p = '$blister' where codpro = '$cod'");
        }
    } else {

        mysqli_query($conexion, "UPDATE producto set preblister = '$p3',blister = '$blister' where codpro = '$cod'");
    }
    //////////////////////////////////7/BLISTER////////////////////////////////////////777




    //stockmini


    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nomloc = $row1['nomloc'];
        }
    }
    if ($nomloc == 'LOCAL0') {
        $campo = 'm00';
    }
    if ($nomloc == 'LOCAL1') {
        $campo = 'm01';
    }
    if ($nomloc == 'LOCAL2') {
        $campo = 'm02';
    }
    if ($nomloc == 'LOCAL3') {
        $campo = 'm03';
    }
    if ($nomloc == 'LOCAL4') {
        $campo = 'm04';
    }
    if ($nomloc == 'LOCAL5') {
        $campo = 'm05';
    }
    if ($nomloc == 'LOCAL6') {
        $campo = 'm06';
    }
    if ($nomloc == 'LOCAL7') {
        $campo = 'm07';
    }
    if ($nomloc == 'LOCAL8') {
        $campo = 'm08';
    }
    if ($nomloc == 'LOCAL9') {
        $campo = 'm09';
    }
    if ($nomloc == 'LOCAL10') {
        $campo = 'm10';
    }
    if ($nomloc == 'LOCAL11') {
        $campo = 'm11';
    }
    if ($nomloc == 'LOCAL12') {
        $campo = 'm12';
    }
    if ($nomloc == 'LOCAL13') {
        $campo = 'm13';
    }
    if ($nomloc == 'LOCAL14') {
        $campo = 'm14';
    }
    if ($nomloc == 'LOCAL15') {
        $campo = 'm15';
    }
    if ($nomloc == 'LOCAL16') {
        $campo = 'm16';
    }
    if ($cr <> 17) {
        $cr++;
    } else {
        $cr = 1;
    }
    mysqli_query($conexion, "UPDATE producto set $campo = '$minim' where codpro = '$codpro'");



    $sqlx = "SELECT codpro,factor,costpr,s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020 as stoctal FROM producto where codpro = '$codpro'";
    $resultx = mysqli_query($conexion, $sqlx);
    if (mysqli_num_rows($resultx)) {
        while ($rowx = mysqli_fetch_array($resultx)) {
            $codpro = $rowx['codpro'];
            $stoctal1 = $rowx['stoctal'];
            $factor1 = $rowx['factor'];

            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                $costpr1 = $rowx['costpr'];
            } elseif ($precios_por_local == 0) {
                $costpr1 = $rowx['costpr'];
            }

            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                $sql_precio = "SELECT $tcostpr_p FROM precios_por_local where codpro = '$codpro'";
                $result_precio = mysqli_query($conexion, $sql_precio);
                if (mysqli_num_rows($result_precio)) {
                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                        $costpr1 = $row_precio[0];   //codigo
                    }
                }
            }
        }
    }


    $stoctal = $stoctal1 / $factor1;
    if ($stoctal1 >= 0) {
        
        
        
    /*    
    if ($number == 0) {
        //cajas
        $promedio = ((($stopro / $factor) * $costpr) + ($text1 * $text6)) / (($stopro / $factor) + $text1);
    } else {
        //unidad
        $text_char = convertir_a_numero($text1);
        $promedio =  ( ((($stopro / $factor) * $costpr) + (($text_char * $factor) * $text6)) / (($stopro / $factor) + ($text_char * $factor))) * $factor ;
    }
      */  
    }


    if ($precios_por_local == 1) {

        if (($zzcodloc == 1)) {

            mysqli_query($conexion, "UPDATE producto set tcosto = '$promedio',tmargene = '$price1',tprevta= '$price2', tpreuni = '$price3', tcostpr = '$promedio' where codpro = '$cod'");
        } else {

            mysqli_query($conexion, "UPDATE precios_por_local set $tcosto_p = '$promedio',$tmargene_p = '$price1',$tprevta_p= '$price2', $tpreuni_p = '$price3', $tcostpr_p = '$promedio' where codpro = '$cod'");
        }
    } else {

        mysqli_query($conexion, "UPDATE producto set tcosto = '$promedio',tmargene = '$price1',tprevta= '$price2', tpreuni = '$price3', tcostpr = '$promedio' where codpro = '$cod'");
    }
    //stockmini
 $valor=0;
 
    header("Location: compras1.php?ok=5&ckigv=$ckigv&busca_prov=$busca_prov&valor=$valor");

}
