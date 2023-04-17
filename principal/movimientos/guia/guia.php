<?php include('../../session_user.php');
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../../iconoNew.ico" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/body.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
    <style>
        .titulosED {
            font-family: Tahoma;
            font-weight: 900;
            font-size: 15px;
            line-height: normal;
            color: #ffffff;
            margin-left: 10px;

        }

        .embed-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .embed-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3">


</head>

<body>
    <div>
        <!-- <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script> -->
        <div class="title1">

            <table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="titulos">Guias de Remisión</span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
            </table>
        </div>
        <div class="mask1111" style="height: auto;">
            <div class="mask2222" style="height: auto;">
                <div class="mask3333" style="height: auto;">
                    <?php
                    $activado = $_REQUEST['activado'];
                    $activado1 = $_REQUEST['activado1'];
                    $tipo = $_REQUEST['tipo'];
                    $val = $_REQUEST['val'];
                    $producto = $_REQUEST['producto'];

                    ?>


                    <!-- <iframe src="guia1.php?activado=<?php echo $activado ?>&activado1=<?php echo $activado1 ?>&tipo=<?php echo $tipo ?>&val=<?php echo $val ?>&producto=<?php echo $producto ?>" name="venta_principal" width="100%" height="100%" scrolling="Automatic" frameborder="0" id="venta_principal" allowtransparency="0">
                    </iframe>-->


                    <div class="embed-container" style="height: auto;">
                        <div id="contenido" class="contenedor-responsive" style="height: auto;">
                            <!-- <iframe src="venta_index2.php" name="index1" width="100%" height="520" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
                                        </iframe> -->
                            <iframe src="guia1.php?activado=<?php echo $activado ?>&activado1=<?php echo $activado1 ?>&tipo=<?php echo $tipo ?>&val=<?php echo $val ?>&producto=<?php echo $producto ?>" frameborder="0" allowfullscreen="" width="100px" height="1600px" id="index1" name="index1"></iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
<script>

</script>

</html>