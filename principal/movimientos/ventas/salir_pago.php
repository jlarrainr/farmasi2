<?php
require_once('../../session_user.php');
$venta = $_SESSION['venta'];
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS

?>
<!-- <script>
    location.href = 'venta_index2.php';
</script> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function recargo() {
            var f = document.form1;
            document.form1.target = "venta_principal";
            f.action = "venta_index1.php";
            // f.action = "ventas_registro.php";
            f.method = "post";
            f.submit();

        }
    </script>
</head>

<body onload="recargo();">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
    </form>
</body>

</html>