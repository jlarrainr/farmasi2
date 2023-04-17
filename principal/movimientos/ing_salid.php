<?php include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once '../../textos_generales.php';
require_once('../../convertfecha.php');
require_once('../local.php');
$filtro = isset($_REQUEST['filtro']) ? ($_REQUEST['filtro']) : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../iconoNew.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../funciones/alertify/alertify.min.js"></script>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>
    <?php
    require_once("funciones/mov_ing_salid.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    /////////////////////////////////
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    /////////////////////////////////////////////////
    ?>
    <?php
    require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <!-- <script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js?temp=<?php echo rand(); ?>"></script> -->
    <style type="text/css">
        h1 {
            color: #FF0000;
            font-size: 40px;
            font-weight: bold;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        h2 {
            margin-top: -40px;
        }
    </style>
</head>

<body onkeyup="ingreso(event)" <?php if ($filtro == 1) { ?>onLoad="mensaje_error();" <?php } else { ?>onLoad="sf();" <?php } ?>>
    <?php

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }

    $date = date("Y-m-d");
    //$hour   = date(G);
    //$date	= CalculaFechaHora($hour);
    $regis = isset($_REQUEST['regis']) ? ($_REQUEST['regis']) : "";

    if ($regis == 1) {
        $regis_desc = "POR REGISTRO";
    }
    if ($regis == 2) {
        $regis_desc = "POR CONSULTA";
    }
    ?>
    <div class="tabla1">
        <?php // error_log("Menu ing salida");  
        ?>
        <script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script>
        <div class="title">

            <table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="titulos">Movimiento de Mercaderias </span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
            </table>
        </div>
        <div class="mask11">
            <div class="mask22">
                <div class="mask33">
                    <?php if (($nopaga == 1) || ($nopaga == 2)) { ?>
                        <script type="text/javascript">
                            alertify.alert("FARMASIS", '<h1><strong><center><?php echo $smspago; ?></center></strong></h1>',
                                function() {
                                    alertify.message('OK');
                                });
                        </script>

                    <?php } elseif (($alertaPagoPorLocal == 1) || ($alertaPagoPorLocal == 2)) { ?>
                        <script type="text/javascript">
                            alertify.alert("FARMASIS", '<h1><strong><center><?php echo $smspagoLocal; ?></center></strong></h1>',
                                function() {
                                    alertify.message('OK');
                                });
                        </script>
                    <?php }?>
                    <?php require('ing_salid1.php'); ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $('#tipo').select2({
        minimumResultsForSearch: -1
    });
    $('#regis').select2({
        minimumResultsForSearch: -1
    });
</script>

</html>