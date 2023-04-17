<table width="100%" border="0" align="center">
    <tr>
        <td class="login_titulo" align="center"><b>SEGURIDAD DEL SISTEMA </b></td>
    </tr>
</table>
<br>
<table width="90%" height="20" border="0" align="center">
    <tr>
        <td width="30%" style="font-family:serif;font-size: 1rem;text-align: justify;">
            Ingresar un nombre de usuario y contrase&ntilde;a v&aacute;lido para tener acceso al Sistema.<br>
            <br><img src="images/j_login_lock.jpg" width="100%" height="100%" />
        </td>
        <td width="60%" valign="top">
            <table width="100%" height="103" border="0" align="center" class="tabla2">
                <tr>
                    <td width="100%">
                        <form id="form1" name="form1" method="post" action="verifica.php">
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <td width="10%" class="text_login">Usuario </td>
                                    <td width="90%">
                                        <input name="user" type="text" class="logisn" id="user" onclick="this.value = ''" value="" size="30" onkeypress="return ent1(event);" placeholder=" Ingrese su Usuario" /> </td>
                                </tr>
                                <tr>
                                    <td class="text_login">Contrase&ntilde;a</td>
                                    <td>
                                        <input name="text" type="password" id="text" size="30" onKeyPress="return ent(event)" placeholder=" Ingrese su Contraseña" /> </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="button" name="Submit" value="Ingresar" class="buscar" onclick="validar()" />
                                    </td>
                                </tr>
                            </table>
                            <table width="40%" border="0" style="margin-left: 15%;">
                                <tr>
                                    <td width="13%"><input type="button" class="buttones" name="Submit2" value="1" onclick="buton1()" /></td>
                                    <td width="13%"><input type="button" class="buttones" name="Submit2" value="2" onclick="buton2()" /></td>
                                    <td width="13%"><input type="button" class="buttones" name="Submit3" value="3" onclick="buton3()" /></td>
                                </tr>
                                <tr>
                                    <td><input type="button" class="buttones" name="Submit4" value="4" onclick="buton4()" /></td>
                                    <td><input type="button" class="buttones" name="Submit5" value="5" onclick="buton5()" /></td>
                                    <td><input type="button" class="buttones" name="Submit6" value="6" onclick="buton6()" /></td>
                                </tr>
                                <tr>
                                    <td><input type="button" class="buttones" name="Submit7" value="7" onclick="buton7()" /></td>
                                    <td><input type="button" class="buttones" name="Submit8" value="8" onclick="buton8()" /></td>
                                    <td><input type="button" class="buttones" name="Submit9" value="9" onclick="buton9()" /></td>
                                </tr>
                                <tr>
                                    <td><input class="buttones" type="button" name="Submit10" value="0" onclick="buton0()" /></td>
                                    <td colspan="2"><input class="buttones" type="button" name="Submit11" value="Limpiar" onclick="clean()" /></td>
                                </tr>
                            </table>

                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>