<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
     <style>

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;

            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 3px;

            }
            #customers td a{
                color: #4d9ff7;
                font-weight: bold;
                font-size:15px;
                text-decoration: none;

            }

            #customers #total {

                text-align: center;
                background-color: #fe5050;
                color: white;
                font-size:16px;
                font-weight: 900;
            }

            #customers tr:nth-child(even){background-color: #f0ecec;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size:12px;
                font-weight: 900;
            }
        </style>
    </head>
    <?php
    
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $date = date('d/m/Y');
    $hour = date("G") - 5;
    $hour = CalculaHora($hour);
    $min = date("i");
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
     $val = $_REQUEST['val'];
    if ($local <> 'all') {
        $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomloc = $row['nomloc'];
                $nombre = $row['nombre'];
            }
        }
        if ($nombre <> "") {
            $nomloc = $nombre;
        }
    }
    ?>
    <body>
        <table width="100%" border="0" align="center">
            <tr>
                <td><table width="100%" border="0">
                        <tr>
                            <td><strong><?php echo $desemp ?></strong></td>
                            <td><div align="center"><strong>LISTA COMPLETA DE CLIENTES EN <?php echo $desemp ?>  </strong></div></td>
                            <td>&nbsp;</td>
                            <td><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>
                        <tr>
                            <td width="361"><strong>PAGINA # </strong></td>
                            <td width="221"><div align="center">
                                    <?php
                                    if ($local == 'all') {
                                        echo 'TODAS LAS SUCURSALES';
                                    } else {
                                        echo $nomloc;
                                    }
                                    ?>
                                </div></td>
                            <td width="30">&nbsp;</td>
                            <td width="284"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span> </div></td>
                        </tr>

                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if ($val == 1) {
            ?>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="customers">
                <tr>
                    <td id="total" colspan="11"><div align="center"><strong> LISTA DE CLIENTES</strong></div></td>
                </tr>
                
                <tr>
                    <?php
                    $i = 1;
                    $sql1 = "SELECT codcli,descli,dircli,telcli,telcli1,contact,dnicli,ruccli,email,puntos FROM cliente ORDER BY codcli";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        ?>
                        <tr>

                    <th width="10" align="center"><strong>N&ordm;</strong></th>
                    <th width="5"><strong>COD. CLI</strong></th>
                    <th width="140"><strong>CLIENTE</strong></th>
                    <th width="80"><div align="center"><strong>PROPIETARIO</strong></div></th>
                    <th width="110" align="center"><strong>DIRECCION</strong></th>
                    <th width="45"><strong>DNI</strong></th>
                    <th width="40" align="center"><strong>RUC</strong></th>
                    <th width="10"><div align="right"><strong>TELEFONO1</strong></div></th>
                    <th width="10" align="right"><strong>TELEFONO2</strong></th>
                    <th width="100" align="center"><strong>EMAIL</strong></th>
                    <th width="5" align="right"><strong>PUNTOS</strong></th>

                </tr>
                        <?php
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $codcli = $row1['codcli'];
                            $descli = $row1['descli'];
                            $dircli = $row1['dircli'];
                            $telcli = $row1['telcli'];
                            $telcli1 = $row1['telcli1'];
                            $contact = $row1['contact'];
                            $dnicli = $row1['dnicli'];
                            $ruccli = $row1['ruccli'];
                            $email = $row1['email'];
                            $puntos = $row1['puntos'];
                            ?>

                            <tr>

                                <td width="23" bgcolor="#fe5050" align="center"><?php echo $i ?></td>
                                <td width="20"><div align="center"><?php echo $codcli ?></div></td>
                                <td width="150"><div align="left"><?php echo $descli ?></div></td>
                                <td width="80"><div align="left"><?php echo $contact ?></div></td>
                                <td width="120"><div align="left"><?php echo $dircli ?></div></td>
                                <td width="20"><div align="center"><?php echo $ruccli ?></div></td>
                                <td width="20"><div align="center"><?php echo $dnicli ?></div></td>
                                <td width="75"><div align="center"><?php echo $telcli ?></div></td>
                                <td width="75"><div align="center"><?php echo $telcli1 ?></div></td>
                                <td width="110"><div align="center"><?php echo $email ?></div></td>
                                <td width="30"><div align="center"><?php echo $puntos ?></div></td>

                            </tr>

                            <?php
                            $i++;
                        }
                    }/////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?><center>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS SELECCIONADOS</center>
                    <?php }
                    ?>  </tr>
            </table>
            <?php
        }
        ?>
    </body>
</html>
