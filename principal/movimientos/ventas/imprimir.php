<?php
require_once('../../session_user.php');
require_once('session_ventas.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('arreglaInvtot.php');

/* require_once('../../../convertfecha.php');
  require('fpdf/fpdf.php');    //CONEXION A FPDF
  require_once('../../reportes/MontosText.php');
  include "../../phpqrcode/qrlib.php";
  require_once('calcula_monto2.php'); */

$venta = $_SESSION['venta'];

//error_log("venta: " . $venta);
$sql = "SELECT * FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $usecod = $row['usecod'];
    }
}
$sql = "SELECT * FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
    }
}

$numero_xcompa = substr($nomloc, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$stockParaVenta = true;
$descProducto = "";
if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}
if (!empty($arr_detalle_venta)) {
    //    error_log("Entra al primer if");
    $contArray = 0;
    while ($stockParaVenta && isset($arr_detalle_venta[$contArray])) {
        //        error_log("Entra al primer while");
        $row = $arr_detalle_venta[$contArray];
        $contArray++;
        $codpro = $row['codpro'];
        $canpro = $row['canpro'];
        $fraccion = $row['fraccion'];
        $factor = $row['factor'];
        $fraccion = $row['fraccion'];
        if ($fraccion == "F") {
            $cantemp = $canpro * $factor;
        } else {
            $cantemp = $canpro;
        }

        $sql2 = "SELECT stopro, factor, desprod, $tabla FROM producto where codpro = '$codpro'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            if ($row2 = mysqli_fetch_array($result2)) {
                //                error_log("Entra al tercer if");
                $stopro = $row2['stopro'];
                $factor = $row2['factor'];
                $desprod = $row2['desprod'];
                $candisponible = $row2[3];

                //                error_log("cantemp: " . $cantemp);
                //                error_log("candisponible: " . $candisponible);
                if ($cantemp > $candisponible) {
                    $stockParaVenta = false;
                    $descProducto = $desprod;
                } else {
                    $arrAux[] = $row;
                }
            }
        }
    }
}
$_SESSION['arr_detalle_venta'] = $arrAux;

//error_log("Producto: " . $descProducto);
//error_log("stockParaVenta: " . $stockParaVenta);

if (!$stockParaVenta) {
    //    error_log("Ejecutando script");
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="gb18030">


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
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <title>IMPRESION DE VENTA</title>
    <?php
    $CVendedor = isset($_REQUEST['CVendedor']) ? $_REQUEST['CVendedor'] : "";
    $correo = isset($_REQUEST['correo']) ? $_REQUEST['correo'] : "";
    $anotacion = isset($_REQUEST['anotacion']) ? $_REQUEST['anotacion'] : "";
    $Cliente = isset($_REQUEST['cliente']) ? $_REQUEST['cliente'] : "";
    $ClienteID = isset($_REQUEST['cliente_ID']) ? $_REQUEST['cliente_ID'] : "";
    $RUC = isset($_REQUEST['ruc']) ? $_REQUEST['ruc'] : "";

    $pagacon = isset($_REQUEST['pagacon']) ? $_REQUEST['pagacon'] : "";
    $vuelto = isset($_REQUEST['vueltos']) ? $_REQUEST['vueltos'] : "";
    $numCopias = isset($_REQUEST['numCopias']) ? $_REQUEST['numCopias'] : 1;

    //$factura        = isset($_REQUEST['factura'])? $_REQUEST['factura'] : "";

    function limpia_espacios($cadena)
    {
        $cadena = str_replace(' ', '', $cadena);
        return $cadena;
    }

    function cambiarFormatoFecha($fecha)
    {
        list($anio, $mes, $dia) = explode("-", $fecha);
        return $dia . "/" . $mes . "/" . $anio;
    }

    function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    $nombcliente = $Cliente;
    if (strlen($ClienteID) > 0) {
        $sql = "SELECT codcli,descli,dnicli FROM cliente where codcli = '$ClienteID'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codcli = $row["codcli"];
                $descli = $row["descli"];
                $dnicli = $row["dnicli"];
                $nombcliente = $descli;
                mysqli_query($conexion, "UPDATE cliente set email = '$correo',ruccli='$RUC' where codcli = '$ClienteID'");
                mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
                mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
            }
        }
    }


    $rd = isset($_REQUEST['rd']) ? $_REQUEST['rd'] : "";
    $tarjeta = isset($_REQUEST['tarjeta']) ? $_REQUEST['tarjeta'] : "";


    if (($_REQUEST['cobrando'] <> '') && ($tarjeta <> '') && ($tarjeta <> 0)) {

        if (!is_numeric($tarjeta)) {
            $tarjeta = strtoupper($tarjeta);
            mysqli_query($conexion, "INSERT INTO tarjeta (nombre ) values ('$tarjeta')");
            $id_tarjeta = mysqli_insert_id($conexion);
            $tarjeta = $id_tarjeta;
        }
        $numeroTarjeta = $_REQUEST['numeroTarjeta'];
        $cobrando = $_REQUEST['cobrando'];

        mysqli_query($conexion, "UPDATE venta set forpag = 'T',codtab = '$tarjeta',numtarjet = '$numeroTarjeta',numeroCuota='0',mulVISA='$cobrando' where invnum = '$venta'");
    }

    //ADD MARJORIE
    if (($_REQUEST['cobrando'] <> '') && (($tarjeta == '') || ($tarjeta == 0)) && (($_REQUEST['montoYapePlin'] == '')||($_REQUEST['montoYapePlin'] == 0)) && ($_REQUEST['forpagVenta'] <> 'C')) {
        $forpag = 'E';
        $cobrando = $_REQUEST['cobrando'];
       
        $sqlpforpag   = "update venta set forpag = '$forpag',mulEfectivo='$cobrando' where invnum = '$venta'";

        $sqlpforpag  = arreglarSql($sqlpforpag);
        mysqli_query($conexion, $sqlpforpag);
    }

  

    if (($_REQUEST['mulEfectivo'] <> '') || ($_REQUEST['mulTarjeta'] <> '') || ($_REQUEST['mulMasterCard'] <> '') || ($_REQUEST['mulCanje'] <> '') && ($_REQUEST['montoYapePlin'] == '')) {
        $forpag = 'M';
        $mulEfectivo = $_REQUEST['mulEfectivo'];
        $mulTarjeta = $_REQUEST['mulTarjeta'];
        //$mulMasterCard = $_REQUEST['mulMasterCard'];
        $mulCanje = $_REQUEST['mulCanje'];

        $sqlpforpag   = "update venta set forpag = '$forpag',mulEfectivo='$mulEfectivo',mulVISA='$mulTarjeta',mulCanje='$mulCanje' where invnum = '$venta'";

        $sqlpforpag  = arreglarSql($sqlpforpag);
        mysqli_query($conexion, $sqlpforpag);
    }

    if (($_REQUEST['montoYapePlin'] <> '')) {
        $forpag = 'M';
        //$mulEfectivo = $_REQUEST['mulEfectivo'];
        //$mulTarjeta = $_REQUEST['mulTarjeta'];
        //$mulMasterCard = $_REQUEST['mulMasterCard'];
        $montoYapePlin = $_REQUEST['montoYapePlin'];
        $numeroYapePlin = $_REQUEST['numeroYapePlin'];

        $sqlpforpag   = "update venta set forpag = '$forpag',mulCanje='$montoYapePlin',numYapePlin='$numeroYapePlin' where invnum = '$venta'";

        $sqlpforpag  = arreglarSql($sqlpforpag);
        mysqli_query($conexion, $sqlpforpag);
    }

    $sqlp   = "update venta set anotacion='$anotacion', nomcliente = '$nombcliente',pagacon = '$pagacon', tipdoc = '$rd',vuelto = '$vuelto' where invnum = '$venta'";
    $sqlp  = arreglarSql($sqlp);
    mysqli_query($conexion, $sqlp);
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

<?php
mysqli_close($conexion);
?>

</html>