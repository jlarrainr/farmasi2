<?php
// Al ingresar por segunda vez, se activan las opciones de "tipo"
//$val = $_POST['val'];
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$tipo = "";
if ($val == 1) {
    //$tipo = $_POST['tipo'];
    $tipo = isset($_REQUEST['tipo']) ? ($_REQUEST['tipo']) : "";
}

$cod_delete = "";
// Si existen registros en "movmae" con "proceso" igual a "1" y del usuario conectado, capturar codigo
$sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $cod_delete = $row["invnum"];  //codigo
    }
    // Eliminar registros cuyo "invnum" est�0�1�0�8 en "proceso" igual a "1"
    mysqli_query($conexion, "DELETE FROM tempmovmov where invnum = '$cod_delete'");
    mysqli_query($conexion, "DELETE FROM movmov where invnum = '$cod_delete'");
    mysqli_query($conexion, "DELETE FROM movmae where invnum = '$cod_delete'");
}

$sql_datagen = "SELECT nlicencia FROM datagen";
$result_datagen = mysqli_query($conexion, $sql_datagen);
if (mysqli_num_rows($result_datagen)) {
    while ($row_datagen = mysqli_fetch_array($result_datagen)) {
        $nlicencia = $row_datagen['nlicencia'];
    }
}

$sql_datagen_det = "SELECT drogueria,activacionGuiaRemision FROM datagen_det";
$result_datagen_det = mysqli_query($conexion, $sql_datagen_det);
if (mysqli_num_rows($result_datagen_det)) {
    while ($row_datagen_det = mysqli_fetch_array($result_datagen_det)) {
        $drogueria = $row_datagen_det['drogueria'];
        $activacionGuiaRemision = $row_datagen_det['activacionGuiaRemision'];
    }
}
include 'acceso_movimientos.php';
?>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 60%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 3px;
        font-size: 18px;
        height: 40px;
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
        font-size: 20px;
        font-weight: 900;
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

    .LETRA2 {
        background: #d7d7d7
    }

    .radio {
        font-size: 30px;
        font-weight: 500;
        text-transform: capitalize;
        display: inline-block;
        vertical-align: middle;
        color: #fff;
        position: relative;
        padding-left: 30px;
        cursor: pointer;
    }

    .radio input[type="radio"] {
        display: none;

    }

    .radio span {
        height: 25px;
        width: 25px;
        border-radius: 50%;
        border: 3px solid #00aeef;
        display: block;
        position: absolute;
        left: 12px;
        top: 7px;
    }

    .radio span:after {
        content: "";
        height: 10px;
        width: 10px;
        background: #00aeef;
        display: block;
        position: absolute;
        left: 30%;
        top: 30%;
        transform: translate(-50%, -50%) scale(0);
        border-radius: 50%;
        transition: 300ms ease-in-out 0s;

    }

    .radio input[type="radio"]:checked~span:after {
        transform: translate(-50%, -50%) scale(1);
    }
</style>

<script>
    function mensaje() {
        alert("Esta opcion solo es para sistemas con locales mayor a un local");
    }

    function mensaje1() {
        alert("ESTA OPCION ES UNICAMENTE PARA BOTICAS *USAR OTRAS SALIDAS POR LOTES*");
    }

    function mensaje2() {
        alert("ESTA OPCION ES UNICAMENTE PARA SISTEMAS EN MODO DROGUERIA");
    }

    function mensaje3() {
        alert("PARA HABILITAR GUIAS DE REMISIÓN COMUNIQUESE CON UN ENCARGADO");
    }
</script>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
    <tr>
        <td width="714">
            <table width="100%" border="0">
                <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="5%" class="LETRA">
                                    <div align="left"><?php echo TEXT_FECHA; ?></div>
                                </td>
                                <td width="5%">
                                    <label>
                                        <div align="left">
                                            <input class="LETRA2" name="textfield2" type="text" size="10" disabled="disabled" value="<?php echo fecha($date); ?>" />
                                        </div>
                                    </label>
                                </td>
                                <td width="40%">
                                    <div align="right" class="LETRA">
                                        <input name="val" type="hidden" id="val" value="1" />
                                        <?php echo TEXT_TIPO_MOVIMIENTO; ?>
                                    </div>
                                </td>
                                <td width="15%">
                                    <div align="left">
                                        <select name="tipo" id="tipo" onchange="grabar()" style="width:200px;">
                                            <option value="1" <?php if ($tipo == 1) { ?>selected="selected" <?php } ?>><?php echo TEXT_INGRESO_DE_MERCADERIA; ?></option>
                                            <option value="2" <?php if ($tipo == 2) { ?>selected="selected" <?php } ?>><?php echo TEXT_SALIDA_DE_MERCADERIA; ?></option>
                                        </select>

                                    </div>
                                </td>
                                <td width="10%">
                                    <div align="center">

                                        <select name="regis" id="regis" onchange="grabar()" style="width:80px;">
                                            <option value="1" <?php if ($regis == 1) { ?>selected="selected" <?php } ?>><?php echo TEXT_REGISTRAR; ?></option>
                                            <?php ?><option value="2" <?php if ($regis == 2) { ?>selected="selected" <?php } ?>><?php echo TEXT_CONSULTAR; ?></option><?php ?>
                                        </select>
                                    </div>
                                </td>
                                <td width="15%">
                                    <div align="right">
                                        <input type="button" name="Submit" value="<?php echo TEXT_ACEPTAR; ?>" class="grabar" onclick="grabar()" />
                                        &nbsp;&nbsp;
                                        <input type="button" class="salir" name="Submit3" value="<?php echo TEXT_SALIR; ?>" onclick="salir()" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <hr />
                        <table width="100%" border="0">
                            <tr>
                                <td width="530">
                                    <div align="left"><span class="text_combo_select"><strong>LOCAL:</strong><img src="../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
                                </td>
                                <td width="261">
                                    <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
                                </td>
                            </tr>
                        </table>
                        <hr />
                        <?php
                        if ($val == 1) { // Esta parte se muestra cuando se ingresa por segunda vez al formulario
                            $tipo = $_POST['tipo'];
                        ?>
                            <input name="reg" type="hidden" id="reg" value="<?php echo $regis ?>" />
                            <input name="type" type="hidden" id="type" value="<?php echo $tipo ?>" />
                            <input name="date" type="hidden" id="date" value="<?php echo $date ?>" />
                            <br>

                            <?php
                            if ($tipo == 1) { // Ingreso de mercaderia
                            ?>
                                <!--<table width="467" border="0" align="center">
                                                                                                        <tr>
                                                                                                        <td><u><strong>INGRESO DE MERCADERIA <?php echo $regis_desc ?></strong></u></td>
                                                                                                        </tr>
                                                                                                        </table>-->
                                <input type="hidden" name="DatosProveedor" value="">
                                <!--<table width="467" border="0" align="center">
                                    <tr>
                                        <td>PROVEEDOR</td>
                                        <td>
                                            <select name="DatosProveedor" id="DatosProveedor">
                                                <option value="">Seleccione una Opci�0�1�0�6n</option>
                                <?php
                                $sql = "SELECT codpro,despro FROM proveedor order by despro";
                                $result = mysqli_query($conexion, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $s_prov = $row["codpro"];
                                ?>
                                                                                                        <option value="<?php echo $row["codpro"]; ?>" <?php if ($busca_prov == $s_prov) { ?> selected="selected"<?php } ?>><?php echo substr($row["despro"], 0, 55); ?></option>
                                    <?php
                                }
                                    ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>-->
                                <table width="100%" border="0" align="center" id="customers">
                                    <tr>
                                        <td colspan="3" align="center"><u><strong>INGRESO DE MERCADERIA <?php echo $regis_desc ?></strong></u></td>
                                    </tr>
                                    <tr>

                                        <th bgcolor="#50ADEA">
                                            <div align="center" class="titulos_movimientos">OPC</div>
                                        </th>
                                        <th bgcolor="#50ADEA">
                                            <div align="center" class="titulos_movimientos">
                                                <div align="left">MOVIMIENTOS</div>
                                            </div>
                                        </th>
                                        <th bgcolor="#50ADEA">
                                            <div align="center"></div>
                                        </th>
                                    </tr>
                                    <tr>

                                        <td width="32">
                                            <div align="center">1-</div>
                                        </td>
                                        <td width="379">
                                            <div align="left"><label for="I1">COMPRAS</label></div>
                                        </td>
                                        <td width="28">
                                            <label class="radiox">
                                                <input name="rd" id="I1" type="radio" value="1" onclick="validar()" <?php if ($m6 == 0) { ?> disabled="disabled" <?php } ?> /> &nbsp; &nbsp;

                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <div align="center">2-</div>
                                        </td>
                                        <td>
                                            <div align="left"><label for="I2">INGRESO POR TRANSFERENCIA DE SUCURSAL</label></div>
                                        </td>
                                        <td>
                                            <input name="rd" id="I2" type="radio" value="2" onclick="validar()" <?php if ($m7 == 0) { ?> disabled="disabled" <?php } ?> />
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <div align="center">3-</div>
                                        </td>
                                        <td>
                                            <div align="left"><label for="I3">NOTA DE CREDITO(DEVOLUCION EN BUEN ESTADO)</label> </div>
                                        </td>
                                        <td>
                                            <input name="rd" id="I3" type="radio" value="3" onclick="validar()" <?php if ($m8 == 0) { ?> disabled="disabled" <?php } ?> />
                                        </td>
                                    </tr>
                                    <!-- <tr>

                                        <td>
                                            <div align="center">3-</div>
                                        </td>
                                        <td>
                                            <div align="left"><label for="I4">CANJE AL LABORATORIO</label> </div>
                                        </td>
                                        <td>
                                            <?php /* ?><input name="rd" type="radio" value="4" onclick="validar()"/><?php */ ?> </td>
                                    </tr> -->
                                    <tr>

                                        <td>
                                            <div align="center">4-</div>
                                        </td>
                                        <td>
                                            <div align="left"><label for="I5">OTROS INGRESOS</label> </div>
                                        </td>
                                        <td>
                                            <input name="rd" id="I5" type="radio" value="5" onclick="validar()" <?php if ($m9 == 0) { ?> disabled="disabled" <?php } ?> />
                                        </td>
                                    </tr>
                                    <!-- <tr>

                                        <td>
                                            <div align="center">5-</div>
                                        </td>
                                        <td>
                                            <div align="left"><label for="I6">PREINGRESO</label> </div>
                                        </td>
                                        <td>
                                            <input name="rd" id="I6" type="radio" value="6" onclick="validar()" <?php if ($m10 == 0) { ?> disabled="disabled" <?php } ?> />
                                        </td>
                                    </tr> -->
                                </table>
                            <?php
                            } else { // Salida de mercaderia
                            ?>

                                <table width="100%" border="0" align="center" class="tabla2" id="customers">
                                    <tr>
                                        <td colspan="3" align="center"><u><strong>SALIDA DE MERCADERIA <?php echo $regis_desc ?></strong></u></td>
                                    </tr>
                                    <tr>

                                        <th bgcolor="#50ADEA">
                                            <div align="center" class="titulos_movimientos">OPC</div>
                                        </th>
                                        <th bgcolor="#50ADEA">
                                            <div align="center" class="titulos_movimientos">
                                                <div align="left">MOVIMIENTOS</div>
                                            </div>
                                        </th>
                                        <th bgcolor="#50ADEA">
                                            <div align="center"></div>
                                        </th>
                                    </tr>
                                    <tr>

                                        <td width="32">
                                            <div align="center">1-</div>
                                        </td>
                                        <td width="379">
                                            <div align="left">OTRAS SALIDAS </div>
                                        </td>
                                        <td width="28" <?php if ($drogueria == 1) { ?> onclick="mensaje1()" <?php } ?>>
                                            <input name="rd" type="radio" value="1" onclick="validar()" <?php if (($drogueria == 1) || ($m11 == 0)) { ?> disabled="disabled" title="ESTA OPCION ES UNICAMENTE PARA BOTICAS *USAR OTRAS SALIDAS POR LOTES*" <?php } ?> />
                                        </td>
                                    </tr>
                                    <!-- <tr>

                                        <td>
                                            <div align="center">2-</div>
                                        </td>
                                        <td>
                                            <div align="left">GUIAS DE REMISION </div>
                                        </td>
                                        <td>
                                            <?php /* ?> <input name="rd" type="radio" value="2" onclick="validar()"/>    <?php */ ?> </td>
                                    </tr> -->
                                    <tr>

                                        <td>
                                            <div align="center">2-</div>
                                        </td>
                                        <td>
                                            <div align="left">SALIDA POR TRANSFERENCIA DE SUCURSAL </div>
                                        </td>
                                        <td <?php if ($nlicencia == 1) { ?> onclick="mensaje()" <?php } ?>>
                                            <input name="rd" type="radio" value="3" onclick="validar()" <?php if (($nlicencia == 1) || ($m12 == 0)) { ?> disabled="disabled" title="Esta opcion solo es para sistemas con locales mayor a un local" <?php } ?> />
                                        </td>
                                    </tr>
                                    <!-- <tr>

                                        <td>
                                            <div align="center">4-</div>
                                        </td>
                                        <td>
                                            <div align="left">CANJE PROVEEDOR </div>
                                        </td>
                                        <td>
                                            <?php /* ?><input name="rd" type="radio" value="4" onclick="validar()"/> <?php */ ?> </td>
                                    </tr> -->
                                    <!-- <tr>

                                        <td>
                                            <div align="center">4-</div>
                                        </td>
                                        <td>
                                            <div align="left">PRESTAMOS CLIENTE </div>
                                        </td>
                                        <td>
                                            <?php /* ?> <input name="rd" type="radio" value="5" onclick="validar()"/>  <?php */ ?> </td>
                                    </tr> -->

                                    <tr>

                                        <td width="32">
                                            <div align="center">3-</div>
                                        </td>
                                        <td width="379" <?php if ($drogueria == 0) { ?> onclick="mensaje2()" <?php } ?>>
                                            <div align="left">OTRAS SALIDAS POR LOTE </div>
                                        </td>
                                        <td width="28">
                                            <input name="rd" type="radio" value="6" onclick="validar()" <?php if (($drogueria == 0) || ($m13 == 0)) { ?> disabled="disabled" title="ESTA OPCION ES UNICAMENTE PARA SISTEMAS EN MODO DROGUERIA" <?php } ?> />
                                        </td>
                                    </tr>


                                    <tr>

                                        <td>
                                            <div align="center">4-</div>
                                        </td>
                                        <td width="379" <?php if ($activacionGuiaRemision == 0) { ?> onclick="mensaje3()" <?php } ?>>
                                            <div align="left">GUIAS DE REMISIÓN </div>
                                        </td>
                                        <td width="28">
                                            <input name="rd" type="radio" value="2" onclick="validar()" <?php if (($activacionGuiaRemision == 0) || ($m14 == 0)) { ?> disabled="disabled"  title="PARA HABILITAR GUIAS DE REMISIÓN COMUNIQUESE CON UN ENCARGADO"<?php } ?> />
                                        </td>

                                    </tr>
                                </table>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</form>