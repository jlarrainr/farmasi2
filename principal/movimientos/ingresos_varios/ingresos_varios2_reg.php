<?php include('../../session_user.php');
require_once('../../../conexion.php');
$invnum = $_SESSION['ingresos_val'];
$cod = $_REQUEST['cod'];   ////CODIGO DEL PRODUCTO EN EL LOCAL
$text1 = $_REQUEST['text1']; ///cantidad ingresada
$costre = $_REQUEST['text2P']; ///precio promedio
$text3 = $_REQUEST['text3P']; ///total

$textlote = $_REQUEST['textlote']; ///lote
$mesL = $_REQUEST['mesL']; ///vencimiento
$yearsL = $_REQUEST['yearsL']; ///vencimiento
$locall = $_REQUEST['locall']; ///local
$usu = $_REQUEST['usu']; ///usuario
$number = $_REQUEST['number']; ///factor
$stopro = $_REQUEST['stockpro']; ///stock antiguo
$factor = $_REQUEST['factor2']; ///stock antiguo
$costpr = $_REQUEST['costpr2']; ///stock antiguo
$valor = '0';
$textlote = strtoupper($textlote);
$cuento = strlen($mesL);
if ($cuento == '2') {
    $mes = $mesL;
} else {
    $mes = '0' . $mesL;
}

$textven = $mes . "/" . $yearsL;



//echo '$cod ==' . $cod . "<br>";
//echo '$text1 ==' . $text1 . "<br>";
//echo '$costre ==' . $costre . "<br>";
//echo '$text3 ==' . $text3 . "<br>";
//echo '$stopro ==' . $stopro . "<br>";
//echo '$number ==' . $number . "<br>";


$sql = "SELECT invnum FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum_filtro = $row["invnum"];  //codigo

    }
}

// //echo $invnum_filtro;
if (($invnum_filtro == 0) || ($invnum_filtro == '')) {

    header("Location: ingresos_varios1.php?filtro=1");
} else {


    $sql = "SELECT codtemp FROM tempmovmov order by codtemp desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codtemp = $row[0];
        }
        $codtemp = $codtemp + 1;
    } else {
        $codtemp = 1;
    }

    if ($number == 0) {
        /////HALLAR NUEVO COSTO PROMEDIO
        $promedio = ((($stopro / $factor) * $costpr) + ($text1 * $costre)) / (($stopro / $factor) + $text1);
    } else {

        function convertir_a_numero($str)
        {
            $legalChars = "%[^0-9\-\. ]%";

            $str = preg_replace($legalChars, "", $str);
            return $str;
        }

        $text_char = convertir_a_numero($text1);
        $promedio = ((($stopro / $factor) * $costpr) + (($text_char * $factor) * $costre)) / (($stopro / $factor) + ($text_char * $factor));
    }

    if ($number == 0) {
        //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtypro,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$costpr','$text3','$costpr')");
        mysqli_query($conexion, "INSERT INTO tempmovmov (invnum      ,codpro ,qtypro     ,prisal ,pripro     ,costre,numlote,costpr ) values ('$invnum'   ,'$cod' ,'$text1'   ,'$text3','$costre'  ,'$costre','$textlote','$promedio')");
        $id_tempmovmov = mysqli_insert_id($conexion);
    } else {
        //mysqli_query($conexion,"INSERT INTO tempmovmov (codtemp,invnum,codpro,qtyprf,pripro,costre,costpr) values ('$codtemp','$invnum','$cod','$text1','$costpr','$text3','$costpr')");
        mysqli_query($conexion, "INSERT INTO tempmovmov (invnum      ,codpro ,qtyprf     ,prisal ,pripro     ,costre,numlote,costpr ) values ('$invnum'   ,'$cod' ,'$text1'   ,'$text3','$costre'  ,'$costre','$textlote','$promedio')");
        $id_tempmovmov = mysqli_insert_id($conexion);
    }


$sqlDrogueria = "SELECT drogueria FROM datagen_det";
$resultDrogueria = mysqli_query($conexion, $sqlDrogueria);
if (mysqli_num_rows($resultDrogueria)) {
    while ($rowDrogueria = mysqli_fetch_array($resultDrogueria)) {
        $drogueria = $rowDrogueria['drogueria'];
    }
}
if ($drogueria == 1) {
    $lotenombre = "lote";
} else {
    $lotenombre = "lotec";
}

$sqlProducto = "SELECT $lotenombre FROM producto where codpro = '$cod'";
$resultProducto = mysqli_query($conexion, $sqlProducto);
if (mysqli_num_rows($resultProducto)) {
    while ($rowProducto = mysqli_fetch_array($resultProducto)) {
        $loteFiltro = $rowProducto[0];  //codigo
    }
}


if($loteFiltro == 1){
    
    $sql1 = "SELECT numlote,vencim FROM movlote where numlote = '$textlote' and eliminado ='0'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $numlote = $row1['numlote'];
            $vencimi = $row1['vencim'];
        }
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$cod' and numerolote='$textlote'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$textlote'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }



            mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi', codtemp ='$codtemp',registrado='$usuario' where invnum = '$invnum' and codpro = '$cod'");
        } else {
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$textlote'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }

            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim,codloc,codtemp,registrado) values ('$invnum','$numlote','$cod','$textven','$locall','$codtemp','$usu')");
        }
        $valor = '1';

        ////////////////////////////////////////////////////////////////////////////////////////////////////
    } else {
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote,vencim FROM templote where invnum = '$invnum'   and numerolote='$textlote'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $numero = $row2['numerolote'];
                $vencimiento = $row2['vencim'];
            }
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$textlote'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }


            // mysqli_query($conexion, "UPDATE templote set numerolote = '$textlote',vencim = '$vencimiento', codtemp ='$codtemp',registrado='$usuario'  where invnum = '$invnum' and codpro = '$cod'");
            mysqli_query($conexion, " DELETE FROM `tempmovmov` WHERE codtemp='$id_tempmovmov' ");
            $valor = '2';
        } else {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$textlote'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }

            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro,codloc,codtemp,registrado) values ('$invnum','$textlote','$textven','$cod','$locall','$codtemp','$usu')");
            $valor = '0';
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////

    }
} else {
        $valor = '0';
    }

//PARA PASAR FILTRO DE LOTES IGUALES
    $valor = '0';
//SOLO PARA ALGUNOS CLIENTES






    //echo '$promedio ==' . $promedio . "<br>";

    header("Location: ingresos_varios1.php?valor=$valor");
}
