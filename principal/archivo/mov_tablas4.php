<?php
include('../session_user.php');
require_once("../../conexion.php");
$btn    = $_POST['btn'];
$desc    = $_POST['desc'];
$tipo    = $_POST['tipo'];            //// SI ES MARCA ETC
$tipodes = $_POST['tipodes'];
if ($tipodes == "MARCA") {
    //$abrev = $desc;
    $abrev    = $_POST['abrev'];
}
$departamento    = $_POST['departamento'];
$provincia    = $_POST['provincia'];
$tdoc        = $_POST['tdoc'];
if ($departamento != "") {
    $desctipo = $departamento;
}
if ($provincia != "") {
    $desctipo = $provincia;
}
if ($tdoc != "") {
    $rrrr = $tdoc;
}
function quitar($mensaje)
{
    $mensaje = str_replace("<", "&lt;", $mensaje);
    $mensaje = str_replace(">", "&gt;", $mensaje);
    $mensaje = str_replace("\'", "&#39;", $mensaje);
    $mensaje = str_replace('\"', "&quot;", $mensaje);
    $mensaje = str_replace("\\\\", "&#92;", $mensaje);
    return $mensaje;
}
$sql = "SELECT cdgen FROM titultabla where ltdgen = '$tipo'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $cdgen                 = $row["cdgen"];
    }
}
$abrev = substr($abrev, 0, 10);
////////////////////////////////////////////////////////////REGISTRO
if ($btn == 1) {
    $sql = "SELECT tiptab, destab FROM titultabladet WHERE tiptab='$tipo' and destab='$desc'";
    $result = mysqli_query($conexion, $sql);
    if ($row = mysqli_fetch_array($result)) {
        //header("Location: mov_prod.php?error=2");
        header("Location: mov_tablas2.php?cod=" . $cdgen . "&error=1");
    } else {
        if ($tipodes == "MARCA") {
            $sqlf = "SELECT abrev FROM titultabladet where abrev='$abrev'";
            $resultf = mysqli_query($conexion, $sqlf);
            if ($rowf = mysqli_fetch_array($resultf)) {
                header("Location: mov_tablas2.php?cod=" . $cdgen . "&error=1");
            } else {
                mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,cdgen,abrev) values ('$tipo','$desc','$desctipo','$abrev')");
                header("Location: mov_tablas2.php?cod=" . $cdgen . "&ok=1");
            }
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab,cdgen,abrev,campo) values ('$tipo','$desc','$desctipo','$abrev','$rrrr')");
            header("Location: mov_tablas2.php?cod=" . $cdgen . "&ok=1");
        }
    }
}
////////////////////////////////////////////////////////////MODIFICO
if ($btn == 2) {
    $codtab    = $_POST['codtab'];
    $sql = "SELECT destab FROM titultabladet where codtab = '$codtab'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $destab                 = $row["destab"];
        }
    }
    if ($tipodes == "MARCA") {
        /* $sqlf = "SELECT abrev FROM titultabladet where abrev='$abrev'";
            $resultf = mysqli_query($conexion,$sqlf);
            if($rowf = mysqli_fetch_array($resultf))
            {
                header("Location: mov_tablas2.php?cod=".$cdgen."&error=1");
            }
            else
            {
                mysqli_query($conexion,"UPDATE titultabladet set destab = '$desc',abrev = '$abrev',campo = '$rrrr' where codtab = '$codtab'")	;
                header("Location: mov_tablas2.php?cod=".$cdgen."&up=1");
            }*/
        mysqli_query($conexion, "UPDATE titultabladet set destab = '$desc',abrev = '$abrev',campo = '$rrrr' where codtab = '$codtab'");
        header("Location: mov_tablas2.php?cod=" . $cdgen . "&up=1");
    } else {
        if ($desc == $destab) {
            mysqli_query($conexion, "UPDATE titultabladet set destab = '$desc',abrev = '$abrev',campo = '$rrrr' where codtab = '$codtab'");
            header("Location: mov_tablas2.php?cod=" . $cdgen . "&up=1");
        } else {
            /*$sql = "SELECT tiptab, destab FROM titultabladet WHERE tiptab='$tipo' and destab='$desc'";
                $result = mysqli_query($conexion,$sql);
                if($row = mysqli_fetch_array($result))
                {
                //header("Location: mov_prod.php?error=2");
                header("Location: mov_tablas2.php?cod=".$cdgen."&error=1");
                }
                else
                {*/
            mysqli_query($conexion, "UPDATE titultabladet set destab = '$desc',abrev = '$abrev',campo = '$rrrr' where codtab = '$codtab'");
            header("Location: mov_tablas2.php?cod=" . $cdgen . "&up=1");
            //}
        }
    }
}
///////////////////////////////////////////////////////////ELIMINO
if ($btn == 3) {
    $codtab    = $_POST['codtab'];
    mysqli_query($conexion, "DELETE from titultabladet where codtab = '$codtab'");
    mysqli_query($conexion, "DELETE from titultabladet where cdgen = '$codtab'");
    header("Location: mov_tablas2.php?cod=" . $cdgen . "&del=1");
}
