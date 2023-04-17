<?php $sql="SELECT * FROM datagen_det";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
	  while ($row = mysqli_fetch_array($result)){
	  		 $i++;
                         $iddata                 = $row["iddata"];
			 $codcli                 = $row["codcli"];
			 $condv                  = $row["condv"];
			 $codusu                 = $row["codusu"];
			 $prodact                = $row["prodact"];
			 $incigv                 = $row["incigv"];
			 $cosigv                 = $row["cosigv"];
			 $nomarc                 = $row["nomarc"];
			 $codaut                 = $row["codaut"];
			 $afeigv                 = $row["afeigv"];
			 $unalm                  = $row["unalm"];
			 $ventalm                = $row["ventalm"];
			 $ingalm                 = $row["ingalm"];
			 $comcod                 = $row["comcod"];
			 $comnom                 = $row["comnom"];
			 $ventcod                = $row["ventcod"];
			 $ventnom                = $row["ventnom"];
			 $limit                  = $row["limite"];
			 $limite_compra          = $row["limite_compra"];
			 $mensaje                = $row["mensaje"];
			 $unidminrepo            = $row["unidminrepo"];
			 $utldmin                = $row["utldmin"];
			 $priceditable           = $row["priceditable"];
			 $focuscotiz             = $row["focuscotiz"];
			 $auditor                = $row["auditor"];
                         $vendedorventa          = $row["vendedorventa"];
                         $drogueria          = $row["drogueria"];
			 }
			 }
$sql1="SELECT usecod,nomusu FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		$usecod    = $row1['usecod'];
		$nomusu    = $row1['nomusu'];
}
}
$sql1="SELECT descli FROM cliente where codcli = '$codcli'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		$descli    = $row1["descli"];
}
}
?>
<form id="form1" name="form1" method="post" onKeyUp="highlight(event)" onClick="highlight(event)">
<br>
  <table class="tabla2" width="100%" border="0" align="center">
    <tr>
      <td width="604">
	  <strong>VALORES PREDETERMINADOS</strong><br>
	  <br>
	  <table width="100%" border="0" align="center" class="tabla2">
        <tr>
          <td>
              <u ><strong>VENTAS</strong></u>
              <table width="100%" border="0">
                <tr>
                    <td width="40" class="LETRA">VENDEDOR</td>
                  <td width="399">
                    <input name="vendedor" type="text" class="Estilodany" id="vendedor" size="10" onkeypress="return acceptNum(event)" value="<?php echo $usecod?>" onclick="blur()"/>
                    <input name="textfield3" type="text" size="50" onclick="onfocus()" value="<?php echo $nomusu?>" /></td>
                </tr>
                <tr>
                  <td class="LETRA">MENSAJE</td>
                  <td width="399">
                    <input name="msjventa" type="text" id="msjventa" onclick="onfocus()" value="<?php echo $mensaje?>" size="65" /></td>
                </tr>
                <tr>
                  <td class="LETRA">VENDEDOR CON VENTA</td>
                  <td width="399">
                      <input type="checkbox" <?php if($vendedorventa==1){?>checked="checked"<?php }?> name="ckvendedorventa" id="ckvendedorventa" value="1">
                  </td>
                </tr>
                <tr>
                  <td class="LETRA">DROGUERIA</td>
                  <td width="399">
                      <input type="checkbox" <?php if($drogueria==1){?>checked="checked"<?php }?> name="drogueria" id="drogueria" value="1">
                  </td>
                </tr>
              </table>
              <table width="100%" border="0">
                <tr>
                  <td width="136"></td>
                  <td width="399"><label>
                  
                  </label></td>
                </tr>
              </table>
          </td>
        </tr>
      </table>
	  <table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><table width="100%" border="0">
              <tr>
                <td width="350"><u><strong>LIMITE DE BUSQUEDA DE INFORMACION </strong></u></td>
                <td width="213"><u><strong>UTILIDAD MINIMA DEL PRODUCTO</strong></u></td>
              </tr>
            </table>
              <table width="100%" border="0">
                <tr>
                  <td width="66" class="LETRA"><label>
                  LIMITE
                  </label></td>
                  <td width="280"><label>
                    <input name="limit" value="<?php echo $limit;?>" type="text" id="limit" size="10" maxlength="2" onkeypress="return acceptNum(event)"/>
                  </label></td>
                  <td width="76" class="LETRA"><label>UTILIDAD</label></td>
                  <td width="133"><label>
                    <input name="utldmin" type="text" id="utldmin" value="<?php echo $utldmin;?>" size="10" />
                  %</label></td>
                </tr>
            </table></td>
          </tr>
        </table>
		<table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><table width="100%" border="0">
                <tr>
                  <td width="350"><u><strong>LIMITE DE DIAS PARA COMPRA</strong></u></td>
                  <td width="213"><u><strong>AUDITOR DE COMPRAS </strong></u></td>
                </tr>
              </table>
                <table width="100%" border="0">
                  <tr>
                    <td width="66" class="LETRA"><label> LIMITE </label></td>
                    <td width="281"><label>
                      <input name="limit2" value="<?php if ($limite_compra == 0){ ?>15<?php } else { echo $limite_compra; }?>" type="text" id="limit2" size="10" maxlength="2" onkeypress="return acceptNum(event)"/>
 dias                    </label></td>
                    <td width="212" class="LETRA"   ><label>
                      <input name="auditor" type="checkbox" id="auditor" value="1" <?php if ($auditor == 1){?>checked="checked"<?php }?>/>
                    Activar</label></td>
                  </tr>
              </table></td>
          </tr>
        </table>
		<table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><u><strong>MINIMO DE UNIDADES EN PRODUCTOS PARA REPOSICION  </strong></u>
                <table width="100%" border="0">
                  <tr>
                    <td width="66" class="LETRA"><label> MINIMO </label></td>
                    <td width="280" class="LETRA"><label>
                      <input name="minunid" value="<?php echo $unidminrepo;?>" type="text" id="minunid" size="10" maxlength="4" onkeypress="return acceptNum(event)"/>
                      Unid
                    </label></td>
                    <td width="213"><label></label></td>
                  </tr>
              </table></td>
          </tr>
        </table>
		<br>
		<table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><u><strong>PRODUCTOS</strong></u>
                <table width="100%" border="0">
                  <tr>
                    <td width="20"><label>
                      <input name="p1" type="checkbox" id="p1" value="1" <?php if ($prodact == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td width="244" class="LETRA"><label for="p1"> 1- Activo</label>  </td>
                    <td width="20"><label>
                      <input name="p4" type="checkbox" id="p4" value="1" <?php if ($nomarc == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td width="246" class="LETRA"><label for="p4"> 4- Bloque si no tiene Marca </label> </td>
                  </tr>
                  <tr>
                    <td class="LETRA"><label>
                      <input name="p2" type="checkbox" id="p2" value="1" <?php if ($incigv == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td class="LETRA"><label for="p2"> 2- Incluido IGV </label> </td>
                    <td><label>
                      <input name="p5" type="checkbox" id="p5" value="1" <?php if ($codaut == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td class="LETRA"><label for="p5"> 5- Codigo de Productos autogenerado </label> </td>
                  </tr>
                  <tr>
                    <td><label>
                      <input name="p3" type="checkbox" id="p3" value="1" <?php if ($cosigv == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td class="LETRA"><label for="p3"> 3- Costos incluido IGV </label> </td>
                    <td><label>
                      <input name="p6" type="checkbox" id="p6" value="1" <?php if ($afeigv == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td class="LETRA"><label for="p6"> 6-Afecto IGV </label> </td>
                  </tr>
              </table></td>
          </tr>
        </table>
		<br />
		<table width="100%" border="0" align="center" class="tabla2">
          <tr>
            <td><u><strong>VENTAS</strong></u>
                <table width="100%" border="0">
                  <tr>
                    <td width="20"><label>
                      <input name="p10" type="checkbox" id="p10" value="1" <?php if ($priceditable == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td width="244" class="LETRA"><label for="p10"> 1- Precio Editable </label> </td>
                    <td width="20"><label>
                      <input name="p11" type="checkbox" id="p11" value="1" <?php if ($focuscotiz == 1){?>checked="checked"<?php }?> />
                    </label></td>
                    <td width="246" class="LETRA"><label for="p11"> 2- Foco en nro de Cotizaci&oacute;n </label> </td>
                  </tr>
              </table></td>
          </tr>
        </table>
		<br>
        <table width="100%" border="0" align="center">
          <tr>
            <td width="289" valign="top"><table class="tabla2" width="285" border="0">
              <tr>
                <td><u><strong>INVENTARIOS</strong></u>
                    <table width="100%" border="0">
                      <tr>
                        <td width="20"><label>
                          <input name="p7" type="checkbox" id="p7" value="1" <?php if ($unalm == 1){?>checked="checked"<?php }?>/>
                        </label></td>
                        <td width="244" class="LETRA"><label for="p7"> 7- Solo se maneja un Almacen</label>  </td>
                      </tr>
                      <tr>
                        <td><label>
                          <input name="p8" type="checkbox" id="p8" value="1" <?php if ($ventalm == 1){?>checked="checked"<?php }?>/>
                        </label></td>
                        <td class="LETRA"><label for="p8"> 8- Ventas desde el Almacen 0000 siempre</label>  </td>
                      </tr>
                      <tr>
                        <td><label>
                          <input name="p9" type="checkbox" id="p9" value="1" <?php if ($ingalm == 1){?>checked="checked"<?php }?>/>
                        </label></td>
                        <td class="LETRA">  <label for="p9">A- Ingresos al Almacen 0000 siempre </label> </td>
                      </tr>
                  </table></td>
              </tr>
            </table></td>
            <td width="10">&nbsp;</td>
            <td width="345" valign="top"><table class="tabla2" width="280" border="0">
              <tr>
                <td width="325"><u><strong>ORDENADO POR </strong></u>
                  <table width="100%" border="0">
                    <tr>
                      <td width="157" valign="top"><table class="tabla2" width="128" border="0">
                        <tr>
                          <td width="147"><u><em>COMPRAS</em></u>
                            <table width="100%" border="0">
                              <tr>
                                <td class="LETRA"><label>
									<input name="rd1" type="radio" value="1"  <?php if ($comcod == 1){?>checked="checked"<?php }?>/>                                
									D - Por codigo </label></td>
                              </tr>
                              <tr>
                                <td class="LETRA"> <label><input name="rd1" type="radio"  value="2" <?php if ($comnom == 1){?>checked="checked"<?php }?>/>
                                  E - Por nombre </label> </td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                      <td width="156" valign="top"><table class="tabla2" width="129" border="0">
                        <tr>
                          <td width="147"><u><em>VENTAS</em></u>
                              <table width="100%" border="0">
                                <tr>
                                  <td class="LETRA"><label>
                                    <input name="rd2" type="radio" value="1" <?php if ($ventcod == 1){?>checked="checked"<?php }?>/>
                                    B - Por codigo </label></td>
                                </tr>
                                <tr>
                                  <td class="LETRA"> <label><input name="rd2" type="radio" value="2" <?php if ($ventnom == 1){?>checked="checked"<?php }?>/>
                                    C - Por nombre </label> </td>
                                </tr>
                            </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" class="tabla2">
            <tr>
              <td>
			  <table width="100%" border="0">
                    <tr>
                      <td width="26"><label></label></td>
                      <td width="692"><input name="btn" type="hidden" id="btn" /></td>
                      <td width="95">
                        <div align="right">
                          <input type="button" name="Submit2" value="Grabar" onclick="save_datosgen2()" class="grabar"/>
                        </div>
                      </td>
                      <td width="12"><div align="right">
                        <input type="button" name="Submit" value="Salir" onclick="salir1()" class="salir"/>
                      </div></td>
                </tr>
                </table></td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
