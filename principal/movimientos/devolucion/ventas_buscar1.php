<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

mysqli_connect($hostname, $username, $password) or die("Unable to connect to database!");
mysqli_select_db($dbname);

$q = $_REQUEST["q"];

$pagesize = 50;

//mysqli_query($conexion,"set names utf8");

$sql = "select * from producto where locate('$q', desprod) > 0 order by locate('$q', desprod), desprod limit $pagesize";
$results = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_array($results)) {
	$id = $row["codpro"];
	$name = ucwords(strtolower($row["desprod"]));
	$html_name = preg_replace("/(" . $q . ")/i", "<b>\$1</b>", $name);
	echo "<li onselect=\"this.text.value = '$name';\"><span>$id</span>$name</li>\n";
}
mysqli_close($conexion);
