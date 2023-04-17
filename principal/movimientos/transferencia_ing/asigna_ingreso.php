<?php

include('../../session_user.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
 
$codorigen = $_REQUEST['invnum'];

$sql = "SELECT codloc  FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc       = $row['codloc'];            //////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO

    }
}

if (($codorigen <> "") && ($codorigen <> 0)) {

    $sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum          = $row["invnum"];        //codigo

        }
    }
    $_SESSION['transferencia_ing']    = $invnum;     ////GRABO UNA SESION CON EL MOVIMIENTO QUE ESTOY REALIZANDO


    $sql = "SELECT numdoc,sucursal,sucursal1 FROM movmae where invnum = '$codorigen'  and tipmov = '2' and tipdoc = '3' and estado = '0' and proceso = '0' and val_habil = '0'";                    /////OBTENGO EL DOCUMENTO
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $srch = 1;
            $numdoc       = $row['numdoc'];
            $sucursal       = $row['sucursal'];
            $sucursal1       = $row['sucursal1'];
            mysqli_query($conexion, "UPDATE movmae set invnumrecib = '$codorigen',sucursal1=' $sucursal' where invnum = '$invnum'");
        }
    }



    // $sql1 = "SELECT * FROM movmov where invnum = '$codorigen'  order by orden";
    // $result1 = mysqli_query($conexion, $sql1);
    // if (mysqli_num_rows($result1)) {
    //     while ($row1 = mysqli_fetch_array($result1)) {
    //         $i++;
    //         $qtypro     = $row1["qtypro"];  //codigo
    //         $qtyprf     = $row1["qtyprf"];
    //         $pripro     = $row1["pripro"];
    //         $costre     = $row1["costre"];
    //         $codpro     = $row1["codpro"];
    //         $numlote    = $row1["numlote"];
    //         $orden    = $row1["orden"];
    //         $sql1 = "INSERT INTO tempmovmov (invnum,codpro,qtypro,qtyprf,pripro,costre,costpr,invnumrecib,numlote,orden) values ('$invnum','$codpro','$qtypro','$qtyprf','$pripro','$costre','$pripro','$invnumrecib', '$numlote','$orden')";
    //         mysqli_query($conexion, $sql1);
    //     }
    // }
}

header("Location: transferencia1_ing.php?codorigen=$codorigen&srch=1&val=1&local=$sucursal&documento=$numdoc&popup=1");
