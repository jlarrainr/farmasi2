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

<style type="text/css">
    .letras {
        font-size: 12px;
    }

    .letras1 {
        font-size: 12px;


    }

    .letras12 {
        font-size: 10px;

        font-weight: 700px;

    }
</style>
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
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME


$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}

$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$hour = date('G');
//$date	= CalculaFechaHora($hour); 
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = $_REQUEST['val'];
$country = $_REQUEST['country'];
$report = $_REQUEST['report'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros = $_REQUEST['registros'];

$vals = $_REQUEST['vals'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$ck1 = $_REQUEST['ck1'];
$local = $_REQUEST['local'];

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
?>

<body>
    <table width="100%%" border="0">
        <tr>
            <td width="100%">
                <table width="100%" border="0">
                    <tr class="letras1">
                        <td width="278"><strong><?php echo $desemp ?> </strong></td>
                        <td width="563">
                            <div align="center"><strong>REPORTE DE PRODUCTOS BONIFICADOS</strong></div>
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
                                                    if ($val == 1) {
                                                        echo $country;
                                                    }
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



    if (($val == 1) && ($vals == '') && ($ck1 == '')) {
    ?>


        <table width="100%" border="1" cellpadding="0" cellspacing="0" id="customers">

            <tr>
                <th width="220"><strong>PRODUCTO</strong></th>
                <th width="100">
                    <div align="center"><strong>MARCA</strong></div>
                </th>
                <th width="100">
                    <div align="center"><strong>CAN. BONIFICADA</strong></div>
                </th>
                <th width="100">
                    <div align="center"><strong>CAN. DE VENTA PARA BONIFICAR</strong></div>
                </th>

            </tr>
            <?php
            //echo $country;
            $sql = "SELECT  P.codpro,P.desprod,P.codmar ,P.codprobonif,P.cantbonificable,P.cantventaparabonificar FROM producto  as P inner join titultabladet AS T on T.codtab = P.codmar WHERE T.destab like '$country%' and P.codprobonif <>'0' and P.cantventaparabonificar <>'0' and P.cantbonificable <>'0'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {

                    $codpro = $row['codpro'];
                    $desprod = $row['desprod'];
                    $codmar = $row['codmar'];

                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                        $cantbonificable        = $row['cantbonificable'];
                        $cantventaparabonificar = $row['cantventaparabonificar'];
                    } elseif ($precios_por_local == 0) {
                        $cantbonificable        = $row['cantbonificable'];
                        $cantventaparabonificar = $row['cantventaparabonificar'];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $cantbonificable_p,$cantventaparabonificar_p  FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $cantbonificable        = $row_precio[0];
                                $cantventaparabonificar = $row_precio[1];
                            }
                        }
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
                    <tr height="25" onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                        <td width="180"><?php echo $desprod ?></td>
                        <td width="120"><?php echo $destab; ?></td>
                        <td width="100" align="center"><?php echo $cantbonificable; ?></td>
                        <td width="100" align="center"><?php echo $cantventaparabonificar; ?></td>

                    </tr>
                <?php
                }
            } else {
                ?>
               <div class="siniformacion">
                    <center>
                        No se logro encontrar informacion con los datos ingresados
                    </center>
                </div>
            <?php }
            ?>
        </table>
        <?php } else {

        if (($vals == '2') && ($ck1 == '')) { ?>


            <table width="100%" border="1" cellpadding="0" cellspacing="0" id="customers">
                <?php

                $sql = "SELECT DV.codpro, DV.factor,DV.codmar   FROM detalle_venta  as DV  INNER JOIN venta as V ON V.invnum=DV.invnum  WHERE DV.invfec BETWEEN '$date1' and '$date2' and DV.prisal ='0.00' and DV.pripro ='0.00'  and DV.cospro ='0.00' and DV.costpr ='0.00' and V.sucursal='$local'  GROUP BY DV.codpro";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) { ?>
                    <tr>
                        <th>CODIGO</th>
                        <th>PRODUCTO</th>
                        <th>MARCA/LABORATORIO</th>
                        <th>FACTOR</th>
                        <th>CANTIDAD VENDIDA</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($result)) {

                        $codpro     = $row['codpro'];
                        $factor1     = $row['factor'];
                        $codmar     = $row['codmar'];

                        $canproVista = '0';
                        $sqlSuma = "SELECT invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,codmar FROM detalle_venta WHERE invfec BETWEEN '$date1' and '$date2' and prisal ='0.00'and pripro ='0.00'  and cospro ='0.00' and costpr ='0.00'   and   codpro='$codpro'";
                        $resultSuma = mysqli_query($conexion, $sqlSuma);
                        if (mysqli_num_rows($resultSuma)) {
                            while ($rowSuma = mysqli_fetch_array($resultSuma)) {
                                $canpro     = $rowSuma['canpro'];
                                $fraccion   = $rowSuma['fraccion'];
                                $factor     = $rowSuma['factor'];


                                if ($fraccion == 'T') {
                                    $canproVista = $canpro;
                                } else {
                                    $canproVista = $canpro * $factor;
                                }
                            }
                        }
                        $sqldesprod = "SELECT desprod FROM producto WHERE    codpro='$codpro'";
                        $resultdesprod = mysqli_query($conexion, $sqldesprod);
                        if (mysqli_num_rows($resultdesprod)) {
                            while ($rowdesprod = mysqli_fetch_array($resultdesprod)) {
                                $desprod     = $rowdesprod['desprod'];
                            }
                        }

                        $sql1 = "SELECT abrev,destab FROM titultabladet where codtab = '$codmar'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $abrev = $row1['abrev'];
                                $destab = $row1['destab'];
                            }
                        }


                    ?>

                        <tr>
                            <td><?php echo $codpro; ?></td>
                            <td><?php echo $desprod; ?></td>
                            <td><?php echo $destab; ?></td>
                            <td><?php echo $factor1; ?></td>
                            <td><?php echo  stockcaja($canproVista, $factor1); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                <?php } ?>
            </table>
        <?php
        } else { ?>

            <table width="100%" border="1" cellpadding="0" cellspacing="0" id="customers">
                <?php

                $sql = "SELECT DV.invnum,DV.invfec,DV.cuscod,DV.usecod,DV.codpro,DV.canpro,DV.fraccion,DV.factor,DV.codmar,V.nrofactura,V.tipdoc,V.hora   FROM detalle_venta  as DV  INNER JOIN venta as V ON V.invnum=DV.invnum  WHERE DV.invfec BETWEEN '$date1' and '$date2' and DV.prisal ='0.00' and DV.pripro ='0.00'  and DV.cospro ='0.00' and DV.costpr ='0.00'   and V.sucursal='$local'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) { ?>
                    <tr>
                        <th>CODIGO</th>
                        <th>PRODUCTO</th>
                        <th>MARCA/LABORATORIO</th>
                        <th>FACTOR</th>
                        <th>NUMERO FACTURA</th>
                        <th>FECHA / HORA</th>
                        <th>USUARIO</th>
                        <th>CLIENTE</th>
                        <th>CANTIDAD VENDIDA</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($result)) {

                        $invnum         = $row['invnum'];
                        $invfec         = $row['invfec'];
                        $cuscod         = $row['cuscod'];
                        $usecod         = $row['usecod'];
                        $codpro         = $row['codpro'];
                        $canpro         = $row['canpro'];
                        $fraccion       = $row['fraccion'];
                        $factor1        = $row['factor'];
                        $codmar         = $row['codmar'];
                        $nrofactura     = $row['nrofactura'];
                        $tipdoc         = $row['tipdoc'];
                        $hora         = $row['hora'];

                        if ($fraccion == 'T') {
                            $canproVista = $canpro;
                        } else {
                            $canproVista = $canpro * $factor1;
                        }

                        $sqldesprod = "SELECT desprod FROM producto WHERE    codpro='$codpro'";
                        $resultdesprod = mysqli_query($conexion, $sqldesprod);
                        if (mysqli_num_rows($resultdesprod)) {
                            while ($rowdesprod = mysqli_fetch_array($resultdesprod)) {
                                $desprod     = $rowdesprod['desprod'];
                            }
                        }

                        $sql1 = "SELECT abrev,destab FROM titultabladet where codtab = '$codmar'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $abrev = $row1['abrev'];
                                $destab = $row1['destab'];
                            }
                        }

                        $sqlUsuario = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                        $resultUsuario = mysqli_query($conexion, $sqlUsuario);
                        if (mysqli_num_rows($resultUsuario)) {
                            while ($rowUsuario = mysqli_fetch_array($resultUsuario)) {
                                $userUsuario = $rowUsuario['nomusu'];
                            }
                        }
                        $sqlCliente = "SELECT descli,dnicli,ruccli FROM cliente where codcli = '$cuscod'";
                        $resultCliente = mysqli_query($conexion, $sqlCliente);
                        if (mysqli_num_rows($resultCliente)) {
                            while ($rowCliente = mysqli_fetch_array($resultCliente)) {
                                $descli = $rowCliente["descli"];
                                $dnicli = $rowCliente["dnicli"];
                                $ruccli = $rowCliente["ruccli"];
                            }
                        }
                    ?>

                        <tr>
                            <td><?php echo $codpro; ?></td>
                            <td><?php echo $desprod; ?></td>
                            <td><?php echo $destab; ?></td>
                            <td><?php echo $factor1; ?></td>
                            <td align="center"> <a href="javascript:popUpWindow('ver_venta_usu.php?invnum=<?php echo $invnum ?>', 30, 140, 975, 280)"><?php echo $nrofactura; ?></td>
                            <td><?php echo fecha($invfec) . ' - ' . $hora; ?></td>
                            <td><?php echo $userUsuario; ?></td>
                            <td><?php echo $descli; ?></td>
                            <td><?php echo  stockcaja($canproVista, $factor1); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                <?php } ?>
            </table>
    <?php
        }
    }
    ?>
</body>

</html>