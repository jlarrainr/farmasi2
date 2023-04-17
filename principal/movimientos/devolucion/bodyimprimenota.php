<form name="form1" id="form1" style="width: 100%">
    <table class="table_T" align="center" style="width: 100%; border: 1px ;">
        <?php if ($logo <> "") { ?>
            <tr>
                <td style="text-align: center; width:30%;"><img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " /></td> 
            </tr>
        <?php } ?>
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
            <td>FECHA:</td>
            <td><?php echo $invfec; ?></td>
        </tr>
        <tr>
            <td> HORA:</td>
            <td><?php echo substr($hora, 0, 5); ?></td>
        </tr>
        <tr>
            <td>VENDEDOR:</td>
            <td><?php echo $nomusu; ?></td>
        </tr>
        <?php if ($anotacion <> "") { ?>
            <tr>
                <td >MOTIVO:</td>
                <td><strong><?php echo $anotacion; ?></strong></td>
            </tr>
        <?php } ?>
        <tr>
            <td>DOC AFECTADO:</td>
            <td><?php echo $cod_doc . "- FECHA :" . $fecha_old; ?></td>
        </tr>

        <tr>
            <td>CLIENTE:</td>
            <td><?php echo $descli; ?></td>
        </tr>
        <?php
        if (($ruccli <> "") and ( $tipdoc == 1)) {
            ?>
            <tr>
                <td>RUC:</td>
                <td><?php echo $ruccli; ?></td>
            </tr>
            <?php
        }
        if (strlen($dircli) > 0) {
            ?>
            <tr>
                <td>DIRECCI&Oacute;N:</td>
                <td><?php echo $dircli; ?></td>
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
            <td style="font-size: 12px;" colspan="5">
        <center><b><?php echo $TextDoc; ?> - <?php echo $nrofactura; ?></b></center>
        </td>
        </tr>
    </table>
    <!-- <hr>-->
    <table class="table_T" style="width: 100%">
        <?php
        $i = 1;
        $sqlDet = "SELECT * FROM detalle_nota where invnum = '$credito' ";
        $resultDet = mysqli_query($conexion, $sqlDet);
        if (mysqli_num_rows($resultDet)) {
            ?>
            <tr>
                <th style="text-align: left; width:4%;">Cant</th>
                <th style="width:70%;">Descripcion</th>
                <th style="width:7%;">Marca</th>
                <th style="text-align: right; width:9.5%;">P.UNit</th>
                <th style="text-align: right; width:9.5%;">S.Total</th>
                <!--<th style="width:10%;">LOTE</th>
                <th style="text-align: right; width:7.5%;">P. unit</th>
                <th style="text-align: right; width:7.5%;">SUB TOTAL</th>-->
            </tr>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
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
                $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
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
                $numlote = "......";
                $vencim = "";
                $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                $resulLote = mysqli_query($conexion, $sqlLote);
                // if (mysqli_num_rows($resulLote))
                //{
                //    while ($row1 = mysqli_fetch_array($resulLote))
                //    {
                //        $numlote    = $row1['numlote'];
                //       $vencim     = $row1['vencim'];
                //    }
                // }
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
                    <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal, 2, '.', ''); ?></td>
                    <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></td>
                    <!--<td><?php echo $numlote; ?></td>-->
                </tr>
                <tr>
                    <td colspan="5"></td>
                </tr>
            </table>

            <table class="table_T" style="width: 100%">
                <?php
                $i++;
            }
        }
// mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$credito'");
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
        echo pintaDatos('N. I. -' . $credito);
        ?>
    </table>
    <center>
        <?php
//  if (($tipdoc == 1) || ($tipdoc == 2)) {
        QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
        echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" /><hr/>';
//   }
        ?>
    </center>
</form>