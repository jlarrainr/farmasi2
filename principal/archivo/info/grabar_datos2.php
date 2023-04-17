<?php include('../../session_user.php');
require_once('../../../conexion.php');

$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];

 
 mysqli_query($conexion,"truncate TABLE temp_info");

header("Location:info2.php?search=$search&val=1");
?>