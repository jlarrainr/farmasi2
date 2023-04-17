<?php
require_once('../../session_user.php');
require_once('session_ventas.php');
$venta         = $_SESSION['venta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <?php
    $tip          = $_REQUEST['rd'];
    $numCopias   = isset($_REQUEST['numCopias']) ? $_REQUEST['numCopias'] : 1;
    //$impresora   =$_REQUEST['impresora'];
    ?>
    <script>
        function direcion() {
            top.location.href = 'ventas_registro_ventas.php?tt=<?php echo $tip; ?>&vt=<?php echo $venta; ?>&numCopias=<?php echo $numCopias ?>';
        }
    </script>
</head>

<body onload="direcion();">
</body>

</html>