<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
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
    $invnum = $_REQUEST['invnum'];

    function formato($c) {
        printf("%08d", $c);
    }

    function formato1($c) {
        printf("%06d", $c);
    }

    $sql = "SELECT invnum,nrovent,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,sucursal,hora FROM venta where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row['invnum'];
            $nrovent = $row['nrovent'];
            $invfec = $row['invfec'];
            $cuscod = $row['cuscod'];
            $usecod = $row['usecod'];
            $bruto = $row['bruto'];
            $valven = $row['valven'];
            $invtot = $row['invtot'];
            $forpag = $row['forpag'];
            $sucursal = $row['sucursal'];
            $hora = $row['hora'];
            $igv = $row['igv'];
        }
    }
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
    $result = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $nloc = $row["nomloc"];
        $nombre = $row["nombre"];
        if ($nombre == '') {
            $locals = $nloc;
        } else {
            $locals = $nombre;
        }
    }
    $sql = "SELECT descli FROM cliente where codcli = '$cuscod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $descli = $row['descli'];
        }
    }
    $sql = "SELECT nomusu FROM usuario where usecod = '$usecod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomusu = $row['nomusu'];
        }
    }
    $dcto = $bruto - $valven;
    ?><head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>REPORTE DE VENTA</title>

    </head>

    <body>
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="100%">
                    <table width="100%" border="0" align="center" style="background:#f0f0f0;border: 1px solid #cdcdcd;border-spacing:0;border-collapse: collapse;" class="no-spacing" cellspacing="0">
                        <tr>
                            <td width="6%"><strong>NUMERO :</strong></td>
                            <td width="22%"><?php echo formato($nrovent) ?></td>
                            <td width="7%"><strong>FECHA : </strong></td>
                            <td width="11%"><?php echo fecha($invfec) ?></td>
                            <td width="10%"><strong>FORMA DE PAGO :</strong></td>
                            <td width="8%"><?php echo $forpag ?></td>
                            <td width="7%"><strong>LOCAL : </strong></td>
                            <td width="25%"><?php echo $locals ?></td>
                        </tr>
                        <tr>
                            <td ><strong>CLIENTE : </strong></td>
                            <td ><?php echo $descli ?></td>
                            <td ><div align="left"><strong>HORA VTA : </strong></div></td>
                            <td ><?php echo $hora; ?></td>
                            <td ><strong>COD VENDEDOR : </strong></td>
                            <td ><?php echo formato1($usecod) ?></td>
                            <td ><div align="left"><strong>VENDEDOR :</strong></div></td>
                            <td ><?php echo $nomusu ?></td>
                        </tr>
                        <tr>

                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="100%">

                    <hr/>
                    <?php
                    $i = 0;
                    $sql = "SELECT codpro,canpro,fraccion,factor,prisal,pripro,cospro,codmar FROM detalle_venta where invnum = '$invnum'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        ?>
                        <table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th width="3%"><strong>N&ordm;</strong></th>
                                <th width="52%"><strong>PRODUCTO</strong></th>
                                <th width="15%"><strong>MARCA</strong></th>
                                <th width="10%"><div align="right"><strong>CANTIDAD</strong></div></th>
                                <th width="10%"><div align="right"><strong>PRECIO  </strong></div></th>
                                <th width="10%"><div align="right"><strong>SUB TOTAL </strong></div></th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $codpro = $row['codpro'];
                                $canpro = $row['canpro'];
                                $fraccion = $row['fraccion'];
                                $factor = $row['factor'];
                                $prisal = $row['prisal'];
                                $pripro = $row['pripro'];
                                $cospro = $row['cospro'];
                                $codmar = $row['codmar'];

                                if ($fraccion == "T") {
                                    $canpro = 'F' . $canpro;
                                } else {
                                    $canpro = 'C' . $canpro;
                                }
                                $sql1 = "SELECT desprod FROM producto where codpro = '$codpro' and eliminado='0'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $desprod = $row1['desprod'];
                                    }
                                }
                                $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $destab = $row1['destab'];
                                    }
                                }
                                $i++;
                                ?>
                                <tr>
                                    <td ><?php echo $i; ?></td>
                                    <td ><?php echo $desprod; ?></td>
                                    <td align="center"><?php echo $destab; ?></td>
                                    <td ><div align="center"><?php echo $canpro; ?></div></td>
                                    <td ><div align="right"><?php echo $prisal; ?></div></td>
                                    <td ><div align="right"><?php echo $pripro; ?></div></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    <?php }
                    ?>
                </td>
            </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" border="0" align="center" style="background:#f0f0f0;border: 1px solid #cdcdcd;border-spacing:0;border-collapse: collapse;" class="no-spacing" cellspacing="0">
                        <tr>
                            <td width="94"><strong>MONTO BRUTO </strong></td>
                            <td width="103"><?php echo $numero_formato_frances = number_format($bruto, 2, '.', ' '); ?></td>
                            <td width="43"><strong>DCTO</strong></td>
                            <td width="117"><?php echo $numero_formato_frances = number_format(0.00, 2, '.', ' '); ?></td>
                            <td width="99"><strong>VALOR VENTA </strong></td>
                            <td width="151"><?php echo $numero_formato_frances = number_format($valven, 2, '.', ' '); ?></td>
                            <td width="32"><strong>IGV</strong></td>
                            <td width="112"><?php echo $numero_formato_frances = number_format($igv, 2, '.', ' '); ?></td>
                            <td width="41"><strong>TOTAL</strong></td>
                            <td width="101"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </body>
</html>
