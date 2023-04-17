<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <?php
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
    ?>
    <script>
        function sf() {
            var f = document.form1;
            document.form1.p1.focus();
        }

        function cambia() 
        {
            var invnum = document.getElementById("incent").value;

            if(invnum == "-1")
            {
                alert("Seleccione un incentivo");
            }
            else 
            {
                var f = document.form1;
                f.invnumIncentivo.value = document.getElementById("incent").value;
                f.method = "post";
                f.submit();
            }    
        }
        var nav4 = window.Event ? true : false;

        function enter(evt) {
            // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                document.form1.submit();
            }
        }

        function validar() {
            var f = document.form1;
            if (f.p1.value == "") {
                alert("Ingrese un producto para Iniciar la Busqueda");
                f.p1.focus();
                return;
            }
            f.method = "post";
            f.submit();
        }

        function validar1() {
            var f = document.form1;
            f.val.value = 2;
            
            f.method = "post";
            f.submit();
        }

        function validarform() 
        {

            var invnum = document.getElementById("incent").value;

            if(invnum == "-1")
            {
                alert("Seleccione un incentivo");
            }
            else 
            {
                var f = document.form1;
                if ((f.cant.value == "") && (f.cant2.value == "")) {
                    alert("Debe ingresar una cantidad");
                    f.cant.focus();
                    return;
                }
                if (f.monto.value == "") {
                    alert("Debe ingresar un Monto");
                    f.monto.focus();
                    return;
                }
                f.method = "post";
                f.target = "principal";
                f.action = "incentivo_grabar.php";
                f.submit();
            }
        }

        function validarcerrar() {
            var f = document.form1;
            f.valform.value = 0;
            f.codpro.value = "";
            f.incent.value = "";
            f.action = "incentivo3.php";
            f.method = "post";
            f.submit();
        }

        function activaate() {
            var f = document.form1;
            f.ver.value = 0;
            f.incent.value = "";
            f.action = "incentivo3.php";
            f.method = "post";
            f.submit();
        }

    </script>
    <style>
        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/icon-16-checkin.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        a:link,
        a:visited {
            /*color: #0066CC;*/
            border: 0px solid #e7e7e7;
        }

        a:hover {
            background: #fff;
            border: 0px solid #ccc;
        }

        a:focus {
            background-color: #FFFF99;
            /*color: #0066CC;*/
            border: 0px solid #ccc;
        }

        a:active {
            background-color: #FFFF99;
            /*color: #0066CC;*/
            border: 0px solid #ccc;
        }

        .Estilo2 {
            color: #FFFFFF;
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

        #p1 {
            width: 70%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: white;
            background-image: url('../../movimientos/compras/buscador.png');
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 5px 15px 3px 35px;
        }

        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
            font-weight: bold;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ebf8a4;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
    <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<?php
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
////////////////////////////
$registros = 10;
$pagina = $_REQUEST["pagina"];
$val = $_REQUEST['val'];
$p1 = $_REQUEST['p1'];
$ord = $_REQUEST['ord'];
$tip = $_REQUEST['tip'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$cod = $_REQUEST['cod'];
$valform = $_REQUEST['valform'];
$invnumIncentivo = $_REQUEST['invnumIncentivo'];

if (!$pagina) {

    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $registros;
}


////////////////////////////eduardooo
/*if ($val == 1) {
        echo 'aaaa'."<br>";
        $sql = "SELECT codpro FROM producto where ((desprod like '$p1%' )or(codpro = '$p1' )or(codbar = '$p1' )) ";
    } else {
        if ($val == 2) {
            echo 'bbbbbb'."<br>";
            $sql = "SELECT codpro FROM producto where incentivado = '1'";
        } else {
            $sql = "SELECT codpro FROM producto";
            echo 'ccccc'."<br>";
        }
    }
    $sql = mysqli_query($conexion, $sql);
    
    $total_registros = mysqli_num_rows($sql);
    $total_paginas = ceil($total_registros / $registros);*/
////////////////////////////


$caomparacion_incentivado = date('Y-m-d');

$sql = "SELECT * FROM incentivado as I INNER JOIN incentivadodet as ID on ID.invnum=I.invnum WHERE I.estado='1' and I.esta_desa = 0 and ID.codpro='$cod' and '$caomparacion_incentivado' < I.datefin ";

$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result)) 
{
    $variable = 1;
} 
else 
{
    $variable = 0;
}

$sql = "SELECT desprod FROM producto where codpro = '$cod' and eliminado='0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $desprod_alert = $row['desprod'];
    }
}

$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
        $sucursal = $row['codloc'];
    }
}

$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$sql = "SELECT count(*) FROM incentivado where estado = '1' and esta_desa=0 ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $countregx = $row[0];
    }
}

function formato($c)
{
    printf("%08d", $c);
}

if ($tip == 1) {
    $dtip = "ASC";
}
if ($tip == 2) {
    $dtip = "DESC";
}
?>

<body <?php if ($val <> 1) { ?>onload="sf();" <?php } ?>  >
    <form id="form1" name="form1" method="post">
        <table width="100%" border="0">
            <tr>
                <td width="50%">
                    <input name="p1" type="text" id="p1" size="90" value="<?php echo $p1 ?>" onkeypress="enter(event)" placeholder="Buscar Producto....." />
                </td>
                <td width="40%">
                    <input name="val" type="hidden" id="val" value="1" />
                    <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar" />&nbsp;&nbsp;&nbsp;
                    <input type="button" name="Submit2" value="Solo Productos Incentivados" onclick="validar1()" class="modificar" />
                </td>
                <td width="5%">
                    <div align="right">
                        <?php
                        if (($pagina - 1) > 0) {
                        ?>
                            <a href="incentivo3.php?p1=<?php echo $p1 ?>&val=<?php echo $val ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../../images/play1.gif" width="16" height="16" border="0" /> </a>
                        <?php
                        }
                        if (($pagina + 1) <= $total_paginas) {
                        ?>
                            <a href="incentivo3.php?p1=<?php echo $p1 ?>&val=<?php echo $val ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../../images/play.gif" width="16" height="16" border="0" /> </a>
                        <?php }
                        ?>
                    </div>
                </td>
            </tr>
        </table>

        <img src="../../../images/line2.png" width="100%" height="4" />
        <table width="100%" border="0">
            <tr>
                <td>
                    <div align="left"><strong>INCENTIVOS : <?php echo $p1 ?></strong></div>
                </td>
            </tr>
        </table>
        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
        <?php
        $incent = $_REQUEST["incent"];
        $ver = $_REQUEST['ver'];
        if ($incent <> "") {
            $activ = $_REQUEST["activ"];
            $cod = $_REQUEST['codpro'];
            if ($activ == 1) {
            } else {
                $invnumss = $incent;
            }
            $valform = 1;
        }
        if (($valform == 1) and ($cod <> "")) {
            $localx = $_REQUEST['local'];
            $sql = "SELECT codpro,desprod,factor,codmar FROM producto where codpro = '$cod' and eliminado='0'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $desprod1 = $row['desprod'];
                    $codpro1 = $row['codpro'];
                    $factor = $row['factor'];
                    $codmar = $row['codmar'];
                }
            }

            

            $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $destab = $row1['destab'];
                }
            }
            if ($localx <> "") {
                $sql = "SELECT invnum,canprocaj,canprounid,pripro,pripromin,cuota,estado,codloc FROM incentivadodet where codpro = '$cod' and invnum = '$invnumss' and codloc = '$localx'";
            } else {
                $sql = "SELECT invnum,canprocaj,canprounid,pripro,pripromin,cuota,estado,codloc FROM incentivadodet where codpro = '$cod' and invnum = '$invnumss'";
            }
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $invnum = $row['invnum'];
                    $canprocaj = $row['canprocaj'];
                    $canprounid = $row['canprounid'];
                    $pripro = $row['pripro'];
                    $pripromin = $row['pripromin'];
                    $cuota = $row['cuota'];
                    $estado = $row['estado'];
                    $codloc = $row['codloc'];
                }
            } else {
                $estado = 1;
            }
        ?>
            <?php // if ($variable == 0) { 
            ?>
            <table width="100%" border="0" bgcolor="#FFFF99" align="center">
                <tr>
                    <td width="100%">
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td width="80%">
                                    <table width="100%" border="0" bgcolor="#50ADEA">
                                        <tr>
                                            <td width="30%">
                                                <span class="Estilo2" style="font-size:15px;"> A que N&ordm; de incentivo se asignara? </span>
                                            </td>
                                            <td width="70%">
                                                <select name="incent" id="incent" onchange="cambia()" style="width:auto;">
                                                    <option value="-1">---SELECCIONE INCENTIVO---</option>
                                                    <?php
                                                    $sqlx = "SELECT invnum FROM incentivado where estado = '1' and esta_desa = '0' order by invnum desc";
                                                    $resultx = mysqli_query($conexion, $sqlx);
                                                    if (mysqli_num_rows($resultx)) {
                                                        $nnohay = 1;
                                                        while ($rowx = mysqli_fetch_array($resultx)) {
                                                            $inv = $rowx["invnum"];
                                                    ?>
                                                            <option value="<?php echo $rowx["invnum"] ?>" <?php if ($invnumss == $inv) { ?>selected="selected" <?php } ?>><?php echo formato($rowx["invnum"]); ?> </option>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="0">NO SE LOGRO ENCONTRAR INCENTIVOS HABILITADOS</option>
                                                    <?php
                                                        $nnohay = 0;
                                                    }
                                                    ?>
                                                </select>
                                                <!--                                                        <input name="ver" type="hidden" id="ver" value="1"/>
                                                    <input type="button" name="Submit3" value="Buscar" onclick="cambia();" <?php if ($nnohay == 0) { ?> disabled="disabled"<?php } ?>/>-->

                                            </td>
                                        </tr>
                                    </table>
                                    <img src="../../../images/line2.png" width="100%" height="4" />
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="20%">
                                                <strong>
                                                    Codigo
                                                </strong>
                                            </td>
                                            <td width="80%">
                                                <input name="textfield" type="text" size="15" value="<?php echo $codpro1 ?>" disabled="disabled" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Producto</strong></td>
                                            <td>
                                                <input name="textfield" type="text" size="50" value="<?php echo $desprod1 ?>" disabled="disabled" />
                                                <a href="incentivo3.php?val=<?php echo $val ?>&amp;&amp;p1=<?php echo $p1 ?>&amp;&amp;ord=<?php echo $ord ?>&amp;&amp;tip=<?php echo $tip ?>&amp;&amp;inicio=<?php echo $inicio ?>&amp;&amp;pagina=<?php echo $pagina ?>&amp;&amp;tot_pag=<?php echo $tot_pag ?>&amp;&amp;registros=<?php echo $registros ?>"><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /></a>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><strong>Laboratorio</strong></td>
                                            <td>
                                                <input name="marca" id="marca" type="text" size="50" value="<?php echo $destab ?>" disabled="disabled" />
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><strong>Factor</strong></td>
                                            <td>
                                                <input name="factor" id="factor" type="text" size="15" value="<?php echo $factor; ?>" disabled="disabled" />
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Sucursal</strong>
                                            </td>
                                            <td>
                                                <select  name="local" id="local">
                                                    <?php
                                                    $sqlx = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1' order by codloc";
                                                    $resultx = mysqli_query($conexion, $sqlx);
                                                    while ($rowx = mysqli_fetch_array($resultx)) {
                                                        $loc = $rowx["codloc"];
                                                        $nloc = $rowx["nomloc"];
                                                        if($loc == 1)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $rowx["codloc"] ?>" <?php if ($loc == $codloc) { ?> selected="selected" <?php } ?>><?php echo $rowx["nombre"] ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Por la venta de </strong>
                                            </td>
                                            <td>
                                                <input name="cant" type="text" id="cant" placeholder="Cajas....." onkeypress="return acceptNum(event);" value="<?php echo $canprocaj ?>" size="12" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                                <!--CAJAS-->
                                                <input name="cant2" type="hidden" id="cant2" placeholder="Unidades....." onkeypress="return acceptNum(event);" value="<?php echo $canprounid ?>" size="12" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                                <!--UNIDADES-->
                                                <!--<b>(FACTOR = <?php echo $factor ?>)</b>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>El monto a pagar sera de S/. </strong>
                                            </td>
                                            <td>
                                                <input name="monto" type="text" id="monto" onkeypress="return decimal(event);" value="<?php echo $pripro ?>" size="12" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!--<strong>PRECIO MINIMO </strong>-->
                                            </td>
                                            <td>
                                                <input name="price" type="hidden" id="price" onkeypress="return decimal(event);" value="<?php echo $pripromin ?>" size="12" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                            <td>
                                                <!--<strong>Meta Referencial1</strong>!-->

                                                <?php 

                                                    $existeIncentivoDet = '-1';

                                                    //echo $existeIncentivoDet;

                                                    if(!empty($invnumIncentivo) && !empty($codpro1))
                                                    {
                                                        $sqlIncentivosDet = "SELECT estado FROM incentivadodet WHERE codpro = '$codpro1' AND invnum = '$invnumIncentivo' ";

                                                        $resultID = mysqli_query($conexion, $sqlIncentivosDet);

                                                        

                                                        if (mysqli_num_rows($resultID)) 
                                                        {
                                                            while ($row = mysqli_fetch_array($resultID)) 
                                                            {
                                                                $existeIncentivoDet = $row['estado'];

                                                            }
                                                        }


                                                        if ($existeIncentivoDet == '0') 
                                                        {
                                                            echo '<strong>Incentivo desactivado</strong>';
                                                        }
                                                        else if ($existeIncentivoDet == '1')  
                                                        {
                                                            echo '<strong>Incentivo activado</strong>';
                                                        }
                                                        else if ($existeIncentivoDet == '-1')  
                                                        {
                                                            echo '<strong>Producto no incentivado</strong>';
                                                        }
                                                    }
                                                    
                                                ?>

                                            </td>
                                            <td>
                                                    <!--
                                                    <input name="cuota" type="text" id="cuota" onkeypress="return decimal(event);" value="<?php echo $cuota ?>" size="12" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                                    !-->
                                                <input name="invnumIncentivo" type="hidden" id="invnumIncentivo" value="<?php echo $invnumIncentivo ?>" />
                                                <input name="cuota" type="hidden" id="cuota" value="<?php echo ($cuota == null)? 0 : $cuota ?>">
                                                <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro1 ?>" />
                                                <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                                <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                <input name="p1" type="hidden" id="p1" value="<?php echo $p1 ?>" />
                                                <input name="ord" type="hidden" id="ord" value="<?php echo $ord ?>" />
                                                <input name="inicio" type="hidden" id="inicio" value="<?php echo $inicio ?>" />
                                                <input name="pagina" type="hidden" id="pagina" value="<?php echo $pagina ?>" />
                                                <input name="tot_pag" type="hidden" id="tot_pag" value="<?php echo $tot_pag ?>" />
                                                <input name="registros" type="hidden" id="registros" value="<?php echo $registros ?>" />
                                                <input name="valform" type="hidden" id="valform" />
                                                <input type="button" name="Submit22" value="Grabar" class="grabarventa" onclick="validarform();" <?php if ($estado == 0) { ?>disabled="disabled" <?php } ?> />
                                                <input type="button" name="Submit22" value="Cerrar" onclick="validarcerrar();" class="salir" />
                                                <?php if ($estado == 0) { ?>
                                                    (UD DEBE CAMBIAR EL ESTADO DEL PRODUCTO A INCENTIVADO)
                                                <?php } ?>                                                
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20%" valign="top" bgcolor="#FFFFFF">
                                    <iframe src="incentivo3_3.php?codpro=<?php echo $cod; ?>&invnum=<?php echo $invnum ?>&val=<?php echo $val ?>&valform=1&p1=<?php echo $p1 ?>&&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>" name="marco3" id="marco3" width="100%" height="180" scrolling="Automatic" frameborder="0" allowtransparency="0"> </iframe>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <?php // } else {
            ?>
            <!--                    <script type="text/javascript">
                                alert("<?php echo 'El Producto ' . $desprod_alert . ' ya se encuentra con un incentivo activo hasta la fecha'; ?>");
                            </script>-->
            <?php
            //                }
            ?>
            <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
        <?php }
        ?>

        <table width="100%" border="0" id="customers">

            <tr>
                <th width="5%">
                    <strong>CODIGO</strong>
                    <!--<a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=1&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a>-->
                    <!--<a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=2&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a>-->
                </th>

                <th width="35%">
                    <strong>PRODUCTO</strong>
                    <!--                        <a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=1&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a> 
                        <a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=2&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a>      -->
                </th>

                <th width="25%">
                    <strong>LABORATORIO</strong>
                    <!--                        <a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=1&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/down_enabled.gif" width="7" height="9" border="0" /></a> 
                        <a href="incentivo3.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=1&tip=2&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><img src="../css/up_enabled.gif" width="7" height="9" border="0"/></a>      -->
                </th>


                <th width="8%">FACTOR</th>
                <th width="15%">STOCK</th>
                <th width="8%">&nbsp;</th>

                <th width="3%">&nbsp;</th>
            </tr>
            <?php
            $z = 0;
            
            
            ///////////////////////////////////////////////////////SOLO SE INGRESA EL TEXT0
            if ($ord == "") {

                if ($val == 1) {
                    $sql = "SELECT codpro,desprod,incentivado,$tabla as stopro,codmar,factor FROM producto where ((desprod like '$p1%' )or(codpro = '$p1' )or(codbar = '$p1' )) and eliminado='0' LIMIT $inicio, $registros";
                } else {

                    //prueba
                    if ($val == 2) 
                    {
                        $sql = "SELECT  producto.codpro,desprod,incentivado,$tabla as stopro,codmar,producto.factor FROM producto 
                        inner join incentivadodet on producto.codpro = incentivadodet.codpro 
                        inner join incentivado on incentivadodet.invnum = incentivado.invnum
                        WHERE incentivadodet.estado = 1 and incentivado.estado = 1 and incentivado.esta_desa = 0 group by codpro order by desprod,$tabla LIMIT $inicio, $registros";
                    } 
                    else 
                    {
                        $sql = "SELECT codpro,desprod,incentivado,$tabla as stopro,codmar,factor FROM producto  and eliminado='0' order by desprod,$tabla LIMIT $inicio, $registros";
                    }
                }
            } else if ($ord == 1) {
                ///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR PRODUCTO
                if ($val == 1) {
                    $sql = "SELECT codmar,codpro,desprod,incentivado,$tabla as stopro,factor FROM producto where ((desprod like '$p1%' )or(codpro = '$p1' )or(codbar = '$p1' ))  and eliminado='0'  order by desprod,$tabla $dtip LIMIT $inicio, $registros";
                } else {

                    //prueba
                    if ($val == 2) {
                        $sql = "SELECT producto.codmar,producto.codpro,desprod,incentivado,$tabla as stopro,factor FROM producto 
                        inner join incentivadodet on producto.codpro = incentivadodet.codpro 
                        inner join incentivado on incentivadodet.invnum = incentivado.invnum
                        WHERE incentivadodet.estado = 1 and incentivado.estado = 1 and incentivado.esta_desa = 0 group by producto.codpro order by desprod,$tabla $dtip LIMIT $inicio, $registros";
                    } 
                    else 
                    {
                        $sql = "SELECT codpro,desprod,incentivado,$tabla as stopro,codmar,factor FROM producto  and eliminado='0' order by desprod,$tabla $dtip LIMIT $inicio, $registros";
                    }
                }
            } else if ($ord == 2) {
                ///////////////////////////////////////////////////////SE SELECCIONO PARA ORDENAR POR INCENTIVOS
                if ($val == 1) {

                    $sql = "SELECT codpro,desprod,incentivado,$tabla as stopro,codmar,factor FROM producto where ((desprod like '$p1%' )or(codpro = '$p1' )or(codbar = '$p1' ))  and eliminado='0' order by incentivado,$tabla $dtip LIMIT $inicio, $registros";
                } else {

                    //prueba
                    if ($val == 2) {
                        $sql = "SELECT producto.codmar,producto.codpro,desprod,incentivado,$tabla as stopro,factor FROM producto 
                        inner join incentivadodet on producto.codpro = incentivadodet.codpro 
                        inner join incentivado on incentivadodet.invnum = incentivado.invnum
                        WHERE incentivadodet.estado = 1 and incentivado.estado = 1 and incentivado.esta_desa = 0 group by producto.codpro order by incentivado,$tabla $dtip LIMIT $inicio, $registros";
                    } 
                    else 
                    {
                        $sql = "SELECT codpro,desprod,incentivado,$tabla as stopro,codmar,factor FROM producto  and eliminado='0' order by incentivado,$tabla $dtip LIMIT $inicio, $registros";
                    }
                }

              
            }

            //echo $sql;

            $result = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $codpro = $row['codpro'];
                    $desprod = $row['desprod'];
                    $incentivado = $row['incentivado'];
                    $stopro = $row['stopro'];
                    $factor = $row['factor'];
                    $codmar = $row['codmar'];

                    //                        $sql1 = "SELECT codpro FROM incentivadodet where codpro = '$codpro' and invnum = '$invnumss'";
                    $caomparacion = date('Y-m-d');
                    $sql1 = "SELECT * FROM incentivado as I INNER JOIN incentivadodet as ID on ID.invnum=I.invnum WHERE ID.estado=1 and I.esta_desa = 0  and I.estado and ID.codpro='$codpro' and '$caomparacion' < I.datefin";
                    
                    
                    
                    $result1 = mysqli_query($conexion, $sql1);


                    if (mysqli_num_rows($result1)) 
                    {
                        $sihay1 = '1';
                    } 
                    else 
                    {
                        $sihay1 = '0';
                    }
                    



                    $sihay = '0';

                  

                    if ($incentivado == 1 && $sihay1 == 1) {
                        $des_incent = "INCENTIVADO";
                    } else {
                        $des_incent = "NO INCENTIVADO";
                    }

                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $destab = $row1['destab'];
                        }
                    }
                    $z++;
                    if ($stopro <= 0) {
                        $bgcolor = '#FFCBCB';
                    } else {
                        $bgcolor = '#ffffff';
                    }
                    if ($sihay == 1) {
                        $color = '#000000';
                    } else {
                        $color = '#0066CC';
                    }
            ?>
                    <tr <?php if (($valform == 1) && ($cod == $codpro)) { ?> bgcolor="#FFFF33" <?php } else if ($stopro <= 0) { ?> bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                        <td align="center">
                            <?php if (($countregx >= 1) && ($sihay == 0)) { ?>
                                <a color="<?php echo $color; ?>" href="incentivo3.php?cod=<?php echo $codpro; ?>&val=<?php echo $val ?>&valform=1&p1=<?php echo $p1 ?>&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><?php echo $codpro; ?></a>
                            <?php } else { ?>
                                <font color="<?php echo $color; ?>"><?php echo $codpro; ?></font>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (($countregx >= 1) && ($sihay == 0)) { ?>
                                <a color="<?php echo $color; ?>" id="l<?php echo $z; ?>" href="incentivo3.php?cod=<?php echo $codpro; ?>&val=<?php echo $val ?>&valform=1&p1=<?php echo $p1 ?>&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><?php echo $desprod; ?></a>
                            <?php } else {
                            ?>
                                <font color="<?php echo $color; ?>"><?php echo $desprod; ?></font>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (($countregx >= 1) && ($sihay == 0)) { ?>
                                <a color="<?php echo $color; ?>" href="incentivo3.php?cod=<?php echo $codpro; ?>&val=<?php echo $val ?>&valform=1&p1=<?php echo $p1 ?>&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>"><?php echo $destab; ?></a>
                            <?php } else { ?>
                                <font color="<?php echo $color; ?>"><?php echo $destab; ?></font>
                            <?php } ?>
                        </td>

                        <td align="center"><?php echo $factor; ?></td>
                        <td align="center"><?php echo stockcaja($stopro, $factor); ?></td>
                        <td align="center" <?php if ($incentivado == 1 && $sihay1 == 1) { ?>bgcolor="#fb4818" title="Incentivado" <?php } else { ?>bgcolor="#00CC33" title=" No Incentivado" <?php } ?>> <b style="color:#ffffff; "><?php echo $des_incent; ?></b></td>

                        <td>
                            <div align="right">
                                <?php if (($countregx >= 1) && ($sihay == 0)) { ?>
                                    <a href="incentivo3.php?cod=<?php echo $codpro; ?>&val=<?php echo $val ?>&valform=1&p1=<?php echo $p1 ?>&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>">
                                        <img src="../../../images/edit_16.png" width="16" height="16" border="0" />
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </form>
</body>

</html>