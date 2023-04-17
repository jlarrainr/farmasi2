<?php
include('../../session_user.php');
require_once('../../../conexion.php');
$credito = $_REQUEST['proveedor'];
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script>
        function imprimir() {
            var f = document.form1;
            window.print();
            f.action = "por_pagar1.php?valid=1&val=1&proveedor=<?php $credito ?>";
            f.method = "post";
            f.submit();
        }
    </script>
    <style>
        body,
        table {
            font-size: 12px;
            /* //font-weight: bold; */
        }
    </style>
</head>

<body onload="imprimir()">
    <form name="form1" id="form1">

        <h1> estamos probando la impresion<?php echo $credito; ?> en desarrollo </h1>
        <h1> estamos probando la impresion<?php echo $credito; ?> en desarrollo </h1>
        <h1> estamos probando la impresion<?php echo $credito; ?> en desarrollo </h1>
        <h1> estamos probando la impresion<?php echo $credito; ?> en desarrollo </h1>
    </form>
</body>

</html>