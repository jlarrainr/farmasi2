<?php

if (!isset($_SESSION['codigo_local'])) {
    $sql = "SELECT nomloc,xcompa.codloc,nombre FROM usuario inner join xcompa on usuario.codloc = xcompa.codloc where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $desc_local = $row[2];
            $nombre_local = $desc_local <> '' ? $desc_local : $row['nomloc'];
            $nomloc = $row['nomloc'];
            $tablanom_local = $nomloc;
            $codigo_local = $row[1];

            $_SESSION['desc_local'] = $desc_local;
            $_SESSION['nomloc'] = $nomloc;
            $_SESSION['codigo_local'] = $codigo_local;
        }
    }
} else {
    $desc_local = $_SESSION['desc_local'];
    $nomloc = $_SESSION['nomloc'];
    $nombre_local = $desc_local <> '' ? $desc_local : $nomloc;
    $tablanom_local = $nomloc;
    $codigo_local = $_SESSION['codigo_local'];
}
?>