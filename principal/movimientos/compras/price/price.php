<?php
include('../../../session_user.php');
$invnum  = $_SESSION['compras'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="autocomplete.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../../conexion.php');    //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
    require_once("../../../../funciones/functions.php");    //DESHABILITA TECLAS
    require_once("../../../../funciones/funct_principal.php");    //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../../funciones/botones.php");    //COLORES DE LOS BOTONES

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

    $cod      = $_REQUEST['cod'];
    $costo      = $_REQUEST['costo']; //text2
    $pigv      = $_REQUEST['pigv'];
    $desc1      = $_REQUEST['desc1']; //text3
    $desc2      = $_REQUEST['desc2']; //text4
    $desc3      = $_REQUEST['desc3']; //text5
    $text1      = $_REQUEST['text1']; //text1
    //echo $costo;
    //Si el precio es en base al costo promedio o ultimo costo
    // si es 1 es costo promedio  0=Ultimo costo
    $sqlP = "SELECT porcent,Preciovtacostopro FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $porcent    = $row['porcent'];
            $tipocosto = $row['Preciovtacostopro'];
        }
    }
    // echo $tipocosto;
    // echo $porcent;
    // sleep(3);

    $sql = "SELECT codpro,desprod,factor,margene,prevta,preuni,tcosto,tmargene,tprevta,tpreuni,igv,costpr,tcostpr,costre, s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015 as stoctal FROM producto where codpro = '$cod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro        = $row['codpro'];
            $desprod        = $row['desprod'];
            $factor         = $row['factor'];
            $igv            = $row['igv'];
            $stoctal        = $row['stoctal'];

            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                $prevta         = $row['prevta'];
                $preuni         = $row['preuni'];
                $tcosto         = $row['tcosto'];
                $tmargene       = $row['tmargene'];
                $amargene       = $row['margene'];
                $tprevta        = $row['tprevta'];
                $tpreuni        = $row['tpreuni'];
                $costpr         = $row['costpr'];
                $tcostpr        = $row['tcostpr'];
                $costre        = $row['costre'];
            } elseif ($precios_por_local == 0) {
                $prevta         = $row['prevta'];
                $preuni         = $row['preuni'];
                $tcosto         = $row['tcosto'];
                $tmargene       = $row['tmargene'];
                $amargene       = $row['margene'];
                $tprevta        = $row['tprevta'];
                $tpreuni        = $row['tpreuni'];
                $costpr         = $row['costpr'];
                $tcostpr        = $row['tcostpr'];
                $costre        = $row['costre'];
            }

            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                $sql_precio = "SELECT $prevta_p,$preuni_p,$tcosto_p,$tmargene_p,$margene_p,$tprevta_p,$tpreuni_p,$costpr_p,$tcostpr_p,$costre_p FROM precios_por_local where codpro = '$codpro'";
                $result_precio = mysqli_query($conexion, $sql_precio);
                if (mysqli_num_rows($result_precio)) {
                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                        $prevta         = $row_precio[0];
                        $preuni         = $row_precio[1];
                        $tcosto         = $row_precio[2];
                        $tmargene       = $row_precio[3];
                        $amargene       = $row_precio[4];
                        $tprevta        = $row_precio[5];
                        $tpreuni        = $row_precio[6];
                        $costpr         = $row_precio[7];
                        $tcostpr        = $row_precio[8];
                        $costre         = $row_precio[9];
                    }
                }
            }
        }

        $tmargene2 = 0;

        // Si es en base a costo promedio
        if ($tipocosto == 1) {
            if ($costpr > 0) {
                $margene = round($prevta / $costpr * 100, 2) - 100;
                $margene2 = round($preuni / $costpr / $factor * 100, 2) - 100;
            } else {
                $margene = 5;
                $margene2 = 5;
            }
        }
        // Si es en base a costre, costo de reposicion
        else        
        if ($costre > 0) {
            $margene = round($prevta / $costre * 100, 2) - 100;
            $margene2 = round($preuni / ($costre / $factor) * 100, 2) - 100;
        } else {
            $margene = 5;
            $margene2 = 5;
        }

        // Aqui se hace los precios unitarios?????
        if ($preuni == "" and $factor <> 1) {
            $preuni         = $prevta / $factor;
        }
        // $tpreuni=0 si es la primera vez que se abre esta ventana
        if ($tpreuni <= 0) {
            //Calculo Si tmargene2=0 es base a costo promedio
            if ($tipocosto >= 1) {
                if ($costpr > 0) {
                    $tmargene2 = (($preuni / ($costpr / $factor)) - 1) * 100;
                }
            } else
            // si es en base al costo de compra real
            {
                if ($costre > 0) {
                    $tmargene2 = (($preuni / ($costre / $factor)) - 1) * 100;
                }
            }
        }
    }
    $stoctal = $stoctal / $factor;

    if ($costo <> 0) {
        if ($pigv !== "1" && $igv == 1) {
            $costo    = $costo * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100)) * (1 + ($porcent / 100));
        } else {
            $costo    = $costo * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100));
        }
    }

    //nuevo costo promedio
    echo $costo . " | " . $text1 . " | " . $costpr . " | " . $stoctal;
    $tcostpr  = (($costo * $text1)  + ($costpr * $stoctal)) / ($text1 + $stoctal);
    echo $tcostpr;
    //******** Para cuando calculo es en base a costo promedio **********
    // echo  'costo '.$costo.'cantidad '.$text1.'Costpr'.$costpr.'Stocal '.$stoctal.'Factor '.$factor.'Tcostpr'.$tcostpr;

    if ($tipocosto >= 1) {
        // echo "Costo promedio";
        // sleep(1);
        $tprevta = round($tcostpr * (1 + $tmargene / 100), 2);
        //Productos fraccionados
        if ($factor > 1) {
            if ($tpreuni <= 0) //Para cuando calculo es en base a costo promedio 
            {
                $tpreuni   = round($tcostpr / $factor * (1 + $tmargene2 / 100), 2);
                $tmargene2 = (($tpreuni / ($tcostpr / $factor)) - 1) * 100;
            } else {
                $tmargene2 = (($tpreuni / ($tcostpr / $factor)) - 1) * 100;
            }
        } else
        // Productos no fraccionados
        {
            $tmargene2  = $tmargene;
        }

        ///echo $tcostpr2;

    }
    /// **** Cuando el calculo es sobre el costo de compra ****
    else {
        if ($factor >= 1) {
            $tmargene2  = ((($tpreuni / ($costre / $factor)) - 1)) * 100;
            $tpreuni   = round($costo * (1 + $tmargene2 / 100) / $factor, 2);
            //echo $tpreuni2;
            // sleep(1); // Se detiene 2 segundos en continuar la ejecuci�0�10�0�71�0�10�0�56n
        } else {
            $tmargene2  = $tmargene;
            $tpreuni = $tprevta;
        }
    }
    $costo     = number_format($costo, 2, '.', ' ');
    $tcostpr  = number_format($tcostpr, 2, '.', ' ');
    $tprevta   = number_format($prevta, 2, '.', ' ');
    $tpreuni   = number_format($tpreuni, 3, '.', ' ');
    $tmargene2 = number_format($tmargene2, 2, '.', ' ');
    ?>
    <script>
        function sf() {
            document.form1.price1.focus();
            var f = document.form1;
            var v1 = parseFloat(document.form1.price.value); //precio
            var v2 = parseFloat(document.form1.price1.value); //margen
            var v3 = parseFloat(document.form1.factor.value); //factor
            if (document.form1.price1.value === "") {
                document.form1.price1.value = 0;
                v2 = 0;
            }
            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat(v1 * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            //pventaunit      = parseFloat(pventa / v3);
            //pventaunit      = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 
            f.price2.value = pventa;
            f.price3.value = pventaunit;
        }

        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }

        function validar() {
            var f = document.form1;
            f.method = "post";
            f.action = "price1.php";
            f.submit();
            /*var f = document.form1;
            if (f.price.value == "")
            { alert("DEBE INGRESAR UN PRECIO");f.price.focus(); return;}
            var p = f.price.value;
            var q = f.price1.value;
            var r = f.price2.value;
            var s = f.price3.value;
            var t = f.cod.value;
            //window.close();
            */
        }

        function precio() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.price.value); //precio
            var v2 = parseFloat(document.form1.price1.value); //margen caja
            var v3 = parseFloat(document.form1.factor.value); //factor
            if (document.form1.price1.value === "") {
                document.form1.price1.value = 0;
                v2 = 0;
            }
            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat(v1 * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            //pventaunit = parseFloat(pventa / v3);
            //pventaunit = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 

            f.price2.value = pventa; //precio de venta uni caja
            /////
            //f.price3.value = pventaunit;                  //precio de venta uni
        }

        function precio1() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.price.value); //precio costo
            var v2 = parseFloat(document.form1.price2.value); //precio caja
            var v3 = parseFloat(document.form1.factor.value); //factor
            if (v3 === 0) {
                v3 = 1;
            }
            var rpc = 0;
            rpc = ((v2 - v1) / v1) * 100;
            rpc = Math.round(rpc * Math.pow(10, 2)) / Math.pow(10, 2);
            f.price1.value = rpc;
        }

        function precioUni() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.price.value); //precio
            var v2 = parseFloat(document.form1.priceU.value); //margen unidad
            var v3 = parseFloat(document.form1.factor.value); //factor
            if (document.form1.price1.value === "") {
                document.form1.price1.value = 0;
                v2 = 0;
            }
            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat(v1 * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            pventaunit = parseFloat(pventa / v3);
            pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
            //f.price2.value = pventa;
            // if $factor=1
            // {
            //             pventaunit=$tprevta ;
            // }
            f.price3.value = pventaunit; //precio de venta uni
        }

        function precioUni1() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.price.value); //precio costo
            var v2 = parseFloat(document.form1.price3.value); //precio unidad
            var v3 = parseFloat(document.form1.factor.value); //factor
            if (v3 === 0) {
                v3 = 1;
            }
            var rpu1 = (v1 / v3);
            var rpu = ((v2 - rpu1) / rpu1) * 100;
            rpu = Math.round(rpu * Math.pow(10, 2)) / Math.pow(10, 2);
            f.priceU.value = rpu;
        }
    </script>
    <title><?php echo $desprod ?></title>
    <link href="../../css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        <!--
        .Estilo5 {
            color: #0066CC
        }

        .Estilo6 {
            color: #006699
        }
        -->
    </style>
</head>

<body onload="sf();" onkeyup="cerrar(event)">
    <table width="450" border="0" bgcolor="#FFFF99" class="tabla2">
        <tr>
            <td width="477">
                <table width="444" border="0" align="center" bgcolor="#FFFF99">
                    <tr>
                        <td class="main1_text Estilo6">DESCRIPCION</td>
                        <td><?php echo $desprod ?></td>
                    </tr>
                    <tr>
                        <td width="69" class="main1_text Estilo6">FACTOR</td>
                        <td width="365"><?php echo $factor . "   " . $cod ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <img src="../../../../images/line2.png" width="450" height="4" />
    <form id="form1" name="form1" method="post" action="verifica.php">
        <input type="hidden" name="factor" id="factor" value="<?php echo $factor; ?>" />
        <input name="cod" type="hidden" id="cod" value="<?php echo $cod ?>" />
        <table class="tabla2" width="450" border="0">
            <tr>
                <td width="540">
                    <table width="344" border="0" align="center">
                        <tr>
                            <td><span class="Estilo5">Pre.VENTA ACTUAL: X CAJA</span></td>
                            <td bgcolor="#FFFFCC"><?php echo $prevta; ?></td>
                        </tr>
                        <tr>
                            <td width="122"><span class="Estilo5"> X UND</span></td>
                            <td width="312" bgcolor="#FFFFCC"><?php echo $preuni; ?></td>
                        </tr>
                        <tr>
                            <!---->
                            <?php
                            if ($tipocosto >= 1) {
                            ?>
                                <td><span class="Estilo5"> COSTO PROMEDIO X CAJA : </span></td>
                                <td bgcolor="#FFFFCC">
                                    <input name="price" type="text" id="price" onkeypress="return decimal(event)" onkeyup="precio();" readonly value="<?php if ($tcostpr <> 0) {
                                                                                                                                                            echo $tcostpr;
                                                                                                                                                        } else {
                                                                                                                                                            echo $tcostpr;
                                                                                                                                                        } ?>" />
                                    (Incluido IGV) </td>
                            <?php
                            } else {
                            ?>
                                <td><span class="Estilo5"> COSTO X CAJA : </span></td>
                                <td bgcolor="#FFFFCC">
                                    <input name="price" type="text" id="price" onkeypress="return decimal(event)" onkeyup="precio();" readonly value="<?php if ($costo <> 0) {
                                                                                                                                                            echo $costo;
                                                                                                                                                        } else {
                                                                                                                                                            echo $costo;
                                                                                                                                                        } ?>" />
                                    (Incluido IGV) </td>
                            <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><span class="Estilo5"> % DE UTILIDAD % X CAJA </span></td>
                            <td bgcolor="#FFFFCC">
                                <input name="price1" type="text" id="price1" onkeypress="return decimal(event)" value="<?php if ($tmargene <> 0) {
                                                                                                                            echo $tmargene;
                                                                                                                        } else {
                                                                                                                            echo $margene;
                                                                                                                        } ?>" onkeyup="precio();" /></td>
                        </tr>

                        <?php
                        if ($factor > 1) {
                        ?>
                            <tr>
                                <td><span class="Estilo5"> % X UND </span></td>
                                <td bgcolor="#FFFFCC">
                                    <input name="priceU" type="text" id="priceU" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event)" value="<?php if ($tmargene2 <> 0) {
                                                                                                                                                                                echo $tmargene2;
                                                                                                                                                                            } else {
                                                                                                                                                                                echo $tmargene2;
                                                                                                                                                                            } ?>" onkeyup="precioUni();" /></td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <input type="hidden" name="priceU" id="priceU" value="0" />
                        <?php
                        }
                        ?>
                        <tr>
                            <td><span class="Estilo5"> PRECIO D VENTA: X CAJA </span></td>
                            <td bgcolor="#FFFFCC">
                                <input name="price2" type="text" id="price2" onkeypress="return decimal(event)" value="<?php if ($tprevta <> 0) {
                                                                                                                            echo $tprevta;
                                                                                                                        } ?>" onkeyup="precio1();" /></td>
                        </tr>
                        <?php
                        if ($factor > 1) {
                        ?>
                            <tr>
                                <td><span class="Estilo5"> X UND</span></td>
                                <td bgcolor="#FFFFCC">
                                    <input name="price3" <?php if ($factor == 1) { ?>readonly<?php } ?> type="text" id="price3" onkeypress="return decimal(event)" value="<?php if ($tpreuni <> 0) {
                                                                                                                                                                                echo $tpreuni;
                                                                                                                                                                            } ?>" onkeyup="precioUni1();" />

                                </td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <input type="hidden" name="price3" id="price3" value="<?php echo $tprevta; ?>" />
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td><input type="button" name="Submit" value="Actualizar" onclick="validar();" /> </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
</style>
</head>