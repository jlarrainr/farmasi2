<?php
require_once('conexion.php');
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}
$sqlX = "SELECT invnum from movmae  ";
$resultX = mysqli_query($conexion, $sqlX);
if (mysqli_num_rows($resultX)) {
    while ($rowX = mysqli_fetch_array($resultX)) {
        $invnum  = $rowX[0];

        //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
        $sqlmovmov = "SELECT invnum,codpro,qtypro,qtyprf,pripro,prisal FROM movmov where invnum = '$invnum'";
        $resultmovmov = mysqli_query($conexion, $sqlmovmov);
        if (mysqli_num_rows($resultmovmov)) {
            while ($row = mysqli_fetch_array($resultmovmov)) {
                $invnum_movmov = $row['invnum'];
                $codpro_movmov = $row['codpro'];
                $qtypro_movmov = $row['qtypro'];
                $qtyprf_movmov = $row['qtyprf'];
                $pripro_movmov = $row['pripro'];
                $prisal_movmov = $row['prisal'];


                $sql_producto = "SELECT codpro,factor,costre FROM producto  WHERE codpro = '$codpro_movmov' ";
                $result_producto = mysqli_query($conexion, $sql_producto);
                if (mysqli_num_rows($result_producto)) {
                    while ($row_producto = mysqli_fetch_array($result_producto)) {
                        $codpro_producto = $row_producto['codpro'];
                        $factor_producto = $row_producto['factor'];
                        $costre_producto = $row_producto['costre'];
                    }
                }





                if ($pripro_movmov == '0') {

                    if ($qtyprf_movmov <> '') {
                        $remplazo = $costre_producto / $factor_producto;
                    } else {
                        $remplazo = $costre_producto;
                    }
                    mysqli_query($conexion, "UPDATE movmov set pripro = '$remplazo' where invnum = '$invnum_movmov' and codpro='$codpro_movmov'");
                }
            }
        }
        mysqli_query($conexion, "UPDATE movmov set prisal=pripro");


        $sqlmovmov2 = "SELECT invnum,codpro,qtypro,qtyprf,pripro,costre FROM movmov where invnum = '$invnum'";
        $resultmovmov2 = mysqli_query($conexion, $sqlmovmov2);
        if (mysqli_num_rows($resultmovmov2)) {
            while ($row2 = mysqli_fetch_array($resultmovmov2)) {
                $invnum_movmov2 = $row2['invnum'];
                $codpro_movmov2 = $row2['codpro'];
                $qtypro_movmov2 = $row2['qtypro'];
                $qtyprf_movmov2 = $row2['qtyprf'];
                $pripro_movmov2 = $row2['pripro'];
                $costre_movmov2 = $row2['costre'];

                $cant_dividir      = convertir_a_numero($qtyprf_movmov2);


                $sql_producto = "SELECT codpro,factor,costre FROM producto  WHERE codpro = '$codpro_movmov2' ";
                $result_producto = mysqli_query($conexion, $sql_producto);
                if (mysqli_num_rows($result_producto)) {
                    while ($row_producto = mysqli_fetch_array($result_producto)) {
                        $codpro_producto = $row_producto['codpro'];
                        $factor_producto = $row_producto['factor'];
                    }
                }
                if ($costre_movmov2 == '0') {
                    if ($qtyprf_movmov2 <> '') {
                        $cant      = convertir_a_numero($qtyprf_movmov2);
                        $nuevo_costre = (($pripro_movmov2 * $cant) / $factor_producto);
                    } else {
                        $cant      = $qtypro_movmov2;
                        $nuevo_costre = $pripro_movmov2 * $cant;
                    }
                    mysqli_query($conexion, "UPDATE movmov set costre = '$nuevo_costre' where invnum = '$invnum_movmov2' and codpro='$codpro_movmov2'");

                    if ($qtyprf_movmov2 <> '') {
                        $nuevo = $nuevo_costre / $cant_dividir;

                        mysqli_query($conexion, "UPDATE movmov set pripro = '$nuevo' where invnum = '$invnum_movmov2' and codpro='$codpro_movmov2'");
                    }
                } else {
                    if ($qtyprf_movmov2 <> '') {
                        $nuevo = $costre_movmov2 / $cant_dividir;

                        mysqli_query($conexion, "UPDATE movmov set pripro = '$nuevo' where invnum = '$invnum_movmov2' and codpro='$codpro_movmov2'");
                    }
                }
            }
        }
        $sqlmovmov3 = "SELECT invnum,sum(costre) as suma FROM movmov where invnum = '$invnum'";
        $resultmovmov3 = mysqli_query($conexion, $sqlmovmov3);
        if (mysqli_num_rows($resultmovmov3)) {
            while ($row3 = mysqli_fetch_array($resultmovmov3)) {
                $invnum_movmov3 = $row3['invnum'];
                $sumacostre_movmov3 = $row3['suma'];
                mysqli_query($conexion, "UPDATE movmae set invtot = '$sumacostre_movmov3' where invnum = '$invnum_movmov3'");
            }
        }
    }
}
