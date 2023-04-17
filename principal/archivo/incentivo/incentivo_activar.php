<?php

include('../../session_user.php');
require_once('../../../conexion.php');
//--------------------------------------------------------------------//
$val = $_REQUEST['val'];
$p1 = $_REQUEST['p1'];
$ord = $_REQUEST['ord'];
$codpro = $_REQUEST['codpro'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros = $_REQUEST['registros'];
$invnum = $_REQUEST['invnum'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$estado = $_REQUEST['estado'];
$desc = $_REQUEST['desc'];

$caomparacion_incentivado = date('Y-m-d');

$sql_incentivo_old = "SELECT invnum_copia  FROM incentivado where invnum = '$invnum'  ";
$result_incentivo_old = mysqli_query($conexion, $sql_incentivo_old);
if (mysqli_num_rows($result_incentivo_old)) {
    while ($row = mysqli_fetch_array($result_incentivo_old)) {
        $invnum_de_copia = $row[0];
    }
}

if (($invnum_de_copia != 0) || ($invnum_de_copia != '')) {

    $sql_incentivo_old = "SELECT estado,dateini,datefin  FROM incentivado where invnum = '$invnum_de_copia'  ";
    $result_incentivo_old = mysqli_query($conexion, $sql_incentivo_old);
    if (mysqli_num_rows($result_incentivo_old)) {
        while ($row_incentivo_old = mysqli_fetch_array($result_incentivo_old)) {
            $estado_de_copia = $row_incentivo_old[0];
            // $dateini_de_copia = $row[1];
            $datefin_de_copia = $row_incentivo_old[2];
        }
    }
    if ($estado_de_copia == 1) {
        if ($date1 <= $datefin_de_copia) {
            $filtro = 1;
            $tipo_sms = 1;
        } else {
            $filtro = 0;
        }
    } else {
        $filtro = 0;
    }
} else {
    $filtro = 0;
}


if ($date2 < $date1) {
    $filtro_fechas = 1;
    $tipo_sms = 2;
} else {
    $filtro_fechas = 0;
}

/*
echo 'datefin_de_copia ' . $datefin_de_copia . "<br>";
echo 'date1 ' . $date1 . "<br>";
echo 'invnum_de_copia ' . $invnum_de_copia . "<br>";
echo 'estado ' . $estado . "<br>";
echo 'filtro_fechas ' . $filtro_fechas . "<br>";
echo 'filtro ' . $filtro . "<br>";
*/
if (($estado == 1) && ($filtro_fechas == 1) || ($filtro == 1)) {

    header("Location: incentivo1.php?p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&mensaje=1&tipo_sms=$tipo_sms");
} else {


    //--------------------------------------------------------------------//
    $sql = "SELECT codpro FROM incentivadodet where invnum = '$invnum' group by codpro";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row["codpro"];

            $sqldet = "SELECT COUNT(*) FROM incentivadodet where codpro = '$codpro'";
            $resultdet = mysqli_query($conexion, $sqldet);
            if (mysqli_num_rows($resultdet)) {
                while ($rowdet = mysqli_fetch_array($resultdet)) {
                    $contador_de_productos = $rowdet[0];
                }
            }
            //SI EL PRODUCTO CUENTA CON MAS INCENTIVOS NO PODRA DESACTIVARSE 
            if ($contador_de_productos == 1) {
                mysqli_query($conexion, "UPDATE producto set incentivado = '$estado' where codpro = '$codpro'");
            }
        }
    }
    //--------------------------------------------------------------------//
    mysqli_query($conexion, "UPDATE incentivado set descripcion ='$desc',dateini = '$date1',datefin = '$date2',estado = '$estado' where invnum = '$invnum'");
    mysqli_query($conexion, "UPDATE incentivadodet set estado = '$estado' where invnum = '$invnum'");
    //--------------------------------------------------------------------//
    if ($estado <> 0) {
        $sql = "SELECT incentivado.invnum,dateini,datefin,codpro FROM incentivado inner join incentivadodet on incentivado.invnum = incentivadodet.invnum where incentivado.estado = '1' and incentivado.invnum = '$invnum' and incentivadodet.estado = '1' order by incentivado.invnum";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $invnumIncentivo = $row['invnum'];
                $codpro = $row['codpro'];
                //BUSCO EN LAS VENTAS QUE EST�N ENTRE LAS FECHAS SELECCIONADAS PARA APLICAR EL INCENTIVO
                $sqlX = "SELECT invnum FROM detalle_venta where codpro = $codpro and invfec between '$date1' and '$date2'";
                $resultX = mysqli_query($conexion, $sqlX);
                if (mysqli_num_rows($resultX)) {
                    while ($rowX = mysqli_fetch_array($resultX)) {
                        $invnumVent = $rowX['invnum'];
                        mysqli_query($conexion, "UPDATE detalle_venta set incentivo = '$invnumIncentivo' where invnum = '$invnumVent' and codpro = $codpro");
                    }
                }
                //LOS QUE NO ESTEN EN ESTE RANGO SIMPLEMENTE EL INCENTIVO DE LA VENTA SERA IGUAL A CERO
                $sqlY = "SELECT invnum FROM detalle_venta where codpro = $codpro and incentivo = '$invnumIncentivo' and invfec not between '$date1' and '$date2'";
                $resultY = mysqli_query($conexion, $sqlY);
                if (mysqli_num_rows($resultY)) {
                    while ($rowY = mysqli_fetch_array($resultY)) {
                        $invnumVent2 = $rowY['invnum'];
                        mysqli_query($conexion, "UPDATE detalle_venta set incentivo = '0' where invnum = '$invnumVent2' and codpro = $codpro");
                    }
                }
            }
        }
    }
    header("Location: incentivo1.php?p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&mensaje=2");
}
