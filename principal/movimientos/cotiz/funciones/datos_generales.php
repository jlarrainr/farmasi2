<?php $sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}

$numero_xcompa = substr($nomloc, 5, 2);
    $tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);
    
    
$sql="SELECT cuscod FROM cotizacion where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$cuscod    = $row['cuscod'];
}
}
$sql="SELECT descli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nombre_cliente    = $row['descli'];
}
}

  
    
    