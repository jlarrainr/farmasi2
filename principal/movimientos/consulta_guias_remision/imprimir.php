<?php
require_once('../../session_user.php');
 
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../funciones/guiaremision.php');
//$invnum =  $_REQUEST['invnum']; 

$despatch_uid = $_REQUEST['despatch_uid'];


// echo $despatch_uid;

 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

     
    <title>IMPRESION DE VENTA</title>
    
    <script>
    
    
    function escapes(valor,despatchid) {
            var valor;
            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
            window.open("impresion_guia.php?despatch_id="+despatchid,"",opciones);
            return false;
    }


         
    </script>
</head>

<body onload="escapes(<?php echo $despatch_id ?>' );">
    <form id="form1" name="form1">
           
    </form>
</body>

<?php
mysqli_close($conexion);
?>

</html>