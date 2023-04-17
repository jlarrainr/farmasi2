<?php

include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$cod = $_POST['cod'];   ///invnum
$referencia = $_POST['referencia']; ///referencia
$mont2 = $_POST['mont2'];   ///monto total
$hoy = date('Y-m-d H:i:s');
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}
$sql = "SELECT invnum FROM movmae where invnum = '$cod'";
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
    ////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
    $sqlx = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
    $resultx = mysqli_query($conexion, $sqlx);
    if (mysqli_num_rows($resultx)) {
        while ($rowx = mysqli_fetch_array($resultx)) {
            $numdoc = $rowx['numdoc'];
            $invfec = $rowx['invfec'];
            $tipmov = $rowx['tipmov'];
            $tipdoc = $rowx['tipdoc'];
            $usecod = $rowx['usecod'];
        }
    }
    $sql1 = "SELECT drogueria FROM datagen_det";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $drogueria = $row1['drogueria'];
        }
    }
    if ($drogueria == 1) {
        $lotenombre = "lote";
    } else {
        $lotenombre = "lotec";
    }
    $sql2 = "SELECT codloc FROM usuario where usecod = '$usecod'";
    $result2 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result2)) {
        while ($row2 = mysqli_fetch_array($result2)) {
            $codloc = $row2['codloc'];
        }
    }
    $sqla = "SELECT nomloc FROM xcompa where codloc = '$codloc' ORDER BY codloc";
    $resulta = mysqli_query($conexion, $sqla);
    if (mysqli_num_rows($resulta)) {
        while ($rowa = mysqli_fetch_array($resulta)) {
            $nomloc = $rowa['nomloc'];
        }
    }

    $sqlb = "SELECT P.codpro, P.desprod,P.$lotenombre FROM tempmovmov T, producto P where invnum = '$cod' and T.codpro=P.codpro and P.$lotenombre='1' order by T.codtemp";
    $resultb = mysqli_query($conexion, $sqlb);
    if (mysqli_num_rows($resultb)) {
        while ($rowb = mysqli_fetch_array($resultb)) {
            $codpro = $rowb['codpro'];
            $desprod = $rowb['desprod'];
            $lote = $rowb[2];
            $sqlLotec = "SELECT COUNT(codpro) contador FROM templote where invnum = '$cod' and codpro='$codpro'";
            $resultLotec = mysqli_query($conexion, $sqlLotec);
            if (mysqli_num_rows($resultLotec)) {
                if ($rowLotec == mysqli_fetch_array($resultLotec)) {
                    $contador = $rowLotec['contador'];
                    if ($contador < 1) {
                        echo '<script type="text/javascript">
                    alert("No se ha asociado un lote para el producto: ' . $desprod . '");
                    window.location.href="ingresos_varios.php";
                    </script>';
                        return;
                    }
                }
            }
        }
    }

    require_once('../tabla_local.php');
    $sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,prisal,numlote FROM tempmovmov where invnum = '$cod' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $i++;
            $codpro = $row['codpro'];
            $qtypro = $row['qtypro'];
            $qtyprf = $row['qtyprf'];
            $pripro = $row['pripro'];
            $costre = $row['costre'];
            $costpr = $row['costpr'];
            $prisal = $row['prisal']; // costre * cantidad
            $numlote1 = $row['numlote'];

            $sql1d = "SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
            $result1d = mysqli_query($conexion, $sql1d);
            if (mysqli_num_rows($result1d)) {
                while ($row1d = mysqli_fetch_array($result1d)) {
                    $factor = $row1d['factor'];
                    $stopro = $row1d['stopro'];
                    $cant_loc = $row1d[2];
                    $sactual = $cant_loc;
                }
            }
            if ($qtyprf <> "") {
                $text_char = convertir_a_numero($qtyprf);
                $cant_unid = $text_char;
            } else {
                $cant_unid = $qtypro * $factor;
            }
            $cant_local = $cant_loc + $cant_unid;
            $stopro = $stopro + $cant_unid;
            $stocklote = 0;

            $numlote = "";
            ////////LOTES Y VENCIMIENTOS DE LA TABLA TEMPORAL////////////////////
            /////////////////////////////////////////////////////////////////////
            $sql1 = "SELECT numerolote,vencim FROM templote where invnum = '$cod' and codpro = '$codpro' and numerolote='$numlote1' and codloc= '$codloc'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $numlote = $row1['numerolote'];
                    $vencimi = $row1['vencim'];

                    $numlote = strtoupper($numlote);
                }
            }
            $stocklote = 0;
            ///////REVISO SI EL NUMERO DEL TEMPORAL EXISTE EN MI TABLA ORIGINAL
            if ($numlote <> "") {
                $sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote' and codpro = '$codpro' and codloc= '$codloc'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $numerolote = $row1['numlote'];
                        $fvencimi = $row1['vencim'];
                        $stocklote = $row1['stock'];
                        $stocklote = $stocklote + $cant_unid;

                        $numerolote = strtoupper($numerolote);
                    }
                    mysqli_query($conexion, "UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote' and codloc= '$codloc'");
                } else {
                    mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro','$numlote','$vencimi','$cant_unid', '$codloc')");
                }
            }

            $sql1 = "SELECT idlote FROM movlote where numlote = '$numlote' and vencim ='$vencimi' and codpro = '$codpro' and codloc= '$codloc'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $idlotereg = $row1['idlote'];
                }
            }
            /////////////////////////////////////////////////////////////////////
            $sqlmovmov = "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,costpr,numlote,codloc, tipmov,orden) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$prisal','$costpr','$idlotereg','$codloc','$tipmov','$i')";
            mysqli_query($conexion, $sqlmovmov);
            /////////////////////////////////////////////////////////////////////
            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            /////////////////////////////////////////////////////////////////////
            $sqlkardex = "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc','$idlotereg')";
            //                   "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc','$idlotereg')"  
            mysqli_query($conexion, $sqlkardex);
            /////////////////////////////////////////////////////////////////////
        }
    }


    $sql = "SELECT sum(prisal) FROM tempmovmov where invnum = '$cod' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $sumatotal = $row[0];
        }
    }
    $sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $correlativo = $row[0];        //codigo
        }
        $correlativo    = $correlativo + 1;
    }
    //echo "UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', estado = '0', proceso = '0' where invnum = '$cod'";exit;
    mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
    mysqli_query($conexion, "DELETE from templote where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE movmae set invtot  = '$sumatotal', monto = '$sumatotal',refere = '$referencia', estado = '0', proceso = '0',correlativo='$correlativo',hora='$hoy'  where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$cod'");
    //header("Location: ../ing_salid.php"); 
    //header("Location: generaImpresion.php?Compra=$cod");
    
   
    if (($nopaga == 1) || ($nopaga == 0)) { 
    echo "<script>if(confirm('DESEA IMPRIMIR ESTE INGRESO')){document.location='generaImpresion.php?Compra=$cod';}else{ alert(document.location='../ing_salid.php');}</script>";
    }elseif($nopaga == 2){
         echo "<script>if(confirm('DESEA IMPRIMIR ESTE INGRESO')){document.location='generaImpresion.php?Compra=$cod';}else{ alert(document.location='../../logout.php');}</script>";
    }
    
    
}
