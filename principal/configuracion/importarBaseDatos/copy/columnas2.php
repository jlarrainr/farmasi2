<?php $b1  = $_REQUEST['b1'];
require_once('conexion.php'); 
$i=0;
$r=0;
$z=0;
$sql="SHOW FIELDS FROM producto";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
$r++;
}
}
$sql="SHOW FIELDS FROM producto";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
$i++;
	$col[$i]  		= $row[0];
	if ($i == $r)
	{
	$tot			= $tot.','.$col[$i];
	}
	else
	{
		if ($i == 1)
		{
		$tot			= $col[$i];
		}
		else
		{
		$tot			= $tot.','.$col[$i];
		}
	}
}
}
$sql="select $tot FROM producto";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
$z = 0;
	while($z < $r)
	{
		$prod  		= $row[$z];
		if ($z == 0)
		{
		}
		else
		{
			if ($z == 1)
			{
			$prods		= "'".$prod."'";
			}
			else
			{
			$prods		= $prods.",'".$prod."'";
			}
		}
	$z++;
	}
	$b2  = $_REQUEST['b2'];
	$sql1="select codpro FROM producto order by codpro desc limit 1";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$codp  		= $row1[0];
	}
	}
	$codp++;
	$productos = "'".$codp."',".$prods;
	mysqli_query($conexion, "INSERT INTO producto($tot) VALUES ($productos)");
}
}
header("Location: index.php?cod=1");
?>