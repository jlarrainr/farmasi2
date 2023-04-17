<section>
    <div class="bodyy">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="30%">
                        <div class="title2">
                            <?php if ($logo <> "") { ?>
                                <img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " />
                            <?php } ?>
                        </div>
                    </td>
                    <td width="40%">
                        <div class="title">
                            <p class="text_principal"><?php echo $linea1 ?></p>
                            <p style="text-align: left"><?php echo $linea2 ?></p>
                            <p style="text-align: left"><?php echo $linea3 ?></p>
                            <p style="text-align: left"><?php echo $linea4 ?></p>

                            <?php if ($tipdoc <> 4) { ?>
                                <p style="text-align: left"> <?php echo $linea5 ?> </p>
                            <?php } ?>
                            <p style="text-align: left"><?php echo $linea6 ?></p>
                            <p style="text-align: left"><?php echo $linea7 ?></p>
                            <p style="text-align: left"><?php echo $linea8 ?></p>
                            <p style="text-align: left"><?php echo $linea9 ?></p>
                        </div>
                    </td>
                    <td width="30%">
                        <div class="div_ruc">
                            <?php if ($tipdoc <> 4) { ?>
                                <p> <?php echo $linea5; ?> </p>
                            <?php } ?>
                            <p class="boleta">
                                <?php echo $TextDoc; ?>
                            </p>
                            <!-- <p ><?php echo $serie . '-' . zero_fill($correlativo, 8) . " " . $anulado; ?></p>-->
                            <p> <?php echo $nrofactura . " " . $anulado; ?> </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="data_cliente">
        <table class="table_cabe">
            <tr>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">Nombre:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $descli; ?></font>
                    </p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">Fecha emision:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $invfec; ?></font>
                    </p>
                </th>

            </tr>
            <tr>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">Direcci&oacute;n:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $dircli; ?></font>
                    </p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">Moneda:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo "soles"; ?></font>
                    </p>
                </th>

            </tr>
            <tr>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">RUC:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $ruccli; ?></font>
                    </p>
                </th>

            </tr>
            <tr>

                <th align="left" class="thra1cabe">
                    <p class="letracabe">Usuario:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $nomusu2; ?></font>
                    </p>
                </th>
            </tr>
            
             <tr>

                <th align="left" class="thra1cabe">
                    <p class="letracabe">FORMA DE PAGO:</p>
                </th>
                <th align="left" class="thra1cabe">
                    <p class="letracabe">
                        <font><?php echo $forma; ?></font>
                    </p>
                </th>

    
        </table>
 <?php if($numeroCuota >0){ ?>
 <hr>
<table class="table_T" style="width: 100%">
    <tr>
        <th># CUOTA</th>
        <th>FECHA EMISION</th>
        <th>FECHA VENCIMIENTO</th>
    </tr>
    <?php for ($iCuota = 1; $iCuota <= $numeroCuota; $iCuota++) {
            $nuevosDias = $diasCuotasVentas * $iCuota;
            $date1 =  $invfecS;
            $fechaPago = date("Y-m-d", strtotime($date1 . "+ $nuevosDias days"));
    ?>
    <tr>
        <td style="text-align: center;"><?php echo $iCuota;?></td>
        <td style="text-align: center;"><?php echo $invfecS;?></td>
        <td style="text-align: center;"><?php echo $fechaPago;?></td>
    </tr>
     <?php }?>
</table>
<hr>
 <?php } ?>

    </div>

    <table class="table_2" style="width: 100%;" frame="hsides" rules="groups">

        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="left" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <COLGROUP align="center" height="455px" style="color: #474B56;"></COLGROUP>
        <?php
        $i = 1;

        $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";

        $resultDet = mysqli_query($conexion, $sqlDet);
        if (mysqli_num_rows($resultDet)) {
        ?>
            <thead>
                <tr>
                    <th class="thra" style="width: 20px;">N°</th>
                    <th class="thra" style="width: 40px;">CODIGO</th>
                    <th class="thra" style="width: 40px;">MARCA</th>
                    <th class="thra" style="width: 30px;">CANT.</th>
                    <th class="thra" style="width: 340px;">DESCRIPCION</th>
                    <th class="thra" style="width: 40px;">LOTE</th>
                    <th class="thra" style="width: 40px;">VENCIMIENTO</th>
                    <th class="thra" style="width: 74px;">U.M.</th>
                    <th class="thra" style="width: 67px;">V. UNITA</th>
                    <th class="thra" style="width: 64px;">P. UNITA</th>
                    <th class="thra" style="width: 64px;">VALOR VENTA</th>
                </tr>
            </thead>

            <!-- </table>
                            
                            <TABLE class="table_2x"  style="border: 1px solid #00FF00; width: 100%;"  frame="hsides" rules="groups">-->

            <tbody class="lista_productos">
                <?php
                while ($row = mysqli_fetch_array($resultDet)) {
                    $codpro = $row['codpro'];
                    $canpro = $row['canpro'];
                    $factor = $row['factor'];
                    $prisal = $row['prisal'];
                    $pripro = $row['pripro'];
                    $fraccion = $row['fraccion'];
                    $idlote = $row['idlote'];
                    $factorP = 1;
                    $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro' and eliminado='0'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row1 = mysqli_fetch_array($resultProd)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factorP = $row1['factor'];
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
                       $numlote = "";
                    $vencim = "";
                   $sql1_movlote = "SELECT numlote,vencim FROM movlote where codpro = '$codpro'  and codloc= '$sucursal'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
                            $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                            if (mysqli_num_rows($result1_movlote)) {
                                while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                    $numlote = $row1_movlote['numlote'];
                                    $vencim = $row1_movlote['vencim'];
                                }
                            }
                    
                    $sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                    $resultMarca = mysqli_query($conexion, $sqlMarca);
                    if (mysqli_num_rows($resultMarca)) {
                        while ($row1 = mysqli_fetch_array($resultMarca)) {
                            $ltdgen = $row1['ltdgen'];
                        }
                    }
                    $marca = "";
                    $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                    $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                    if (mysqli_num_rows($resultMarcaDet)) {
                        while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                            $marca = $row1['destab'];
                            $abrev = $row1['abrev'];
                            if ($abrev == '') {
                                $marca = substr($marca, 0, 4);
                            } else {
                                $marca = substr($abrev, 0, 4);
                            }
                        }
                    }
                    $producto = $desprod;
                ?>

                    <tr>
                        <td width="40" align="center">
                            <p><?php echo $i; ?></p>
                        </td>
                        <td width="40" align="center">
                            <p><?php echo $codpro; ?></p>
                        </td>
                        <td width="40" align="center">
                            <p><?php echo $marca; ?></p>
                        </td>
                        <td width="30" align="center">
                            <p><?php echo $cantemp; ?></p>
                        </td>
                        <td width="350">
                            <p><?php echo $producto; ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo $numlote; ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo $vencim; ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo 'UND'; ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo $row2[0]; ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo number_format($prisal, 2, '.', ''); ?></p>
                        </td>
                        <td width="60" align="center">
                            <p><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></p>
                        </td>
                    </tr>

                <?php
                    $i++;
                }
                for ($n = $i; $n <= 20; $n++) {
                    # code...
                ?>
                    <tr>
                        <td width="40px" color="#fffff" align="center">&nbsp;</td>
                        <td width="40px" align="center">&nbsp;</td>
                        <td width="50" align="center">&nbsp;</td>
                        <td width="30">&nbsp;</td>
                        <td width="60" align="center">&nbsp;</td>
                        <td width="30">&nbsp;</td>
                        <td width="30">&nbsp;</td>
                        <td width="60" align="center">&nbsp;</td>
                        <td width="60" align="center">&nbsp;</td>
                        <td width="60">&nbsp;</td>
                    </tr>
            <?php
                }
            }
            //mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
            ?>

            </tbody>
    </table>
    <div class="div_total">
        <p class="letra">Son: <?php echo valorEnLetras($invtot); ?></p>
    </div>

    <div class="div_end">
        <table width="99%">
            <tbody>
                <tr>
                    <td width="33%">
                        <div class="footer_1">
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
                        </div>
                    </td>
                    <td width="33%">
                        <div class="footer_2">
                            <?php
                            if (($tipdoc == 1) || ($tipdoc == 2)) {
                                QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
                                echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" />';
                            }
                            ?>
                        </div>
                    </td>
                    <td width="33%">
                        <div class="footer_3">
                            <table class="table_1">
                                <tbody>
                                    <tr>
                                        <td class="thra1">OP. GRAVADA</td>
                                        <td class="tdra">
                                            <center><?php echo 'S/' . number_format($SumGrabado, 2, '.', ''); ?></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="thra1">OP. INAFECTA</td>
                                        <td class="tdra">
                                            <center><?php echo 'S/' . number_format($SumInafectos, 2, '.', ''); ?></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="thra1">OP. EXONERADA</td>
                                        <td class="tdra">
                                            <center><?php echo 'S/ 0.00' ?></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="thra1">IGV</td>
                                        <td class="tdra">
                                            <center><?php echo 'S/' . $igv; ?></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="thra1">IMPORTE TOTAL(S/)</td>
                                        <td class="tdra">
                                            <center><?php echo $invtot; ?></center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</section>