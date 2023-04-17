<?php

require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
if (isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters'])) {
    $letters = $_REQUEST['letters'];
    //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
    $sql = "SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $limit = $row["limite"];
        }
    }
    if ($limit == 0) {
        $limit = 15;
    }
    $res = mysqli_query($conexion, "select codcli,descli,puntos,dnicli,ruccli from cliente where descli like '" . $letters . "%' or ruccli like '%" . $letters . "%' or dnicli like '%" . $letters . "%'  limit $limit ") or die(mysqli_error());
    while ($inf = mysqli_fetch_array($res)) {
        $ruccli = $inf['ruccli'];
        {
            $cad = "<u><b>DNI:</b> " . $inf['dnicli'] . " <b>DES:</b>:" . $inf['descli'] . " <b>RUC:</b> " . $inf['ruccli'] . " <b>Puntos:</b>" . $inf['puntos'] . " </u>" . "|";
        }
        echo $inf["codcli"] . "###" . $cad;
    }
}
?>
