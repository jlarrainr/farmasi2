<?php require_once('../../session_user.php');
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
// require('../../session_filtro.php');

$sql = "SELECT ingreso2 FROM usuario where usecod = '$usuario'  ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $ingreso2 = $row['ingreso2'];
    }
}
// if ($ingreso2 <> $_SESSION['eduardo']) {
//     require('logout.php');
// }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../../iconoNew.ico" />
    <link href="css/tablas_med.css" rel="stylesheet" type="text/css" />
    <link href="../../css/body.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../funciones/functions.php');
    $cancel = isset($_REQUEST['cancel']) ? $_REQUEST['cancel'] : "";
    $tt = isset($_REQUEST['tt']) ? $_REQUEST['tt'] : "";
    $vt = isset($_REQUEST['vt']) ? $_REQUEST['vt'] : "";
    $pf = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : "";
    if (isset($_SESSION['venta'])) {
        unset($_SESSION['venta']);
    }
    ?>

    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <!-- <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script> -->
    <script>
        var popUpWin = 0;

        function impresion() {
            window.frames['iframeOculto'].location = 'imprimirpdf.php?rd=<?php echo $tt; ?>&vt=<?php echo $vt; ?>';
        }
    </script>


</head>

<body>
    <!--<iframe id="iframeOculto" name="iframeOculto" style="width:0px; height:0px; border:0px"></iframe>-->
    <div class="tabla1" style="width:99%;">
        <!-- <script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script> -->
        <div class="title1" style="border-top-left-radius: 10px;border-top-right-radius: 10px;height:auto;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">
                        <span class="titulos">Ventas</span>
                    </td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>
                </tr>
            </table>
        </div>
        <div class="mask1111" style="height:auto;">
            <div class="mask2222" style="height:auto;">
                <div class="mask3333" style="height:auto;">
                    <?php
                    $activado = isset($_REQUEST['activado']) ? $_REQUEST['activado'] : "";
                    $activado1 = isset($_REQUEST['activado1']) ? $_REQUEST['activado1'] : "";
                    $tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : "";
                    $val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
                    $producto = isset($_REQUEST['producto']) ? $_REQUEST['producto'] : "";


                    // echo 'nopaga  =' . $nopaga . "<br>";
                    if (($nopaga == 1) || ($nopaga == 2)) {
                    ?>
                        <script type="text/javascript">
                            alertify.alert("FARMASIS", '<h1><strong><center><?php echo $smspago; ?></center></strong></h1>',
                                function() {
                                    alertify.message('OK');
                                });
                        </script>
                    <?php } ?>


                    <iframe src="venta_index1.php?activado=<?php echo $activado; ?>&activado1=<?php echo $activado1; ?>&tipo=<?php echo $tipo; ?>&val=<?php echo $val; ?>&producto=<?php echo $producto; ?>" name="venta_principal" width="100%" height="640" scrolling="no" frameborder="0" id="venta_principal" allowtransparency="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</body>

</html>