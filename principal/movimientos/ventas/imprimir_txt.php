<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
?>
<html>

<head>
    <?php
    $archivotxt = $_REQUEST['ruta'];
    ?>
    <script>
        function imprimir() {
            var f = document.form1;
            window.print();
            f.action = "venta_index.php";
            f.method = "post";
            f.submit();
        }
    </script>
</head>

<body onLoad="imprimir();">
    <form name="form1" id="form1">
        <?php
        $archivo = file($archivotxt);
        $lineas = count($archivo);
        for ($i = 0; $i < $lineas; $i++) {
            echo "" . $archivo[$i] . "</br>\n";
        }
        ?>
    </form>
</body>

</html>