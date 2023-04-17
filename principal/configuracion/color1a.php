<form method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table class="tabla2" width="100%" border="0" align="center">
        <tr>
            <td width="645" valign="top"><strong>COLORES</strong><br><br>
                <table width="100%" border="0" align="center" class="tabla2">
                    <tr>
                        <td width="589"><u>TITULO DE LOS BOTONES
                            </u>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="156" valign="top">

                                        <table width="100%" border="0" align="center">
                                            <tr>
                                                <td >
                                                    <div align="left">
                                                        <input type="button"  class="primero" name="Submit3" value="Primero" />
                                                    </div>
                                                </td>
                                                <td width="396">

                                                    <input name="text" type="text" id="dhtmlxColorPicker1" size="6" colorbox="true" value="<?php echo $prodnormal ?>" >
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker1');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td width="96">
                                                    <div align="left">
                                                        <input type="button" class="ver" name="Submit33" value="Visualizar" />
                                                    </div>
                                                </td>
                                                <td width="396">
                                                    <input name="text4" type="text" id="dhtmlxColorPicker5" size="6" colorbox="true" value="<?php echo $ver ?>" />
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker5');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td width="96">
                                                    <div align="left">
                                                        <input type="button" name="Submit34" value="Buscar" class="buscar"/>
                                                    </div>					  </td>
                                                <td width="396" >
                                                    <input name="text9" type="text" id="dhtmlxColorPicker11" size="6" colorbox="true" value="<?php echo $buscar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker11');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" class="anterior" name="Submit32" value="Anterior"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text1" type="text" id="dhtmlxColorPicker2" size="6" colorbox="true"value="<?php echo $anterior ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker2');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit323" value="Nuevo" class="nuevo"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text5" type="text" id="dhtmlxColorPicker6" size="6" colorbox="true" value="<?php echo $nuevo ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker6');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit324" value="Preliminar" class="preliminar"/>
                                                    </div>					  </td>
                                                <td>
                                                    <input name="text10" type="text" id="dhtmlxColorPicker12" size="6" colorbox="true" value="<?php echo $preliminar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker12');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" class="siguiente" name="Submit322" value="Siguiente"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text2" type="text" id="dhtmlxColorPicker3" size="6" colorbox="true"value="<?php echo $siguiente ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker3');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit3223" value="Modificar" class="modificar"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text6" type="text" id="dhtmlxColorPicker7" size="6" colorbox="true" value="<?php echo $modificar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker7');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                 <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit3224" value="Imprimir" class="imprimir"/>
                                                    </div>					  </td>
                                                <td>
                                                    <input name="text11" type="text" id="dhtmlxColorPicker13" size="6" colorbox="true" value="<?php echo $imprimir ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker13');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" class="ultimo" name="Submit3222" value="Ultimo"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text3" type="text" id="dhtmlxColorPicker4" size="6" colorbox="true" value="<?php echo $ultimo ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker4');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32222" value="Eliminar" class="eliminar"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text7" type="text" id="dhtmlxColorPicker8" size="6" colorbox="true" value="<?php echo $eliminar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker8');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32223" value="Consultar" class="consultar">
                                                    </div>					  </td>
                                                <td>
                                                    <input name="text12" type="text" id="dhtmlxColorPicker14" size="6" colorbox="true" value="<?php echo $consulta ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker14');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  </td>
                                            </tr>

                                            <tr>
                                                  <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32222" value="Grabar" class="grabar"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text8" type="text" id="dhtmlxColorPicker9" size="6" colorbox="true" value="<?php echo $grabar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker9');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32222" value="Cancelar" class="cancelar"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="text17" type="text" id="dhtmlxColorPicker10" size="6" colorbox="true" value="<?php echo $grabar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker10');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32223" value="Salir" class="salir"/>
                                                    </div>					  </td>
                                                <td>
                                                    <input name="text13" type="text" id="dhtmlxColorPicker15" size="6" colorbox="true" value="<?php echo $salir ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker15');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  </td>
                                            </tr>
                                            
                                            <tr>
                                              <td><div align="left">
                                                        <input type="button" name="Submit32223" value="Regresar" class="regresar"/>
                                                    </div></td>
                                                <td><input name="text19" type="text" id="dhtmlxColorPicker20" size="6" colorbox="true" value="<?php echo $regresar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker20');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>                      
                                                </td>
                                                 <td><div align="left">
                                                        <input type="button" name="Submit32223" value="Limpiar" class="limpiar"/>
                                                    </div></td>
                                                <td><input name="text20" type="text" id="dhtmlxColorPicker21" size="6" colorbox="true" value="<?php echo $limpiar ?>"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker21');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>
                                                </td>
                                                <td>
                                                    <div align="left">
                                                        <input type="button" name="Submit32223" value="TODOS" class="salir"/>
                                                    </div>					  </td>
                                                <td>
                                                    <input name="text18" type="text" id="dhtmlxColorPicker16" size="6" colorbox="true"/>
                                                    <script>
                                                        var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker16');
                                                        myCP2.setImagePath("../../funciones/codebase/imgs/");
                                                        myCP2.init();
                                                    </script>					  </td>
                                            </tr>
                                        </table>


                                    </td>

                                </tr>
                            </table>            </td>
                    </tr>
                </table>
                <table width="100%" border="0" align="center" class="tabla2">
                    <tr>
                        <td width="589"><u>COLOR DE TEXTO              
                            </u>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="138" class="LETRA"> Productos con Stock Cero </td>
                                    <td width="28">
                                        <input type="button" name="Submit4" value="..." class="prodstock"/>
                                    </td>
                                    <td width="392">
                                        <input name="text14" type="text" id="dhtmlxColorPicker17" size="6" colorbox="true"value="<?php echo $prodstock ?>"/>
                                        <script>
                                            var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker17');
                                            myCP2.setImagePath("../../funciones/codebase/imgs/");
                                            myCP2.init();
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="LETRA">Productos Incentivados </td>
                                    <td>
                                        <input type="button" name="Submit42" value="..." class="prodincent"/>
                                    </td>
                                    <td>
                                        <input name="text15" type="text" id="dhtmlxColorPicker18" size="6" colorbox="true" value="<?php echo $prodincent ?>"/>
                                        <script>
                                            var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker18');
                                            myCP2.setImagePath("../../funciones/codebase/imgs/");
                                            myCP2.init();
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="LETRA"> Productos Normales </td>
                                    <td><input type="button" name="Submit43" value="..." class="prodnormal"/></td>
                                    <td>
                                        <input name="text16" type="text" id="dhtmlxColorPicker19" size="6" colorbox="true" value="<?php echo $prodnormal ?>"/>
                                        <script>
                                            var myCP2 = dhtmlXColorPickerInput('dhtmlxColorPicker19');
                                            myCP2.setImagePath("../../funciones/codebase/imgs/");
                                            myCP2.init();
                                        </script>
                                    </td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <br>    
                <table class="tabla2" width="100%" border="0" align="center">
                    <tr>
                        <td><label>
                                <div align="right">
                                    <input name="btn" type="hidden" id="btn" />
                                    <input type="button" name="Submit2" value="Grabar" onclick="save_color()" class="grabar"/>
                                    <input type="button" name="Submit" value="Salir" onclick="salir1()" class="salir"/>
                                </div>
                            </label></td>
                    </tr>
                </table>
                <br></td>
        </tr>
    </table>
</form>
