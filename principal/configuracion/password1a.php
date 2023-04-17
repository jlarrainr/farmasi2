<?php $sql="SELECT adminuser,paramsist,colorbut FROM datagen";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
	  while ($row = mysqli_fetch_array($result)){
	  		 $i++;
             $adminuser                 = $row["adminuser"];
			 $paramsist                 = $row["paramsist"];
			 $colorbut                  = $row["colorbut"];
			 }
			 }
?>
<form method="post" enctype="multipart/form-data" name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table class="tabla2" width="100%" border="0" align="center">
    <tr>
      <td width="626"><strong>CONTRASE�AS ESPECIALES</strong><br><br>
        <br>
        <table width="100%" border="0" align="center">
          <tr>
            <td width="202"><div align="center"><img src="../images/keychain1.gif" width="93" height="139"></div></td>
            <td width="202"><div align="center"><img src="../images/keychain1.gif" width="93" height="139"></div></td>
            <td width="202"><div align="center"><img src="../images/keychain1.gif" width="93" height="139"></div></td>
          </tr>
          <tr>
            <td valign="top"><div align="center"><u>ADMINISTRADOR DE USUARIOS</u></div></td>
            <td valign="top"><div align="center"><u>PARAMETROS DEL SISTEMA</u></div></td>
            <td valign="top"><div align="center"><u>CAMBIAR COLORES DE LOS TITULOS DE LOS BOTONES</u></div></td>
          </tr>
          <tr>
            <td><label>
              <div align="center">
                <input name="pas1" type="text" id="pas1" value="<?php echo $adminuser?>">
              </div>
            </label></td>
            <td><label>
              <div align="center">
                <input name="pas2" type="text" id="pas2" value="<?php echo $paramsist?>">
              </div>
            </label></td>
            <td><label>
              <div align="center">
                <input name="pas3" type="text" id="pas3" value="<?php echo $colorbut?>">
              </div>
            </label></td>
          </tr>
        </table>
		<br><br>
        <table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><table width="100%" border="0">
                <tr>
                  <td width="26"><label></label></td>
                  <td width="392"><input name="btn" type="hidden" id="btn" /></td>
                  <td width="95"><div align="right">
                      <input type="button" name="Submit2" value="Grabar" onclick="save_datosgen1()" class="grabar"/>
                  </div></td>
                  <td width="42"><div align="right">
                      <input type="button" name="Submit" value="Salir" onclick="salir1()" class="salir"/>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table>
      <br></td>
    </tr>
  </table>
  </form>
