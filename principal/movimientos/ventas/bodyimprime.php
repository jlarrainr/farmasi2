<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('MontosText.php');
?>

<form name="form1" id="form1" style="width: 100%">

    <?php
    $sqlUsu = "SELECT formadeimpresion,codigo_hash FROM datagen";
    $resultUsu = mysqli_query($conexion, $sqlUsu);
    if (mysqli_num_rows($resultUsu)) {
        while ($row = mysqli_fetch_array($resultUsu)) {
            $formadeimpresion = $row['formadeimpresion'];
            $codigo_hash = $row['codigo_hash'];
        }
    }
    $sqldrogueria = "SELECT drogueria FROM datagen_det";
    $resultdrogueria = mysqli_query($conexion, $sqldrogueria);
    if (mysqli_num_rows($resultdrogueria)) {
        while ($rowdrogueria = mysqli_fetch_array($resultdrogueria)) {
            $drogueria = $rowdrogueria['drogueria'];
        }
    }
    $sqlUsuX = "SELECT logo,for_continuo,impresion_local FROM xcompa where codloc = '$sucursal'";
    $resultUsu2 = mysqli_query($conexion, $sqlUsuX);
    if (mysqli_num_rows($resultUsu2)) {
        while ($row = mysqli_fetch_array($resultUsu2)) {
            $logo = $row['logo'];
            $for_continuo = $row['for_continuo'];
            $impresion_local = $row['impresion_local'];
        }
    }

    if (($formadeimpresion == 1) && ($tipdoc <> 4) && ($impresion_local == 1)  )  {   //IMPRESION A4
        require_once('1_impresion_A4.php');
    } else if ($for_continuo == 1) {                    //IMPRESION PAPEL CONTINUO        
        if (($tipdoc == 2)) {                           // SOLO PARA EL TIPO DE DOCUMUENTO ( FACTURA=1, BOLETA=2, TICKET=4)
            require_once('3_impresion_continuo.php');
        } else {                                        //IMPRESION EN TICKETERA   
            require_once('2_impresion_ticket.php');
        }
    } else {                                            //IMPRESION EN TICKETERA   
        require_once('2_impresion_ticket.php');
    }
    ?>

</form>