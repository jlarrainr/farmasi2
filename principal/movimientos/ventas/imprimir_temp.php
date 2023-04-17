<?php
require_once('../../session_user.php');
require_once('session_ventas_temp.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');    //CONEXION A BASE DE DATOS

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}

$tventa         = $_SESSION['tventa'];

//error_log("tventa: " . $tventa);
$sql = "SELECT * FROM venta2 where invnum = '$tventa'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $usecod    = $row['usecod'];
    }
}
$sql = "SELECT * FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc    = $row['codloc'];
    }
}
$sql = "SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc    = $row['nomloc'];
    }
}

$stockParaVenta = true;
$descProducto = "";
$sql = "SELECT * FROM detalle_venta2 where invnum = '$tventa'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    //    error_log("Entra al primer if");
    while ($stockParaVenta && $row = mysqli_fetch_array($result)) {
        //        error_log("Entra al primer while");
        $codtemp      = $row['codtemp'];
        $codpro       = $row['codpro'];
        $canpro       = $row['canpro'];
        $fraccion     = $row['fraccion'];
        $factor       = $row['factor'];
        $fraccion     = $row['fraccion'];
        if ($fraccion == "F") {
            $cantemp = $canpro * $factor;
        } else {
            $cantemp = $canpro;
        }

        $sql2 = "SELECT stopro, factor, desprod, s000, s001, s002, s003, s004,
            s005, s006, s007, s008, s009, s010, s011, s012, s013, s014, s015, 
            s016, s017, s018, s019, s020
             FROM producto where codpro = '$codpro'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            if ($row2 = mysqli_fetch_array($result2)) {
                //                error_log("Entra al tercer if");
                $stopro                 = $row2['stopro'];
                $desprod        = $row2['desprod'];
                $s000      = $row2['s000'];
                $s001      = $row2['s001'];
                $s002      = $row2['s002'];
                $s003      = $row2['s003'];
                $s004      = $row2['s004'];
                $s005      = $row2['s005'];
                $s006      = $row2['s006'];
                $s007      = $row2['s007'];
                $s008      = $row2['s008'];
                $s009      = $row2['s009'];
                $s010      = $row2['s010'];
                $s011      = $row2['s011'];
                $s012      = $row2['s012'];
                $s013      = $row2['s013'];
                $s014      = $row2['s014'];
                $s015      = $row2['s015'];
                $s016      = $row2['s016'];
                $s017      = $row2['s017'];
                $s018      = $row2['s018'];
                $s019      = $row2['s019'];
                $s020      = $row2['s020'];

                if ($nomloc == "LOCAL0") {
                    $candisponible = $s000;
                } elseif ($nomloc == "LOCAL1") {
                    $candisponible = $s001;
                } elseif ($nomloc == "LOCAL2") {
                    $candisponible = $s002;
                } elseif ($nomloc == "LOCAL3") {
                    $candisponible = $s003;
                } elseif ($nomloc == "LOCAL4") {
                    $candisponible = $s004;
                } elseif ($nomloc == "LOCAL5") {
                    $candisponible = $s005;
                } elseif ($nomloc == "LOCAL6") {
                    $candisponible = $s006;
                } elseif ($nomloc == "LOCAL7") {
                    $candisponible = $s007;
                } elseif ($nomloc == "LOCAL8") {
                    $candisponible = $s008;
                } elseif ($nomloc == "LOCAL9") {
                    $candisponible = $s009;
                } elseif ($nomloc == "LOCAL10") {
                    $candisponible = $s010;
                } elseif ($nomloc == "LOCAL11") {
                    $candisponible = $s011;
                } elseif ($nomloc == "LOCAL12") {
                    $candisponible = $s012;
                } elseif ($nomloc == "LOCAL13") {
                    $candisponible = $s013;
                } elseif ($nomloc == "LOCAL14") {
                    $candisponible = $s014;
                } elseif ($nomloc == "LOCAL15") {
                    $candisponible = $s015;
                } elseif ($nomloc == "LOCAL16") {
                    $candisponible = $s016;
                } elseif ($nomloc == "LOCAL17") {
                    $candisponible = $s017;
                } elseif ($nomloc == "LOCAL18") {
                    $candisponible = $s018;
                } elseif ($nomloc == "LOCAL19") {
                    $candisponible = $s019;
                } elseif ($nomloc == "LOCAL20") {
                    $candisponible = $s020;
                }

                //                error_log("cantemp: " . $cantemp);
                //                error_log("candisponible: " . $candisponible);
                if ($cantemp > $candisponible) {

                    mysqli_query($conexion, "DELETE from detalle_venta2 where invnum = '$tventa' and codpro = '$codpro'");
                    $stockParaVenta = false;
                    $descProducto = $desprod;
                }
            }
        }
    }
}

//error_log("Producto: " . $descProducto);
//error_log("stockParaVenta: " . $stockParaVenta);

if (!$stockParaVenta) {
    //    error_log("Ejecutando script");
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }
        </style>
        <SCRIPT LANGUAGE="JavaScript">
            alert("No hay suficiente stock del producto <?php echo $descProducto; ?>.");
            window.opener.location.reload(true);
            window.close();
        </script>
    </head>

    <body>
    </body>
<?php
    //    error_log("Ejecutando script2");

    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

    <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <title>IMPRESION DE VENTA</title>
    <?php
    $CVendedor      = isset($_REQUEST['CVendedor']) ? $_REQUEST['CVendedor'] : "";
    $correo         = isset($_REQUEST['correo']) ? $_REQUEST['correo'] : "";
    $anotacion         = isset($_REQUEST['anotacion']) ? $_REQUEST['anotacion'] : "";
    $Cliente        = isset($_REQUEST['cliente']) ? $_REQUEST['cliente'] : "";
    $ClienteID      = isset($_REQUEST['cliente_ID']) ? $_REQUEST['cliente_ID'] : "";
    $RUC            = isset($_REQUEST['ruc']) ? $_REQUEST['ruc'] : "";

    $pagacon        = isset($_REQUEST['pagacon']) ? $_REQUEST['pagacon'] : "";
    $vuelto         = isset($_REQUEST['vueltos']) ? $_REQUEST['vueltos'] : "";
    $numCopias   = isset($_REQUEST['numCopias']) ? $_REQUEST['numCopias'] : 1;
    //$factura        = isset($_REQUEST['factura'])? $_REQUEST['factura'] : "";

    $nombcliente    = $Cliente;
    if (strlen($ClienteID) > 0) {
        $sql = "SELECT codcli,descli,dnicli FROM cliente where codcli = '$ClienteID'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codcli         = $row["codcli"];
                $descli         = $row["descli"];
                $dnicli         = $row["dnicli"];
                $nombcliente    = $descli;
                mysqli_query($conexion, "UPDATE cliente set email = '$correo',ruccli='$RUC' where codcli = '$ClienteID'");
                mysqli_query($conexion, "UPDATE venta2 set cuscod = '$codcli' where invnum = '$tventa'");
                mysqli_query($conexion, "UPDATE detalle_venta2 set cuscod = '$codcli' where invnum = '$tventa'");
            }
        }
    }

    if (strlen($correo) <> "") {
        $sqlVenta = "SELECT cuscod,correlativo,sucursal FROM venta2 where estado ='1' and invnum = '$tventa'";
        $resultVenta = mysqli_query($conexion, $sqlVenta);
        if (mysqli_num_rows($resultVenta)) {
            while ($row = mysqli_fetch_array($resultVenta)) {
                $cuscod         = $row['cuscod'];
                $correlativo    = $row['correlativo'];
                $sucursal       = $row['sucursal'];
            }
        }

        //**CONFIGPRECIOS_PRODUCTO**//
        $nomlocalG  = "";
        $sqlLocal   = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
        $resultLocal = mysqli_query($conexion, $sqlLocal);
        if (mysqli_num_rows($resultLocal)) {
            while ($rowLocal = mysqli_fetch_array($resultLocal)) {
                $nomlocalG    = $rowLocal['nomloc'];
            }
        }

        $TablaPrevtaMain = "prevta";
        $TablaPreuniMain = "preuni";
        if ($nomlocalG <> "") {
            if ($nomlocalG == "LOCAL1") {
                $TablaPrevta = "prevta1";
                $TablaPreuni = "preuni1";
            } else {
                if ($nomlocalG == "LOCAL2") {
                    $TablaPrevta = "prevta2";
                    $TablaPreuni = "preuni2";
                } else {
                    $TablaPrevta = "prevta";
                    $TablaPreuni = "preuni";
                }
            }
        } else {
            $TablaPrevta = "prevta";
            $TablaPreuni = "preuni";
        }
        //**FIN_CONFIGPRECIOS_PRODUCTO**//

        $sqlCli = "SELECT ruccli,descli,email FROM cliente where codcli = '$cuscod'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {
                $ruccli    = $row["ruccli"];
                $descli    = $row["descli"];
                $emailcli  = $row["email"];
            }
        }
        if (strlen($emailcli) > 0) {
            $sql = "SELECT codtemp,codpro,canpro,fraccion,factor,prisal,pripro,fraccion,bonif FROM detalle_venta2 where invnum = '$tventa' order by codtemp";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                $i = 1;
                $Fecha = date("d/m/Y H:i");
                $mail       = "Estimado(a). $descli, por el presente se le remite una copia de su comprobante, debido a la compra realizada en nuestra empresa.<br><br>"
                    . "<table style='width:100%;'>"
                    . "<tr><td><b>Nï¿½ Venta:</b></td><td>$correlativo</td></tr>"
                    . "<tr><td><b>Cliente:</b></td><td>$descli</td></tr>"
                    . "<tr><td><b>RUC:</b></td><td>$ruccli</td></tr>"
                    . "<tr><td><b>Fecha:</b></td><td>$Fecha</td></tr>"
                    . "</table><br>"
                    . "<table style='width:100%;'>"
                    . "<tr><td><b>Nï¿½</b></td><td><b>Producto</b></td><td><b>Cantidad</b></td><td><b>Precio Caja</b></td><td><b>Precio Unit.</b></td><td><b>Sub Total</b></td></tr>";
                while ($row = mysqli_fetch_array($result)) {
                    $codtemp      = $row['codtemp'];
                    $codpro       = $row['codpro'];
                    $canpro       = $row['canpro'];
                    $fraccion     = $row['fraccion'];
                    $factor       = $row['factor'];
                    $prisal       = $row['prisal']; //preciounitario
                    $pripro       = $row['pripro']; //subtotal
                    $bonif        = $row['bonif'];
                    if ($fraccion == 'T') {
                        $CantidadProducto = $canpro;
                    } else {
                        $CantidadProducto = 'c' . $canpro;
                    }
                    $sql1 = "SELECT desprod,$TablaPrevtaMain as PrevtaMain,$TablaPrevta,codpro FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $codpro    = $row1['codpro'];
                            $desprod    = $row1['desprod'];
                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $prevtaMain = $row1[1]; //preciocaja
                                $prevta     = $row1[2];
                            } elseif ($precios_por_local == 0) {
                                $prevtaMain = $row1[1]; //preciocaja
                                $prevta     = $row1[2];
                            }


                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $prevta_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $prevtaMain = $row_precio[0]; //preciocaja
                                        $prevta     = $row_precio[0];
                                    }
                                }
                            }
                        }
                    }

                    //**CONFIGPRECIOS_PRODUCTO**//
                    if (($prevta == "") || ($prevta == 0)) {
                        $prevta = $prevtaMain;
                    }
                    //**FIN_CONFIGPRECIOS_PRODUCTO**//

                    $mail       = $mail . "<tr><td>$i</td><td>$desprod</td><td>$CantidadProducto</td><td>$prevta</td><td>$prisal</td><td>$pripro</td></tr>";
                    $i++;
                }
                $mail       = $mail . "</table><br>Muchas gracias por su preferencia.<br><br>Atentamente<br><br>FARMASIS";
                $titulo     = "Compra realizada";
                $headers    = "MIME-Version: 1.0\r\n";
                $headers    .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers    .= "From: FARMASIS <admin@farmasis.net>\r\n";
                $bool       = mail($emailcli, $titulo, $mail, $headers);
            }
        }
    }

    $rd     = isset($_REQUEST['rd']) ? $_REQUEST['rd'] : "";
    //$sqlp   = "update venta set nomcliente = '$nombcliente',pagacon = '$pagacon', tipdoc = '$rd',vuelto = '$vuelto',nrofactura = '$factura' where invnum = '$venta'";
    $sqlp   = "update venta set anotacion='$anotacion', nomcliente = '$nombcliente',pagacon = '$pagacon', tipdoc = '$rd',vuelto = '$vuelto' where invnum = '$tventa'";
    mysqli_query($conexion, $sqlp);
    //    error_log("Imprime (" . $sqlp . ")\nError(" . mysqli_error($conexion) . ")");

    ?>
    <script>
        function escapes() {
            var f = document.form1;
            var rd = f.rd.value;
            f.method = "post";
            f.target = "self";
            self.close();
            if (rd == 1) {
                parent.opener.location = 'impresion.php?rd=1&numCopias=<?php echo $numCopias ?>';
            }
            if (rd == 2) {
                parent.opener.location = 'impresion.php?rd=2&numCopias=<?php echo $numCopias ?>';
            }
            if (rd == 4) {
                parent.opener.location = 'impresion.php?rd=4&numCopias=<?php echo $numCopias ?>';
            }
        }
    </script>
</head>

<body onload="escapes();">
    <form id="form1" name="form1">
        <input name="rd" type="hidden" id="rd" value="<?php echo $rd; ?>" />
    </form>
</body>

</html>