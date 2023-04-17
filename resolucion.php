<?php 
session_set_cookie_params(0);
session_start();
//$resol = $_GET['resol'];
$resol = isset($_REQUEST['resol'])? $_REQUEST['resol'] : "";
$_SESSION['resolucion']	= $resol; 
header("Location: index.php");
