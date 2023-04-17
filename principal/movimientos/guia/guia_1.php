<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('MontosText.php');
require_once('../../../funciones/highlight.php');    //ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');    //DESHABILITA TECLAS
require_once('../../../funciones/botones.php');    //COLORES DE LOS BOTONES
require_once('../../../funciones/funct_principal.php');    //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once('../funciones/venta.php');    //FUNCIONES DE ESTA PANTALLA
require_once('../../local.php');    //LOCAL DEL USUARIO
//$venta     = $_SESSION['venta'];

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>
<html>

<head>
    <meta charset="euc-jp">

    <script>
        function imprimir() {

            window.print();
            window.history.go(-2)

            f.submit();
        }
    </script>
    <style type="text/css">
        body,
        table {
            line-height: 100%
        }
    </style>
    <style>
        body,
        table {
            font-family: courier;
            font-size: 10px;
            font-weight: normal;
        }
    </style>
</head>

<body onload="imprimir()">

    <form name="form1" id="form1">
        <?php
        $invnum = $_REQUEST['invnum'];
        //    echo $invnum;
        $sql = "SELECT codpro,canpro,fraccion,prisal,pripro,usecod FROM detalle_venta where invnum = '$invnum'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                ++$i;
                $codpro = $row['codpro'];
                $canpro = $row['canpro'];
                $fraccion = $row['fraccion'];
                $prisal = $row['prisal'];
                $pripro = $row['pripro'];
                $usecod = $row['usecod'];
            }
        }
        $sql1 = "SELECT porcent FROM datagen";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $porcent = $row1['porcent'];
            }
        }


        $sql1 = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $desprod = $row1['desprod'];
                $codmar = $row1['codmar'];
                $factor = $row1['factor'];
            }
        }
        $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $ltdgen = $row1['ltdgen'];
            }
        }
        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $marca = $row1['destab'];
            }
        }

        $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $user_venta = $row1['nomusu'];
            }
        }

        function cambiarFormatoFecha($fecha)
        {
            list($anio, $mes, $dia) = explode("-", $fecha);
            return $dia . "/" . $mes . "/" . $anio;
        }

        //set it to writable location, a place for temp generated PNG files
        $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

        //html PNG location prefix
        $PNG_WEB_DIR = 'temp/';

        include "../../phpqrcode/qrlib.php";

        $filename = $PNG_TEMP_DIR . 'ventas.png';

        $matrixPointSize = 3;
        $errorCorrectionLevel = 'L';
        $framSize = 3; //Tama�����o en blanco

        $rd = $_REQUEST['rd'];
        $venta = $_REQUEST['vt'];
        $seriebol = "B001";
        $seriefac = "F001";
        $serietic = "T001";
        $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

        require_once('calcula_monto2.php');
        $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,icbpertotal FROM venta where invnum = '$invnum'";
        $resultV = mysqli_query($conexion, $sqlV);
        if (mysqli_num_rows($resultV)) {
            while ($row = mysqli_fetch_array($resultV)) {
                $invnum = $row['invnum'];
                $nrovent = $row['nrovent'];
                $invfec = cambiarFormatoFecha($row['invfec']);
                $cuscod = $row['cuscod'];
                $usecod = $row['usecod'];
                $codven = $row['codven'];
                $forpag = $row['forpag'];
                $fecven = $row['fecven'];
                $sucursal = $row['sucursal'];
                $correlativo = $row['correlativo'];
                $nomcliente = $row['nomcliente'];
                $pagacon = $row['pagacon'];
                $vuelto = $row['vuelto'];
                $valven = $row['valven'];
                $igv = $row['igv'];
                $invtot = $row['invtot'];
                $hora = $row['hora'];
                $tipdoc = $row['tipdoc'];
                $tipteclaimpresa = $row['tipteclaimpresa'];
                $icbper_total = $row['icbpertotal'];
                $sqlXCOM = "SELECT seriebol,seriefac,serietic FROM xcompa where codloc = '$sucursal'";
                $resultXCOM = mysqli_query($conexion, $sqlXCOM);
                if (mysqli_num_rows($resultXCOM)) {
                    while ($row = mysqli_fetch_array($resultXCOM)) {
                        $seriebol = $row['seriebol'];
                        $seriefac = $row['seriefac'];
                        $serietic = $row['serietic'];
                    }
                }
            }
        }

        //F9
        if ($tipteclaimpresa == "2") {
            if ($tipdoc == 1) {
                $serie = "F" . $seriefac;
            }
            if ($tipdoc == 2) {
                $serie = "B" . $seriebol;
            }
            if ($tipdoc == 4) {
                $serie = "T" . $serietic;
            }
        } else { //F8
            $serie = $correlativo;
        }

        if ($tipdoc == 1) {
            $TextDoc = "Factura electr&oacute;nica";
        }
        if ($tipdoc == 2) {
            $TextDoc = "Boleta electr&oacute;nica";
        }
        if ($tipdoc == 4) {
            $TextDoc = "";
        }
        $SerieQR = $serie;

        //TOMO LOS PATRAMETROS DEL TICKET
        $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '$sucursal'";
        $resultTicket = mysqli_query($conexion, $sqlTicket);
        if (mysqli_num_rows($resultTicket)) {
            while ($row = mysqli_fetch_array($resultTicket)) {
                $linea1 = $row['linea1'];
                $linea2 = $row['linea2'];
                $linea3 = $row['linea3'];
                $linea4 = $row['linea4'];
                $linea5 = $row['linea5'];
                $linea6 = $row['linea6'];
                $linea7 = $row['linea7'];
                $linea8 = $row['linea8'];
                $linea9 = $row['linea9'];
                $pie1 = $row['pie1'];
                $pie2 = $row['pie2'];
                $pie3 = $row['pie3'];
                $pie4 = $row['pie4'];
                $pie5 = $row['pie5'];
                $pie6 = $row['pie6'];
                $pie7 = $row['pie7'];
                $pie8 = $row['pie8'];
                $pie9 = $row['pie9'];
            }
        } else {
            $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
                . "FROM ticket where sucursal = '1'";
            $resultTicket = mysqli_query($conexion, $sqlTicket);
            if (mysqli_num_rows($resultTicket)) {
                while ($row = mysqli_fetch_array($resultTicket)) {
                    $linea1 = $row['linea1'];
                    $linea2 = $row['linea2'];
                    $linea3 = $row['linea3'];
                    $linea4 = $row['linea4'];
                    $linea5 = $row['linea5'];
                    $linea6 = $row['linea6'];
                    $linea7 = $row['linea7'];
                    $linea8 = $row['linea8'];
                    $linea9 = $row['linea9'];
                    $pie1 = $row['pie1'];
                    $pie2 = $row['pie2'];
                    $pie3 = $row['pie3'];
                    $pie4 = $row['pie4'];
                    $pie5 = $row['pie5'];
                    $pie6 = $row['pie6'];
                    $pie7 = $row['pie7'];
                    $pie8 = $row['pie8'];
                    $pie9 = $row['pie9'];
                }
            }
        }
        $sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
        $resultUsu = mysqli_query($conexion, $sqlUsu);
        if (mysqli_num_rows($resultUsu)) {
            while ($row = mysqli_fetch_array($resultUsu)) {
                $nomusu = $row['abrev'];
            }
        }

        $MarcaImpresion = 0;
        $sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
        $resultDataGen = mysqli_query($conexion, $sqlDataGen);
        if (mysqli_num_rows($resultDataGen)) {
            while ($row = mysqli_fetch_array($resultDataGen)) {
                $desemp = $row['desemp'];
                $rucemp = $row['rucemp'];
                $telefonoemp = $row['telefonoemp'];
                $MarcaImpresion = $row["MarcaImpresion"];
            }
        }
        $departamento = "";
        $provincia = "";
        $distrito = "";
        $pstcli = 0;
        $sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos FROM cliente where codcli = '$cuscod'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {
                $descli = $row['descli'];
                $dircli = $row['dircli'];
                $ruccli = $row['ruccli'];
                $dptcli = $row['dptcli'];
                $procli = $row['procli'];
                $discli = $row['discli'];
                $pstcli = $row['puntos'];
            }
            if (strlen($dircli) > 0) {
                //VERIFICO LOS DPTO, PROV Y DIST
                if (strlen($dptcli) > 0) {
                    //                $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
                    $sqlDPTO = "SELECT name FROM departamento where id = '$dptcli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $departamento = $row['name'];
                        }
                    }
                }
                if (strlen($procli) > 0) {
                    $sqlDPTO = "SELECT name FROM provincia where id = '$procli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $provincia = " | " . $row['name'];
                        }
                    }
                }

                if (strlen($discli) > 0) {
                    $sqlDPTO = "SELECT name FROM distrito where id = '$discli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $distrito = " | " . $row['name'];
                        }
                    }
                }
                $Ubigeo = $departamento . $provincia . $distrito;
                if (strlen($Ubigeo) > 0) {
                    $dircli = $dircli . "  - " . $Ubigeo;
                }
            }
        }
        $SumInafectos = 0;
        $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$invnum'";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $igvVTADet = 0;
                $codproDet = $row['codpro'];
                $canproDet = $row['canpro'];
                $factorDet = $row['factor'];
                $prisalDet = $row['prisal'];
                $priproDet = $row['pripro'];
                $fraccionDet = $row['fraccion'];
                $sqlProdDet = "SELECT igv,icbper FROM producto where codpro = '$codproDet'";
                $resultProdDet = mysqli_query($conexion, $sqlProdDet);
                if (mysqli_num_rows($resultProdDet)) {
                    while ($row1 = mysqli_fetch_array($resultProdDet)) {
                        $igvVTADet = $row1['igv'];
                        $icbper = $row1['icbper'];
                    }
                }

                if (($igvVTADet == 0)) {
                    $MontoDetalle = $prisalDet * $canproDet;
                    $SumInafectos = $SumInafectos + $MontoDetalle;
                    $SumInafectos = number_format($SumInafectos, 2, '.', '');
                }
            }
        }
        $SumGrabado = $invtot - ($igv + $SumInafectos);
        $SumGrabado = $SumGrabado - $icbper_total;
        mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
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
        <table style="width: 100%; border: 1px ;">

            <tr style="width: 100%;height:100PX">
                <td style="width: 50%">


                    <p style="text-align: left">FECHA: <?php echo $invfec; ?> HORA: <?php echo substr($hora, 0, 5); ?> </p>

                    <p>VENDEDOR: <?php echo $user_venta; ?></p>

                    <p>CLIENTE: <?php echo $descli; ?></p>

                    <?php
                    if (($ruccli <> "") and ($tipdoc == 1)) {
                    ?>

                        <p>RUC: <?php echo $ruccli; ?></p>

                    <?php
                    }
                    if (strlen($dircli) > 0) {
                    ?>

                        <p>DIRECCI&Oacute;N: <?php echo $dircli; ?></p>

                    <?php
                    }
                    if (($pstcli > 0) and ($descli <> "PUBLICO EN GENERAL")) {
                    ?>

                        <p>PUNTOS ACUMULADOS HASTA LA FECHA : <?php echo $pstcli; ?></p>

                    <?php
                    }
                    ?>


                </td>


                <td style="width: 50%;border-radius: 9px;font-size: 20px;text-align: right;border: 1px solid;">
                    <?php
                    if (($ruccli <> "") and ($tipdoc == 1)) {
                    ?>

                        <p style="margin-top: -27PX;text-align: center">RUC: <?php echo $ruccli; ?></p>
                    <?php }
                    ?>
                    <H5 style="margin-bottom:-20PX;background: #D7D6D6;height:20PX;text-align: center">
                        <P>GUIA DE REMISION - REMITENTE</P>
                    </H5>

                    <br><br>
                    <p style="margin-bottom:-20PX"><?php echo $TextDoc; ?> - <?php echo $serie . '-' . zero_fill($correlativo, 8); ?></p>
                </td>
            </tr>

        </table>
        <hr>
        <table style="width: 100%; border: 1px ;">

            <tr>

                <td style="text-align: left; width:50%;border-radius: 7px;border: 1px solid;height:80PX">
                    <h5 style="text-align: CENTER;width: 50%;margin-left: 35PX; margin-top: -7PX">PUNTO DE PARTIDA</h5>
                    <p>-----------------------------------------------------------------------------</p>
                    <p>-----------------------------------------------------------------------------</p>
                    <p>fecha inicio de traslado_________________________costo minimo________________</p>
                </td>

                <td style="text-align: left; width:50%;border-radius: 7px;border: 1px solid;height:80PX">
                    <h5 style="text-align: right;width: 50%;margin-left: 35PX; margin-top: -7PX">PUNTO DE LLEGADA</h5>
                    <p>-----------------------------------------------------------------------------</p>
                    <p>Nombre o Razon social del destinatario:--------------------------------------</p>
                    <p>_________________________________________RUC:________________________________</p>
                </td>

            </tr>

            <tr>
                <td style="text-align: left;border-radius: 7px; width:50%;border: 1px solid;height:80PX">
                    <h5 style="text-align: CENTER;width: 50%;margin-left: 60PX; margin-top: -18PX">UNIDAD DE TRANSPORTE Y CONDUCTOR</h5>
                    <p>-----------------------------------------------------------------------------</p>
                    <p>-----------------------------------------------------------------------------</p>
                </td>

                <td style="text-align: left;border-radius: 7px; width:50%;border: 1px solid;height:80PX">
                    <h5 style="text-align: right;width: 50%;margin-left: 35PX; margin-top: -18PX">EMPRESA DE TRANSPORTE</h5>
                    <p>-----------------------------------------------------------------------------</p>
                    <p>-----------------------------------------------------------------------------</p>
                </td>
            </tr>
        </table>
        <HR>
        <table style="width: 100%;">
            <?php
            $i = 1;
            $sqlDet = "SELECT * FROM detalle_venta where invnum = '$invnum'";
            $resultDet = mysqli_query($conexion, $sqlDet);
            if (mysqli_num_rows($resultDet)) {
            ?>
                <tr>
                    <td style="text-align: left; width:5%;">CANT</td>
                    <td style="width:45%;">DESCRIPCION</td>
                    <td style="width:20%;">MARCA</td>
                    <td style="text-align: right; width:15%;">PRECIO UND</td>
                    <td style="text-align: right; width:15%;">SUB TOTAL</td>
                    <!--<td style="width:10%;">LOTE</td>
                    <td style="text-align: right; width:20%;">PRECIO</td>
                    <td style="text-align: right; width:20%;">SUB TOTAL</td>-->
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
                    $numlote = "............";
                    $vencim = "";
                    $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
                    $resulLote = mysqli_query($conexion, $sqlLote);
                    if (mysqli_num_rows($resulLote)) {
                        while ($row1 = mysqli_fetch_array($resulLote)) {
                            $numlote = $row1['numlote'];
                            $vencim = $row1['vencim'];
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
                    if (strlen($numlote) > 0) {
                        $producto = $desprod . "  Lote:" . $numlote;
                        if (strlen($vencim) > 0) {
                            $producto = $producto . "(" . $vencim . ")";
                        }
                    } else {
                        $producto = $desprod;
                    }
                ?>
                    <tr>
                        <td style="text-align: left; width:5%;"><?php echo $cantemp; ?></td>
                        <td style="width:45%;"><?php echo $producto; ?></td>
                        <td style="width:20%;"><?php echo $marca; ?></td>
                        <td style="text-align: right; width:15%;"><?php echo number_format($prisal, 2, '.', ''); ?></td>
                        <td style="text-align: right; width:15%;"><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></td>
                        <!--<td><?php echo $numlote; ?></td>-->
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>

            <?php
                    $i++;
                }
            }
            mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$invnum'");
            ?>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>GRAVADA: <?php echo number_format($SumGrabado, 2, '.', ''); ?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>INAFECTO: <?php echo number_format($SumInafectos, 2, '.', ''); ?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><b>IGV: <?php echo ($igv); ?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;font-size: 12px;"><b>TOTAL: S/ <?php echo $invtot; ?></b></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;font-size: 8px;">SON: <?php echo valorEnLetras($invtot); ?></td>
            </tr>
            <tr>
                <td colspan="5"><b>PAG&Oacute; con: S/ <?php echo $pagacon; ?></b></td>
            </tr>
            <tr>
                <td colspan="5"><b>VUELTO: S/ <?php echo $vuelto; ?></b></td>
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
        <center>
            <?php
            if (($tipdoc == 1) || ($tipdoc == 2)) {
                QRcode::png($linea5 . '|' . $SerieQR . '|' . zero_fill($correlativo, 8) . '|' . $igv . '|' . $invtot . '|' . $invfec, $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
                echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" /><hr/>';
            }
            ?>
        </center>
    </form>
</body>

</html>