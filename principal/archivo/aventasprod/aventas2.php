<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            table.tabla2
            { 
                color: #404040;
                background-color: #FFFFFF;
                border: 1px #CDCDCD solid;
                border-collapse: collapse;
                border-spacing: 0px;}
            .Estilo4 {color: #006699; font-weight: bold; }
            .Estilo5 {color: #0066CC}
            -->
            .LETRA{
                font-family:Tahoma;
                font-size:11px;
                line-height:normal;
                color:'#5f5e5e';
                font-weight: bold;
            }
            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px; 
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
            .LETRA2{
                background:#d7d7d7
            }

        </style>
    </head>
    <?php
    $codpro = $_REQUEST['codpro'];
    for ($i = 0; $i <= 5; $i++) {
        $dates[$i] = date("d-m-Y", mktime(0, 0, 0, date("m") - $i, date("d"), date("Y"))) . '<br>';
        list($dcar, $mcar, $ycar) = split('[/.-]', $dates[$i]);
        $m[$i] = $mcar;
        $y[$i] = $ycar;
        if ($m[$i] == 1) {
            $mes[$i] = "ENE";
        }
        if ($m[$i] == 2) {
            $mes[$i] = "FEB";
        }
        if ($m[$i] == 3) {
            $mes[$i] = "MAR";
        }
        if ($m[$i] == 4) {
            $mes[$i] = "ABR";
        }
        if ($m[$i] == 5) {
            $mes[$i] = "MAY";
        }
        if ($m[$i] == 6) {
            $mes[$i] = "JUN";
        }
        if ($m[$i] == 7) {
            $mes[$i] = "JUL";
        }
        if ($m[$i] == 8) {
            $mes[$i] = "AGO";
        }
        if ($m[$i] == 9) {
            $mes[$i] = "SET";
        }
        if ($m[$i] == 10) {
            $mes[$i] = "OCT";
        }
        if ($m[$i] == 11) {
            $mes[$i] = "NOV";
        }
        if ($m[$i] == 12) {
            $mes[$i] = "DIC";
        }
    }
    $sql = "SELECT codpro,desprod,stopro,factor FROM producto where codpro = '$codpro'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row['codpro'];
            $desprod = $row['desprod'];
            $stopro = $row['stopro'];
            $factor = $row['factor'];
        }
    }
    ?>
    <body>
        <table width="935" border="0" class="tabla2">
            <tr>
                <td width="1086"><span class="text_login">PRODUCTO : <?php echo $desprod ?></span>
                    <br />
                    <img src="../../../images/line2.png" width="920" height="4" /></td>
            </tr>
        </table>
        <br />
        <table width="938" border="0">
            <tr>
                <td><table width="935" border="0" class="tabla2">
                        <tr>
                            <td width="925"><table width="741" border="0">
                                    <tr>
                                        <td width="171" class="text_gris"><span class="Estilo4">DESCRIPCION</span></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[5] ?></div></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[4] ?></div></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[3] ?></div></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[2] ?></div></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[1] ?></div></td>
                                        <td width="90" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[0] ?></div></td>
                                    </tr>
                                </table>
                                <img src="../../../images/line2.png" width="920" height="4" />
                                <table width="741" border="0">
                                    <tr>
                                        <td width="172"><span class="Estilo4">COMPRA</span></td>
                                        <td width="89"><div align="right">
<?php
$sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[5]' and year(invfec) = '$y[5]'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $sum0 = $row[0];
    }
}
if ($sum0 == "") {
    $sum0 = "0.00";
}
echo $sum0;
?>
                                            </div></td>
                                        <td width="90"><div align="right">
                                                <?php
                                                $sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[4]' and year(invfec) = '$y[4]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sum1 = $row[0];
                                                    }
                                                }
                                                if ($sum1 == "") {
                                                    $sum1 = "0.00";
                                                }
                                                echo $sum1;
                                                ?>
                                            </div></td>
                                        <td width="90"><div align="right">
                                                <?php
                                                $sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[3]' and year(invfec) = '$y[3]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sum2 = $row[0];
                                                    }
                                                }
                                                if ($sum2 == "") {
                                                    $sum2 = "0.00";
                                                }
                                                echo $sum2;
                                                ?>
                                            </div></td>
                                        <td width="90"><div align="right">
                                                <?php
                                                $sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[2]' and year(invfec) = '$y[2]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sum3 = $row[0];
                                                    }
                                                }
                                                if ($sum3 == "") {
                                                    $sum3 = "0.00";
                                                }
                                                echo $sum3;
                                                ?>
                                            </div></td>
                                        <td width="90"><div align="right">
                                                <?php
                                                $sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[1]' and year(invfec) = '$y[1]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sum4 = $row[0];
                                                    }
                                                }
                                                if ($sum4 == "") {
                                                    $sum4 = "0.00";
                                                }
                                                echo $sum4;
                                                ?>
                                            </div></td>
                                        <td width="90"><div align="right">
                                                <?php
                                                $sql = "SELECT sum(costre) FROM movmov where codpro = '$codpro' and month(invfec) = '$m[0]' and year(invfec) = '$y[0]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sum5 = $row[0];
                                                    }
                                                }
                                                if ($sum5 == "") {
                                                    $sum5 = "0.00";
                                                }
                                                echo $sum5;
                                                ?>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td><span class="Estilo4">VENTA</span></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[5]' and year(invfec) = '$y[5]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven0 = $row[0];
                                                    }
                                                }
                                                if ($ven0 == "") {
                                                    $ven0 = "0.00";
                                                }
                                                echo $ven0;
                                                ?>
                                            </div></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[4]' and year(invfec) = '$y[4]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven1 = $row[0];
                                                    }
                                                }
                                                if ($ven1 == "") {
                                                    $ven1 = "0.00";
                                                }
                                                echo $ven1;
                                                ?>
                                            </div></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[3]' and year(invfec) = '$y[3]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven2 = $row[0];
                                                    }
                                                }
                                                if ($ven2 == "") {
                                                    $ven2 = "0.00";
                                                }
                                                echo $ven2;
                                                ?>
                                            </div></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[2]' and year(invfec) = '$y[2]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven3 = $row[0];
                                                    }
                                                }
                                                if ($ven3 == "") {
                                                    $ven3 = "0.00";
                                                }
                                                echo $ven3;
                                                ?>
                                            </div></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[1]' and year(invfec) = '$y[1]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven4 = $row[0];
                                                    }
                                                }
                                                if ($ven4 == "") {
                                                    $ven4 = "0.00";
                                                }
                                                echo $ven4;
                                                ?>
                                            </div></td>
                                        <td><div align="right">
                                                <?php
                                                $sql = "SELECT sum(pripro) FROM detalle_venta where codpro = '$codpro' and month(invfec) = '$m[0]' and year(invfec) = '$y[0]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven5 = $row[0];
                                                    }
                                                }
                                                if ($ven5 == "") {
                                                    $ven5 = "0.00";
                                                }
                                                echo $ven5;
                                                ?>
                                            </div></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <br />
        <table width="938" border="0">
            <tr>
                <td width="495" valign="top"><table width="492" border="0" class="tabla2">
                        <tr>
                            <td width="495"><table width="479" border="0">
                                    <tr>
                                        <td width="61"><span class="Estilo4">FECHA</span></td>
                                        <td width="200"><span class="Estilo4">PROVEEDOR</span></td>
                                        <td width="103"><div align="right"><span class="Estilo4">PEDIDO</span></div></td>
                                        <td width="97"><div align="center"><span class="Estilo4">ESTADO</span></div></td>
                                    </tr>
                                </table>
                                <img src="../../../images/line2.png" width="485" height="4" />
                                <table width="479" border="0">
<?php
$sql = "SELECT invnum,invfec,provee,borrada,pendiente,confirmado FROM ordmae where (month(invfec) between '$m[5]' and '$m[0]') and (year(invfec) between '$y[5]' and '$y[0]') order by invfec desc, invnum desc";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row["invnum"];
        $nrocomp = $row["nrocomp"];
        $invfec = fecha($row["invfec"]);
        $provee = $row["provee"];
        $sql1 = "SELECT despro FROM proveedor where codpro = '$provee'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $desprov = $row1["despro"];
            }
        }
        $existe = 0;
        //echo $codpro;
        $sql1 = "SELECT sum(canate) FROM ordmov where codpro = '$codpro' and invnum = '$invnum'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $summ = $row1[0];
            }
        }
        if ($summ <> "") {
            $existe = 1;
        }
        if ($borrada == 1) {
            $estado = "BORRADO";
        } else {
            if ($pendiente == 1) {
                $estado = "PENDIENTE";
            } else {
                $estado = "RECIBIDO";
            }
        }
        //echo $existe;
        if ($existe == 1) {
            ?>
                                                <tr>
                                                    <td width="61"><a href="aventas2.php?codpro=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>" class="Estilo5"><?php echo $invfec ?></a></td>
                                                    <td width="200"><a href="aventas2.php?codpro=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>" class="Estilo5"><?php echo $desprov ?></a></td>
                                                    <td width="103"><div align="right" class="Estilo5"><a href="aventas2.php?codpro=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>"><?php echo $summ ?></a></div></td>
                                                    <td width="97"><div align="center" class="Estilo5"><a href="aventas2.php?codpro=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>"><?php echo $estado ?></a></div></td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                </table></td>
                        </tr>
                    </table></td>
                <td width="430" valign="top">
                    <table width="433" border="0" class="tabla2">
                        <tr>
                            <td><table width="425" border="0">
                                    <tr>
                                        <td width="79" class="Estilo4"><div align="right">DESC1</div></td>
                                        <td width="79" class="Estilo4"><div align="right">DESC2</div></td>
                                        <td width="79" class="Estilo4"><div align="right">DESC3</div></td>
                                        <td width="78" class="Estilo4"><div align="right">P UNIT </div></td>
                                        <td width="88" class="Estilo4"><div align="right">SUBTOTAL</div></td>
                                    </tr>
                                </table>
                                <img src="../../../images/line2.png" width="428" height="4" />
<?php $invnum = $_REQUEST['invnum'];
?>
                                <table width="425" border="0">
<?php
$sql1 = "SELECT desc1,desc2,desc3,precio_ref,costod FROM ordmov where codpro = '$codpro' and invnum = '$invnum'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $desc1 = $row1["desc1"];
        $desc2 = $row1["desc2"];
        $desc3 = $row1["desc3"];
        $precio_ref = $row1["precio_ref"];
        $costod = $row1["costod"];
        ?>
                                            <tr>
                                                <td width="79"><div align="right"><?php echo $desc1 ?></div></td>
                                                <td width="79"><div align="right"><?php echo $desc2 ?></div></td>
                                                <td width="79"><div align="right"><?php echo $desc3 ?></div></td>
                                                <td width="78"><div align="right"><?php echo $precio_ref ?></div></td>
                                                <td width="88"><div align="right"><?php echo $costod ?></div></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </body>
</html>
