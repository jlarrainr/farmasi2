<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('../ventas/MontosText.php');
?>

<form name="form1" id="form1" style="width: 100%">


    <?php
    $sqlUsu = "SELECT formadeimpresion FROM datagen";
    $resultUsu = mysqli_query($conexion, $sqlUsu);
    if (mysqli_num_rows($resultUsu)) {
        while ($row = mysqli_fetch_array($resultUsu)) {
            $formadeimpresion      = $row['formadeimpresion'];
        }
    }

    if (($formadeimpresion == '1') && ($tipdoc <> 4)) {

    ?>
        <section>


            <div class="bodyy" style="width: 100%">
                <div class="title" style="text-align: left">
                    <p><?php echo pintaDatos($linea1); ?></p>
                    <p><?php echo pintaDatos($linea2); ?></p>
                    <p><?php echo pintaDatos($linea3); ?></p>
                    <p><?php echo pintaDatos($linea4); ?></p>
                    <?php if ($tipdoc <> 4) { ?>
                        <p> <?php echo pintaDatos($linea5); ?> </p>
                    <?php } ?>
                    <p><?php echo pintaDatos($linea6); ?></p>
                    <p><?php echo pintaDatos($linea7); ?></p>
                    <p><?php echo pintaDatos($linea8); ?></p>
                    <p><?php echo pintaDatos($linea9); ?></p>
                </div>

                <div class="title2">
                    <img src="logo.jpg">

                </div>

                <div class="div_ruc">

                    <?php
                    if (($ruccli <> "") and ($tipdoc == 1)) {
                    ?>
                        <p>RUC: <?php echo $ruccli; ?></p>

                    <?php
                    }
                    ?>
                    <p class="boleta" style="font-weight: 1990; ">
                        <font color="#0a6fc2" style="font-weight: 1990; "><?php echo $TextDoc; ?></font>
                    </p>
                    <p><?php echo $serie . '-' . zero_fill($correlativo, 8); ?></p>
                </div>
            </div>




            <div class="title_div" style="width: 100%">
                <div class="data_cliente">
                    <p class="letra">Cliente &nbsp;&nbsp;&nbsp;: <?php echo $descli; ?></p>
                    <?php if (strlen($dircli) > 0) { ?>
                        <p class="letra">Direcci&oacute;n : <?php echo $dircli; ?></p>
                    <?php  } ?>

                    <p class="letra">DNI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<?php echo  $dnicli; ?></p>

                    <?php if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL")) { ?>
                        <p class="letra">PUNTOS ACUMULADOS HASTA LA FECHA : <?php echo $pstcli; ?></p>
                    <?php } ?>
                </div>


                <div class="data_cliente2">
                    <p class="letra">Feha de emisi&oacute;n: <?php echo $invfec; ?></p>
                    <br>
                    <p class="letra">Hora: <?php echo substr($hora, 0, 5); ?></p>
                </div>
            </div>




            <table class="table_1">
                <tr>
                    <th class="thra">VENDEDOR</th>
                    <th class="thra">COND. PAGO</th>
                    <th class="thra">FECHA DE VENCIMIENTO</th>
                    <th class="thra">GUIA DE REMISION</th>
                    <th class="thra">NRO ORDEN DE VENTA</th>
                </tr>
                <tr>
                    <td class="tdra"><?php echo $nomusu; ?></td>
                    <td class="tdra" align="center"><?php echo $forma; ?></td>
                    <td class="tdra">&nbsp;</td>
                    <td class="tdra">&nbsp;</td>
                    <td class="tdra" align="center"><?php echo zero_fill($correlativo, 8); ?></td>
                </tr>
            </table>

            <table class="table_2" style="width: 100%;" frame="hsides" rules="groups">

                <COLGROUP align="center" style="color: #0a6fc2"></COLGROUP>
                <COLGROUP align="left" style="color: #0a6fc2;"></COLGROUP>
                <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
                <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
                <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
                <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
                <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
                <?php
                $i  = 1;
                $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
                $resultDet = mysqli_query($conexion, $sqlDet);
                if (mysqli_num_rows($resultDet)) {
                ?>
                    <tr>
                        <th class="thra" style="width: 43px;">CANT</th>
                        <th class="thra" style="width: 48px;">LAB.</th>
                        <th class="thra" style="width: 340px;">DESCRIPTION</th>
                        <th class="thra" style="width: 74px;">LOTE</th>
                        <th class="thra" style="width: 67px;">FECH VCTO.</th>
                        <th class="thra" style="width: 64px;">P. UNITA</th>
                        <th class="thra" style="width: 64px;">P. VENTA</th>
                    </tr>
                    <!-- </table>
           
           <TABLE class="table_2x"  style="border: 1px solid #00FF00; width: 100%;"  frame="hsides" rules="groups">-->


                    <?php
                    while ($row = mysqli_fetch_array($resultDet)) {
                        $codpro       = $row['codpro'];
                        $canpro       = $row['canpro'];
                        $factor       = $row['factor'];
                        $prisal       = $row['prisal'];
                        $pripro       = $row['pripro'];
                        $fraccion     = $row['fraccion'];
                        $idlote       = $row['idlote'];
                        $factorP = 1;
                        $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                        $resultProd = mysqli_query($conexion, $sqlProd);
                        if (mysqli_num_rows($resultProd)) {
                            while ($row1 = mysqli_fetch_array($resultProd)) {
                                $desprod    = $row1['desprod'];
                                $codmar     = $row1['codmar'];
                                $factorP    = $row1['factor'];
                            }
                        }
                        if ($fraccion == "F") {
                            $cantemp = "C" . $canpro;
                        } else {
                            if ($factorP == 1) {
                                $cantemp = $canpro;
                            } else {
                                $cantemp = "F" . $canpro;
                            }
                        }
                        $Cantidad = $canpro;
                        $numlote = "......";
                        $vencim  = "";
                        $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                        $resulLote = mysqli_query($conexion, $sqlLote);
                         if (mysqli_num_rows($resulLote))
                        {
                           while ($row1 = mysqli_fetch_array($resulLote))
                            {
                                $numlote    = $row1['numlote'];
                                $vencim     = $row1['vencim'];
                            }
                        }
                        $sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                        $resultMarca = mysqli_query($conexion, $sqlMarca);
                        if (mysqli_num_rows($resultMarca)) {
                            while ($row1 = mysqli_fetch_array($resultMarca)) {
                                $ltdgen     = $row1['ltdgen'];
                            }
                        }
                        $marca = "";
                        $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                        $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                        if (mysqli_num_rows($resultMarcaDet)) {
                            while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                $marca     = $row1['destab'];
                                $abrev     = $row1['abrev'];
                                if ($abrev == '') {
                                    $marca = substr($marca, 0, 4);
                                } else {
                                    $marca = substr($abrev, 0, 4);
                                }
                            }
                        }
                        $producto2 = $desprod;
                        // if (strlen($numlote) > 0) 
                        // {
                        //    $producto = $desprod. " Lote: " . $numlote ;
                        //    if (strlen($vencim)>0)
                        //    {
                        //        $producto = $producto. " (".$vencim.")";
                        //    }
                        // } 
                        // else 
                        // {
                        //   $producto = $desprod;
                        // }
                    ?>



                        <TR>
                            <TD width="40px">
                                <pre><?php echo $cantemp; ?></PRE>
                            <TD width="50"><?php echo $marca; ?>
                            <TD width="350"><?php echo $producto2; ?>
                            <TD width="60"><?php echo $numlote; ?>
                            <TD width="60"><?php echo $vencim; ?>
                            <TD width="60"><?php echo number_format($prisal, 2, '.', ''); ?>
                            <TD width="60"><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?>

                        </TR>












                <?php
                        $i++;
                    }
                }
                mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
                ?>
            </table>
            <table>
                <div class="div_end">
                    <div class="f1">
                        <p class="letra">Son: <?php echo valorEnLetras($invtot); ?></p>
                        <p class="letra">NETO: <?php echo number_format($SumGrabado, 2, '.', ''); ?></p>
                    </div>
                    <div class="f2">
                        <br>
                        <p class="letra">INFACTO: <?php echo number_format($SumInafectos, 2, '.', ''); ?></p>
                    </div>
                    <div class="f3">
                        <br>
                        <p class="letra">IGV:<?php echo ($igv); ?></p>
                    </div>
                    <div class="f4">
                        <br>
                        <p class="letra">TOTAL: S/ <?php echo $invtot; ?></p>
                    </div>
                </div>
            </table>
            <table>
                <div class="money">
                    <p class="letra2">PAG&Oacute; con S/. <?php echo $pagacon; ?></p>
                    <p class="letra2">VUELTO S/. <?php echo $vuelto; ?> </p>
                </div>
            </table>

        </section>
    <?php } else {

        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////


    ?>
        <table class="table_T" align="center" style="width: 100%; border: 1px ;">
            <tr>
                <!-- <td style="text-align: center; width:30%;"><img src="logo.jpg"></td> -->
            </tr>
            <tr>
                <td style="width:30%;">
                    <?php

                    echo pintaDatos($linea1);
                    echo pintaDatos($linea2);
                    echo pintaDatos($linea3);
                    echo pintaDatos($linea4);
                    if ($tipdoc <> 4) {
                        echo pintaDatos($linea5);
                    }
                    echo pintaDatos($linea6);
                    echo pintaDatos($linea7);
                    echo pintaDatos($linea8);
                    echo pintaDatos($linea9);
                    ?>

                </td>
            </tr>
        </table>
        <table class="table_T" style="width: 100%">
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="5">FECHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $invfec; ?></td>
            </tr>
            <tr>
                <td colspan="5"> HORA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo substr($hora, 0, 5); ?></td>
            </tr>
            <tr>
                <td colspan="5">VENDEDOR&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $nomusu; ?></td>
            </tr>
            <?php if ($anotacion <> "") { ?>
                <tr>
                    <td colspan="5">OBS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<strong><?php echo $anotacion; ?></strong></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="5">CLIENTE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $descli; ?></td>
            </tr>
            <?php
            if (($ruccli <> "") and ($tipdoc == 1)) {
            ?>
                <tr>
                    <td colspan="5">RUC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $ruccli; ?></td>
                </tr>
            <?php
            }
            if (strlen($dircli) > 0) {
            ?>
                <tr>
                    <td colspan="5">DIRECCI&Oacute;N&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $dircli; ?></td>
                </tr>


            <?php
            }
            if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL")) {
            ?>
                <tr>
                    <td>PUNTOS ACUMULADOS HASTA LA FECHA : <?php echo $pstcli; ?></td>
                </tr>
            <?php

            }
            ?>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="font-size: 12px;">
                    <center><b><?php echo $TextDoc; ?> - <?php echo $nrofactura; ?></b></center>
                </td>
            </tr>
        </table>
        <!-- <hr>-->
        <table class="table_T" style="width: 100%">
            <?php
            $i  = 1;
            $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
            $resultDet = mysqli_query($conexion, $sqlDet);
            if (mysqli_num_rows($resultDet)) {
            ?>
                <tr>
                    <th style="text-align: left; width:4%;">Cant</th>
                    <th >Descripcion</th>
                    <th >Marca</th>
                    <th >lote</th>
                    <th >venci</th>
                    <th style="text-align: right; width:9.5%;">P.UNit</th>
                    <th style="text-align: right; width:9.5%;">S.Total</th>
                    <!--<th style="width:10%;">LOTE</th>
                <th style="text-align: right; width:7.5%;">P. unit</th>
                <th style="text-align: right; width:7.5%;">SUB TOTAL</th>-->
                </tr>
                <tr>
                    <td colspan="7">
                        <hr>
                    </td>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($resultDet)) {
                    $codpro       = $row['codpro'];
                    $canpro       = $row['canpro'];
                    $factor       = $row['factor'];
                    $prisal       = $row['prisal'];
                    $pripro       = $row['pripro'];
                    $fraccion     = $row['fraccion'];
                    $idlote       = $row['idlote'];
                    $factorP = 1;
                    $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row1 = mysqli_fetch_array($resultProd)) {
                            $desprod    = $row1['desprod'];
                            $codmar     = $row1['codmar'];
                            $factorP    = $row1['factor'];
                        }
                    }
                    if ($fraccion == "F") {
                        $cantemp = "C" . $canpro;
                    } else {
                        if ($factorP == 1) {
                            $cantemp = $canpro;
                        } else {
                            $cantemp = "F" . $canpro;
                        }
                    }
                    $Cantidad = $canpro;
                    $numlote = "......";
                    $vencim  = "";
                    $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                    $resulLote = mysqli_query($conexion, $sqlLote);
                     if (mysqli_num_rows($resulLote))
                    {
                        while ($row1 = mysqli_fetch_array($resulLote))
                        {
                            $numlote    = $row1['numlote'];
                           $vencim     = $row1['vencim'];
                        }
                     }
                    $sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                    $resultMarca = mysqli_query($conexion, $sqlMarca);
                    if (mysqli_num_rows($resultMarca)) {
                        while ($row1 = mysqli_fetch_array($resultMarca)) {
                            $ltdgen     = $row1['ltdgen'];
                        }
                    }
                    $marca = "";
                    $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                    $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                    if (mysqli_num_rows($resultMarcaDet)) {
                        while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                            $marca     = $row1['destab'];
                            $abrev     = $row1['abrev'];
                            if ($abrev == '') {
                                $marca = substr($marca, 0, 4);
                            } else {
                                $marca = substr($abrev, 0, 4);
                            }
                        }
                    }
                    $producto = $desprod;
                    // if (strlen($numlote) > 0) 
                    // {
                    //    $producto = $desprod. " Lote: " . $numlote ;
                    //    if (strlen($vencim)>0)
                    //    {
                    //        $producto = $producto. " (".$vencim.")";
                    //    }
                    // } 
                    // else 
                    // {
                    //   $producto = $desprod;
                    // }
                ?>
                    <tr>
                        <td style="text-align: left; width:4%;"><?php echo $cantemp; ?></td>
                        <td style="width:70%;"><?php echo $producto; ?></td>
                        <td style="width:7%;"><?php echo $marca; ?></td>
                        <td><?php echo $numlote; ?></td>
                        <td ><?php echo $vencim; ?></td>
                        <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal, 2, '.', ''); ?></td>
                        <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></td>
                        <!--<td><?php echo $numlote; ?></td>-->
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
        </table>

        <table class="table_T" style="width: 100%">
    <?php
                    $i++;
                }
            }
            mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
    ?>
    <tr>
        <td colspan="5">
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right;"><b>GRAVADA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo number_format($SumGrabado, 2, '.', ''); ?></b></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right;"><b>INAFECTO: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<?php echo number_format($SumInafectos, 2, '.', ''); ?></b></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right;"><b>IGV:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo ($igv); ?></b></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: right;font-size: 12px;"><b>TOTAL:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;S/ <?php echo $invtot; ?></b></td>
    </tr>
    <?php if ($pagacon <> "") { ?>
        <tr>
            <td colspan="5" style="text-align: left;font-size: 10px;">SON: <?php echo valorEnLetras($invtot); ?></td>
        </tr>
        <tr>
            <td colspan="5"><b>PAG&Oacute; con:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $pagacon; ?></b></td>
        </tr>
        <tr>
            <td colspan="5"><b>VUELTO:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $vuelto; ?></b></td>
        </tr>
    <?php } ?>
        </table>
        <table class="table_T" style="width: 100%">
            <?php
            echo pintaDatos($pie1);
            echo pintaDatos($pie2);
            echo pintaDatos($pie3);
            echo pintaDatos($pie4);
            echo pintaDatos($pie5);
            echo pintaDatos($pie6);
            echo pintaDatos($pie7);
            echo pintaDatos($pie8);
            echo pintaDatos($pie9);
            echo pintaDatos('N. I. -' . $venta);
            ?>
        </table>
        <center>
            <?php
            if (($tipdoc == 1) || ($tipdoc == 2)) {
                QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
                echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" /><hr/>';
            }
            ?>
        </center>
    <?php } ?>
</form>