require_once('conexion.php');

$sql = "SELECT sum(costre) as costre, movmae.tipmov, movmae.tipdoc, movmae.invnum
        FROM movmov
        INNER JOIN movmae ON movmae.invnum = movmov.invnum
        group by movmae.tipmov, movmae.tipdoc, movmae.invnum
        ORDER BY movmae.invnum";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)) {
while ($row = mysqli_fetch_array($result)) 
{
        $costre    = $row['costre'];
        $tipmov    = $row['tipmov'];
        $tipdoc    = $row['tipdoc'];
        $invnum    = $row['invnum'];
        mysqli_query($conexion,"UPDATE movmae set invtot  = '$costre' where invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'");
        //echo "UPDATE movmae set invtot  = '$costre' where invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
        //echo "<br>";
        
}
}
?>
