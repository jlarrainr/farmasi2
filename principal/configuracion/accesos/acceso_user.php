<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="windows-1252">
        
        <title>Documento sin t&iacute;tulo</title>
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
        <script src="../../../funciones/alertify/alertify.min.js"></script>
        <link href="../../select2/css/select2.min.css" rel="stylesheet" />
        <script src="../../select2/jquery-3.4.1.js"></script>
        <script src="../../select2/js/select2.min.js"></script>


        <?php
        require_once ('../../../conexion.php');
        require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        require_once("../../../funciones/funct_principal.php"); //DESHABILITA TECLAS
        require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
        require_once("ajax_user.php");
        ?>
        <script language="JavaScript">
            function graba()
            {
                var f = document.form1;
                if (f.nombre.value == "")
                {
                    alert("Ingrese el Nombre del Usuario");
                    f.nombre.focus();
                    return;
                }
                if (f.login.value == "")
                {
                    alert("Ingrese el Login del Usuario");
                    f.login.focus();
                    return;
                }
                if (f.codigo.value == "")
                {
                    alert("Ingrese el Codigo de acceso");
                    f.codigo.focus();
                    return;
                }
                if (f.claveventa.value == "")
                {
                    alert("Ingrese el Codigo de Venta del Usuario");
                    f.claveventa.focus();
                    return;
                }

              /*  var codigo = document.getElementById('codigo').value;
                if (validar_clave(codigo) == true)
                {*/
//                    alert('Cotraseña fuerte');
//                     return;
                    f.method = "post";
                    f.action = "acceso_user1.php";
                    f.submit();
               /* } else
                {
                    alert('La contrasena ingresada no es fuerte');
                    f.codigo.focus();
                    return;
                }*/

            }
            function sf() {
                document.form1.nombre.focus();
            }

            function validar_clave(codigo)
            {
                if (codigo.length >= 8)
                {
//                    Tiene ocho caracteres como mínimo.
                    var mayuscula = false;
                    var minuscula = false;
                    var numero = false;
                    var caracter_raro = false;
                    for (var i = 0; i < codigo.length; i++)
                    {
                        if (codigo.charCodeAt(i) >= 65 && codigo.charCodeAt(i) <= 90)
                        {
//                            Letras minúsculas.
                            mayuscula = true;
                        } else if (codigo.charCodeAt(i) >= 97 && codigo.charCodeAt(i) <= 122)
                        {
                            minuscula = true;
                        } else if (codigo.charCodeAt(i) >= 48 && codigo.charCodeAt(i) <= 57)
                        {
//                            Números.
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
            var letras = "abcdefghyjklmnñopqrstuvwxyz";
            function tiene_letras(texto) {
                texto = texto.toLowerCase();
                for (i = 0; i < texto.length; i++) {
                    if (letras.indexOf(texto.charAt(i), 0) != -1) {
                        return 1;
                    }
                }
                return 0;
            }
//            var letras = "abcdefghyjklmnñopqrstuvwxyz";

            function tiene_minusculas(texto) {
                for (i = 0; i < texto.length; i++) {
                    if (letras.indexOf(texto.charAt(i), 0) != -1) {
                        return 1;
                    }
                }
                return 0;
            }
            var letras_mayusculas = "ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
            function tiene_mayusculas(texto) {
                for (i = 0; i < texto.length; i++) {
                    if (letras_mayusculas.indexOf(texto.charAt(i), 0) != -1) {
                        return 1;
                    }
                }
                return 0;
            }

            function ocultar() {
                div = document.getElementById('contenido');
//                div.style.display = 'none';
            }
            function mensajes_pass(codigo) {
                var campo = 0;
                var clave = document.form1.codigo.value;
                var strLength = codigo.value.length;
                if (codigo.value.length != 0) {
                    div = document.getElementById('contenido');
                    div.style.display = '';
                    if (codigo.value.length >= 8) {
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

                    if (tiene_numeros(clave)) {
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
//                    if (tiene_letras(clave)) {
//                        campo += 1;
//                        M_tiene_letras = 'a-Z';
//                        M_tiene_letras = M_tiene_letras.fontcolor('blue');
//                    } else {
//                        campo += 0;
//                        M_tiene_letras = 'a-Z';
//                        M_tiene_letras = M_tiene_letras.fontcolor('red');
//                    }
//            ------------------------------------------------
                    if (tiene_minusculas(clave)) {
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
                    if (tiene_mayusculas(clave)) {
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

                        document.form1.botones.value = "GABAR";
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
            function seguridad_clave(codigo) {
                var seguridad = 0;
                var clave = document.form1.codigo.value;
                var strLength = codigo.value.length;
                if (codigo.value.length != 0) {

                    if (tiene_numeros(clave) && tiene_letras(clave)) {
                        seguridad += 30;
                    }
                    if (tiene_minusculas(clave) && tiene_mayusculas(clave)) {
                        seguridad += 30;
                    }
                    if (codigo.value.length >= 4 && codigo.value.length <= 5) {
                        seguridad += 10;
                    } else {
                        if (codigo.value.length >= 6 && codigo.value.length <= 8) {
                            seguridad += 30;
                        } else {
                            if (codigo.value.length > 8) {
                                seguridad += 40;
                            }
                        }
                    }
                }
                return seguridad
            }


            function muestra_seguridad_clave(codigo) {
                seguridad = seguridad_clave(codigo);
//                document.form1.seguridad.value = seguridad + "%";
                document.getElementById("seguridad").innerHTML = 'Nivel de seguridad: ' + seguridad + "%";
                if(seguridad == 10){
                     document.getElementById("seguridad").style.color = "red";
                }else if(seguridad == 40){
                    document.getElementById("seguridad").style.color = "#ff8b00";//NARANJA
                }else if(seguridad == 70){
                    document.getElementById("seguridad").style.color = "#2d9df9"; //AZUL
                }else if(seguridad == 100){
                    document.getElementById("seguridad").style.color = "#00df11";//verde
                }
            }

            function mostrarPassword() {
                var cambio = document.getElementById("codigo");
                if (cambio.type == "password") {
                    cambio.type = "text";
                    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                } else {
                    cambio.type = "password";
                    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }

            $(document).ready(function () {
                //CheckBox mostrar contraseña
                $('#ShowPassword').click(function () {
                    $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                });
            });
        </script>
        <style type="text/css">
            <!--
            .Estilo1 {color: #0066CC}
            -->
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
            .invalid{
                color: red;
            }
            .valid{
                color: #00df11;
            }


            .balloon:before {
                content:"";
                position: absolute;
                width: 0;
                height: 0;
                border-bottom: 30px solid #f5f5f5;
                border-right: 10px solid transparent;
                border-left: 10px solid transparent;
                margin: -15px 0 0 50px;
            }
        </style>


    </head>
    <?php
    $codgrup = $_REQUEST['codgrup'];
    $error = $_REQUEST['error'];
    $error_nomb = $_REQUEST['nomb'];
    $ok = $_REQUEST['ok'];
    $val = $_REQUEST['val'];
    $sql = "SELECT nomgrup FROM grupo_user where codgrup = '$codgrup'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
    $nomgrup = $row['nomgrup'];
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
    <body onload="sf();" style="background-color:#f5f5f5;">


        <table width="584" border="0" align="center">
            <tr>
                <td width="578" align="center">
                    <span  class="text_combo_select"><strong> REGISTRO DE USUARIOS DEL SISTEMA - <?php echo $nomgrup ?></strong></span>
                    <img src="../../../images/line2.jpg" width="570" height="4" />
                </td>
            </tr>
        </table>
        <?php
        if ($val == 1) {
        ?>
        <table width="100%" border="0" align="center" class="tabla2">
            <tr>
                <td><span class="Estilo1">
                        <?php
                        if ($ok == 1) {
//                                echo "SE LOGRO REGISTRAR SATISFACTORIAMENTE UN USUARIO";
                        ?>
                        <script>
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success("<a style='color:White;font-size:10px;font-weight: bold;'>SE LOGRO REGISTRAR SATISFACTORIAMENTE UN USUARIO.</a>", alertify.get('notifier', 'position'));

                        </script>
                        <?php
                        }
                        if ($error == 1) {
                        //                                echo "NO SE PUDO REGISTRAR EL USUARIO, ESTE YA SE ENCUENTRA REGISTRADO EN EL SISTEMA";
                        ?>
                        <script>

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error("<a style='color:White;font-size:10px;font-weight: bold;'>ERROR!- NO SE PUDO REGISTRAR EL USUARIO, ESTE YA SE ENCUENTRA REGISTRADO EN EL SISTEMA.</a>", alertify.get('notifier', 'position'));

                        </script>
                        <?php
                        }
                        if ($error_nomb == 1) {
                        ?>
                        <script>

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error("<a style='color:White;font-size:10px;font-weight: bold;'>YA EXISTE ESE NOMBRE REGISTRADO EN EL SISTEMA.</a>", alertify.get('notifier', 'position'));

                        </script>
                        <?php
                        }
                        ?>
                    </span> 
                </td>
            </tr>
        </table>
        <?php }
        ?>
        <table width="100%" border="0" align="center" class="tabla2">
            <tr>
                <td>
                    <form id="form1" name="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td width="130" class="LETRA">GRUPO DE USUARIO </td>
                                <td colspan="2" width="394"><b><?php echo $nomgrup ?></b></td>
                            </tr>
                            <tr>
                                <td class="LETRA">NOMBRE</td>
                                <td colspan="2">
                                    <input tabindex="1" name="nombre" type="text" id="nombre" size="60" onkeyup="cargarContenido()" placeholder="Ingrese Nombre...." />          </td>
                            </tr>
                            <tr>
                                <td class="LETRA">ABREVIATURA</td>
                                <td colspan="2"><div id="contenedor"></div></td>
                            </tr>
                            <tr>
                                <td class="LETRA">USUARIO</td>
                                <td colspan="2">
                                    <input tabindex="2" name="login" type="text" id="login" size="60" onblur="validarUsuario(this);" placeholder="Ingrese Usuario...." />          
                                    <div  id="comprobado"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">CONTRASE&Ntilde;A </td>
                                <td width="50" >
                                  <!--  <input tabindex="3" name="codigo" type="password" id="codigo" size="21"  placeholder="Ingrese Contrase&ntilde;a...." onkeyup="muestra_seguridad_clave(codigo), mensajes_pass(codigo)"  onblur="validarUsuario_pass(codigo, login);"  />-->
                                    <input tabindex="3" name="codigo" type="password" id="codigo" size="21"  placeholder="Ingrese Contrase&ntilde;a...."  onkeypress="return acceptNum(event)"  onblur="validarUsuario_pass(codigo, login);"  />
                                
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
                                <td>
                                    <div class="input-group-append" >
                                        <button  id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()" title="CLIC PARA VER CONTRASE&Ntilde;A">  <img src="ojo.svg" width="16" height="16"  border="0"/> </button> <a id="comprobado_pass" ><strong></strong></a>

                                    </div>
                                     
                                </td>
                                <!--<div  id="comprobado_pass"></div>--> 
                                <!--<div  name="seguridad"  id="seguridad" style="border: 0px; background-color:ffffff; text-decoration:italic;"></div>-->  
                                <!--<div  id="mensajepass"></div>--> 


                            </tr>
                            <tr>
                                <td class="LETRA">CONTRASE&Ntilde;A DE VENTA </td>
                                <td colspan="2">c<input tabindex="4" name="claveventa" type="password"  id="claveventa" maxlength="10" size="33" onkeyup="ocultar();" placeholder="Ingrese Contrase&ntilde;a de venta...." /></td>
                            </tr>
                            <tr>
                                <td class="LETRA">REPORTES A EXCEL </td>
                                <td colspan="2"><label>
                                        <select tabindex="5" name="excel" id="excel">
                                            <option value="1" <?php if ($export == 1) { ?>selected="selected"<?php } ?>>SI</option>
                                            <option value="0" <?php if ($export == 0) { ?>selected="selected"<?php } ?>>NO</option>
                                        </select>
                                    </label></td>
                            </tr>
                            <tr>
                                <td class="LETRA">LOCAL</td>
                                <td colspan="2">
                                    <select tabindex="6" name="local" id="local" style="width:80px;text-align: center;">
                                        <?php
                                        $sql = "SELECT codloc, nomloc, nombre from xcompa where habil = '1' order by codloc ASC LIMIT $nlicencia";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value="<?php echo $row[0] ?>"><?php
                                                    if ($row[2] <> "") {
                                                        echo $row[2];
                                                    } else {
                                                        echo $row[1];
                                                    }
                                                    ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="0">NO EXISTEN LOCALES REGISTRADAS</option>
                                        <?php }
                                        ?>
                                    </select>
                                    <input name="grup" type="hidden" id="grup" value="<?php echo $codgrup ?>" />
                                    <input tabindex="7" type="button" name="Submit" value="Grabar" id="botones" class="grabar" onclick="graba()"/></td>
                            </tr>


                        </table>
                    </form>
                </td>
            </tr>
        </table>
<!--        <table width="100%" border="0" align="center">
            <tr>
                <td align="center" width="578"><span class="text_combo_select"><strong> LISTADO DE USUARIOS - <?php echo $nomgrup ?></strong></span><img src="../../../images/line2.jpg" width="570" height="4" />
                </td>
            </tr>
        </table>-->
        <table width="100%" border="0" align="center" class="tabla2">
            <tr>
                <td>
                    <center>

                        <iframe src="acceso_user_listado.php?codgrup=<?php echo $codgrup ?>" name="iFrame1" width="100%" height="340" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True">
                        </iframe>
                    </center>
                </td>
            </tr>
        </table>

        <script type="text/javascript">
            $('#local').select2();
            function validarUsuario(login)
            {
                var url = 'validarusuario.php';
                var parametros = 'login=' + login.value;
                var ajax = new Ajax.Updater('comprobado', url, {method: 'get', parameters: parametros});
            }

            function validarUsuario_pass(codigo, login)
            {
                var url = 'validarusuario_pass.php';
                var parametros = 'codigo=' + codigo.value + '&login=' + login.value;
                var ajax = new Ajax.Updater('comprobado_pass', url, {method: 'get', parameters: parametros});
            }
        </script>
    </body>
</html>
<script type="text/javascript"  src="prototype.js"></script>