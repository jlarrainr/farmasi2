<?php
include('../../session_user.php');
require_once ('../../../conexion.php');
require_once('../../../titulo_sist.php');
$CCompra = $_REQUEST['Compra'];
$tipo_documento = 'OTROS INGRESOS';
?>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <script>
            function imprimir()
            {
                    <?php  if ($nopaga == 2) {?>
                    var f = document.form1;
                    f.action = "../logout.php";
                    f.method = "post";
                    f.submit();
                <?php } else { ?>
                    var f = document.form1;
                    window.print();
                    f.action = "../ing_salid.php";
                    f.method = "post";
                    f.submit();
    
                <?php   }  ?>
                
                
            }
        </script>
    </head>
    <body onload="imprimir()">
        <?php require_once('../bodyimprime_movimientos.php'); ?>
    </body>
</html>