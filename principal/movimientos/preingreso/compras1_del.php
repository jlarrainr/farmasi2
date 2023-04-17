<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum	 = $_POST['cod'];
$ok  	 = $_POST['ok'];
/*$sql="SELECT codpro FROM tempmovmov where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$codpro    = $row['codpro'];
		mysqli_query($conexion,"UPDATE producto set tcosto = '0',tmargene = '0',tprevta= '0',tpreuni = '0' where codpro = '$codpro'");
}
}
*/
mysqli_query($conexion,"DELETE from tempmovmov where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from tempmovmov_bonif where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from movmov where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from templote where invnum = '$invnum'");
mysqli_query($conexion,"DELETE from movmae where invnum = '$invnum'");
header("Location: ../ing_salid.php"); 
?>