<?php

require_once('../../../../conexion.php'); //CONEXION A BASE DE DATOS
$letters = strtolower($_REQUEST["term"]);
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
$items[] = array();
$CadenaBusk = substr($letters, 0, 1);
if (is_numeric($CadenaBusk)) {

    if (strlen($letters) >= 11) {
        $res = mysqli_query($conexion, "select codcli,descli,dnicli,email,ruccli from cliente where ruccli like '" . $letters . "%' limit $limit") or die(mysqli_error());
    } else {
        $res = mysqli_query($conexion, "select codcli,descli,dnicli,email,ruccli from cliente where dnicli like '" . $letters . "%' limit $limit") or die(mysqli_error());
    }

    while ($inf = mysqli_fetch_array($res)) {
        $Codigo = $inf['codcli'];
        $Cliente = $inf['descli'];
        $Email = $inf['email'];
        $RUC = $inf['ruccli'];
        array_push($items, array("id" => $Codigo, "label" => $Cliente, "value" => $Cliente, "Mail" => $Email, "Ruc" => $RUC));
    }
} else {
    $res = mysqli_query($conexion, "select codcli,descli,dnicli,email,ruccli from cliente where descli like '" . $letters . "%' limit $limit") or die(mysqli_error());
    while ($inf = mysqli_fetch_array($res)) {
        $Codigo = $inf['codcli'];
        $Cliente = $inf['descli'];
        $Email = $inf['email'];
        $RUC = $inf['ruccli'];
        array_push($items, array("id" => $Codigo, "label" => $Cliente, "value" => $Cliente, "Mail" => $Email, "Ruc" => $RUC));
    }
}
echo json_encode($items);
exit;
?>
