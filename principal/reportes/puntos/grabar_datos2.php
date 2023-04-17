<?php

include('../../session_user.php');
require_once('../../../conexion.php');

$codcli = $_REQUEST['codcli'];
$val = $_REQUEST['val'];
$search = $_REQUEST['search'];


//  mysqli_query($conexion,"truncate TABLE temp_puntos");
mysqli_query($conexion, "DELETE FROM temp_puntos where codclic ='$codcli' and usecod ='$usuario' ");

header("Location:puntos2.php?search=$search&val=1");
?>