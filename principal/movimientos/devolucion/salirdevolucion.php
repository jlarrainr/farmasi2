<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');

$codtempid = $_REQUEST['codtempid'];        // usuario


// echo "1" . $cod . "<br>";
// echo "2" . $usuario . "<br>";
// echo "3" . $codtempid . "<br>";
mysqli_query($conexion, "delete from temp_venta2 where codtemp ='$codtempid'");
mysqli_query($conexion, "delete from temp_detalle_venta where codtemp ='$codtempid'");

header("Location:../ing_salid.php");
