<?php

require_once("../../../conexion.php");
include('../../session_user.php');
$usuario = $_REQUEST['login'];

if ($usuario <> "") {
    $sql = "SELECT logusu FROM usuario WHERE logusu = '$usuario' and eliminado='0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        echo '<a style="color:red;">Ya existe alguien con ese Usuario.</a>';
    } else {

        echo '<a style="color:#00df11;">Usuario Disponible</a>';
    }
}
