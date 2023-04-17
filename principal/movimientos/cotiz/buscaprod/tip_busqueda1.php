<?php require_once("../../../../conexion.php");
include('../../../session_user.php');
session_set_cookie_params(0);
session_start();
$_SESSION['searchcot']		= $_REQUEST['tarjeta']; 
Header("Location: tip_busqueda.php?vals=1");
//$search		= $_REQUEST['tarjeta']; 
//Header("Location: tip_busqueda.php?vals=1&search=$search");
?>