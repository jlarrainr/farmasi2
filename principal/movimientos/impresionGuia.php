<?php
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../reportes/MontosText.php');
 require_once('../../phpqrcode/qrlib.php');

 $sql = "SELECT codloc FROM usuario where usecod = '$usuario'  ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $sucursal = $row['codloc'];
    }
}

function pintaDatosTitle($Valor)
{
    if ($Valor <> "") {
        return $Valor;
    } else {
        return "------ . ------";
    }
}

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<p style:'text-align:center'>" . $Valor . "</p>";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}

function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

 $despatch_uid = $_REQUEST['despatch_uid'];

//   echo $despatch_uid;

$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../ventas/temp' . DIRECTORY_SEPARATOR;

$PNG_WEB_DIR = '../ventas/temp/';
$filename = $PNG_TEMP_DIR . 'ventas.png';
$matrixPointSize = 3;
$errorCorrectionLevel = 'L';
$framSize = 3; //Tama?????o en blanco
$filename = $PNG_TEMP_DIR . 'test' . $despatch_uid . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

$TextDoc = "Guia de Remision Electronica";
$serie = "T";

$serie = $despatch_id;


?>

<style>
    section {
        padding: 5px;
        border: 2px solid #0a6fc2;
        width: 98%;
        height: 98%;
        border-radius: 15px;
    }

    .thra {
            border: 1px solid #000;
            padding: 5px;
            border: 1.5px solid #474B56;
            font-size: 14px;
        }

        .table_2 th:nth-child(2) {
    background: black;
    color: white;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<body>


    <form name="form1" id="form1">
        <section>
            <div class="bodyy">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="30%">
                                <div class="title2">
                                    <?php if ($logo <> "") { ?>
                                        <img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " />
                                    <?php } else { ?>
                                        <hr>
                                        <img class="mb-4" src="../../../../LOGOINDEX.png" alt="" style="width:auto;height:auto;" width="72" height="72">
                                    <?php } ?>
                                </div>
                            </td>
                            <td width="40%">
                                <div class="title">
                                    <p class="text_principal"><?php echo pintaDatosTitle($linea1); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea2); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea3); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea4); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea5); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea6); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea7); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea8); ?></p>
                                    <p style="text-align: left"><?php echo pintaDatosTitle($linea9); ?></p>
                                   

                                </div>
                            </td>
                            <td width="30%">
                                <div class="div_ruc">
                                    <p> <?php echo $linea5; ?> </p>
                                    <p class="boleta">
                                        <?php echo $TextDoc; ?>
                                    </p>
                                    <p> <?php echo $despatch_id; ?> </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <div class="d-flex">

                <div class="w-50">
                    <fieldset border 1px>
                        <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>REMITENTE</strong></legend>

                        <div class="div_remitente">


                            <table class="table_cabe">


                                <tr>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe">RUC:</p>
                                    </th>

                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe"><?= $partyidentification; ?></p>
                                    </th>

                                </tr>
                                <tr>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe">
                                            RAZON SOCIAL:
                                        </p>
                                    </th>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe"><?= $partyname; ?></p>
                                    </th>

                                </tr>
                            </table>
                        </div>

                    </fieldset>
                </div>
                <div class="w-50">
                    <fieldset border 1px>
                        <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DESTINATARIO</strong></legend>

                        <div class="div_destinatario">

                            <table class="table_cabe">

                                <tr>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe">RUC: </p>
                                    </th>

                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe"><?= $deliverycustomeraccountid; ?></p>
                                    </th>

                                </tr>
                                <tr>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe">
                                            RAZON SOCIAL:
                                        </p>
                                    </th>
                                    <th align="left" class="thra1cabe">
                                        <p class="letracabe"> <?= $deliveryname; ?> </p>
                                    </th>

                                </tr>
                            </table>

                        </div>
                </div>
            </div>




            <div class="div_datosenvio">
                <fieldset border 1px>
                    <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DATOS DE ENVIO</strong></legend>




                    <table class="table_cabe">

                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Motivo del traslado</p>
                                <?= $handlingCodeString; ?>
                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Modalidad de Traslado</p>
                                <?php if ($transportModeCode == 1) { ?>
                                    Transporte publico
                                    <?php } else { ?>
                                    Transporte Privado
                                    <?php } ?>
                            </td>


                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Fecha de Emision </p>
                                <?= cambiarFormatoFecha($issueDate); ?>
                            </td>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Inicio de Traslado </p>
                                <?= cambiarFormatoFecha($startDate); ?>
                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Hora </p>
                                <?= $issueTime; ?>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Datos del contenedor</p>

                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Numero de Bultos</p>
                                <?= $totalUnitQuantity; ?>
                            </td>


                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Peso bruto total</p>
                                <?= $grossWeightMeasure; ?>
                            </td>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Unidad de medida </p>
                                <?= $unitCodeWeightMeasure; ?>
                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"> Puerto o Aeropuerto </p>

                            </td>
                        </tr>


                    </table>


            </div>

            <div class="div_datosenvio1">

                <fieldset border 1px>
                    <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DIRECCIONES</strong></legend>


                    <table class="table_cabe">

                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Punto de Partida :</p>

                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $originAddressStreetName; ?></p>

                            </td>

                        </tr>

                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Punto de Llegada: </p>

                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $deliveryStreetName; ?></p>

                            </td>

                        </tr>
                        <!-- <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Transportista: </p>

                            </td>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $carrierPartyName; ?></p>
                            </td>
                        </tr> -->
                        <?php if ($transportModeCode == 1) { ?>
                        <tr>
                            <td align="left" class="thra1cabe">

                             <p class="letracabe">Transportista: </p>

                            </td>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $carrierPartyName; ?></p>
                            </td>
                        </tr> 
                    
                        <?php } else { ?>

                            <tr>
                            <td align="left" class="thra1cabe">

                             <p class="letracabe">Numero de Placa: </p>

                            </td>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $licensePlateId; ?></p>
                            </td>
                        </tr> 
                           
                      <?php  }  ?>

                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Descripcion del traslado :</p>

                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $information; ?></p>

                            </td>

                        </tr>


                        <tr>
                            <td align="left" class="thra1cabe">
                                <p class="letracabe">Observacion: </p>

                            </td>

                            <td align="left" class="thra1cabe">
                                <p class="letracabe"><?= $note; ?></p>

                            </td>

                        </tr>


                    </table>



            </div>
            <br>

<!-- 
            <div class="div_datosenvio2">

                <table width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CODIGO</th>
                            <th>CANTIDAD</th>
                            <th>UND DE MEDIDA</th>
                            <th>DESCRIPCION</th>

                        </tr>
                        <tr>
                            <th colspan="5">
                                <hr>
                            </th>
                        </tr>
                    </thead>

                    <tbody>


                        <?php
                        if (mysqli_num_rows($resultDespatch)) {
                            while ($row = mysqli_fetch_array($resultDespatch)) {
                                echo '<tr>';
                                echo    '<td>' . $row["lineid"]  . '</td>';
                                echo    '<td></td>';
                                echo    '<td>' . $row["deliveredQuantity"] . '</td>';
                                echo    '<td>' . $row["unitCode"] . '</td>';
                                echo    '<td>' . $row["nameProduct"] . '</td>';
                                echo '</tr>';
                            }
                        }

                        ?>


                    </tbody>
                </table>
            </div> -->

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
                <?php
              $i = 1;

                $sqlDet = "SELECT  codProducto,nameProduct,deliveredQuantity,unitCode,amountPrice,amountTaxted,igvTax FROM sd_despatch_line where despatch_id = '$despatch_id'";

                //echo $sqlDet;
              
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
                            
                            <th class="thra" style="width: 74px;">U.M.</th>
                            
                            <th class="thra" style="width: 64px;">P. UNITA</th>
                            <th class="thra" style="width: 64px;">VALOR VENTA</th>
                        </tr>
                    </thead>

                    <!-- </table>
            
            <TABLE class="table_2x"  style="border: 1px solid #00FF00; width: 100%;"  frame="hsides" rules="groups">-->

                    <tbody class="lista_productos">
                        <?php
                        
                        while ($row = mysqli_fetch_array($resultDet))  {

                            $codProducto = $row['codProducto'];
                            $nameProduct = $row['nameProduct'];
                            $deliveredQuantity = $row['deliveredQuantity'];
                            $unitCode = $row['unitCode'];
                            $amountPrice = $row['amountPrice'];
                            $amountTaxted = $row['amountTaxted'];
                            $igvTax = $row['igvTax'];
                            //$amountTotal = $row['amountTotal'];

                            //apra sumar montos


                            $sql = "SELECT sum(amountTotal),sum(amountTaxted),sum(igvTax) FROM sd_despatch_line where despatch_id = '$despatch_id'";

                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $tot = $row[0];
                                    $tot1 = $row[1];
                                    $igv = $row[2];
                                }
                            }

                            // $sql = "SELECT  FROM sd_despatch_line where despatch_id = '$despatch_id'";

                            // $result = mysqli_query($conexion, $sql);
                            // if (mysqli_num_rows($result)) {
                            //     while ($row = mysqli_fetch_array($result)) {
                                    
                            //     }
                            // }

                            // $sql = "SELECT  FROM sd_despatch_line where despatch_id = '$despatch_id'";

                            // $result = mysqli_query($conexion, $sql);
                            // if (mysqli_num_rows($result)) {
                            //     while ($row = mysqli_fetch_array($result)) {
                                    
                            //     }
                            // }
                           
                           

                            //echo $tot;


                            $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codProducto' and eliminado='0'";
                            $resultProd = mysqli_query($conexion, $sqlProd);
                            if (mysqli_num_rows($resultProd)) {
                                while ($row1 = mysqli_fetch_array($resultProd)) {
                                    $desprod = $row1['desprod'];
                                    $codmar = $row1['codmar'];
                                    $factorP = $row1['factor'];
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
                        
                        ?>

                        <tr>
                                <td width="40" align="center">
                                    <p><?php echo $i; ?></p>
                                </td>
                                <td width="40" align="center">
                                    <p><?php echo $codProducto; ?></p>
                                </td>
                                <td width="40" align="center">
                                    <p><?php echo $marca; ?></p>
                                </td>
                                <td width="30" align="center">
                                    <p><?php echo $deliveredQuantity; ?></p>
                                </td>
                                <td width="350">
                                    <p><?php echo $nameProduct; ?></p>
                                </td>
                               
                                <td width="60" align="center">
                                    <p><?php echo $unitCode; ?></p>
                                </td>
                               
                                <td width="60" align="center">
                                    <p><?php echo number_format($amountPrice, 2, '.', ''); ?></p>
                                </td>
                                <td width="60" align="center">
                                    <p><?php echo number_format($amountPrice * $deliveredQuantity, 2, '.', ''); ?></p>
                                </td>
                            </tr>
                        
                        <?php
                            $i++;
                        }

                    }

                    
                        for ($n = $i; $n <= 15; $n++) {
                            # code...
                        ?>
                            <tr>
                                <td width="40px" color="#fffff" align="center">&nbsp;</td>
                                <td width="40px" align="center">&nbsp;</td>
                                <td width="50" align="center">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                               
                                <td width="30">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                                <td width="60" align="center">&nbsp;</td>
                                
                            </tr>
                    <?php
                        }
                    
                    
                    
                    //  mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
                    ?>

                    </tbody>
             </table>

             <div class="div_total">
                <p class="letra">Son: <?php echo numtoletras($tot); ?></p>
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
                                    echo pintaDatos('N. I. -' . $despatch_uid);
                                    ?>
                                </div>
                            </td>
                            
                            <td width="33%">
                                <div class="footer_2">
                                    <?php
                                    
                                    QRcode::png($linea5 . '|' . $serieQR . '|' . zero_fill($despatch_uid, 8) . '|' . $igv . '|' . $tot . '|' . cambiarFormatoFecha($issueDate), $filename, $errorCorrectionLevel, $matrixPointSize, $framSize);
                                    echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" />'; 
                                
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
                                                    <center><?php echo 'S/' . number_format($tot1, 2, '.', ''); ?></center>
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
                                                    <center><?php echo $tot; ?></center>
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

    </form>

</body>