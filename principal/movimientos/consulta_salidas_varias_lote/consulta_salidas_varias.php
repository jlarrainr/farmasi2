<?php include('../../session_user.php');
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link rel="icon" type="image/x-icon" href="../../../iconoNew.ico" />
        <link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/body.css" rel="stylesheet" type="text/css" />
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        ?>
        <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
    </head>
    <body>
        <div class="tabla1">
            <!-- <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script> -->
            <div class="title1">
             
                <table width="100%" border="0">
                    <tr>
                        <td align="left">
                            <span class="titulos">SALIDAS VARIAS POR LOTE</span>
                        </td>
                        <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30"  /> </a></td>
                        <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

   <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                    </tr>
                </table>
            </div>
            <div class="mask1111">
                <div class="mask2222">
                    <div class="mask3333">
                        <iframe src="consult_compras1.php" name="ingreso_transf" width="100%" height="640" scrolling="Automatic" frameborder="0" id="ingreso_transf" allowtransparency="0">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
