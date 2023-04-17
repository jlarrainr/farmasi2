<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />

    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php
    require_once("../../../funciones/functions.php");    //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>
    <?php
    require_once("../../local.php"); //LOCAL DEL USUARIO
    $sqlP = "SELECT precios_por_local FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
        }
    }
    $sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
            $codloc = $row['codloc'];
        }
    }
    //**CONFIGPRECIOS_PRODUCTO**//
    $nombre_xcompa = "";
    $sqlLocal = "SELECT nombre FROM xcompa where habil = '1' and codloc = '$codloc'";
    $resultLocal = mysqli_query($conexion, $sqlLocal);
    if (mysqli_num_rows($resultLocal)) {
        while ($rowLocal = mysqli_fetch_array($resultLocal)) {
            $nombre_xcompa = $rowLocal['nombre'];
        }
    }

    if ($precios_por_local == 1) {
        $texto_1 = 'El precio de compra y venta se cambiara unicamente para el local ' . $nombre_xcompa;
        $texto_2 = 'PRECIOS DE PRODUCTOS POR CADA ESTABLECIMIENTO';
    } else {
        $texto_1 = 'El precio de venta se cambiara para todos los establecimientos.';
        $texto_2 = 'PRECIOS DE PRODUCTOS PARA TODOS LOS LOCALES';
    }
    $val1 = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
    $val2 = isset($_REQUEST['val2']) ? ($_REQUEST['val2']) : "";
    // $val3 = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
    $ckM = isset($_REQUEST['ckM']) ? ($_REQUEST['ckM']) : "";
    $produc = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
    $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
    $marca = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
    if ($val1 == 1) {
        $sql = "SELECT desprod FROM producto where desprod like '$produc%' and eliminado='0'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $desprod = $row['desprod'];
            }
        }
        $val = $val1;
        $search = $produc;
    }
    if ($val2 == 2) {
        $sql = "SELECT destab FROM titultabladet where codtab = '$marca1'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $destab = $row['destab'];
            }
        }
        $val = $val2;
        $search = $marca;
    }
    // if ($val3 == 3) {
    //     $sql = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$local1'";
    //     $result = mysqli_query($conexion, $sql);
    //     if (mysqli_num_rows($result)) {
    //         while ($row = mysqli_fetch_array($result)) {
    //             $nomloc = $row['nomloc'];
    //         }
    //     }
    //     $val = $val3;
    //     $search = $local;
    // }
    ?>
    <!-- <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script> -->
    <script>
        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function buscar() {
            var f = document.form1;
            mostrar =f.ckM.value
            if(mostrar == 0){
                if (f.country.value == "") {
                alert("Ingrese el Producto para iniciar la Busqueda");
                f.country.focus();
                return;
            }
            }
            
            // f.val3.value = 0;
            f.val2.value = 0;
            f.submit();
        }

        function lp1() {
            var f = document.form1;
            f.val1.value = 0;
            // f.val3.value = 0;
            f.submit();
        }

        function lp2() {
            var f = document.form1;
            f.val1.value = 0;
            f.val2.value = 0;
            f.submit();
        }

        function sf() {
            document.form1.country.focus();
        }
        var nav4 = window.Event ? true : false;

        function ent(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                var f = document.form1;
                if (f.country.value == "") {
                    alert("Ingrese el Producto para iniciar la Busqueda");
                    f.country.focus();
                    return;
                }
                // f.val3.value = 0;
                f.val2.value = 0;
                f.submit();
            }
        }
    </script>
    <style>
        table {
            width: 100%;
        }

        img {
            width: 100%;
        }

        iframe {
            width: 100%;
        }

        .tablarepor {

            border: 1px solid black;
            border-collapse: collapse;


        }

        .tablarepor tr {

            background: #ececec;
        }
    </style>
</head>

<body <?php ?>onload="sf();" <?php ?>>

    <table border="0">
        <tr>
            <td width="100%">
                <form id="form1" name="form1">
                    <table border="0" class="tablarepor">
                        <tr>
                            <td colspan='4'><b><u><?php echo $texto_2; ?> </u></b>: <a style="color:red;font-size:12px;"><strong><?php echo $texto_1; ?></strong> </a></td>

                        </tr>
                        <tr>
                            <td colspan='4'> Elija solo una de las opciones a buscar: </td>

                        </tr>
                        <tr>
                            <td width="20%" class="LETRA">Nombre del producto</td>
                            <td width="55%">
                                <input name="country" type="text" id="country" size="100" value="<?php echo $produc ?>" onkeypress="return ent(event);" onKeyUp="this.value = this.value.toUpperCase();" />
                            </td>
                            <td>
                                <input name="ckM" type="checkbox" id="ckM" value="1"  <?php if ($ckM == 1) { ?>checked="checked" <?php } ?> />
                                <label for="ckM" class="LETRA"> Mostrar  </label>
                            </td>
                            <td width="25%">
                                <div align="right">
                                    <input name="val1" type="hidden" id="val1" value="1" />
                                    <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codpro ?>" />
                                    <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar" />
                                    <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="LETRA">Todos los productos de Laboratorio/marca: </td>
                            <td colspan='2'>
                                <select name="marca" id="marca" style='width:30%;'> 
                                 <option value="all" <?php if ($marca == 'all') { ?>selected="selected" <?php } ?>> TODOS LOS LABORATORIOS</option>

                                    <?php
                                    $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M'";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row["codtab"] ?>" <?php if ($marca == $row["codtab"]) { ?>selected="selected" <?php } ?>><?php echo $row["destab"] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <div align="right">
                                    <input name="val2" type="hidden" id="val2" value="2" />
                                    <input name="search222" type="submit" id="search222" value="Buscar" class="buscar" onclick="lp1()" />
                                    <input name="exit222" type="button" id="exit222" value="Salir" onclick="salir()" class="salir" />
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="LETRA">Solo mostrar los productos con stock de:</td>
                            <td>
                                <select name="local" id="local" style='width:30%;' disabled>
                                    <?php
                                    $sqlx = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1' and codloc = '$codloc'";
                                    $resultx = mysqli_query($conexion, $sqlx);
                                    while ($row = mysqli_fetch_array($resultx)) {
                                        $loc = $row["codloc"];
                                        $nloc = $row["nomloc"];
                                        $nombre = $row["nombre"];
                                        if ($nombre == '') {
                                            $locals = $nloc;
                                        } else {
                                            $locals = $nombre;
                                        }
                                    ?>
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($local == $row["codloc"]) { ?>selected="selected" <?php } ?>><?php echo $locals; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <div align="right">
                                    <input name="val3" type="hidden" id="val3" value="3" />
                                    <input name="search22" type="submit" id="search22" value="Buscar" class="buscar" onclick="lp2()" />
                                    <input name="exit22" type="button" id="exit22" value="Salir" onclick="salir()" class="salir" />
                                </div>
                            </td>
                        </tr> -->
                    </table>
                </form>
            </td>
        </tr>
    </table>
    <iframe src="precios2.php?search=<?php echo str_replace("&","@",$search) ?>&val=<?php echo $val ?>&ckM=<?php echo $ckM ?>" name="marco" id="marco" height="450" scrolling="Automatic" frameborder="0" allowtransparency="0">
    </iframe>
</body>

</html>
<script>
    $('#marca').select2();
</script>