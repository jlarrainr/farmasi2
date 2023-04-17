<?php
include('../../session_user.php');
//error_log("En Ingresos Varios 2");
$invnum = isset($_SESSION['ingresos_val']) ? $_SESSION['ingresos_val'] : 0;
//error_log("Session 1: ".$_SESSION['ingresos_val']);
//error_log("invnum ".$invnum);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS.
    require_once('../../../titulo_sist.php');
    require_once("functions.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../funciones/ingresovarios.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../convertfecha.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES

    $sqlP = "SELECT precios_por_local FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
        }
    }
    if ($precios_por_local  == 1) {
        require_once '../../../precios_por_local.php';
    }
    ?>
    <script>
        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                document.form1.method = "post";
                document.form1.submit();
            }
        }

        function mensaje() {
            alert("El producto no puede ser seleccionado no cuenta con costo de Reposicion");
        }
        var statSend = false;
        var nav4 = window.Event ? true : false;

        function eventoIngresoVarios(evt, valor) {
            var valor;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (!statSend) {
                    var f = document.form1;
                    var v1 = parseFloat(document.form1.text1.value);
                    var lotec = parseFloat(document.form1.lotec.value);
                    if ((v1 == 0) || (v1 == '')) {
                        alert('Debe ingresar un valor diferente a 0');
                        document.form1.text1.focus();
                        return;
                    }
                    if (f.text1.value == "") {
                        alert("Debe ingresar una cantidad" + lotec);
                        f.text1.focus();
                        return;
                    }
                    if (document.form1.lotec.value == 1) {
                        if (f.textlote.value == "") {
                            alert("Ingrese el Numero de Lote");
                            f.textlote.focus();
                            return;
                        }
                        if (f.mesL.value == "") {
                            alert("Ingrese el Mes");
                            f.mesL.focus();
                            return;
                        }
                        if (f.yearsL.value == "") {
                            alert("Ingrese el A�o");
                            f.yearsL.focus();
                            return;
                        }
                        var cadena = f.yearsL.value;
                        var cadena_mes = f.mesL.value;
                        var longitud = cadena.length;
                        if (f.mesL.value > 12) {
                            alert("Ingrese un Mes valido");
                            f.mesL.focus();
                            return;
                        }
                        if (longitud < 4) {
                            alert("Ingrese un Año valido1");
                            f.yearsL.focus();
                            return;
                        }
                        var fecha = new Date();
                        var ano = fecha.getFullYear();
                        var mess = fecha.getMonth() + 1;
                        cadena = parseInt(f.yearsL.value);
                        var res = f.mesL.value.substring(0, 1);
                        if (res == 0) {
                            var cadena_mes2 = parseInt(document.form1.mesL.value, 10);
                        } else {
                            cadena_mes2 = parseInt(f.mesL.value);
                        }
                        ano = parseInt(ano);
                        mess = parseInt(mess);
                        if (ano > cadena) {
                            alert("Ingrese un Año posterior al Año Actual");
                            f.years.focus();
                            return;
                        } else {
                            if (ano == cadena) {
                                if (cadena_mes2 <= mess) {
                                    alert("Ingrese un Mes posterior ");
                                    f.mesL.focus();
                                    return;
                                }
                            }
                        }
                    }
                    f.method = "post";
                    f.action = "ingresos_varios2_reg.php";
                    f.target = "comp_principal";
                    f.submit();

                    statSend = true;
                    return true;
                } else {
                    alert("El proceso esta siendo cargado espere un momento...");
                    return false;
                }
            }
            if (valor == 1) {
                // valor = 1 // para enteros con unidades(factor>1)
                return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
            } else if (valor == 4) {
                // valor = 1 // para enteros sin unidades(factor=1)
                return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
            } else if (valor == 2) {
                // valor = 2 // para decimales
                return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
            } else if (valor == 3) {
                // valor = 3 // para alfanumericos
                return !(key > 31 && (key < 48 || key > 90) && (key < 97 || key > 122));
            }
        }

        function caj1() {
            document.form1.text1.focus();
        }

        function compras1(e) {
            tecla = e.keyCode;
            var f = document.form1;
            var a = f.carcount.value;
            var b = f.carcount1.value;
            if (tecla == 119) {
                if ((a == 0) || (b > 0)) {
                    alert('No se puede grabar este Documento');
                } else {
                    var f = document.form1;
                    //			  if (f.referencia.value == "")
                    //			  { alert("Ingrese una referencia"); f.referencia.focus(); return; }
                    if (f.mont2.value == "") {
                        alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                        f.mont2.focus();
                        return;
                    }
                    if (confirm("ÃÂ¯ÃÂ¿ÃÂ½Desea Grabar esta informacion?")) {
                        //			  alert("EL NUMERO REGISTRADO ES "+<?php echo $numdoc ?>);
                        f.method = "POST";
                        f.target = "_top";
                        f.action = "ingresos_varios1_reg.php";
                        f.submit();
                    }
                }
            }
            if (tecla == 27) {
                // document.form1.method = "post";
                document.form1.submit();
            }
            if (tecla == 120) {
                if ((a == 0) || (b > 0)) {
                    alert('No se puede realizar la impresiÃÂ¯ÃÂ¿ÃÂ½n de este Documento');
                } else {
                    if (window.print)
                        window.print()
                    else
                        alert("Disculpe, su navegador no soporta esta opciÃÂ¯ÃÂ¿ÃÂ½n.");
                }
            }

        }
    </script>
    <style>
        a:link,
        a:visited {
            color: #0066CC;
            border: 0px solid #e7e7e7;
        }

        a:hover {
            background: #fff;
            border: 0px solid #ccc;
        }

        a:focus {
            background-color: #FFFF66;
            /*color de fondo de descripcion de los productos al pasar con las flechas del teclado */
            color: #0066CC;
            padding: 1px 2px 2px 0px;


        }

        a:active {
            background-color: #FFFF66;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        #country {
            width: 70%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: white;
            background-image: url('../compras/buscador.png');
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 5px 15px 3px 35px;
        }
    </style>
</head>
<?php
///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA
$sqlTMM = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
$resultTMM = mysqli_query($conexion, $sqlTMM);
if (mysqli_num_rows($resultTMM)) {
    while ($row = mysqli_fetch_array($resultTMM)) {
        $count = $row[0]; ////CANTIDAD DE REGISTROS EN EL GRID
    }
} else {
    $count = 0; ////CUANDO NO HAY NADA EN EL GRID
}

$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc = $row1['codloc'];
    }
}
//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tablad = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);





///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
$sqlTMM2 = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro = '0' and qtyprf = ''";
$resultTMM2 = mysqli_query($conexion, $sqlTMM2);
if (mysqli_num_rows($resultTMM2)) {
    while ($row = mysqli_fetch_array($resultTMM2)) {
        $count1 = $row[0]; ////CUANDO HAY UN GRID PERO CON DATOS VACIOS
    }
} else {
    $count1 = 0; ////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
}


$sqlUsu = "SELECT codloc FROM usuario where usecod = '$usuario'";
$resultUsu = mysqli_query($conexion, $sqlUsu);
if (mysqli_num_rows($resultUsu)) {
    while ($row = mysqli_fetch_array($resultUsu)) {
        $codloc = $row['codloc'];
    }
}

$sqlXC = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$resultXC = mysqli_query($conexion, $sqlXC);
if (mysqli_num_rows($resultXC)) {
    while ($row = mysqli_fetch_array($resultXC)) {
        $nomloc = $row['nomloc'];
    }
}

$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$Desprod = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";



if ($val == 2) {
    $producto = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
    if ($producto <> "") {
        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$producto' and invnum = '$invnum'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            $search = 0;
        } else {
            $search = 1;
        }
    } else {
        $search = 0;
    }
} else {
    $search = 0;
}
$sql = "SELECT drogueria FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $drogueria = $row['drogueria'];
    }
}
if ($drogueria == 1) {
    $lotenombre = "lote";
} else {
    $lotenombre = "lotec";
}
require_once('../tabla_local.php');
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
$cprod = isset($_REQUEST['cprod']) ? ($_REQUEST['cprod']) : "";
$valcprod = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
?>


<body onload="  <?php if ($valcprod == 0) { ?> sf();<?php } else {
                                                    if ($valform == 1) {
                                                    ?> caj1();<?php } else {
                                                                if ($search == 1) {
                                                                ?>links();<?php } else { ?>getfocus();<?php
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                                        ?>" onkeyup="compras1(event)">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="192">
                    <input name="country" type="text" id="country" onkeypress="enteres1(event)" onKeyUp="this.value = this.value.toUpperCase();" value="" size="120" placeholder="Buscar Producto....." />
                    <input name="val" type="hidden" id="val" value="1" />
                    <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                    <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                </td>
            </tr>
        </table>
        <?php
        if ($val == 1) {
            if ($Desprod <> "") {
                $EsCodigoProducto = is_numeric($Desprod);


                $healthy=array("ñ","Ñ");
    $yummy =array("&ntilde;","&Ntilde;" );


    $limpiacadena = str_replace($healthy, $yummy, $Desprod);
                if ($EsCodigoProducto == 0) {
                    $sqlSProd = "SELECT codpro,desprod,codmar,factor,igv,pcostouni,$lotenombre as lote ,costre,$tablad as local,codpro FROM producto where activo1 = '1' and eliminado='0' and (desprod LIKE '$limpiacadena%')   order by desprod" or die(mysqli_error());
                } else {
                    $sqlSProd = "SELECT codpro,desprod,codmar,factor,igv,pcostouni,$lotenombre as lote,costre,$tablad as local,codpro FROM producto where activo1 = '1' and eliminado='0' and ((codpro = '$limpiacadena') || (codbar = '$limpiacadena'))  order by desprod" or die(mysqli_error());
                }

                $resultSProd = mysqli_query($conexion, $sqlSProd);
                if (mysqli_num_rows($resultSProd)) {
        ?>
                    <table width="100%" id="customers" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="5">Código</th>
                            <th width="160">Producto</th>
                            <th width="120">Laboratorio</th>
                            <th width="70">Factor</th>
                            <th width="100">Costo Reposición</th>
                            <th width="70">Stock</th>

                        </tr>
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($resultSProd)) {
                            $i++;
                            $destab = "";
                            $codpro = $row['codpro'];
                            $desprod = $row['desprod'];
                            $marca = $row['codmar'];
                            $lote = $row['lote'];
                            $factor = $row['factor'];
                            $local = $row['local'];
                            $codpro = $row['codpro'];





                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $costre = $row['costre'];
                            } elseif ($precios_por_local == 0) {
                                $costre = $row['costre'];
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $costre_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costre = $row_precio[0];
                                    }
                                }
                            }

                            $sqlMARC = "SELECT destab FROM titultabladet where codtab = '$marca'";
                            $resultMARC = mysqli_query($conexion, $sqlMARC);
                            if (mysqli_num_rows($resultMARC)) {
                                while ($row1 = mysqli_fetch_array($resultMARC)) {
                                    $destab = $row1['destab'];
                                }
                            }
                            if ($i % 2 == 0) {
                                $color = "#CCE2FB";
                            } else {
                                $color = "#Ffffff";
                            }
                        ?>
                            <tr>

                                <td><?php echo $codpro; ?></td>
                                <td>
                                    <a id="l<?php echo $i ?>" <?php if (($costre <= 0)) { ?> href="#" onclick="mensaje();" <?php } else { ?> href="ingresos_varios2.php?country_ID=<?php echo $codpro ?>&ok=<?php echo $ok; ?>&val=2&valform=1&cprod=<?php echo $codpro ?>&ckigv=<?php echo $ckigv; ?>" <?php } ?> class="<?php echo $color ?>"><?php echo $desprod; ?></a>
                                </td>
                                <td><?php echo $destab ?></td>
                                <td align="center"><?php echo $factor ?></td>
                                <td align="center"><?php echo $costre ?></td>
                                <td>
                                    <div align="right"><?php echo stockcaja($local, $factor); ?></div>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                <?php
                }
            }
        }
        if ($val == 2) {
            $i = 0;
            $producto = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";


            $sqlP = "SELECT $lotenombre as lote FROM producto where activo1 = '1' and codpro = '$producto'";
            $resultP = mysqli_query($conexion, $sqlP);
            if (mysqli_num_rows($resultP)) {
                while ($row = mysqli_fetch_array($resultP)) {
                    $lote = $row['lote'];
                }
            }



            $sql = "SELECT codpro,desprod,codmar,$tabla,$lotenombre as lote,costre FROM producto where activo1 = '1' and codpro = '$producto' order by desprod";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                ?>

                <table id="customers" cellpadding="0" cellspacing="0">
                    <tr>
                        <th width="32">N&ordm;</th>
                        <th width="379">DESCRIPCION</th>
                        <th width="120">
                            <div align="left">LABORATORIO / MARCA</div>
                        </th>
                        <th width="119">
                            <div align="center">FACTOR</div>
                        </th>
                        <th width="72">
                            <div align="CENTER">CANT</div>
                        </th>
                        <?php if ($lote == 1) { ?>
                            <th width="72">
                                <div align="right">N&ordm; LOTE</div>
                            </th>
                            <th width="112">
                                <div align="center">VENCIMIENTO</div>
                            </th>

                        <?php } ?>
                        <th width="68">
                            <div align="right">COSTO REPOSICIÓN</div>
                        </th>
                        <th width="76">
                            <div align="CENTER">STOCK ACTUAL </div>
                        </th>
                        <th width="76">
                            <div align="right">SUB TOTAL</div>
                        </th>
                        <th width="17">&nbsp;</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $i++;
                        $codpro = $row['codpro'];  //codgio
                        $desprod = $row['desprod'];
                        $codmar = $row['codmar'];
                        $cant_loc = $row[3];
                        $lote = $row['lote'];


                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                            $costre = $row['costre'];
                        } elseif ($precios_por_local == 0) {
                            $costre = $row['costre'];
                        }

                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                            $sql_precio = "SELECT $costre_p FROM precios_por_local where codpro = '$codpro'";
                            $result_precio = mysqli_query($conexion, $sql_precio);
                            if (mysqli_num_rows($result_precio)) {
                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                    $costre = $row_precio[0];
                                }
                            }
                        }
                        $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $ltdgen = $row1['ltdgen'];
                            }
                        }
                        $sql1 = "SELECT codpro,desprod,codmar,factor,costpr,stopro,$tabla,pcostouni FROM producto where codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                //echo $sql1;
                                $codpro = $row1['codpro'];
                                $desprod = $row1['desprod'];
                                $codmar = $row1['codmar'];
                                $factor = $row1['factor'];
                                $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                                $cant_loc = $row1[6];
                                //                                    $costpr = $row1['pcostouni'];
                                if ($factor == 1) {
                                    $comparativa = 4;
                                } else {
                                    $comparativa = 1;
                                }
                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                    $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                } elseif ($precios_por_local == 0) {
                                    $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                }

                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $costpr_p FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $costpr = $row_precio[0];  ///COSTO PROMEDIO

                                        }
                                    }
                                }
                            }
                        }
                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $marca = $row1['destab'];
                            }
                        }

                        $sql1 = "SELECT numlote,vencim FROM movlote WHERE codpro='$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $numlote = $row1['numlote'];
                                $vencim = $row1['vencim'];
                            }
                        }


                        $sql1 = "SELECT qtypro,qtyprf,prisal FROM tempmovmov where invnum = '$invnum' and codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $qtypro1 = $row1['qtypro'];
                                $qtyprf1 = $row1['qtyprf'];
                                $prisal1 = $row1['prisal'];
                            }
                        }
                        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$codpro' and invnum = '$invnum'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $control = 1;
                        } else {
                            $control = 0;
                        }


                        $ycar = substr($vencim, -4);
                        $m = substr($vencim, 0, -5);
                    ?>
                        <tr>
                            <td><?php echo $codpro; ?></td>
                            <td title="<?php echo "el factos es" . $factor; ?>">
                                <?php if ($control == 0) {
                                ?>
                                    <a id="l1" href="ingresos_varios2.php?country_ID=<?php echo $producto ?>&valform=1&val=<?php echo $val ?>&cprod=<?php echo $codpro ?>"><?php echo $desprod ?>
                                    </a>
                                <?php
                                } else {
                                    echo $desprod;
                                }
                                ?>
                            </td>
                            <td><?php echo $marca ?></td>
                            <td align="CENTER"><?php echo $factor ?></td>
                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input name="text1" type="text" id="text1" size="4" onkeypress="return eventoIngresoVarios(event,<?php echo $comparativa ?>)" value="" onKeyUp="precio();" />
                                        <input name="number" type="hidden" id="number" />
                                        <input name="factor2" type="hidden" id="factor2" value="<?php echo $factor ?>" />
                                        <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                        <input type="hidden" name="costpr2" value="<?php echo $costpr; ?>" />
                                        <input name="text3P" type="hidden" id="text3P" />
                                        <input name="text2P" type="hidden" id="text2P" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $codpro; ?>" />
                                        <input name="costre" type="hidden" id="costre" value="<?php echo $costre; ?>" />
                                        <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                        <input name="ok" type="hidden" id="ok" value="<?php echo $ok; ?>" />
                                        <input name="locall" type="hidden" id="locall" value="<?php echo $codloc ?>" />
                                        <input name="usu" type="hidden" id="usu" value="<?php echo $usuario ?>" />
                                        <input name="lotec" type="hidden" id="lotec" value="<?php echo $lote ?>" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>

                            <?php if ($lote == 1) { ?>
                                <td>
                                    <div align="right">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="textlote" type="text" id="textlote" value="" size="4" onkeypress="return eventoIngresoVarios(event, 3)" />
                                            <input name="locall" type="hidden" id="locall" value="<?php echo $codloc; ?>" />
                                            <input name="usu" type="hidden" id="usu" value="<?php echo $usuario ?>" />
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>

                                <td>
                                    <div align="right">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="mesL" type="text" id="mesL" size="1" maxlength="2" value="" onkeypress="return eventoIngresoVarios(event, 4)" />
                                            /
                                            <input name="yearsL" type="text" id="yearsL" size="2" maxlength="4" value="" onkeypress="return eventoIngresoVarios(event, 4)" />
                                            <input name="locall" type="hidden" id="locall" value="<?php echo $codloc ?>" />
                                            <input name="usu" type="hidden" id="usu" value="<?php echo $usuario ?>" />
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            <?php } ?>

                            <td title="22222">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input name="text2" type="text" id="text2" value="<?php echo $costre; ?>" size="4" onKeyPress="return ent1(event)" readonly />
                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>

                            <td>
                                <div align="right"><?php echo stockcaja($cant_loc, $factor); ?></div>
                            </td>

                            <td align="left">
                                <div align="left">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input disable="disabled" size="2" name="text3" type="text" id="text3" size="6" class="pvta" value="" disabled="disabled" READONLY />
                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>

                            <td>
                                <div align="center"><?php
                                                    if ($control == 0) {
                                                        if ($cant_loc > 0) {
                                                    ?> <a href="ingresos_varios1.php?valcprod=<?php echo '' ?>&valform=<?php echo '' ?>&search=<?php echo '0' ?>" target="comp_principal"><img src="../../../images/del_16.png" width="14" height="15" border="0" /></a><?php
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                        ?><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /><?php } ?></div>
                            </td>

                        </tr>
                    <?php }
                    ?>
                </table>
            <?php
            } else {
            ?>
                <center><u><br><br>
                        <span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
                </center>
        <?php
            }
        }
        ?>
    </form>
</body>

</html>