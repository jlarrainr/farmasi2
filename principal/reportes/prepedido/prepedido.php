<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
require_once("../local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";

    $str = preg_replace($legalChars, "", $str);
    return $str;
}

$idpreped = isset($_REQUEST['idpreped']) ? ($_REQUEST['idpreped']) : "";
$numpagina = isset($_REQUEST['numpagina']) ? ($_REQUEST['numpagina']) : "";



//echo '$numpagina = '.$numpagina."<br>";

if($numpagina <>''){
$sqlpagina = "SELECT * FROM prepedido where idpreped = $numpagina and estado=0";

//echo '$sqlpagina = '.$sqlpagina."<br>";



            $result1pagina = mysqli_query($conexion, $sqlpagina);
            if (mysqli_num_rows($result1pagina)) {
                $encuentra=1;
            }else{
                $encuentra=0;
            }
            
}
            
            
$idpreped=$numpagina;
//echo '$numpagina = '.$numpagina."<br>";
//echo '$idpreped = '.$idpreped."<br>";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['text'])) {
        $text = $_POST['text'];

        $pasa = 0;
        foreach ($text as $key => $n) {


//echo '$key = '.$key."<br>";
//echo '$idpreped = '. $idpreped."<br>";
            $sql1 = "SELECT idprod,fraccion,factor FROM detalle_prepedido where iddetalle = $key";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $idprod = $row1['idprod'];
                    $fraccion = $row1['fraccion'];
                    //  $control = $row1['control'];
                    $factor = $row1['factor'];
                }
            }
            $sqlpagina2 = "SELECT s000 FROM producto where  codpro = $idprod";
            $result1pagina2 = mysqli_query($conexion, $sqlpagina2);
            if (mysqli_num_rows($result1pagina2)) {
                while ($row12 = mysqli_fetch_array($result1pagina2)) {
                    $control = $row12[0];
                }
            }
            $sqlpagina = "SELECT idprepedido FROM detalle_prepedido where iddetalle = $key";
            $result1pagina = mysqli_query($conexion, $sqlpagina);
            if (mysqli_num_rows($result1pagina)) {
                while ($row1 = mysqli_fetch_array($result1pagina)) {
                    $numpagina22222 = $row1['idprepedido'];
                    $idpreped = $row1['idprepedido'];
                }
            }

            $string = $n;
            $letra = $string[0];
            if ($letra == 'F') {
                $ncontrolx = substr($n, 1);
                $control_remplazo = 'F' . $control;
            } else {
                $ncontrolx = $n * $factor;
                $control_remplazo = $control / $factor;
            }
            //if(($ncontrolx <> 0)&&($ncontrolx <>'')){

            // if (($ncontrolx <= $control)) {

            $sql = "UPDATE detalle_prepedido DP SET solicitado='$n' WHERE DP.idprepedido = '$idpreped' AND DP.iddetalle='$key'";
            $result = mysqli_query($conexion, $sql);
            // } else {
            //     $sql2 = "UPDATE detalle_prepedido DP SET solicitado='$control_remplazo' WHERE DP.idprepedido = '$idpreped' AND DP.iddetalle='$key'";
            //     $result = mysqli_query($conexion, $sql2);
            // }


            //}
        }
    }
}
if ($numpagina22222 <> "") {
    //echo '$numpagina22222 = '.$numpagina22222."<br>";
    $numpagina = $numpagina22222;
    $idpreped = $numpagina22222;
     $encuentra=1;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

        
          #tabDetalle {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;

            }

            #tabDetalle td, #tabDetalle th {
                border: 1px solid #ddd;
                padding: 3px;

            }
            #tabDetalle td a{
                color: #4d9ff7;
                font-weight: bold;
                font-size:15px;
                text-decoration: none;

            }
            
            #tabDetalle #total {

                text-align: center;
                background-color: #9ebcc1;
                color: white;
                font-size:16px;
                font-weight: 900;
            }
            
            #tabDetalle tr:nth-child(even){background-color: #f0ecec;}

            #tabDetalle tr:hover {background-color: #ddd;}

            #tabDetalle th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size:12px;
                font-weight: 900;
            }

        input {

            border: 1px solid #ccc;
            border-radius: 4px;

            background-color: white;
            background-position: 3px 3px;


        }

        table.tabla2x {
            color: #404040;
            background-color: #ffffff;
            border: 1px #CDCDCD solid;
            border-collapse: collapse;
            border-spacing: 1px;
        }

        table.tabla2x .th {
            background-color: #f6f1f1;
        }
        
        .tablarepor {
             
  border: 1px solid black;
                        border-collapse: collapse;
                        
}
.tablarepor tr{
    
    background: #ececec;
}
    </style>
    <script language="JavaScript">
        function buscarFunc() {
            var f = document.form1;
            if (f.numpagina.value == "") {
                alert("Ingrese un nÃÂºmero de prepedido");
                f.numpagina.focus();
                return;
            }
            f.submit();
        }

        function buscarOption() {
            var f = document.form1;
            f.numpagina.value = f.option.value
            f.submit();
        }

        function salirFunc() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function printerFunc() {
            window.open('prepedido_imp.php?idpreped=<?php echo $idpreped; ?>&numpagina=<?php echo $numpagina; ?>');
        }

        function printerFunc2() {
            var table = document.getElementById("tabDetalle");
            for (var i = 1, row; row = table.rows[i]; i++) {
                //for (var j = 0, col; col = row.cells[j]; j++) {
                //     console.log(col);
                var content = row.cells[6].children[0].value;
                if (content <= 0) {
                    row.classList.add("no-print");
                } else {
                    row.classList.remove("no-print");
                }

                //}  
            }
            window.print(document.form1.resultado);
        }

        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }

        function actualizar() {
            confirm("EL PREPEDIDO A SIDO ACTUALIZADO");
            var f = document.form2;
            f.method = "POST";
            f.submit();
        }

        function addProducto(idpreped, numpagina) {
            window.open('addProducto.php?idpreped=' + idpreped + '&numpagina=' + numpagina, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,,left=80,width=1205,height=500');
        }

        var nav4 = window.Event ? true : false;

        function ent2(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {



                var f = document.form2;
                f.method = "POST";
                f.submit();
            }
            //                return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
            return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
        }


        var nav4 = window.Event ? true : false;

        function ent(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {



                var f = document.form2;
                f.method = "POST";
                f.submit();
            }

            return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
        }



        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
    </script>
    <title><?php echo $desemp ?></title>

    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />

    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    
    <!--<link href="..'/../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
    -->
    
    
    
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    
    
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS  
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
    <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES    
    ?>
    <!--<link href="../../select2/css/select2.min.css" rel="stylesheet" />
                       <script src="../../select2/jquery-3.4.1.js"></script>
                       <script src="../../select2/js/select2.min.js"></script>-->


</head>

<body>
    <div class="tabla1" style="height: 100%;">
        <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>

        <div class="title1" style="height:auto;">
            <!--                <span class="titulos">SISTEMA DE VENTAS - PREPEDIDO
            </span>
                -->
            <table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="titulos">PREPEDIDO</span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/uploads/2018/12/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: #e74b3b;font-weight: 900;font-size: 20px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
                <?php


                /* if (($vacio == 1) || ( $pasa == 2)) { ?>
                        <script>
                //alertify.error("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo "La cantidad es incorrecta"; ?></p>");
                        </script>
                        <?php
                    }*/
                if ($pasa == 1) {
                ?>
                    <script>
                        //   alertify.success("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo "Se registro con Exito"; ?></p>");
                    </script>
                <?php } ?>

            </table>
        </div>
        <div class="mask1111" style="height: 100%;width:100%" >
            <div class="mask2222" style="height: 100%;width:100%">
                <div class="mask3333" style="height: 100%;width:100%">
                    <table width="100%" border="0">
                        <tr>
                            <td>
                                <form id="form1" name="form1" method="post" action="">
                                    <fieldset style="colo">
                                        <legend> <strong>BUSQUEDA DE PREPEDIDO</strong></legend>
                                        <table width="100%" border="0" class="tablarepor">
                                            <tr>
                                                <td width="119"><b>CODIGO</b></td>
                                                <td width="98">
                                                    <input type="text" name="numpagina" id="numpagina" size="12" value="<?php echo $numpagina; ?>">
                                                </td>

                                                <td width="400" align="center" rowspan="2">
                                                    <input type="button" name="buscar" value="Buscar" onclick="buscarFunc()" class="buscar" />
                                                    <input type="button" name="imprimir" value="Imprimir" onclick="printerFunc()" class="imprimir" />
                                                    <!--<input type="button" name="exportar" value="Exportar" onclick="exportarFunc()" class="imprimir"/>-->
                                                    <input type="button" name="salir" value="Salir" onclick="salirFunc()" class="salir" />
                                                </td>

                                            </tr>
                                             
                                        </table>
                                    </fieldset>
                                </form>
                                <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                            </td>
                        </tr>
                    </table>
                    <?php
                    
                    
                    
                    if (($idpreped != "")&&($encuentra == 1)) {
                        $sql = "SELECT * FROM prepedido P, xcompa X where P.codloc=X.codloc AND P.idpreped = '$idpreped'";
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            if ($row = mysqli_fetch_array($result)) {
                                $nomloc = $row['nomloc'];
                                $nombre = $row['nombre'];
                                $fecha = $row['fecha'];

                                $columna = 's000';
                                if ($nomloc == "LOCAL0") {
                                    $columna = 's000';
                                }
                                if ($nomloc == "LOCAL1") {
                                    $columna = 's001';
                                }
                                if ($nomloc == "LOCAL2") {
                                    $columna = 's002';
                                }
                                if ($nomloc == "LOCAL3") {
                                    $columna = 's003';
                                }
                                if ($nomloc == "LOCAL4") {
                                    $columna = 's004';
                                }
                                if ($nomloc == "LOCAL5") {
                                    $columna = 's005';
                                }
                                if ($nomloc == "LOCAL6") {
                                    $columna = 's006';
                                }
                                if ($nomloc == "LOCAL7") {
                                    $columna = 's007';
                                }
                                if ($nomloc == "LOCAL8") {
                                    $columna = 's008';
                                }
                                if ($nomloc == "LOCAL9") {
                                    $columna = 's009';
                                }
                                if ($nomloc == "LOCAL10") {
                                    $columna = 's010';
                                }
                                if ($nomloc == "LOCAL11") {
                                    $columna = 's011';
                                }
                                if ($nomloc == "LOCAL12") {
                                    $columna = 's012';
                                }
                                if ($nomloc == "LOCAL13") {
                                    $columna = 's013';
                                }
                                if ($nomloc == "LOCAL14") {
                                    $columna = 's014';
                                }
                                if ($nomloc == "LOCAL15") {
                                    $columna = 's015';
                                }
                                if ($nomloc == "LOCAL16") {
                                    $columna = 's016';
                                }
                                if ($nomloc == "LOCAL17") {
                                    $columna = 's017';
                                }
                                if ($nomloc == "LOCAL18") {
                                    $columna = 's018';
                                }
                                if ($nomloc == "LOCAL19") {
                                    $columna = 's019';
                                }
                                if ($nomloc == "LOCAL20") {
                                    $columna = 's020';
                                }
                    ?>
                                  <div id="resultado" name="resultado"  style="width:100%;" >
                                    <b><u></u></b>

                                    <fieldset>
                                        <legend> <strong>DATOS DEL PREPEDIDO</strong></legend>
                                        <div>
                                            <table width="100%" border="0" class="tablarepor">
                                                <tr>
                                                    
                                                    <th width="150">
                                                        <div align="center"><b>CODIGO : </b></div>
                                                    </th>
                                                    <td>
                                                        <div><?php echo $numpagina; ?></div>
                                                    </td>
                                                    <th width="60">
                                                        <div align="center"><b>LOCAL: </b></div>
                                                    </th>
                                                    <td>
                                                        <div><?php echo $nombre; ?></div>
                                                    </td>
                                                    <th width="150">
                                                        <div align="center"><b>FECHA : </b></div>
                                                    </th>
                                                    <td>
                                                        <div><?php echo fecha($fecha); ?></div>
                                                    </td>
                                                    <td width="310">
                                                        <div align="left">
                                                            <input type="button" name="addProducto" value="Agregar Producto" onclick="addProducto( <?php echo $idpreped; ?>,<?php echo $numpagina; ?>)" class="buscar" />
                                                        </div>
                                                    </td>
                                                    <td width="310">
                                                        <div align="left">
                                                            <input type="button" name="actualizar" value="Actualizar Cambios" onclick="actualizar()" class="grabarventa" />
                                                        </div>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </fieldset>

                                    <form id="form1" name="form2" method="post" action="" align="center" width="95%"  >

                                        <table width="95%" border="1" align="center" id="tabDetalle" name="tabDetalle" cellpadding="0" cellspacing="0" style="
                                                   margin-bottom: 10px;
                                                   ">

                                            <thead>
                                                <tr>
                                                    <th id="total" colspan="12">LISTA DE PRODUCTOS</th>
                                                </tr>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>Laboratorio</th>
                                                    <th>Factor</th>
                                                    <th>Blister</th>
                                                    <th>Stock almacen/central</th>
                                                    <th>Venta</th>
                                                    <th>Stock sucursal</th>
                                                    <th>Solicitado</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Costo de Reposicion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                //echo '$columna = '.$columna."<br>";
                                                //echo '$numpagina = '.$numpagina."<br>";
                                                //$sql="SELECT * FROM detalle_prepedido DP,producto P where DP.idprod=P.codpro AND DP.numpagina='$numpagina'order by iddetalle asc";
                                                $sql = "SELECT DP.iddetalle,DP.idprepedido,DP.idcantidad,DP.solicitado,DP.fraccion,P.desprod,M.destab,P.blister,P.codmar,P.s000,P.factor,P.stopro,P.$columna as columna,P.prevta,P.codpro,P.utlcos FROM detalle_prepedido as DP INNER JOIN producto as P on DP.idprod=P.codpro inner join titultabladet AS M ON M.codtab=P.codmar WHERE DP.idprepedido='$numpagina' AND M.tiptab = 'M'   AND  DP.solicitado <>'' AND  DP.solicitado <>'0'   order by  P.desprod ";
                                                //                                                    error_log($sql);
                                                $result = mysqli_query($conexion, $sql);
                                                $cont = 0;
                                                $sumaprevta =0;
                                                        $sumautlcos =0;
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $iddetalle = $row['iddetalle'];
                                                        $idcantidad = $row['idcantidad'];
                                                        $solicitado = $row['solicitado'];
                                                        $control = $row['control'];
                                                        $fraccion = $row['fraccion'];
                                                        $desprod = $row['desprod'];
                                                        $codmar = $row['codmar'];
                                                        $stocentpro = $row['s000'];
                                                        $factor = $row['factor'];
                                                        $stopro = $row['stopro'];
                                                        $stocklocal = $row['columna'];
                                                        $prevta = $row['prevta'];
                                                        $codpro = $row['codpro'];
                                                        $utlcos = $row['utlcos'];
                                                        $blister = $row['blister'];
                                                        if ($fraccion == 1) {
                                                            $control = "F" . $control;
                                                        } else {
                                                            $control = $control;
                                                        }

                                                        //                                                            if ($factor > 1) {
                                                        //
                                                        //                                                                if ($solicitado > $factor) {
                                                        //                                                                    $convert1 = $solicitado / $factor;
                                                        //                                                                    $caja = ((int) ($convert1));
                                                        //                                                                    $solicitado = "C" . $caja;
                                                        //                                                                } else {
                                                        //                                                                    $solicitado = "F" . $solicitado;
                                                        //                                                                }
                                                        //
                                                        ////                                                               
                                                        //                                                            } else {
                                                        //
                                                        //                                                                $solicitado = "C" . $solicitado;
                                                        //                                                            }


                                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                                $destab = $row1['destab'];

                                                                $abrev = $row1['abrev'];
                                                                $destab2 = $row1['destab'];
                                                                if ($abrev <> '') {
                                                                    $destab = $destab2;
                                                                }
                                                            }
                                                        }

                                                        //                                                            $convert1 = $stocklocal / $factor;
                                                        //                                                            $div1 = ((int) ($convert1));
                                                        //                                                            $UNI1 = ($stocklocal - ($div1 * $factor));
                                                        //                                                            $stocklocal = $div1 . ' C ' . $UNI1;
                                                        //
                                                        //
                                                        //                                                            $convert2 = $stocentpro / $factor;
                                                        //                                                            $div2 = ((int) ($convert2));
                                                        //                                                            $UNI2 = ($stocentpro - ($div2 * $factor));
                                                        //                                                            $stocentpro = $div2 . ' C ' . $UNI2;
                                                        $cont++;
                                                        
                                                        $sumaprevta +=$prevta;
                                                        $sumautlcos +=$utlcos;
                                                ?>
                                                        <tr>
                                                            <td bgcolor="#50ADEA" style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo $cont; ?></td>
                                                            <td align="center"><?php echo $codpro; ?></td>
                                                            <td><?php echo $desprod; ?></td>
                                                            <td align="center" title="<?php echo $destab2; ?>"><?php echo $abrev; ?></td>
                                                            <td align="center"><?php echo $factor; ?></td>
                                                            <td align="center"><?php echo $blister; ?></td>
                                                            <td align="center" bgcolor="#7af0d9"><?php echo stockcaja($stocentpro, $factor); ?></td>
                                                            <td align="center" bgcolor="#d494fa"><?php echo $idcantidad; ?></td>
                                                            <td align="center" bgcolor="#dff770"><?php echo stockcaja($stocklocal, $factor); ?></td>
                                                            <td><input id="text[<?php echo $iddetalle; ?>]" name="text[<?php echo $iddetalle; ?>]" type="text" size="10" value="<?php echo $solicitado; ?>" tabindex="<?php echo $cont; ?> " <?php if ($factor == 1) { ?> onkeypress="return ent(event);" <?php } else { ?>onkeypress="return ent2(event);" <?php } ?> onkeyup="mayus(this);" /><?php echo $solicitado;?></td>
                                                            <td align="center"><?php echo $prevta; ?></td>
                                                            <td align="center"><?php echo $utlcos; ?></td>

                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            
                                             <tfoot>
                                                <tr>
                                                   
                                                            <th align="center" colspan="10">TOTAL</th>
                                                        
                                                            <th align="center"><?php echo $sumaprevta; ?></th>
                                                            <th align="center"><?php echo $sumautlcos; ?></th>
                                                </tr>
                                              </tfoot>
                                            
                                        </table>
                                    </form>
                                </div>
                    <?php
                            }
                        }
                    }else{
                    ?>
                        <div class="siniformacion" style="padding: 15% 0;">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
   
</body>

</html>

<script type="text/javascript">
    //$('#option').select2();
</script>