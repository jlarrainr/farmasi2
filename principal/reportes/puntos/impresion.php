<?php
require_once('../../session_user.php');
include('../../session_user.php');
require_once('../../../conexion.php');
$u = $_SESSION['u'];
$c = $_SESSION['c'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <script>
            function direcion()
            {
                top.location.href = 'imprimir.php';
            }
        </script>
    </head>
    <body onload="direcion();">
    </body>
</html>
