<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
//require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?> - ORDENES DE COMPRA</title>
    <?php
    $invnum = $_REQUEST['cod'];
    $pag    = $_REQUEST['pag'];
    $ultimo = $_REQUEST['ultimo'];
    $numerox = $_REQUEST['numero'];

    if ($numerox == 0) {
        $numerox = "";
    } else {
        $pag = "";
    }
    //echo $numerox;
    //$cadena = $pag."&numero=".$numerox;
    //echo $pag."-".$numerox;
    ?>
    <script>
        function imprimir() {
            //alert("consult_compras1.php?pageno=<?php echo $pag ?>&numero=<?php echo $numerox ?>");
            var f = document.form1;
            window.print();
            self.close();
            <?php
            echo "parent.opener.location='consult_compras1.php?pageno=" . $pag . "&numero=" . $numerox . "';";
            ?>
            //f.action = "ingresos_varios.php";
            //f.method = "post";
            //f.submit();
        }
    </script>

    <style>
        body,
        table {
            font-size: 16px;
            /*font-weight: bold;*/
        }
    </style>
    <?php 
$CCompra =$invnum;
$tipo_documento = 'INGRESOS POR COMPRAS';
?>
   
    
</head>

 <body onload="imprimir()">
        <?php require_once('../bodyimprime_movimientos.php'); ?>
    </body>



</html>