	  <table width="449" border="0" align="center">
        <tr>
          <td class="login_titulo"><b>SEGURIDAD  DEL SISTEMA </b></td>
        </tr>
      </table>
	  <br>
	  <table width="449" height="20" border="0" align="center">
        <tr>
          <td width="163">Usa un nombre de usuario y contrase&ntilde;a v&aacute;lido para poder tener acceso a la Sistema.<br>
            <br><img src="images/j_login_lock.jpg" width="152" height="137" /></td>
          <td width="442" valign="top">
		    <table width="285" height="103" border="0" align="right" class="tabla2">
            <tr>
              <td width="435"><form id="form1" name="form1" method="post" action="verifica.php">
                <table width="274" border="0" align="center">
				<tr>
                    <td width="88" class="text_login">Local</td>
                    <td width="176"><label>
                      <select name="local" class="Estilodany" id="local">
                        <?php 
								$sql = "SELECT * FROM xcompa order by codloc"; 
								$result = mysqli_query($conexion,$sql); 
								while ($row = mysqli_fetch_array($result)){ 
								?>
                        <option value="<?php echo $row["codloc"] ?>" class="Estilodany"><?php echo strtoupper($row["nomloc"]) ?></option>
                        <?php } ?>
                      </select>
                  </label></td>
                  </tr>
                  <tr>
                    <td width="88" class="text_login">Nombre de Usuario </td>
                   <td width="176">
				  <input name="user" type="text" class="login" id="user" onclick="this.value=''" value="<?php echo $desc?>" size="28" <?php if ($desc<>''){?> <?php }?>/>
                    </td>
                  </tr>
				  
                  <tr>
                    <td class="text_login">Contrase&ntilde;a</td>
                    <td>
                      <input name="text" type="password" id="text" onfocus="blur()" size="28"/>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <input type="button" name="Submit" value="Ingresar" onclick="validar()"/>
                    </td>
                  </tr>
                </table>
                            <table width="121" border="0">
                              <tr>
                                <td width="25"><input type="button" class="buttones" name="Submit2" value="1" onclick="buton1()"/>
                                </td>
                                <td width="26"><input type="button" class="buttones" name="Submit2" value="2" onclick="buton2()"/></td>
                                <td width="56"><input type="button" class="buttones" name="Submit3" value="3" onclick="buton3()"/></td>
                              </tr>
                              <tr>
                                <td><input type="button" class="buttones" name="Submit4" value="4" onclick="buton4()"/></td>
                                <td><input type="button" class="buttones" name="Submit5" value="5" onclick="buton5()"/></td>
                                <td><input type="button" class="buttones" name="Submit6" value="6" onclick="buton6()"/></td>
                              </tr>
                              <tr>
                                <td><input type="button" class="buttones" name="Submit7" value="7" onclick="buton7()"/></td>
                                <td><input type="button" class="buttones" name="Submit8" value="8" onclick="buton8()"/></td>
                                <td><input type="button" class="buttones" name="Submit9" value="9" onclick="buton9()"/></td>
                              </tr>
                            </table>
                            <table width="121" border="0">
                              <tr>
                                <td width="23"><input class="buttones" type="button" name="Submit10" value="0" onclick="buton0()"/></td>
                                <td width="72"><input class="buttones" type="button" name="Submit11" value="Limpiar" onclick="clean()"/></td>
                                <td width="12">&nbsp;</td>
                              </tr>
                            </table>
              </form>
              </td>
            </tr>
          </table></td>
        </tr>
</table>