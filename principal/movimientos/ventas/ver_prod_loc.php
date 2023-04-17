<?php
require_once('../../session_user.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
$venta = $_SESSION['venta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="windows-1252">

    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php'); //CONEXION A BASE DE DATOS

    //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
    require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
    require_once('../../../funciones/botones.php'); //COLORES DE LOS BOTONES
    ?>
    <?php
$sql1 = "SELECT codloc,codgrup FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codloc = $row1['codloc'];
            $codgrupve = $row1['codgrup'];
        }
    }

    $sql1_codgrup = "SELECT * FROM `grupo_user` WHERE codgrup = '$codgrupve' and (nomgrup LIKE '%VENDEDOR%')"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_codgrup = mysqli_query($conexion, $sql1_codgrup);
    if (mysqli_num_rows($result1_codgrup)) {
        $controleditable = 1;
    } else {
        $controleditable = 0;
    }

    $sql1 = "SELECT  drogueria FROM datagen_det";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $drogueria      = $row1['drogueria'];
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

    $sql = "SELECT * FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codloc = $row['codloc'];
        }
    }
    $col_stock = "s" . sprintf('%03d', $codloc - 1);
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
            $nombre = $row['nombre'];
        }
    }

    $sqlVenta = "SELECT sucursal FROM venta where invnum = '$venta'";
    $resultVenta = mysqli_query($conexion, $sqlVenta);
    if (mysqli_num_rows($resultVenta)) {
        while ($rowVenta = mysqli_fetch_array($resultVenta)) {
            $sucursal = $rowVenta['sucursal'];
        }
    }

    //**CONFIGPRECIOS_PRODUCTO**//
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


    $TablaPrevtaMain = "prevta";
    $TablaPreuniMain = "preuni";
    if ($nomlocalG <> "") {
        if ($nomlocalG == "LOCAL1") {
            $TablaPrevta = "prevta1";
            $TablaPreuni = "preuni1";
        } else {
            if ($nomlocalG == "LOCAL2") {
                $TablaPrevta = "prevta2";
                $TablaPreuni = "preuni2";
            } else {
                $TablaPrevta = "prevta";
                $TablaPreuni = "preuni";
            }
        }
    } else {
        $TablaPrevta = "prevta";
        $TablaPreuni = "preuni";
    }
    //**FIN_CONFIGPRECIOS_PRODUCTO**//

    if ($nombre <> "") {
        $nomloc = $nombre;
    }

    function formato($c)
    {
        printf("%08d", $c);
    }

    function stockFactor($cant_loc, $factor)
    {
        $convert1 = $cant_loc / $factor;
        $div1 = floor($convert1);
        $mult1 = $factor * $div1;
        $tot1 = $cant_loc - $mult1;
        return $div1 . "F" . $tot1;
    }

    $cod = $_REQUEST['cod'];
    $sql = "SELECT desprod,codmar,codfam,coduso,factor,margene,costre,costpr,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,preblister,detpro,codpro,$tabla as stocklocal FROM producto where codpro = '$cod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $desprod = $row['desprod'];
            $codmar = $row['codmar'];
            $codfam = $row['codfam'];
            $coduso = $row['coduso'];
            $factor = $row['factor'];
            $s000 = $row['s000'];
            $s001 = $row['s001'];
            $s002 = $row['s002'];
            $s003 = $row['s003'];
            $s004 = $row['s004'];
            $s005 = $row['s005'];
            $s006 = $row['s006'];
            $s007 = $row['s007'];
            $s008 = $row['s008'];
            $s009 = $row['s009'];
            $s010 = $row['s010'];
            $s011 = $row['s011'];
            $s012 = $row['s012'];
            $s013 = $row['s013'];
            $s014 = $row['s014'];
            $s015 = $row['s015'];
            $s016 = $row['s016'];
            $s017 = $row['s017'];
            $s018 = $row['s018'];
            $s019 = $row['s019'];
            $s020 = $row['s020'];
            $detpro = $row['detpro'];
            $codpro = $row['codpro'];
            $cant_loc1 = $row['stocklocal'];


            if ($drogueria == 1) {

                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                if (mysqli_num_rows($result1_movlote)) {
                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                        $stock_movlote = $row1_movlote[0];
                    }
                }

                $cant_loc = $stock_movlote;
            } else {

                $cant_loc = $cant_loc1;
            }

            $stock_vencido = $cant_loc1 - $cant_loc;


            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                $margene = $row['margene'];
                $costre = $row['costre'];
                $costpr = $row['costpr'];
                $prevtaMain = $row['PrevtaMain'];
                $preuniMain = $row['PreuniMain'];
                $prevta = $row[25];
                $preuni = $row[26];
                $preblister = $row['preblister'];
            } elseif ($precios_por_local == 0) {
                $margene = $row['margene'];
                $costre = $row['costre'];
                $costpr = $row['costpr'];
                $prevtaMain = $row['PrevtaMain'];
                $preuniMain = $row['PreuniMain'];
                $prevta = $row[25];
                $preuni = $row[26];
                $preblister = $row['preblister'];
            }

            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                $sql_precio = "SELECT $margene_p,$costre_p,$costpr_p,$prevta_p,$preuni_p,$preblister_p FROM precios_por_local where codpro = '$codpro'";
                $result_precio = mysqli_query($conexion, $sql_precio);
                if (mysqli_num_rows($result_precio)) {
                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                        $margene = $row_precio[0];
                        $costre = $row_precio[1];
                        $costpr = $row_precio[2];
                        $prevtaMain = $row_precio[3];
                        $preuniMain = $row_precio[4];
                        $prevta = $row_precio[3];
                        $preuni = $row_precio[4];
                        $preblister = $row_precio[5];
                    }
                }
            }


            //**CONFIGPRECIOS_PRODUCTO**//
            if (($prevta == "") || ($prevta == 0)) {
                $prevta = $prevtaMain;
                $preuni = $preuniMain;
            }
            //**FIN_CONFIGPRECIOS_PRODUCTO**//

            $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $marca = $row1['destab'];
                }
            }
            $sql1 = "SELECT destab FROM titultabladet where tiptab = 'F' and codtab = '$codfam'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $familia = $row1['destab'];
                }
            }
            $sql1 = "SELECT destab FROM titultabladet where tiptab = 'U' and codtab = '$coduso'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $familia2 = $row1['destab'];
                }
            }
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL0'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre1 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL1'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre2 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL2'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre3 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL3'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre4 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL4'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre5 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL5'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre6 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL6'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre7 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL7'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre8 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL8'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre9 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL9'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre10 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL10'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre11 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL11'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre12 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL12'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre13 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL13'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre14 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL14'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre15 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL15'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre16 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL16'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre17 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL17'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre18 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL18'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre19 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL19'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre20 = $row1['nombre'];
        }
    }
    $sql1 = "SELECT nombre FROM xcompa where nomloc = 'LOCAL20'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $nombre21 = $row1['nombre'];
        }
    }
    ?>
    <script>
        function getfocus1() {
            document.getElementById('l1').focus();
        }

        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }
    </script>
    <title><?php echo $desprod ?></title>
    <script>
        function cerrar_popup(valor) {
            //ventana=confirm("Desea Grabar este Cliente");
            var prod = valor;
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php?prod=" + prod;
            self.close();
        }
    </script>
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        <!--
        .Estilo2 {
            color: #FFFFFF;
            font-weight: bold;
        }

        .EstiloT {
            color: #0c4aae;
            font-size: 22px;
        }

        .Estilo3 {
            color: #FFFFFF
        }

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
            color: #0066CC;
            border: 0px solid #ccc;
        }

        a:active {
            background-color: #FFFF66;
            color: #0066CC;
            border: 0px solid #ccc;
        }
        -->
        .texto-vertical-3
        {
        width:10px;
        word-wrap:
        break-word;
        text-align:center;
        }
    </style>
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
    <table class="tabla2" width="100%" border="1" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="100%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="250" bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>Producto</strong></td>
                        <td width="550" bgcolor="#FFFF99"><?php echo $desprod ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>Laboratorio / marca</strong></td>
                        <td bgcolor="#FFFF99"><?php echo $marca ?></td>

                    </tr>

                    <tr>
                        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>Principio activo / contenido</strong></td>
                        <td bgcolor="#FFFF99"><?php echo $familia ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>Accion terapeutica / uso</strong></td>
                        <td bgcolor="#FFFF99"><?php echo $familia2 ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>Fracciones </strong></td>
                        <td bgcolor="#FFFF99"><?php echo $factor ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#50ADEA" class="Estilo3 main1_text"><strong>SUCURSAL</strong></td>
                        <td bgcolor="#FFFF99" colspan="2"><?php echo $nomloc ?></td>
                    </tr>
                    <?php if ($drogueria == 1) { ?>
                        <tr>
                            <td bgcolor="#eaa35f" class="Estilo3 main1_text"><strong>STOCK ACTUAL</strong></td>
                            <td bgcolor="#FFFF99" colspan="2"><?php echo stockcaja($cant_loc1, $factor); ?></td>
                        </tr>
                        <tr>
                            <td bgcolor="#f2837c" class="Estilo3 main1_text"><strong>STOCK VENCIDO</strong></td>
                            <td bgcolor="#FFFF99" colspan="2"><?php echo stockcaja($stock_vencido, $factor); ?></td>
                        </tr>

                        <tr>
                            <td bgcolor="#a2ea5f" class="Estilo3 main1_text"><strong>STOCK DISPONIBLE</strong></td>
                            <td bgcolor="#FFFF99" colspan="2"><?php echo stockcaja($cant_loc, $factor); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>

            <!--desde aqui-->
            <td width="250" bgcolor="#50ADEA">
                <div class="Estilo3 main1_text">Informacion adicional</div>
            </td>
            <td width="400">
                <textarea style="background-color: #f9f8f8;" readonly name="textdesc" cols="30" rows="7" disable="disable" class="Estilodany" onChange="conmayus(this)"><?php echo $detpro ?>
                    </textarea>
            </td>
            <td width="200">
                <table width="230" border="0" cellpadding="0" cellspacing="0">
                    <tr height="54">
                        <td bgcolor="#50ADEA" class="text_prodstock"><strong>
                                <center>Costo promedio</center>
                            </strong></td>
                        <td bgcolor="#FFFF99" class="text_prodstock"><?php if($controleditable == 1){ echo '0.00'; }else{ echo $costpr; } ?></td>
                    </tr>
                    <tr height="54">
                        <td bgcolor="#50ADEA" class="text_prodstock"><strong>
                                <center>Ultimo costo</center>
                            </strong></td>
                        <td bgcolor="#FFFF99" class="text_prodstock" size="55"><?php if($controleditable == 1){ echo '0.00'; }else{ echo $costre; } ?></td>

                    </tr>


                </table>
            </td>
            <!--desde aqui-->
        </tr>

      
    </table>

    <table width="100%" border="0" class="tabla2" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="100%">
                <table width="100%" border="0" bgcolor="#CCFFCC" cellpadding="0" cellspacing="0" >
                    <tr bgcolor="#50ADEA">
                        <td align="center" class="EstiloT" colspan='21'>
                             STOCK EN SUCURSALES 
                        </td>
                    </tr>
                    <tr>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre1 == "") { ?>ALM<?php
                                                                        } else {
                                                                            echo $nombre1;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre2 == "") { ?>D01<?php
                                                                        } else {
                                                                            echo $nombre2;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre3 == "") { ?>D02<?php
                                                                        } else {
                                                                            echo $nombre3;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre4 == "") { ?>D03<?php
                                                                        } else {
                                                                            echo $nombre4;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre5 == "") { ?>D04<?php
                                                                        } else {
                                                                            echo $nombre5;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre6 == "") { ?>D05<?php
                                                                        } else {
                                                                            echo $nombre6;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre7 == "") { ?>D06<?php
                                                                        } else {
                                                                            echo $nombre7;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre8 == "") { ?>D07<?php
                                                                        } else {
                                                                            echo $nombre8;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre9 == "") { ?>D08<?php
                                                                        } else {
                                                                            echo $nombre9;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre10 == "") { ?>D09<?php
                                                                        } else {
                                                                            echo $nombre10;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre11 == "") { ?>D10<?php
                                                                        } else {
                                                                            echo $nombre11;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre12 == "") { ?>D11<?php
                                                                        } else {
                                                                            echo $nombre12;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre13 == "") { ?>D12<?php
                                                                        } else {
                                                                            echo $nombre13;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre14 == "") { ?>D13<?php
                                                                        } else {
                                                                            echo $nombre14;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre15 == "") { ?>D14<?php
                                                                        } else {
                                                                            echo $nombre15;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre16 == "") { ?>D15<?php
                                                                        } else {
                                                                            echo $nombre16;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre17 == "") { ?>D16<?php
                                                                        } else {
                                                                            echo $nombre17;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre18 == "") { ?>D17<?php
                                                                        } else {
                                                                            echo $nombre18;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre19 == "") { ?>D18<?php
                                                                        } else {
                                                                            echo $nombre19;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre20 == "") { ?>D19<?php
                                                                        } else {
                                                                            echo $nombre20;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                        <th style="font-size:10px" class="text_combo_select">
                            <div>
                                <strong><?php if ($nombre21 == "") { ?>D20<?php
                                                                        } else {
                                                                            echo $nombre21;
                                                                        }
                                                                            ?>
                                </strong>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s000, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s001, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s002, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s003, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s004, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s005, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s006, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s007, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s008, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s009, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s010, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s011, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s012, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s013, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s014, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s015, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s016, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s017, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s018, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s019, $factor); ?></div>
                        </td>
                        <td class="text_combo_select">
                            <div align="center"><?php echo stockcaja($s020, $factor); ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="customers">
        
         <tr bgcolor="#50ADEA">
            <td align="center" class="EstiloT" colspan='12'>
                <strong> VENTAS DE LOS ULTIMOS 12 MESES</strong>
            </td>
        </tr>
        
        <tr>
            <?php
    
            for($i=0;$i<=11;$i++){
                
            $mes= date("m",mktime(0,0,0,date("m")-$i,date("d"),date("Y"))) ;
            $ano= date("Y",mktime(0,0,0,date("m")-$i,date("d"),date("Y"))) ;
            setlocale(LC_ALL, 'es_ES');
            $monthNum  = $mes;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = strftime('%B', $dateObj->getTimestamp());

            echo '<th>' .strtoupper($monthName) .' - '.$ano. '</th>';
            }  
            
             
            ?>
        </tr>
        <tr>
             <?php
                                         
                                        
                                 
            for($i=0;$i<=11;$i++){
            $mes= date("m-Y",mktime(0,0,0,date("m")-$i,date("d"),date("Y"))) ;
            $dividido= explode('-', $mes, 2);
            $mes=$dividido[0];
            $ano=$dividido[1];
               $sumcol=0;    
              //$sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$mes' and year(invfec) = '$ano' and invtot <> '0' and estado = '0' and val_habil = '0' and codpro='' group by month(invfec),year(invfec)  ";
              $sql = "SELECT  DV.canpro,DV.factor,DV.fraccion FROM venta as V INNER JOIN detalle_venta as DV on DV.invnum=V.invnum where month(V.invfec) = '$mes' and year(V.invfec) = '$ano' and V.invtot <> '0' and V.estado = '0' and V.val_habil = '0' and DV.codpro='$cod'  ";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $canpro     = $row[0];
                            $factor     = $row[1];
                            $fraccion   = $row[2];
                                    
                            if($fraccion == "F"){
                                $cantidad= $canpro* $factor;
                            }else{
                                $cantidad= $canpro ;
                            }
                            $sumcol += $cantidad;
                                                
                        }
                        echo '<td>' . stockcaja($sumcol, $factor). '</td>';
                    }else{
                             echo '<td>' . stockcaja("0", $factor). '</td>';
                    }
          
            
            }  
            
             
            ?>
        </tr>
    </table>
   
    <table width="100%" border="0" class="tabla2" cellpadding="0" cellspacing="0">
        <tr>
            <td width="100%">
                <table width="100%" border="0" bgcolor="#50ADEA" cellpadding="0" cellspacing="0" id="customers">
                    <tr>
                        <td align="center" class="EstiloT">
                            <strong> PRODUCTOS SIMILARES</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <form name="form1" id="form1">
        <table width="100%" border="0" class="tabla2" cellpadding="0" cellspacing="0">
            <tr>
                <td>

                    <?php
                    $i = 1;

                    //    agrego costpr y costre  en la consulta



                    $sql = "SELECT codpro,desprod,codmar,codfam,factor,margene,costpr,costre,preuni,prelis,prevta,factor,incentivado,pcostouni,margene,$col_stock,preblister,blister FROM producto where codfam = '$codfam' order by $col_stock desc, incentivado desc";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                    ?>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">


                            <tr bgcolor="#50ADEA">
                                <th width="3%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">N</div>
                                    </div>
                                </th>
                                <th width="5%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">CODIGO</div>
                                    </div>
                                </th>
                                <th width="32%">
                                    <div align="left" class="Estilo2">
                                        <div align="left">PRODUCTO</div>
                                    </div>
                                </th>
                                <th width="15%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">LABORATORIO</div>
                                    </div>
                                </th>
                                <th width="7%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">PRECIO REF</div>
                                    </div>
                                </th>
                                <th width="7%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">DCTOS</div>
                                    </div>
                                </th>
                                <th width="7%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">PRECIO BLISTER</div>
                                    </div>
                                </th>
                                <th width="7%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">PRECIO CAJA</div>
                                    </div>
                                </th>
                                <th width="7%">
                                    <div align="center" class="Estilo2">
                                        <div align="center">PRECIO UNID</div>
                                    </div>
                                </th>
                                <th width="10%">
                                    <div class="Estilo2">
                                        <div align="center">STOCK U.</div>
                                    </div>
                                </th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $codigo = $row['codpro'];
                                $desprod = $row['desprod'];
                                $codmar = $row['codmar'];
                                $codfam = $row['codfam'];
                                $factor = $row['factor'];
                                $incentivado = $row['incentivado'];
                                $cant_loc = $row[15];

                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                    $margene = $row['margene'];
                                    $costpr = $row['costpr'];   //este agregue nuevo
                                    $costre = $row['costre']; //este agregue nuevo
                                    $referencial = $row['prelis'];
                                    $prevta = $row['prevta'];
                                    $preuni = $row['preuni'];
                                    $pcostouni = $row['pcostouni'];
                                    $preblister = $row['preblister'];
                                    $blister = $row['blister'];
                                } elseif ($precios_por_local == 0) {
                                    $margene = $row['margene'];
                                    $costpr = $row['costpr'];   //este agregue nuevo
                                    $costre = $row['costre']; //este agregue nuevo
                                    $referencial = $row['prelis'];
                                    $prevta = $row['prevta'];
                                    $preuni = $row['preuni'];
                                    $pcostouni = $row['pcostouni'];
                                    $preblister = $row['preblister'];
                                    $blister = $row['blister'];
                                }


                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $margene_p,$costpr_p,$costre_p,$prelis_p,$prevta_p,$preuni_p,$pcostouni_p,$preblister_p,$blister_p        FROM precios_por_local where codpro = '$codigo'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $margene = $row_precio[0];
                                            $costpr = $row_precio[1];   //este agregue nuevo
                                            $costre = $row_precio[2]; //este agregue nuevo
                                            $referencial = $row_precio[3];
                                            $prevta = $row_precio[4];
                                            $preuni = $row_precio[5];
                                            $pcostouni = $row_precio[6];
                                            $preblister = $row_precio[7];
                                            $blister = $row_precio[8];
                                        }
                                    }
                                }

                                if (($referencial <> 0) and ($referencial <> $prevta)) {
                                    $margenes = ($margene / 100) + 1;
                                    $precio_ref = $referencial;
                                    //$precio_ref     = $referencial / $factor;
                                    //$precio_ref     = $referencial * $factor;
                                    $precio_ref = $precio_ref * $margenes;
                                    $precio_ref = number_format($precio_ref, 2, '.', ',');
                                    $desc1 = $precio_ref - $preuni;
                                    if ($desc1 < 0) {
                                        $descuento = 0;
                                    } else {
                                        if ($precio_ref <= 0) {
                                            $descuento = 0;
                                        } else {
                                            $descuento = (($precio_ref - $preuni) / $precio_ref) * 100;
                                        }
                                    }
                                } else {
                                    $precio_ref = $preuni;
                                    $descuento = 0;
                                }
                                $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $ltdgen = $row1['ltdgen'];
                                    }
                                }
                                $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $marca = $row1['destab'];
                                        $marca1 = $row1['abrev'];
                                    }
                                }
                                if (($incentivado == 1) and ($cant_loc > 0)) {
                                    $color = 'prodincent';
                                    $text = 'text_prodincent';
                                } else {
                                    if ($cant_loc > 0) {
                                        $color = 'prodnormal';
                                        $text = 'text_prodnormal';
                                    } else {
                                        $color = 'prodstock';
                                        $text = 'text_prodstock';
                                    }
                                }
                            ?>
                                <tr onmouseover="this.style.backgroundColor = '#FFFF99';
                                                    this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                    <td><span class="<?php echo $text ?>"><?php echo ++$i; ?>-</span></td>
                                    <td class="<?php echo $text; ?>">
                                        <?php if ($codigo == $cod) { ?>
                                            <b><?php echo $codigo; ?></b>
                                        <?php
                                        } else {
                                            echo $codigo;
                                        }
                                        ?>
                                    </td>
                                    <td title="<?php echo $incentivado; ?>">
                                        <a id="l1" href="javascript:cerrar_popup(<?php echo $codigo ?>)">
                                            <?php if ($codigo == $cod) { ?>
                                                <b><?php echo $desprod ?></b>
                                            <?php
                                            } else {
                                                echo $desprod;
                                            }
                                            ?>
                                        </a>
                                    </td>
                                    <td title="<?php echo $marca; ?>" align="center">
                                        <span class="<?php echo $text ?>">
                                            <b><?php
                                                if ($marca1 == "") {
                                                    echo substr($marca, 0, 5);
                                                    echo "...";
                                                } else {
                                                    echo substr($marca1, 0, 5);
                                                    echo "...";
                                                }
                                                ?></b>
                                        </span>
                                    </td>
                                    <td>
                                        <div align="center"><span class="<?php echo $text ?>"><b><?php echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' '); ?></span></div>
                                    </td>
                                    <td>
                                        <div align="center"><span class="<?php echo $text ?>"><b><?php echo $numero_formato_frances = number_format($descuento, 0, '.', ' '); ?>%</b></span></div>
                                    </td>

                                    <td title=" A partir de &nbsp;<?php echo $pblister; ?>&nbsp;und &nbsp;el precio es <?php echo $preblister; ?>">

                                        <div align="center" class="<?php echo $text ?>"><?php echo $blister . "<b style='color:red;'>&nbsp;>&nbsp;</b>" . $preblister; ?> </div>

                                    </td>
                                    <td>
                                        <div align="center"><span class="<?php echo $text ?>"><b><?php echo $prevta ?></b></span></div>
                                    </td>
                                    <td>
                                        <div align="center"><span class="<?php echo $text ?>"><b><?php echo $preuni ?></b></span></div>
                                    </td>
                                    <td>
                                        <div align="center">
                                            <span class="<?php echo $text ?>">
                                                <?php if ($codigo == $cod) { ?>
                                                    <b><?php echo stockcaja($cant_loc, $factor); ?></b>
                                                <?php
                                                } else {
                                                    echo stockcaja($cant_loc, $factor);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    <?php }
                    ?>
                </td>
            </tr>
        </table>
    </form>
    <?php
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_close($conexion);
    ?>
</body>

</html>