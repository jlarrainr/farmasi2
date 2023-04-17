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

    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
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
$hour = date(G);
//$date	= CalculaFechaHora($hour); 
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min = date(i);
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$country = $_REQUEST['country'];
$report = $_REQUEST['report'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros = $_REQUEST['registros'];

function formato($c)
{
    printf("%06d", $c);
}

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}

if ($val == 2) {
    $sql = "SELECT destab FROM titultabladet where codtab = '$search'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $country = $row['destab'];
        }
    }
}

$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
    }
}
?>

<body>
    <table width="100%" border="0">
        <tr>
            <td width="100%">
                <table width="100%" border="0">
                    <tr>
                        <td width="278"><strong><?php echo $desemp ?> </strong></td>
                        <td width="563">
                            <div align="center"><strong>REPORTE DE STOCK DE PRODUCTOS</strong></div>
                        </td>
                        <td width="278">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="278">&nbsp;</td>
                        <td width="565">
                            <div align="center"><b><?php
                                                    echo $country;
                                                    ?></b></div>
                        </td>
                        <td width="276">
                            <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if (($val == 1) || ($val == 2)) {
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL0'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[0] = 'LC0';
                } else {
                    $des[0] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL1'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[1] = 'LC1';
                } else {
                    $des[1] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL2'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[2] = 'LC2';
                } else {
                    $des[2] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL3'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[3] = 'LC3';
                } else {
                    $des[3] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL4'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[4] = 'LC4';
                } else {
                    $des[4] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL5'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[5] = 'LC5';
                } else {
                    $des[5] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL6'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[6] = 'LC6';
                } else {
                    $des[6] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL7'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[7] = 'LC7';
                } else {
                    $des[7] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL8'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[8] = 'LC8';
                } else {
                    $des[8] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL9'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[9] = 'LC9';
                } else {
                    $des[9] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL10'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[10] = 'LC10';
                } else {
                    $des[10] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL11'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[11] = 'LC11';
                } else {
                    $des[11] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL12'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[12] = 'LC12';
                } else {
                    $des[12] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL13'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[13] = 'LC13';
                } else {
                    $des[13] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL14'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[14] = 'LC14';
                } else {
                    $des[14] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL15'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[15] = 'LC15';
                } else {
                    $des[15] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL16'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[16] = 'LC16';
                } else {
                    $des[16] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL17'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[17] = 'LC17';
                } else {
                    $des[17] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL18'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[18] = 'LC18';
                } else {
                    $des[18] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL19'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[19] = 'LC19';
                } else {
                    $des[19] = substr($nomlocs, 0, 3);
                }
            }
        }
        $sql = "SELECT codloc,nombre FROM xcompa where nomloc = 'LOCAL20'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomlocs = $row['nombre'];
                if ($nomlocs == '') {
                    $des[20] = 'LC20';
                } else {
                    $des[20] = substr($nomlocs, 0, 3);
                }
            }
        }
    ?>

        <table width="98%" border="1" cellpadding="0" cellspacing="0" id="customers">

            <tr align="center">
                <th width="20"><strong>N</strong></th>
                <th width="20"><strong>CODIGO</strong></th>
                <th width="220"><strong>PRODUCTO</strong></th>
                <th width="20"><strong>FACTOR</strong></th>
                <th width="100">
                    <div><strong>MARCA</strong></div>
                </th>
                <?php for ($i = 0; $i <= $nlicencia; $i++) { ?>

                    <th width="33">
                        <div><?php echo $des[$i]; ?></div>
                    </th>
                <?php
                }
                ?>
                <th width="43">
                    <div><strong>TOTAL</strong></div>
                </th>
            </tr>
            <?php
            //echo $country;
            $contador = 0;
            if ($val == 1) {
                $sql = "SELECT codpro,desprod,codmar,stopro,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,factor FROM producto WHERE codpro='$search' and eliminado='0' order by desprod";
            } else {
                $sql = "SELECT codpro,desprod,codmar,stopro,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,factor FROM producto inner join titultabladet on codtab = codmar where codtab='$search' and tiptab = 'M' and producto.eliminado='0' order by desprod";
            }
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($rowProducto = mysqli_fetch_array($result)) {
                    $contador++;
                    $abrev = "";
                    $destab = "";
                    $stopro1 = 0;
                    $s000 = 0;
                    $s001 = 0;
                    $s002 = 0;
                    $s003 = 0;
                    $s004 = 0;
                    $s005 = 0;
                    $s006 = 0;
                    $s007 = 0;
                    $s008 = 0;
                    $s009 = 0;
                    $s010 = 0;
                    $s011 = 0;
                    $s012 = 0;
                    $s013 = 0;
                    $s014 = 0;
                    $s015 = 0;
                    $s016 = 0;
                    $s017 = 0;
                    $s018 = 0;
                    $s019 = 0;
                    $s020 = 0;
                    $codpro = $rowProducto['codpro'];
                    $desprod = $rowProducto['desprod'];
                    $codmar = $rowProducto['codmar'];
                    $s000 = $rowProducto['s000'];
                    $s001 = $rowProducto['s001'];
                    $s002 = $rowProducto['s002'];
                    $s003 = $rowProducto['s003'];
                    $s004 = $rowProducto['s004'];
                    $s005 = $rowProducto['s005'];
                    $s006 = $rowProducto['s006'];
                    $s007 = $rowProducto['s007'];
                    $s008 = $rowProducto['s008'];
                    $s009 = $rowProducto['s009'];
                    $s010 = $rowProducto['s010'];
                    $s011 = $rowProducto['s011'];
                    $s012 = $rowProducto['s012'];
                    $s013 = $rowProducto['s013'];
                    $s014 = $rowProducto['s014'];
                    $s015 = $rowProducto['s015'];
                    $s016 = $rowProducto['s016'];
                    $s017 = $rowProducto['s017'];
                    $s018 = $rowProducto['s018'];
                    $s019 = $rowProducto['s019'];
                    $s020 = $rowProducto['s020'];
                    $stopro = $rowProducto['stopro'];
                    $factor = $rowProducto['factor'];
                    $stopro1 = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016 + $s017 + $s018 + $s019 + $s020;

                  
                    //echo $qtypro;
                    if ($fraccion <> "") {
                        $cant = convertir_a_numero($fraccion);
                        $descuenta = $cant;
                        $car = $descuenta;
                        $cant_desc = "f" . $cant;
                    }

                    if ($codmar <> 0) {

                        $sql1 = "SELECT abrev,destab FROM titultabladet where codtab = '$codmar'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $abrev = $row1['abrev'];
                                $destab = $row1['destab'];
                            }
                        } else {
                            $abrev == "";
                        }
                        if ($abrev == "") {
                            $abrev = $destab;
                        }
                    } else {
                        $abrev = "";
                    }
            ?>
                    <tr align="center">
                        <td><?php echo $contador; ?></td>
                        <td><?php echo $codpro; ?></td>                        
                        <td   align="left"><?php echo $desprod ?></>
                        <td> <?php echo $factor; ?> </td>
                        <td width="70"><?php echo $abrev; ?></td>

                        <?php
                        $ii = 0;
                        for ($i = 0; $i <= $nlicencia; $i++) {
                            $ii = 4 + $i;
                        ?>

                            <td width="33">
                                <div><?php echo stockcaja($rowProducto[$ii], $factor); ?></div>
                            </td>
                        <?php
                        }
                        ?>


                        <td width="45">
                            <div><?php echo   stockcaja($stopro1, $factor);   ?></div>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <center><br /><br /><br /><br />NO SE PUDO ENCONTRAR INFORMACIï¿½N CON LOS DATOS INGRESADOS</center>
            <?php }
            ?>
        </table>
        <br>
        <br>
        <br>
        <br>
    <?php }
    ?>
</body>

</html>