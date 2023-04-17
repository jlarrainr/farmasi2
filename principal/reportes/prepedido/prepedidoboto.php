<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
require_once ('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
require_once("../local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
//require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
$ok = isset($_REQUEST['ok']) ? ($_REQUEST['ok']) : "";

//echo $ok ;
function convertir_a_numero($str) {
    $legalChars = "%[^0-9\-\. ]%";

    $str = preg_replace($legalChars, "", $str);
    return $str;
}

$idpreped = isset($_REQUEST['idpreped']) ? ($_REQUEST['idpreped']) : "";
$numpagina = isset($_REQUEST['numpagina']) ? ($_REQUEST['numpagina']) : "";
$editar = $_REQUEST['editar'];
$paso = $_REQUEST['paso'];
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    if (isset($_POST['text'])) {
//        $text = $_POST['text'];
//
//        foreach ($text as $key => $n) {
//            $sql1 = "SELECT control,fraccion FROM detalle_prepedido where iddetalle = $key";
//            $result1 = mysqli_query($conexion, $sql1);
//            if (mysqli_num_rows($result1)) {
//                while ($row1 = mysqli_fetch_array($result1)) {
//                    $control = $row1['control'];
//                    $fraccion = $row1['fraccion'];
//                }
//            }
//
//            if ($fraccion == 1) {
//                $ncontrolx = substr($n, 1);
//            } else {
//                $ncontrolx = $n;
//            }
//
//            if (($ncontrolx == "") || ($ncontrolx == 0)) {
//
//                $vacio = 1;
//            }
//
//            /* echo '$ncontrolx'.$ncontrolx."<br>";
//              echo '$control'.$control."<br>";
//              echo '-----------------------------------'."<br>"; */
//
//            if (($ncontrolx <= $control) && ($ncontrolx <> "") && ($ncontrolx <> 0 )) {
//
//
//
//                $sql = "UPDATE detalle_prepedido DP SET solicitado='$n' WHERE DP.idprepedido = '$idpreped' AND DP.iddetalle='$key'";
//                $result = mysqli_query($conexion, $sql);
//
//                $pasa = 1;
//            } else {
//                $pasa = 2;
//            }
//        }
//    }
//}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <style>
            @media print
            {    
                .no-print, .no-print *
                {
                    display: none !important;
                }
            }
            #tabDetalle { display: block; }

            #tabDetalle {
                height: 600px;       /* Just for the demo          */
                overflow-y: auto;    /* Trigger vertical scroll    */
            }


            #tabDetalle {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 70%;

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

            #tabDetalle thead #total {

                text-align: center;
                background-color: #9ebcc1;
                color: white;
                font-size:14px;
                font-weight: 900;
            }

            #tabDetalle tr:nth-child(even){background-color: #f0ecec;}

            #tabDetalle tr:hover {background-color: #ddd;}

            #tabDetalle th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size:13px;
                font-weight: 900;
            }

            input {

                border: 1px solid #ccc;
                border-radius: 4px;

                background-color: white;
                background-position: 3px 3px;


            }
            table.tabla2x
            { 
                color: #404040;
                background-color: #ffffff;
                border: 1px #CDCDCD solid;
                border-collapse: collapse;
                border-spacing: 1px;
            }
            table.tabla2x .th{
                background-color: #f6f1f1;
            }

            #boton { background:url('../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
            #boton1 { background:url('../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
        </style>
        <script language="JavaScript">


            function buscarFunc()
            {
                var f = document.form1;
                if (f.numpagina.value == "")
                {
                    alert("Ingrese un nÃÂÃÂºmero de prepedido");
                    f.numpagina.focus();
                    return;
                }
                f.submit();
            }
            function buscarOption()
            {
                var f = document.form1;
                f.numpagina.value = f.option.value
                f.submit();
            }
            function salirFunc()
            {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                f.action = "../../index.php";
                f.submit();
            }
            function printerFunc()
            {
                window.open('prepedido_imp.php?idpreped=<?php echo $idpreped; ?>&numpagina=<?php echo $numpagina; ?>');
            }
            function printerFunc2()
            {
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
            function PrintElem(elem)
            {
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
                var f = document.form2;
                var v1 = parseFloat(document.form2.cantidad.value); //CANTIDAD NGRESADA
                var alm = parseFloat(document.form2.almacen.value); //CANTIDAD NGRESADA
                var factor = parseFloat(document.form2.factor.value); //CANTIDAD NGRESADA


                var valor = isNaN(v1);
                if (valor == true) ////NO ES NUMERO
                {
                    if ((f.cantidad.value == 0) || (f.cantidad.value == ""))
                    {
                        alert('Debe ingresar un valor diferente a 0 o vacio');
                        document.form2.cantidad.focus();
                        return;
                    }
                    if (factor == 1) {
                        alert("La cantidad ingresada no puede ser fraccion porque el factor es 1");
                        f.cantidad.focus();
                        return;
                    } else {
                        document.form2.number.value = 1; ////avisa que no es numero
                        var v1 = document.form2.cantidad.value.substring(1);
                        if (v1 > alm) {
                            alert("La cantidad ingresada excede al stock de almacen");
                            f.cantidad.focus();
                            return;
                        }
                    }
                } else {
                    if ((f.cantidad.value == 0) || (f.cantidad.value == ""))
                    {
                        alert('Debe ingresar un valor diferente a 0 o vacio');
                        document.form2.cantidad.focus();
                        return;
                    }
                    document.form2.number.value = 0; ////avisa que es numero
                    v1 = parseFloat(v1 * factor);
                    if (v1 > alm) {
                        alert("La cantidad ingresada excede al stock de almacen");
                        f.cantidad.focus();
                        return;
                    }
                }
                f.method = "POST";
                f.action = "actualizar.php";
                f.submit();

            }

            function validar_grid() {
                var f = document.form2;
                f.method = "POST";
                f.action = "refre.php";
                f.submit();
            }
            function cantidadxx() {
                var f = document.form2;
                var v1 = parseFloat(document.form2.cantidad.value); //CANTIDAD NGRESADA
                var alm = parseFloat(document.form2.almacen.value); //CANTIDAD NGRESADA
                var factor = parseFloat(document.form2.factor.value); //CANTIDAD NGRESADA

                var valor = isNaN(v1);
                if (valor == true) ////NO ES NUMERO
                {

                    document.form2.number.value = 1; ////avisa que no es numero
                    var v1 = document.form2.cantidad.value.substring(1);
                    if (v1 > alm) {
                        alert("La cantidad ingresada excede al stock de almacen");
                        f.cantidad.focus();
                        return;
                    }
                } else {

                    document.form2.number.value = 0; ////avisa que es numero
                    v1 = parseFloat(v1 * factor);
                    if (v1 > alm) {
                        alert("La cantidad ingresada excede al stock de almacen");
                        f.cantidad.focus();
                        return;
                    }
                }
            }
            var nav4 = window.Event ? true : false;
            function ent2(evt) {
                var key = nav4 ? evt.which : evt.keyCode;
                if (key == 13)
                {
                    var f = document.form2;
                    var v1 = parseFloat(document.form2.cantidad.value); //CANTIDAD NGRESADA
                    var alm = parseFloat(document.form2.almacen.value); //CANTIDAD NGRESADA
                    var factor = parseFloat(document.form2.factor.value); //CANTIDAD NGRESADA


                    var valor = isNaN(v1);
                    if (valor == true) ////NO ES NUMERO
                    {
                        if ((f.cantidad.value == 0) || (f.cantidad.value == ""))
                        {
                            alert('Debe ingresar un valor diferente a 0 o vacio');
                            document.form2.cantidad.focus();
                            return;
                        }
                        if (factor == 1) {
                            alert("La cantidad ingresada no puede ser fraccion porque el factor es 1");
                            f.cantidad.focus();
                            return;
                        } else {
                            document.form2.number.value = 1; ////avisa que no es numero
                            var v1 = document.form2.cantidad.value.substring(1);
                            if (v1 > alm) {
                                alert("La cantidad ingresada excede al stock de almacen");
                                f.cantidad.focus();
                                return;
                            }
                            if (factor == 1) {
                                alert("La cantidad ingresada excede al stock de almacen");
                                f.cantidad.focus();
                                return;
                            }
                        }

                    } else {
                        if ((f.cantidad.value == 0) || (f.cantidad.value == ""))
                        {
                            alert('Debe ingresar un valor diferente a 0 o vacio');
                            document.form2.cantidad.focus();
                            return;
                        }
                        document.form2.number.value = 0; ////avisa que es numero
                        v1 = parseFloat(v1 * factor);
                        if (v1 > alm) {
                            alert("La cantidad ingresada excede al stock de almacen");
                            f.cantidad.focus();
                            return;
                        }
                    }


                    var f = document.form2;
                    f.method = "POST";
                    f.action = "actualizar.php";
                    f.submit();
                }
//                return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
                return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
            }

            function textcantidad() {


                document.getElementById("cantidad").value = "";
                document.form2.cantidad.focus();
            }
            function actualizar2() {
                var f = document.form2;
                f.method = "POST";
                ventana = confirm("Desea Grabar e Imprimir Prepedido");
                if (ventana) {
                    window.open('prepedido_imp.php?idpreped=<?php echo $idpreped; ?>&numpagina=<?php echo $numpagina; ?>');

                }
                f.submit();
            }
        </script>  
        <title><?php echo $desemp ?></title>

        <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/body.css" rel="stylesheet" type="text/css" />
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />

        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/style1s.css" rel="stylesheet" type="text/css" />
        <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
        <script src="../../../funciones/alertify/alertify.min.js"></script>
        <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS  ?>
        <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
        <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES    ?>
        <!--<link href="../../select2/css/select2.min.css" rel="stylesheet" />
                       <script src="../../select2/jquery-3.4.1.js"></script>
                       <script src="../../select2/js/select2.min.js"></script>-->


    </head>
    <body <?php if ($editar == 1) { ?> onload="textcantidad();" <?php } ?> >
        <div class="tabla1"  style="height: 100%;">
            <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>

            <div class="title1">
<!--                <span class="titulos">SISTEMA DE VENTAS - PREPEDIDO
            </span>
                -->
                <table width="100%" border="0">
                    <tr>
                        <td align="left">
                            <span class="titulos">PREPEDIDO</span>
                        </td>
                        <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30"  /> </a></td>
                        <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

   <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                    </tr>
                    <?php if ($paso == 2) { ?>
                        <script>
                alertify.error("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo "La cantidad es incorrecta"; ?></p>");
                        </script>
                        <?php
                    }
                    if ($paso == 1) {
                        ?>
                        <script>
                            alertify.success("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo "Se registro con Exito"; ?></p>");
                        </script>
                    <?php } ?>

                </table>
            </div>
            <div class="mask1111"  style="height: 100%;">
                <div class="mask2222"  style="height: 100%;">
                    <div class="mask3333"  style="height: 100%;">
                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <form id="form1" name="form1" method = "post" action="">
                                        <fieldset style="colo" >
                                            <legend> <strong>BUSQUEDA DE PREPEDIDO</strong></legend>
                                            <table width="100%" border="0" class="tabla2x">
                                                <tr>
                                                    <td width="119"><b>CODIGO</b></td>
                                                    <td width="98">
                                                        <input type="text" name="numpagina" id="numpagina" size="12" value="<?php echo $numpagina; ?>">
                                                    </td>     

                                                    <td width="400" align="center" rowspan="2" >
                                                        <input type="button" name="buscar" value="Buscar" onclick="buscarFunc()" class="buscar"/>
                                                        <!--<input type="button" name="imprimir" value="Imprimir" onclick="printerFunc()" class="imprimir"/>-->
                                                        <!--<input type="button" name="exportar" value="Exportar" onclick="exportarFunc()" class="imprimir"/>-->
                                                        <input type="button" name="salir" value="Salir" onclick="salirFunc()" class="salir"/>
                                                    </td>  

                                                </tr>
                                                <tr>
                                                    <td width="119"><b>CAMBIAR A PREPEDIDO</b></td>
                                                    <td width="98">
                                                        <select id="option" name='option' onchange="buscarOption()" style="width:90px;">
                                                            <?php
                                                            $sqlList = "SELECT distinct(numpagina) numcont FROM detalle_prepedido P where P.idprepedido = '$idpreped'";
//                                                            error_log("SQL 2: " . $sqlList);
                                                            $result = mysqli_query($conexion, $sqlList);
                                                            if (mysqli_num_rows($result)) {
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $numcont = $row['numcont'];
                                                                    echo '<option value="' . $numcont . '"';
                                                                    if ($numcont == $numpagina)
                                                                        echo " selected ";
                                                                    echo '>' . $numcont . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
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
                        if ($idpreped != "") {
                            $sql = "SELECT * FROM prepedido P, xcompa X where P.codloc=X.codloc AND P.idpreped = '$idpreped'";
//                            error_log("SQL 1: " . $sql);
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                if ($row = mysqli_fetch_array($result)) {
                                    $nomloc = $row['nomloc'];
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
                                    <div id="resultado" name="resultado">
                                        <b><u></u></b>

                                        <fieldset >
                                            <legend> <strong>DATOS DEL PREPEDIDO</strong></legend>
                                            <div>
                                                <table width="100%" border="0"  class="tabla2x">
                                                    <tr>
                                                        <th width="119" align="center">  <div><b>CODIGO PRINCIPAL: </b></div></th>
                                                        <td> <div><?php echo $idpreped; ?></div></td>
                                                        <th width="150" ><div align="center"><b>CODIGO DEL PREPEDIDO: </b></div></th>
                                                        <td ><div><?php echo $numpagina; ?></div></td>
                                                        <th width="60"><div align="center"><b>LOCAL: </b></div></th>
                                                        <td><div><?php echo $nomloc; ?></div></td>
                                                        <th width="150"><div align="center"><b>FECHA DEL PREPEDIDO: </b></div></th>
                                                        <td ><div><?php echo fecha($fecha); ?></div></td>
                                                        <td width="310" >
                                                            <div align="left">
                                                                <input type="button" name="actualizar" value="Grabar Prepedido" onclick="actualizar2()" class="grabarventa"/>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </fieldset >

                                        <form id="form1" name="form2" method = "post" action="" align="center">

                                            <table width="100%" border="1" align="center" id="tabDetalle" name="tabDetalle" cellpadding="0" cellspacing="0" style="
                                                   margin-bottom: 10px;
                                                   ">

                                                <thead>
                                                    <tr >
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
                                                        <!--<th>Venta</th>-->
                                                        <th>Stock sucursal</th>
                                                        <th>Solicitado</th>
                                                        <th>Precio de Venta</th>
                                                        <th>Ultimo Costo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    //$sql="SELECT * FROM detalle_prepedido DP,producto P where DP.idprod=P.codpro AND DP.numpagina='$numpagina'order by iddetalle asc";
                                                    //$sql = "SELECT DP.iddetalle,DP.idcantidad,DP.solicitado,DP.control,DP.fraccion,P.desprod,P.blister,P.codmar,P.s000,P.factor,P.stopro,P.$columna as columna,P.prevta,P.codpro,P.utlcos FROM detalle_prepedido as DP INNER JOIN producto  as P on  DP.idprod=P.codpro  WHERE DP.numpagina='$numpagina'order by iddetalle asc";
                                                    $sql = "SELECT DP.iddetalle,DP.idprepedido,DP.idcantidad,DP.solicitado,DP.fraccion,P.desprod,M.destab,P.blister,P.codmar,P.s000,P.factor,P.stopro,P.$columna as columna,P.prevta,P.codpro,P.utlcos FROM detalle_prepedido as DP INNER JOIN producto as P on DP.idprod=P.codpro inner join titultabladet AS M ON M.codtab=P.codmar WHERE DP.numpagina='$numpagina' AND M.tiptab = 'M' order by M.destab, P.desprod ";
//                                                    error_log($sql);
                                                    $result = mysqli_query($conexion, $sql);
                                                    $cont = 0;
                                                    if (mysqli_num_rows($result)) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $iddetalle = $row['iddetalle'];
                                                            $idprepedido = $row['idprepedido'];
                                                            $idcantidad = $row['idcantidad'];
                                                            $solicitado = $row['solicitado'];
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

                                                            $valform = $_REQUEST['valform'];
                                                            $cod = $_REQUEST['cod'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $cont; ?></td>
                                                                <td align="center"><?php echo $codpro; ?></td>
                                                                <td><?php echo $desprod; ?></td>
                                                                <td align="center"><?php echo $abrev; ?></td>
                                                                <td align="center"><?php echo $factor; ?></td>
                                                                <td align="center"><?php echo $blister; ?></td>

                                                                <td align="center" bgcolor="#d7d9d7"><?php echo stockcaja($stocentpro, $factor); ?></td>
                                                                <!--<td align="center"><?php echo $idcantidad; ?></td>-->
                                                                <td align="center"><?php echo stockcaja($stocklocal, $factor); ?></td>
                                                                <td>
                                                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?> 

                                                                        <input id="cantidad" name="cantidad" type="text" size="5" value="<?php echo $solicitado; ?>"  onkeyup="cantidadx();" onkeypress="return ent2(event);" />
                                                                        <!--<input id="text[<?php echo $iddetalle; ?>]" name="text[<?php echo $iddetalle; ?>]" type="hidden" value="<?php echo $solicitado; ?>" />-->
                                                                        <input type="hidden" name="iddetalle" size="4" id="iddetalle" value="<?php echo $iddetalle; ?>"/>
                                                                        <input type="hidden" name="idpreped" size="4" id="idpreped" value="<?php echo $idpreped; ?>"/>
                                                                        <input type="hidden" name="numpagina" size="4" id="numpagina" value="<?php echo $numpagina; ?>"/>
                                                                        <input type="hidden" name="codpro" size="4" id="codpro" value="<?php echo $codpro; ?>"/>
                                                                        <input type="hidden" name="almacen" size="4" id="almacen" value="<?php echo $stocentpro; ?>"/>
                                                                        <input type="hidden" name="factor" size="4" id="factor" value="<?php echo $factor; ?>"/>
                                                                        <input type="hidden" name="idpreped" size="4" id="idpreped" value="<?php echo $idprepedido; ?>"/>
                                                                    <?php } else { ?>
                                                                        <?php echo $solicitado; ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <td align="center"><?php echo $prevta; ?></td>
                                                                <td align="center"><?php echo $utlcos; ?></td>

                                                                <td  valign="bottom" width="35"> 
                                                                    <div align="center">
                                                                        <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                                                            <input name="number" type="hidden" id="number" />

                                                                            <input type="button" id="boton" onClick="actualizar()" alt="GUARDAR"/>
                                                                            <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR"/>
                                                                        <?php } else { ?>
                                                                            <a href="prepedido.php?cod=<?php echo $codpro ?>&valform=1&idpreped=<?php echo $idpreped ?>&numpagina=<?php echo $numpagina; ?>&editar=1">
                                                                                <!--<a onclick="eduardo();">-->
                                                                                <img src="../../../images/edit_16.png" width="16" height="16" border="0"/>
                                                                            </a>

                                                                        <?php } ?>
                                                                    </div>	 
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    //$('#option').select2();
</script>