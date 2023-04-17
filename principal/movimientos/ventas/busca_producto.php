<?php
require_once('../../session_user.php');
require_once("../../../conexion.php");
header('Content-Type: text/html; charset=iso-8859-1');
$sql = "SELECT * FROM producto order by desprod";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$datos[count($datos)] = $row['desprod'];
	}
}
$texto = $_REQUEST['texto'];
// Devuelvo el XML con la palabra que mostramos (con los '_') y si hay �xito o no
$xml  = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$xml .= '<datos>';
foreach ($datos as $dato) {
	if (strpos(strtoupper($dato), strtoupper($texto)) === 0 or $texto == "") {
		$xml .= '<pais>' . $dato . '</pais>';
	}
}
$xml .= '</datos>';
header('Content-type: text/xml');
echo $xml;
