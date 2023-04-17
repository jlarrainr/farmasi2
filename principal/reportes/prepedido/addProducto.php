<?php
include('../../session_user.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');


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

if($utlcos_p!=''){
    $tablaSelect='precios_por_local';
    $entra=1;
}else{
    $tablaSelect='producto';
    $entra=2;
}

  
 
$ActionForm     = isset($_REQUEST['ActionForm']) ? ($_REQUEST['ActionForm']) : "";
$CProducto      = isset($_REQUEST['CProducto']) ? ($_REQUEST['CProducto']) : "";
$CProductoBonif = isset($_REQUEST['CProductoBonif']) ? ($_REQUEST['CProductoBonif']) : "";
$ProductoBusk   = isset($_REQUEST['ProductoBusk']) ? ($_REQUEST['ProductoBusk']) : "";
$Cantidad       = isset($_REQUEST['Cantidad']) ? ($_REQUEST['Cantidad']) : "";
$CantidadBonif  = isset($_REQUEST['CantidadBonif']) ? ($_REQUEST['CantidadBonif']) : "";

$idpreped = isset($_REQUEST['idpreped']) ? ($_REQUEST['idpreped']) : "";
$numpagina = isset($_REQUEST['numpagina']) ? ($_REQUEST['numpagina']) : "";

$desprodBonif       = "";
$CantidadaVender2   = "";
//$CProductoBonif = "";
//$CantidadBonif  = "";
$sql = "SELECT desprod,codpro,factor FROM producto where codpro = '$CProductoBonif'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $des            = $row['desprod'];
        $codpro_campo    = $row['codpro'];
        $factor_campo    = $row['factor'];
        $factor_campo2   = $row['factor'];
        $factorx            = $row['factor'];
    }
}

if ($ActionForm == "RegistrarBonificacion") {
    if (!is_numeric($Cantidad)) {
        $Cantidad = strtoupper($Cantidad);
    }

    if (!is_numeric($CantidadBonif)) {
        $fraccion = 1;
        $CantidadBonif = strtoupper($CantidadBonif);
    } else {
        $fraccion = 0;
    }

    mysqli_query($conexion, "INSERT INTO `detalle_prepedido`(  `idprepedido`, `idprod`, `idcantidad`,  `solicitado`, `numpagina`,fraccion,factor ) VALUES ('$idpreped' ,'$CProductoBonif','$CantidadBonif','$CantidadBonif','$numpagina','$fraccion','$factor_campo' )");
}

if ($ActionForm == "EliminaBonificacion") {

    mysqli_query($conexion, "DELETE FROM `grupo_user` where idprod = '$CProductoBonif' AND  idprepedido = '$idpreped'  AND  numpagina = '$numpagina' ");

    $ActionForm     = "";
    $CProductoBonif = "";
    $Cantidad       = "";
    $desprodBonif       = "";
    $ProductoBusk       = "";
}




require_once("../../../funciones/botones.php");    //COLORES DE LOS BOTONES
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desprod ?></title>
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <!-- <link href="../../css/body.css" rel="stylesheet" type="text/css" /> -->
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        function producto_no_cargado() {
            var f = document.Formulario;
            f.ProductoBusk.focus();
        }

        function producto_si_cargado() {
            var f = document.Formulario;
            f.CantidadBonif.focus();
        }

        function Salir() {
            window.close();
        }

        function buscar() {
            var f = document.Formulario;
            if (f.ProductoBusk.value === "") {
                f.CantidadBonif.focus();
                alert("Ingrese un producto a buscar");
                return false;
            }
            f.ActionForm.value = "BuscarProducto";
            f.CProductoBonif.value = "";
            f.submit();
        }

        function eliminar() {
            var Formulario = "Formulario";
            var f = document.getElementById(Formulario);
            if (confirm('Desea limpiar este registro')) {
                f.ActionForm.value = "EliminaBonificacion";
                f.submit();
            } else {
                return;
            }
        }

        function SelecProducto(Valor) {
            var f = document.Formulario;
            f.ActionForm.value = "";
            f.CProductoBonif.value = Valor;
            f.submit();
        }

        function GrabarBonificacion() {
            var f = document.Formulario;


            if (f.CProductoBonif.value === "") {
                alert("Seleccione un Producto a Añadir");
                return false;
            }

            if ((f.ProductoBusk.value === "") || (f.ProductoBusk.value == 0)) {
                f.ProductoBusk.focus();
                alert("Ingrese un Producto a Añadir ");
                return false;
            }
            if ((f.CantidadBonif.value === "") || (f.CantidadBonif.value == 0)) {
                f.CantidadBonif.focus();
                alert("Ingrese una cantidad  diferente a 0 o vacio");
                return false;
            }

            f.ActionForm.value = "RegistrarBonificacion";
            f.submit();
        }

        function letracc(evt) {
            //var key=evt.keyCode;
            var key = evt ? evt.which : evt.keyCode;
            return (key == 67 || key == 99 || key <= 13 || (key >= 48 && key <= 57));
        }
        var nav4 = window.Event ? true : false;

        function ent(evt) {
            var key = nav4 ? evt.which : evt.keyCode;


            return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
        }

        var nav4 = window.Event ? true : false;

        function ent2(evt) {
            var key = nav4 ? evt.which : evt.keyCode;

            //                return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
            return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
        }
    </script>
    <style>
        .siniformacion {
            font-family: Tahoma;
            font-size: 20px;
            line-height: normal;
            color: #e65a3d;
            padding: 20px;
            font-weight: bold;
            /*margin-top:  20px;*/
        }

        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/x2.png') no-repeat;
            border: none;
            width: 26px;
            height: 26px;
        }

        a:link,
        a:visited {
            color: #0066CC;
            border: 0px solid #e7e7e7;
            text-decoration: none;
        }

        a:hover {
            background: #fff;
            border: 0px solid #ccc;
            font-size: 15px;
            color: #ec5e5c;
            background-color: #FFFF66;
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

        /* para las tablas */
        /* #customers a {
			text-decoration: none;

		}

		#customers a:hover {
			text-decoration: solid;
			font-size: 15px;

		} */

        #customers_1 {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers_1 th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers_1 td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 12px;
        }

        #customers_1 tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers_1 tr:hover {
            background-color: #FFFF66;
        }

        #customers_1 th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }


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
            padding: 5px;
            font-size: 12px;
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
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }

        table {
            width: 100%;
        }

        .LETRA2 {
            background: #d7d7d7
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
    </style>
</head>

<body <?php if ($ActionForm == "RegistrarBonificacion") { ?>onload="Salir();" <?php } elseif ($codpro_campo == "") { ?> onload="producto_no_cargado();" <?php } elseif ($codpro_campo <> "") { ?> onload="producto_si_cargado();" <?php } ?>width="100%">
    <form name="Formulario" id="Formulario" action="addProducto.php?idpreped=<?php echo $idpreped; ?>&numpagina=<?php echo $numpagina; ?>" method="post" width="100%">
        <input type="hidden" name="ActionForm" value="" />
        <input type="hidden" name="CProducto" value="<?php echo $CProducto; ?>" />
        <input type="hidden" name="CProductoBonif" value="<?php echo $CProductoBonif; ?>" />
        <input type="hidden" name="factor" id="factor" value="<?php echo $factor_campo; ?>">
        <input type="hidden" name="factor_venta" id="factor_venta" value="<?php echo $factorx; ?>">
        <input type="hidden" name="tipo_de_venta_text" id="tipo_de_venta_text" value="">
        <input type="hidden" name="desprod_principal" id="desprod_principal" value="<?php echo $desprod; ?>">
        <table border="0" style="width: 100%" cellpadding="0" cellspacing="0">
            <tr>
                <td <?php if ($ActionForm <> "") { ?> style="float:left;" align="right" width="49%" <?php } else { ?> width="100%" <?php } ?>>

                    <table style="width: 100%" border="1" id="customers_1" cellpadding="0" cellspacing="0">

                        <tr>
                            <th class="LETRA">PRODUCTO </th>
                            <td>
                                <input class="letra2" type="text" value="<?php echo $codpro_campo; ?>" size="5" readonly />
                                <input class="letra2" type="text" value="<?php echo $factor_campo2; ?>" size="10" readonly />
                                <input name="ProductoBusk" type="text" maxlength="100" id="ProductoBusk" style="width: 40%;" value="<?php echo $des; ?>" placeholder="Ingrese a Buscar Producto ..." onclick="this.value = ''" />
                                <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar" />
                                <?php
                                if ((strlen($CProductoBonif) > 0) and ($CProductoBonif <> 0)) {
                                ?>
                                    <input name="delete" type="button" id="delete" value="Quitar" onclick="eliminar()" class="limpiar" />
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="LETRA">CANTIDAD </th>
                            <td>
                                <input type="text" placeholder="Ingrese cantidad" maxlength="4" name="CantidadBonif" <?php if ($factor_campo2 == 1) { ?> onkeypress="return ent(event);" <?php } else { ?>onkeypress="return ent2(event);" <?php } ?> id="CantidadBonif" value="<?php echo $CantidadBonif2; ?>" <?php if ($codpro_campo == "") { ?> disabled="disabled" class="letra2" <?php } ?> />

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php
                                if (strlen($CProductoBonif) > 0) {
                                ?>
                                    <input type="button" name="Grabar" id="Grabar" class="grabarventa" value="Asignar Informacion" onclick="GrabarBonificacion();" />
                                <?php
                                }
                                ?>
                                <input name="exit" type="button" id="exit" value="Salir" onclick="Salir()" class="salir" />
                            </td>
                        </tr>
                    </table>
                </td>
                <?php if ($ActionForm <> "") {                    ?>
                    <td width="50%" style="float:right;">

                        <!-- <iframe src="productos_lista.php?ProductoBusk=<?php echo $ProductoBusk ?>" name="iFrame1" width="100%" height="600" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0"> </iframe> -->
                        <table style="width: 100%" id="customers">
                            <?php
                            
                          /* if($entra==1){
                               echo $utlcos_p.'<br>';
                               if (is_numeric($ProductoBusk)) {
                                    $sql3 = "SELECT P.codpro,P.desprod,P.codmar,P.factor FROM producto P INNER JOIN precios_por_local AS PL on P.codpro=PL.codpro  where ((P.codbar = '$ProductoBusk') or (P.codpro = '$ProductoBusk'))and PL.$utlcos_p>0  and P.eliminado='0'";
                                
                                   echo $sql3.'<br>';
                               } else {
                                    $sql3 = "SELECT P.codpro,P.desprod,P.codmar,P.factor FROM producto P INNER JOIN precios_por_local AS PL  on P.codpro=PL.codpro where  P.desprod like '$ProductoBusk%' and PL.$utlcos_p>0  and P.eliminado='0'";
                                }
                               
                               
                           }else{
                               */
                               if (is_numeric($ProductoBusk)) {
                                $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where codbar = '$ProductoBusk' or codpro = '$ProductoBusk' and eliminado='0' ";
                                } else {
                                    $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where desprod like '$ProductoBusk%'   and eliminado='0' ";
                                }
                         //  }
                           
                           
                            
                            $result3 = mysqli_query($conexion, $sql3);
                            if (mysqli_num_rows($result3)) {
                            ?>
                                <thead id="Topicos_Cabecera_Datos">

                                    <tr>
                                        <th style="text-align: left;" class="LETRA">CODIGO</th>
                                        <th style="text-align: left;" class="LETRA">SELECCIONE UN PRODUCTO</th>
                                        <th style="text-align: left;" class="LETRA">MARCA</th>
                                        <th style="text-align: left;" class="LETRA">FACTOR</th>
                                        <th style="text-align: left;" class="LETRA"></th>
                                    </tr>
                                </thead>
                                <tbody id="gtnp_Listado_Datos">
                                    <?php
                                    $i = 0;
                                    while ($row3 = mysqli_fetch_array($result3)) {
                                        $codpro         = $row3['codpro'];
                                        $desprod        = $row3['desprod'];
                                        $codmar         = $row3['codmar'];
                                        $factor         = $row3['factor'];
                                        $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                        $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                                        if (mysqli_num_rows($resultMarcaDet)) {
                                            while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                                $marca     = $row1['destab'];
                                                $abrev     = $row1['abrev'];
                                                if ($abrev == '') {
                                                    $marca = substr($marca, 0, 4);
                                                } else {
                                                    $marca = substr($abrev, 0, 4);
                                                }
                                            }
                                        }
                                        $t = $i % 2;
                                        if ($t == 1) {
                                            $Color = "#f5f8f9";
                                        } else {
                                            $Color = "#D4D0C8";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $codpro; ?></td>
                                            <td><?php echo $desprod; ?></td>
                                            <td><?php echo $marca; ?></td>
                                            <td style="text-align: center;"><?php echo $factor; ?></td>
                                            <td style="text-align: center;"><input type="button" class="limpiar" name="Seleccionar" value="Seleccionar" onclick="SelecProducto(<?php echo $codpro; ?>);" /></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            <?php
                            } else {
                            ?>

                                <div class="siniformacion">
                                    <center>
                                        No se logro encontrar informacion con los datos ingresados
                                    </center>
                                </div>
                            <?php
                            }
                            ?>


                        </table>
                    </td>
                <?php } ?>
            </tr>
        </table>

    </form>
</body>

</html>
<?php

?>


<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                // "pageLength": 25,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ãltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
        }

    );
</script>