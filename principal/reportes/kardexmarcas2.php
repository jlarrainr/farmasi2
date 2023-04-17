<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    </head>
    <?php
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $date = date('d/m/Y');
    $hour = date(G);
//$hour   = CalculaHora($hour);
    $min = date(i);
//$hor    		= date(A);
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
    $val = $_REQUEST['val'];
    $country_ID = $_REQUEST['country_ID'];
    $country = $_REQUEST['country'];
    $date1 = $_REQUEST['date1'];
    $date2 = $_REQUEST['date2'];
    $report = $_REQUEST['report'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $registros = $_REQUEST['registros'];
    $local = $_REQUEST['local'];
    $ck = $_REQUEST['ck'];
    $dat1 = $date1;
    $dat2 = $date2;
    $date1 = fecha1($date1);
    $date2 = fecha1($date2);
    if ($pagina == 1) {
        $i = 0;
    } else {
        $t = $pagina - 1;
        $i = $t * $registros;
    }

    function formato($c) {
        printf("%06d", $c);
    }

    function convertir_a_numero($str) {
        $legalChars = "%[^0-9\-\. ]%";
        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

    function valores($factor, $qtypro, $fraccion, $dato) {
        if ($factor == 1) {
            if ($qtypro <> "") {
                $cant = $qtypro;
                $descuenta = $cant * $factor;
                //$car	   = $descuenta;
                //$cant_desc = "C".$cant;
            }
            if ($fraccion <> "") {
                $cant = convertir_a_numero($fraccion);
                $descuenta = $cant;
                //$car	   = $descuenta;
                //$cant_desc = "C".$cant;
            }
        } else {
            if ($qtypro <> "") {
                $cant = $qtypro;
                $descuenta = $cant * $factor;
                //$car	   = $descuenta;
                //$cant_desc = "C".$cant;
            }
            //echo $qtypro;
            if ($fraccion <> "") {
                $cant = convertir_a_numero($fraccion);
                $descuenta = $cant;
                //$car	   = $descuenta;
                //$cant_desc = "U".$cant;
            }
        }
        if ($dato == 1) {
            return $cant;
        }
        if ($dato == 2) {
            return $descuenta;
        }
        /* if ($dato == 3)
          {
          return $car;
          }
          if ($dato == 4)
          {
          return $cant_desc;
          } */
    }

    $i = 0;
    $ff = 0;
    if($ck == 1){
    $sql = "SELECT fecha FROM kardex inner join producto on kardex.codpro = producto.codpro where fecha between '$date1' and '$date2' and (tipmov = '1' or tipmov = '2' or tipmov = '9' or (tipmov = '10' and tipdoc = '10') or tipmov = '11') and sucursal = '$local' GROUP BY fecha";
    }else{
        $sql = "SELECT fecha FROM kardex inner join producto on kardex.codpro = producto.codpro where fecha between '$date1' and '$date2' and codmar = '$country_ID' and (tipmov = '1' or tipmov = '2' or tipmov = '9' or (tipmov = '10' and tipdoc = '10') or tipmov = '11') and sucursal = '$local' GROUP BY fecha";
    }
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $ff++;
            $fecha[$ff] = $row['fecha'];
        }
    }
    if ($fecha <> "") {
        $ancho = ($ff * 3);
        $ancho = 100 / $ancho;
    }
    ?>
    <body>
        <table width="100%" border="0">
            <tr>
                <td width="1120">
                    <table width="100%" border="0">
                        <tr>
                            <td width="278"><strong><?php echo $desemp ?> </strong></td>
                            <td width="563"><div align="center"><strong>REPORTE DE KARDEX DE PRODUCTOS POR MARCA</strong></div></td>
                            <td width="278"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>
                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td width="278"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                            <td width="565"><div align="center"><b><?php
                                        if ($val == 1) {
                                            echo $country;
                                        }
                                        ?></b></div></td>
                            <td width="276"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td><div align="center"><b>
                                        <?php
                                        if ($val == 1) {
                                            echo "FECHAS ENTRE :";
                                            echo $dat1;
                                            echo " AL ";
                                            echo $dat2;
                                        }
                                        ?>
                                    </b></div></td>
                        </tr>
                    </table>
                    <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if (($val == 1)and ( $fecha <> "")) {
            ?>
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="0"  cellpadding="0" cellspacing="0" id="customers">
                            <?php
                            $t = 1;
                            /* while ($t <= $ff)
                              { */
                                if($ck == 1){
                            $sql = "SELECT kardex.codpro,desprod,codmar FROM kardex inner join producto on kardex.codpro = producto.codpro where fecha between '$date1' and  '$date2'   and (tipmov = '1' or tipmov = '2' or tipmov = '9' or (tipmov = '10' and tipdoc = '10') or tipmov = '11') and sucursal = '$local'  group by kardex.codpro,desprod,codmar order by desprod";
                                }else{
                            $sql = "SELECT kardex.codpro,desprod,codmar FROM kardex inner join producto on kardex.codpro = producto.codpro where fecha between '$date1' and  '$date2' and codmar = '$country_ID' and (tipmov = '1' or tipmov = '2' or tipmov = '9' or (tipmov = '10' and tipdoc = '10') or tipmov = '11') and sucursal = '$local'  group by kardex.codpro,desprod,codmar order by desprod";
                                }
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                ?>
                                <tr>
                                    <th width="5%" valign="bottom" rowspan="2"><strong>CODIGO</strong></th>
                                    <th width="25%" valign="bottom" rowspan="2"><strong>PRODUCTO</strong></th>
                                    <th width="10%" valign="bottom" rowspan="2"><strong>MARCA</strong></th>
                                            <?php
                                            $t = 1;
                                            $col = 0;
                                            while ($t <= $ff) {
                                                $col = $t % 2;
                                                if ($col == 1) {
                                                    $color = "#CCCCCC";
                                                } else {
                                                    $color = "#F0F0F0";
                                                }
                                                ?>
                                                <th width="40%" colspan="3" bgcolor="<?php echo $color ?>"><strong><center><?php echo fecha($fecha[$t]); ?></center></strong></th>
                                                <?php
                                                $t++;
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <?php
                                            $t = 1;
                                            $col = 0;
                                            while ($t <= $ff) {
                                                $col = $t % 2;
                                                if ($col == 1) {
                                                    $color1 = "#CCCCCC";
                                                } else {
                                                    $color1 = "#F0F0F0";
                                                }
                                                ?>
                                                <th width="13%" bgcolor="<?php echo $color1 ?>"><center><strong>Ingresos</strong></center></th>
                                                <th width="13%" bgcolor="<?php echo $color1 ?>"><center><strong>Salidas</strong></center></th>
                                                <th width="13%" bgcolor="<?php echo $color1 ?>"><center><strong>Ventas</strong></center></th>
                                                <?php
                                                $t++;
                                            }
                                            ?>
                                        </tr>
                                <?php
                                
                                while ($row = mysqli_fetch_array($result)) {
                                    $t++;
                                    $div = 0;
                                    $codpro = $row['codpro'];
                                    $desprod = $row['desprod'];
                                    $codmar = $row['codmar'];


                                    $sqlx = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                                    $resultx = mysqli_query($conexion, $sqlx);
                                    if (mysqli_num_rows($resultx)) {
                                        while ($rowx = mysqli_fetch_array($resultx)) {
                                            $marca = $rowx['destab'];
                                        }
                                    }

                                    $div = $t % 2;
                                    if ($div == 1) {
                                        $color2 = "#CCCCCC";
                                    } else {
                                        $color2 = "#F0F0F0";
                                    }
                                    ?>
                                    <tr bgcolor="<?php echo $color2; ?>">
                                        <td  valign="center"><?php echo $codpro; ?></td>
                                        <td   valign="top"><?php echo $desprod; ?></td>
                                         <td  valign="center"><?php echo $marca; ?></td> 
                                                    <?php
                                                    $yy = 1;
                                                    $col = 0;
                                                    while ($yy <= $ff) {
                                                        $fechita = $fecha[$yy];
                                                        $ingreso = 0;
                                                        $salida = 0;
                                                        $venta = 0;
                                                        $factor = 1;
                                                        $toting1 = 0;
                                                        $toting2 = 0;
                                                        $totsal1 = 0;
                                                        $totsal2 = 0;
                                                        $totvta1 = 0;
                                                        $totvta2 = 0;
                                                        $totingresos = 0;
                                                        $totsalidas = 0;
                                                        $totventa = 0;
                                                        $sqly = "SELECT tipmov,tipdoc,qtypro,fraccion,factor FROM kardex where codpro = '$codpro' and fecha = '$fechita' and (tipmov = '1' or tipmov = '2' or tipmov = '9' or (tipmov = '10' and tipdoc = '10') or tipmov = '11') and sucursal = '$local'";
                                                        $resulty = mysqli_query($conexion, $sqly);
                                                        if (mysqli_num_rows($resulty)) {
                                                            while ($rowy = mysqli_fetch_array($resulty)) {
                                                                $tipmov = $rowy['tipmov'];
                                                                $tipdoc = $rowy['tipdoc'];
                                                                $qtypro = $rowy['qtypro'];
                                                                $fraccion = $rowy['fraccion'];
                                                                $factor = $rowy['factor'];
                                                                $valor = valores($factor, $qtypro, $fraccion, 2);
                                                                if (($tipmov == 1) || ($tipmov == 11)) {
                                                                    $ingreso = $ingreso + $valor;
                                                                }
                                                                if ($tipmov == 2) {
                                                                    $salida = $salida + $valor;
                                                                }
                                                                if (($tipmov == 9) || ($tipmov == 10)) {
                                                                    $venta = $venta + $valor;
                                                                }
                                                            }
                                                            ////calculooo cajas
                                                            ///INGRESOS
                                                            $toting1 = $ingreso / $factor;
                                                            $toting2 = $ingreso % $factor;
                                                            $toting1 = explode(".", $toting1);
                                                            $toting1 = $toting1[0];
                                                            $totingresos = $toting1 . " C " . $toting2 . " U ";
                                                            /////////////////////
                                                            ///SALIDAS
                                                            $totsal1 = $salida / $factor;
                                                            $totsal2 = $salida % $factor;
                                                            $totsal1 = explode(".", $totsal1);
                                                            $totsal1 = $totsal1[0];
                                                            $totsalidas = $totsal1 . " C " . $totsal2 . " U ";
                                                            /////////////////////
                                                            ///VENTAS
                                                            $totvta1 = $venta / $factor;
                                                            $totvta2 = $venta % $factor;
                                                            $totvta1 = explode(".", $totvta1);
                                                            $totvta1 = $totvta1[0];
                                                            $totventa = $totvta1 . " C " . $totvta2 . " U ";
                                                        }

                                                        /////////////////////
                                                        $col = $yy % 2;
                                                        if ($col == 1) {
                                                            $color1 = "#CCCCCC";
                                                        } else {
                                                            $color1 = "#F0F0F0";
                                                        }
                                                        ?>
                                                        <td  bgcolor="<?php echo $color1 ?>"><center><?php echo stockcaja($ingreso,$factor); ?></center></td>
                                                        <td   bgcolor="<?php echo $color1 ?>"><center><?php echo stockcaja($salida,$factor); ?></center></td>
                                                        <td   bgcolor="<?php echo $color1 ?>"><center><?php echo stockcaja($venta,$factor); ?></center></td>
                                                        <?php
                                                        $yy++;
                                                    }
                                                    ?>
                                                
                                    </tr>
                                    <?php
                                }
                            }
                            /* else
                              {
                              ?>
                              <center>No se logrï¿½ encontrar informaciï¿½n con los datos seleccionados</center>
                              <?php
                              } */
                            /* $t++;
                              } */
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        <?php } else {
            ?>
            <div class="siniformacion">
                <center>
                    No se logro encontrar informacion con los datos ingresados
                </center>
            </div> <?php
        }
        ?>
    </body>
</html>
