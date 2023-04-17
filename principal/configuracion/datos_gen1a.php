<?php
$facturacionElect = 0;
$MarcaImpresion = 0;
$TicketDefecto = 0;
$formadeimpresion = 0;
$ventablister = 0;
$venf8 = 0;
$vencipro = 0;

$sql = "SELECT desemp,porcent,direccionemp,rucemp, facturacionElect,MarcaImpresion,TicketDefecto, formadeimpresion,ventablister,venf8,puntosdiv,nopaga,fechavenci,vencipro,TicketDefectoMayorA ,contvistos,recordarsunat,alerta_masiva_sistema,precios_por_local,arqueo_caja,numerocopias,anular_venta_vendedor,nlicencia,codigo_hash,usuariosEspeciales_ArqueoCaja FROM datagen";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $desemp = $row["desemp"];
        $porcent = $row["porcent"];
        $direccionemp = $row["direccionemp"];
        $rucemp = $row["rucemp"];
        $facturacionElect = $row["facturacionElect"];
        $MarcaImpresion = $row["MarcaImpresion"];
        $TicketDefecto = $row["TicketDefecto"];
        $formadeimpresion = $row["formadeimpresion"];
        $ventablister = $row["ventablister"];
        $venf8 = $row["venf8"];
        $puntosdiv = $row["puntosdiv"];
        $nopaga = $row["nopaga"];
        $fechavenci = $row["fechavenci"];
        $vencipro = $row["vencipro"];
        $TicketDefectoMayorA = $row["TicketDefectoMayorA"];
        $contvistos = $row["contvistos"];
        $recordarsunat = $row["recordarsunat"];
        $alerta_masiva_sistema = $row["alerta_masiva_sistema"];
        $precios_por_local = $row["precios_por_local"];
        $arqueo_caja = $row["arqueo_caja"];
        $numerocopias = $row["numerocopias"];
        $anular_venta_vendedor = $row["anular_venta_vendedor"];
        $nlicencia = $row["nlicencia"];
        $codigo_hash = $row["codigo_hash"];
        $usuariosEspeciales_ArqueoCaja = $row["usuariosEspeciales_ArqueoCaja"];
    }
}

$sql = "SELECT drogueria,priceditable,selva FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $drogueria          = $row["drogueria"];
        $priceditable          = $row["priceditable"];
        $selva          = $row["selva"];
    }
}

if ($drogueria == 1) {
    $sms_drogueria = 'SU SISTEMA ESTA EN MODO DROGUERIA';
    $tipo = 'SISTEMA EN MODO:';
} else {
    $sms_drogueria = 'SU SISTEMA ESTA EN MODO BOTICA / FARMACIA';
    $tipo = 'SISTEMA EN MODO:';
}
$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $sucursal = $row['codloc'];
    }
}

$sqlUsuX = "SELECT for_continuo FROM xcompa where codloc = '$sucursal'";
$resultUsu2 = mysqli_query($conexion, $sqlUsuX);
if (mysqli_num_rows($resultUsu2)) {
    while ($row = mysqli_fetch_array($resultUsu2)) {
        $for_continuo = $row['for_continuo'];
    }
}
?>
<style>
    #div1 {
        overflow: scroll;
        height: 500px;
        width: 100%;
    }

    #div1 #customers {
        width: 100%;
        background-color: lightgray;
    }
</style>
<form id="form1" name="form1" method="post" onKeyUp="highlight(event)" onClick="highlight(event)">
    <table class="tabla2" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <fieldset style="width:98%;">
                    <legend style="color:brown;font-size:16px;"> <strong>DATOS GENERALES</strong></legend>
                    <div id="div1">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <fieldset style="width:98%; ">
                                        <legend style="color:royalblue;font-size:14px;"> <strong>DATOS DEL CLIENTE</strong></legend>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
                                            <tr>
                                                <th width="25%"> </th>
                                                <th width="25%"> </th>
                                                <th width="50%" align="center">
                                                    <div align="center">INFORMACION DE OPCION</div>
                                                </th>
                                            </tr>

                                            <tr>
                                                <td class="LETRA">RAZON SOCIAL:</td>
                                                <td>
                                                    <input name="desc" type="text" id="desc" size="60" value="<?php echo $desemp ?>" onKeyUp="this.value = this.value.toUpperCase();" required maxlength="255" onfocus="mensaje(1)" />
                                                </td>
                                                <td rowspan="14" align="justify">
                                                    <blink>

                                                        <a style="font-size:25px;" align="justify" id="informacion1"></a>

                                                    </blink>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA">DIRECCION FISCAL:</td>
                                                <td>
                                                    <input name="dir" type="text" id="dir" size="60" value="<?php echo $direccionemp ?>" onKeyUp="this.value = this.value.toUpperCase();" maxlength="255" onfocus="mensaje(2)" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA">RUC: </td>
                                                <td>
                                                    <input name="ruc" type="text" id="ruc" size="60" value="<?php echo $rucemp ?>" onKeyPress="return acceptNum(event)" maxlength="11" onfocus="mensaje(3)" />
                                                </td>
                                            </tr>
                                       </table>
                                    </fieldset>

                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <fieldset style="width:98%; ">
                                        <legend style="color:royalblue;font-size:14px;"> <strong>CONFIGURACION AVANZADA</strong></legend>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
                                            
                                            <tr>
                                                <td width="25%"class="LETRA">PORCENTAJE IGV (No mover)</td>
                                                <td width="25%">
                                                    <input name="igv" type="text" id="igv" onkeypress="return decimal(event)" size="10" value="<?php echo $porcent ?>" required onfocus="mensaje(4)" />
                                                </td>
                                                <td width="50%" rowspan="14" align="justify">
                                                    <blink>

                                                        <a style="font-size:25px;" align="justify" id="informacion2"></a>

                                                    </blink>
                                                </td>
                                            </tr>

                                            <tr title="<?php echo $sms_drogueria; ?>">
                                                <td class="LETRA">
                                                    <a id='tipo'></a>
                                                    <a id='tipo2'><?php echo $tipo; ?></a>

                                                </td>
                                                <td>
                                                    <div>
                                                        <label for="drogueria_SI" class="LETRA">
                                                            <input type="radio" name="drogueria" id="drogueria_SI" <?php if ($drogueria == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(5)">
                                                            Drogueria 
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="drogueria_NO" class="LETRA">
                                                            <input type="radio" name="drogueria" id="drogueria_NO" <?php if ($drogueria == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(6)">
                                                            Botica
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td class="LETRA">
                                                    SISTEMA PARA LA SELVA
                                                </td>
                                                <td>
                                                    <div>
                                                        <label for="selva_SI" class="LETRA">
                                                            <input type="radio" name="selva" id="selva_SI" <?php if ($selva == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(46)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="selva_NO" class="LETRA">
                                                            <input type="radio" name="selva" id="selva_NO" <?php if ($selva == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(47)">
                                                            NO
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="LETRA">NUMERO DE LICENCIAS</td>
                                                <td>
                                                    <input type="text" size="10" value="<?php echo $nlicencia ?>" readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA"> ¿DESEA MANEJAR COSTOS Y PRECIOS DIFERENTES PARA CADA LOCAL?</td>
                                                <td>
                                                    <div>
                                                        <label for="precios_por_local_SI" class="LETRA">
                                                            <input type="radio" name="precios_por_local" id="precios_por_local_SI" <?php if ($precios_por_local == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(19)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="precios_por_local_NO" class="LETRA">
                                                            <input type="radio" name="precios_por_local" id="precios_por_local_NO" <?php if ($precios_por_local == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(20)">
                                                            NO
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    </fieldset>

                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <fieldset style="width:98%; ">
                                        <legend style="color:royalblue;font-size:14px;"> <strong>CONFIGURACION AVANZADA DE VENTAS</strong></legend>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
                                            <tr>
                                                <td class="LETRA"> ¿DESEA ACTIVAR EL ARQUEO DE CAJA?</td>
                                                <td>
                                                    <div>

                                                        <label for="arqueo_caja_SI" class="LETRA">
                                                            <input type="radio" name="arqueo_caja" id="arqueo_caja_SI" <?php if ($arqueo_caja == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(21)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="arqueo_caja_NO" class="LETRA">
                                                            <input type="radio" name="arqueo_caja" id="arqueo_caja_NO" <?php if ($arqueo_caja == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(22)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="25%" class="LETRA"> ¿TICKET COMO COMPROBANTE POR DEFECTO?</td>
                                                <td width="25%">
                                                    <div>

                                                        <label for="TicketDefecto_SI" class="LETRA">
                                                            <input type="radio" name="TicketDefecto" id="TicketDefecto_SI" <?php if ($TicketDefecto == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(23)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="TicketDefecto_NO" class="LETRA">
                                                            <input type="radio" name="TicketDefecto" id="TicketDefecto_NO" <?php if ($TicketDefecto == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(24)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>
                                                <td width="50%" rowspan="14" align="justify">
                                                    <blink>

                                                        <a style="font-size:25px;" align="justify" id="informacion3"></a>

                                                    </blink>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA">BOLETA COMO COMPROBANTE POR DEFECTO A PARTIR DE: </td>
                                                <td>
                                                    <input name="TicketDefectoMayorA" type="text" id="TicketDefectoMayorA" onkeypress="return decimal(event)" size="10" value="<?php echo $TicketDefectoMayorA ?>" required onfocus="mensaje(38)" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA"> NUMERO DE COPIAS DEL COMPROBANTE DE PAGO</td>
                                                <td>
                                                    <div>

                                                        <label for="numerocopias_1" class="LETRA">
                                                            <input type="radio" name="numerocopias" id="numerocopias_1" <?php if ($numerocopias == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(25)">
                                                            1
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="numerocopias_2" class="LETRA">
                                                            <input type="radio" name="numerocopias" id="numerocopias_2" <?php if ($numerocopias == 2) { ?> checked="" <?php } ?> value="2" onfocus="mensaje(26)">
                                                            2
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="numerocopias_3" class="LETRA">
                                                            <input type="radio" name="numerocopias" id="numerocopias_3" <?php if ($numerocopias == 3) { ?> checked="" <?php } ?> value="3" onfocus="mensaje(27)">
                                                            3
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="numerocopias_4" class="LETRA">
                                                            <input type="radio" name="numerocopias" id="numerocopias_4" <?php if ($numerocopias == 4) { ?> checked="" <?php } ?> value="4" onfocus="mensaje(28)">
                                                            4
                                                        </label>

                                                    </div>
                                                </td>

                                            <tr>
                                                <td class="LETRA"> IMPRIMIR COMPROBANTE DE PAGO TAMA&Ntilde;O A4</td>
                                                <td id="A4">
                                                    <div>

                                                        <label for="formadeimpresion_SI" class="LETRA">
                                                            <input type="radio" name="formadeimpresion" id="formadeimpresion_SI" <?php if ($for_continuo == 1) { ?> disabled="disabled" <?php } ?> <?php if ($formadeimpresion == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(29)" onclick="A4_SI()">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="formadeimpresion_NO" class="LETRA">
                                                            <input type="radio" name="formadeimpresion" id="formadeimpresion_NO" <?php if ($for_continuo == 1) { ?> disabled="disabled" <?php } ?> <?php if ($formadeimpresion == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(30)" onclick="A4_NO()">
                                                            NO
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <strong> <a id="mensaje1" style="font-size: 15px;"></a></strong>
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="LETRA"> IMPRIMIR COMPROBANTE DE PAGO EN PAPEL CONTINUO </td>
                                                <td id="CONTINUO">
                                                    <div>

                                                        <label for="for_continuo_SI" class="LETRA">
                                                            <input type="radio" name="for_continuo" id="for_continuo_SI" <?php if ($formadeimpresion == 1) { ?> disabled="disabled" <?php } ?> <?php if ($for_continuo == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(31)" onclick="continuo_SI()">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="for_continuo_NO" class="LETRA">
                                                            <input type="radio" name="for_continuo" id="for_continuo_NO" <?php if ($formadeimpresion == 1) { ?> disabled="disabled" <?php } ?> <?php if ($for_continuo == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(32)" onclick="continuo_NO()">
                                                            NO
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <strong> <a id="mensaje2" style="font-size: 15px;"></a></strong>
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="LETRA"> BLOQUEAR LA VENTA POR CANTIDADES MENOR AL BLISTER </td>
                                                <td>
                                                    <div>

                                                        <label for="ventablister_SI" class="LETRA">
                                                            <input type="radio" name="ventablister" id="ventablister_SI" <?php if ($ventablister == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(33)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="ventablister_NO" class="LETRA">
                                                            <input type="radio" name="ventablister" id="ventablister_NO" <?php if ($ventablister == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(34)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="LETRA"> VENTA CON F8 NO GRABA CORRELATIVO </td>
                                                <td>
                                                    <div>

                                                        <label for="venf8_SI" class="LETRA">
                                                            <input type="radio" name="venf8" id="venf8_SI" <?php if ($venf8 == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(35)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="venf8_NO" class="LETRA">
                                                            <input type="radio" name="venf8" id="venf8_NO" <?php if ($venf8 == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(36)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="LETRA">LA CANTIDAD DE PUNTOS ACUMULADOS POR CADA SOL ES: </td>
                                                <td>
                                                    <input name="puntosdiv" type="text" id="puntosdiv" onkeypress="return decimal(event)" size="10" value="<?php echo $puntosdiv ?>" required onfocus="mensaje(37)" />
                                                </td>
                                            </tr>

                                            

                                            <tr>
                                                <td class="LETRA"> ¿DESEA DAR ACCESO A LOS VENDEDORES PARA ANULAR VENTAS? </td>
                                                <td>
                                                    <div>

                                                        <label for="anular_venta_vendedor_SI" class="LETRA">
                                                            <input type="radio" name="anular_venta_vendedor" id="anular_venta_vendedor_SI" <?php if ($anular_venta_vendedor == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(39)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="anular_venta_vendedor_NO" class="LETRA">
                                                            <input type="radio" name="anular_venta_vendedor" id="anular_venta_vendedor_NO" <?php if ($anular_venta_vendedor == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(40)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="LETRA"> ¿DAR ACCESO A LOS VENDEDORES PARA CAMBIAR PRECIOS EN LA VENTA? </td>
                                                <td>
                                                    <div>

                                                        <label for="priceditable_SI" class="LETRA">
                                                            <input type="radio" name="priceditable" id="priceditable_SI" <?php if ($priceditable == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(41)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="priceditable_NO" class="LETRA">
                                                            <input type="radio" name="priceditable" id="priceditable_NO" <?php if ($priceditable == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(42)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>

                                            </tr> 
                                            <tr>
                                                <td class="LETRA"> IMPRIMIR CON CODIGO HASH </td>
                                                <td>
                                                    <div>

                                                        <label for="codigo_hash_SI" class="LETRA">
                                                            <input type="radio" name="codigo_hash" id="codigo_hash_SI" <?php if ($codigo_hash == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(45)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="codigo_hash_NO" class="LETRA">
                                                            <input type="radio" name="codigo_hash" id="codigo_hash_NO" <?php if ($codigo_hash == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(46)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>

                                            </tr>
                                            
                                            <tr>
                                                <td class="LETRA"> ¿ACTIVAR BLOQUEO DE ARQUEO CAJA PARA ADMINISTRADORES DE SISTEMA? </td>
                                                <td>
                                                    <div>

                                                        <label for="usuariosEspeciales_ArqueoCaja_SI" class="LETRA">
                                                            <input type="radio" name="usuariosEspeciales_ArqueoCaja" id="usuariosEspeciales_ArqueoCaja_SI" <?php if ($usuariosEspeciales_ArqueoCaja == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(47)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="usuariosEspeciales_ArqueoCaja_NO" class="LETRA">
                                                            <input type="radio" name="usuariosEspeciales_ArqueoCaja" id="usuariosEspeciales_ArqueoCaja_NO" <?php if ($usuariosEspeciales_ArqueoCaja == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(48)">
                                                            NO
                                                        </label>

                                                    </div>
                                                </td>
                                            </tr> 
                                            
                                        </table>
                                    </fieldset>

                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <fieldset style="width:98%; ">
                                        <legend style="color:royalblue;font-size:14px;"> <strong>ALERTAS Y PAGOS</strong></legend>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
                                            <tr >
                                                <td width="25%" class="LETRA">VENCIMIENTO DE PAGO PARA CORTE</td>
                                                <td width="25%">
                                                    <div>
                                                        <input type="text" name="date1" id="date1" size="12" value="<?php echo $fecha_muestra; ?>" onfocus="mensaje(7)" />
                                                    </div>
                                                </td>
                                                <td width="50%" rowspan="14" align="justify">
                                                    <blink>

                                                        <a style="font-size:25px;" align="justify" id="informacion4"></a>

                                                    </blink>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA"> ¿MOSTRAR ALERTA DE PAGO? </td>
                                                <td>
                                                    <div>
                                                        <label for="nopaga_SI" class="LETRA">
                                                            <input type="radio" name="nopaga" id="nopaga_SI" <?php if ($nopaga == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(8)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="nopaga_NO" class="LETRA">
                                                            <input type="radio" name="nopaga" id="nopaga_NO" <?php if ($nopaga == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(9)">
                                                            NO
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="nopaga_CORTE" class="LETRA">
                                                            <input type="radio" name="nopaga" id="nopaga_CORTE" <?php if ($nopaga == 2) { ?> checked="" <?php } ?> value="2" onfocus="mensaje(10)">
                                                            CORTE
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA"> ¿MOSTRAR ALERTA DE VENCIMIENTOS DE LOS PRODUCTOS?</td>
                                                <td>
                                                    <div>
                                                        <label for="vencipro_SI" class="LETRA">
                                                            <input type="radio" name="vencipro" id="vencipro_SI" <?php if ($vencipro == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(11)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="vencipro_NO" class="LETRA">
                                                            <input type="radio" name="vencipro" id="vencipro_NO" <?php if ($vencipro == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(12)">
                                                            NO
                                                        </label>


                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA"> ¿DESEA QUE EL SISTEMA LE ALERTE EN CASO DE OLVIDAR ENVIAR COMPROBANTES A SUNAT?</td>
                                                <td>
                                                    <div>
                                                        <label for="recordarsunat_SI" class="LETRA">
                                                            <input type="radio" name="recordarsunat" id="recordarsunat_SI" <?php if ($recordarsunat == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(13)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="recordarsunat_NO" class="LETRA">
                                                            <input type="radio" name="recordarsunat" id="recordarsunat_NO" <?php if ($recordarsunat == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(14)">
                                                            NO
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA">CONTEO DE VISTAS DE ALERTA DE PAGO</td>
                                                <td>
                                                    <input type="text" size="10" value="<?php echo $contvistos ?>" readonly onfocus="mensaje(15)" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA">FECHA DE MENSAJE DE ALERTA MASIVA</td>
                                                <td>
                                                    <div>
                                                        <input type="text" name="date2" id="date2" size="12" value="<?php echo $fecha_muestra2; ?>" onfocus="mensaje(16)" />
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="LETRA"> ALERTA MASIVA</td>
                                                <td>
                                                    <div>
                                                        <label for="alerta_masiva_sistema_SI" class="LETRA">
                                                            <input type="radio" name="alerta_masiva_sistema" id="alerta_masiva_sistema_SI" <?php if ($alerta_masiva_sistema == 1) { ?> checked="" <?php } ?> value="1" onfocus="mensaje(17)">
                                                            SI
                                                        </label>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <label for="alerta_masiva_sistema_NO" class="LETRA">
                                                            <input type="radio" name="alerta_masiva_sistema" id="alerta_masiva_sistema_NO" <?php if ($alerta_masiva_sistema == 0) { ?> checked="" <?php } ?> value="0" onfocus="mensaje(18)">
                                                            NO
                                                        </label>


                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>

                                </td>

                            </tr>

                        </table>
                    </div>
                </fieldset>
                <br><br>
            </td>
        </tr>
    </table>
    <table class="tabla2" width="100%" border="0" align="center">
        <tr>
            <td><label>
                    <div align="right">
                        <input name="btn" type="hidden" id="btn" />
                        <input type="button" name="Submit2" value="Grabar" onclick="save_datosgen1()" class="grabar" />
                        <input type="button" name="Submit" value="Salir" onclick="salir1()" class="salir" />
                    </div>
                </label></td>
        </tr>
    </table>
</form>