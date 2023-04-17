<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
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
            .Estilo1 {color: #006699}
            .Estilo2 {color: #003366}
            .Estilo4 {
                color: #FFFFFF;
                font-weight: bold;
            }
            .Estilo5 {color: #FFFFFF}
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
    $mes = $_REQUEST['mes'];
    $anio = $_REQUEST['anio'];
    if ($mes == 1) {
        $dmes = "ENERO";
    }
    if ($mes == 2) {
        $dmes = "FEBRERO";
    }
    if ($mes == 3) {
        $dmes = "MARZO";
    }
    if ($mes == 4) {
        $dmes = "ABRIL";
    }
    if ($mes == 5) {
        $dmes = "MAYO";
    }
    if ($mes == 6) {
        $dmes = "JUNIO";
    }
    if ($mes == 7) {
        $dmes = "JULIO";
    }
    if ($mes == 8) {
        $dmes = "AGOSTO";
    }
    if ($mes == 9) {
        $dmes = "SETIEMBRE";
    }
    if ($mes == 10) {
        $dmes = "OCTUBRE";
    }
    if ($mes == 11) {
        $dmes = "NOVIEMBRE";
    }
    if ($mes == 12) {
        $dmes = "DICIEMBRE";
    }

    function UltimoDia($anho, $mes) {
        if (((fmod($anho, 4) == 0) and ( fmod($anho, 100) != 0)) or ( fmod($anho, 400) == 0)) {
            $dias_febrero = 29;
        } else {
            $dias_febrero = 28;
        }
        switch ($mes) {
            case 01: return 31;
                break;
            case 02: return $dias_febrero;
                break;
            case 03: return 31;
                break;
            case 04: return 30;
                break;
            case 05: return 31;
                break;
            case 06: return 30;
                break;
            case 07: return 31;
                break;
            case 08: return 31;
                break;
            case 09: return 30;
                break;
            case 10: return 31;
                break;
            case 11: return 30;
                break;
            case 12: return 31;
                break;
        }
    }

    $dd = UltimoDia($anio, $mes);  ////obtiene los dias del mes

    function formato($c) {
        printf("%02d", $c);
    }

    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc0 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc1 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL2'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc2 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL3'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc3 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL4'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc4 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL5'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc5 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL6'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc6 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL7'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc7 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL8'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc8 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL9'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc9 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL10'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc10 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL11'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc11 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL12'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc12 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL13'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc13 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL14'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc14 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL15'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc15 = $row[0];
        }
    }
    $sql = "SELECT codloc FROM xcompa where nomloc = 'LOCAL16'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $loc16 = $row[0];
        }
    }
//echo $dmes;
    $sql = "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM cuota where mes = '$dmes' and anio = '$anio'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $s000 = $row[0];
            $s001 = $row[1];
            $s002 = $row[2];
            $s003 = $row[3];
            $s004 = $row[4];
            $s005 = $row[5];
            $s006 = $row[6];
            $s007 = $row[7];
            $s008 = $row[8];
            $s009 = $row[9];
            $s010 = $row[10];
            $s011 = $row[11];
            $s012 = $row[12];
            $s013 = $row[13];
            $s014 = $row[14];
            $s015 = $row[15];
            $s016 = $row[16];
        }
    } else {
        $s000 = "0";
        $s001 = "0";
        $s002 = "0";
        $s003 = "0";
        $s004 = "0";
        $s005 = "0";
        $s006 = "0";
        $s007 = "0";
        $s008 = "0";
        $s009 = "0";
        $s010 = "0";
        $s011 = "0";
        $s012 = "0";
        $s013 = "0";
        $s014 = "0";
        $s015 = "0";
        $s016 = "0";
    }
    $suma1 = 0;
    $suma2 = 0;
    $suma3 = 0;
    $suma4 = 0;
    $suma5 = 0;
//echo $s000;
    ?>
    <body>
        <table width="1094" border="0" class="tabla2">
            <tr>
                <td width="1086"><span class="text_login">VENTAS - <?php echo $dmes ?> <?php echo $anio ?></span><img src="../../../images/line2.png" width="1070" height="4" />
                    <table width="1070" border="0">
                        <tr>
                            <td width="59">&nbsp;</td>
                            <td width="77"><strong>DIA</strong></td>
                            <td width="71"><div align="right"><strong>P. DIARIO </strong></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL0</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL1</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL2</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL3</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL4</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL5</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL6</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL7</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL8</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL9</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL10</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL11</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL12</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL13</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL14</span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1">LOCAL15</span></div></td>
                            <td width="45"><div align="right"><span class="Estilo1">LOCAL16</span></div></td>
                        </tr>
                    </table>
                    <img src="../../../images/line2.png" width="1070" height="4" />
                    <table width="1070" border="0">
                        <?php
                        $i = 1;
                        while ($i <= $dd) {
                            $ss = $i % 2;
                            if (($i >= 1) and ( $i <= 7)) {
                                $color = "#FFFF99";
                                if ($i == 7) {
                                    $car1 = 1;
                                } else {
                                    $car1 = 0;
                                }
                            } else {
                                $car1 = 0;
                            }
                            if (($i >= 8) and ( $i <= 14)) {
                                $color = "#CCFFCC";
                                if ($i == 14) {
                                    $car2 = 1;
                                } else {
                                    $car2 = 0;
                                }
                            } else {
                                $car2 = 0;
                            }
                            if (($i >= 15) and ( $i <= 21)) {
                                $color = "#CCCC66";
                                if ($i == 21) {
                                    $car3 = 1;
                                } else {
                                    $car3 = 0;
                                }
                            } else {
                                $car3 = 0;
                            }
                            if (($i >= 22) and ( $i <= 28)) {
                                $color = "#FFCCFF";
                                if ($i == 28) {
                                    $car4 = 1;
                                } else {
                                    $car4 = 0;
                                }
                            } else {
                                $car4 = 0;
                            }
                            if (($i >= 29) and ( $i <= 35)) {
                                $color = "#FFCC66";
                                if ($i == 35) {
                                    $car5 = 1;
                                } else {
                                    $car5 = 0;
                                }
                            } else {
                                $car5 = 0;
                            }
                            $prom = 0;
                            $dt0 = 0;
                            $dt1 = 0;
                            $dt2 = 0;
                            $dt3 = 0;
                            $dt4 = 0;
                            $dt5 = 0;
                            $dt6 = 0;
                            $dt7 = 0;
                            $dt8 = 0;
                            $dt9 = 0;
                            $dt10 = 0;
                            $dt11 = 0;
                            $dt12 = 0;
                            $dt13 = 0;
                            $dt14 = 0;
                            $dt15 = 0;
                            $dt16 = 0;
                            ?>
                            <tr bgcolor="<?php if ($ss == 1) { ?>#CCCCFF<?php } else { ?>#E5E5E5<?php } ?>">
                                <td bgcolor="<?php echo $color ?>" width="59"><?php echo formato($i);
                        echo "/";
                        echo formato($mes);
                        echo "/";
                        echo $anio; ?></td>
                                <td width="77">
                                    <span class="Estilo2">
                            <?php
                            $fecha = $i . "-" . $mes . "-" . $anio; //5 agosto de 2004 por ejemplo 
                            $fdate = $anio . "-" . $mes . "-" . $i;
                            $fechats = strtotime($fecha); //a timestamp
                            //el parametro w en la funcion date indica que queremos el dia de la semana
                            //lo devuelve en numero 0 domingo, 1 lunes,....
                            switch (date('w', $fechats)) {
                                case 0: echo "Domingo";
                                    break;
                                case 1: echo "Lunes";
                                    break;
                                case 2: echo "Martes";
                                    break;
                                case 3: echo "Miercoles";
                                    break;
                                case 4: echo "Jueves";
                                    break;
                                case 5: echo "Viernes";
                                    break;
                                case 6: echo "Sabado";
                                    break;
                            }
                            ?>
                                    </span> </td>
                                <td width="71">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT avg(invtot) FROM venta where invfec = '$fdate'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $prom = $row[0];
                                            }
                                        }
                                        echo $numero_formato_frances = number_format($prom, 2, '.', ' ');
                                        ?>
                                    </div>
                                </td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc0'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt0 = $row[0];
                                            }
                                        }
                                        echo $dt0;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc1'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt1 = $row[0];
                                            }
                                        }
                                        echo $dt1;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc2'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt2 = $row[0];
                                            }
                                        }
                                        echo $dt2;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc3'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt3 = $row[0];
                                            }
                                        }
                                        echo $dt3;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc4'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt4 = $row[0];
                                            }
                                        }
                                        echo $dt4;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc5'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt5 = $row[0];
                                            }
                                        }
                                        echo $dt5;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc6'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt6 = $row[0];
                                            }
                                        }
                                        echo $dt6;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc7'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt7 = $row[0];
                                            }
                                        }
                                        echo $dt7;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc8'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt8 = $row[0];
                                            }
                                        }
                                        echo $dt8;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc9'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt9 = $row[0];
                                            }
                                        }
                                        echo $dt9;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc10'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt10 = $row[0];
                                            }
                                        }
                                        echo $dt10;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
    <?php
    $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc11'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $dt11 = $row[0];
        }
    }
    echo $dt11;
    ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
    <?php
    $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc12'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $dt12 = $row[0];
        }
    }
    echo $dt12;
    ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc13'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt13 = $row[0];
                                            }
                                        }
                                        echo $dt13;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc14'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt14 = $row[0];
                                            }
                                        }
                                        echo $dt14;
                                        ?>
                                    </div></td>
                                <td width="46">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc15'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt15 = $row[0];
                                            }
                                        }
                                        echo $dt15;
                                        ?>
                                    </div></td>
                                <td width="45">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where invfec = '$fdate' and sucursal = '$loc16'";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $dt16 = $row[0];
                                            }
                                        }
                                        echo $dt16;
                                        $suma = $dt0 + $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12 + $dt13 + $dt14 + $dt15 + $dt16;
                                        $colum0 = $colum0 + $dt0;
                                        $colum1 = $colum1 + $dt1;
                                        $colum2 = $colum2 + $dt2;
                                        $colum3 = $colum3 + $dt3;
                                        $colum4 = $colum4 + $dt4;
                                        $colum5 = $colum5 + $dt5;
                                        $colum6 = $colum6 + $dt6;
                                        $colum7 = $colum7 + $dt7;
                                        $colum8 = $colum8 + $dt8;
                                        $colum9 = $colum9 + $dt9;
                                        $colum10 = $colum10 + $dt10;
                                        $colum11 = $colum11 + $dt11;
                                        $colum12 = $colum12 + $dt12;
                                        $colum13 = $colum13 + $dt13;
                                        $colum14 = $colum14 + $dt14;
                                        $colum15 = $colum15 + $dt15;
                                        $colum16 = $colum16 + $dt16;
                                        if ($car1 == 1) {
                                            $suma1 = $suma1 + $suma;
                                        }
                                        if ($car2 == 1) {
                                            $suma2 = $suma2 + $suma;
                                        }
                                        if ($car3 == 1) {
                                            $suma3 = $suma3 + $suma;
                                        }
                                        if ($car4 == 1) {
                                            $suma4 = $suma4 + $suma;
                                        }
                                        if ($car5 == 1) {
                                            $suma5 = $suma5 + $suma;
                                        }
                                        ?>
                                    </div></td>
                            </tr>
    <?php
    if ($car1 == 1) {
        ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td bgcolor="#FFFF33"><b>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($suma1, 2, '.', ' '); ?></div></b></td>
                                    <td> </td>
                                </tr>
    <?php
    }
    if ($car2 == 1) {
        ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td bgcolor="#FFFF33"><b>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($suma2, 2, '.', ' '); ?></div></b></td>
                                    <td></td>
                                </tr>
    <?php
    }
    if ($car3 == 1) {
        ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td bgcolor="#FFFF33"><b>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($suma3, 2, '.', ' '); ?></div></b></td>
                                    <td></td>
                                </tr>
    <?php
    }
    if ($car4 == 1) {
        ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td bgcolor="#FFFF33"><b>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($suma4, 2, '.', ' '); ?></div></b></td>
                                    <td></td>
                                </tr>
    <?php
    }
    if ($i == $dd) {
        ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td bgcolor="#FFFF33"><b>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($suma5, 2, '.', ' '); ?></div></b></td>
                                    <td></td>
                                </tr>
    <?php
    }
    $i++;
}
$sumtotal = $colum0 + $colum1 + $colum2 + $colum3 + $colum4 + $colum5 + $colum6 + $colum7 + $colum8 + $colum9 + $colum10 + $colum11 + $colum12 + $colum13 + $colum14 + $colum15 + $colum16;
?>
                    </table>
                    <table width="1070" border="0" bgcolor="#000000">
                        <tr>
                            <td width="58"><span class="Estilo5"><strong>CUOTAS</strong></span></td>
                            <td width="77"><span class="Estilo5"></span></td>
                            <td width="71"><span class="Estilo5"></span></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s000, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s001, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s002, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s003, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s004, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s005, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s006, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s007, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s008, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s009, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s010, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s011, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s012, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s013, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s014, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s015, 2, '.', ' '); ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5"><?php echo $numero_formato_frances = number_format($s016, 2, '.', ' '); ?></span></div></td>
                        </tr>
                    </table>
                    <table width="1070" border="0" bgcolor="#006699">
                        <tr>
                            <td width="58"><span class="Estilo4">VENTAS</span></td>
                            <td width="77"><div align="right" class="Estilo4"><?php echo $numero_formato_frances = number_format($sumtotal, 2, '.', ' '); ?></div></td>
                            <td width="71"><span class="Estilo5"></span></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum0, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum1, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum2, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum3, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum4, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum5, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum6, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum7, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum8, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum9, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum10, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum11, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum12, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum13, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum14, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum15, 2, '.', ' '); ?></div></td>
                            <td width="46"><div align="right" class="Estilo5"><?php echo $numero_formato_frances = number_format($colum16, 2, '.', ' '); ?></div></td>
                        </tr>
                    </table>
                    <table width="1070" border="0" bgcolor="#660000">
                        <tr>
                            <td width="58"><span class="Estilo5"><strong>%</strong></span></td>
                            <td width="77"><span class="Estilo5"></span></td>
                            <td width="71"><span class="Estilo5"></span></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s000 <> 0) {
                                            $t0 = (($colum0 / $s000) * 100) - 100;
                                        } else {
                                            $t0 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t0, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s001 <> 0) {
                                            $t1 = (($colum1 / $s001) * 100) - 100;
                                        } else {
                                            $t1 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t1, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s002 <> 0) {
                                            $t2 = (($colum2 / $s002) * 100) - 100;
                                        } else {
                                            $t2 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t2, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s003 <> 0) {
                                            $t3 = (($colum3 / $s003) * 100) - 100;
                                        } else {
                                            $t3 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t3, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s004 <> 0) {
                                            $t4 = (($colum4 / $s004) * 100) - 100;
                                        } else {
                                            $t4 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t4, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s005 <> 0) {
                                            $t5 = (($colum5 / $s005) * 100) - 100;
                                        } else {
                                            $t5 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t5, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s006 <> 0) {
                                            $t6 = (($colum6 / $s006) * 100) - 100;
                                        } else {
                                            $t6 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t6, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s007 <> 0) {
                                            $t7 = (($colum7 / $s007) * 100) - 100;
                                        } else {
                                            $t7 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t7, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s008 <> 0) {
                                            $t8 = (($colum8 / $s008) * 100) - 100;
                                        } else {
                                            $t8 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t8, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s009 <> 0) {
                                            $t9 = (($colum9 / $s009) * 100) - 100;
                                        } else {
                                            $t9 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t9, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s010 <> 0) {
                                            $t10 = (($colum10 / $s0010) * 100) - 100;
                                        } else {
                                            $t10 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t10, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s011 <> 0) {
                                            $t11 = (($colum11 / $s0011) * 100) - 100;
                                        } else {
                                            $t11 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t11, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s012 <> 0) {
                                            $t12 = (($colum12 / $s0012) * 100) - 100;
                                        } else {
                                            $t12 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t12, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s013 <> 0) {
                                            $t13 = (($colum13 / $s0013) * 100) - 100;
                                        } else {
                                            $t13 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t13, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s014 <> 0) {
                                            $t14 = (($colum14 / $s0014) * 100) - 100;
                                        } else {
                                            $t14 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t14, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s015 <> 0) {
                                            $t15 = (($colum15 / $s0015) * 100) - 100;
                                        } else {
                                            $t15 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t15, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                            <td width="46"><div align="right"><span class="Estilo5">
                                        <?php
                                        if ($s016 <> 0) {
                                            $t16 = (($colum16 / $s0016) * 100) - 100;
                                        } else {
                                            $t16 = 0;
                                        }
                                        echo $numero_formato_frances = number_format($t16, 2, '.', ' ');
                                        ?>
                                    </span></div></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </body>
</html>
