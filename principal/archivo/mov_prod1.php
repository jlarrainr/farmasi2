<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" enctype="multipart/form-data">

    <center>
        <div class="botones">
            <table width="100%" border="0">
                <tr>
                    <td width="50%">

                        <div align="left">
                            <?php
                            if ($ver != 1) {
                                $firstpage = 1;
                                $prevpage = $pageno - 1;
                                $nextpage = $pageno + 1;
                                $lastpage = $lastpage;
                            }


                            $sql1 = "SELECT codpro FROM kardex where codpro = '$codpro'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                $elimi = "1";
                            }

                            $sql = "SELECT stopro,SUM(s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020) as sumato FROM producto where codpro = '$codpro'";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $stopro = $row["stopro"];
                                    $sumato = $row["sumato"];
                                }
                            }
                            ?>


                            <input name="firstpage" type="hidden" id="firstpage" value="<?php echo $firstpage ?>" />
                            <input name="prevpage" type="hidden" id="prevpage" value="<?php echo $prevpage ?>" />
                            <input name="nextpage" type="hidden" id="nextpage" value="<?php echo $nextpage ?>" />
                            <input name="lastpage" type="hidden" id="lastpage" value="<?php echo $lastpage ?>" />
                            <input name="ppg" type="hidden" id="ppg" value="<?php echo $pageno ?>" />
                            <input name="pageno" type="hidden" id="pageno" />

                            <input name="first" type="button" id="first" value="Primero" <?php if (($pageno == 1) || ($search == 1)) { ?> disabled="disabled" <?php } ?> class="primero" onClick="primero()" />
                            <input name="prev" type="button" id="prev" value="Anterior" <?php if (($pageno == 1) || ($search == 1)) { ?> disabled="disabled" <?php } ?> class="anterior" onClick="anterior()" />
                            <input name="next" type="button" id="next" value="Siguiente" <?php if (($pageno == $lastpage) || ($search == 1) || ($numrows == 0)) { ?> disabled="disabled" <?php } ?> class="siguiente" onClick="siguiente()" />
                            <input name="fin" type="button" id="fin" value="Ultimo" <?php if (($pageno == $lastpage) || ($search == 1) || ($numrows == 0)) { ?> disabled="disabled" <?php } ?> class="ultimo" onClick="ultimo()" />
                        </div>

                    </td>
                    <!-- <td width="9">&nbsp;</td> -->
                    <td width="50%">

                        <div align="right">
                            <input name="cod_nuevo" type="hidden" id="cod_nuevo" />
                            <input name="price33" type="hidden" id="price33" />
                            <input name="price44" type="hidden" id="price44" />
                            <input name="drogueria" type="hidden" id="drogueria" value="<?php echo $drogueria ?>" />
                            <input name="selva" type="hidden" id="selva" value="<?php echo $selva ?>" />
                            <input name="fincod" type="hidden" id="fincod" value="<?php echo $fincod ?>" />
                            <input name="cod_modif_del" type="hidden" id="cod_modif_del" value="<?php echo $codpro ?>" />
                            <input name="val" type="hidden" id="val" />
                            <input name="btn" type="hidden" id="btn" />
                            <input name="paginas" type="hidden" id="paginas" value="<?php echo $pageno ?>" />
                            <input name="printer" type="button" id="printer" value="infor" onClick="producto()" class="imprimir" />
                            <input name="nuevo" type="button" id="nuevo" value="Nuevo" onClick="buton2()" class="nuevo" />
                            <input name="modif" type="button" id="modif" value="Modificar" onClick="buton3()" class="modificar" <?php if ($numrows == 0) { ?>disabled="disabled" <?php } ?> />
                            <input name="save" type="button" id="save" value="Grabar" onClick="validar()" class="grabar" />
                            <input name="del" type="button" id="del" value="Eliminar" <?php if ($elimi == 1) { ?>onClick="eliminarkardex()" <?php } elseif ($sumato > 0) { ?>onClick="eliminarstock()" <?php } else { ?> onClick="eliminar()" <?php } ?> class="eliminar" <?php if ($numrows == 0) { ?>disabled="disabled" <?php } ?> />
                            <input name="" type="submit" id="ext" value="Cancelar" class="cancelar" />
                            <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />

                        </div>
                    </td>


                </tr>
            </table>
        </div>
    </center>

    <table width="100%" border="0">
        <tr>
            <td width="50%">
                <div align="left"><span class="text_combo_select"><strong>LOCAL:</strong><img src="../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
            </td>
            <td width="50%">
                <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
            </td>
        </tr>
    </table>
    <img src="../../images/line2.jpg" width="100%" height="4" />



    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td width="25%" class="LETRA">
                C&OacuteDIGO INT
            </td>
            <td width="30%">
                <input name="codigo" type="text" class="Estilodany" id="codigo" value="<?php echo formato($codpro) ?>" />
                <input name="codigo_barras" type="hidden" id="codigo_barras" value="<?php echo $codpro ?>" />
            </td>
            <td width="45%" class="LETRA">
                INFORMACI&OacuteN DEL PRODUCTO
            </td>
        </tr>
        <tr>
            <td class="LETRA">
                Nombre y descripci&oacuten del Producto
            </td>
            <td>
                <input tabindex="1" name="des" type="text" class="Estilodany" id="des" value="<?php echo $desprod ?>" size="60" onKeyUp="this.value = this.value.toUpperCase();" onChange="conmayus(this)" />
            </td>

            <td rowspan="3">
                <table border="0" width="100%">
                    <tr>
                        <td width="50%" rowspan="3">
                            <textarea name="textdesc" cols="50" rows="5" class="Estilodany" onChange="conmayus(this)"><?php echo $detpro ?>
                            </textarea>
                        </td>
                        <td width="25%" class="LETRA">ACTIVO PARA VENTAS </td>
                        <td width="10%">
                            <select name="rd" class="Estilodany" id="rd" style='width:50px;'>
                                <option <?php if ($activo == 1) { ?> selected="selected" <?php } ?> value="1">SI</option>
                                <option <?php if ($activo == 0) { ?> selected="selected" <?php } ?> value="0">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="LETRA">ACTIVO PARA COMPRAS </td>
                        <td>
                            <select name="rd1" class="Estilodany" id="rd1" style='width:50px;'>
                                <option <?php if ($activo1 == 1) { ?> selected="selected" <?php } ?> value="1">SI</option>
                                <option <?php if ($activo1 == 0) { ?> selected="selected" <?php } ?> value="0">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="LETRA">MONEDA</td>
                        <td>
                            <select name="moneda" class="Estilodany" id="moneda" style='width:55px;'>
                                <option value="S" <?php if ($moneda == "S") { ?>selected="selected" <?php } ?>>SOLES</option>
                                <option value="D" <?php if ($moneda == "D") { ?>selected="selected" <?php } ?>>DOLARES</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>

            <td class="LETRA">¿Cu&aacutentas unidades vienen en el producto para la venta? (FACTOR)</td>
            <td>
                <input tabindex="2" name="factor" type="text" class="Estilodany" id="factor" onkeypress="return acceptNum(event)" value="<?php echo $factor ?>" size="12" maxlength="4" onKeyUp="precio();" />
                <input name="fact" type="hidden" id="fact" value="<?php echo $factor ?>" />
                <!--<input name="inc" type="checkbox" id="inc" value="1" <?php if ($inc == 1) { ?>checked="checked" <?php } ?> disabled="disabled" />
                Incentivo para Producto-->
            </td>
        </tr>
        <tr>

            <td class="LETRA">¿Cu&aacutentas unidades contiene un blister?</td>
            <td>
                <label>
                    <input tabindex="3" name="blister" type="text" class="Estilodany" id="blister" onKeyPress="return acceptNum(event)" value="<?php echo $blister ?>" size="12" maxlength="4" />
                    <input name="lotec" type="checkbox" id="lotec" value="1" <?php if ($lotec == 1) { ?>checked="checked" <?php } ?> />
                    <label tabindex="4" for="lotec" class="LETRA">Marcar si este producto tiene vencimiento</label>
                </label>
            </td>

        </tr>
        <tr>

        <tr>
            <td class="LETRA">¿A qu&eacute laboratorio o marca pertenece?</td>
            <td>
                <label>
                    <select tabindex="5" style='width:350px;' id="marca" name="marca">
                        <option value="0">Seleccionar...</option>
                        <?php
                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $marca = $row["codtab"];
                            if ($codmar == $marca) {
                                $activa1 = 1;
                            }
                        ?>
                            <option value="<?php echo $row["codtab"] ?>" <?php if ($codmar == $marca) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:openPopup('regmarca.php?val=1')">
                        <img src="../../images/add.gif" border="0" />
                    </a>
                </label>
            </td>

            <td rowspan="15">
                <iframe src="busca_prod/busca_prod.php" name="iFrame1" width="100%" height="600" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0"> </iframe>
            </td>
        </tr>
        <tr>
            <td class="LETRA">¿Cu&aacutel es su principio activo? </td>
            <td>
                <label>
                    <select tabindex="6" style='width:350px;' id="line" name="line">
                        <option value="0">Seleccionar...</option>
                        <?php
                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'F' order by destab";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $familia = $row["codtab"];
                            if ($codfam == $familia) {
                                $activa2 = 1;
                            }
                        ?>
                            <option value="<?php echo $row["codtab"] ?>" <?php if ($codfam == $familia) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:openPopup('reglinea.php?val=2')"><img src="../../images/add.gif" border="0" />
                    </a>
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">¿Cu&aacutel es su acci&oacuten terap&eacuteutica?</td>
            <td>
                <label>
                    <select tabindex="7" style='width:350px;' id="clase" name="clase">
                        <option value="0">Seleccionar...</option>
                        <?php
                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'U' order by destab";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $uso = $row["codtab"];
                            if ($coduso == $uso) {
                                $activa3 = 1;
                            }
                        ?>
                            <option value="<?php echo $row["codtab"] ?>" <?php if ($coduso == $uso) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:openPopup('regclase.php')"><img src="../../images/add.gif" border="0" />
                    </a>
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">Seleccione su presentaci&oacuten</td>
            <td><label>
                    <select tabindex="8" style='width:350px;' id="present" name="present">
                        <option value="0">Seleccionar...</option>
                        <?php
                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'PRES' order by destab";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $pres = $row["codtab"];
                            if ($codpres == $pres) {
                                $activa3 = 1;
                            }
                        ?>
                            <option value="<?php echo $row["codtab"] ?>" <?php if ($codpres == $pres) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:openPopup('regad.php')"><img src="../../images/add.gif" border="0" />
                    </a>
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">Seleccione su categor&iacutea</td>
            <td><label>
                    <select tabindex="8" style='width:350px;' id="categoria" name="categoria">
                        <option value="0">Seleccionar...</option>
                        <?php
                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'CAT' order by destab";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $cat = $row["codtab"];
                            if ($coduso == $cat) {
                                $activa5 = 1;
                            }
                        ?>
                            <option value="<?php echo $row["codtab"] ?>" <?php if ($codcatp == $cat) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["destab"]) ?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:openPopup('reg_categoria.php')"><img src="../../images/add.gif" border="0" />
                    </a>
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">C&oacutedigo Producto - Digemid </td>
            <td>
                <label>
                    <input name="digemid" disabled="disabled" type="text" class="Estilodany" id="digemid" value="<?php echo $digemid; ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">C&oacutedigo Gen&eacuterico - Digemid</td>
            <td>
                <label>
                    <input name="cod_generico" disabled="disabled" type="text" class="Estilodany" id="cod_generico" value="<?php echo $cod_generico; ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">Registro Sanitario</td>
            <td>
                <label>
                    <input name="registrosanitario" disabled="disabled" type="text" class="Estilodany" id="registrosanitario" value="<?php echo $registrosanitario; ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">C&oacutedigo de barras </td>
            <td>
                <label>
                    <input name="cod_bar" type="text" class="Estilodany" id="cod_bar" onkeypress="return acceptNum(event)" value="<?php echo $codbar ?>" onblur="validarCodigodebarras(cod_bar,codigo_barras);" />

                </label>
                <a id="comprobado_codigo_barra"><strong></strong></a>
            </td>
        </tr>
        <tr>
            <td class="LETRA">Marcar si este producto es afecto al IGV</td>
            <td>
                <input name="igv" type="checkbox" id="igv" value="1" <?php if ($igv == 1) { ?>checked="checked" <?php } ?> />
            </td>
        </tr>
        <tr>
            <td class="LETRA">Marcar si este producto es parte del Listado COVID-19</td>
            <td>
                <input name="covid" type="checkbox" id="covid" value="1" <?php if ($covid == 1) { ?>checked="checked" <?php } ?> />
            </td>
        </tr> 
        <tr>
            <td class="LETRA">Activo para Puntos</td>
            <td>
                <input name="activoPuntos" type="checkbox" id="activoPuntos" value="1" <?php if ($activoPuntos == 1) { ?>checked="checked" <?php } ?> />
            </td>
        </tr>
        <tr>
            <td class="LETRA">ICBPER</td>
            <td>
                <input name="icbper" type="checkbox" id="icbper" value="1" <?php if ($icbper == 1) { ?>checked="checked" <?php } ?> />
            </td>
        </tr>
        <tr>
            <td class="LETRA">Producto con Receta Medica</td>
            <td>
                <input name="recetaMedica" type="checkbox" id="recetaMedica" value="1" <?php if ($recetaMedica == 1) { ?>checked="checked" <?php } ?> />
            </td>
        </tr>
        <tr>
            <td colspan="2">
               <div  id="tablaProductos" style="display:none">
                <fieldset>
                    <legend style="color:#000;"> <strong>Costos y Precios de venta(incluido IGV)</strong></legend>
                    <table border="0" width="100%" align="left" style=" border-collapse: collapse;">
                        <tr align="center" style="color:#fff;background:#3398db;">
                            <th>Costo Compra</th>
                            <th>% por Caja</th>
                            <th>Pre.Vta x Caja</th>
                            <!--<th>% por Caja</th>-->
                            <th>% por Unidad</th>
                            <th>Pre. Unitario</th>
                            <th>% por Blister</th>
                            <th title="No confundir, no es el precio total del blister, ingrese el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. ">Pre.Unid x Blister</th>
                        </tr>
                        <tr align="center" style="background:#d4dbd9;">
                            <td>
                                <!--Costo Compra-->
                                <input tabindex="9" type="text" class="Estilodany" size="6" name="ncostre" id="ncostre" value="<?php echo $costre; ?>" onkeypress="return decimal(event)" onKeyUp="precion();" />

                                <input name="nmargenenuevo" type="hidden" id="nmargenenuevo" value="<?php echo $utldmin ?>" />
                            </td>
                            <td>
                                <!--% margen-->
                                <input style="background: #e9fb53;color: #000;font-weight: 900;" tabindex="10" type="text" class="Estilodany" size="4" name="nmargene" id="nmargene" value="<?php echo number_format($margene, 2, '.', ' ');  ?>" onkeypress="return decimal(event)" onKeyUp="precion();" />%
                            </td>
                            <td>
                                <!--Pre.Vta x Caja-->
                                <input tabindex="11" type="text" class="Estilodany" size="6" name="nprevta" id="nprevta" value="<?php echo $prevta; ?>" onkeypress="return decimal(event)" onKeyUp="precioncaja();"/>
                            </td>
                            <!-- <td >
                                        <!--% de margen Pre.Vta x Caja--
                                        <input  style="background: #4399f3;color: #fff;font-weight: 900;" type="text" class="Estilodany" size="4" name="nmargencaja" id="nmargencaja" value="<?php echo $margenecaja; ?> " readonly/>%
                                    </td>-->
                            <td>
                                <!--% de margen Pre. Unitario-->
                                <input style="background: #e9fb53;color: #000;font-weight: 900;" type="text" class="Estilodany" size="4" name="nmargenuni" id="nmargenuni" value="<?php echo number_format($margeneuni, 2, '.', ' ');  ?>" disabled="disabled" />%
                            </td>
                            <td>
                                <!--Pre. Unitario-->
                                <input tabindex="12" type="text" class="Estilodany" size="6" name="npreuni" id="npreuni" value="<?php echo $preuni; ?>" onkeypress="return decimal(event)" onKeyUp="precionunidad();"/>
                            </td>
                            <td>
                                <!--% de margen blister-->
                                <input style="background: #e9fb53;color: #000;font-weight: 900;" type="text" class="Estilodany" size="4" name="nmargenblister" id="nmargenblister" value="<?php echo number_format($margenblister, 2, '.', ' ');  ?> " disabled="disabled" />%
                            </td>
                            <td title="No confundir, no es el precio total del blister, ingrese el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. ">
                                <!--Pre. blister-->
                                <input tabindex="13" type="text" class="Estilodany" size="6" name="npreblister" id="npreblister" value="<?php echo $preblister; ?>" onkeypress="return decimal(event)" onKeyUp="precioblister();" title="No confundir, no es el precio total del blister, ingrese el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. " />
                            </td>
                        </tr>
                    </table>
                </fieldset>
               </div>
            </td>
        </tr>


        <tr>
            <td class="LETRA">STOCK GENERAL</td>
            <td><label>
                    <!--<input name="sstock" disabled="disabled" type="text" class="Estilodany" id="sstock" value="<?php echo $stopro; ?>"/>-->
                    <input name="sstock" disabled="disabled" type="text" class="Estilodany" id="sstock" value="<?php echo $CantidadFactor; ?>" />
                </label></td>
        </tr>
        <tr>
            <td class="LETRA">PRECIO REFERENCIAL</td>
            <td><label>
                    <input name="price" type="text" class="Estilodany" id="price" onkeypress="return decimal(event)" value="<?php echo $prelis; ?>" />
                </label></td>
        </tr>

        <tr>
            <td class="LETRA">C&OacuteDIGO DE CUENTA </td>
            <td>
                <label>
                    <input name="cod_cuenta" type="text" class="Estilodany" id="cod_cuenta" />
                </label>
            </td>
        </tr>
        <tr>
            <td class="LETRA">ARCHIVO </td>
            <td><input name="img" type="file" class="Estilodany" id="img" size="20" /></td>
        </tr>
        <tr>

            <td width="463" valign="top" colspan="2">


                <table border="0" align="left" width="80%" style="padding: 4px;">
                    <thead>
                        <tr align="left">
                            <th>COSTOS PROMEDIOS:</th>
                            <td>
                                <div id="1">
                                    <?php echo $costpr; ?>
                                </div>
                            </td>
                            <th>&UacuteLTIMO:</th>
                            <td>
                                <div id="2">
                                    <?php echo $utlcos; ?>
                                </div>
                            </td>
                            <th>REAL:</th>
                            <td>
                                <div id="3">
                                    <?php echo $costre; ?>
                                </div>
                            </td>
                        </tr>
                        <tr align="left">
                            <th>M&AacuteRGENES (COSTO REAL):</th>
                            <td>
                                <div id="4">
                                    <?php echo $margene; ?>
                                </div>
                            </td>
                            <th>UNITARIO:</th>
                            <td>
                                <div id="5">
                                    <?php echo $margeneuni; ?>
                                </div>
                            </td>

                        </tr>
                        <tr align="left">
                            <th>PRECIO DE VENTA:</th>
                            <td>
                                <div id="6">
                                    <?php echo $prevta; ?>
                                </div>
                            </td>
                            <th>UNITARIO:</th>
                            <td>
                                <div id="7">
                                    <?php echo $preuni; ?>
                                </div>
                            </td>

                        </tr>
                    </thead>

                </table>
            </td>

        </tr>

    </table>




</form>