<?php
//require_once('fpdf/fpdf.php');
include('../session_user.php');
require_once('../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');    //CONEXION A BASE DE DATOS

require_once('../phpqrcode/qrlib.php');
require_once('../movimientos/ventas/calcula_monto2.php');
require_once('MontosText.php');
$venta = $_REQUEST['venta'];

function pintaDatos($Valor) {
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center' ><center>" . $Valor . "</center></td></tr>";
    }
}

function zero_fill($valor, $long = 0) {
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>
<html>

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">



        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script>
            function imprimir() {
                //alert("consult_compras1.php?pageno=<?php echo $pag ?>&numero=<?php echo $numerox ?>");
                var f = document.form1;
                window.print();
                self.close();
<?php
// echo "parent.opener.location='reg_venta1.php';";
?>
                //f.action = "ingresos_varios.php";
                //f.method = "post";
                //f.submit();
            }
        </script>

        <style>
            body {
                font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                line-height: 90%;
                font-family: times;
                font-size: 11px;
                font-weight: normal;
            }


            .table_T {
                line-height: 90%;
                font-family: times;
                font-size: 11px;
                font-weight: normal;
            }
        </style>
    </head>

    <?php

    function cambiarFormatoFecha($fecha) {
        list($anio, $mes, $dia) = explode("-", $fecha);
        return $dia . "/" . $mes . "/" . $anio;
    }

    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../movimientos/ventas/temp' . DIRECTORY_SEPARATOR;

    $PNG_WEB_DIR = '../movimientos/ventas/temp/';

    $filename = $PNG_TEMP_DIR . 'ventas.png';
    $matrixPointSize = 3;
    $errorCorrectionLevel = 'L';
    $framSize = 3; //Tama?????o en blanco
    $seriebol = "B001";
    $seriefac = "F001";
    $serietic = "T001";
    $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';



    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,val_habil "
            . "FROM venta where invnum = '$venta'";
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
            $anotacion = $row['anotacion'];
            $nrofactura = $row['nrofactura'];
            $val_habil = $row['val_habil'];

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


    $sqlUsu = "SELECT logo FROM xcompa where codloc = '$sucursal'";
    $resultUsu = mysqli_query($conexion, $sqlUsu);
    if (mysqli_num_rows($resultUsu)) {
        while ($row = mysqli_fetch_array($resultUsu)) {
            $logo = $row['logo'];
        }
    }
    if ($forpag == "E") {
        $forma = "EFECTIVO";
    }
    if ($forpag == "C") {
        $forma = "CREDITO";
    }
    if ($forpag == "T") {
        $forma = "TARJETA";
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
        $TextDoc = "Factura electronica";
    }
    if ($tipdoc == 2) {
        $TextDoc = "Boleta de Venta electronica";
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
            $nomusu2 = $row['nomusu'];
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
    $sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos,dnicli FROM cliente where codcli = '$cuscod'";
    $resultCli = mysqli_query($conexion, $sqlCli);
    if (mysqli_num_rows($resultCli)) {
        while ($row = mysqli_fetch_array($resultCli)) {
            $descli = $row['descli'];
            $dnicli = $row['dnicli'];
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
    $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
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
    
            if (($igvVTADet == 0) && ($icbper == 0)) {
                $MontoDetalle = $prisalDet * $canproDet;
                $SumInafectos = $SumInafectos + $MontoDetalle;
                $SumInafectos = number_format($SumInafectos, 2, '.', '');
            }
        }
    }
    $SumGrabado = $invtot - ($igv + $SumInafectos);
    ?>

    <body onload="imprimir()">



        <!--    <form name="form1" id="form1" align="center" style="width: 60%;margin-left:130px;">-->

        <form name="form1" id="form1" align="center" style="width: 100%;">
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
            <table class="table_T" style="width: 100%" align="center">
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
                if (($ruccli <> "") and ( $tipdoc == 1)) {
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
                if (($pstcli > 0) and ( $descli <> "PUBLICO EN GENERAL")) {
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
            <table class="table_T" align="center" style="width: 100%">
                <?php
                $i = 1;
                $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
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

                    <table class="table_T" align="center" style="width: 100%">
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
                        <td colspan="5" style="text-align: left;font-size: 10px;">SON: <?php echo numtoletras($invtot); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><b>PAG&Oacute; con:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $pagacon; ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="5"><b>VUELTO:&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; S/ <?php echo $vuelto; ?></b></td>
                    </tr>
                <?php } ?>
            </table>
            <table class="table_T" align="center" style="width: 100%">
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

        </form>



    </body>

</html>