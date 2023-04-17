
<?php

require_once('../conexion.php');

$zzcodloc = '1';

require_once('../precios_por_local.php');



$sql = "SELECT nomloc  FROM xcompa where codloc = '$zzcodloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomlocalG = $row['nomloc'];
       
    }
}

$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$sql = "SELECT codpro,s000,costre,prevta,preuni,utlcos,costpr,margene,prelis,pcostouni,blister,preblister,cantventaparabonificar,codprobonif,cantbonificable,tcosto,tmargene,tprevta,tpreuni,tcostpr,costod,ultpcostouni,mardis FROM producto   ORDER by codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro = $row[0];
        
        $stock = $row[1];

        $costre = $row[2];
        $prevta = $row[3];
        $preuni = $row[4];
        $utlcos = $row[5];
        $costpr = $row[6];
        $margene = $row[7];
        $prelis = $row[8];
        $pcostouni = $row[9];
        $blister = $row[10];
        $preblister = $row[11];
        $cantventaparabonificar = $row[12];
        $codprobonif = $row[13];
        $cantbonificable = $row[14];
        $tcosto = $row[15];
        $tmargene = $row[16];
        $tprevta = $row[17];
        $tpreuni = $row[18];
        $tcostpr = $row[19];
        $costod = $row[20];
        $ultpcostouni = $row[21];
        $mardis = $row[22];


        //////////////// OJO ////////////////////////////////////
        //////////////// OJO ////////////////////////////////////
        //////////////// OJO ////////////////////////////////////
        //////////////// OJO ////////////////////////////////////

       //mysqli_query($conexion, "UPDATE producto set $tabla = '$stock' where codpro = '$codpro'");
       
       
       //////////////// OJO ////////////////////////////////////
       //////////////// OJO ////////////////////////////////////
       //////////////// OJO ////////////////////////////////////
       //////////////// OJO ////////////////////////////////////
       
        mysqli_query($conexion, "UPDATE precios_por_local set  $utlcos_p = '$utlcos',$costpr_p = '$costpr',$costre_p = '$costre',  $prevta_p = '$prevta',    $preuni_p = '$preuni',    $margene_p = '$margene', $blister_p = '$blister',    $preblister_p = '$preblister',    $prelis_p = '$prelis',    $pcostouni_p = '$pcostouni',    $cantventaparabonificar_p = '$cantventaparabonificar',    $codprobonif_p = '$codprobonif',    $cantbonificable_p = '$cantbonificable',    $tcosto_p = '$tcosto',    $tmargene_p = '$tmargene',    $tprevta_p = '$tprevta',    $tpreuni_p = '$tpreuni',    $tcostpr_p = '$tcostpr',    $costod_p = '$costod',    $ultpcostouni_p = '$ultpcostouni',$mardis_p = '$mardis' where codpro = '$codpro'");
       
    }
}
