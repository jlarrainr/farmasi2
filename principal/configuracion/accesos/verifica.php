<?php require_once ('../../../conexion.php');
include('../../session_user.php');
$pass	= $_REQUEST['pass'];
$sql = "SELECT passuser FROM datagen WHERE passuser = '$pass'";
$result = mysqli_query($conexion,$sql);
if($row = mysqli_fetch_array($result)){
Header("Location: acceso.php");
}
else
{
Header("Location: index.php?error=2");
}
?>