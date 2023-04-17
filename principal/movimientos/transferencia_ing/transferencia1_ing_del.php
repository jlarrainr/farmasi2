<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum	 = $_POST['cod'];
$sql1 = "DELETE from tempmovmov where invnum = '$invnum'";
mysqli_query($conexion,$sql1);
// if (mysqli_errno($conexion))
//     error_log("Elimina Linea Temp SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
$sql1 = "DELETE from movmov where invnum = '$invnum'";
mysqli_query($conexion,$sql1);
// if (mysqli_errno($conexion))
//     error_log("Elimina Linea Mov SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
$sql1 = "DELETE from movmae where invnum = '$invnum'";
mysqli_query($conexion,$sql1);
// if (mysqli_errno($conexion))
//     error_log("Elimina Linea Mae SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
header("Location: ../ing_salid.php"); 
?>