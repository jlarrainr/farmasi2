<?php 
require_once ('conexion.php');
$numero = 0;
$sql="SELECT invnum FROM movmae order by invnum";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		$numero++;
		mysqli_query($conexion,"UPDATE movmae set numdoc = '$numero' where invnum = '$invnum'");
}
}
$sql="SELECT movmae.tipmov,movmae.tipdoc,movmae.invnum,movmae.numdoc FROM kardex inner join movmae on kardex.invnum = movmae.invnum where kardex.tipmov = movmae.tipmov and kardex.tipdoc = movmae.tipdoc";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$invnum    = $row['invnum'];
		$numdoc    = $row['numdoc'];
		mysqli_query($conexion,"UPDATE kardex set nrodoc = '$numdoc' where invnum = '$invnum' and tipmov = '$tipmov' and $tipdoc = '$tipdoc'");
}
}
?>