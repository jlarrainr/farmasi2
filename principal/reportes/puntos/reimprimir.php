<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
$codpumre = $_REQUEST['codpumnt'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $desemp ?> - ORDENES DE CANJE</title>
        <script>
            function imprimir()
            {
                var f = document.form1;
                window.print();
                f.action = "puntos.php";
                f.method = "post";
                f.submit();
            }
        </script>
        <style type="text/css">
            body, table
            {
                line-height: 100%

            }
        </style>
        <style>
            body, table
            {   
                font-family:courier;
                font-size:10px;
                font-weight: normal;
            }
        </style>
    </head>
    <body onLoad="imprimir();">


        <form name="form1" id="form1">

<!--<table style="width: 100%" border="0">
 <tr>
   <td >USUARIO </td>
   <td >Producto</td>
   <td >V. Compra </td>
   
   
 </tr>
</table>-->
            <?php

            function pintaDatos($Valor) {
                if ($Valor <> "") {
                    return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
                }
            }

            function zero_fill($valor, $long = 0) {
                return str_pad($valor, $long, '0', STR_PAD_LEFT);
            }

            $sql1 = "SELECT codpun,fecha,usecod,codclic,despunto,pdescuento,puntosold FROM puntos WHERE codpun='$codpumre' ";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codpun = $row1['codpun'];
                    $fecha = $row1['fecha'];
                    $usecod = $row1['usecod'];
                    $codclic = $row1['codclic'];
                    $despunto = $row1['despunto'];
                    $pdescuento = $row1['pdescuento'];
                    $puntosold = $row1['puntosold'];




                    $sql1 = "SELECT descli,dnicli,dircli,ruccli,puntos FROM cliente WHERE codcli= '$codclic'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $descli = $row1['descli'];
                            $dnicli = $row1['dnicli'];
                            $dircli = $row1['dircli'];
                            $ruccli = $row1['ruccli'];
//                        $puntos    = $row1['puntos'];
                        }
                    }

                    $sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $user_venta = $row1['nomusu'];
                            $codloc = $row1['codloc'];
                        }
                    }
                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $nomloc = $row1['nomloc'];
                        }
                    }

                    $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
                            . "FROM ticket where sucursal = '$codloc'";
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

                    <div class="title" style="text-align: left" >
                        <p><?php echo pintaDatos($linea1); ?></p>
                        <p><?php echo pintaDatos($linea2); ?></p>
                        <p><?php echo pintaDatos($linea3); ?></p>
                        <p><?php echo pintaDatos($linea4); ?></p>
                        <?php if ($tipdoc <> 4) { ?>
                            <p> <?php echo pintaDatos($linea5); ?> </p>
                        <?php } ?>
                        <p><?php echo pintaDatos($linea6); ?></p>
                        <p><?php echo pintaDatos($linea7); ?></p>
                        <p><?php echo pintaDatos($linea8); ?></p>
                        <p><?php echo pintaDatos($linea9); ?></p>
                    </div>
                    <table style="width: 100%" border="0">


                        <tr>
                            <td align="CENTER"><h2>CANJE DE PUNTOS</h2></td>

                        </tr>
                        <tr>
                            <td><h3>VENDEDOR</h3></td>
                            <td><h3>LOCAL</h3></td>
                        </tr>
                        <tr>
                            <td><?php echo $user_venta; ?></td>
                            <td><?php echo $nomloc; ?></td>
                        </tr>
                    </table>
                    <table style="width: 100%" border="0">



                        <tr>
                            <td><h3>CLIENTE</h3></td>
                            <td align="right"><h3>P. ACOMULADOS</h3></td>
                        </tr>
                        <tr>
                            <td><?php echo $descli; ?></td>
                            <td align="right"><?php echo $puntosold; ?></td>
                        </tr>
                    </table>
                    <table style="width: 100%" border="0">



                        <tr>
                            <td align="CEBTER"><h3>DESCRIPCION</h3></td>
                        </tr>
                        <tr>
                            <td ><div  style="width: 10%;height:30%" ><pre style="width: 10%;height:30%"><?php echo $despunto; ?></pre></div></td>
                        </tr>
                    </table>
                    <table style="width: 100%" border="0">



                        <tr>
                            <td><h3>P. A DESCONTAR </h3></td>

                        </tr>
                        <tr>
                            <td ><?php echo $pdescuento; ?></td>

                        </tr>
                    </table>
                    <table style="width: 100%" border="0">



                        <tr>

                            <td><h3>TOTAL PUNTOS </h3></td>
                        </tr>
                        <tr>

                            <td ><?php echo $puntosold - $pdescuento; ?></td>
                        </tr>
                    </table>



                    <?php
                }
            }
            ?>
        </form>
    </body>
</html>