<?php include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../iconoNew.ico" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/select_pro.css" rel="stylesheet" type="text/css" />
    <link href="../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../funciones/alertify/alertify.min.js"></script>
    <?php
    require_once("funciones/mov_prod.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../local.php"); //LOCAL DEL USUARIO
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $sql = "SELECT drogueria,selva FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $drogueria = $row['drogueria'];
            $selva = $row['selva'];
        }
    }
    if ($drogueria == 1) {
        $lotenombre = "lote";
    } else {
        $lotenombre = "lotec";
    }
    $pag = isset($_REQUEST['pageno']) ? ($_REQUEST['pageno']) : "";
    $ultimo = isset($_REQUEST['ultimo']) ? ($_REQUEST['ultimo']) : "";
    if (isset($_REQUEST['pageno'])) {
        $pageno = $_REQUEST['pageno'];
    } else {
        $pageno = 1;
    }

    $sql1 = "SELECT utldmin FROM datagen_det"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $utldmin = $row1['utldmin'];
        }
    }
    $sql1 = "SELECT r_sanitario  FROM datagen"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $r_sanitario = $row1['r_sanitario'];
        }
    }
    $sql = "SELECT count(codpro) FROM producto  where eliminado ='0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numrows = $row[0];
        }
    }
    $busqueda = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
    $search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
    $word = isset($_REQUEST['word']) ? ($_REQUEST['word']) : "";
    if ($search == "") {
        $search = 0;
        $busqueda = "";
    }
    /////SELECCIONO EL ULTIMO CODIGO
    $sql = "SELECT codpro FROM producto     order by codpro desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $fincod = $row[0];
        }
    } else {
        $fincod = 0;
    }
    /////////////////////////////////
    $rows_per_page = 1;
    $lastpage = ceil($numrows / $rows_per_page);
    $pageno = (int) $pageno;
    if ($ultimo == 1) {
        $pageno = $lastpage;
    }
    if ($pageno > $lastpage) {
        $pageno = $lastpage;
    } // if
    if ($pageno < 1) {
        $pageno = 1;
    } // if
    $limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;
    if ($search == 1) {
        $sql = "SELECT codpro,desprod,codbar,factor,margene,stopro,moneda,prevta,imapro,detpro,cant1,cant2,cant3,desc1,desc2,desc3,activo,prelis,prevta,preuni,margene,costre,stopro,codmar,coduso,codfam,igv,incentivado,blister,$lotenombre as lote,codpres,activo1,costpr,utlcos,preblister,digemid,cod_generico,registrosanitario,covid,codcatp,activoPuntos,icbper,recetaMedica FROM producto where codpro = '$busqueda' and codpro <> 0 and eliminado = 0";
    } else {
        $sql = "SELECT codpro,desprod,codbar,factor,margene,stopro,moneda,prevta,imapro,detpro,cant1,cant2,cant3,desc1,desc2,desc3,activo,prelis,prevta,preuni,margene,costre,stopro,codmar,coduso,codfam,igv,incentivado,blister,$lotenombre as lote,codpres,activo1,costpr,utlcos,preblister,digemid,cod_generico,registrosanitario,covid,codcatp,activoPuntos,icbper,recetaMedica  FROM producto where codpro <> 0 and eliminado = 0 $limit";
    }


    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro             = $row["codpro"];
            $desprod            = $row["desprod"];
            $codbar             = $row["codbar"];
            $factor             = $row["factor"];
            $stopro             = $row["stopro"];
            $moneda             = $row["moneda"];
            $imapro             = $row["imapro"];
            $detpro             = $row["detpro"];
            $cant1              = $row["cant1"];
            $cant2              = $row["cant2"];
            $cant3              = $row["cant3"];
            $desc1              = $row["desc1"];
            $desc2              = $row["desc2"];
            $desc3              = $row["desc3"];
            $activo             = $row["activo"];   ///0=desactivo-----1=activo
            $codmar             = $row["codmar"];
            $coduso             = $row["coduso"];
            $codfam             = $row["codfam"];
            $igv                = $row["igv"];
            $inc                = $row["incentivado"];
            $lotec              = $row["lote"];
            $codpres            = $row["codpres"];
            $codcatp            = $row["codcatp"];
            $activo1            = $row["activo1"];
            $digemid            = $row["digemid"];
            $cod_generico       = $row["cod_generico"];
            $registrosanitario  = $row["registrosanitario"];
            $covid              = $row["covid"];
            $activoPuntos       = $row["activoPuntos"];
            $icbper             = $row["icbper"];
            $recetaMedica       = $row["recetaMedica"];


            if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                $margene        = $row["margene"];
                $prevta         = $row["prevta"];
                $prelis         = $row["prelis"];
                $preuni         = $row["preuni"];
                $costre         = $row["costre"];
                $blister        = $row["blister"];
                $costpr         = $row["costpr"];
                $utlcos         = $row["utlcos"];
                // $margeneuni     = $row["margeneuni"];
                $preblister     = $row["preblister"];
            } elseif ($precios_por_local == 0) {

                $margene        = $row["margene"];
                $prevta         = $row["prevta"];
                $prelis         = $row["prelis"];
                $preuni         = $row["preuni"];
                $costre         = $row["costre"];
                $blister        = $row["blister"];
                $costpr         = $row["costpr"];
                $utlcos         = $row["utlcos"];
                // $margeneuni     = $row["margeneuni"];
                $preblister     = $row["preblister"];
            }

            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                $sql_precio = "SELECT $margene_p,$prevta_p,$prelis_p,$preuni_p,$costre_p,$blister_p,$costpr_p,$utlcos_p,$preblister_p FROM precios_por_local where codpro = '$codpro'";
                $result_precio = mysqli_query($conexion, $sql_precio);
                if (mysqli_num_rows($result_precio)) {
                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                        $margene        = $row_precio[0];
                        $prevta         = $row_precio[1];
                        $prelis         = $row_precio[2];
                        $preuni         = $row_precio[3];
                        $costre         = $row_precio[4];
                        $blister        = $row_precio[5];
                        $costpr         = $row_precio[6];
                        $utlcos         = $row_precio[7];
                        $preblister     = $row_precio[8];
                    }
                }
            }

            if ($factor == 0) {
                $factor = 1;
            }
            if ($costre <> 0) {

                $margenecaja = round(($prevta / $costre) * 100, 2) - 100;
                // $margeneuni = round($preuni / ($costre / $factor) * 100, 2) - 100;
                if ($blister > 0) {
                    $margenblister = (($preblister * $factor) / ($costre) - 1) * 100;
                }
            } else {
                $margenecaja = '0.00';
                // $margeneuni = '0.00';
                $margenblister = '0.00';
            }
            if ($factor > 1) {
                $convert1 = $stopro / $factor;
                $caja = ((int) ($convert1));
                $unidad = ($stopro - ($caja * $factor));
                $stocknuevo = "C" . $caja . " + F" . $unidad;
                $CantidadFactor = $stocknuevo;
            } else {
                $convert1 = $stopro / $factor;
                $caja = ((int) ($convert1));

                $stocknuevo = $caja . "C ";
                $CantidadFactor = $stocknuevo;
            }


            //echo $stopro."-".$factor;
        }
    } else {
        $codpro = 1;
        $CantidadFactor = 0;
    }
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <link rel="STYLESHEET" type="text/css" href="../../funciones/codebase/dhtmlxcombo.css">
    <script>
        window.dhx_globalImgPath = "../../funciones/codebase/imgs/";
    </script>
    <script src="../../funciones/codebase/dhtmlxcommon.js"></script>
    <script src="../../funciones/control.js"></script>
    <script src="../../funciones/codebase/dhtmlxcombo.js"></script>
    <!-- <script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js"></script> -->
    <!--<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>-->
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>
    <link href="../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../funciones/alertify/alertify.min.js"></script>
    <script>
        function openPopup(url) {
            myPopup = window.open(url, 'popupWindow', 'width=460,height=28,top=300,left=550');
            if (!myPopup.opener)
                myPopup.opener = window;
        }

        function copyForm1() {
            var f = myPopup.document.popupForm.myTextField.value;
            if (f == "") {
                alert("DEBE INGRESAR UNA DESCRIPCION");
                myPopup.document.popupForm.myTextField.focus();
                return;
            } else {
                var i = document.forms[0].marca.length;
                var myNewOption = new
                Option(myPopup.document.forms[0].myTextField.value, myPopup.document.forms[0].myTextField.value);
                document.forms[0].marca.options[i] = myNewOption;
                document.forms[0].marca.selectedIndex = i;
                myPopup.window.close();
                return false;
            }
        }

        function copyForm2() {
            var f = myPopup.document.popupForm.myTextField.value;
            if (f == "") {
                alert("DEBE INGRESAR UNA DESCRIPCION");
                myPopup.document.popupForm.myTextField.focus();
                return;
            } else {
                var i = document.forms[0].line.length;
                var myNewOption = new
                Option(myPopup.document.forms[0].myTextField.value, myPopup.document.forms[0].myTextField.value);
                document.forms[0].line.options[i] = myNewOption;
                document.forms[0].line.selectedIndex = i;
                myPopup.window.close();
                return false;
            }
        }

        function copyForm3() {
            var f = myPopup.document.popupForm.myTextField.value;
            if (f == "") {
                alert("DEBE INGRESAR UNA DESCRIPCION");
                myPopup.document.popupForm.myTextField.focus();
                return;
            } else {
                var i = document.forms[0].clase.length;
                var myNewOption = new
                Option(myPopup.document.forms[0].myTextField.value, myPopup.document.forms[0].myTextField.value);
                document.forms[0].clase.options[i] = myNewOption;
                document.forms[0].clase.selectedIndex = i;
                myPopup.window.close();
                return false;
            }
        }

        function copyForm4() {
            var f = myPopup.document.popupForm.myTextField.value;
            if (f == "") {
                alert("DEBE INGRESAR UNA DESCRIPCION");
                myPopup.document.popupForm.myTextField.focus();
                return;
            } else {
                var i = document.forms[0].present.length;
                var myNewOption = new
                Option(myPopup.document.forms[0].myTextField.value, myPopup.document.forms[0].myTextField.value);
                document.forms[0].present.options[i] = myNewOption;
                document.forms[0].present.selectedIndex = i;
                myPopup.window.close();
                return false;
            }
        }

        function copyForm5() {
            var f = myPopup.document.popupForm.myTextField.value;
            if (f == "") {
                alert("DEBE INGRESAR UNA DESCRIPCION");
                myPopup.document.popupForm.myTextField.focus();
                return;
            } else {
                var i = document.forms[0].categoria.length;
                var myNewOption = new
                Option(myPopup.document.forms[0].myTextField.value, myPopup.document.forms[0].myTextField.value);
                document.forms[0].categoria.options[i] = myNewOption;
                document.forms[0].categoria.selectedIndex = i;
                myPopup.window.close();
                return false;
            }
        }
    </script>
    <style>
        .pasos {
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
            color: red;
        }
    </style>
</head>

<body onLoad="sf();" onkeydown="ctrls(event)" onkeyup="prods(event)" onkeypress="return pulsar(event)">
    <?php

    function formato($c)
    {
        printf("%09d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }
    ?>
    <div class="tabla1" style="height: auto;margin-bottom: 12px;">
        <script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script>
        <div class="title" height="50">

            <table width="100%" border="0">
                <tr>

                    <td align="left">
                        <span class="titulos">
                            Mantenimiento de Producto
                            <b>
                                <?php
                                $up = isset($_REQUEST['up']) ? ($_REQUEST['up']) : "";
                                $del = isset($_REQUEST['del']) ? ($_REQUEST['del']) : "";
                                $error = isset($_REQUEST['error']) ? ($_REQUEST['error']) : "";
                                $ok = isset($_REQUEST['ok']) ? ($_REQUEST['ok']) : "";

                                if ($error == 1) {
                                    $descripcion_error = 'YA EXISTE UN PRODUCTO CON EL MISMO CODIGO DE BARRAS REGISTRADO';
                                } elseif ($error == 2) {
                                    $descripcion_error = 'YA EXISTE UN PRODUCTO CON EL MISMO NOMBRE Y MARCA REGISTRADO';
                                } elseif ($error == 3) {
                                    $descripcion_error = 'EL FACTOR NO PUEDE SER CAMBIADO, AUN CUANTA CON STOCK DISPONIBLE EN EL PRODUCTO';
                                } elseif ($error == 4) {
                                    $descripcion_error = 'YA HAY UN PRODUCTO CON EL MISMO CODIGO DE BARRAS REGISTRADO NO PUEDE SER ACTUALIZADO ';
                                } elseif ($error == 5) {
                                    $descripcion_error = 'YA HAY UN PRODUCTO IGUAL REGISTRADO NO PUEDE SER ACTUALIZADO ';
                                } elseif ($error == 6) {
                                    $descripcion_error = 'NO SE PUEDE ELIMINAR EL PRODUCTO PORQUE TIENE STOCK DISPONIBLE';
                                }

                                if ($ok == 1) {
                                    $descripcion_ok = 'SE LOGRO GRABAR EXITOSAMENTE LOS DATOS.';
                                } elseif ($ok == 2) {
                                    $descripcion_ok = 'SE LOGRO ACTUALIZAR EXITOSAMENTE LOS DATOS.';
                                } elseif ($ok == 3) {
                                    $descripcion_ok = 'SE LOGRO ACTUALIZAR EXITOSAMENTE LOS DATOS DEL PRODUCTO';
                                }
                                if ($del == 1) {
                                    $descripcion_del = 'SE LOGRO ELIMINAR EL PRODUCTO INDICADO';
                                }


                                if (($error <> '') || ($error <> 0)) {
                                ?>
                                    <script>
                                        alertify.error("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo $descripcion_error; ?></p>");
                                    </script>
                                <?php
                                }
                                if (($ok <> '') || ($ok <> 0)) {
                                ?>
                                    <script>
                                        alertify.success("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo $descripcion_ok; ?></p>");
                                    </script>
                                <?php
                                }

                                if (($del <> '') || ($del <> 0)) {
                                ?>
                                    <script>
                                        alertify.success("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo  $descripcion_del; ?></p>");
                                    </script>
                                <?php
                                }
                                ?>
                            </b>
                        </span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
            </table>
        </div>
        <div class="mask1" style="height: auto;margin-bottom: 12px;">
            <div class="mask2" style="height: auto;margin-bottom: 12px;">
                <div class="mask3" style="height: auto;margin-bottom: 12px;">
                    <?php require('mov_prod1.php'); ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
<script>
    $('#marca').select2();
    $('#line').select2();
    $('#clase').select2();
    $('#present').select2();
    $('#categoria').select2();

    $('#moneda').select2({
        minimumResultsForSearch: -1
    });
    $('#rd1').select2({
        minimumResultsForSearch: -1
    });
    $('#rd').select2({
        minimumResultsForSearch: -1
    });

    function validarCodigodebarras(codbar, codnuevo) {
        var url = 'validar_codigo_barras.php';
        var parametros = 'codbar=' + codbar.value + '&codnuevo=' + codnuevo.value;
        var ajax = new Ajax.Updater('comprobado_codigo_barra', url, {
            method: 'get',
            parameters: parametros
        });
    }
</script>
<!--<script type="text/javascript" src="prototype.js"></script>-->