
<?php
require_once('../conexion.php');


//  mysqli_query($conexion, "TRUNCATE precios_por_local");
 
 
 
// $sql = "SELECT codpro FROM producto WHERE codpro BETWEEN 0 and 1000 ";
$sql = "SELECT codpro FROM producto  order by codpro";
// $sql = "SELECT codpro FROM producto LIMIT 9000,10000";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro = $row[0];


        mysqli_query($conexion, "INSERT INTO precios_por_local (codpro) values ('$codpro')");
    }
}
