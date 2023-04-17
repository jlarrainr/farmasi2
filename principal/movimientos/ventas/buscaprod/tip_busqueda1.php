<?php require_once('../../../../conexion.php');
require_once('../../../session_user.php');
session_set_cookie_params(0);
session_start();
$_SESSION['search']		= $_REQUEST['tarjeta']; 
header("Location: tip_busqueda.php?vals=1");
?>