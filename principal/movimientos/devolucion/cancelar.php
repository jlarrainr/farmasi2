<?php include('../../session_user.php');
require_once('../../../conexion.php');

$cod            = $_REQUEST['cod'];        ///invnum
$codtempid      = $_REQUEST['codtempid'];        ///invnum


mysqli_query($conexion, "DELETE from temp_detalle_venta where codtemp = '$codtempid'");
mysqli_query($conexion, "DELETE from temp_venta2 where codtemp = '$codtempid'");

header('Location: devolucion.php');
