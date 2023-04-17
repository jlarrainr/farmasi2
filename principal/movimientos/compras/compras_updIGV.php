<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

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
$codCompra      = isset($_REQUEST['cod']) ? ($_REQUEST['cod']) : "";
$ckigv          = isset($_REQUEST['ckigv']) ? ($_REQUEST['ckigv']) : "";

$ok           = isset($_REQUEST['ok']) ? ($_REQUEST['ok']) : "";
$msg           = isset($_REQUEST['msg']) ? ($_REQUEST['msg']) : "";
$busca_num      = isset($_REQUEST['nrocompra']) ? ($_REQUEST['nrocompra']) : "";
$busca_prov     = isset($_REQUEST['busca_prov']) ? ($_REQUEST['busca_prov']) : "";
$DatosProveedor = isset($_REQUEST['DatosProveedor']) ? ($_REQUEST['DatosProveedor']) : "";

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}

function FormatoMoneda($Valor)
{
    return number_format($Valor, 2, '.', ',');
}

if ($ckigv == 1) {
    $_SESSION['sesIGV'] = 1;
    $sesIGV             = 1;
} else {
    $_SESSION['sesIGV'] = 0;
    $sesIGV             = 0;
}

$Porcent                = 1;
$sqlPorcent = "SELECT porcent FROM datagen";
$resultPorcent = mysqli_query($conexion, $sqlPorcent);
if (mysqli_num_rows($resultPorcent)) {
    while ($row = mysqli_fetch_array($resultPorcent)) {
        $Porcent    = $row['porcent'];
    }
    $Porcent = 1 + ($Porcent / 100);
}

$igvPROD = 0;
$sqlMOV = "SELECT * FROM tempmovmov where invnum = '$codCompra' order by codtemp";
$resultMOV = mysqli_query($conexion, $sqlMOV);
if (mysqli_num_rows($resultMOV)) {
    while ($row = mysqli_fetch_array($resultMOV)) {
        $codtemp   = $row['codtemp'];
        $codpro    = $row['codpro'];
        $qtypro    = $row['qtypro'];    //CANTIDAD ENTEROS
        $qtyprf    = $row['qtyprf'];    //CANTIDAD FRACCION
        $pripro    = $row['pripro'];    //TEXT6
        $prisal    = $row['prisal'];    //TEXT2
        $costre    = $row['costre'];    //TEXT7
        $desc1     = $row['desc1'];
        $desc2     = $row['desc2'];
        $desc3     = $row['desc3'];
        $costpr    = $row['costpr'];    //CALCULO - PROMEDIO
        $canbon    = $row['canbon'];
        $tipbon    = $row['tipbon'];
        $conigv    = $row['conigv'];    //SI ES CON IGV
        $sqlx = "SELECT igv,stopro,factor,pcostouni,codpro FROM producto where codpro = '$codpro'";
        $resultx = mysqli_query($conexion, $sqlx);
        if (mysqli_num_rows($resultx)) {
            while ($rowx = mysqli_fetch_array($resultx)) {
                $igvPROD  = $rowx["igv"];
                $stopro   = $rowx["stopro"];
                $factor   = $rowx["factor"];
                $codpro   = $rowx["codpro"];


                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                    $pcostouni = $rowx["pcostouni"];
                } elseif ($precios_por_local == 0) {
                    $pcostouni = $rowx["pcostouni"];
                }

                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                    $sql_precio = "SELECT $pcostouni_p FROM precios_por_local where codpro = '$codpro'";
                    $result_precio = mysqli_query($conexion, $sql_precio);
                    if (mysqli_num_rows($result_precio)) {
                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                            $pcostouni = $row_precio[0];
                        }
                    }
                }
            }
        }

        if ($sesIGV == 1) {
            $cIGV   = 1;
            $pventa = ($prisal * $desc1 * $desc2 * $desc3);
        } else {
            if ($igvPROD == 1) {
                $cIGV   = 1;
                $pventa = $prisal * $desc1 * $desc2 * $desc3 * $Porcent;
            } else {
                $cIGV   = 0;
                $pventa = ($prisal * $desc1 * $desc2 * $desc3);
            }
        }

        $pventa = FormatoMoneda(round($pventa * 100) / 100);


        //INICIO LOS CALCULOS PARA VER EL TEMA DEL IGV
        /////HALLAR NUEVO COSTO PROMEDIO
        if ($qtyprf == "") {
            //ES NUMERO ENTERO
            $Total      = $qtypro * $pventa;
            $promedio   = FormatoMoneda(((($stopro / $factor) * $pcostouni) + ($qtypro * $pventa)) / (($stopro / $factor) + $qtypro));
        } else {
            //ES FRACCION
            $text_char  = convertir_a_numero($qtyprf);
            $Fact       = $text_char / $factor;
            $Total      = $Fact * $pventa;
            $promedio   = FormatoMoneda(((($stopro / $factor) * $pcostouni) + (($text_char / $factor) * $pventa)) / (($stopro / $factor) + ($text_char / $factor)));
        }

        $Total = FormatoMoneda(round($Total * 100) / 100);
        mysqli_query($conexion, "UPDATE tempmovmov SET conigv = $cIGV,costpr=$promedio,pripro=$pventa,costre=$Total WHERE codtemp = $codtemp ");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Generando Venta...</title>
    <script>
        function actualizaIGV() {
            var f = document.form1;
            f.action = "compras1.php";
            f.method = "post";
            f.submit();

        }
    </script>
</head>

<body onload="actualizaIGV();">
    <form name="form1" id="form1">
        <input name="ok" type="hidden" id="ok" value="<?php echo $ok ?>" />
        <input name="msg" type="hidden" id="msg" value="<?php echo $msg ?>" />
        <input name="nrocompra" type="hidden" id="nrocompra" value="<?php echo $nrocompra ?>" />
        <input name="busca_prov" type="hidden" id="busca_prov" value="<?php echo $busca_prov ?>" />
        <input name="DatosProveedor" type="hidden" id="DatosProveedor" value="<?php echo $DatosProveedor ?>" />
    </form>
</body>

</html>