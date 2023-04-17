
<?php

require_once('conexion.php');

$sql = "SELECT invnum,numdoc  FROM movmae WHERE estado = '1' and proceso='0' ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnummovmae = $row['invnum'];
        $numdocmovmae = $row['numdoc'];

        echo '$invnum' . "$$$$$$$==" . $invnummovmae . "<br>";

        $sql1 = "SELECT invnum FROM movmov WHERE invnum = '$invnummovmae' ";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $invnum222 = $row1['invnum'];


                echo $invnum222 . "<br>";
                echo "-------movmov----------" . "<br>";
            }
        } else {
            echo 'no existe' . "<br>";
            echo "-------movmov----------" . "<br>";
        }
        $sql1kar = "SELECT codkard FROM kardex WHERE invnum = '$invnummovmae' and nrodoc='$numdocmovmae'";
        $result1kar = mysqli_query($conexion, $sql1kar);
        if (mysqli_num_rows($result1kar)) {
            while ($row1kar = mysqli_fetch_array($result1kar)) {
                $codkard222 = $row1kar['codkard'];


                echo 'kardex' . "========" . $codkard222 . "<br>";
                echo "-----kardex--------" . "<br>";
            }
        } else {
            echo 'no existe' . "<br>";
            echo "-------kardex----------" . "<br>";
        }
    }
}

