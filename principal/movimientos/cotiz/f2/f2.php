<?php
require_once('../../../session_user.php');
$venta = $_SESSION['venta'];
require_once('../../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../../../icono.ico" />
    <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="../../../archivo/css/select_cli.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <?php
    require_once('../../../../funciones/funct_principal.php');
    require_once('../../../../funciones/highlight.php'); //ILUMINA CAJAS DE TEXTOS
    require_once('../../../../funciones/botones.php'); //COLORES DE LOS BOTONES
    require_once("funciones/call_combo.php"); //LLAMA A generaSelect
    $close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : "";
    ?>
    <script type="text/javascript" src="funciones/ajax.js"></script>
    <script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="funciones/select_3_niveles.js"></script>

    <script type="text/javascript">
        function errorDNI() {
            alert("DNI ya se encuentra registardo");
            var f = document.form1;
            f.country.focus();
            return;
        }

        function errorRUC() {
            alert("RUC ya se encuentra registardo");
            var f = document.form1;
            f.country.focus();
            return;
        }

        function fc() {
            document.form1.country.focus();
        }

        function asigna() {
            var f = document.form1;
            if (f.country_ID.value == "") {
                alert("Ingrese el nombre del Cliente");
                f.country.focus();
                return;
            }
            var codcli = f.country_ID.value;
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php?codcli=" + codcli;
            self.close();
        }


        function validarRUC(elemento) {
            var f = document.form2;

            if (f.ruc.value != "") {
                document.form2.dni.disabled = true;
                document.form2.boton_dni.disabled = true;
                var actual = document.getElementById('imagen_actual_dni');
                actual.src = "disabled.svg";
                document.getElementById("dni").style.borderColor = "#f51e1e"; //ROJO     
                document.getElementById("boton_dni").style.color = "#1f1e1e"; //ROJO
                document.getElementById("boton_dni").style.background = "#e4e1e1"; //ROJO
                document.getElementById("boton_dni").style.borderColor = "#1f1e1e"; //ROJO
                var maxLength = 11;
                var strLength = elemento.value.length;
                document.getElementById("contadorRUC").innerHTML = strLength + '/' + maxLength;
                if (strLength < maxLength) {
                    document.getElementById("contadorRUC").style.color = "red"; //rojo
                } else {
                    document.getElementById("contadorRUC").style.color = "blue"; //azul
                }
            } else {
                document.form2.dni.disabled = false;
                document.form2.boton_dni.disabled = false;
                document.getElementById("nom").value = "";
                document.getElementById("direc").value = "";
                document.getElementById("fono").value = "";
                var actual = document.getElementById('imagen_actual_dni');
                actual.src = "";
                document.getElementById("dni").style.borderColor = "#15ff00"; //VERDE
                document.getElementById("contadorRUC").innerHTML = '';
                document.getElementById("boton_dni").style.color = "#074897"; //ROJO
                document.getElementById("boton_dni").style.background = "#f8f8f8"; //ROJO
                document.getElementById("boton_dni").style.borderColor = "#074897"; //ROJO
            }

        }

        function validarDNI(elemento) {
            var f = document.form2;
            if (f.dni.value != "") {

                document.form2.ruc.disabled = true;
                document.form2.boton_ruc.disabled = true;
                var actual = document.getElementById('imagen_actual_ruc');
                actual.src = "disabled.svg";
                document.getElementById("ruc").style.borderColor = "#f51e1e"; //ROJO
                document.getElementById("boton_ruc").style.color = "#1f1e1e"; //ROJO
                document.getElementById("boton_ruc").style.background = "#e4e1e1"; //ROJO
                document.getElementById("boton_ruc").style.borderColor = "#1f1e1e"; //ROJO
                var maxLength = 8;
                var strLength = elemento.value.length;
                document.getElementById("contadorDNI").innerHTML = strLength + '/' + maxLength;

                if (strLength < maxLength) {
                    document.getElementById("contadorDNI").style.color = "red"; //rojo
                } else {
                    document.getElementById("contadorDNI").style.color = "blue"; //azul
                }
            } else {
                document.form2.ruc.disabled = false;
                document.form2.boton_ruc.disabled = false;
                document.getElementById("nom").value = "";
                var actual = document.getElementById('imagen_actual_ruc');
                actual.src = "";
                document.getElementById("ruc").style.borderColor = "#15ff00"; //VERDE
                document.getElementById("contadorDNI").innerHTML = '';
                document.getElementById("boton_ruc").style.color = "#bf0909"; //ROJO
                document.getElementById("boton_ruc").style.background = "#f8f8f8"; //ROJO
                document.getElementById("boton_ruc").style.borderColor = "#bf0909"; //ROJO
            }

        }

        function save_cliente() {
            var f = document.form2;
            if (f.nom.value == "null null null") {
                alert("El cliente no se encuentra registrado en la RENIEC, no es valido");
                f.nom.focus();
                return;
            }
            if (f.nom.value == "") {
                alert("Ingrese el nombre del Cliente");
                f.nom.focus();
                return;
            }
            if ((f.ruc.value == "") && (f.dni.value == "")) {
                alert("Ingresar un RUC o un DNI del cliente");
                f.ruc.focus();
                return;
            }
            var ruc = f.ruc.value;
            if (ruc.length > 0) {
                if (ruc.length < 11) {
                    alert("Debe ingresar 11 caracteres en el RUC");
                    f.ruc.focus();
                    return false;
                }
            }

            var dni = f.dni.value;
            if (dni.length > 0) {
                if (dni.length < 8) {
                    alert("Debe ingresar 8 caracteres en el DNI");
                    f.dni.focus();
                    return false;
                }
            }
            if (f.mail.value != "") {
                if (f.emailres.value == 0) {
                    alert("Correo invalido");
                    f.email.focus();
                    return;
                }
            }
            ventana = confirm("Desea Grabar este Cliente");
            if (ventana) {
                f.method = "post";
                f.action = "cliente_reg.php";
                f.submit();
            }
        }

        function cerrar_popup() {
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php";
            self.close();
        }

        function cerrar_popup1() {
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir1.php";
            self.close();
        }

        function validarEmail(elemento) {

            var texto = document.getElementById(elemento.id).value;
            var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            if (texto != "") {
                if (!regex.test(texto)) {
                    document.getElementById("resultado").innerHTML = "Correo invalido";
                    document.getElementById("resultado").style.color = "red";
                    document.form2.emailres.value = 0;
                } else {
                    document.getElementById("resultado").innerHTML = "Correo valido";
                    document.getElementById("resultado").style.color = "blue";
                    document.form2.emailres.value = 1;
                }
            } else {
                document.getElementById("resultado").innerHTML = "";
                document.form2.emailres.value = "";
            }
        }
        var nav4 = window.Event ? true : false;

        function ent(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                var f = document.form1;
                if (f.country_ID.value == "") {
                    alert("Ingrese el nombre del Cliente");
                    f.country.focus();
                    return;
                }

                var codcli = f.country_ID.value;
                document.form1.target = "venta_principal";
                window.opener.location.href = "salir.php?codcli=" + codcli;
                self.close();
            }
        }

        function escapes(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }
    </script>

</head>
<?php
$val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
if ($val == 1) {
    $codcli = $_REQUEST['country_ID'];
    $sql = "SELECT codcli,descli,dnicli FROM cliente where codcli = '$codcli'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codcli = $row["codcli"];
            $descli = $row["descli"];
            $dnicli = $row["dnicli"];
            mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");

            if (isset($_SESSION['arr_detalle_venta'])) {
                $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
            } else {
                $arr_detalle_venta = array();
            }
            $arrAux = array();
            foreach ($arr_detalle_venta as $detalle) {
                $detalle['cuscod'] = $codcli;
                $arrAux[] = $detalle;
            }
            $_SESSION['arr_detalle_venta'] = $arrAux;
        }
    }
}
$sql = "SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];  //codgio
        $nrovent = $row['nrovent'];
        $invfec = $row['invfec'];
        $cuscod = $row['cuscod'];
        $usecod = $row['usecod'];
        $codven = $row['codven'];
        $forpag = $row['forpag'];
        $fecven = $row['fecven'];
        $correlativo = $row['correlativo'];
    }
}
$sql = "SELECT codcli,descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcli = $row["codcli"];
        $descli = $row["descli"];
    }
}

function formato($c)
{
    printf("%08d", $c);
}
?>
<style>
    .COLOR {
        color: #FF0000;
    }

    /* CSS link color */
    .COLOR2 {
        color: #ffffff;
        font-family: Tahoma;
        font-size: 16px;
        line-height: normal;
        font-weight: bold;
    }

    /* CSS link color */
    .LETRA {
        font-family: Tahoma;
        font-size: 11px;
        line-height: normal;
        color: '#5f5e5e';
        font-weight: bold;
    }

    input {
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 12px;
        background-color: white;
        background-position: 3px 3px;
        background-repeat: no-repeat;
        padding: 2px 1px 2px 5px;

    }

    .boton_personalizado_RUC {
        text-decoration: none;
        padding: 2px;
        font-weight: 600;
        font-size: 11px;
        color: #bf0909;
        background-color: #f8f8f8;
        border-radius: 6px;
        border: 1px solid #bf0909;
    }

    .boton_personalizado_RUC:hover {
        color: #ffffff;
        background-color: #bf0909;
    }

    .boton_personalizado_DNI {
        text-decoration: none;
        padding: 2px;
        font-weight: 600;
        font-size: 11px;
        color: #074897;
        background-color: #f8f8f8;
        border-radius: 6px;
        border: 1px solid #074897;
    }

    .boton_personalizado_DNI:hover {
        color: #ffffff;
        background-color: #074897;
    }
</style>
</head>

<body <?php if ($close == 1) { ?> onload="cerrar_popup();" <?php } else if ($close == 2) {
                                                            ?> onload="cerrar_popup1();" <?php } else if ($error == 1) { ?> onload="errorDNI();" <?php } else if ($error == 2) {
                                                                                                                                                    ?> onload="errorRUC();" <?php
                                                                                                                                                                        } else {
                                                                                                                                                                            ?> onload="fc();" <?php }
                                                                                                                                                                                                ?> onkeyup="escapes(event)">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
        <div align="center"><img src="../../../../images/line2.png" width="100%" height="10" /></div>
        <div align="center">
            <table align="center" width="100%" border="0" bgcolor="#3f92c3">
                <tr>
                    <td align="left" class="COLOR2"><strong>CLIENTE YA REGISTRADO</strong></td>
                </tr>
            </table>
            <table width="100%" border="0" bgcolor="#f8f8f8">
                <!--
                                <tr>
                                  <td width="74" valign="top" class="LETRA">NRO DE VENTA </td>
                                  <td width="481" valign="top">
                                      <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo) ?>"/>      </td>
                                </tr>
                                -->
                <tr>
                    <td class="LETRA">BUSCAR CLIENTE</td>
                    <td valign="top">
                        <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" size="80" onclick="this.value = ''" onkeypress="return ent(event);" placeholder="Buscar al cliente para asignar a la venta....." />
                        <input type="hidden" id="country_hidden" name="country_ID" />
                        <input name="val" type="hidden" id="val" value="1" />
                        <input name="button" type="button" value="ASIGNAR" onclick="asigna()" class="buscar" />
                        <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()" class="limpiar" />
                    </td>
                </tr>
            </table>
            <img src="../../../../images/line2.png" width="100%" height="10" />
            <table align="center" width="100%" border="0" bgcolor="#3f92c3">
                <tr>
                    <td align="LEFT" class="COLOR2"><strong>CLIENTE NUEVO</strong></td>
                </tr>
            </table>
        </div>
    </form>
    <form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
        <div align="center">
            <table width="100%" border="0" bgcolor="#e5e2e2" style="border: 1px solid #3f92c3;">
                <tr>
                    <td width="105" width="105" class="LETRA"><strong>RUC </strong></td>
                    <td width="5"><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td width="452">
                        <input tabindex="1" type="text" id="ruc" name="ruc" value="" size="30" maxlength="11" autocomplete="off" placeholder="Buscar RUC del cliente..." onkeypress="return acceptNum(event)" onkeyup="validarRUC(this)" />
                        <button class="boton_personalizado_RUC" type="button" onclick="busqueda();" id="boton_ruc" title="Se buscara en la SUNAT">
                            <span>BUSCAR RUC</span>
                        </button>
                        <a id='contadorRUC'></a>
                        &nbsp;
                        &nbsp;
                        <img id="imagen_actual_ruc" src="" width="20px" height="20px" style="margin-bottom: -7px;" title="Opcion se encuentra deshabilitado" />

                    </td>
                </tr>
                <tr>
                    <td class="COLOR" class="LETRA"><strong>DNI</strong></td>
                    <td><a style="color:green;"> <strong> </strong></a></td>
                    <td><input tabindex="2" name="dni" type="text" id="dni" size="30" placeholder="Buscar DNI del cliente..." onkeypress="return acceptNum(event)" maxlength="8" onkeyup="validarDNI(this)" />

                        <button class="boton_personalizado_DNI" type="button" onclick="busqueda_DNI();" id="boton_dni" title="Se buscara en la RENIEC">
                            <span>BUSCAR DNI</span>
                        </button>
                        <a id='contadorDNI'></a>
                        &nbsp;
                        &nbsp;

                        <img id="imagen_actual_dni" src="" width="20px" height="20px" style="margin-bottom: -4px;" title="Opcion se encuentra deshabilitado" />

                    </td>
                </tr>
                <tr>
                    <td class="COLOR" width="105" class="LETRA"><strong>NOMBRE / RAZON SOCIAL </strong></td>
                    <td><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td> <input tabindex="3" name="nom" type="text" id="nom" size="85" onkeyup="this.value = this.value.toUpperCase();" /> </td>
                </tr>

                <!--  <tr>
     <td class="LETRA">RUC</td>
     <td   width="5"><a style="color:green;"> <strong> (F)</strong></a></td>
     <td> <input name="ruc" type="text" id="ruc" size="60" onkeypress="return acceptNum(event)" maxlength="11" minlength="11" onkeyup="validarRUC(this)"/>      
         <a id='resultadoRUC'></a>
         <a id='contadorRUC'></a>

     </td>
 </tr>-->
                <tr>
                    <td class="LETRA">TELEFONO 1 </td>
                    <td><a style="color:green;"> <strong> </strong></a></td>
                    <td><input tabindex="4" name="fono" type="text" id="fono" size="30" onkeypress="return acceptNum(event)" maxlength="10" /> </td>
                </tr>
                <tr>
                    <td class="LETRA">TELEFONO 2 </td>
                    <td><a style="color:green;"> <strong> </strong></a></td>
                    <td><input tabindex="5" name="fono1" type="text" id="fono1" size="30" onkeypress="return acceptNum(event)" maxlength="10" /> </td>
                </tr>
                <tr>
                    <td class="LETRA">DEPARTAMENTO</td>
                    <td><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td>
                        <div id="demoIzq">
                            <?php generaSelect($conexion); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">PROVINCIA</td>
                    <td><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td>
                        <div id="demoMed">
                            <select disabled="disabled" name="provincia" id="provincia">
                                <option value="0">Seleccione una Provincia</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">DISTRITO</td>
                    <td><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td>
                        <div id="demoDer">
                            <select disabled="disabled" name="distrito" id="distrito">
                                <option value="0">Seleccione un Distrito</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="LETRA">DIRECCION</td>
                    <td><a style="color:green;"> <strong> (F)</strong></a></td>
                    <td> <input name="direc" type="text" id="direc" size="110" /> </td>
                </tr>
                <tr>
                    <td class="LETRA">ENVIAR AL EMAIL</td>
                    <td><a style="color:green;"> <strong> </strong></a></td>
                    <td>
                        <input name="mail" type="text" id="mail" size="80" title="Si el correo es valido se le hara un envio de su comprobante de pago..." onkeyup="validarEmail(this)" />
                        <blink><a id='resultado'></a></blink>
                        <input name="emailres" type="hidden" id="emailres" value="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="button" name="Submit" value="GRABAR" onclick="save_cliente()" class="grabar" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <H4 class="COLOR">TICKET O BOLETA: PARA CREAR UN CLIENTE LLENE COMO MINIMO LOS CAMPOS EN COLOR ROJO Y LUEGO CLIC EN GRABAR</H4>
                        <H4 style="color:green;">FACTURA: LLENE COMO MINIMO LOS CAMPOS MARCADOS CON <a style="color:green;"> (F)</a> (NO LLENAR EL CAMPO DNI) Y LUEGO CLIC EN GRABAR</H4>
                    </td>
                </tr>

            </table>
        </div>
        <div align="center"><img src="../../../../images/line2.png" width="100%" height="4" />
            <br>
        </div>




        <script type="text/javascript">
            (function($) {
                $.ajaxblock = function() {
                    $("body").prepend("<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>");
                    $("#ajax-overlay").css({
                        position: 'absolute',
                        color: '#FFFFFF',
                        top: '0',
                        left: '0',
                        width: '100%',
                        height: '100%',
                        position: 'fixed',
                        background: 'rgba(39, 38, 46, 0.67)',
                        'text-align': 'center',
                        'z-index': '9999'
                    });
                    $("#ajax-overlay-body").css({
                        position: 'absolute',
                        top: '40%',
                        left: '50%',
                        width: '120px',
                        height: '48px',
                        'margin-top': '-12px',
                        'margin-left': '-60px',
                        //background: 'rgba(39, 38, 46, 0.1)',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'border-radius': '10px'
                    });
                    $("#ajax-overlay").fadeIn(50);
                };
                $.ajaxunblock = function() {
                    $("#ajax-overlay").fadeOut(100, function() {
                        $("#ajax-overlay").remove();
                    });
                };
            })(jQuery);

            function busqueda_DNI() {

                dni = $('#dni').val();
                if ((dni == "")) {
                    alert("Ingresar un DNI del cliente");
                    document.form2.dni.focus();
                    return;
                }

                if (dni.length > 0) {
                    if (dni.length < 8) {
                        alert("Debe ingresar 8 caracteres en el DNI");
                        document.form2.dni.focus();
                        return false;
                    }
                }

                try {
                    Param = {
                        documento: 'DNI',
                        nro_documento: dni
                    };
                    URLs = 'https://www.facturacionelectronica.us/facturacion/controller/ws_consulta_rucdni_v2.php?usuario=' + decodeURIComponent(escape(window.atob('MTA0NDc5MTUxMjU='))) + '&password=' + decodeURIComponent(escape(window.atob('OTg1NTExOTMz')));
                    $.ajax({
                        url: URLs,
                        data: Param,
                        dataType: 'JSON',
                        success: function(respuesta) {
                            response = respuesta['result'];
                            // var datos = eval(datos_dni);
                            //     var n1 = (datos[1]);
                            //     var n2 = (datos[2]);
                            //     var n3 = (datos[3]);
                            //     var mas = n1 + ' ' + n2 + ' ' + n3;
                            $('#dni').val(response.DNI);
                            $('#nom').val(response.Paterno + ' ' + response.Materno + ' ' + response.Nombre);
                        },
                        error: function() {
                            console.log("No se ha podido obtener la información");
                        }
                    });
                } catch (error) {
                    console.log(error);
                }
            }

            function busqueda() {

                try {
                    Param = {
                        documento: 'RUC',
                        nro_documento: $("#ruc").val()
                    };
                    URLs = 'https://www.facturacionelectronica.us/facturacion/controller/ws_consulta_rucdni_v2.php?usuario=' + decodeURIComponent(escape(window.atob('MTA0NDc5MTUxMjU='))) + '&password=' + decodeURIComponent(escape(window.atob('OTg1NTExOTMz')));
                    $.ajax({
                        url: URLs,
                        data: Param,
                        dataType: 'JSON',
                        success: function(respuesta) {
                            response = respuesta['result'];
                            $('#direc').val(response.Direccion);
                            $('#nom').val(response.RazonSocial);
                            $('#tipo').val(response.Tipo);
                            $('#fono').val(response.Telefono);

                            // $("#departamento").append($("<option></option>").attr({
                            //     value: '0',
                            //     selected: "selected"
                            // }).text(response.departamento));
                            // $("#provincia").append($("<option></option>").attr({
                            //     value: '0',
                            //     selected: "selected"
                            // }).text(response.provincia));
                            // $("#distrito").append($("<option></option>").attr({
                            //     value: '0',
                            //     selected: "selected"
                            // }).text(response.distrito));

                        },
                        error: function() {
                            console.log("No se ha podido obtener la informaci贸n");
                        }
                    });
                } catch (error) {
                    console.log(error);
                }

            }
        </script>
    </form>
</body>

</html>