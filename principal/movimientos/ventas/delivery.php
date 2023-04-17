<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
$venta = $_SESSION['venta'];
$delivery = $_REQUEST['delivery'];
mysqli_query($conexion, "UPDATE venta set delivery='$delivery'  where invnum = '$venta'");

header("Location: venta_index1.php?delivery=$delivery");
