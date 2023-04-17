<?php
include('../../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once("../../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../../funciones/funct_principal.php"); //DESHABILITA TECLAS
    require_once('../../../../funciones/botones.php'); //COLORES DE LOS BOTONES
    require_once('../../../../titulo_sist.php');
    //include('../../local.php');

    $close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";
    $entrada = isset($_REQUEST['entrada']) ? $_REQUEST['entrada'] : "";
    $id_arqueo = isset($_REQUEST['id_arqueo']) ? $_REQUEST['id_arqueo'] : "";
 

    $fecha_actual_arqueo = date('Y/m/d');
if($entrada <> 1){
    if ($entrada == 2) {
        $sql_arqueo = "SELECT fecha_inicio,hora_inicio,monto_inicio FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo'";
    } elseif ($entrada == 3) {
        $sql_arqueo = "SELECT fecha_inicio,hora_inicio,monto_inicio FROM arqueo_caja WHERE codigo_usuario='$usuario' and id='$id_arqueo'";
    }
    $result_arqueo = mysqli_query($conexion, $sql_arqueo);
    if (mysqli_num_rows($result_arqueo)) {
        while ($row1 = mysqli_fetch_array($result_arqueo)) {
            $fecha_inicio_o = $row1['fecha_inicio'];
            $hora_inicio_o = $row1['hora_inicio'];
            $monto_inicio_o = $row1['monto_inicio'];
        }
    }
}
    $fecha_presenta = fecha($fecha_inicio_o) . ' - ' . $hora_inicio_o;
    // echo '$arqueo = '.$arqueo;

    if ($entrada == 1) {
        $grabar_cierrre = 'Aperturar';
        $info = 'ARQUEO DE CAJA INICIO';
        $color = '#CCFF33';
    } elseif ($entrada == 2) {
        $grabar_cierrre = 'Grabar Cierre';
        $info = 'ARQUEO DE CAJA CIERRE';
        $color = '#305681';
    } elseif ($entrada == 3) {
        $grabar_cierrre = 'Grabar Cierre de Dia Anterior';
         $info = 'ARQUEO DE CAJA CIERRE DE DIA ' . fecha($fecha_inicio_o);
        $info2 = 'Usted sera notificado(a) a FARMASIS sobre el cierre de caja de un dia que no le corresponde al dia actual, gracias.';
        $color = '#fc5555';
    }

    ?>
    <script>
        // Si usuario pulsa tecla ESC, cierra ventana
        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }
    </script>
    <?php
    $hora_actual = date("H:i:s");
    function formato($c)
    {
        printf("%08d", $c);
    }

    function truncar($numero, $digitos)
    {
        $truncar = 10 ** $digitos;
        return intval($numero * $truncar) / $truncar;
    }

    $fecha_actual = date('d/m/Y');
    $fecha_actual_venta = date('Y-m-d');

    $sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nomusu = $row1['nomusu'];
            $codloc = $row1['codloc'];
        }
    }

    $sql1_fecha_inicio_cierre_anterior = "SELECT fecha_inicio  FROM arqueo_caja where id = '$id_arqueo'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_fecha_inicio_cierre_anterior = mysqli_query($conexion, $sql1_fecha_inicio_cierre_anterior);
    if (mysqli_num_rows($result1_fecha_inicio_cierre_anterior)) {
        while ($row1_fecha_inicio_cierre_anterior = mysqli_fetch_array($result1)) {
            $fecha_inicio_cierre_anterior = $row1_fecha_inicio_cierre_anterior['fecha_inicio'];
        }
    }






    if ($entrada == 2) {
        $sql1 = "SELECT  (invtot-(mulVISA+mulMasterCard+mulCanje)) as invtot,forpag FROM `venta` WHERE usecod='$usuario' and invfec='$fecha_actual_venta' and estado ='0' and val_habil='0'";
    } elseif ($entrada == 3) {
        $sql1 = "SELECT  (invtot-(mulVISA+mulMasterCard+mulCanje)) as invtot,forpag FROM `venta` WHERE usecod='$usuario' and invfec='$fecha_inicio_cierre_anterior' and estado ='0' and val_habil='0'";
    }
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $invtot = $row1['invtot'];
            $forpag = $row1['forpag'];

            if (($forpag == 'E')|| ($forpag == 'M')){
                $venta_efectivo += truncar($invtot, 1);
            } elseif ($forpag == 'T') {
                $venta_tarjeta += truncar($invtot, 1);
            } elseif ($forpag == 'C') {
                $venta_credito += truncar($invtot, 1);
            }
        }
    }






    ?>
    <title><?php echo $info; ?></title>
    <link href="../../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../../funciones/datatable/jquery.dataTables.min.js"></script>
    <style>
        body {
            background: #e9e9e9;

        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #FFFF66;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }

        .text_combo_select {
            font-family: Tahoma;
            font-size: 15px;
            line-height: normal;
            color: red;
            padding: 20px;
            font-weight: bolder;
        }
    </style>
    <script>
        function fc() {
            document.form1.inicio_caja.focus();
        }

        function fc2() {
            document.form1.monto_cierre.focus();
        }

        var statSend = false;

        function grabar_arqueo_caja() {

            if (!statSend) {
                var f = document.form1;
                var entrada = parseFloat(document.form1.entrada.value); //CANTIDAD

                if (entrada == 1) {
                    if ((f.inicio_caja.value == "") && (f.inicio_caja.value < 0)) {
                        alert("Ingrese el monto con el cual inicia en caja.");
                        f.inicio_caja.focus();
                        return;
                    }
                } else {
                    if ((f.monto_cierre.value == "") && (f.monto_cierre.value < 0)) {
                        alert("Ingrese el monto con el cual inicia en caja.");
                        f.monto_cierre.focus();
                        return;
                    }
                }
                ventana = confirm("Desea Grabar esta Informaci\u00F3n");
                if (ventana) {
                    f.method = "post";
                    f.action = "arqueo_caja_grabar.php";
                    f.submit();

                    statSend = true;
                    return true;
                } else {
                    return false;

                }


            } else {
                alert("El proceso esta siendo cargado espere un momento...");
                return false;
            }
        }



        function cerrar_popup() {
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php";
            self.close();
        }

        function cerrar_popup2() {
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir2.php";
            self.close();
        }
    </script>
</head>

<body onkeyup="cerrar(event)" <?php if ($close == 1) { ?> onload="cerrar_popup();" <?php } elseif ($close == 2) { ?> onload="cerrar_popup2();" <?php } else {   ?> <?php if ($entrada == 1) { ?> onload="fc()" <?php } else { ?> onload="fc2()" <?php } ?> <?php } ?>>

    <form name="form1">
        <table class="tabla2" width="100%" border="0">
            <tr>
                <td>
                    <table width="100%" border="0" align="center" bordercolor="#FFCC00" bgcolor="<?php echo $color; ?>">
                        <tr align="center">
                            <td style="color:#ffffff;font-size:15px;font-weight: bolder;"> <?php echo $info; ?> </td>
                        </tr>
                        <?php if ($entrada == 3) { ?>
                            <tr align="center">
                                <td style="color:#ffffff;font-size:10px;font-weight: bolder;">
                                    <blink><?php echo $info2; ?> </blink>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <div align="center"><img src="../../../../images/line2.jpg" width="100%" height="4" /></div>






                    <table width="100%">
                        <tr>
                            <td colspan="4">
                                <hr>
                            </td>
                        </tr>
                        <?php if ($entrada == 1) { ?>
                            <tr>
                                <td class="LETRA">Fecha Ingreso: </td>
                                <td> <?php echo $fecha_actual; ?></td>
                                <td class="LETRA"> Usuario: </td>
                                <td> <?php echo $nomusu; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Monto Inicio</td>
                                <td colspan="3">
                                    <input type="text" name="inicio_caja" id="inicio_caja" value="" onKeyPress="return decimal(event)" required />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>


                        <?php } elseif ($entrada == 2) { ?>
                            <tr>
                                <td class="LETRA">Fecha Ingreso: </td>
                                <td> <?php echo $fecha_presenta; ?></td>

                            </tr>
                            <tr>
                                <td class="LETRA">Fecha Cierre: </td>
                                <td colspan="3"> <?php echo $fecha_actual . ' - ' . $hora_actual; ?></td>

                            </tr>
                            <tr>
                                <td class="LETRA">Usuario: </td>
                                <td colspan="3"> <?php echo $nomusu; ?></td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Monto Inicio</td>
                                <td colspan="3">
                                    <input type="text" value="<?php echo $monto_inicio_o; ?>" readonly />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Monto Cierre</td>
                                <td colspan="3">
                                    <input type="text" name="monto_cierre" id="monto_cierre" value="" onKeyPress="return decimal(event)" required />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Otros Montos de Salida</td>
                                <td colspan="3">
                                    <input type="text" name="monto_agregado" id="monto_agregado" value="" onKeyPress="return decimal(event)" />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Detalle de Otros Montos de Salida</td>
                                <td colspan="3">
                                    <textarea name="detalle_monto_agregado" id='detalle_monto_agregado' rows="5" cols="25"></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>

                        <?php } elseif ($entrada == 3) {  ?>
                            <tr>
                                <td class="LETRA">Fecha Ingreso : </td>
                                <td> <?php echo $fecha_presenta; ?></td>

                            </tr>
                            <tr>
                                <td class="LETRA">Fecha Cierre: </td>
                                <td colspan="3"> <?php echo $fecha_actual . ' - ' . $hora_actual; ?></td>

                            </tr>
                            <tr>
                                <td class="LETRA">Usuario: </td>
                                <td colspan="3"> <?php echo $nomusu; ?></td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Monto Inicio</td>
                                <td colspan="3">
                                    <input type="text" value="<?php echo $monto_inicio_o; ?>" readonly />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Monto Cierre</td>
                                <td colspan="3">
                                    <input type="text" name="monto_cierre" id="monto_cierre" value="" onKeyPress="return decimal(event)" required />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Otros Montos de Salida</td>
                                <td colspan="3">
                                    <input type="text" name="monto_agregado" id="monto_agregado" value="" onKeyPress="return decimal(event)" />
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">Detalle de Otros Montos de Salida</td>
                                <td colspan="3">
                                    <textarea name="detalle_monto_agregado" id='detalle_monto_agregado' rows="5" cols="25"></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <b style="font-size: 7px;"> <?php echo ' FARMASIS se comunicara con el representante de ' . $desemp . ' ,para mejor control de la informacion.' ?> </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <hr>
                                </td>
                            </tr>

                        <?php } ?>
                        <tr>
                            <td colspan="4" align="center">
                                <input type="button" name="Submit" value="<?php echo $grabar_cierrre; ?>" onclick="grabar_arqueo_caja()" class="grabarventa" />
                                <input type="hidden" name="entrada" id="entrada" value="<?php echo $entrada; ?>" />
                                <input type="hidden" name="id_arqueo" id="id_arqueo" value="<?php echo $id_arqueo; ?>" />
                                <input type="hidden" name="venta_efectivo" id="venta_efectivo" value="<?php echo $venta_efectivo; ?>" />
                                <input type="hidden" name="venta_tarjeta" id="venta_tarjeta" value="<?php echo $venta_tarjeta; ?>" />
                                <input type="hidden" name="venta_credito" id="venta_credito" value="<?php echo $venta_credito; ?>" />
                            </td>
                        </tr>

                    </table>



                </td>
            </tr>
        </table>
    </form>
</body>

</html>