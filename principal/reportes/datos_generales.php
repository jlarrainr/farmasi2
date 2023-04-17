<?php

$nomloc = "";
$sql = "SELECT nomloc FROM xcompa where codloc = '$local'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
    }
}
if ($nomloc == "LOCAL0") {
    $tabla = 's000';
    $tabla1 = 'm00';
}
if ($nomloc == "LOCAL1") {
    $tabla = 's001';
    $tabla1 = 'm01';
}
if ($nomloc == "LOCAL2") {
    $tabla = 's002';
    $tabla1 = 'm02';
}
if ($nomloc == "LOCAL3") {
    $tabla = 's003';
    $tabla1 = 'm03';
}
if ($nomloc == "LOCAL4") {
    $tabla = 's004';
    $tabla1 = 'm04';
}
if ($nomloc == "LOCAL5") {
    $tabla = 's005';
    $tabla1 = 'm05';
}
if ($nomloc == "LOCAL6") {
    $tabla = 's006';
    $tabla1 = 'm06';
}
if ($nomloc == "LOCAL7") {
    $tabla = 's007';
    $tabla1 = 'm07';
}
if ($nomloc == "LOCAL8") {
    $tabla = 's008';
    $tabla1 = 'm08';
}
if ($nomloc == "LOCAL9") {
    $tabla = 's009';
    $tabla1 = 'm09';
}
if ($nomloc == "LOCAL10") {
    $tabla = 's010';
    $tabla1 = 'm10';
}
if ($nomloc == "LOCAL11") {
    $tabla = 's011';
    $tabla1 = 'm11';
}
if ($nomloc == "LOCAL12") {
    $tabla = 's012';
    $tabla1 = 'm12';
}
if ($nomloc == "LOCAL13") {
    $tabla = 's013';
    $tabla1 = 'm13';
}
if ($nomloc == "LOCAL14") {
    $tabla = 's014';
    $tabla1 = 'm14';
}
if ($nomloc == "LOCAL15") {
    $tabla = 's015';
    $tabla1 = 'm15';
}
if ($nomloc == "LOCAL16") {
    $tabla = 's016';
    $tabla1 = 'm16';
}
?>