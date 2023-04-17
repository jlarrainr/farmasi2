<?php
require_once("../../../conexion.php");
include('../../session_user.php');

mysqli_query($conexion,"UPDATE usuario SET eliminado ='1' where estado ='0'");

header("Location: acceso2.php");

?>