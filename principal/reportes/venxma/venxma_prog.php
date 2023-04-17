<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    </head>
    <?php
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $date = date('d/m/Y');
    $hour = date("G") - 5;
    $hour = CalculaHora($hour);
    $min = date("i");
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
    $val = $_REQUEST['val'];
    $date1 = fecha1($_REQUEST['date1']);
    $date2 = fecha1($_REQUEST['date2']);
    $local = $_REQUEST['local'];
    $det = $_REQUEST['det'];
    $ltdgen = $_REQUEST['ltdgen'];
    $marca = $_REQUEST['marca'];

    $doc = $_REQUEST['doc'];
    $ven = $_REQUEST['ven'];

    if ($local <> 'all') {
        $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomloc = $row['nomloc'];
                $nombre = $row['nombre'];
            }
        }
        if ($nombre <> "") {
            $nomloc = $nombre;
        }
    }


    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL0'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre1 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL1'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre2 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL2'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre3 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL3'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre4 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL4'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre5 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL5'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre6 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL6'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre7 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL7'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre8 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL8'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre9 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL9'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre10 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL10'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre11 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL11'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre12 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL12'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre13 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL13'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre14 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL14'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre15 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL15'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre16 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL16'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre17 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL17'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre18 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL18'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre19 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL19'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre20 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL20'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre21 = $row1['nombre'];
        }
    }
    ?>
    <body>
        <table width="930" border="0" align="center">
            <tr>
                <td><table width="914" border="0">
                        <tr>
                            <td><strong><?php echo $desemp ?></strong></td>
                            <td><div align="center"><strong>REPORTE DE RENTABILIDAD </strong></div></td>
                            <td>&nbsp;</td>
                            <td><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>
                        <tr>
                            <td width="361"><strong>PAGINA # </strong></td>
                            <td width="221"><div align="center">
                                    <?php
                                    if ($local == 'all') {
                                        echo 'TODAS LAS SUCURSALES';
                                    } else {
                                        echo $nomloc;
                                    }
                                    ?>
                                </div></td>
                            <td width="30">&nbsp;</td>
                            <td width="284"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span> </div></td>
                        </tr>

                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="910" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if ($val == 1) {
            ?>
            <table width="926" border="0" align="center">
                <tr>
                    <td><div align="center"><strong> VENTA POR LABORATORIO EN UNIDADES DE PRODUCTO</strong></div></td>
                </tr>
            </table>

            <table width="1390" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><table width="1390" border="0" align="center">
                            <tr>
                                <td width="29"><strong>N&ordm;</strong></td>
                                <td width="170"><strong>PRODUCTO</strong></td>

                                <td width="45"><strong>MARCA</strong></td>
                                <?php if ($doc == 1) { ?><td width="50"><div align="center"><strong>UND V.</strong></div></td><?php } ELSEif ($doc == 3) { ?><td width="56"><div align="center"><strong>UND V.</strong></div></td><?php } ?>
                                <?php if ($doc == 2) { ?><td width="50"><div align="center"><strong>S/ V.</strong></div></td><?php } ELSEIF ($doc == 3) { ?><td width="56"><div align="center"><strong>S/ V.</strong></div></td><?php } ?>

                                <?php if ($ven == 1) { ?><td width="50"><div align="center"><strong>VEND.</strong></div></td><?php } ELSEif ($ven == 3) { ?><td width="56"><div align="center"><strong>VEND.</strong></div></td><?php } ?>
                                <?php if ($ven == 2) { ?><td width="50"><div align="center"><strong>LOCAL</strong></div></td><?php } ELSEIF ($ven == 3) { ?><td width="56"><div align="center"><strong>LOCAL</strong></div></td><?php } ?>

                                <td style="font-size:10px" width="40"><div align="right"><strong><?php if ($nombre1 == "") { ?>LOCAL0<?php
                                            } else {
                                                echo $nombre1;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre2 == "") { ?>LOCAL1<?php
                                            } else {
                                                echo $nombre2;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre3 == "") { ?>LOCAL2<?php
                                            } else {
                                                echo $nombre3;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre4 == "") { ?>LOCAL3<?php
                                            } else {
                                                echo $nombre4;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre5 == "") { ?>LOCAL4<?php
                                            } else {
                                                echo $nombre5;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre6 == "") { ?>LOCAL5<?php
                                            } else {
                                                echo $nombre6;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre7 == "") { ?>LOCAL6<?php
                                            } else {
                                                echo $nombre7;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre8 == "") { ?>LOCAL7<?php
                                            } else {
                                                echo $nombre8;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre9 == "") { ?>LOCAL8<?php
                                            } else {
                                                echo $nombre9;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre10 == "") { ?>LOCAL9<?php
                                            } else {
                                                echo $nombre10;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre11 == "") { ?>LOCAL10<?php
                                            } else {
                                                echo $nombre11;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre12 == "") { ?>LOCAL11<?php
                                            } else {
                                                echo $nombre12;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre13 == "") { ?>LOCAL12<?php
                                            } else {
                                                echo $nombre13;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre14 == "") { ?>LOCAL13<?php
                                            } else {
                                                echo $nombre14;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre15 == "") { ?>LOCAL14<?php
                                            } else {
                                                echo $nombre15;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre16 == "") { ?>LOCAL15<?php
                                            } else {
                                                echo $nombre16;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre17 == "") { ?>LOCAL16<?php
                                            } else {
                                                echo $nombre17;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre18 == "") { ?>LOCAL17<?php
                                            } else {
                                                echo $nombre18;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre19 == "") { ?>LOCAL18<?php
                                            } else {
                                                echo $nombre19;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre20 == "") { ?>LOCAL19<?php
                                            } else {
                                                echo $nombre20;
                                            }
                                            ?></strong></div></td>
                                <td style="font-size:10px" width="40" ><div align="right"><strong><?php if ($nombre21 == "") { ?>LOCAL20<?php
                                            } else {
                                                echo $nombre21;
                                            }
                                            ?></strong></div></td>
                                <td width="50"><div align="right"><strong>TOTAL</strong></div></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
            <table width="1390" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <?php
                    $SumGenPripro = 0;
                    $SumGenPCosto = 0;
                    $SumGenRentab = 0;

                    if ($marca == 'all') {
                        //$sql1="SELECT codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0' group by codmar, codpro";
                        $sql1 = "SELECT codmar, codpro,detalle_venta.usecod FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and val_habil = '0' group by codmar, codpro";
                    } else {
                        //$sql1="SELECT codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and codmar = '$marca' and val_habil = '0' and invtot <> '0' group by codmar, codpro";
                        $sql1 = "SELECT codmar, codpro,detalle_venta.usecod FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and codmar = '$marca' and val_habil = '0' group by codmar, codpro";
                    }

                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {

                            $codmar = $row1['codmar'];
                            $codpro = $row1['codpro'];
                            $usecodD = $row1['usecod'];
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $destab = $row2['destab'];
                                    $abrev = $row2['abrev'];
                                    if ($abrev <> '') {
                                        $destab = $abrev;
                                    }
                                }
                            }

                            $sql2 = "SELECT abrev,codloc from usuario WHERE usecod ='$usecodD' ";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $abrevVV = $row2['abrev'];
                                    $codlocc = $row2['codloc'];

                                    if ($codlocc == '1') {
                                        $x = 1;
                                        $loca = "fdfwd";
                                    }if ($codlocc == '2') {
                                        $x = 2;
                                    }if ($codlocc == '3') {
                                        $x = 3;
                                    }if ($codlocc == '4') {
                                        $x = 4;
                                    }if ($codlocc == '5') {
                                        $x = 5;
                                    }if ($codlocc == '6') {
                                        $x = 6;
                                    }if ($codlocc == '7') {
                                        $x = 7;
                                    }if ($codlocc == '8') {
                                        $x = 8;
                                    }if ($codlocc == '9') {
                                        $x = 9;
                                    }if ($codlocc == '10') {
                                        $x = 10;
                                    }if ($codlocc == '11') {
                                        $x = 11;
                                    }if ($codlocc == '12') {
                                        $x = 12;
                                    }if ($codlocc == '13') {
                                        $x = 13;
                                    }if ($codlocc == '14') {
                                        $x = 14;
                                    }if ($codlocc == '15') {
                                        $x = 15;
                                    }if ($codlocc == '16') {
                                        $x = 16;
                                    }if ($codlocc == '17') {
                                        $x = 17;
                                    }if ($codlocc == '18') {
                                        $x = 18;
                                    }if ($codlocc == '19') {
                                        $x = 19;
                                    }if ($codlocc == '20') {
                                        $x = 20;
                                    }if ($codlocc == '21') {
                                        $x = 21;
                                    }
                                }
                            }



                            $sql2 = "SELECT codpro,desprod,codmar,codfam,factor,margene,costre,costpr,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,SUM(s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020) as suma FROM producto where codpro = '$codpro' and eliminado='0'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row = mysqli_fetch_array($result2)) {
                                    $product = $row['desprod'];
                                    $codmar = $row['codmar'];
                                    $codfam = $row['codfam'];
                                    $factor = $row['factor'];
                                    $margene = $row['margene'];
                                    $costre = $row['costre'];
                                    $costpr = $row['costpr'];
                                    $s000 = $row['s000'];
                                    $s001 = $row['s001'];
                                    $s002 = $row['s002'];
                                    $s003 = $row['s003'];
                                    $s004 = $row['s004'];
                                    $s005 = $row['s005'];
                                    $s006 = $row['s006'];
                                    $s007 = $row['s007'];
                                    $s008 = $row['s008'];
                                    $s009 = $row['s009'];
                                    $s010 = $row['s010'];
                                    $s011 = $row['s011'];
                                    $s012 = $row['s012'];
                                    $s013 = $row['s013'];
                                    $s014 = $row['s014'];
                                    $s015 = $row['s015'];
                                    $s016 = $row['s016'];
                                    $s017 = $row['s017'];
                                    $s018 = $row['s018'];
                                    $s019 = $row['s019'];
                                    $s020 = $row['s020'];
                                    $suma = $row['suma'];
                                }
                            }

                            $sql2 = "SELECT nombre FROM xcompa where codloc = '$codlocc'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $n = $row2['nombre'];
                                }
                            }
                            $sql2 = "SELECT pripro,canpro,fraccion,factor,cospro,prisal,costpr FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codmar = '$codmar' and codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and val_habil = '0' ";

                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $pripro = $row2['pripro'];
                                    $canpro = $row2['canpro'];
                                    $fraccion = $row2['fraccion'];
                                    $factor = $row2['factor'];
                                    $pcostouni = $row2['costpr'];
                                    $prisal = $row2['prisal'];
                                    $costpr = $row2['costpr'];
                                    $SOLES = $canpro * $prisal;
                                    $tot = 0;
                                    //$precio_costo     = $pcostouni;
                                    //FRACCIONADO
                                    /* if ($fraccion == "T") 
                                      {
                                      $RentPorcent    = (($prisal - $costpr) * $canpro);
                                      $Rentabilidad   =  $Rentabilidad + $RentPorcent;
                                      $porcent        = ($Rentabilidad / $costpr) * 100;
                                      $canprod        = $canprod + $canpro;
                                      $tot            = $tot + $canpro;
                                      //$precio_costo   = $costpr;
                                      $precio_costo = $pcostouni;
                                      }
                                      else
                                      {
                                      //NO FRACCIONADO
                                      //$precio_costo = $pcostouni/$factor;
                                      //$canpros   = $canpro * $factor;
                                      //$tot	   = $tot + $canpros;
                                      $RentPorcent    = (($prisal - $pcostouni) * $canpro);
                                      $Rentabilidad   = $Rentabilidad + $RentPorcent;
                                      $porcent        = ($Rentabilidad / $pcostouni) * 100;
                                      $canprod1       = $canprod1 + $canpro;
                                      $canpros        = $canpro * $factor;
                                      $tot            = $tot + $canpros;
                                      $precio_costo   = $pcostouni / $factor;
                                      }
                                      $SumPorcent = $SumPorcent + $porcent;
                                      $sumpripro = $sumpripro + $pripro;
                                      $sumpcosto = $precio_costo * $tot;
                                      $sumpcosto1 = $sumpcosto1 + $sumpcosto; */

                                    /* $tot          = 0;
                                      $precio_costo = $pcostouni;
                                      if ($fraccion == "T")
                                      {
                                      $canprod = $canprod + $canpro;
                                      $tot	 = $tot + $canpro;

                                      }
                                      else
                                      {
                                      $canprod1 = $canprod1 + $canpro;
                                      $canpros  = $canpro * $factor;
                                      $tot	  = $tot + $canpros;
                                      //$precio_costo = $pcostouni/$factor;
                                      //$precio_costo = number_format($precio_costo,2,',','.');
                                      }
                                      $sumpripro = $sumpripro + $pripro;
                                      $sumpcosto = $precio_costo * $tot;
                                      $sumpcosto1= $sumpcosto1 + $sumpcosto; */
                                }
                            }
                            //echo $tot; echo " "; echo $sumpcosto1; echo " , ";
                            /* $rentabilidad = $sumpripro - $sumpcosto1;
                              $porcentaje = 0;
                              if ($sumpcosto1 <> 0){
                              $porcentaje   = (($sumpripro - $sumpcosto1)/$sumpcosto1)*100;
                              } */
                            //$rentabilidad       = $Rentabilidad;
                            //$porcentaje         = $SumPorcent;
                            /*  $rentabilidad 	= $Rentabilidad;
                              $porcentaje 	= ($Rentabilidad / $sumpcosto1) * 100;
                              $SumGenPripro 	= $SumGenPripro + $sumpripro;
                              $SumGenPCosto 	= $SumGenPCosto + $sumpcosto1;
                              $SumGenRentab 	= $SumGenRentab + $rentabilidad; */
                            $i++;
                            ?>
                            <tr>
                                <td width="20"><?php echo $i ?></td>
                                <td width="160"><div align="left"><?php echo $product ?></div></td>
                                <td width="55"><div align="left"><?php echo $destab ?></div></td>

                                <?php if ($doc == 1) { ?><td width="45">  <?php echo $canpro ?></td><?php } ELSEif ($doc == 3) { ?><td width="45">  <?php echo $canpro ?></td><?php } ?>
                                <?php if ($doc == 2) { ?><td width="45"> <?php echo "S/" . $SOLES; ?> </td><?php } ELSEif ($doc == 3) { ?><td width="45"> <?php echo "S/" . $SOLES; ?> </td><?php } ?>

                                <?php if ($ven == 1) { ?><td width="35">  <?php echo $x . " - " . $abrevVV; ?></td><?php } ELSEif ($ven == 3) { ?><td width="35">  <?php echo $x . " - " . $abrevVV; ?></td><?php } ?>
                                <?php if ($ven == 2) { ?><td width="35"> <?php echo $n; ?> </td><?php } ELSEif ($ven == 3) { ?><td width="35"> <?php echo $n; ?> </td><?php } ?>


                                <td width="35"><div align="right"><?php echo $s000 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s001 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s002 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s003 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s004 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s005 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s006 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s007 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s008 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s009 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s010 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s011 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s012 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s013 ?></div></td>
                                <td width="35"><div align="right"><?php echo $s014 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s015 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s016 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s017 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s018 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s019 ?></div></td>
                                <td width="40"><div align="right"><?php echo $s020 ?></div></td>

                                <td width="40"><div align="right"><?php echo $suma ?></div></td>


                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                        ?>
        <!--                        <tr>
        <td colspan="4"><center>TOTAL</center></td>
        <td width="103"><div align="right"><?php echo $numero_formato_frances = number_format($SumGenPripro, 2, '.', ' '); ?></div></td>
        <td width="100"><div align="right"><?php echo $numero_formato_frances = number_format($SumGenPCosto, 2, '.', ' '); ?></div></td>
        <td width="97"><div align="right"><?php echo $numero_formato_frances = number_format($SumGenRentab, 2, '.', ' '); ?></div></td>
        <td width="100"></td>
        </tr>-->
                        <?php
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
            </table>
            </td>
            </tr>
            </table>
            <?php
        }
        ?>
    </body>
</html>
