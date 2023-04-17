<?php include('../../../session_user.php');
$invnum  = $_SESSION['transferencia_ing'];
require_once ('../../../../conexion.php');




$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codloc = $row1['codloc'];
        }
    }




$numero  = $_REQUEST['country'];
$cod  = $_REQUEST['codpro'];
$cantidad = $_REQUEST['stockLote'];
$mes2  = $_REQUEST['mes'];
$years  = $_REQUEST['years'];
 

$cuento = strlen($mes2);
if ($cuento == '2') {
    $mes = $mes2;
} else {
    $mes = '0' . $mes2;
}
$vencimiento = $mes . "/" . $years;


 $sql1 = "SELECT numerolote,vencim FROM templote where numerolote = '$numero'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $numlote = $row1['numerolote'];
            $vencimi = $row1['vencim'];
        }
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$cod' and numerolote='$numero'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }
            mysqli_query($conexion, "UPDATE templote set numerolote = '$numlote',vencim = '$vencimi', codtemp ='$codtemp',registrado='$usuario' where invnum = '$invnum' and codpro = '$cod'");
        } else {
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }
            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,codpro,vencim,codloc,codtemp,registrado) values ('$invnum','$numlote','$cod','$vencimi','$codloc','$codtemp','$usuario')");
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////
    } else {
        /////////SI EXISTE EN LA BASE DE DATOS EL NUMERO VERIFICO SI YA LO TENGO EN MI TEMPORAL//////////////////////
        $sql2 = "SELECT numerolote FROM templote where invnum = '$invnum' and codpro = '$cod' and numerolote='$numero'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {

            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }


            mysqli_query($conexion, "UPDATE templote set numerolote = '$numero',vencim = '$vencimiento', codtemp ='$codtemp',registrado='$usuario'  where invnum = '$invnum' and codpro = '$cod'");
            
            mysqli_query($conexion, "UPDATE tempmovmov set numlote = '$numlote' where invnum = '$invnum' and codpro = '$cod'");
        } else {
            mysqli_query($conexion, "UPDATE tempmovmov set numlote = '$numero' where invnum = '$invnum' and codpro = '$cod'");
            
            $sql1 = "SELECT codtemp FROM tempmovmov where invnum = '$invnum' and codpro = '$cod' and numlote='$numero'  order by codtemp";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codtemp = $row1['codtemp'];
                }
            }

            mysqli_query($conexion, "INSERT INTO templote (invnum,numerolote,vencim,codpro,codloc,codtemp,registrado) values ('$invnum','$numero','$vencimiento','$cod','$codloc','$codtemp','$usuario')");
            

            
            
           
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////
    }


    $sql1 = "SELECT idlote FROM movlote where codpro='$cod' and numlote='$numero' and vencim='$vencimiento' and codloc='$codloc'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $idlote = $row1['idlote'];
           
        }
        mysqli_query($conexion, "UPDATE movlote set stock='$cantidad' where idlote='$idlote'");

    } else {

        
     mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,codloc,stock) values ('$cod','$numero','$vencimiento','$codloc','$cantidad')");
 

    $ultimoid=  mysqli_insert_id($conexion);

    }




header("Location: lote.php?cod=$cod&ultimoid=$ultimoid&cerrar=1");
?>