<section class="section_continuo">
    <div class="div_continuo_1" style="width: 100%">
        <div class="div_continuo_2">
            <table border="0" width="100%">
                <tr>
                    <td class="letra_continuo" width="55px">
                        <p class="letra_continuo">Feha: </p>
                    </td>
                    <td class="letra_continuo">
                        <p class="letra_continuo"> <?php echo $invfec; ?></p>
                    </td>
                    <td class="letra_continuo" width="100px">
                        <p class="letra_continuo">Vendedor: </p>
                    </td>
                    <td class="letra_continuo">
                        <p class="letra_continuo"> <?php echo $nomusu; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="letra_continuo">
                        <p class="letra_continuo">Hora:</p>
                    </td>
                    <td class="letra_continuo">
                        <p class="letra_continuo"> <?php echo substr($hora, 0, 5); ?></p>
                    </td>
                    <td class="letra_continuo">
                        <p class="letra_continuo">Documento:</p>
                    </td>
                    <td class="letra_continuo">
                        <p class="letra_continuo"> <?php echo $nrofactura; ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <table class="table_continuo_1" style="width: 100%;" frame="hsides" rules="groups">

        <COLGROUP align="center" style="color: #0a6fc2"></COLGROUP>
        <COLGROUP align="left" style="color: #0a6fc2;"></COLGROUP>
        <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
        <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
        <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
        <?php
        $i = 1;
        $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
        $resultDet = mysqli_query($conexion, $sqlDet);
        if (mysqli_num_rows($resultDet)) {
        ?>
            <tr>
                <th class="table_continuo_1_th" style="width: 43px;">CANT</th>

                <th class="table_continuo_1_th" style="width: 340px;">DESCRIPTION</th>
                <th class="table_continuo_1_th" style="width: 48px;">LAB.</th>
                <th class="table_continuo_1_th" style="width: 64px;">P. UNITA</th>
                <th class="table_continuo_1_th" style="width: 64px;">P. VENTA</th>
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
                //   while ($row1 = mysqli_fetch_array($resulLote))
                //    {
                //        $numlote    = $row1['numlote'];
                //        $vencim     = $row1['vencim'];
                //    }
                //}
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
                $producto2 = $desprod;
            ?>
                <tr>
                    <td><?php echo $cantemp; ?></td>
                    <td><?php echo $producto2; ?></td>
                    <td><?php echo $marca; ?></td>
                    <td><?php echo number_format($prisal, 2, '.', ''); ?></td>
                    <td><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?> </td>
                </tr>

            <?php
                $i++;
            }
            ?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php
        }
        // mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
        ?>
    </table>
    <table style="width: 90%;">
        <tr>
            <td align="left">
                <p class="letra_continuo">Son: <?php echo valorEnLetras($invtot); ?></p>
            </td>
            <td align="right">
                <p class="letra_continuo">TOTAL: S/ <?php echo $invtot; ?></p>
            </td>
        </tr>
    </table>
</section>