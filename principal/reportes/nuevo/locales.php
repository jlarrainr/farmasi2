<?php $sql="SELECT xcompa.codloc,nomloc FROM xcompa inner join usuario on xcompa.codloc = usuario.codloc where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $codigo_local    = $row[0];
	$nomloc    = $row['nomloc'];
}
}
?>