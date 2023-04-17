<?php include('../../session_user.php');
require_once('../../../conexion.php');
$cod        = $_REQUEST['cod'];        ///CODIGO UTILIZADO PARA ELIMINAR
$codtemp    = $_REQUEST['codtemp'];
$invnum     = $_REQUEST['invnum'];
$delete     = $_REQUEST['delete'];
$text1     = $_REQUEST['text1'];
$text2     = $_REQUEST['text2'];
$text3     = $_REQUEST['text3'];
$subtotal2     = $_REQUEST['subtotal2'];
$number     = $_REQUEST['number'];

// echo 'cod = ' . $cod . "<br>";
// echo 'codtemp = ' . $codtemp . "<br>";
// echo 'invnum = ' . $invnum . "<br>";
// echo 'delete = ' . $delete . "<br>";
// echo "<hr>" . "<br>";
// echo 'text1 = ' . $text1 . "<br>";
// echo 'text2x = ' . $text2 . "<br>";
// echo 'text3 = ' . $text3 . "<br>";
// echo 'subtotal2 = ' . $subtotal2 . "<br>";
// echo 'number = ' . $number . "<br>";

if ($delete == 1) {

    mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$invnum' and codtemp='$codtemp' and idlote_salida='$cod'");
} else {

    if ($number == 0) {
        mysqli_query($conexion, "UPDATE tempmovmov set qtypro = '$text1', qtyprf ='', pripro = '$text3', costre = '$text2',costpr= '$text3' where invnum = '$invnum' and codtemp='$codtemp' and idlote_salida='$cod' ");
    } else {
        mysqli_query($conexion, "UPDATE tempmovmov set qtypro = '',qtyprf = '$text1', pripro = '$text3', costre = '$text2',costpr= '$text3' where invnum = '$invnum' and codtemp='$codtemp' and idlote_salida='$cod'");
    }
}


header("Location: salidas_varias_lote1.php");
