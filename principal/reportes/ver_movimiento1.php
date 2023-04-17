<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .Estilo1 {
        color: #FF0000;
        font-weight: bold;
    }

    .Estilo2 {
        color: #FF0000
    }
</style>
<?php
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $users = $row['nomusu'];
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
$mov = $_REQUEST['mov'];
$user = $_REQUEST['user'];
$local = $_REQUEST['local'];
$invnum = $_REQUEST['invnum'];
$desc_mov = $_REQUEST['tex'];

echo $tex;

function formato($c)
{
    printf("%08d", $c);
}

function formato1($c)
{
    printf("%06d", $c);
}

////////////////////////////
if ($mov == 1) {
    $desc_mov = "TODOS LOS MOVIMIENTOS";
}
if ($mov == 2) {
    $desc_mov = "SOLAMENTE INGRESOS";
}
if ($mov == 3) {
    $desc_mov = "SOLAMENTE SALIDAS";
}
if ($mov == 4) {
    $desc_mov = "COMPRAS";
}
if ($mov == 5) {
    $desc_mov = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 6) {
    $desc_mov = "DEVOLUCION EN BUEN ESTADO";
}
if ($mov == 7) {
    $desc_mov = "CANJE AL LABORATORIO";
}
if ($mov == 8) {
    $desc_mov = "OTROS INGRESOS";
}
if ($mov == 9) {
    $desc_mov = "SALIDAS VARIAS";
}
if ($mov == 10) {
    $desc_mov = "GUIAS DE REMISION";
}
if ($mov == 11) {
    $desc_mov = "SALIDA POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 12) {
    $desc_mov = "CANJE PROVEEDOR";
}
if ($mov == 13) {
    $desc_mov = "PRESTAMOS CLIENTE";
}
if ($user == 1) {
    $desc_user = "CLIENTE";
}
if ($user == 2) {
    $desc_user = "PROVEEDOR";
}
if ($user == 3) {
    $desc_user = "SUCURSAL";
}
////////////////////////////
$sql = "SELECT * FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
        $invnumrecib = $row['invnumrecib'];
        $nro_compra = $row['nro_compra'];
        $invfec = $row['invfec'];
        $usecod = $row['usecod'];   //usuario
        $cuscod = $row['cuscod'];  //proveedor
        $numdoc = $row['correlativo'];
        $numdocD1 = $row['numero_documento'];
        $numdocD2 = $row['numero_documento1'];
        $fecdoc = $row['fecdoc'];
        $plazo = $row['plazo'];
        $forpag = $row['forpag'];
        //            $invtot = $row['invtot'];
        $destot = $row['destot'];
        $valven = $row['valven'];
        $tipmov = $row['tipmov'];
        $tipdoc = $row['tipdoc'];
        $refere = $row['refere'];
        $fecven = $row['fecven'];
        //            $monto = $row['monto'];
        $hora = $row['hora'];
        $saldo = $row['saldo'];
        $moneda = $row['moneda'];
        $suspendido = $row['suspendido'];
        $costo = $row['costo'];
        $igv = $row['igv'];
        $codanu = $row['codanu'];
        $codrec = $row['codrec'];
        $orden = $row['orden'];
        $sucursal = $row['sucursal'];   //sucursal origen
        $sucursal1 = $row['sucursal1']; //sucursal destino
        $incluidoIGV = $row['incluidoIGV'];
        $dafecto = $row['dafecto'];
        $dinafecto = $row['dinafecto'];
        $digv = $row['digv'];
        $dtotal = $row['dtotal'];
        $monto = $row['invtot'];

        $sqlProv = "SELECT despro FROM proveedor where codpro = '$cuscod'";
        $resultProv = mysqli_query($conexion, $sqlProv);
        if (mysqli_num_rows($resultProv)) {
            while ($row = mysqli_fetch_array($resultProv)) {
                $Proveedor = $row['despro'];
            }
        }
        $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal1'";
        $resultSuc = mysqli_query($conexion, $sqlSuc);
        if (mysqli_num_rows($resultSuc)) {
            while ($row = mysqli_fetch_array($resultSuc)) {
                $sucursal_destino = $row['nombre'];
            }
        }
        $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal'";
        $resultSuc = mysqli_query($conexion, $sqlSuc);
        if (mysqli_num_rows($resultSuc)) {
            while ($row = mysqli_fetch_array($resultSuc)) {
                $Sucursal = $row['nombre'];
            }
        }
        if ($incluidoIGV == 1) {
            $incluidoIGV = "SI";
        } else {
            $incluidoIGV = "NO";
        }

        if ($tipmov == 1) {
            $desctip_mov = "INGRESO";
        } else {
            $desctip_mov = "SALIDA";
        }
    }
}
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
</head>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="33%"><strong><?php echo $desemp ?> </strong></td>
                        <td width="33%">
                            <div align="center"><strong>REPORTE DE INGRESOS Y SALIDAS </strong></div>
                        </td>
                        <td width="33%">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo $desc_mov ?></strong></td>
                        <td>
                            <div align="center"><b>
                                    <?php if ($val == 1) { ?>
                                        NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php
                                                                                            echo $desc1;
                                                                                        }
                                                                                        if ($vals == 2) {
                                                                                            ?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php
                                                                                                                                            echo $date2;
                                                                                                                                        }
                                                                                                                                            ?></b></div>
                        </td>
                        <td>
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $users ?></span></div>
                        </td>
                    </tr>
                </table>

                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="100%" border="0" align="center" style="background:#f0f0f0;border: 1px solid #cdcdcd;border-spacing:0;border-collapse: collapse;" class="no-spacing" cellspacing="0">
                    <tr>
                        <td style="text-align: left;width:20%"><b>FECHA : </b><?php echo fecha($invfec) ?></td>
                        <td style="text-align: left;width:20%"><b>INTERNO : </b><?php echo formato($invnum) ?></td>
                        <td style="text-align: left;width:20%"><b>TIPO MOV : </b><?php echo $desctip_mov ?></td>
                        <td style="text-align: left;width:20%"><b>N&ordm; DOCUMENTO : </b><?php echo formato($numdoc); ?></td>
                        <td style="text-align: left;width:20%;"><b>MONTO : </b><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' '); ?></td>
                    </tr>
                    <?php if ($Sucursal <> '') { ?>
                        <tr>
                            <td colspan="3">
                                <b>REFERENCIA : </b>
                                <?php
                                echo $refere;
                                echo "...";
                                ?>
                            </td>
                            <td style="text-align: left;"><?php if ($sucursal1 <> 0) { ?><b> LOCAL ENVIO :</b><?php } else { ?><b>LOCAL : </b><?php } ?><?php echo $Sucursal; ?></td>
                            <td style="text-align: left;"> <?php if ($sucursal1 <> 0) { ?><b>LOCAL DES : </b><?php echo $sucursal_destino; ?> <?php } ?></td>
                        </tr>
                    <?php } ?>


                    <?php if (($desc_mov == 'INGRESO POR COMPRA')) { ?>
                        <tr>
                            <td style="text-align: left;"><b>PROVEEDOR : </b><?php echo $Proveedor; ?></td>
                            <td style="text-align: left;"><b>N&ordm; DOCT : </b><?php echo $numdocD1 . '-' . $numdocD2; ?> </td>
                            <td style="text-align: left;"><b>FORMA. PAG : </b><?php echo $forpag; ?></td>
                            <td style="text-align: left;"><b>INCLUIDO IGV : </b> <?php echo $incluidoIGV; ?></td>
                            <td style="text-align: left;"><b>LOCAL : </b><?php echo $Sucursal; ?></td>
                        </tr>


                        <?php if ($plazo > 0) { ?>
                            <tr>
                                <td colspan="2" style="text-align: left;width:50%"><b>Plazo : </b><?php echo $plazo; ?></td>
                                <td colspan="3 " style="text-align: left;width:50%"><b>Fecha. P : </b><?php echo fecha($fecven); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="text-align: left;"><b>AFECTO :</b> <?php echo number_format($dafecto, 2, '.', ' '); ?></td>
                            <td style="text-align: left;"><b>INAFECTO :</b> <?php echo number_format($dinafecto, 2, '.', ' '); ?></td>
                            <td style="text-align: left;"><b>IGV :</b> <?php echo number_format($digv, 2, '.', ' '); ?></td>
                            <td style="text-align: left;"><b>TOTAL : </b><?php echo number_format($dtotal, 2, '.', ' '); ?></td>
                            <td style="text-align: left;"></td>
                        </tr>

                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>

    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <?php
                $sql = "SELECT * FROM movmov where invnum = '$invnum' order by pripro desc";
                $result = mysqli_query($conexion, $sql);
                $i = 0;
                if (mysqli_num_rows($result)) {
                ?>
                    <table width="100%" border="0" align="center" id="customers">
                        <tr>
                            <th style="width: 2%">
                                <div align="left"><strong>N&ordm;</strong></div>
                            </th>
                            <th style="width: 40%">
                                <div align="left"><strong>PRODUCTO</strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="left"><strong>MARCA</strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>CANTIDAD</strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>PRECIO REF </strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>DESC 1 </strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>DESC 2 </strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>DESC 3 </strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>TOTAL CON DCTO </strong></div>
                            </th>
                            <th style="width: 6%">
                                <div align="center"><strong>SUB TOTAL </strong></div>
                            </th>
                        </tr>
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)) {
                            $i++;
                            $codpro = $row['codpro'];
                            $qtypro = $row['qtypro'];
                            $qtyprf = $row['qtyprf'];
                            $pripro = $row['pripro'];
                            $prisal = $row['prisal'];
                            $costre = $row['costre'];
                            $desc1 = $row['desc1'];
                            $desc2 = $row['desc2'];
                            $desc3 = $row['desc3'];
                            $sql1 = "SELECT desprod,factor,codmar FROM producto where codpro = '$codpro' and eliminado='0'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $desprod = $row1['desprod'];
                                    $factor = $row1['factor'];
                                    $codmar = $row1['codmar'];
                                }
                            }
                            if ($qtyprf == "") {
                                $cantidad = $qtypro;
                            } else {
                                $cantidad = $qtyprf;
                            }
                            $sql1 = "SELECT destab,abrev FROM titultabladet  where codtab = '$codmar'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $destab = $row1['destab'];
                                    $abrev = $row1['abrev'];
                                    if ($abrev <> '') {
                                        $destab = $abrev;
                                    }
                                }
                            }
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php
                                    echo $desprod;
                                    echo " ";
                                    if ($pripro == 0) {
                                    ?>(BONIF)<?php } ?></td>
                                <td><?php echo $destab; ?></td>
                                <td>
                                    <div align="center"><?php echo $cantidad ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $prisal ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $desc1 ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $desc2 ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $desc3 ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $pripro ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $costre ?></div>
                                </td>
                            </tr>
                        <?php
                        }
                        $i++
                        ?>
                    </table>
                <?php }
                ?>
            </td>
        </tr>
    </table>
</body>

</html>