<style>
    .table_2 {
        width: 100%;
        border-collapse: collapse;
        border: none;
    }

    .table_2 th {
        font-size: 14px;
        background: black;
        color: white;
    }

    .table_2 th:first-child {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(2) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(3) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(4) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:first-child {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(2) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(3) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(4) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(5) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(6) {
        background: black;
        color: white;
        font-size: 1em;
    }

    .table_2 th:nth-child(7) {
        background: black;
        color: white;
        font-size: 1em;
    }
    .table_2 th:nth-child(8) {
        background: black;
        color: white;
        font-size: 1em;
    }
    .table_2 th:nth-child(9) {
        background: black;
        color: white;
        font-size: 1em;
    }.table_2 th:nth-child(10) {
        background: black;
        color: white;
        font-size: 1em;
    }.table_2 th:nth-child(11) {
        background: black;
        color: white;
        font-size: 1em;
    }
</style>
<form name="form1" id="form1" style="width: 100%">
    <?php
    $sql_ver_costo = "SELECT ver_costo FROM datagen ";
    $result_ver_costo = mysqli_query($conexion, $sql_ver_costo);
    if (mysqli_num_rows($result_ver_costo)) {
        while ($row = mysqli_fetch_array($result_ver_costo)) {
            $ver_costo = $row[0];
        }
    }

    function fecha($fechadata)
    {
        $fecha = explode("-", $fechadata);
        $dia = $fecha[2];
        $mes = $fecha[1];
        $year = $fecha[0];
        $fecharesult = $dia . '/' . $mes . '/' . $year;
        return $fecharesult;
    }

    $HoraActuala = DATE("H:i");
    if ($HoraActuala <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
    $HoraActual = $HoraActuala . ' ' . $hor;
    $usuario = "";
    $Sucursal = "";
    $Proveedor = "";
    $sqlCompras = "SELECT * FROM movmae where invnum = '$CCompra'";
    $resultCompras = mysqli_query($conexion, $sqlCompras);
    if (mysqli_num_rows($resultCompras)) {
        while ($row = mysqli_fetch_array($resultCompras)) {
            $invnum = $row['invnum'];
            $invnumrecib = $row['invnumrecib'];
            $nro_compra = $row['nro_compra'];
            $invfec = $row['invfec'];
            $hora = $row['hora'];
            $usecod = $row['usecod'];   //usuario
            $cuscod = $row['cuscod'];  //proveedor
            $numdoc = $row['numdoc'];
            $numdocD1 = $row['numero_documento'];
            $numdocD2 = $row['numero_documento1'];
            $fecdoc = $row['fecdoc'];
            $plazo = $row['plazo'];
            $forpag = $row['forpag'];
            $invtot = $row['invtot'];
            $destot = $row['destot'];
            $valven = $row['valven'];
            $tipmov = $row['tipmov'];
            $tipdoc = $row['tipdoc'];
            $referencia = $row['refere'];
            $fecven = $row['fecven'];
            $monto = $row['monto'];
            $hora = $row['hora'];
            $saldo = $row['saldo'];
            $moneda = $row['moneda'];
            $suspendido = $row['suspendido'];
            $costo = $row['costo'];
            $igv = $row['igv'];
            $codanu = $row['codanu'];
            $codrec = $row['codrec'];
            $orden = $row['orden'];
            $sucursal = $row['sucursal'];   //sucursal origen
            $sucursal1 = $row['sucursal1']; //sucursal destino
            $incluidoIGV = $row['incluidoIGV'];
            $dafecto = $row['dafecto'];
            $dinafecto = $row['dinafecto'];
            $digv = $row['digv'];
            $dtotal = $row['dtotal'];

            if ($incluidoIGV == 1) {
                $incluidoIGV = "SI";
            } else {
                $incluidoIGV = "NO";
            }
            
            if($hora == '0000-00-00 00:00:00'){
                $horaMostarr=$HoraActual;
            }else{
                 $hora1 = date("g:i a", strtotime($hora));
                $horaMostarr=$hora1;
            }
            $forpagTexto='';
if($forpag =='F'){
    $forpagTexto="Factura";
}elseif($forpag =='B'){
     $forpagTexto="Boleta";
}elseif($forpag =='G'){
     $forpagTexto="Guia";
}elseif($forpag =='O'){
     $forpagTexto="Otros";
}
            
            $sqlUsu = "SELECT nomusu FROM usuario where usecod = '$usecod'";
            $resultUsu = mysqli_query($conexion, $sqlUsu);
            if (mysqli_num_rows($resultUsu)) {
                while ($row = mysqli_fetch_array($resultUsu)) {
                    $usuario = $row['nomusu'];
                }
            }
            $sqlProv = "SELECT despro FROM proveedor where codpro = '$cuscod'";
            $resultProv = mysqli_query($conexion, $sqlProv);
            if (mysqli_num_rows($resultProv)) {
                while ($row = mysqli_fetch_array($resultProv)) {
                    $Proveedor = $row['despro'];
                }
            }
            $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal1'";
            $resultSuc = mysqli_query($conexion, $sqlSuc);
            if (mysqli_num_rows($resultSuc)) {
                while ($row = mysqli_fetch_array($resultSuc)) {
                    $sucursal_destino = $row['nombre'];
                }
            }
            $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal'";
            $resultSuc = mysqli_query($conexion, $sqlSuc);
            if (mysqli_num_rows($resultSuc)) {
                while ($row = mysqli_fetch_array($resultSuc)) {
                    $Sucursal = $row['nombre'];
                }
            }
        }
        
        if (($tipmov == 1) && ($tipdoc == 1)) {
            $activoCompras='1';

           
             
        }
    ?>
        <table style="width: 100%" border="0">
            <tr>
                <td style="text-align: center;width:100%;" colspan="2"><b> <?php echo $desemp; ?></b></td>
            </tr>
            <tr>
                
                <td style="text-align: left;width:50%;"><b>N&ordm; Interno : </b><?php echo $invnum; ?> </td> 
                <td style="text-align: left;width:50%;"><b>Tipo M. - </b><?php if (($tipmov == 2) && ($tipdoc == 6)) {echo $tipo_documento1; } else { echo $tipo_documento;}?></td>

            </tr>
            <tr>

                <td style="text-align: left;width:50%;"><b>N&ordm; Ope : </b><?php echo $numdoc; ?></td>
                <td style="text-align: left;width:50%;"><b>Fecha-Hora : </b><?php echo fecha($invfec) . ' - ' . $horaMostarr; ?></td>
            </tr>
            <tr>
                <td style="text-align: left;width:50%;"><b>Usu : </b><?php echo $usuario; ?></td>
                <td style="text-align: left;width:50%;"><b>Local : </b><?php echo $Sucursal; ?></td>
            </tr>


            <?php if ($referencia <> "") { ?>
                <tr>
                    <td style="text-align: left;width:100%;" colspan="2"><b>Referencia : </b><?php echo $referencia; ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td style="text-align: left;width:50%;"><b>Monto :</b><?php echo $invtot; ?></td>

                <td style="text-align: left;width:50%;"> <?php if ($sucursal1 <> 0) { ?><b>Local Des : </b><?php echo $sucursal_destino; ?> <?php } ?></td>

            </tr>
            <?php if (($tipmov == 1) && ($tipdoc == 1)) { ?>
                <tr>
                    <td style="text-align: left;width:50%;"><b>Proveedor : </b><?php echo $Proveedor; ?></td>
                    <td style="text-align: left;width:50%;"><b>N&ordm; Doct : </b><?php echo $numdocD1 . '-' . $numdocD2; ?> </td>
                </tr>

                <tr>
                    <td style="text-align: left;width:50%;"><b>Forma. Pag : </b><?php echo $forpagTexto; ?></td>
                    <td style="text-align: left;width:50%;"><b>Incluido IGV : </b> <?php echo $incluidoIGV; ?></td>
                </tr>
                <?php if ($plazo > 0) { ?>
                    <tr>
                        <td style="text-align: left;width:50%;"><b>Plazo : </b><?php echo $plazo; ?></td>
                        <td style="text-align: left;width:50%;"><b>Fecha. P : </b><?php echo fecha($fecven); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align: left;width:50%;"><b>AFECTO :</b> <?php echo number_format($dafecto, 2, '.', ' '); ?></td>
                    <td style="text-align: left;width:50%;"><b>INAFECTO :</b> <?php echo number_format($dinafecto, 2, '.', ' '); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;"><b>IGV :</b> <?php echo number_format($digv, 2, '.', ' '); ?></td>
                    <td style="text-align: left;width:50%;"><b>TOTAL : </b><?php echo number_format($dtotal, 2, '.', ' '); ?></td>
                </tr>
            <?php } ?>
        </table>
        <table class="table_2" style="width: 99%;" frame="hsides" rules="groups">
            <COLGROUP align="center" style="color: #0a6fc2"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            
            <?php if ($activoCompras == 1) { ?>
            
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            
            <?php }else if ($ver_costo == 1) { ?>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <COLGROUP align="center" style="color: #0a6fc2;"></COLGROUP>
            <?php
            }
            $sqlComprasMov = "SELECT codpro,qtyprf,qtypro,numlote,costre,pripro,prisal FROM movmov where invnum = '$CCompra' order by orden";
            $resultComprasMov = mysqli_query($conexion, $sqlComprasMov);
            if (mysqli_num_rows($resultComprasMov)) {
            ?>

                <tr>
                    <th>Cod</th>
                    <th>Producto</th>
                    <th>Laboratorio</th>

                    <?php  if (($tipmov == 2) && ($tipdoc == 6)) { ?>
                        <th>Lote</th>
                    <th>Venci</th>
                    <?php } ?>


                    <th>Cant</th>


                       <?php if ($activoCompras == 1) { ?>
                       
                    <th>Lote</th>
                    <th>Venci</th>
                    <th>Precio Compra</th>
                    <th>Precio Neto</th>
                    <th>Sub Total</th>
                    
                       <?php }else if ($ver_costo == 1) { ?>
                        <th>Costo</th>
                        <th>Sub total</th>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        <hr>
                    </td>
                    <td>
                        <hr>
                    </td>
                    <td>
                        <hr>
                    </td>
                    <td>
                        <hr>
                    </td>
                    <?php  if (($tipmov == 2) && ($tipdoc == 6)) { ?>
                        <td>
                        <hr>
                    </td>
                    <td>
                        <hr>
                    </td>

                    <?php } ?>
                    
                    <?php if ($activoCompras == 1) { ?>
                    
                        <td>
                            <hr>
                        </td>
                        <td>
                            <hr>
                        </td>
                        <td>
                            <hr>
                        </td>
                        <td>
                            <hr>
                        </td>
                        <td>
                            <hr>
                        </td>
                        
                    <?php }else if ($ver_costo == 1) { ?>
                        <td>
                            <hr>
                        </td>
                        <td>
                            <hr>
                        </td>
                    <?php } ?>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($resultComprasMov)) {
                    $codpro = $row['codpro'];
                    $qtyprf = $row['qtyprf'];
                    $qtypro = $row['qtypro'];
                    $numlotereg = $row['numlote'];
                    $costre = $row['costre'];
                    $pripro = $row['pripro'];
                    $prisal     = $row['prisal'];
                    if ($qtyprf <> "") {
                        $CANT = $qtyprf;
                    } else {
                        $CANT = 'C' . $qtypro;
                    }

                    $Producto = "";
                    $Marca = "";
                    $sqlProd = "SELECT P.desprod,M.destab,M.abrev FROM producto P LEFT JOIN titultabladet M ON M.codtab = P.codmar WHERE  P.codpro = '$codpro'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row = mysqli_fetch_array($resultProd)) {
                            $Producto = $row['desprod'];
                            $Marca = $row['destab'];
                            $abrev = $row['abrev'];
                        }
                    }

                    $numlote = "";
                    $vencim = "";
                    $sqlProd = "SELECT numlote,vencim from  movlote WHERE codpro = '$codpro' and idlote ='$numlotereg'";

                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row = mysqli_fetch_array($resultProd)) {
                            $numlote = $row['numlote'];
                            $vencim = $row['vencim'];
                        }
                    }
                ?>
                    <tr>
                        <td style="text-align: left; width:8%;"> <b><?php echo $codpro; ?></b></td>
                        <td style="width:52%;"> <b><?php echo $Producto; ?></b></td>
                        <td style="width:12%;"> <b><?php echo $abrev; ?></b></td>

                        <?php  if (($tipmov == 2) && ($tipdoc == 6)) { ?>
                        <td style="text-align:center; width:9%;"><b><?php echo $numlote; ?></b></td>
                        <td style="text-align:center; width:9%;"><b><?php echo $vencim; ?></b></td>
                        <?php }  ?>


                        <td style="text-align:center; width:9%;"> <b><?php echo $CANT; ?></b></td>
                       
                       <?php if ($activoCompras == 1) { ?>
                                <td style="text-align:center; width:9%;"><b><?php echo $numlote; ?></b></td>
                                <td style="text-align:center; width:9%;"><b><?php echo $vencim; ?></b></td>
                                <td style="text-align:right; width:9%;"> <b><?php echo $prisal; ?></b></td>
                                <td style="text-align:center; width:9%;"><b><?php echo $pripro; ?></b></td>
                                <td style="text-align:right; width:9%;"> <b><?php echo $costre; ?></b></td>
                       
                       
                        <?php }else if ($ver_costo == 1) {

                            if (($tipmov == 2) && ($tipdoc == 1)) {

                                //salida varias imprime distinto
                        ?>
                                <td style="text-align:center; width:9%;"> <b><?php echo $invtot; ?></b></td>
                                <td style="text-align:right; width:9%;"> <b><?php echo $pripro; ?></b></td>

                            <?php } else { ?>
                                <td style="text-align:center; width:9%;"> <b><?php echo $pripro; ?></b></td>
                                <td style="text-align:right; width:9%;"> <b><?php echo $invtot; ?></b></td>


                        <?php
                            }
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                     <?php if ($activoCompras == 1) { ?>
                     <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                     
                    <?php }else if ($ver_costo == 1) { ?>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    <?php } ?>
                </tr>

                <tr>
                    <td   <?php if ($activoCompras == 1) { ?> colspan="9"   <?php  }else  if ($ver_costo == 1) { ?> colspan="6" <?php } else { ?> colspan="4" <?php } ?>style="text-align:center ;width:100%;">
                        <b> ---------------FIN DE LA IMPRESION---------------</b>
                    </td>
                </tr>
        </table>

<?php
            }
        }
?>
</form>