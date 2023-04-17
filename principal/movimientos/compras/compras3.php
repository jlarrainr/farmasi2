<?php
include('../../session_user.php');
$invnum = $_SESSION['compras'];
$ok = $_REQUEST['ok'];
$ckigv = $_REQUEST['ckigv'];
$busca_prov = $_REQUEST['busca_prov'];
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
    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
    require_once("../funciones/compras.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES

    $sql = "SELECT drogueria  FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $drogueria          = $row["drogueria"];
        }
    }
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
        function mensaje() {
            alert("No se puede editar, eliminar y volver a cargar el Producto");
        }

        function letraf(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            // return (key == 85 || key == 117 || key <= 13 || (key >= 48 && key <= 57));
            return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
        }

        function tippbon() {
            var tip = document.form2.tipbonif.value;
            if (tip == 1) {
                document.form2.country.disabled = true;
                document.form2.country.value = "";
            } else if (tip == 2) {
                document.form2.country.disabled = false;
                document.form2.country.value = "";
                document.form2.country.focus();
            }
        }
        var popUpWin = 0;

        function popUpWindows(URLStr, left, top, width, height) {
            pcosto = document.form1.text6.value;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            URLStr = URLStr + '&costo=' + pcosto;
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            //alert(URLStr+'&costo='+pcosto);
        }

        function validar_bonif() {
            var f = document.form2
            var tip = document.form2.tipbonif.value;
            if (tip == 2) {
                if (document.form2.country_ID.value == "") {
                    alert("Ingrese el nombre del Producto");
                    document.form2.country.focus();
                    return;
                }
            }
            if (document.form2.bonif_can.value == "") {
                alert("Ingrese la Cantidad a Ingresar");
                document.form2.bonif_can.focus();
                return;
            }

              if (document.form2.drogueria.value == 1) {
            if (f.countryL.value == "") {
                alert("Ingrese el Numero de Lote");
                f.countryL.focus();
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
                var cadena_mes2 = parseInt(document.form2.mesL.value, 10);
            } else {
                cadena_mes2 = parseInt(f.mesL.value);
            }
            ano = parseInt(ano);
            mess = parseInt(mess);
            if (ano > cadena) {
                alert("Ingrese un Año posterior al Año Actual");
                f.yearsL.focus();
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
            var v1 = document.form2.bonif_can.value; //CANTIDAD 
            var valor = isNaN(v1);
            if (valor == true) ////NO ES NUMERO
            {
                document.form2.nnum.value = 1; ////avisa que no es numero
            } else {
                document.form2.nnum.value = 0; ////avisa que es numero
            }
            document.form2.method = "post";
            document.form2.action = "compras33.php";
            document.form2.submit();
        }
    </script>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td {
            border: 1px solid #ddd;
            padding: 2px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #FFFF66;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #5ed592;
            color: white;
            font-size: 15px;
        }
    </style>
</head>

<body onload="fc()">
    <?php
    $sql1 = "SELECT porcent FROM datagen";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $porcent = $row1['porcent'];
        }
    }
    $sql = "SELECT nro_compra FROM movmae where usecod = '$usuario' and proceso = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $ncompra = $row["nro_compra"];  //codigo
        }
    }
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count = $row[0];
        }
    } else {
        $count = 0;
    }
    $sql = "SELECT * FROM tempmovmov where invnum = '$invnum' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {

        $codtemp = $_REQUEST['codtemp'];
        $codprod = $_REQUEST['codprod'];
        $bon = $_REQUEST['bon'];
        if ($bon == 1) {
    ?>

            <form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
                <input type="hidden" id="busca_prov" name="busca_prov" value="<?php echo $busca_prov; ?>" />
                <?php
                $sqlq = "SELECT codpro,canbon,tipbon FROM tempmovmov where codtemp = '$codtemp' and invnum = '$invnum'";
                $resultq = mysqli_query($conexion, $sqlq);
                if (mysqli_num_rows($resultq)) {
                    while ($rowq = mysqli_fetch_array($resultq)) {
                        $codprobon = $rowq["codpro"];
                        $canbonbon = $rowq["canbon"];
                        $tipbon = $rowq["tipbon"];
                    }
                }
                // echo 'codprobon = ' . $codprobon . '<br>';
                $sqlq = "SELECT codpro,canbon,tipbon,numlote,vencim,tipbonif,codprobon FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$invnum'";
                $resultq = mysqli_query($conexion, $sqlq);
                if (mysqli_num_rows($resultq)) {
                    while ($rowq = mysqli_fetch_array($resultq)) {
                        $codprobon1 = $rowq["codpro"];
                        $canbonbon1 = $rowq["canbon"];
                        $tipbon1    = $rowq["tipbon"];
                        $numlote    = $rowq["numlote"];
                        $vencim     = $rowq["vencim"];
                        $tipbonif   = $rowq["tipbonif"];
                        $codprobon_bonif   = $rowq["codprobon"];
                        $tyt = 1;

                        $vencim1 = explode("/", $vencim);
                        $mes = $vencim1[0];
                        $ano = $vencim1[1];
                    }
                } else {
                    $tyt = 0;
                }
                $sqlq = "SELECT desprod,factor FROM producto where codpro = '$codprobon'";
                $resultq = mysqli_query($conexion, $sqlq);
                if (mysqli_num_rows($resultq)) {
                    while ($rowq = mysqli_fetch_array($resultq)) {
                        $desprodbon = $rowq["desprod"];
                        $factorbon = $rowq["factor"];
                    }
                }
                if ($tyt == 1) {
                    $sqlq = "SELECT desprod,factor FROM producto where codpro = '$codprobon1'";
                    $resultq = mysqli_query($conexion, $sqlq);
                    if (mysqli_num_rows($resultq)) {
                        while ($rowq = mysqli_fetch_array($resultq)) {
                            $desprodbon1 = $rowq["desprod"];
                            $factorbon1 = $rowq["factor"];
                        }
                    }
                }

                // DESCRIPCION DEL PRODUCTO
                if ($tyt == 1) {
                    $desp = $desprodbon1;
                    $fac = $factorbon1;
                } else {
                    $desp = $desprodbon;
                    $fac = $factorbon;
                }

                // CANTIDAD DEL PRODUCTO 
                if ($tyt == 1) {
                    if ($tipbon1 == "U") {
                        $tipo = "F";
                    }
                    $cantidad_mostrar = $tipo . $canbonbon1;
                } else {
                    if ($tipbon == "U") {
                        $tipo =  "F";
                    }
                    $cantidad_mostrar = $tipo . $canbonbon;
                }

                //BONIFICABLE
                if ($tyt == 1) {
                    // $bonificable = $codprobon1;
                }

                if ($tipbonif == 1) {
                    $bonificable = $codprobon_bonif;
                } else {
                    $bonificable = $codprobon_bonif;
                }

                ?>

                <table align="center" width="80%" border="1" class="celda2" cellpadding="0" cellspacing="0" id="customers">
                    <tr>
                        <th width="80%" colspan="6">
                            <div align="center">
                                <blink> INGRESO DE BONIFICACIONES </blink>
                            </div>
                        </th>
                    </tr>

                    <tr>
                        <th width="5%"><strong>PRODUCTO</strong></th>
                        <td width="479">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <th style="background:#bfbebe;">COD</th>
                                    <td><?php echo $codprobon; ?></td>
                                    <th style="background:#bfbebe;">DESCRIPCION</th>
                                    <td><?php echo $desprodbon; ?></td>
                                    <th style="background:#bfbebe;">FACTOR</th>
                                    <td><?php echo $factorbon; ?></td>
                                </tr>
                            </table>


                        </td>
                        <th width=" 5%">
                            <div align="right">
                                <strongW>TIPO DE BONIF </strongW>
                            </div>
                        </th>
                        <td width="260">
                            <select name="tipbonif" id="tipbonif" onchange="tippbon()">
                                <option value="1" <?php if ($tipbonif == "1") { ?> selected="selected" <?php } ?>>EL MISMO PRODUCTO</option>
                                <option value="2" <?php if ($tipbonif == "2") { ?> selected="selected" <?php } ?>>OTRO PRODUCTO</option>
                            </select>
                        </td>
                        <th><strong>BONIFICACION</strong></th>
                        <td>
                            <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" size="90" disabled="disabled" value="<?php echo $desp; ?>" />

                            <input type="text" size="15" value="<?php echo 'FACTOR = ' . $fac; ?>" readonly />
                            <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $bonificable; ?>" />
                            <!-- <input type="text" value="<?php echo $codprobon_bonif; ?>" /> -->
                        </td>
                    </tr>
                    <tr>

                        <th>
                            <div align="right"><strong>CANTIDAD </strong></div>
                        </th>

                        <td>
                            <input name="bonif_can" type="text" id="bonif_can" size="5" onkeypress="return letraf(event)" value="<?php echo $cantidad_mostrar ?>" />
                        </td>
                        
                        

                      
                        <th>
                            <div align="right"><strong>NUMERO LOTE </strong></div>
                        </th>
                        <td>
                            <input name="countryL" type="text" id="countryL" size="20" value="<?php echo $numlote; ?>" onkeypress="return evento_compra(event,3)" onkeypress="this.value = this.value.toUpperCase();" />

                        </td>
                        <th>
                            <div align="right"><strong>VENCIMIENTO </strong></div>
                        </th>

                        <td>

                            <input name="mesL" type="text" id="mesL" size="4" maxlength="2" placeholder="MM" value="<?php echo $mes; ?>" onkeypress="return evento_compra(event,1)" onkeypress="return acceptNum(event)" />
                            /
                            <input name="yearsL" type="text" id="yearsL" size="2" maxlength="4" placeholder="AAAA" value="<?php echo $ano; ?>" onkeypress="return evento_compra(event,1)" onkeypress="return acceptNum(event)" />

                     
                        


                            <input name="nnum" type="hidden" id="nnum" />
                            <input name="codprobon" type="hidden" id="codprobon" value="<?php echo $codprobon ?>" />
                            <!-- <input type="text" value="<?php echo $codprobon_bonif; ?>" /> -->
                            <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                            <input name="ok" type="hidden" id="ok" value="<?php echo $ok ?>" />
                            <input name="drogueria" type="hidden" id="drogueria" value="<?php echo $drogueria ?>" />
                            <input type="button" name="Submit" value="Grabar" onclick="validar_bonif()" class="grabarventa" />
                            <input type="submit" name="Submit2" value="Cancelar" class="salir" />
                        </td>
                    </tr>
                </table>
            </form>
        <?php }
        ?>
        <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
            <input type="hidden" id="busca_prov" name="busca_prov" value="<?php echo $busca_prov; ?>" />
            <input type="hidden" id="ckigv" name="ckigv" value="<?php echo $ckigv; ?>" />

            <table class="celda2" width="100%">
                <tr>
                    <th width="19" bgcolor="#50ADEA" class="titulos_movimientos" align="center">N&ordm;</th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">CODIGO</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">MARCA</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">FACTOR</div>
                    </th>

                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">LOTE</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">VENCI</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">BONIF</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">CANT</div>
                    </th>



                    <th width="50" bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">COSTO CAJA</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">DESC1</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">DESC2</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">DESC3</div>
                    </th>


                    <th width="50" bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">C. CAJA (+IGV)</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">SUB TOT</div>
                    </th>
                    <!--<th  bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">PREC</div></th>-->
                    <th bgcolor="#50ADEA" class="titulos_movimientos">
                        <div align="center">LOTE</div>
                    </th>
                    <th bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $i++;
                    $codtemp = $row['codtemp'];
                    $codpro = $row['codpro'];
                    $qtypro = $row['qtypro'];
                    $qtyprf = $row['qtyprf'];
                    $desc1 = $row['desc1'];
                    $desc2 = $row['desc2'];
                    $desc3 = $row['desc3'];
                    $prisal = $row['prisal'];
                    $pripro = $row['pripro'];
                    $costre = $row['costre'];
                    $canbon = $row['canbon'];
                    $numlote = $row['numlote'];



                    $sql2 = "SELECT vencim FROM templote where numerolote  = '$numlote' and codpro = '$codpro' and codtemp='$codtemp' ";
                    $result2 = mysqli_query($conexion, $sql2);
                    if (mysqli_num_rows($result2)) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $vencimi = $row2['vencim'];
                            //                                list($m, $ycar) = split('[/.-]', $vencimi);
                            //                                $search = 0;
                        }
                    }
                    // echo 'asdas ' . $codtemp  . "<br>";
                    // echo 'invnum ' . $invnum  . "<br>";


                    $sql1 = "SELECT canbon FROM tempmovmov_bonif where codpro = '$codpro' and  codtemp = '$codtemp' and invnum = '$invnum'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        $ccbon = 1;
                    } else {
                        $ccbon = 0;
                    }
                    $sql1 = "SELECT lotec FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $lotecfiltro = $row1['lotec']; ///para buscar el lote 
                        }
                    }

                    if ($lotecfiltro == 1) {
                        $lotenombre = "lotec";
                    } else {
                        $lotenombre = "lote";
                    }

                    $sql1 = "SELECT desprod,codmar,factor,igv,pcostouni,stopro,$lotenombre,codpro FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factor = $row1['factor'];
                            $igv = $row1['igv'];
                            $stopro = $row1['stopro']; ///STOCK EN UNIDADES 
                            $codpro = $row1['codpro']; ///STOCK EN UNIDADES 
                            $lote = $row1[6]; ///STOCK EN UNIDADES 



                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
                            } elseif ($precios_por_local == 0) {
                                $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $pcostouni_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costpr = $row_precio['pcostouni'];  ///COSTO PROMEDIO
                                    }
                                }
                            }
                            /* if ($igv == 1)
                                  {
                                  $ckigv = 1;
                                  } */
                        }
                    }
                    $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $ltdgen = $row1['ltdgen'];
                        }
                    }
                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $marca = $row1['destab'];
                        }
                    }
                    if ($costre > 0) {
                        $bg = "#f7f7a6";
                        $over = "#f7f7a6";
                        $out = "#f7f7a6";
                    } else {
                        $bg = "#ffffff";
                        $over = "#EAEDEF";
                        $out = "#ffffff";
                    }
                    $valform = $_REQUEST['valform'];
                    $cod = $_REQUEST['cod'];
                    $codtempfiltro = $_REQUEST['codtempfiltro'];
                ?>
                    <tr bgcolor="<?php echo $bg; ?>" onMouseOver="this.style.backgroundColor = '<?php echo $over; ?>';
                                        this.style.cursor = 'hand';" onMouseOut="this.style.backgroundColor = '<?php echo $out; ?>';">
                        <td valign="bottom" align="center">
                            <?php echo $i; ?>
                        </td>
                        <td valign="bottom" align="center">
                            <?php echo $codpro; ?>
                        </td>
                        <td valign="bottom">
                            <a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>', 435, 110, 560, 200)" title="EL FACTOR ES <?php echo $factor ?>" style="text-decoration:none;padding: 1em 5px 30px 0px;"><strong><?php
                                                                                                                                                                                                                                                                    echo substr($desprod, 0, 65);
                                                                                                                                                                                                                                                                    echo "";
                                                                                                                                                                                                                                                                    ?></strong></a>
                        </td>
                        <td valign="bottom" align="center"><?php echo $marca ?></td>
                        <td valign="bottom" align="center"><?php echo $factor ?></td>
                        <td valign="bottom">
                            <div align="center"><?php echo $numlote; ?></div>
                        </td>

                        <td valign="bottom">
                            <div align="center"><?php echo $vencimi ?></div>
                        </td>
                        <td>
                            <center>
                                <?php
                                // echo '$ccbon = ' . $ccbon . "<br>";

                                if ($canbon <> 0) {
                                ?>
                                    <a href="compras3.php?codtemp=<?php echo $codtemp ?>&codprod=<?php echo $codpro ?>&bon=1&ok=<?php echo $ok ?>&busca_prov=<?php echo $busca_prov; ?>">
                                        <img src="<?php if ($ccbon == 0) { ?>../../../images/tickr.gif<?php } else { ?>../../../images/tickg.gif<?php } ?>" border="0" title="REGISTRO DE BONIFICACION" /> </a>
                                <?php } ?>
                            </center>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input type="hidden" name="costpr" value="<?php echo $costpr; ?>" />
                                    <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                    <input type="hidden" name="ok" value="<?php echo $ok; ?>" />
                                    <input name="number2" type="hidden" id="number2" />
                                    <input type="hidden" name="factor" value="<?php echo $factor; ?>" />
                                    <input type="hidden" id="ckigv" name="ckigv" value="<?php echo $ckigv; ?>" />
                                    <input type="hidden" name="porcentaje" value="<?php
                                                                                    if ($igv == 1) {
                                                                                        echo $porcent;
                                                                                    }
                                                                                    ?>" />
                                    <input TITLE="SSDF" name="text1" type="text" class="input_text1" id="text1" value="<?php
                                                                                                                        if ($qtyprf <> "") {
                                                                                                                            echo $qtyprf;
                                                                                                                        } else {
                                                                                                                            echo $qtypro;
                                                                                                                        }
                                                                                                                        ?>" size="4" onKeyUp="precio();" onKeyPress="return f(event)" />
                                <?php
                                } else {
                                    if ($qtyprf <> "") {
                                        echo $qtyprf;
                                    } else {
                                        echo $qtypro;
                                    }
                                }
                                ?>
                            </div>
                        </td>


                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text2" type="text" class="input_text1" id="text2" value="<?php echo $prisal ?>" size="4" maxlength="6" onKeyPress="return decimal(event)" onKeyUp="precio();" />
                                <?php
                                } else {
                                    echo $prisal;
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text3" type="text" class="input_text1" id="text3" value="<?php echo $desc1 ?>" size="4" maxlength="5" onKeyPress="return acceptNum(event)" onKeyUp="precio();" />
                                <?php
                                } else {
                                    echo $desc1;
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text4" type="text" class="input_text1" id="text4" value="<?php echo $desc2 ?>" size="4" maxlength="5" onKeyPress="return acceptNum(event)" onKeyUp="precio();" />
                                <?php
                                } else {
                                    echo $desc2;
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text5" type="text" class="input_text1" id="text5" value="<?php echo $desc3 ?>" size="4" maxlength="5" onKeyPress="return acceptNum(event)" onKeyUp="precio();" />
                                <?php
                                } else {
                                    echo $desc3;
                                }
                                ?>
                            </div>
                        </td>



                        <td valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text6" type="text" id="text6" size="4" class="pvta" value="<?php echo $pripro ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $pripro;
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text7" type="text" id="text7" size="8" class="pvta" value="<?php echo $costre ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $costre;
                                }
                                ?>
                            </div>
                        </td>
                        <!-- <td >
                                <div align="center">
                            <?php // if (($valform == 1) && ($cod == $codpro)&&( $codtempfiltro == $codtemp)) { 
                            ?>
                                        <a href="javascript:popUpWindows('price/price.php?cod=<?php // echo $codpro                    
                                                                                                ?>&invnum=<?php // echo $invnum                    
                                                                                                            ?>&ncompra=<?php // echo $ncompra                    
                                                                                                                        ?>&ok=<?php // echo $ok                    
                                                                                                                                ?>', 430, 60, 468, 500)" title="PRECIO DE PRODUCTOS">
                                            <img src="../../../images/tickg.gif" width="19" height="18" border="0"/> 
                                        </a>
                            <?php // }
                            ?>
                                </div>
                            </td>-->
                        <td>
                            <a href="javascript:popUpWindow('lote/lote.php?cod=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>&ncompra=<?php echo $ncompra ?>&codtempfiltro=<?php echo $codtemp ?>&ok=<?php echo $ok ?>', 435, 110, 560, 200)" title="LOTE DE PRODUCTOS">
                                <div align="center"><?php if ($lote == 1) { ?><img src="../../../images/add.gif" width="14" height="15" border="0" /><?php } ?></div>
                            </a>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="number" type="hidden" id="number" />
                                    <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                    <input type="hidden" id="ckigv" name="ckigv" value="<?php echo $ckigv; ?>" />
                                    <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
                                    <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR" />
                                <?php } else { ?>
                                    <!--<a href="compras3.php?cod=<?php echo $codpro ?>&valform=1&ok=<?php echo $ok ?>&busca_prov=<?php echo $busca_prov; ?>&codtempfiltro=<?php echo $codtemp ?>&ckigv=<?php echo $ckigv; ?>">-->
                                    <a onClick="mensaje()">
                                        <img src="../../../images/edit_16.png" width="16" height="16" border="0" />
                                    </a>
                                    <a href="compras4.php?cod=<?php echo $codtemp ?>&ok=<?php echo $ok ?>&busca_prov=<?php echo $busca_prov; ?>&ckigv=<?php echo $ckigv; ?>" target="comp_principal">
                                        <img src="../../../images/del_16.png" width="16" height="16" border="0" />
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
        <?php
    } else {
        ?>
            <!--<br><br><br><br><br><br><br><br><center>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</center>-->
        <?php }
        ?>
        </form>
</body>

</html>

<script type="text/javascript">
    $('#tipbonif').select2({
        minimumResultsForSearch: -1
    });
</script>