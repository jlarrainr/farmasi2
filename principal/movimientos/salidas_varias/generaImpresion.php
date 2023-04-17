<?php
include('../../session_user.php');
require_once ('../../../conexion.php');
require_once('../../../titulo_sist.php');
$CCompra = $_REQUEST['Compra'];
$tipo_documento = 'SALIDAS VARIAS';
?>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <script>
            function imprimir()
            {
                var f = document.form1;
                window.print();
                f.action = "../ing_salid.php";
                f.method = "post";
                f.submit();
            }
        </script>
    </head>
    <body onload="imprimir()">
        <?php require_once('../bodyimprime_movimientos.php'); ?>
    </body>
</html>