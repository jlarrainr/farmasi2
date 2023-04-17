<?php
session_set_cookie_params(0);
session_start();
//$resol = $_GET['resol'];
$ingreso2 = isset($_REQUEST['ingreso2']) ? $_REQUEST['ingreso2'] : "";
$_SESSION['ingreso_session']    = $ingreso2;
header("Location: index.php");
