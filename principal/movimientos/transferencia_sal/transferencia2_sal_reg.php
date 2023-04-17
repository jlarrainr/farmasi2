<?php
include('../../session_user.php');
require_once('../../../conexion.php');
$invnum  = $_SESSION['transferencia_sal'];
$cod     = $_REQUEST['cod'];            ////CODIGO DEL PRODUCTO EN EL LOCAL
$text1   = $_REQUEST['text1'];    ///cantidad ingresada
$text2   = $_REQUEST['text2'];    ///precio promedio
$text3   = $_REQUEST['text3'];    ///total
$number  = $_REQUEST['number']; ///factor

/*ECHO $text1."<br>";
ECHO $text2."<br>";
ECHO $text3."<br>";
ECHO $number;
EXIT;*/
$sql = "SELECT codtemp FROM tempmovmov order by codtemp desc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codtemp       = $row[0];
    }
    $codtemp = $codtemp + 1;
} else {
    $codtemp = 1;
}

$contador_de_transfe = 0;
$sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $contador_de_transfe = $row[0];  //codigo
    }
    $contador_de_transfe += 1;
} else {
    $contador_de_transfe = 1;
}
if ($number == 0) {
    //echo "INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')";exit;
    //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");
    mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr,orden) values ('$invnum','$cod','$text1','$text2','$text3','$text2','$contador_de_transfe')");
} else {
    //echo "INSERT INTO tempmovmov (codtemp,invnum,codpro,qtyprf,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')";exit;
    //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtyprf,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$text2','$text3','$text2')");
    mysqli_query($conexion, "INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr,orden) values ('$invnum','$cod','$text1','$text2','$text3','$text2','$contador_de_transfe')");
}
header("Location: transferencia1_sal.php");
