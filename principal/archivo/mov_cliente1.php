<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">

    <table width="100%" border="0">
        <tr>
            <td>


                <table width="100%" border="1" id="customers">

                    <tr>
                        <td width="20%">
                            <div align="right"><span class="text_combo_select"><strong>LOCAL:</strong><img src="../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
                        </td>
                        <td width="40%">
                            <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
                        </td>
                        <td rowspan="40%">
                            <iframe src="busca_cliente/busca_cliente.php" name="iFrame1" width="400" height="295" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0"> </iframe>
                        </td>
                    </tr>

                    <tr>
                        <th class="LETRA">CODIGO</th>
                        <td><label>
                                <input name="codigo" type="text" class="Estilodany" id="codigo" value="<?php echo formato($codcli) ?>" size="10" />
                            </label>
                        </td>

                    </tr>

                    <tr>
                        <th class="LETRA">RUC</th>
                        <td><input name="ruc" type="text" class="Estilodany" id="ruc" onkeypress="return acceptNum(event)" value="<?php echo $ruccli ?>" size="15" maxlength="11" onkeyup="validarRUC(this)" />
                            <a id='resultadoRUC'></a>
                            <a id='contadorRUC'></a>

                            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />

                            <button class="boton_personalizado_RUC" type="button" onclick="busqueda();" title="Se buscara en la SUNAT">
                                <span>BUSCAR RUC</span>
                            </button>

                        </td>
                    </tr>
                    <tr>
                        <th class="LETRA">DNI</th>
                        <td><input name="dni" type="text" class="Estilodany" id="dni" onkeypress="return acceptNum(event)" value="<?php echo $dnicli ?>" size="15" maxlength="8" onkeyup="validarDNI(this)" />
                            <a id='resultadoDNI'></a>
                            <a id='contadorDNI'></a>

                            <button class="boton_personalizado_DNI" type="button" onclick="busqueda_DNI();" id="boton_dni" title="Se buscara en la RENIEC">
                                <span>BUSCAR DNI</span>
                            </button>
                        </td>
                    </tr>

                    <tr>

                        <th class="LETRA">NOMBRES(*)</th>
                        <td><label>
                                <input name="nom" type="text" class="Estilodany" id="nom" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $descli ?>" size="70" />
                            </label></td>
                    </tr>


                    <tr>
                        <th class="LETRA">PROPIETARIO(*)</th>
                        <td><label>
                                <input name="propietario" type="text" id="propietario" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $contact ?>" size="100">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th class="LETRA">DIRECCION(*)</th>
                        <td><label>
                                <input name="direccion" type="text" id="direccion" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $dircli ?>" size="70">
                            </label></td>
                    </tr>
                    <tr>
                        <th class="LETRA">LIMITE DE CREDITO</th>
                        <td>
                            <label>
                                <input name="limiteCredito" type="text" id="limiteCredito" onkeypress="return decimal(event)" value="<?php echo $limiteCredito; ?>" size="70">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th class="LETRA">DEPARTAMENTO(*)</th>
                        <td><label>
                                <div id="demoIzq"><?php generaSelect($conexion); ?></div>
                            </label></td>
                    </tr>
                    <tr>
                        <th class="LETRA">PROVINCIA(*)</th>
                        <td>
                            <div id="demoMed">
                                <select disabled="disabled" name="provincia" id="provincia">
                                    <option value="0">Seleccione una Provincia</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="LETRA">DISTRITO(*)</th>
                        <td>
                            <div id="demoDer">
                                <select disabled="disabled" name="distrito" id="distrito">
                                    <option value="0">Seleccione un Distrito</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="LETRA">TIPO EMPRESA </th>
                        <td><label>
                                <input name="tipo" type="text" id="tipo" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $tipo ?>" size="70">
                            </label></td>
                    </tr>

                    <tr>
                        <th class="LETRA">ESTADO </th>
                        <td><label>
                                <input name="estado" type="text" id="estado" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $estado?>" size="70">
                            </label></td>
                    </tr>

                    <tr>
                        <th class="LETRA">CONDICION </th>
                        <td><label>
                                <input name="condicion" type="text" id="condicion" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $condicion ?>" size="70">
                            </label></td>
                    </tr>


                    <tr>
                        <th class="LETRA">TELEFONO 1 </th>
                        <td><input name="fono" type="text" class="Estilodany" id="fono" onkeypress="return acceptNum(event)" value="<?php echo $telcli ?>" size="15" maxlength="10" placeholder="Telefono 1" />
                            <input name="fono1" type="text" class="Estilodany" id="fono1" onkeypress="return acceptNum(event)" value="<?php echo $telcli1 ?>" size="15" maxlength="10" placeholder="Telefono 2" />
                        </td>
                    </tr>

                    <tr>
                        <th class="LETRA">E- MAIL </th>
                        <td><input name="email" type="text" class="Estilodany" id="email" value="<?php echo $email ?>" onkeyup="validarEmail(this)" size="70" placeholder="Si el correo es valido se le hara un envio de su comprobante de pago..." />
                            <blink><a id='resultado'></a></blink>
                            <input name="emailres" type="hidden" id="emailres" value="<?php echo $emailres ?>" />
                        </td>
                    </tr>
                   
                </table>


                <table width="100%" border="0">
                    <tr>
                        <td width="392">
                            <?php
                            //include ('../../conexion.php');
                            $sql = "SELECT name FROM departamento where id = '$dptcli' ";
                            $result = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $depart = $row[0];
                            }
                            ?>
                            <input class="input_text" name="textt1" type="text" disabled="disabled" id="textt1" onFocus="blur()" value="<?php echo $depart; ?>" size="45" />
                        </td>
                        <td width="51"></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            $sql = "SELECT name FROM provincia where id = '$procli' ";
                            $result = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $provinc = $row[0];
                            }
                            ?>
                            <input class="input_text" name="textt2" type="text" disabled="disabled" id="textt2" onFocus="blur()" value="<?php echo $provinc; ?>" size="45" />
                        </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td><?php
                            $sql = "SELECT name FROM distrito where id = '$discli' ";
                            $result = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $distrit = $row[0];
                            }
                            ?>
                            <input class="input_text" name="textt3" type="text" disabled="disabled" id="textt3" onfocus="blur()" value="<?php echo $distrit; ?>" size="45" />
                        </td>
                        <td></td>
                    </tr>
                    <!--  <tr>
                        <td class="LETRA">DELIVERY
                            <input name="delivery" type="checkbox" id="delivery" value="1" <?php if ($delivery == 1) { ?>checked="checked" <?php } ?> />
                        </td>
                        <td> </td>
                    </tr>-->
                </table>


            </td>
        </tr>
    </table>

    <center>
        <div class="botones">
            <table width="100%" border="0">
                <tr>
                    <td width="272">

                        <div align="left">
                            <?php
                            if ($ver != 1) {
                                $firstpage = 1;
                                $prevpage = $pageno - 1;
                                $nextpage = $pageno + 1;
                                $lastpage = $lastpage;
                            }
                            ?>
                            <input name="firstpage" type="hidden" id="firstpage" value="<?php echo $firstpage ?>" />
                            <input name="nextpage" type="hidden" id="nextpage" value="<?php echo $nextpage ?>" />
                            <input name="prevpage" type="hidden" id="prevpage" value="<?php echo $prevpage ?>" />
                            <input name="lastpage" type="hidden" id="lastpage" value="<?php echo $lastpage ?>" />
                            <input name="pageno" type="hidden" id="pageno" />
                            <input name="first" type="button" id="first" value="Primero" <?php if (($pageno == 1) || ($search == 1)) { ?> disabled="disabled" <?php } ?> class="primero" onClick="primero()" />
                            <input name="prev" type="button" id="prev" value="Anterior" <?php if (($pageno == 1) || ($search == 1)) { ?> disabled="disabled" <?php } ?> class="anterior" onClick="anterior()" />
                            <input name="next" type="button" id="next" value="Siguiente" <?php if (($pageno == $lastpage) || ($search == 1) || ($numrows == 0)) { ?> disabled="disabled" <?php } ?> class="siguiente" onClick="siguiente()" />
                            <input name="fin" type="button" id="fin" value="Ultimo" <?php if (($pageno == $lastpage) || ($search == 1) || ($numrows == 0)) { ?> disabled="disabled" <?php } ?> class="ultimo" onClick="ultimo()" />
                        </div>
                    </td>
                    <!-- <td width="28">&nbsp;</td> -->
                    <td width="489">
                        <label>

                            <div align="right">
                                <input name="dpto" type="hidden" id="dpto" value="<?php echo $dptcli ?>" />
                                <input name="prov" type="hidden" id="prov" value="<?php echo $procli ?>" />
                                <input name="dist" type="hidden" id="dist" value="<?php echo $discli ?>" />
                                <input name="cod_nuevo" type="hidden" id="cod_nuevo" />
                                <input name="fincod" type="hidden" id="fincod" value="<?php echo $fincod ?>" />
                                <input name="cod_modif_del" type="hidden" id="cod_modif_del" value="<?php echo $codcli ?>" />
                                <input name="val" type="hidden" id="val" />
                                <input name="btn" type="hidden" id="btn" />
                                <input name="printer" type="button" id="printer" value="Listar clientes" onClick="cli()" class="imprimir" />
                                <input name="nuevo" type="button" id="nuevo" value="Nuevo" onClick="buton2()" class="nuevo" />
                                <input name="modif" type="button" id="modif" value="Modificar" onClick="buton3()" class="modificar" <?php if ($numrows == 0) { ?>disabled="disabled" <?php } ?> />
                                <input name="save" type="button" id="save" value="Grabar" onClick="validar()" class="grabar" />
                                <input name="del" type="button" id="del" value="Eliminar" onClick="eliminar()" class="eliminar" <?php if ($numrows == 0) { ?>disabled="disabled" <?php } ?> />
                                <input name="ext" type="submit" id="ext" value="Cancelar" class="cancelar" />
                                <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                        </label>
                    </td>
                </tr>
            </table>
        </div>
    </center>





</form>