<?php
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../session_user.php');
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}
/*$cod        = $_POST['cod'];   ///invnum
$referencia = $_POST['referencia']; ///referencia
$local_dest = $_POST['local'];   ///local
$vendedor   = $_POST['vendedor'];  ///vendedor destino
$mont2      = $_POST['mont2']; ///monto total
*/

$numdocreg = isset($_REQUEST['numdocreg']) ? $_REQUEST['numdocreg'] : ""; //F8,F9

$cod = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : ""; //F8,F9
$referencia = isset($_REQUEST['referencia']) ? $_REQUEST['referencia'] : ""; //F8,F9
$local_dest = isset($_REQUEST['local']) ? $_REQUEST['local'] : ""; //F8,F9
$vendedor = isset($_REQUEST['vendedor']) ? $_REQUEST['vendedor'] : ""; //F8,F9
$mont2 = isset($_REQUEST['mont2']) ? $_REQUEST['mont2'] : ""; //F8,F9

// require_once('../tabla_local.php');


$sqlClienteRuc = "SELECT codcli,descli,ruccli FROM cliente where codloc = '$local_dest' and   descli <> 'PUBLICO EN GENERAL' and ruccli<>'' and CHARACTER_LENGTH(ruccli)=11";
$resultClienteRuc = mysqli_query($conexion, $sqlClienteRuc);
if (mysqli_num_rows($resultClienteRuc)) {
    while ($rowClienteRuc = mysqli_fetch_array($resultClienteRuc)) {
        $codcli = $rowClienteRuc['codcli'];
        $descli = $rowClienteRuc['descli'];
        $ruccli = $rowClienteRuc['ruccli'];
    }
    $activoFacura = 1;
    $descripcionCliente = 'La venta sera asignado al cliente : ' . $descli . ' ,con el RUC: ' . $ruccli;

    $facturaDefecto = 1;
} else {
    $sqlClienteDNI = "SELECT codcli,descli,dnicli FROM cliente where codloc = '$local_dest' and   descli <> 'PUBLICO EN GENERAL' and dnicli<>'' and CHARACTER_LENGTH(dnicli)=8";
    $resultClienteDNI = mysqli_query($conexion, $sqlClienteDNI);
    if (mysqli_num_rows($resultClienteDNI)) {
        while ($rowClienteDNI = mysqli_fetch_array($resultClienteDNI)) {
            $codcli = $rowClienteDNI['codcli'];
            $descli = $rowClienteDNI['descli'];
            $dnicli = $rowClienteDNI['dnicli'];
        }
        $activoFacura = 0;
        $descripcionCliente = 'La venta sera asignado al cliente : ' . $descli . ' ,con el DNI: ' . $dnicli;
        $boletaDefecto = 1;
    } else {
        $activoFacura = 0;
        $descripcionCliente = 'La venta sera asignado al cliente : PUBLICO EN GENERAL ';
    }
}

$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
    }
}

$numero_xcompa = substr($nomloc, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
$resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
if (mysqli_num_rows($resultP_drogueria)) {
    while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
        $drogueria = $row_drogueria['drogueria'];
    }
}


$sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod' order by codtemp ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $codpro = $row['codpro'];
        $qtypro = $row['qtypro'];
        $qtyprf = $row['qtyprf'];
        $pripro = $row['pripro'];
        $costre = $row['costre'];
        $costpr = $row['costpr'];
        $numlote = $row['numlote'];


        $sql1 = "SELECT factor,stopro,$tabla,desprod FROM producto where codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $factor     = $row1['factor'];
                $stopro     = $row1['stopro'];
                $cant_loc1   = $row1[2];
                $desprod    = $row1['desprod'];

                if ($drogueria == 1) {

                    $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                    $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                    if (mysqli_num_rows($result1_movlote)) {
                        while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                            $stock_movlote = $row1_movlote[0];
                        }
                    }

                    $cant_loc = $stock_movlote;
                } else {

                    $cant_loc = $cant_loc1;
                }
            }
        }

        if ($qtyprf <> "") {
            $text_char = convertir_a_numero($qtyprf);
            $cant_unid = $text_char;
        } else {
            $cant_unid = $qtypro * $factor;
        }
        if ($cant_loc < $cant_unid) {
?>

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta charset="euc-jp">

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

                    .LETRA {
                        font-family: Tahoma;
                        font-size: 11px;
                        line-height: normal;
                        color: '#5f5e5e';
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
                </style>
                <script LANGUAGE="JavaScript">
                    alert("Eliminar de la lista los productos que no cuentan con stock disponible(fondo rojo) ");
                    window.opener.location.reload(true);
                    window.close();
                </script>

            </head>

            <body>
            </body>



<?php

        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <link href="../ventas/css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="../ventas/css/tabla2.css" rel="stylesheet" type="text/css" />
    <title><?php echo $desemp ?></title>
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript">
        function fc() {
            document.form1.country.focus();
        }

        function cerrar_popup() {
            window.close();
        }

        function escapes(e) {
            tecla = e.keyCode;
            if (tecla === 27) {
                window.close();
            }
            if (tecla === 13) {
                var f = document.form1;

                if (confirm("¿Desea Grabar esta informacion?")) {
                    alert("EL NUMERO REGISTRADO ES " + <?php echo $numdocreg ?>);
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "imprimirnuevo.php";
                    f.submit();
                }
            }
        }


        function sf() {
            var f = document.form1;
            // f.correo.focus();
            f.anotacion.focus();

        }

        function grabar() {
            var f = document.form1;
            if (confirm("¿Desea Grabar esta informacion?")) {
                alert("EL NUMERO REGISTRADO ES " + <?php echo $numdocreg ?>);
                f.method = "POST";
                f.target = "_top";
                f.action = "imprimirnuevo.php";
                f.submit();
            }
        }
    </script>
    <?php
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once('../../../funciones/functions.php'); //DESHABILITA TECLAS
    require_once('../../../funciones/highlight.php'); //ILUMINA CAJAS DE TEXTOS
    require_once('../../../funciones/botones.php'); //COLORES DE LOS BOTONES




    $TicketDefecto = 0;
    $numCopias = 1;
    $sqlGen = "SELECT montoboleta,TicketDefecto, numerocopias FROM datagen"; ////por defecto 5
    $resultGen = mysqli_query($conexion, $sqlGen);
    if (mysqli_num_rows($resultGen)) {
        while ($row = mysqli_fetch_array($resultGen)) {
            $montoboleta = $row["montoboleta"];
            $TicketDefecto = $row["TicketDefecto"];
            $numCopias = $row["numerocopias"];
        }
    }


    function formato($c)
    {
        printf("%08d", $c);
    }


    ?>
</head>

<body onkeyup="escapes(event)" onload="sf();">
    <table width="100%" height="535" border="1">
        <tr>
            <td height="372" bgcolor="#f0f0f0">
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="398">
                            <?php

                            $FactDefecto = 0;
                            $BolDefecto = 0;
                            $TickDefecto = 0;
                            if ($TicketDefecto == 1) {
                                $titulo = "EL NUMERO REGISTRADO ES : ";
                                $color = "#3398db";
                                $FactDefecto = 0;
                                $BolDefecto = 0;
                                $TickDefecto = 1;
                            } else {
                                $FactDefecto = 0;
                                $BolDefecto = 1;
                                $TickDefecto = 0;
                                $titulo = "EL NUMERO REGISTRADO ES :";
                                $color = "#3398db";
                            }
                            ?>
                            <center>
                                <font color="<?php echo $color; ?>" size="+3"><b><?php echo $titulo . " " . $numdocreg; ?></b></font>
                            </center>
                        </td>
                    </tr>
                </table>
                <br /><br />
                <table width="90%" height="150" border="0" align="center" class="tabla2">
                    <tr>
                        <td width="650"><u><strong>IMPRESION DE VENTAS EN TRANSFERENCIA</strong></u><br>

                            <form id="form1" name="form1">

                                <table width="100%" border="0" align="center">


                                    <tr>
                                        <td colspan="4">TIPO DOCUMENTO </td>


                                    </tr>
                                    <tr>
                                        <?php if ($activoFacura == 1) { ?>

                                            <td align="center">
                                                <input type="radio" value="1" name="rd" id="factura" <?php if ($facturaDefecto == 1) { ?>checked<?php } ?> />
                                                <label for="factura" style='color:red;font-size: 23px;'><b>FACTURA</b></label>
                                            </td>
                                            <td align="center"> <input type="radio" value="3" name="rd" id="ninguno" />
                                                <label for="ninguno" style='color:#9886fe;font-size: 23px;'><b>NINGUNO</b></label>
                                            </td>
                                        <?php } else { ?>

                                            <td align="center"> <input type="radio" value="2" name="rd" id="boleta" <?php if ($boletaDefecto  == 1) { ?>checked<?php } ?> />
                                                <label for="boleta" style='color:blue;font-size: 23px;'><b>BOLETA</b></label>
                                            </td>
                                            <td align="center"> <input type="radio" value="4" name="rd" id="ticket" />
                                                <label for="ticket" style='color:green;font-size: 23px;'><b>TICKET</b></label>
                                            </td>
                                            <td align="center"> <input type="radio" value="3" name="rd" id="ninguno" />
                                                <label for="ninguno" style='color:#9886fe;font-size: 23px;'><b>NINGUNO</b></label>
                                            </td>

                                        <?php  } ?>




                                    </tr>

                                    <tr>
                                        <td colspan="4"><span style="color:#508bbf;font-size: 18px;">
                                                <blink> <?php echo  $descripcionCliente; ?> </blink>
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="4">
                                            <input type="button" name="Submit" value="GRABAR" onclick="grabar();" onkeypress="enter(event);" class="grabar" />

                                            <input type="hidden" name="cod" id="cod" value="<?php echo $cod; ?>" />
                                            <input type="hidden" name="referencia" id="referencia" value="<?php echo $referencia; ?>" />
                                            <input type="hidden" name="local" id="local" value="<?php echo $local_dest; ?>" />
                                            <input type="hidden" name="vendedor" id="vendedor" value="<?php echo $vendedor; ?>" />
                                            <input type="hidden" name="mont2" id="mont2" value="<?php echo $mont2; ?>" />


                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    mysqli_close($conexion);
    ?>
</body>

</html>