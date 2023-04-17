<?php include('../../../session_user.php');
$invnum  = $_SESSION['ingresos_val'];
require_once ('../../../../conexion.php');
$numero  = $_REQUEST['country_ID'];
$country = $_REQUEST['country'];
$codpro  = $_REQUEST['codpro'];
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
				$codloc    = $row['codloc'];
	}
}
if ($country <> "")
{
		if ($numero <> $country)
		{
		$numero = $country;
		}
		$sql1="SELECT numlote,vencim FROM movlote where numlote = '$numero' and codpro = '$codpro' and codloc='$codloc'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1))
		{
			$numlote        = $row1['numlote'];
			$vencimi        = $row1['vencim'];
		}
		/////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
			$sql2="SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2))
			{
			mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi' where invnum = '$invnum' and codpro = '$codpro'");
			}
			else
			{
			mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim, codloc) values ('$invnum','$numlote','$codpro','$vencimi','$codloc')");
			}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else
		{
		/////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
			$sql2="SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$codpro'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2))
			{
			mysqli_query($conexion, "UPDATE templote set numerolote = '$numero',vencim = '' where invnum = '$invnum' and codpro = '$codpro'");
			}
			else
			{
			mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro, codloc) values ('$invnum','$numero','','$codpro','$codloc')");
			}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		}	
}
header("Location: lote.php?cod=$codpro");
?>