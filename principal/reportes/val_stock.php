<?php include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../iconoNew.ico" />
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
    <script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js"></script>
    <style>
        #table-wrapper {
            position: relative;
        }

        #table-scroll {
            height: 450px;
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

        .select2-container .select2-selection--single {
            height: 20px
        }
    </style>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#marca1').select2();
            $('#marca2').select2();
            $('#local').select2();
        });

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../index.php";
            f.submit();
        }
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
$ispost = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ispost = 1;
    $report = $_REQUEST['report'];
    $local = $_REQUEST['local'];
    $marca1 = $_REQUEST['marca1'];
    $marca2 = $_REQUEST['marca2'];
    $detalle = $_REQUEST['detalle'];
}

if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}

$sql = "SELECT export,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
        $user = $row['nomusu'];
    }
}
$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
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
<script>
    function verDetalle(marca) {
        window.open('val_stock_detalle.php?marca=' + marca + "&local=" + <?php echo "'$local'" ?>, 'Detalle', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=100,left=120,width=1050,height=450');
    }
</script>

<body>
    <div class="tabla1">
          <!-- <script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script> -->
        <div class="title1">


            <table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="titulos">REPORTE DE VALORIZACIÓN DE STOCK</span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
            </table>
        </div>
        <div class="mask1111 myDivToPrint">
            <div class="mask2222">
                <div class="mask3333" width="100%" height="600" scrolling="Automatic">
                    <table width="100%" border="0">
                        <tr>
                            <td><b><u>REPORTE DE VALORIZACIÓN DE STOCK </u></b>
                                <form id="form1" name="form1" method="post" action="">
                                    <table width="100%" border="0" class="tablarepor">
                                        <tr>
                                            <td width="81" class="LETRA">SALIDA</td>
                                            <td width="158">
                                                <select name="report" id="report">
                                                    <option value="1" <?php if ($report == 1) echo 'selected' ?>>POR PANTALLA</option>
                                                    <?php if ($export == 1) { ?>
                                                        <option value="2" <?php if ($report == 2) echo 'selected' ?>>EN ARCHIVO XLS</option>
                                                    <?php } ?>
                                                    <option value="3" <?php if ($report == 3) echo 'selected' ?>>IMPRIMIR</option>
                                                </select>
                                            </td>
                                            <td width="39" class="LETRA" align="right">LOCAL</td>
                                            <td width="100"><select style="width:150px" name="local" id="local">
                                                    <?php
                                                    if ($nombre_local == 'LOCAL0') {
                                                        $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                                        echo '<option value="all" ';
                                                        if ($loc == $local) {
                                                            echo 'selected';
                                                        };
                                                        echo '>TODOS LOS LOCALES</option>';
                                                    } else {
                                                        $sql = "SELECT * FROM xcompa where codloc = '$codigo_local'";
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
                                                        <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td width="39" class="LETRA" align="right">DETALLE</td>
                                            <td width="100">
                                                <select name="detalle" id="detalle">
                                                    <option value="det" <?php
                                                                        if ($detalle == 'det') {
                                                                            echo 'selected';
                                                                        }
                                                                        ?>>DETALLADA</option>
                                                    <option value="res" <?php
                                                                        if ($detalle == 'res') {
                                                                            echo 'selected';
                                                                        }
                                                                        ?>>RESUMIDA</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="40" class="LETRA">MARCA DESDE</td>
                                            <td width="160">
                                                <select name="marca1" id="marca1">
                                                    <?php
                                                    foreach ($marcasArr as $codmarca => $marca) {
                                                    ?>
                                                        <option value="<?php echo $codmarca; ?>" <?php if ($codmarca == $marca1) { ?> selected="selected" <?php } ?>><?php echo $marca; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="40" class="LETRA" align="right">HASTA</td>
                                            <td width="160" colspan="3">
                                                <select name="marca2" id="marca2">
                                                    <?php
                                                    foreach ($marcasArr as $codmarca => $marca) {
                                                    ?>
                                                        <option value="<?php echo $codmarca; ?>" <?php if ($codmarca == $marca2) { ?> selected="selected" <?php } ?>><?php echo $marca ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td width="100">
                                                <input name="val" type="hidden" id="val" value="1" />
                                                <input type="Submit" name="Submit" value="Buscar" class="buscar" />
                                                <input type="button" name="Submit" value="Salir" class="salir" onclick="salir()" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                            </td>
                        </tr>
                    </table>
                    <div id="table-wrapper" <?php
                                            if ($report != 1) {
                                                echo 'style="display:none"';
                                            }
                                            ?>>
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="134"><strong><?php echo $desemp ?></strong></td>
                                            <td width="30"></td>
                                            <td width="230"><strong>REPORTE DE VALORIZACIÓN DE STOCK </strong></td>

                                            <td width="284" colspan="3">
                                                <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                                            </td>
                                        </tr>

                                    </table>
                                    <table width="100%" border="0">
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
                                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                                </td>
                            </tr>
                        </table>
                        <div id="table-scroll">
                            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" scrolling="Automatic">
                                <thead>
                                    <tr>
                                        <?php if ($detalle == 'det') { ?>
                                            <th width="20"><strong>N&ordm;</strong></th>
                                            <th width="20">
                                                <div align="center"><strong>COD.PRO.</strong></div>
                                            </th>
                                            <th width="550">
                                                <div align="center"><strong>PRODUCTO</strong></div>
                                            </th>
                                            <th width="20">
                                                <div align="center"><strong>LAB.</strong></div>
                                            </th>
                                            
                                            <th width="45">
                                            <div align="center"><strong>COSTO UNITARIO</strong></div>
                                        </th>
                                        <?php } else { ?>
                                            <th width="20"><strong>Abrev</strong></th>


                                            <th width="300">
                                                <div align="center"><strong>LAB.</strong></div>
                                            </th>
                                        <?php } ?>
                                        
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
                                <?php
                                if ($ispost == 1) {
                                ?>
                                    <tbody>
                                        <?php
                                        $nomMarca1 = $marcasArr[$marca1];
                                        $nomMarca2 = $marcasArr[$marca2];
                                        if ($local == 'all') {
                                            $stockCol = 'p.stopro';
                                        } else {
                                            $stockCol = 'p.s' . str_pad($local - 1, 3, '0', STR_PAD_LEFT) . '';
                                        }
                                        if ($detalle == 'det') {
                                            $sql = "select codpro, desprod, concat(tm.destab, '(', abrev,')') as lab, abrev, 
												$stockCol stock,  tm.destab,
												p.factor,
												costpr*$stockCol/factor costpro, costre*$stockCol/factor costre, prevta*$stockCol/factor prevta,
												p.codmar
												from producto p, titultabladet tm 
												where tm.codtab = p.codmar 
												and tm.destab between '$nomMarca1' and '$nomMarca2'
												order by tm.destab, p.desprod asc";
                                        } else {
                                            $sql = "select concat(tm.destab, '(', abrev,')') as lab, abrev, 
												SUM($stockCol) stock,  tm.destab,
												SUM(costpr*$stockCol/factor) costpro, SUM(costre*$stockCol/factor) costre, SUM(prevta*$stockCol/factor) prevta,
												p.codmar											
												from producto p, titultabladet tm 
												where tm.codtab = p.codmar 
												and tm.destab between '$nomMarca1' and '$nomMarca2'
												group by lab, abrev
												order by tm.destab, p.desprod asc";
                                            //echo $sql;
                                        }

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
                                                $costpr1 = $row['costpro'];
                                                $costre1 = $row['costre'];
                                                $prevta1 = $row['prevta'];

                                                $desMarca = $row['destab'];
                                                $codmar = $row['codmar'];
                                                
                                                

                                               // $costpro =  $costpr1 * $stopro / $factor;
                                                $costpro =  $costpr1;
                                                //$costre = $costre1 * $stopro / $factor;
                                                $costre = $costre1  ;
                                                //$prevta = $prevta1 * $stopro / $factor;
                                                $prevta = $prevta1 ;


                                                $sql2 = "SELECT costre from producto WHERE codpro='$codpro' ";
                                                $result2 = mysqli_query($conexion, $sql2);
                                                if (mysqli_num_rows($result2)) {
                                                    while ($row2 = mysqli_fetch_array($result2)) {
                                                        $costre2 = $row2['costre'];
                                                    }
                                                }

                                                if ($factor > 1) {
                                                    $convert = $stopro / $factor;
                                                    $div = floor($convert);
                                                    $mult = $factor * $div;
                                                    $tot = $stopro - $mult;
                                                } else {

                                                    $convert = $stopro;
                                                    $div = floor($convert);
                                                    $mult = $factor * $div;
                                                    $tot = $stopro - $mult;
                                                }
                                                if ($i != 0 && $labAnt != $lab && $detalle == 'det') {
                                        ?>
                                                    <tr>
                                                        <td colspan="<?php
                                                                        if ($detalle == 'det') {
                                                                            echo '5';
                                                                        } else {
                                                                            echo '3';
                                                                        }
                                                                        ?>" width="32" align="right"><b>Total <?php echo $labAnt ?>:</b></td>
                                                        <!-- <td width="32" align="right"><b><?php echo number_format($stockTotalGen, 2) ?></b></td>
                                                        <td width="32" align="right"><b><?php echo number_format($costproTotalGen, 2) ?></b></td>
                                                        <td width="32" align="right"><b><?php echo number_format($costreTotalGen, 2) ?></b></td>
                                                        <td width="32" align="right"><b><?php echo number_format($prevtaTotalGen, 2) ?></b></td> -->

                                                        <td width="32" align="right"><b><?php echo number_format($stockTotal, 2) ?></b></td>
                                                            <td width="32" align="right"><b><?php echo number_format($costproTotal, 2) ?></b></td>
                                                            <td width="32" align="right"><b><?php echo number_format($costreTotal, 2) ?></b></td>
                                                            <td width="32" align="right"><b><?php echo number_format($prevtaTotal, 2) ?></b></td>
                                                    </tr>
                                                <?php
                                                    $labAnt = $lab;
                                                    $stockTotal = 0;
                                                    $costproTotal = 0;
                                                    $costreTotal = 0;
                                                    $prevtaTotal = 0;
                                                    
                                                    
                                                } else if ($i == 0) {
                                                    $labAnt = $lab;
                                                     
                                                }

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
                                                    <?php if ($detalle == 'det') { ?>
                                                        <td width="20" style="border:0;padding-left:5px"><?php echo $i ?></td>
                                                        <td width="20" style="border:0"><?php echo $codpro ?></td>
                                                        <td width="550" style="border:0"><?php echo $producto ?></td>
                                                        <td width="20" style="border:0"><?php echo $abrev ?></td>
                                                        <td width="20" align="CENTER" style="border:0"><?php echo number_format($costre2, 2) ?></td>
                                                        <td width="45" align="right" style="border:0"><?php echo $div . ' F ' . $tot ?></td>
                                                    <?php } else { ?>
                                                        <td width="20" style="border:0"><a href="#" onclick="return verDetalle(<?php echo $codmar ?>);"><?php echo $abrev ?></a></td>
                                                        <td width="300" style="border:0"><a href="#" onclick="return verDetalle(<?php echo $codmar ?>);"><?php echo $desMarca ?></a></td>
                                                        <td width="45" align="right" style="border:0"><?php echo $stopro ?></td>
                                                    <?php } ?>

                                                    <td width="32" align="right" style="border:0"><?php echo number_format($costpro, 2) ?></td>
                                                    <td width="32" align="right" style="border:0"><?php echo  number_format($costre, 2);?></td>
                                                    <td width="32" align="right" style="border:0"><?php echo number_format($prevta, 2) ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($detalle == 'det') { ?>
                                                <tr>
                                                    <td colspan="<?php
                                                                    if ($detalle == 'det') {
                                                                        echo '5';
                                                                    } else {
                                                                        echo '3';
                                                                    }
                                                                    ?>" width="32" align="right"><b>Total <?php echo $labAnt ?>:</b></td>
                                                    <td width="32" align="right"><b><?php echo number_format($stockTotal, 2) ?></b></td>
                                                    <td width="32" align="right"><b><?php echo number_format($costproTotal, 2) ?></b></td>
                                                    <td width="32" align="right"><b><?php echo number_format($costreTotal, 2) ?></b></td>
                                                    <td width="32" align="right"><b><?php echo number_format($prevtaTotal, 2) ?></b></td>
                                                </tr>
                                            <?php } ?>
                                            <tr style="font-size:13px;font-weight:boldest;background-color:#ddddff">
                                                <td colspan="<?php
                                                                if ($detalle == 'det') {
                                                                    echo '5';
                                                                } else {
                                                                    echo '3';
                                                                }
                                                                ?>" width="32" align="left" style="font-size:15px"><b>Total General:</b></td>
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
                                <?php
                                } else {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td colspan="8" align="center">Haga click en Buscar para generar reporte</td>
                                        </tr>
                                    </tbody>
                                <?php
                                }
                                ?>
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
<?php if ($report == 3) { ?>
    <script>
        var mywindow = window.open('', 'PRINT', 'height=650,width=650');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title + '</h1>');
        mywindow.document.write(document.getElementById('table-wrapper').innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();
    </script>
<?php } elseif ($report == 2) { ?>
    <script>
        var tableToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body>{table}</body></html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    })
                }
            return function(table, name, filename) {
                if (!table.nodeType)
                    table = document.getElementById(table)
                var ctx = {
                    worksheet: name || 'Worksheet',
                    table: table.innerHTML
                }
                //window.location.href = uri + base64(format(template, ctx));
                //window.location.download = filename;
                document.getElementById("dlink").href = uri + base64(format(template, ctx));
                document.getElementById("dlink").download = filename;
                document.getElementById("dlink").click();
            }
        })()

        tableToExcel('table-wrapper', 'SIST_EXPORT_DATA', '.xls');
        /*var a = document.body.appendChild(
         document.createElement("a")
         );
         a.download = "SIST_EXPORT_DATA.xls";
         a.href = "data:text/html," + '<html><body><div width="1800">' +
         '<table width="930" border="0" align="center"><tr><td>' + document.getElementById("table-wrapper").innerHTML + '</td></tr></table></div></body></html>'; // Grab the HTML
         a.click(); // Trigger a click on the element*/
    </script>
<?php } ?>