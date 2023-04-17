<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum	 = $_POST['cod'];
mysqli_query($conexion,"DELETE from tempmovmov where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from movmov where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from movmae where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from templote where invnum = '$invnum'");
header("Location: ../ing_salid.php"); 
?>