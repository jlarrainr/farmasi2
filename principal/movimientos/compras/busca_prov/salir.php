<?php
require_once('../../../session_user.php');
require_once('../../../../conexion.php'); //CONEXION A BASE DE DATOS
$proveedor = $_REQUEST['proveedor'];

//echo '$proveedor'.$proveedor;



?>
<script>
    location.href = '../compras1.php?ok=4&agregar=1&busca_prov=<?php echo $proveedor?>';
</script>