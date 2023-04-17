<?php
require_once("../../../conexion.php");
include('../../session_user.php');
$codgrup= $_REQUEST['codgrup'];
header("Location: acceso_user_listado.php?codgrup=$codgrup");

?>