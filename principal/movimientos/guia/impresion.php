<?php
require_once('../../../conexion.php'); 
require_once('../../session_user.php');
 
 $invnum =  $_REQUEST['invnum'];
 $despatch_id =  $_REQUEST['despatch_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    
    <script>
        function direcion() {
            console.log("impresion");
            top.location.href = 'impresion_guia.php?invnum=<?=$invnum;?>&despatch_id=<?=$despatch_id;?>';
        }
    </script>
</head>

<body onload="direcion();">
     
</body>

</html>