<?php require_once ('../../conexion.php');
include('../session_user.php');
$buscar	=$_POST['textos'];
$user	=$_POST['user'];
$sql="SELECT usecod FROM movmae where numdoc = '$buscar' and tipmov = '1' and tipdoc = '1' and proceso = '0' and val_habil = '0'";///PROCESO = 0 ---- COMPRA TERMINADA  VAL_HABIL 0 HABILITADO 1 DESHABILTADO
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){	////USUARIO QUUIEN REALIZO LA COMPRA Y SI LA COMPRA EXISTE
		$usuario_compra    = $row['usecod'];
}
	$sql1="SELECT codloc FROM usuario where usecod = '$usuario_compra'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$codigo_local    = $row1['codloc'];			////LOCAL DE QUIEN HIZO LA COMPRA
	}
	}
	//echo $codigo_local;
	$sql1="SELECT codloc FROM usuario where usecod = '$user'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$codigo_local1    = $row1['codloc'];		////LOCAL DE QUIEN ACCEDE A ESTA COMPRA
	}
	}
	//echo $codigo_local1;
	if ($codigo_local == $codigo_local1)
	{
	$_SESSION['invnum']			= $buscar; 
	Header("Location: compras.php?val=1&ok=1"); 
	}
	else
	{
	Header("Location: compras.php?val=1&ok=2"); //no tiene permiso para verlo
	}
}
else
{
Header("Location: compras.php?val=1&ok=3"); //no se encuentra en el sist
}
?>