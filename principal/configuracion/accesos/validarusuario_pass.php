<?php

require_once("../../../conexion.php");
include('../../session_user.php');
$usuario = $_REQUEST['login'];
$codigo = $_REQUEST['codigo'];
if (($usuario <> "") && ($codigo <> "")) {
    //echo $usuario ."--".$codigo;
    $sql = "SELECT logusu FROM usuario WHERE logusu = '$usuario' and pasusu='$codigo' and eliminado='0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        echo '<a style="color:red;">Ya existe alguien con ese Usuario y Contrase&ntilde;a.</a>';
        //    echo 1;

    } else {

        echo '<a style="color:blue;">Usuario Disponible</a>';
    }
}
