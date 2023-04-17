<?php
require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">


    <title><?php echo $desemp ?></title>
    <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="../../../archivo/css/select_cli.css" rel="stylesheet" type="text/css">
    <?php
    require_once('../../../../funciones/funct_principal.php');
    require_once('../../../../funciones/highlight.php');    //ILUMINA CAJAS DE TEXTOS
    require_once('../../../../funciones/botones.php');    //COLORES DE LOS BOTONES
    require_once("funciones/call_combo.php");    //LLAMA A generaSelect
    $close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";
    ?>

    <script type="text/javascript" src="funciones/ajax.js"></script>
    <script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="funciones/select_3_niveles.js"></script>

    <link href="../../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../../select2/jquery-3.4.1.js"></script>
    <script src="../../../select2/js/select2.min.js"></script>

    <script type="text/javascript">
        function fc() {
            document.form1.country.focus();
        }

        function asigna() {
            var f = document.form1;
            if (f.country_ID.value == "") {
                alert("Ingrese el nombre del Medico");
                f.country.focus();
                return;
            }
            var codmed = f.country_ID.value;
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php?codmed=" + codmed;
            self.close();
        }
        var nav4 = window.Event ? true : false;

        function enteres1(evt) {
            var f = document.form1;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (f.country_ID.value !== '') {
                    document.form1.submit();
                } else {
                    alert("Ingrese una descripci�1�70�1�71�1�70�1�76n");
                    return false;
                }
            } else {
                return false;
            }
        }

        function save_medico() {
            var f = document.form2;
            if (f.nommedico.value == "") {
                alert("Ingrese el nombre del Medico");
                f.nommedico.focus();
                return;
            }
            if (f.colegiatura.value == "") {
                alert("Debe ingresar su colegiatura");
                f.colegiatura.focus();
                return;
            }

            if (f.especialidad.value == 0) {
                alert("Seleccione una Especialidad");
                f.especialidad.focus();
                return;
            }
            ventana = confirm("Desea Grabar este Medico");
            if (ventana) {
                f.method = "post";
                f.action = "medico_reg.php";
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

                var codmed = f.country_ID.value;
                document.form1.target = "venta_principal";
                window.opener.location.href = "salir.php?codmed=" + codmed;
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

    <style type="text/css">
        .body {
            background-color: #FFFFCC;
        }

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
    </style>
</head>
<?php
$val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
if ($val == 4) {
    $codmed = $_REQUEST['country_ID'];
    $sql = "SELECT codmed,nommedico,codcolegiatura FROM medico where codmed = '$codmed'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codmed           = $row["codmed"];
            $nommedico        = $row["nommedico"];
            $codcolegiatura   = $row["codcolegiatura"];
            mysqli_query($conexion, "UPDATE venta set codmed = '$codmed' where invnum = '$venta'");
            mysqli_query($conexion, "UPDATE temp_venta set codmed = '$codmed' where invnum = '$venta'");
        }
    }
}
$sql = "SELECT invnum,nrovent,invfec,cuscod,codmed,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum       = $row['invnum'];        //codgio
        $nrovent      = $row['nrovent'];
        $invfec       = $row['invfec'];
        $cuscod       = $row['cuscod'];
        $codmedd       = $row['codmed'];
        $usecod       = $row['usecod'];
        $codven       = $row['codven'];
        $forpag       = $row['forpag'];
        $fecven       = $row['fecven'];
        $correlativo  = $row['correlativo'];
    }
}
$sql = "SELECT codmed,nommedico,codcolegiatura FROM medico where codmed = '$codmedd'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $codmed           = $row["codmed"];
        $nommedico        = $row["nommedico"];
        $codcolegiatura   = $row["codcolegiatura"];
    }
}
function formato($c)
{
    printf("%08d",  $c);
}
$especialidad = $_REQUEST['especialidad'];
?>
</head>

<body <?php if ($close == 1) { ?>onload="cerrar_popup()" <?php } else {
                                                            if ($close == 2) { ?> onload="cerrar_popup1()" <?php } else { ?>onload="fc()" <?php }
                                                                                                                                    } ?> onkeyup="escapes(event)">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
        <div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
        <div align="center">
            <table width="100%" border="0" bgcolor="#f8f8f8">
                <tr>
                    <td class="LETRA" valign="top">NRO DE OPERACION </td>
                    <td valign="top">
                        <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo) ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="LETRA" valign="top">BUSCAR MEDICO</td>
                    <td valign="top">
                        <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="80" onclick="this.value=''" onkeypress="return ent(event);" />
                        <input type="hidden" id="country_hidden" name="country_ID" onkeypress="enteres1(event)" />
                        <input name="val" type="hidden" id="val" value="2" />
                        <input name="button" type="button" value="ASIGNAR" onclick="asigna()" class="buscar" />
                        <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()" class="limpiar" />
                    </td>
                </tr>
            </table>
            <img src="../../../../images/line2.png" width="100%" height="4" />

            <table align="center" width="95%" border="0" bgcolor="#3f92c3">
                <tr>
                    <td align="center" class="COLOR2"><strong>CREAR MEDICO</strong></td>
                </tr>
            </table>

        </div>

    </form>
    <form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
        <table align="center" width="95%" border="0" bgcolor="#e5e2e2" style="border: 1px solid #3f92c3;">

            <tr>
                <td class="COLOR" width="103">NOMBRE MEDICO</td>
                <td width="452"><input name="nommedico" type="text" id="nommedico" size="60" onkeyup="this.value = this.value.toUpperCase();" /> </td>
            </tr>
            <tr>
                <td class="COLOR">COLEGIATURA</td>
                <td><input name="colegiatura" type="text" id="colegiatura" onkeypress="return acceptNum(event)" /> </td>
            </tr>
            <tr>
                <td class="LETRA">ESPECIALIDAD</td>
                <td>
                    <select style='width:350px;' id="especialidad" name="especialidad">
                        <option value="0">Seleccione una Especialidad...</option>
                        <?php
                        $sql = "SELECT id,nombre FROM especialidad_medica   order by nombre";
                        $result = mysqli_query($conexion, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $especia = $row["id"];
                        ?>
                            <option value="<?php echo $row["id"] ?>" <?php if ($especialidad == $especia) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo strtoupper($row["nombre"]) ?></option>
                        <?php } ?>
                    </select>
                    <input type="button" name="Submit" value="GRABAR" onclick="save_medico()" class="grabar" />
                </td>
            </tr>


        </table>
    </form>
</body>

</html>
<script>
    $("#especialidad").select2({
        placeholder: "sometext",
        allowClear: false,
        tags: true
    });
</script>