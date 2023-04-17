<?php

$sql1 = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'   ";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {

        $conteo     = $row1[0];  //codigo

    }
}

if ($conteo == 0) {
    $sql1 = "SELECT * FROM movmov where invnum = '$codorigen'  order by orden";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        $i = 0;
        while ($row1 = mysqli_fetch_array($result1)) {
            $i++;
            $qtypro     = $row1["qtypro"];  //codigo
            $qtyprf     = $row1["qtyprf"];
            $pripro     = $row1["pripro"];
            $costre     = $row1["costre"];
            $codpro     = $row1["codpro"];
            $numlote    = $row1["numlote"];
            $orden    = $row1["orden"];


            $sql1 = "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,pripro,costre,costpr,invnumrecib,numlote,orden ) values ('$invnum','$codpro','$qtypro','$qtyprf','$pripro','$costre','$pripro','$invnumrecib', '$numlote','$i')";
            mysqli_query($conexion, $sql1);
        }
    }
}
