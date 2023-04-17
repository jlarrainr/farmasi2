<?php
require_once('../../session_user.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <?php
    $rd          = $_REQUEST['rd'];


    $cod        = $_REQUEST['cod'];
    $referencia = $_REQUEST['referencia'];
    $local_dest = $_REQUEST['local'];
    $vendedor     = $_REQUEST['vendedor'];
    $mont2         = $_REQUEST['mont2'];



    ?>
    <script>
        function direcion() {
            top.location.href = 'transferencia1_sal_reg.php?rd=<?php echo $rd; ?>&cod=<?php echo $cod; ?>&referencia=<?php echo $referencia; ?>&local=<?php echo $local_dest; ?>&vendedor=<?php echo $vendedor; ?>&mont2=<?php echo $mont2; ?>';
        }
    </script>
</head>

<body onload="direcion();">
</body>

</html>