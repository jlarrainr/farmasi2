<?php include('../session_user.php');
	require_once("../../conexion.php");
	header('Content-Type: text/html; charset=iso-8859-1');
	$sql="SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
		 $limit             = $row["limite"];
    }
	}
	$sql= "SELECT despro FROM proveedor order by despro limit $limit";
	$result = mysqli_query($conexion,$sql);	
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		   $datos[count($datos)] = $row["despro"];
	}
	}
    $texto = $_REQUEST["texto"];
	
	// Devuelvo el XML con la palabra que mostramos (con los '_') y si hay �xito o no
	$xml  = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	$xml .= '<datos>';
	foreach ($datos as $dato) {
		if (strpos(strtoupper($dato), strtoupper($texto)) === 0 OR $texto == "") {
			$xml .= '<pais>'.$dato.'</pais>';
		}
	}
	$xml .= '</datos>';
	header('Content-type: text/xml');
	echo $xml;		
?>