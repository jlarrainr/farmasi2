<?php
include('../../session_user.php');
require_once ('../../../conexion.php');
require_once('../../../titulo_sist.php');
$venta = $_REQUEST['invnum'];
$date = date("Y-m-d");

function cambiarFormatoFecha($fecha) {
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

function pintaDatos($Valor) {
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}

$sqlUsuX = "SELECT logo FROM xcompa where codloc = '$zzcodloc'";
$resultUsu2 = mysqli_query($conexion, $sqlUsuX);
if (mysqli_num_rows($resultUsu2)) {
    while ($row = mysqli_fetch_array($resultUsu2)) {
        $logo = $row['logo'];
    }
}
?>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <script>
            function imprimir()
            {
                var f = document.form1;
                window.focus();
                window.print();
                f.method = "post";
                //f.target = "principal";
                f.action = "ventas_registro.php";

                f.submit();

            }
        </script>
    </head>
    <body onload="imprimir()" style="width: 100%" >
        <form name = "form1" id = "form1" style = "width: 100%">


            <?php
            $sqlV = "SELECT invnum,invfec,cuscod,usecod,forpag,sucursal,hora,invtot,igv,valven FROM cotizacion where invnum = '$venta'";
            $resultV = mysqli_query($conexion, $sqlV);
            if (mysqli_num_rows($resultV)) {
                while ($row = mysqli_fetch_array($resultV)) {
                    $invnum = $row['invnum'];
                    $invfec = cambiarFormatoFecha($row['invfec']);
                    $cuscod = $row['cuscod'];
                    $usecod = $row['usecod'];
                    $forpag = $row['forpag'];
                    $sucursal = $row['sucursal'];
                    $hora = $row['hora'];
                    $invtot = $row['invtot'];
                    $igv = $row['igv'];
                    $valven = $row['valven'];

                    $sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
                    $resultUsu = mysqli_query($conexion, $sqlUsu);
                    if (mysqli_num_rows($resultUsu)) {
                        while ($row = mysqli_fetch_array($resultUsu)) {
                            $nomusu = $row['abrev'];
                            $nomusu2 = $row['nomusu'];
                        }
                    }
                    $sqlCli = "SELECT descli,dnicli,dircli,ruccli,puntos,dptcli,procli,discli FROM cliente where codcli = '$cuscod'";
                    $resultCli = mysqli_query($conexion, $sqlCli);
                    if (mysqli_num_rows($resultCli)) {
                        while ($row = mysqli_fetch_array($resultCli)) {
                            $descli = $row['descli'];
                            $dnicli = $row['dnicli'];
                            $dircli = $row['dircli'];
                            $ruccli = $row['ruccli'];
                            $pstcli = $row['puntos'];
                            $dptcli = $row['dptcli'];
                            $procli = $row['procli'];
                            $discli = $row['discli'];
                        }
                        if (strlen($dircli) > 0) {
                            //VERIFICO LOS DPTO, PROV Y DIST
                            if (strlen($dptcli) > 0) {
                                $sqlDPTO = "SELECT name FROM departamento where id = '$dptcli'";
                                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                                if (mysqli_num_rows($resultDPTO)) {
                                    while ($row = mysqli_fetch_array($resultDPTO)) {
                                        $departamento = $row['name'];
                                    }
                                }
                            }
                            if (strlen($procli) > 0) {
                                $sqlDPTO = "SELECT name FROM provincia where id = '$procli'";
                                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                                if (mysqli_num_rows($resultDPTO)) {
                                    while ($row = mysqli_fetch_array($resultDPTO)) {
                                        $provincia = " | " . $row['name'];
                                    }
                                }
                            }
                            if (strlen($discli) > 0) {
                                $sqlDPTO = "SELECT name FROM distrito where id = '$discli'";
                                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                                if (mysqli_num_rows($resultDPTO)) {
                                    while ($row = mysqli_fetch_array($resultDPTO)) {
                                        $distrito = " | " . $row['name'];
                                    }
                                }
                            }
                            $Ubigeo = $departamento . $provincia . $distrito;
                            if (strlen($Ubigeo) > 0) {
                                $dircli = $dircli . "  - " . $Ubigeo;
                            }
                        }
                    }
                }
            }



            $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '$sucursal'";
            $resultTicket = mysqli_query($conexion, $sqlTicket);
            if (mysqli_num_rows($resultTicket)) {
                while ($row = mysqli_fetch_array($resultTicket)) {
                    $linea1 = $row['linea1'];
                    $linea2 = $row['linea2'];
                    $linea3 = $row['linea3'];
                    $linea4 = $row['linea4'];
                    $linea5 = $row['linea5'];
                    $linea6 = $row['linea6'];
                    $linea7 = $row['linea7'];
                    $linea8 = $row['linea8'];
                    $linea9 = $row['linea9'];
                    $pie1 = $row['pie1'];
                    $pie2 = $row['pie2'];
                    $pie3 = $row['pie3'];
                    $pie4 = $row['pie4'];
                    $pie5 = $row['pie5'];
                    $pie6 = $row['pie6'];
                    $pie7 = $row['pie7'];
                    $pie8 = $row['pie8'];
                    $pie9 = $row['pie9'];
                }
            }
            ?>
            <table  align="center" style="width: 100%; border: 0px ;">
<?php if ($logo <> "") { ?>
                    <tr>
                        <td style="text-align: center; width:30%;"><img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " /></td> 
                    </tr>
<?php } ?>

                <tr>
                    <td style="width:30%;">
                        <?php
                        echo pintaDatos($linea1);
                        echo pintaDatos($linea2);
                        echo pintaDatos($linea3);
                        echo pintaDatos($linea4);

                        echo pintaDatos($linea6);
                        echo pintaDatos($linea7);
                        echo pintaDatos($linea8);
                        echo pintaDatos($linea9);
                        ?>

                    </td>
                </tr>
            </table>
            <table  style="width: 100%" border='0'>

                <tr>
                    <td colspan="4" style="text-align: center;font-size: 23px;">
                        <b>
<?php echo 'NUMERO DE COTIZACION : ' . $venta; ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>FECHA :</td>
                    <td align="left"><?php echo $invfec; ?></td>
                    <td align="right">HORA :</td>
                    <td align="left"><?php echo substr($hora, 0, 5); ?></td>

                </tr>
                <tr>
                    <td >VENDEDOR :</td>
                    <td colspan="3"><?php echo $nomusu2; ?></td>
                </tr>

                <tr>
                    <td >CLIENTE :</td>
                    <td colspan="3"><?php echo $descli; ?></td>
                </tr>
                <?php
                if (($ruccli <> "")) {
                    ?>
                    <tr>
                        <td >RUC :</td>
                        <td colspan="3"><?php echo $ruccli; ?></td>
                    </tr>
                    <?php
                }
                if (strlen($dircli) > 0) {
                    ?>
                    <tr>
                        <td >DIRECCI&Oacute;N :</td>
                        <td colspan="3"><?php echo $dircli; ?></td>
                    </tr>
<?php } ?>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
            </table>
            <table  style="width: 98%" align="center">
                <?php
                $i = 1;
                $sqlDet = "SELECT * FROM cotizacion_det where invnum = '$venta' ";
                $resultDet = mysqli_query($conexion, $sqlDet);
                if (mysqli_num_rows($resultDet)) {
                    ?>
                    <tr>
                        <th style="text-align: left; width:4%;">Cant</th>
                        <th style="width:66%;">Descripcion</th>
                        <th style="width:7%;">Marca</th>
                        <th style="text-align: right; width:9%;">P.Unit</th>
                        <th style="text-align: right; width:9%;">S.Total</th>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <hr>
                        </td>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($resultDet)) {
                        $codpro = $row['codpro'];
                        $canpro = $row['canpro'];
                        $factor = $row['factor'];
                        $prisal = $row['prisal'];
                        $pripro = $row['pripro'];
                        $fraccion = $row['fraccion'];
                        $factorP = 1;
                        $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                        $resultProd = mysqli_query($conexion, $sqlProd);
                        if (mysqli_num_rows($resultProd)) {
                            while ($row1 = mysqli_fetch_array($resultProd)) {
                                $desprod = $row1['desprod'];
                                $codmar = $row1['codmar'];
                                $factorP = $row1['factor'];
                            }
                        }
                        if ($fraccion == "F") {
                            $cantemp = "C" . $canpro;
                        } else {
                            if ($factorP == 1) {
                                $cantemp = $canpro;
                            } else {
                                $cantemp = "F" . $canpro;
                            }
                        }
                        $Cantidad = $canpro;

                        $marca = "";
                        $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = 'M'";
                        $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                        if (mysqli_num_rows($resultMarcaDet)) {
                            while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                $marca = $row1['destab'];
                                $abrev = $row1['abrev'];
                                if ($abrev == '') {
                                    $marca = substr($marca, 0, 4);
                                } else {
                                    $marca = substr($abrev, 0, 4);
                                }
                            }
                        }
                        $producto = $desprod;
                        ?>
                        <tr>
                <td style="text-align: left; width:4%;"><?php echo $cantemp; ?></td>
                <td style="width:70%;"><?php echo $producto; ?></td>
                <td style="width:7%;"><?php echo $marca; ?></td>
                <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal, 2, '.', ''); ?></td>
                <td style="text-align: right; width:9.5%;"><?php echo number_format($prisal * $Cantidad, 2, '.', ''); ?></td>
                <!--<td><?php echo $numlote; ?></td>-->
            </tr>
                      
                <tr>
                    <td colspan="5"></td>
                </tr>

                    </table>

<table  style="width: 98%" >
                    <?php
                    $i++;
                }
            }
            ?>
            
                <tr>
                    <td colspan="5">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;font-size: 15px;"><b>TOTAL:&nbsp;&nbsp;S/. <?php echo $invtot; ?></b></td>
                </tr>


            </table>
        </form>
    </body>
</html>