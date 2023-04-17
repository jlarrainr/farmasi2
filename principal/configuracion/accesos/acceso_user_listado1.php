<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="windows-1252">

            <title>Documento sin t&iacute;tulo</title>
            <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
            <script src="../../../funciones/alertify/alertify.min.js"></script>
            <link href="../../select2/css/select2.min.css" rel="stylesheet" />
            <script src="../../select2/jquery-3.4.1.js"></script>
            <script src="../../select2/js/select2.min.js"></script>
            <?php
            require_once ('../../../conexion.php');
            require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
            require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
            require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
            $codgrup = $_REQUEST['codgrup'];
            $usecod = $_REQUEST['usecod'];
            $sql = "SELECT nomusu,logusu,pasusu,codgrup,export,codloc,claveventa FROM usuario where usecod = '$usecod' and eliminado='0'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $nomusu = $row['nomusu'];
                    $logusu = $row['logusu'];
                    $pasusu = $row['pasusu'];
                    $grupo = $row['codgrup'];
                    $export = $row['export'];
                    $codloc = $row['codloc'];
                    $claveventa = $row['claveventa'];
                }
            }

            $sql = "SELECT nlicencia FROM datagen ";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $nlicencia = $row['nlicencia'];
                }
            }
            ?>
            <script language="JavaScript">
                function regresar()
                {
                    var f = document.form1;
                    f.action = "regresar.php";
                    f.method = "post";
                    f.submit();
                }
                function grabar()
                {
                    var f = document.form1;
                    if (f.clave.value === "")
                    {
                        alert("Ingrese la Clave del Usuario");
                        f.clave.focus();
                        return;
                    }
                    if (f.claveventa.value === "")
                    {
                        alert("Ingrese la Clave de Venta del Usuario");
                        f.claveventa.focus();
                        return;
                    }

                  /*  var clave = document.getElementById('clave').value;
                    if (validar_clave(clave) == true)
                    {*/
                        f.action = "acceso_user_listado2.php";
                        f.method = "post";
                        f.submit();
                    /*} else
                    {
                        alert('La contrasena ingresada no es fuerte');
                        f.clave.focus();
                        return;
                    }*/
                }
            </script>
            <style>
                input {
                    box-sizing: border-box;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 12px;
                    background-color: white;
                    background-position: 3px 3px; 
                    background-repeat: no-repeat;
                    padding: 2px 1px 2px 5px;
                    padding: 4px;

                }
                table.tabla2
                { 
                    color: #404040;
                    background-color: #FFFFFF;
                    border: 1px #CDCDCD solid;
                    border-collapse: collapse;
                    border-spacing: 0px;
                }
                .LETRA{
                    font-family:Tahoma;
                    font-size:11px;
                    line-height:normal;
                    color:'#5f5e5e';
                    font-weight: bold;
                } 
                #contenido{
                    background: #f5f5f5;
                    float:right;
                    clear:both;
                    border:1px solid #e6e6e6;
                    margin-top:81px;
                    padding:2px;
                    width:auto;
                    overflow:auto;
                    font-family:helvetica;
                    font-size:10px;
                    text-align: justify;

                }
            </style>
            <script type="text/javascript">
                function validar_clave(clave)
                {
                    if (clave.length >= 8)
                    {
//                    Tiene ocho caracteres como m�nimo.
                        var mayuscula = false;
                        var minuscula = false;
                        var numero = false;
                        var caracter_raro = false;
                        for (var i = 0; i < clave.length; i++)
                        {
                            if (clave.charCodeAt(i) >= 65 && clave.charCodeAt(i) <= 90)
                            {
//                            Letras min�sculas.
                                mayuscula = true;
                            } else if (clave.charCodeAt(i) >= 97 && clave.charCodeAt(i) <= 122)
                            {
                                minuscula = true;
                            } else if (clave.charCodeAt(i) >= 48 && clave.charCodeAt(i) <= 57)
                            {
//                            N�meros.
                                numero = true;
                            }
//                        else
//                        {
//                            caracter_raro = true;
//                        }
                        }
//                    if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true)
                        if (mayuscula == true && minuscula == true && numero == true)
                        {
                            return true;
                        }
                    }
                    return false;
                }
                var numeros = "0123456789";
                function tiene_numeros(texto) {
                    for (i = 0; i < texto.length; i++) {
                        if (numeros.indexOf(texto.charAt(i), 0) != -1) {
                            return 1;
                        }
                    }
                    return 0;
                }
                var letras = "abcdefghyjklmn�opqrstuvwxyz";
                function tiene_letras(texto) {
                    texto = texto.toLowerCase();
                    for (i = 0; i < texto.length; i++) {
                        if (letras.indexOf(texto.charAt(i), 0) != -1) {
                            return 1;
                        }
                    }
                    return 0;
                }
//            var letras = "abcdefghyjklmn�opqrstuvwxyz";

                function tiene_minusculas(texto) {
                    for (i = 0; i < texto.length; i++) {
                        if (letras.indexOf(texto.charAt(i), 0) != -1) {
                            return 1;
                        }
                    }
                    return 0;
                }
                var letras_mayusculas = "ABCDEFGHYJKLMN�OPQRSTUVWXYZ";
                function tiene_mayusculas(texto) {
                    for (i = 0; i < texto.length; i++) {
                        if (letras_mayusculas.indexOf(texto.charAt(i), 0) != -1) {
                            return 1;
                        }
                    }
                    return 0;
                }
                function mensajes_pass(clave) {
                    var campo = 0;
                    var clave2 = document.form1.clave.value;
                    var strLength = clave.value.length;
                    if (clave.value.length != 0) {
                        div = document.getElementById('contenido');
                        div.style.display = '';
                        if (clave.value.length >= 8) {
                            campo += 1;
                            M_a_ocho = '>8';
                            M_a_ocho = M_a_ocho.fontcolor('blue');
                            document.getElementById("lengthx").style.color = "#00df11";
                        } else {
                            campo += 0;
                            M_a_ocho = '>8';
                            M_a_ocho = M_a_ocho.fontcolor('red');
                            document.getElementById("lengthx").style.color = "red";
                        }

                        if (tiene_numeros(clave2)) {
                            campo += 1;
                            M_tiene_numeros = '#';
                            M_tiene_numeros = M_tiene_numeros.fontcolor('blue');
                            document.getElementById("numero").style.color = "#00df11";
                        } else {
                            campo += 0;
                            M_tiene_numeros = '#';
                            M_tiene_numeros = M_tiene_numeros.fontcolor('red');
                            document.getElementById("numero").style.color = "red";
                        }

//            --------------------------------------------
//                    if (tiene_letras(clave2)) {
//                        campo += 1;
//                        M_tiene_letras = 'a-Z';
//                        M_tiene_letras = M_tiene_letras.fontcolor('blue');
//                    } else {
//                        campo += 0;
//                        M_tiene_letras = 'a-Z';
//                        M_tiene_letras = M_tiene_letras.fontcolor('red');
//                    }
//            ------------------------------------------------
                        if (tiene_minusculas(clave2)) {
                            campo += 1;
                            M_tiene_minusculas = 'a';
                            M_tiene_minusculas = M_tiene_minusculas.fontcolor('blue');
                            document.getElementById("letra").style.color = "#00df11";
                        } else {
                            campo += 0;
                            M_tiene_minusculas = 'a';
                            M_tiene_minusculas = M_tiene_minusculas.fontcolor('red');
                            document.getElementById("letra").style.color = "red";
                        }
//            ------------------------------------------------
                        if (tiene_mayusculas(clave2)) {
                            campo += 1;
                            M_tiene_mayusculas = 'Z';
                            M_tiene_mayusculas = M_tiene_mayusculas.fontcolor('blue');
                            document.getElementById("mayuscula").style.color = "#00df11";
                        } else {
                            campo += 0;
                            M_tiene_mayusculas = 'Z';
                            M_tiene_mayusculas = M_tiene_mayusculas.fontcolor('red');
                            document.getElementById("mayuscula").style.color = "red";
                        }
                        if (campo == 4) {
                            document.form1.botones.disabled = false;
                            document.form1.botones.value = "Grabar Informacion";
                        } else {
                            document.form1.botones.disabled = true;
                            document.form1.botones.value = "------";
                        }
//                    document.getElementById("mensajepass").innerHTML = M_a_ocho + ' / ' + M_tiene_numeros + ' / ' + M_tiene_minusculas + '-' + M_tiene_mayusculas;
                    } else {
                        div = document.getElementById('contenido');
                        div.style.display = 'none';
                    }
                }
                function seguridad_clave(clave) {
                    var seguridad = 0;
                    var clave2 = document.form1.clave.value;
                    var strLength = clave.value.length;
                    if (clave.value.length != 0) {

                        if (tiene_numeros(clave2) && tiene_letras(clave2)) {
                            seguridad += 30;
                        }
                        if (tiene_minusculas(clave2) && tiene_mayusculas(clave2)) {
                            seguridad += 30;
                        }
                        if (clave.value.length >= 4 && clave.value.length <= 5) {
                            seguridad += 10;
                        } else {
                            if (clave.value.length >= 6 && clave.value.length <= 8) {
                                seguridad += 30;
                            } else {
                                if (clave.value.length > 8) {
                                    seguridad += 40;
                                }
                            }
                        }
                    }
                    return seguridad
                }


                function muestra_seguridad_clave(clave) {
                    seguridad = seguridad_clave(clave);
//                document.form1.seguridad.value = seguridad + "%";
                    document.getElementById("seguridad").innerHTML = 'Nivel de seguridad: ' + seguridad + "%";
                    if (seguridad == 10) {
                        document.getElementById("seguridad").style.color = "red";
                    } else if (seguridad == 40) {
                        document.getElementById("seguridad").style.color = "#ff8b00"; //NARANJA
                    } else if (seguridad == 70) {
                        document.getElementById("seguridad").style.color = "#2d9df9"; //AZUL
                    } else if (seguridad == 100) {
                        document.getElementById("seguridad").style.color = "#00df11"; //verde
                    }
                }
                function mostrarPassword() {
                    var cambio = document.getElementById("clave");
                    if (cambio.type == "password") {
                        cambio.type = "text";
                        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                    } else {
                        cambio.type = "password";
                        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                    }
                }

                $(document).ready(function () {
                    //CheckBox mostrar contrase�a
                    $('#ShowPassword').click(function () {
                        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                    });
                });
            </script>
    </head>
    <body>
        <div align="center" width="578"><span class="text_combo_select"><strong> EDITAR USUARIO</strong></span><img src="../../../images/line2.jpg" width="570" height="4" />
        </div>
        <form id="form1" name="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
            <table width="100%" border="0" align="center" >

                <tr>
                    <td class="LETRA" width="140">NOMBRE</td>
                    <td colspan="2" width="443"><label>
                            <input name="nom" type="text" id="nom" size="50"  onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $nomusu ?>" disabled="disabled"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">USUARIO</td>
                    <td colspan="2"><label>
                            <input name="login" type="text" id="login" size="50" value="<?php echo $logusu ?>" disabled="disabled"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">CONTRASE&Ntilde;A</td>
                    <td width="60">
                        <label>
                            <!--<input name="clave" type="password" id="clave" size="50" value="<?php echo $pasusu ?>"  onkeyup=" muestra_seguridad_clave(clave), mensajes_pass(clave)"  onblur="validarUsuario_pass(clave, login);" />-->
                            <input name="clave" type="password" id="clave" size="50" value="<?php echo $pasusu ?>"  onkeypress="return acceptNum(event)"  onblur="validarUsuario_pass(clave, login);" />
                        </label>

                    </td>
<!--<div  class="balloonx" id="contenido"  style="display:none;">
                        <h4>La contrase&ntilde;a debe cumplir:</h4>
                        <ul>
                            <li id="comprobado_pass" ><strong></strong></li>
                            <li id="seguridad" class=""><strong></strong></li>
                            <li id="letra" class="invalid">Al menos <strong>una letra</strong></li>
                            <li id="mayuscula" class="invalid">Al menos <strong>una letra mayuscula</strong></li>
                            <li id="numero" class="invalid">Al menos <strong>un numero</strong></li>
                            <li id="lengthx" class="invalid">Al menos <strong>8 caracteres</strong></li>
                        </ul>
                    </div>-->
                    <td >
                        <div class="input-group-append">
                            <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()" title="CLIC PARA VER CONTRASE&Ntilde;A">   <img src="ojo.svg" width="16" height="16" title="HACER CLIC PARA ACTIVAR USUARIO" border="0"/> </button><a id="comprobado_pass" ><strong></strong></a>

                        </div>
                         
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">CONTRASE&Ntilde;A DE VENTA</td>
                    <td width="60"><label>
                            c<input name="claveventa" type="password" onkeypress="return acceptNum(event)" id="claveventa" maxlength="10" size="20" value="<?php echo $claveventa ?>"/>
                        </label></td>
                </tr>
                <tr>
                    <td class="LETRA">GRUPO</td>
                    <td colspan="2"><select name="grupo" id="grupo" style="width:auto;text-align: center;">
                            <?php
                            $sql = "SELECT codgrup,nomgrup FROM grupo_user order by nomgrup";
                            $result = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $codgrup1 = $row["codgrup"];
                                $nomgrup = $row["nomgrup"];
                                ?>
                                <option value="<?php echo $row["codgrup"]; ?>" <?php if ($grupo == $codgrup1) { ?> selected="selected"<?php } ?>><?php echo $row["nomgrup"] ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td class="LETRA">LOCAL</td>
                    <td colspan="2"><label>
                            <select name="local" id="local" style="width:80px;text-align: center;">
                                <?php
                                $sql = "SELECT codloc, nombre from xcompa order by codloc ASC LIMIT $nlicencia";
                                $result = mysqli_query($conexion, $sql);
                                if (mysqli_num_rows($result)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option <?php if ($codloc == $row[0]) { ?>selected="selected"<?php } ?> value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">NO EXISTEN LOCALES REGISTRADAS</option>
                                <?php }
                                ?>
                            </select>
                        </label></td>
                </tr>
                <tr>
                    <td class="LETRA">REPORTES A EXCEL </td>
                    <td colspan="2"><label>
                            <select name="excel" id="excel">
                                <option value="1" <?php if ($export == 1) { ?>selected="selected"<?php } ?>>SI</option>
                                <option value="0" <?php if ($export == 0) { ?>selected="selected"<?php } ?>>NO</option>
                            </select>
                        </label></td>
                </tr>
            </table>
            <table width="533" border="0" align="center">
                <tr>
                    <td width="80">&nbsp;</td>
                    <td width="443"><label>
                            <input name="usecod" type="hidden" id="usecod" value="<?php echo $usecod ?>" />
                            <input name="codgrup" type="hidden" id="codgrup" value="<?php echo $codgrup ?>" />
                            <input type="button" name="Submit" id="botones" value="Grabar Informacion" style="width: auto;"class=" grabar"onclick="grabar()"/>
                            <input type="button" name="Submit" value="Regresar" style="width: auto;"class=" cancelar"onclick="regresar()"/>
                        </label></td>
                </tr>
            </table>
            <script type="text/javascript">
                $('#grupo').select2();
                $('#local').select2();
                function validarUsuario_pass(clave, login)
                {
                    var url = 'validarusuario_pass.php';
                    var parametros = 'codigo=' + clave.value + '&login=' + login.value;
                    var ajax = new Ajax.Updater('comprobado_pass', url, {method: 'get', parameters: parametros});
                }
            </script>
        </form>
    </body>
</html>
<script type="text/javascript"  src="prototype.js"></script>