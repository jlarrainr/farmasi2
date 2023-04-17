<?php require_once ('../../../conexion.php');
include('../../session_user.php');
$codgrup	= $_REQUEST['codgrup'];
$user   	= $_REQUEST['user'];
mysqli_query($conexion,"update usuario set estado = '0' where usecod = '$user'")	;
Header("Location: acceso_user_listado.php?codgrup=$codgrup");
?>