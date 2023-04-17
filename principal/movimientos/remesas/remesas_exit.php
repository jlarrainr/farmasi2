<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$remesa   	  = $_SESSION['remesa'];
$sql="SELECT invnum FROM remesa where invnum ='$remesa'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		mysqli_query($conexion,"DELETE from remesa where invnum = '$invnum'");
		mysqli_query($conexion,"DELETE from gasres where invnum = '$invnum'");
}
}
header("Location: ../../index.php");
?>