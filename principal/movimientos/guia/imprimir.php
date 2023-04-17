<?php
require_once('../../session_user.php');
 
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
$invnum =  $_REQUEST['invnum']; 
$despatch_id = $_REQUEST['despatch_id'];
$despatch_uid = $_REQUEST['despatch_uid'];

 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

     
    <title>IMPRESION DE VENTA</title>
    
    <script>
    
    
    function escapes(valor,despatchid,despatch_uid) {
            var valor;
            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
            window.open("impresion_guia.php?invnum="+valor+"&despatch_id="+despatchid+"&despatch_uid="+despatch_uid,"",opciones);
            return false;
    }


         
    </script>
</head>

<body onload="escapes(<?php echo $invnum ?>, '<?php echo $despatch_id ?>', '<?php echo $despatch_uid ?>' );">
    <form id="form1" name="form1">
           
    </form>
</body>

<?php
mysqli_close($conexion);
?>

</html>