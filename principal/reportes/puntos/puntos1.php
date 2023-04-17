<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="windows-1252">

            <title>Documento sin t&iacute;tulo</title>
            <link href="../../archivo/css/css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="../../../funciones/ajax.js"></script>
            <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>

            <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS?>
            <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS?>
            <?php require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
            <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
            <?php
            require_once("../../local.php"); //LOCAL DEL USUARIO
            $sql = "SELECT * FROM usuario where usecod = '$usuario'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $user = $row['nomusu'];
                }
            }
            $codclire = isset($_REQUEST['codclire']) ? ($_REQUEST['codclire']) : "";
            $val1 = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
            $val2 = isset($_REQUEST['val22']) ? ($_REQUEST['val22']) : "";
            $codcli = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
            $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
            $marca = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";

            $descli = "";
            $search = "";
            $val = "";
            if ($val1 == 1) {
                $sql = "SELECT descli FROM cliente where codcli = '$codcli'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $descli = $row['descli'];
                    }
                }
                $val = $val1;
                $search = $codcli;
            }

            if ($val2 == 2) {
                if ($codclire == "") {
                    $sql = "SELECT descli FROM cliente where codcli = '$codcli' ";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $descli = $row['descli'];
                        }
                    }
                } else {
                    $sql = "SELECT descli FROM cliente where codcli = '$codclire'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $descli = $row['descli'];
                        }
                    }
                }
                $val = $val2;
                $search = $codcli;
            }
            ?>
            <script>
                function salir()
                {
                    var f = document.form1;
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "../../index.php";
                    f.submit();
                }
                function buscar1()
                {
                    var f = document.form1;

                    if (f.country.value == "")
                    {
                        alert("Ingrese el Producto para iniciar la Busqueda");
                        f.country.focus();
                        return;
                    }

                    f.val22.value = 0;
                    f.submit();
                }
                function buscar2()
                {
                    var f = document.form1;
                    if (f.country.value == "")
                    {
                        alert("Ingrese el Producto para iniciar la Busqueda");
                        f.country.focus();
                        return;
                    }
                    f.val1.value = 0;
                    f.submit();
                }

                function ent(evt)
                {
                    var key = nav4 ? evt.which : evt.keyCode;
                    if (key == 13)
                    {
                        var f = document.form1;

                        if (f.country.value == "")
                        {
                            alert("Ingrese el Producto para iniciar la Busqueda");
                            f.country.focus();
                            return;
                        }
                        //f.val2.value=0;
                        f.submit();
                    }
                }
                function sf()
                {
                    document.form1.country.focus();
                }
            </script>
            <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
            <style>
                .tablarepor {

                    border: 1px solid black;
                    border-collapse: collapse;

                }
                .tablarepor tr{

                    background: #ececec;
                }
            </style>
    </head>
    <body onload="sf();">
        <table width="100%" border="0">
            <tr>
                <td width="835"><b><u>CANJE DE PUNTOS: </u></b> Se mostraran los Clientes con sus puntos correspondiente.</td>
            </tr>

        </table>
        <table width="100%" border="0">
            <tr>
                <td width="944">
                    <form id="form1" name="form1">
                        <table width="100%" border="0" class="tablarepor">
                            <tr>
                                <td width="58" class="LETRA">CLIENTE</td>
                                <td width="529">
                                    <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" size="100" onkeypress="return ent(event);" onclick="this.value = ''" value="<?php echo $descli ?>"/>
                                </td>

                                <td width="342">
                                    <div align="right">
                                        <input name="val22" type="hidden" id="val22" value="2"/>
                                        <input type="hidden" id="country_ID2" name="country_ID2" value="<?php echo $codcli ?>"/>
                                        <input name="search" type="button" id="search" value="Buscar Movimientos" onclick="buscar2()" class="buscar"/>
                                    </div>
                                </td>
                                <td width="342">
                                    <div align="right">
                                        <input name="val1" type="hidden" id="val1" value="1"/>
                                        <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codcli ?>"/>
                                        <input type="hidden" id="re" name="re" value="<?php echo $codclire ?>"/>
                                        <input name="search" type="button" id="search" value="Descontar" onclick="buscar1()" class="buscar"/>
                                        <input name="exit" type="button" id="exit" value="Salir"  onclick="salir()" class="salir"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                    
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <?php if ($codclire == "") { ?>
            <iframe src="puntos2.php?search=<?php echo $search ?>&&val=<?php echo $val ?>" name="marco" id="marco" width="100%" height="450"  frameborder="0" allowtransparency="0">
            </iframe>
        <?php } else { ?>
            <iframe src="puntos2.php?search=<?php echo $search ?>&&val=<?php echo $val ?>&&codclire=<?php echo $codclire ?>" name="marco" id="marco" width="100%" height="450"  frameborder="0" allowtransparency="0">
            </iframe>
        <?php } ?>

    </body>
</html>
