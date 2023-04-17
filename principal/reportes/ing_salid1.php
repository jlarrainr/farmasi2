<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />
    <link href="css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'd/m/Y'
            });
            myCal = new Calendar({
                date2: 'd/m/Y'
            });
        });
    </script>

    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>
    <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse;
        }

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

        .LETRA2 {
            background: #d7d7d7
        }
    </style>
    <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/calendar.php"); ?>
    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <?php
    require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    require_once('../../convertfecha.php');
    ?>

    <script language="JavaScript">
        function validar() {
            var f = document.form1;
            if (f.desc.value == "") {
                alert("Ingrese el Numero del Documento");
                f.desc.focus();
                return;
            }
            document.form1.vals.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "ing_salid1.php";
            } else {
                f.action = "ing_salid_prog.php";
            }
            f.submit();
        }

        function validar1() {
            var f = document.form1;
            if (f.date1.value == "") {
                alert("Ingrese una Fecha");
                f.date1.focus();
                return;
            }
            if (f.date2.value == "") {
                alert("Ingrese una Fecha");
                f.date2.focus();
                return;
            }
            document.form1.val.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "ing_salid1.php";
            } else {
                f.action = "ing_salid_prog.php";
            }
            f.submit();
        }

        function sf() {
            var f = document.form1;
            document.form1.desc.focus();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../index.php";
            f.submit();
        }

        function combo() {
            var f = document.form1;
            if (f.mov.value == 4) {
                f.ck.disabled = false;
            } else {
                f.ck.disabled = true;
            }
        }

        function callTiposUser() {
            var f = document.form1;
            /*DivCliente
             DivProveedor
             DivSucursal*/
            var User = document.getElementById('user');
            var ValUser = User.options[User.selectedIndex].value;
            var DivCliente = document.getElementById('DivCliente');
            var DivProveedor = document.getElementById('DivProveedor');
            var DivSucursal = document.getElementById('DivSucursal');
            var DivTextUser = document.getElementById('TextUser');
            //CLIENTE
            if (ValUser == 1) {
                DivCliente.style.display = 'block';
                DivProveedor.style.display = 'none';
                DivSucursal.style.display = 'none';
                DivTextUser.innerHTML = "Cliente";
            }
            //PROVEEDOR
            if (ValUser == 2) {
                DivCliente.style.display = 'none';
                DivProveedor.style.display = 'block';
                DivSucursal.style.display = 'none';
                DivTextUser.innerHTML = "Proveedor";
            }
            //SUCURSAL
            if (ValUser == 3) {
                DivCliente.style.display = 'none';
                DivProveedor.style.display = 'none';
                DivSucursal.style.display = 'block';
                DivTextUser.innerHTML = "Sucursal";
            }
        }

        function printer() {
            window.marco.print();
        }
    </script>
</head>
<?php
$date = date('d/m/Y');
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$vals = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
$desc = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
$desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$mov = isset($_REQUEST['mov']) ? ($_REQUEST['mov']) : "";
$user = isset($_REQUEST['user']) ? ($_REQUEST['user']) : "";
$ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";
$SCliente = isset($_REQUEST['SCliente']) ? ($_REQUEST['SCliente']) : "";
$SProveedor = isset($_REQUEST['SProveedor']) ? ($_REQUEST['SProveedor']) : "";
$SSucursal = isset($_REQUEST['SSucursal']) ? ($_REQUEST['SSucursal']) : "";
$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}

//OBTIENE LA PRIMERA FECHAA DE REGISTRO DE MOVMAE
$sql = "SELECT invfec FROM movmae order by invfec asc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $PrimeraFecha = $row['invfec'];
    }
}
$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
    }
}

/* if (strlen($date1)==0)
                  {
                  //$date1 = date_format($PrimeraFecha, 'd/m/Y');
                  $date1 = date("d/m/Y", strtotime($PrimeraFecha));
                  //var_dump($date1);
                  } */
?>

<body>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE INGRESO Y SALIDA DE MERCADERIA </u></b>
                <form id="form1" name="form1" method="post" action="">

                    <table width="100%" border="0" class="table">
                        <tr bgcolor="#ececec">
                            <td class="LETRA">SALIDA</td>
                            <td>
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select> </td>
                            <td width="80" class="LETRA">
                                <div align="left">LOCAL</div>
                            </td>
                            <td colspan="2">
                                <select style="width:200px" name="local" id="local">
                                    <?php if ($nombre_local == 'LOCAL0') { ?>
                                        <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
                                    <?php } ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                    } else {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local'";
                                    }
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $loc = $row["codloc"];
                                        $nloc = $row["nomloc"];
                                        $nombre = $row["nombre"];
                                        if ($nombre == '') {
                                            $locals = $nloc;
                                        } else {
                                            $locals = $nombre;
                                        }
                                    ?>
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nombre ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>&nbsp;</td>
                        </tr>


                        <tr bgcolor="#ececec">

                            <td class="LETRA">TIPO DE MOV </td>
                            <td width="30%">
                                <select name="mov" id="mov" onchange="combo();">
                                    <option value="1" <?php if ($mov == 1) { ?> selected="selected" <?php } ?>>TODOS LOS MOVIMIENTOS</option>
                                    <option value="2" <?php if ($mov == 2) { ?> selected="selected" <?php } ?>>SOLAMENTE INGRESOS</option>
                                    <option value="3" <?php if ($mov == 3) { ?> selected="selected" <?php } ?>>SOLAMENTE SALIDAS</option>
                                    <option value="4" <?php if ($mov == 4) { ?> selected="selected" <?php } ?>>COMPRAS</option>
                                    <option value="5" <?php if ($mov == 5) { ?> selected="selected" <?php } ?>>INGRESO POR TRANSFERENCIA DE SUCURSAL</option>
                                    <option value="6" <?php if ($mov == 6) { ?> selected="selected" <?php } ?>>DEVOLUCION EN BUEN ESTADO</option>
                                    <option value="7" <?php if ($mov == 7) { ?> selected="selected" <?php } ?>>CANJE AL LABORATORIO </option>
                                    <option value="8" <?php if ($mov == 8) { ?> selected="selected" <?php } ?>>OTROS INGRESOS </option>
                                    <option value="9" <?php if ($mov == 9) { ?> selected="selected" <?php } ?>>SALIDAS VARIAS </option>
                                    <option value="10" <?php if ($mov == 10) { ?> selected="selected" <?php } ?>>GUIAS DE REMISION </option>
                                    <option value="11" <?php if ($mov == 11) { ?> selected="selected" <?php } ?>>SALIDA POR TRANSFERENCIA DE SUCURSAL</option>
                                    <option value="12" <?php if ($mov == 12) { ?> selected="selected" <?php } ?>>CANJE PROVEEDOR </option>
                                    <option value="13" <?php if ($mov == 13) { ?> selected="selected" <?php } ?>>PRESTAMOS CLIENTE </option>
                                </select>
                                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                                <select name="user" id="user" onchange="callTiposUser();">
                                    <option value="1" <?php if ($user == 1) { ?>selected="selected" <?php } ?>>CLIENTE</option>
                                    <option value="2" <?php if ($user == 2) { ?>selected="selected" <?php } ?>>PROVEEDOR</option>
                                    <option value="3" <?php if ($user == 3) { ?>selected="selected" <?php } ?>>SUCURSAL</option>
                                </select>

                            </td>


                            <?php
                            if (($user == 1) || ($user == "")) {
                                $TextUser = "Cliente";
                            }
                            if ($user == 1) {
                                $TextUser = "Proveedor";
                            }
                            if ($user == 1) {
                                $TextUser = "Sucursal";
                            }
                            ?>
                            <td class="LETRA" align="left">
                                <div id="TextUser"><?php echo $TextUser; ?></div>
                            </td>
                            <td colspan="2">
                                <div id="DivCliente" <?php if (($user == 2) || ($user == 3)) { ?>style="display:none" <?php } ?>>
                                    <select name="SCliente" id="SCliente">
                                        <option value="">Seleccione una Opción</option>
                                        <?php
                                        $sql = "SELECT codcli,descli FROM cliente order by descli";
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $codcli = $row["codcli"];
                                            $descli = $row["descli"];
                                        ?>
                                            <option value="<?php echo $codcli; ?>" <?php if ($SCliente == $codcli) { ?>selected="selected" <?php } ?>><?php echo $descli; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div id="DivProveedor" <?php if (($user == 1) || ($user == 3) || ($user == "")) { ?>style="display:none" <?php } ?>>
                                    <select name="SProveedor" id="SProveedor">
                                        <option value="">Seleccione una Opción</option>
                                        <?php
                                        $sql = "SELECT codpro,despro FROM proveedor order by despro";
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $codpro = $row["codpro"];
                                            $despro = $row["despro"];
                                        ?>
                                            <option value="<?php echo $codpro; ?>" <?php if ($SProveedor == $codpro) { ?>selected="selected" <?php } ?>><?php echo $despro; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div id="DivSucursal" <?php if (($user == 1) || ($user == 2) || ($user == "")) { ?>style="display:none" <?php } ?>>
                                    <select name="SSucursal" id="SSucursal">
                                        <option value="">Seleccione una Opción</option>
                                        <?php
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa where habil = 1 order by codloc";
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $codloc = $row["codloc"];
                                            $nomloc = $row["nomloc"];
                                            $nomloc2 = $row["nombre"];
                                        ?>
                                            <option value="<?php echo $codloc; ?>" <?php if ($SSucursal == $codloc) { ?>selected="selected" <?php } ?>><?php echo $nomloc2; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>


                            </td>
                            <td>&nbsp;</td>
                        </tr>




                        <tr bgcolor="#ececec">
                            <td class="LETRA">DOC. INICIAL </td>
                            <td><input class="sinborde" name="desc" type="text" id="desc" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc ?>" /></td>
                            <td class="LETRA">
                                <div align="left"> DOC. FINAL</div>
                            </td>
                            <td width="200"><input name="desc1" type="text" id="desc1" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc1 ?>" /> </td>
                            <td>
                                <input type="checkbox" name="ck" id="ck" value="1" <?php
                                                                                    if ($mov == 4) {
                                                                                    } else {
                                                                                    ?>disabled="disabled" <?php } ?><?php if (($mov == 4) and ($ck == 1)) { ?>checked="checked" <?php } ?> />
                                <label for="ck" class="LETRA"> Mostrar Detallado</label>

                                <label>


                            </td>
                            <td><input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar" />
                                <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir" /></td>
                        </tr>



                        <tr bgcolor="#ececec">
                            <td class="LETRA">FECHA INICIO</td>
                            <td><input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>" /></td>

                            <td class="LETRA">
                                <div align="left">FECHA FINAL</div>
                            </td>
                            <td colspan="2"><input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                                        if ($date2 == "") {
                                                                                                            echo $date;
                                                                                                        } else {
                                                                                                            echo $date2;
                                                                                                        }
                                                                                                        ?>" /></td>

                            <td><input name="vals" type="hidden" id="vals" value="2" />
                                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" /></td>
                        </tr>
                    </table>




                </form>
                <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if (($val == 1) || ($vals == 2)) {
        require_once("ing_salid2.php");
    ?>
        <!-- <iframe src="ing_salid2.php?val=<?php echo $val ?>&vals=<?php echo $vals ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&mov=<?php echo $mov ?>&user=<?php echo $user ?>&local=<?php echo $local ?>&ck=<?php echo $ck; ?>&SCliente=<?php echo $SCliente; ?>&SProveedor=<?php echo $SProveedor; ?>&SSucursal=<?php echo $SSucursal; ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
                                </iframe>-->
    <?php }
    ?>

    <div class="go-top-container" title="Vuelve al comienzo">
        <div class="go-top-button" title="Vuelve al comienzo">
            <a id="volver-arriba" href="#" title="Vuelve al comienzo" style="  cursor:pointer;">
                <i class="fas fa-chevron-up" title="Vuelve al comienzo">

                </i>
            </a>
        </div>
    </div>
    <script src="js/gotop.js"></script>
</body>

</html>
<script>
    $('#local').select2();
    $('#mov').select2();
    $('#user').select2();
    $('#SSucursal').select2();
    $('#SCliente').select2();
    $('#SProveedor').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>