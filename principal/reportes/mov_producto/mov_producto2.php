<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
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

        .texto {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            color: #e88227;
            font-size: 18px;
            font-weight: 900;
        }

        .crear {
            background-color: #b6f77f;
        }

        .actualiza {
            background-color: #f7bf7f;
        }

        .elimina {
            background-color: #f7957f;
        }
    </style>
</head>
<?php
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$val = $_REQUEST['val'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$opcion = $_REQUEST['opcion'];
$local = $_REQUEST['local'];
$date = date('d/m/Y');
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}

if ($opcion == 1) {
    $loca_text = 'LISTA DE PRODUCTOS CREADOS';
    $op_local = 'local_add';
    $op_usuario = 'usuario_add';
    $op_fecha = 'fecha_add';
    $op_hora = 'hora_add';
    $class = 'crear';
} elseif ($opcion == 2) {
    $loca_text = 'LISTA DE PRODUCTOS ACTUALIZADOS';
    $op_local = 'local_up';
    $op_usuario = 'usuario_up';
    $op_fecha = 'fecha_up';
    $op_hora = 'hora_up';
    $class = 'actualiza';
} elseif ($opcion == 3) {
    $loca_text = 'LISTA DE PRODUCTOS ELIMINADOS';
    $op_local = 'local_d';
    $op_usuario = 'usuario_d';
    $op_fecha = 'fecha_d';
    $op_hora = 'hora_d';
    $class = 'elimina';
} else {
    $loca_text = 'LISTA DE TODOS LOS MOVIMIENTOS';
}
$dat1 = $date1;
$dat2 = $date2;
if (strlen($date1) > 0) {
    $date1 = fecha1($date1);
}
if (strlen($date2) > 0) {
    $date2 = fecha1($date2);
}

?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td width="100%">
                <table width="100%" border="0">
                    <tr>
                        <td width="278"><strong><?php echo $desemp ?> </strong></td>
                        <td width="563">
                            <div align="center"><strong>REPORTE REGISTROS DE PRODUCTOS</strong></div>
                        </td>
                        <td width="278">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="center">
                            </div>
                        </td>
                        <td>
                            <div align="center"><b>
                                    <?php
                                    if ($val == 1) {
                                        echo "FECHAS ENTRE :";
                                        echo $dat1;
                                        echo " AL : ";
                                        echo $dat2;
                                    }
                                    ?>
                                </b>
                            </div>
                        </td>
                        <td width="276">
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>



                </table>
                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>

                <?php if ($opcion <> 4) { ?>
                    <table width="100%" id="customers">

                        <?php
                        if ($local == 'all') {
                            $sql = "SELECT codpro,$op_local,$op_usuario,$op_fecha,$op_hora FROM mov_producto where $op_fecha between '$date1' and '$date2' order by $op_fecha";
                            // echo 1;
                        } else {
                            $sql = "SELECT codpro,$op_local,$op_usuario,$op_fecha,$op_hora FROM mov_producto where $op_fecha between '$date1' and '$date2'  and $op_local = '$local'  order by $op_fecha";
                            // echo 2;
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) { ?>
                            <tr>
                                <td colspan="9">
                                    <div align='center' class="texto">
                                        <?php echo $loca_text; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>N</th>
                                <th>CODIGO</th>
                                <th>PRODUCTO</th>
                                <th>FACTOR</th>
                                <th>MARCA</th>
                                <th>LOCAL</th>
                                <th>USUARIO</th>
                                <th>FECHA</th>
                                <th>HORA</th>
                            </tr>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                $i++;
                                $codpro = $row['codpro'];
                                $mov_local = $row[1];
                                $mov_usuario = $row[2];
                                $mov_fecha = $row[3];
                                $mov_hora = $row[4];

                                $sql1 = "SELECT desprod,factor,codmar FROM producto where codpro = '$codpro' and eliminado='0'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $desprod = $row1['desprod'];
                                        $factor = $row1['factor'];
                                        $codmar = $row1['codmar'];
                                    }
                                }
                                $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $destab = $row2['destab'];
                                        $abrev = $row2['abrev'];
                                        if ($abrev <> '') {
                                            $destab = $abrev;
                                        }
                                    }
                                }
                                $sqlxcompa = "SELECT nombre FROM xcompa where codloc = '$mov_local'";
                                $resultxcompa = mysqli_query($conexion, $sqlxcompa);
                                if (mysqli_num_rows($resultxcompa)) {
                                    while ($rowxcompa = mysqli_fetch_array($resultxcompa)) {
                                        $nombre = $rowxcompa['nombre'];
                                    }
                                }
                                $sql_usuario = "SELECT nomusu FROM usuario where usecod = '$mov_usuario'";
                                $result_usuario = mysqli_query($conexion, $sql_usuario);
                                if (mysqli_num_rows($result_usuario)) {
                                    while ($row_usuario = mysqli_fetch_array($result_usuario)) {
                                        $user_n_usuario = $row_usuario['nomusu'];
                                    }
                                }
                            ?>
                                <tr>
                                    <td>
                                        <div align='center'>
                                            <?php echo $i; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo $codpro; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo $desprod; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo  $factor; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo  $destab; ?>
                                        </div>
                                    </td>
                                    <td class="<?php echo $class; ?>">
                                        <div align='center'>
                                            <?php echo  $nombre; ?>
                                        </div>
                                    </td>
                                    <td class="<?php echo $class; ?>">
                                        <div align='center'>
                                            <?php echo  $user_n_usuario; ?>
                                        </div>
                                    </td>
                                    <td class="<?php echo $class; ?>">
                                        <div align='center'>
                                            <?php echo  fecha($mov_fecha); ?>
                                        </div>
                                    </td>
                                    <td class="<?php echo $class; ?>">
                                        <div align='center'>
                                            <?php echo  $mov_hora; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9">
                                    <div class="siniformacion">
                                        <center>
                                            No se logro encontrar informacion con los datos ingresados
                                        </center>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>

                    <table width="100%" id="customers">

                        <?php

                        $sql = "SELECT * FROM mov_producto     order by codpro";

                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) { ?>
                            <tr>
                                <td colspan="17">
                                    <div align='center' class="texto">
                                        <?php echo $loca_text; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>N</th>
                                <th>CODIGO</th>
                                <th>PRODUCTO</th>
                                <th>FACTOR</th>
                                <th>MARCA</th>
                                <th>LOCAL CREACION</th>
                                <th>USUARIO CREACION</th>
                                <th>FECHA CREACION</th>
                                <th>HORA CREACION</th>

                                <th>LOCAL ACTUALIZACION</th>
                                <th>USUARIO ACTUALIZACION</th>
                                <th>FECHA ACTUALIZACION</th>
                                <th>HORA ACTUALIZACION</th>
<!--
                                <th>LOCAL ELIMINACION</th>
                                <th>USUARIO ELIMINACION</th>
                                <th>FECHA ELIMINACION</th>
                                <th>HORA ELIMINACION</th>-->
                            </tr>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                $i++;
                                $codpro = $row['0'];
                                $local_add = $row[1];
                                $usuario_add = $row[2];
                                $fecha_add = $row[3];
                                $hora_add = $row[4];

                                $local_up = $row[5];
                                $usuario_up = $row[6];
                                $fecha_up = $row[7];
                                $hora_up = $row[8];

                                $local_d = $row[9];
                                $usuario_d = $row[10];
                                $fecha_d = $row[11];
                                $hora_d = $row[12];


                                $hora_add2 = date("g:i a", strtotime($hora_add));
                                $hora_up2 = date("g:i a", strtotime($hora_up));
                                $hora_d2 = date("g:i a", strtotime($hora_d));


                                $sql1 = "SELECT desprod,factor,codmar FROM producto where codpro = '$codpro' and eliminado='0'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $desprod = $row1['desprod'];
                                        $factor = $row1['factor'];
                                        $codmar = $row1['codmar'];
                                    }
                                }
                                $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $destab = $row2['destab'];
                                        $abrev = $row2['abrev'];
                                        if ($abrev <> '') {
                                            $destab = $abrev;
                                        }
                                    }
                                }
                                $sql_add = "SELECT nombre FROM xcompa where codloc = '$local_add'";
                                $result_add = mysqli_query($conexion, $sql_add);
                                if (mysqli_num_rows($result_add)) {
                                    while ($row_add = mysqli_fetch_array($result_add)) {
                                        $nombre_add = $row_add['nombre'];
                                    }
                                } else {
                                    $nombre_add = '-------------';
                                }
                                $sql_up = "SELECT nombre FROM xcompa where codloc = '$local_up'";
                                $result_up = mysqli_query($conexion, $sql_up);
                                if (mysqli_num_rows($result_up)) {
                                    while ($row_up = mysqli_fetch_array($result_up)) {
                                        $nombre_up = $row_up['nombre'];
                                    }
                                } else {
                                    $nombre_up = '-------------';
                                }
                                $sql_d = "SELECT nombre FROM xcompa where codloc = '$local_d'";
                                $result_d = mysqli_query($conexion, $sql_d);
                                if (mysqli_num_rows($result_d)) {
                                    while ($row_d = mysqli_fetch_array($result_d)) {
                                        $nombre_d = $row_d['nombre'];
                                    }
                                } else {
                                    $nombre_d = '-------------';
                                }

                                ///////////////////////////////////
                                ///////////////////////////////////
                                ///////////////////////////////////
                                ///////////////////////////////////
                                $sql_add2 = "SELECT nomusu FROM usuario where usecod = '$usuario_add'";
                                $result_add2 = mysqli_query($conexion, $sql_add2);
                                if (mysqli_num_rows($result_add2)) {
                                    while ($row_add2 = mysqli_fetch_array($result_add2)) {
                                        $user_add = $row_add2['nomusu'];
                                    }
                                } else {
                                    $user_add = '-------------';
                                }
                                $sql_up2 = "SELECT nomusu FROM usuario where usecod = '$usuario_up'";
                                $result_up2 = mysqli_query($conexion, $sql_up2);
                                if (mysqli_num_rows($result_up2)) {
                                    while ($row_up2 = mysqli_fetch_array($result_up2)) {
                                        $user_up = $row_up2['nomusu'];
                                    }
                                } else {
                                    $user_up = '-------------';
                                }

                                $sql_d2 = "SELECT nomusu FROM usuario where usecod = '$usuario_d'";
                                $result_d2 = mysqli_query($conexion, $sql_d2);
                                if (mysqli_num_rows($result_d2)) {
                                    while ($row_d2 = mysqli_fetch_array($result_d2)) {
                                        $user_d = $row_d2['nomusu'];
                                    }
                                } else {
                                    $user_d = '-------------';
                                }
                            ?>
                                <tr>
                                    <td>
                                        <div align='center'>
                                            <?php echo $i; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo $codpro; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo $desprod; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo  $factor; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align='center'>
                                            <?php echo  $destab; ?>
                                        </div>
                                    </td>
                                    <td class="crear">
                                        <div align='center'>
                                            <?php echo  $nombre_add; ?>
                                        </div>
                                    </td>
                                    <td class="crear">
                                        <div align='center'>
                                            <?php echo  $user_add; ?>
                                        </div>
                                    </td>
                                    <td class="crear">

                                        <div align='center'>
                                            <?php if ($fecha_add == '0000-00-00') {
                                                echo '-------------';
                                            } else {
                                                echo  fecha($fecha_add);
                                            } ?>
                                        </div>
                                    </td>
                                    <td class="crear">

                                        <div align='center'>
                                            <?php if ($hora_add == '00:00:00') {
                                                echo '-------------';
                                            } else {
                                                echo  $hora_add2;
                                            } ?>
                                        </div>
                                    </td>

                                    <td class="actualiza">
                                        <div align='center'>
                                            <?php echo  $nombre_up; ?>
                                        </div>
                                    </td>
                                    <td class="actualiza">
                                        <div align='center'>
                                            <?php echo  $user_up; ?>
                                        </div>
                                    </td>
                                    <td class="actualiza">

                                        <div align='center'>
                                            <?php if ($fecha_up == '0000-00-00') {
                                                echo '-------------';
                                            } else {
                                                echo  fecha($fecha_up);
                                            } ?>
                                        </div>
                                    </td>
                                    <td class="actualiza">

                                        <div align='center'>
                                            <?php if ($hora_up == '00:00:00') {
                                                echo '-------------';
                                            } else {
                                                echo  $hora_up2;
                                            } ?>
                                        </div>
                                    </td>
<!--

                                    <td class="elimina">
                                        <div align='center'>
                                            <?php echo  $nombre_d; ?>
                                        </div>
                                    </td>
                                    <td class="elimina">
                                        <div align='center'>
                                            <?php echo  $user_d; ?>
                                        </div>
                                    </td>
                                    <td class="elimina">
                                        <div align='center'>
                                            <?php if ($fecha_d == '0000-00-00') {
                                                echo '-------------';
                                            } else {
                                                echo  fecha($fecha_d);
                                            } ?>
                                        </div>
                                    </td>
                                    <td class="elimina">

                                        <div align='center'>
                                            <?php if ($hora_d == '00:00:00') {
                                                echo '-------------';
                                            } else {
                                                echo  $hora_d2;
                                            } ?>
                                        </div>

                                    </td>
                                    -->
                                </tr>
                            <?php
                            } ?>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="17 ">
                                    <div class="siniformacion">
                                        <center>
                                            No se logro encontrar informacion con los datos ingresados
                                        </center>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>


            </td>

        </tr>





    </table>
</body>

</html>