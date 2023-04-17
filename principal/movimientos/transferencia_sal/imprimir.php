<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$venta = $_SESSION['venta'];
$rd = $_REQUEST['rd'];
$CCompra = $_SESSION['transferencia_sal'];
$tipo_documento = 'TRANSFERENCIA DE MERCADERIA';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> </meta>
            <script>

                function imprimir() {
                    console.log("Imprimiendo");
                    var f = document.form1;
                    window.focus();
                    window.print();


<?php if ($rd <> 3) { ?>


                        f.action = "imprimir2.php";
                        f.method = "post";
                        f.submit();

<?php } else { ?>
                        var f = document.form1;
                        f.action = "../ing_salid.php";
                        f.method = "post";
                        f.submit();
<?php } ?>
                }
            </script>

    </head>
    <body onLoad="imprimir();">
        <?php require_once('../bodyimprime_movimientos.php'); ?>
    </body>
</html>