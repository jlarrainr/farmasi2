<?php
include('../../session_user.php');
require_once ('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/body.css" rel="stylesheet" type="text/css" />
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <?php
        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        $ok = isset($_REQUEST['ok']) ? ($_REQUEST['ok']) : "";
        $msg = isset($_REQUEST['msg']) ? ($_REQUEST['msg']) : "";
        $DatosProveedor = isset($_REQUEST['DatosProveedor']) ? ($_REQUEST['DatosProveedor']) : "";

        $sql = "SELECT invfec,nrocomp,provee FROM ordmae where pendiente = '1' and preingreso = '1'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            $pop = 1;
        } else {
            $pop = 0;
        }
        ?>
        <script>
            function ss()
            {
                alert("NO SE HAN INGRESADO LOTES");
                return;
            }
            function sf()
            {
                alert("FALTA REGISTRAR BONIFICACIONES PARA ESTA VENTA");
                return;
            }
            var popUpWin = 0;
            function popUpWindow(URLStr, left, top, width, height)
            {
                if (popUpWin)
                {
                    if (!popUpWin.closed)
                        popUpWin.close();
                }
                popUpWin = open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=455,height=120,left=540,top=300,screenX=' + left + ',screenY=' + top + '');
            }
        </script>
        <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>
    </head>
    <body onload="<?php if ($msg == 1) { ?>ss();<?php } if ($msg == 2) { ?>sf();<?php } if ($pop == 1) { ?> popUpWindow()<?php } ?>">
        <div class="tabla1">
            <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>
            <div class="title1">
               
                <table width="100%" border="0">
                    <tr>
                        <td align="left">
                            <span class="titulos">Movimiento de Mercaderias</span>
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
                        <iframe src="compras1.php?msg=<?php echo $msg ?>&DatosProveedor=<?php echo $DatosProveedor; ?>" name="comp_principal" width="100%" height="615" scrolling="Automatic" frameborder="0" id="comp_principal" allowtransparency="0">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
