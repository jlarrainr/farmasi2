<?php
include('../../session_user.php');
require_once ('../../../conexion.php');
$CCompra = $_REQUEST['Compra'];
?>
<html>
    <head><meta charset="windows-1252"> 
        <script>
            function imprimir()
            {
                var f = document.form1;
                window.print();
                f.action = "../ing_salid.php";
                f.method = "post";
                f.submit();
            }
        </script>
        <style>
            body, table
            {
                font-size:12px;
                /*//font-weight: bold;*/
            }
        </style>
    </head>
    <body onload="imprimir()">
        <form name="form1" id="form1">
            <?php

            function cambiarFormatoFecha($fecha) {
                list($anio, $mes, $dia) = explode("-", $fecha);
                return $dia . "-" . $mes . "-" . $anio;
            }

            $HoraActual = DATE("H:i");
            $Usuario = "";
            $Sucursal = "";
            $Proveedor = "";
            $sqlCompras = "SELECT numdoc,invfec,refere,invnumrecib,usecod,sucursal,cuscod,forpag,numero_documento,numero_documento1,incluidoIGV,plazo,fecven,invtot,igv,valven,destot,costo FROM movmae where invnum = '$CCompra'";
            $resultCompras = mysqli_query($conexion, $sqlCompras);
            if (mysqli_num_rows($resultCompras)) {
                while ($row = mysqli_fetch_array($resultCompras)) {
                    $invnum = $row['numdoc'];
                    $invfec = $row['invfec'];
                    $usecod = $row['usecod'];
                    $sucursal = $row['sucursal'];
                    $cuscod = $row['cuscod'];
                    $forpag = $row['forpag'];
                    $numdoc = $row['numero_documento'];
                    $numdoc1 = $row['numero_documento1'];
                    $incluidoIGV = $row['incluidoIGV'];
                    $plazo = $row['plazo'];
                    $fecven = $row['fecven'];
                    $invtot = $row['invtot'];
                    $igv = $row['igv'];
                    $valven = $row['valven'];
                    $destot = $row['destot'];
                    $costo = $row['costo'];
                    $refere = $row['refere'];
                    $invnumrecib = $row['invnumrecib'];
                    if ($incluidoIGV == 1) {
                        $incluidoIGV = "SI";
                    } else {
                        $incluidoIGV = "NO";
                    }
                    $sqlCompras2 = "SELECT sucursal,usecod FROM movmae where invnum = '$invnumrecib'";
                    $resultCompras2 = mysqli_query($conexion, $sqlCompras2);
                    if (mysqli_num_rows($resultCompras2)) {
                        while ($row = mysqli_fetch_array($resultCompras2)) {
                            $SucursalOrig = $row['sucursal'];
                            $UsuarioOrig = $row['usecod'];
                        }
                    }
                    $sqlUsu = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                    $resultUsu = mysqli_query($conexion, $sqlUsu);
                    if (mysqli_num_rows($resultUsu)) {
                        while ($row = mysqli_fetch_array($resultUsu)) {
                            $Usuario = $row['nomusu'];
                        }
                    }
                    $sqlUsuOrig = "SELECT nomusu FROM usuario where usecod = '$UsuarioOrig'";
                    $resultUsuOrig = mysqli_query($conexion, $sqlUsuOrig);
                    if (mysqli_num_rows($resultUsuOrig)) {
                        while ($row = mysqli_fetch_array($resultUsuOrig)) {
                            $UsuarioOrig = $row['nomusu'];
                        }
                    }
                    $sqlSuc = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                    $resultSuc = mysqli_query($conexion, $sqlSuc);
                    if (mysqli_num_rows($resultSuc)) {
                        while ($row = mysqli_fetch_array($resultSuc)) {
                            $Sucursal = $row['nomloc'];
                        }
                    }
                    $sqlSucOrig = "SELECT nomloc FROM xcompa where codloc = '$SucursalOrig'";
                    $resultSucOrig = mysqli_query($conexion, $sqlSucOrig);
                    if (mysqli_num_rows($resultSucOrig)) {
                        while ($row = mysqli_fetch_array($resultSucOrig)) {
                            $SucursalOrig = $row['nomloc'];
                        }
                    }
                }
                ?>
                <table style="width: 100%">
                    <tr>
                        <th style="text-align:left">Tipo de Movimiento</th>
                        <td colspan="9">COMPRAS</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">N°</th>
                        <td><?php echo $invnum; ?></td>
                        <th style="text-align:left">Fecha</th>
                        <td><?php echo $invfec; ?></td>
                        <th style="text-align:left">Hora</th>
                        <td><?php echo $HoraActual; ?></td>
                        <th style="text-align:left">Res</th>
                        <td><?php echo $Usuario; ?></td>
                        <th style="text-align:left">Local</th>
                        <td><?php echo $Sucursal; ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:left">De</th>
                        <td colspan="4"><?php echo $UsuarioOrig; ?></td>
                        <th style="text-align:left">Solicitado por</th>
                        <td colspan="4"><?php echo $SucursalOrig; ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Referencia</th>
                        <td colspan="9"><?php echo $refere; ?></td>
                    </tr>
                </table>
                <br>
                <?php
                $sqlComprasMov = "SELECT qtypro,codpro,prisal,desc1,desc2,desc3,pripro,costre FROM movmov where invnum = '$CCompra'";
                $resultComprasMov = mysqli_query($conexion, $sqlComprasMov);
                if (mysqli_num_rows($resultComprasMov)) {
                    ?>
                    <hr>
                    <hr>
                    <table style="width: 100%">
                        <tr>
                            <th style="text-align:left">Cantidad</th>
                            <th style="text-align:right">Producto</th>
                            <th style="text-align:right">Precio Unit</th>
                            <th style="text-align:right">Sub Total</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($resultComprasMov)) {
                            $qtypro = $row['qtypro'];
                            $codpro = $row['codpro'];
                            $prisal = $row['prisal'];
                            $desc1 = $row['desc1'];
                            $desc2 = $row['desc2'];
                            $desc3 = $row['desc3'];
                            $pripro = $row['pripro'];
                            $costre = $row['costre'];
                            $Producto = "";
                            $Marca = "";
                            $sqlProd = "SELECT P.desprod,M.destab FROM producto P LEFT JOIN titultabladet M ON M.codtab = P.codmar AND P.codpro = '$codpro'";
                            $resultProd = mysqli_query($conexion, $sqlProd);
                            if (mysqli_num_rows($resultProd)) {
                                while ($row = mysqli_fetch_array($resultProd)) {
                                    $Producto = $row['desprod'];
                                    $Marca = $row['destab'];
                                }
                            }
                            ?>
                            <tr>
                                <td><?php echo $qtypro; ?></td>
                                <td style="text-align: right;"><?php echo $Producto; ?></td>
                                <td><?php echo $Marca; ?></td>
                                <td style="text-align: right;"><?php echo $pripro; ?></td>
                                <td style="text-align: right;"><?php echo $costre; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
                <br>
                <?php
            }
            ?>
        </form>
    </body>
</html>