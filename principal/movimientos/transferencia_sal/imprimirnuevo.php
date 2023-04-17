<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>IMPRESION DE VENTA</title>
    <style type="text/css">
        a:link {
            color: #666666;
        }

        a:visited {
            color: #666666;
        }

        a:hover {
            color: #666666;
        }

        a:active {
            color: #666666;
        }

        .Letras {
            font-size: <?php echo $fuente; ?>px;
        }
    </style>

</head>

<body>
</body>
<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

    <link href="../ventas/css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="../ventas/css/tabla2.css" rel="stylesheet" type="text/css" />
    <title>IMPRESION DE VENTA</title>
    <?php
    $rd     = isset($_REQUEST['rd']) ? $_REQUEST['rd'] : "";

    $cod = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : ""; //F8,F9
    $referencia = isset($_REQUEST['referencia']) ? $_REQUEST['referencia'] : ""; //F8,F9
    $local_dest = isset($_REQUEST['local']) ? $_REQUEST['local'] : ""; //F8,F9
    $vendedor = isset($_REQUEST['vendedor']) ? $_REQUEST['vendedor'] : ""; //F8,F9
    $mont2 = isset($_REQUEST['mont2']) ? $_REQUEST['mont2'] : ""; //F8,F9
    ?>
    <script>
        function escapes() {
            var f = document.form1;
            var rd = f.rd.value;
            f.method = "post";
            f.target = "self";
            self.close();
            if (rd == 1) {
                parent.opener.location = 'impresionnuevo.php?rd=1&cod=<?php echo $cod ?>&referencia=<?php echo $referencia ?>&local=<?php echo $local_dest ?>&vendedor=<?php echo $vendedor ?>&mont2=<?php echo $mont2 ?>';
            }
            if (rd == 2) {
                parent.opener.location = 'impresionnuevo.php?rd=2&cod=<?php echo $cod ?>&referencia=<?php echo $referencia ?>&local=<?php echo $local_dest ?>&vendedor=<?php echo $vendedor ?>&mont2=<?php echo $mont2 ?>';
            }
            if (rd == 4) {
                parent.opener.location = 'impresionnuevo.php?rd=4&cod=<?php echo $cod ?>&referencia=<?php echo $referencia ?>&local=<?php echo $local_dest ?>&vendedor=<?php echo $vendedor ?>&mont2=<?php echo $mont2 ?>';
            }
            if (rd == 3) {
                parent.opener.location = 'impresionnuevo.php?rd=3&cod=<?php echo $cod ?>&referencia=<?php echo $referencia ?>&local=<?php echo $local_dest ?>&vendedor=<?php echo $vendedor ?>&mont2=<?php echo $mont2 ?>';
            }
        }
    </script>
</head>

<body onload="escapes();">
    <form id="form1" name="form1">
        <input name="rd" type="hidden" id="rd" value="<?php echo $rd; ?>" />
    </form>
</body>

</html>