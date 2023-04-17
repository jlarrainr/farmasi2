<?php 
include('session_user.php');
require_once('../conexion.php');
mysqli_query($conexion,"UPDATE usuario set ingreso = '0',ingreso2='0' where usecod = '$usuario'");

    session_start();
    $_SESSION = array();
    session_destroy();
header("Location: ../index.php");
