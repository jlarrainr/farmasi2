
<?php
require_once('../conexion.php');
//$sql = "SELECT invnum  FROM venta  WHERE sunat_respuesta_descripcion LIKE '%si tiene operaciones%'     ORDER BY invnum  ";
//$sql = "SELECT invnum  FROM nota  WHERE estado=0 and invtot<> bruto and invfec='2021-09-13'    ORDER BY invnum  ";
$sql = "SELECT invnum,igv  FROM nota WHERE invnum='3' and estado=0 ORDER BY invnum ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnumventa = $row['invnum'];




        $sql4 = "SELECT porcent,precioIcbperAnual FROM datagen";
        $result4 = mysqli_query($conexion, $sql4);
        if (mysqli_num_rows($result4)) {
            while ($row4 = mysqli_fetch_array($result4)) {
                $porcent = $row4['porcent'];
                $precioIcbperAnual = $row4['precioIcbperAnual'];
            }
        }

        //$venta = '17761';
        $SumInafectos = 0;
        $monto_total = 0;
        $valor_ventaSuma = 0;
        $mont_bruto = 0;


        $sqlDetTot = "SELECT * FROM detalle_nota where invnum = '$invnumventa' and canpro <> '0'";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $i++;
                $igvVTADet = 0;
                $codproDet = $row['codpro'];
                $canproDet = $row['canpro'];
                $factorDet = $row['factor'];
                $prisalDet = $row['prisal'];


                //$priproDet = $row['pripro'];
                $priproDet = round($canproDet * $prisalDet, 2);


                $fraccionDet = $row['fraccion'];
                $sqlProdDet = "SELECT igv,icbper FROM producto where codpro = '$codproDet'";
                $resultProdDet = mysqli_query($conexion, $sqlProdDet);
                if (mysqli_num_rows($resultProdDet)) {
                    while ($row1 = mysqli_fetch_array($resultProdDet)) {
                        $igvVTADet = $row1['igv'];
                        $icbper = $row1['icbper'];
                        $icbper=0;
                    }
                }
                // Si aplica IGV, colocar porcentaje, sino 0
                $porcent_igv = ($igvVTADet == 1) ? $porcent : 0;

                // Si el producto se vende fraccionado
                if ($fraccion == 'T') {
                    $valor_venta = round(($prisalDet / (($porcent_igv / 100) + 1)) * $canproDet, 2);
                } else {
                    $valor_venta = round(($priproDet / (($porcent_igv / 100) + 1)), 2);
                }


                if ($igvVTADet == 0) {
                    $MontoDetalle = $prisalDet * $canproDet;
                    $SumInafectos = $SumInafectos + $MontoDetalle;
                    $SumInafectos = number_format($SumInafectos, 2, '.', '');
                }

                if ($icbper == 1) {
                    $MontoDetalleICBPER = $precioIcbperAnual * $canproDet;
                    $icbpertotal = $icbpertotal + $MontoDetalleICBPER;
                }


                echo '$valor_venta = ' . $valor_venta . "<br>";
                $valor_ventaSuma += $valor_venta;
                $monto_total += $priproDet;


                $sql1 = "UPDATE detalle_nota set pripro = '$priproDet' where invnum = '$invnumventa' and codpro='$codproDet'";
                //mysqli_query($conexion, $sql1);

            }
        }

 


        $monto_total2 = $monto_total + $icbpertotal;
        $sum_igv = (($monto_total) - $valor_ventaSuma);

        $sum_igv = ($sum_igv);
 
        $SumGrabado = ($monto_total2 - ($sum_igv + $SumInafectos));
        $SumGrabado = $SumGrabado - $icbpertotal;


        $mont3 = $valor_ventaSuma;  ///PRECIO VENTA
        $mont4 = $sum_igv;   ///IGV
        $mont5 = $monto_total2;  ///TOTAL



        $mont3 = $mont3;
        $mont4 = $mont4;
        $mont5 = $mont5;
        $SumGrabado = $SumGrabado;
        $SumInafectos = $SumInafectos;

        $sql1 = "UPDATE nota set valven = '$mont3',igv = '$mont4',invtot = '$mont5',bruto = '$mont5',saldo = '$mont5',gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$invnumventa'";
         mysqli_query($conexion, $sql1);


        echo  '----------------------------' . "<br>";
        echo  '$invnumventa          = ' . $invnumventa . "<br>";
        echo  'valven          = ' . $mont3 . "<br>";
        echo  'igv          = ' . $mont4 . "<br>";
        echo  'invtot          = ' . $mont5 . "<br>";
        echo  'saldo          = ' . $mont5 . "<br>";
        echo  'gravado          = ' . $SumGrabado . "<br>";
        echo  'inafecto          = ' . $SumInafectos . "<br>";
    }
}
