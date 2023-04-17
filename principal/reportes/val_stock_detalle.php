<?php
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title><?php echo $desemp ?></title>
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../titulo_sist.php');
    ?>
    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES 
    ?>
    <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL  
    ?>
    <style>
        #table-wrapper {
            position: relative;
        }

        #table-scroll {
            height: 350px;
            overflow: auto;
        }

        #table-wrapper table {
            width: 95%;

        }

        #table-wrapper table * {
            color: black;
        }

        #table-wrapper table thead th .text {
            position: absolute;
            top: -20px;
            z-index: 2;
            height: 20px;
        }
    </style>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>
    <script>
        function salir() {}
    </script>
</head>
<?php
//////////////////////////////////
$hour = date('G');
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$date = date("Y-m-d");

$local = $_REQUEST['local'];
$marca = $_REQUEST['marca'];

if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}

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




$sql = "SELECT export,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
        $user = $row['nomusu'];
    }
}

$sqlMarcas = "SELECT td.codtab,td.destab, td.abrev 
	FROM titultabladet td, titultabla tt 
	where td.tiptab = tt.ltdgen and tt.dsgen='MARCA'
	order by td.destab asc";
$resultMarcas = mysqli_query($conexion, $sqlMarcas);
$marcasArr = array();
while ($rowMarcas = mysqli_fetch_array($resultMarcas)) {
    $codtab = $rowMarcas["codtab"];
    $destab = $rowMarcas["destab"];
    $marcasArr[$codtab] = $destab;
}
?>

<body>
    <div class="tabla1">
        <div class="title1">
            <span class="titulos">SISTEMA DE VENTAS - REPORTE DE VALORIZACIÓN DE STOCK
            </span>
        </div>
        <div class="mask1111 myDivToPrint">
            <div class="mask2222">
                <div class="mask3333" width="730" height="400" scrolling="Automatic">
                    <div id="table-wrapper">
                        <table width="720" border="0" align="center">
                            <tr>
                                <td>
                                    <table width="720" border="0">
                                        <tr>
                                            <td width="134"><strong><?php echo $desemp ?></strong></td>
                                            <td width="30"></td>
                                            <td width="230"><strong>REPORTE DE VALORIZACIÓN DE STOCK </strong></td>

                                            <td width="284" colspan="3">
                                                <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                                            </td>
                                        </tr>

                                    </table>
                                    <table width="720" border="0">
                                        <tr>
                                            <td width="134"></td>
                                            <td width="30"></td>
                                            <td width="230">
                                                <div align="center"><b><?php
                                                                        if ($local == 'all') {
                                                                            echo 'TODOS LOS LOCALES';
                                                                        } else {
                                                                            echo $nomloc;
                                                                        }
                                                                        ?></b></div>
                                            </td>
                                            <td width="133" colspan="3">
                                                <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div align="center"><img src="../../images/line2.png" width="720" height="4" /></div>
                                </td>
                            </tr>
                        </table>
                        <div id="table-scroll">
                            <table width="720" border="1" align="center" cellpadding="0" cellspacing="0" scrolling="Automatic">
                                <thead>
                                    <tr>
                                        <th width="20"><strong>N&ordm;</strong></th>
                                        <th width="20">
                                            <div align="center"><strong>COD.PRO.</strong></div>
                                        </th>
                                        <th width="400">
                                            <div align="center"><strong>PRODUCTO</strong></div>
                                        </th>
                                        <th width="20">
                                            <div align="center"><strong>LAB.</strong></div>
                                        </th>
                                        <th width="45">
                                            <div align="center"><strong>STOCK</strong></div>
                                        </th>
                                        <th width="32">
                                            <div align="center"><strong>COSTO PROMEDIO</strong></div>
                                        </th>
                                        <th width="32">
                                            <div align="center"><strong>COSTO REPOSICION</strong></div>
                                        </th>
                                        <th width="32">
                                            <div align="center"><strong>PRECIO VENTA</strong></div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($local == 'all') {
                                        $stockCol = 'p.stopro';
                                    } else {
                                        $stockCol = 'p.s' . str_pad($local - 1, 3, '0', STR_PAD_LEFT) . '';
                                    }
                                    $sql = "select codpro, desprod, concat(tm.destab, '(', abrev,')') lab, abrev, 
												$stockCol stock,  tm.destab,
												p.factor,
												costpr*$stockCol/factor costpro, costre*$stockCol/factor costre, prevta*$stockCol/factor prevta
												from producto p, titultabladet tm 
												where tm.codtab = p.codmar 
												and p.codmar = '$marca' and eliminado='0'
												order by tm.destab, p.desprod asc";

                                    //echo $sql;
                                    $result = mysqli_query($conexion, $sql);
                                    $i = 0;
                                    $labAnt = '';
                                    $stockTotal = 0;
                                    $costproTotal = 0;
                                    $costreTotal = 0;
                                    $prevtaTotal = 0;

                                    $stockTotalGen = 0;
                                    $costproTotalGen = 0;
                                    $costreTotalGen = 0;
                                    $prevtaTotalGen = 0;

                                    if (mysqli_num_rows($result)) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $producto = $row['desprod'];
                                            $lab = $row['lab'];
                                            $codpro = $row['codpro'];
                                            $stopro = $row['stock'];
                                            if ($stopro <= 0) {
                                                continue;
                                            }
                                            $factor = $row['factor'];
                                            $abrev = $row['abrev'];
                                            $costpro = $row['costpro'];
                                            $costre = $row['costre'];
                                            $prevta = $row['prevta'];
                                            $desMarca = $row['destab'];



                                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                                                $costpr1 = $row['costpr'];
                                                $costre1 = $row['costre'];
                                                $prevta1 = $row['prevta'];
                                            } elseif ($precios_por_local == 0) {

                                                $costpr1 = $row['costpr'];
                                                $costre1 = $row['costre'];
                                                $prevta1 = $row['prevta'];
                                            }

                                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                                $sql_precio = "SELECT $costpr_p,$costre_p,$prevta_p  FROM precios_por_local where codpro = '$codpro'";
                                                $result_precio = mysqli_query($conexion, $sql_precio);
                                                if (mysqli_num_rows($result_precio)) {
                                                    while ($row_precio = mysqli_fetch_array($result_precio)) {

                                                        $costpr1 = $row_precio[0];
                                                        $costre1 = $row_precio[1];
                                                        $prevta1 = $row_precio[2];
                                                    }
                                                }
                                            }





                                            $costpro = $costpr1 * $stopro / $factor;
                                            $costre = $costre1 * $stopro / $factor;
                                            $prevta = $prevta1 * $stopro / $factor;

                                            $convert = $stopro / $factor;
                                            $div = floor($convert);
                                            $mult = $factor * $div;
                                            $tot = $stopro - $mult;

                                            $labAnt = $lab;
                                            $stockTotal = 0;
                                            $costproTotal = 0;
                                            $costreTotal = 0;
                                            $prevtaTotal = 0;
                                            $stockTotal += $stopro;
                                            $costproTotal += $costpro;
                                            $costreTotal += $costre;
                                            $prevtaTotal += $prevta;

                                            $stockTotalGen += $stopro;
                                            $costproTotalGen += $costpro;
                                            $costreTotalGen += $costre;
                                            $prevtaTotalGen += $prevta;
                                            $i++;
                                    ?>
                                            <tr style="border:0">
                                                <td width="20" style="border:0;padding-left:5px"><?php echo $i ?></td>
                                                <td width="20" style="border:0"><?php echo $codpro ?></td>
                                                <td width="400" style="border:0"><?php echo $producto ?></td>
                                                <td width="20" style="border:0"><?php echo $abrev ?></td>
                                                <td width="45" align="right" style="border:0"><?php echo $div . ' F ' . $tot ?></td>
                                                <td width="32" align="right" style="border:0"><?php echo number_format($costpro, 2) ?></td>
                                                <td width="32" align="right" style="border:0"><?php echo number_format($costre, 2) ?></td>
                                                <td width="32" align="right" style="border:0"><?php echo number_format($prevta, 2) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr style="font-size:13px;font-weight:boldest;background-color:#ddddff">
                                            <td colspan="4" width="32" align="left" style="font-size:15px"><b>Total General:</b></td>
                                            <td width="32" align="right"><b><?php echo number_format($stockTotalGen, 2) ?></b></td>
                                            <td width="32" align="right"><b><?php echo number_format($costproTotalGen, 2) ?></b></td>
                                            <td width="32" align="right"><b><?php echo number_format($costreTotalGen, 2) ?></b></td>
                                            <td width="32" align="right"><b><?php echo number_format($prevtaTotalGen, 2) ?></b></td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="8" align="center">No se logró encontrar informacion con los datos ingresados</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a id="dlink" style="display:none;"></a>
</body>

</html>