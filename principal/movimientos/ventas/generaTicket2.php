<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<tr><td>" . $Valor . "</td></tr>";
    }
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <script>
        function imprimir() {
            var f = document.form1;
            window.print();
            f.action = "venta_index.php";
            f.method = "post";
            f.submit();
        }
    </script>
    <style>
        body,
        table {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <form name="form1" id="form1">
        <?php
        function cambiarFormatoFecha($fecha)
        {
            list($anio, $mes, $dia) = explode("-", $fecha);
            return $dia . "-" . $mes . "-" . $anio;
        }
        $rd            = $_REQUEST['rd'];
        $venta        = $_REQUEST['vt'];
        require_once('calcula_monto2.php');
        $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,icbpertotal "
            . "FROM venta where invnum = '$venta'";
        $resultV = mysqli_query($conexion, $sqlV);
        if (mysqli_num_rows($resultV)) {
            while ($row = mysqli_fetch_array($resultV)) {
                $invnum       = $row['invnum'];
                $nrovent      = $row['nrovent'];
                $invfec       = cambiarFormatoFecha($row['invfec']);
                $cuscod       = $row['cuscod'];
                $usecod       = $row['usecod'];
                $codven       = $row['codven'];
                $forpag       = $row['forpag'];
                $fecven       = $row['fecven'];
                $sucursal     = $row['sucursal'];
                $correlativo  = $row['correlativo'];
                $nomcliente   = $row['nomcliente'];
                $pagacon      = $row['pagacon'];
                $vuelto       = $row['vuelto'];
                $valven       = $row['valven'];
                $igv          = $row['igv'];
                $invtot       = $row['invtot'];
                $hora         = $row['hora'];
                $tipdoc       = $row['tipdoc'];
                $icbper_total = $row['icbpertotal'];
            }
        }

        //TOMO LOS PATRAMETROS DEL TICKET
        $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '$sucursal'";
        $resultTicket = mysqli_query($conexion, $sqlTicket);
        if (mysqli_num_rows($resultTicket)) {
            while ($row = mysqli_fetch_array($resultTicket)) {
                $linea1       = $row['linea1'];
                $linea2       = $row['linea2'];
                $linea3       = $row['linea3'];
                $linea4       = $row['linea4'];
                $linea5       = $row['linea5'];
                $linea6       = $row['linea6'];
                $linea7       = $row['linea7'];
                $linea8       = $row['linea8'];
                $linea9       = $row['linea9'];
                $pie1         = $row['pie1'];
                $pie2         = $row['pie2'];
                $pie3         = $row['pie3'];
                $pie4         = $row['pie4'];
                $pie5         = $row['pie5'];
                $pie6         = $row['pie6'];
                $pie7         = $row['pie7'];
                $pie8         = $row['pie8'];
                $pie9         = $row['pie9'];
            }
        } else {
            $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
                . "FROM ticket where sucursal = '1'";
            $resultTicket = mysqli_query($conexion, $sqlTicket);
            if (mysqli_num_rows($resultTicket)) {
                while ($row = mysqli_fetch_array($resultTicket)) {
                    $linea1       = $row['linea1'];
                    $linea2       = $row['linea2'];
                    $linea3       = $row['linea3'];
                    $linea4       = $row['linea4'];
                    $linea5       = $row['linea5'];
                    $linea6       = $row['linea6'];
                    $linea7       = $row['linea7'];
                    $linea8       = $row['linea8'];
                    $linea9       = $row['linea9'];
                    $pie1         = $row['pie1'];
                    $pie2         = $row['pie2'];
                    $pie3         = $row['pie3'];
                    $pie4         = $row['pie4'];
                    $pie5         = $row['pie5'];
                    $pie6         = $row['pie6'];
                    $pie7         = $row['pie7'];
                    $pie8         = $row['pie8'];
                    $pie9         = $row['pie9'];
                }
            }
        }
        $sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
        $resultUsu = mysqli_query($conexion, $sqlUsu);
        if (mysqli_num_rows($resultUsu)) {
            while ($row = mysqli_fetch_array($resultUsu)) {
                $nomusu = $row['nomusu'];
                $nomusu2 = $row['abrev'];
            }
        }

        $MarcaImpresion = 0;
        $sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
        $resultDataGen = mysqli_query($conexion, $sqlDataGen);
        if (mysqli_num_rows($resultDataGen)) {
            while ($row = mysqli_fetch_array($resultDataGen)) {
                $desemp         = $row['desemp'];
                $rucemp         = $row['rucemp'];
                $telefonoemp    = $row['telefonoemp'];
                $MarcaImpresion = $row["MarcaImpresion"];
            }
        }
        $sqlCli = "SELECT descli,dircli,ruccli FROM cliente where codcli = '$cuscod'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {
                $descli       = $row['descli'];
                $dircli       = $row['dircli'];
                $ruccli       = $row['ruccli'];
            }
        }

        $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta'";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $igvVTADet     = 0;
                $codproDet     = $row['codpro'];
                $canproDet     = $row['canpro'];
                $factorDet     = $row['factor'];
                $prisalDet     = $row['prisal'];
                $priproDet     = $row['pripro'];
                $fraccionDet   = $row['fraccion'];
                $sqlProdDet    = "SELECT igv FROM producto where codpro = '$codproDet'";
                $resultProdDet = mysqli_query($conexion, $sqlProdDet);
                if (mysqli_num_rows($resultProdDet)) {
                    while ($row1 = mysqli_fetch_array($resultProdDet)) {
                        $igvVTADet        = $row1['igv'];
                    }
                }
                if ($igvVTADet == 0) {
                    $MontoDetalle = $prisalDet * $canproDet;
                    $SumInafectos = $SumInafectos + $MontoDetalle;
                }
            }
        }
        $SumGrabado = $invtot - ($igv + $SumInafectos);
        $SumGrabado = $SumGrabado - $icbper_total;
        mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
        ?>
        <table style="width: 100%;">
            <?php
            echo pintaDatos($linea1);
            echo pintaDatos($linea2);
            echo pintaDatos($linea3);
            echo pintaDatos($linea4);
            if ($tipdoc == 4) {
                echo pintaDatos($linea5);
            }
            echo pintaDatos($linea6);
            echo pintaDatos($linea7);
            echo pintaDatos($linea8);
            echo pintaDatos($linea9);
            ?>
            <tr>
                <td style="text-align: left">Fecha: <?php echo $invfec; ?> Hora: <?php echo substr($hora, 0, 5); ?> Vendedor: <?php echo $nomusu; ?></td>
            </tr>
            <tr>
                <td>Cliente: <?php echo $descli; ?></td>
            </tr>
            <?php
            if (($ruccli <> "") and ($tipdoc == 1)) {
            ?>
                <tr>
                    <td>RUC: <?php echo $ruccli; ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td>Direcci&oacute;n: <?php echo $dircli; ?></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%">
            <?php
            $i  = 1;
            $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta'";
            $resultDet = mysqli_query($conexion, $sqlDet);
            if (mysqli_num_rows($resultDet)) {
            ?>
                <tr>
                    <td style="text-align: left; width:5%;">Cant.</td>
                    <td style="width:45%;">Producto</td>
                    <td style="width:10%;">Lote</td>
                    <td style="text-align: right; width:20%;">Precio</td>
                    <td style="text-align: right; width:20%;">Sub Total</td>
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
                    if ($fraccion == "F") {
                        $cantemp = "C" . $canpro;
                    } else {
                        $cantemp = $canpro;
                    }
                    $Cantidad = $canpro;
                    $sqlProd = "SELECT desprod,codmar FROM producto where codpro = '$codpro'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row1 = mysqli_fetch_array($resultProd)) {
                            $desprod    = substr($row1['desprod'], 0, 25);
                            $codmar     = $row1['codmar'];
                        }
                    }
                    $numlote = "";
                    $sqlLote = "SELECT numlote FROM movlote where idlote = '$idlote'";
                    $resulLote = mysqli_query($conexion, $sqlLote);
                    if (mysqli_num_rows($resulLote)) {
                        while ($row1 = mysqli_fetch_array($resulLote)) {
                            $numlote    = $row1['numlote'];
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

                    if ($numlote <> "") {
                        $Producto = $desprod . "-" . $numlote;
                    } else {
                        $Producto = $desprod;
                    }

                    if ($MarcaImpresion == 1) {
                        $desprod = $desprod . "-" . $marca;
                    }
                ?>
                    <tr>
                        <td><?php echo $cantemp; ?></td>
                        <td><?php echo $desprod; ?></td>
                        <td><?php echo $numlote; ?></td>
                        <td style="text-align: right"><?php echo $prisal; ?></td>
                        <td style="text-align: right"><?php echo $prisal * $Cantidad; ?></td>
                    </tr>

            <?php
                    $i++;
                }
            }
            ?>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td><b>Grabada: <?php echo number_format($SumGrabado, 2, '.', ''); ?></b></td>
                <td><b>Inafecto: <?php echo number_format($SumInafectos, 2, '.', ''); ?></b></td>
                <td><b>Afecto: <?php echo $valven; ?></b></td>
                <td><b>IGV: <?php echo ($igv); ?></b></td>
                <td style="text-align: right; font-size: 18px;"><b>Total: <?php echo $invtot; ?></b></td>
            </tr>
            <tr>
                <td colspan="2"><b>Pag&oacute; con: <?php echo $pagacon; ?></b></td>
                <td colspan="3" style="text-align: right"><b>Vuelto: <?php echo $vuelto; ?></b></td>
            </tr>
        </table>
        <table style="width: 100%">
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
            ?>
        </table>
    </form>
</body>

</html>