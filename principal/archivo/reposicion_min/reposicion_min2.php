<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$freport = $_REQUEST['factor'];
$local   = $_REQUEST['local'];
$marca   = $_REQUEST['marca'];
$marca1  = $_REQUEST['marca1'];
$repon	 = $_REQUEST['repon'];
$fecha   = date('Y-m-d');
//$hour   = date(G);
//$fecha	= CalculaFechaHora($hour);
$referencia = "AUTOMATICO";
$sql1="SELECT codloc,nomloc FROM xcompa where codloc = '$local'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $sucursal        = $row1['codloc'];
			$nomloc          = $row1['nomloc'];
}
}
$sql1="SELECT codloc,nomloc FROM xcompa where nomloc = 'LOCAL0'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $sucursalcent    = $row1['codloc'];
}
}
if ($nomloc == "LOCAL0")
{
	$tabla = 's000';
	$tmin  = 'm00';
}
if ($nomloc == "LOCAL1")
{
	$tabla = 's001';
	$tmin  = 'm01';
}
if ($nomloc == "LOCAL2")
{
	$tabla = 's002';
	$tmin  = 'm02';
}
if ($nomloc == "LOCAL3")
{
	$tabla = 's003';
	$tmin  = 'm03';
}
if ($nomloc == "LOCAL4")
{
	$tabla = 's004';
	$tmin  = 'm04';
}
if ($nomloc == "LOCAL5")
{
	$tabla = 's005';
	$tmin  = 'm05';
}
if ($nomloc == "LOCAL6")
{
	$tabla = 's006';
	$tmin  = 'm06';
}
if ($nomloc == "LOCAL7")
{
	$tabla = 's007';
	$tmin  = 'm07';
}
if ($nomloc == "LOCAL8")
{
	$tabla = 's008';
	$tmin  = 'm08';
}
if ($nomloc == "LOCAL9")
{
	$tabla = 's009';
	$tmin  = 'm09';
}
if ($nomloc == "LOCAL10")
{
	$tabla = 's010';
	$tmin  = 'm10';
}
if ($nomloc == "LOCAL11")
{
	$tabla = 's011';
	$tmin  = 'm11';
}
if ($nomloc == "LOCAL12")
{
	$tabla = 's012';
	$tmin  = 'm12';
}
if ($nomloc == "LOCAL13")
{
	$tabla = 's013';
	$tmin  = 'm13';
}
if ($nomloc == "LOCAL14")
{
	$tabla = 's014';
	$tmin  = 'm14';
}
if ($nomloc == "LOCAL15")
{
	$tabla = 's015';
	$tmin  = 'm15';
}
if ($nomloc == "LOCAL16")
{
	$tabla = 's016';
	$tmin  = 'm16';
}
$sql1="SELECT unidminrepo FROM datagen_det";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $unidminrepo     = $row1[0];
}
}
if ($repon == 1)
{
$sql1="SELECT codpro,s000,$tabla,$tmin,costpr,factor,blister FROM producto inner join titultabladet on codmar = codtab where tiptab = 'M' and s000 > '$unidminrepo' and destab between '$marca' and '$marca1' and incentivado <> '0' order by destab";
}
else
{
$sql1="SELECT codpro,s000,$tabla,$tmin,costpr,factor,blister FROM producto inner join titultabladet on codmar = codtab where tiptab = 'M' and s000 > '$unidminrepo' and destab between '$marca' and '$marca1' order by destab";
}
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $codpro   = $row1['codpro'];
			$s000     = $row1['s000'];
			$stockloc = $row1[2];
			$minloc   = $row1[3];
			$costpr   = $row1['costpr'];
			$factor   = $row1['factor'];
			$blister  = $row1['blister'];
			$reposicion = 0;
			///////PRODUCTOS FRACCIONADOS
			if ($factor > 1)
			{
				if (($blister == 0) || ($blister == 1))
				{
				$reposicion = $minloc - round($stockloc/$factor);
				}
				else
				{
				$reposicion = $minloc - ($stockloc/$factor);
				}
				if (($reposicion > $s000))
				{
				$pripro = $costpr/$factor;
				$subtot = $pripro * $reposicion;
				$stock_prod = $s000 - $reposicion;
				$stocklocalprinc   = $stockloc - $reposicion;
				$cantidad   = "f".$reposicion;
							mysqli_query($conexion,"INSERT INTO reposiciones (codpro,qtypro,qtyprf,prprom,subtot,sucursal,user,pripro,factor) values ('$codpro','$reposicion','$cantidad','$costpr','$subtot','$sucursal','$usuario','$pripro','$factor')");
				mysqli_query($conexion,"UPDATE producto set stopro = '$stocklocalprinc', s000 = '$stock_prod' where codpro = '$codpro'");
				}
			}
			//////PRODUCTOS NO FRACCIONADOS
			else
			{	
				$reposicion = ($minloc - $stockloc);
			//	$reposicion = (($minloc - $stockloc)*$freport)/30;
				if ($reposicion > $s000);
			//	if (($reposicion > $s000) && ($reposicion > $unidminrepo))
				{
				$pripro     = $costpr;
				$subtot     = $costpr * $reposicion;
				$stock_prod = $s000 - $reposicion;
				$stocklocalprinc   = $stockloc - $reposicion;
				$cantidad   =$reposicion;
				mysqli_query($conexion,"INSERT INTO reposiciones (codpro,qtypro,qtyprf,prprom,subtot,sucursal,user,pripro,factor) values ('$codpro','$cantidad','$cantidad','$costpr','$subtot','$sucursal','$usuario','$pripro','$factor')");
				mysqli_query($conexion,"UPDATE producto set stopro = '$stocklocalprinc', s000 = '$stock_prod' where codpro = '$codpro'");
				}
			}
}
}
$sql1="SELECT sum(subtot) FROM reposiciones where user = '$usuario' and sucursal = '$sucursal'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $sumsubtot     = $row1[0];
}
}
$sql="SELECT numdoc FROM movmae where tipmov = '2' and tipdoc = '3' order by numdoc desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$numdoc          = $row[0];		//codigo
}
	$numdoc	= $numdoc + 1;
}
else
{
	$numdoc        = 1;
}
if ($sumsubtot > 0)
{
    	mysqli_query($conexion,"INSERT INTO movmae (invfec,usecod,numdoc,tipmov,tipdoc,proceso,val_habil,sucursal,sucursal1,refere) values ('$fecha','$usuario','$numdoc','2','3','1','0','1','$sucursal','$referencia')");
	//mysqli_query($conexion,"INSERT INTO movmae (invfec,usecod,numdoc,tipmov,tipdoc,proceso,val_habil,sucursal,sucursal1,refere) values ('$fecha','$usuario','$numdoc','2','3','1','0','$sucursalcent','$sucursal','$referencia')");
	$sql1="SELECT invnum,numdoc FROM movmae where tipmov = '2' and tipdoc = '3' and usecod = '$usuario' and proceso = '1' and val_habil = '0'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
				$invnum     = $row1["invnum"];
				$numdoc1    = $row1["numdoc"];
	}
	}
	$sql1="SELECT * FROM reposiciones where user = '$usuario' and sucursal = '$sucursal'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
				$codpro   = $row1['codpro'];
				$qtypro   = $row1['qtypro'];
				$qtyprf   = $row1['qtyprf'];
				$prprom   = $row1['prprom'];
				$pripro   = $row1['pripro'];
				$subtot   = $row1['subtot'];
				$sucursal = $row1['sucursal'];
				$user     = $row1['user'];
				$fact     = $row1['factor'];
				mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr) values ('$invnum','$fecha','$codpro','$qtypro','$qtyprf','$pripro','$subtot','$prprom')");
				mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sucursal) values ('$numdoc1','$codpro','$fecha','2','3','$qtypro','$qtyprf','$fact','$invnum','$usuario','1')")	;
	}
	}
}
mysqli_query($conexion,"DELETE from reposiciones where user = '$usuario' and sucursal = '$sucursal'");
header("Location: reposicion_min1.php");
?>