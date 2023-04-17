<?php
include('../../session_user.php');
require_once('../../../conexion.php');

$val = $_REQUEST['val'];
$tip = $_REQUEST['tip'];
$p1 = $_REQUEST['p1'];
$ord = $_REQUEST['ord'];
$invnum = $_REQUEST['invnum'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros = $_REQUEST['registros'];


$valform = $_REQUEST['valform'];
$cod = $_REQUEST['codpros'];


if ($valform == 1) {
    $b1 = "GRABAR";
    $b2 = "ACEPTAR";
} else {
    $b1 = "EDITAR";
    $b2 = "ELIMINAR";
}

$sql = "SELECT invnum FROM incentivado where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
    }
}

function redondear_dos_decimal($valor) {
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>INCENTIVO NUMERO <?php echo $invnum ?></title>
        <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
        <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
        <?php
        require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
        ?>
        <script>
            function cerrar(e) {
                tecla = e.keyCode
                if (tecla == 27)
                {
                    document.form1.target = "marco1";
                    window.opener.location.href = "salir.php?val=<?php echo $val ?>&p1=<?php echo $p1 ?>&ord=<?php echo $ord ?>&tip=<?php echo $tip ?>&inicio=<?php echo $inicio ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $tot_pag ?>&registros=<?php echo $registros ?>";
                    self.close();
                }
            }
            function fc() {
                document.form1.cantidad.focus();
            }

            function guardar() {

                var f = document.form1;
                f.method = "post";
//                f.target = "principal";
                f.action = "guardar_edicion.php";
                f.submit();
            }
        </script>
        <style type="text/css">
            #boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
            #boton1 { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }

            /*<!--*/
            .Estilo3 {color: #FFFFFF; font-weight: bold; }
            /*-->*/
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
                background-color: #9ebcc1;
                color: white;
                font-size:14px;
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

    <body onkeyup="cerrar(event)" <?php if ($valform == 1) { ?> onload="fc()"<?php } ?> >
        <form name="form1">
            <table width="664">
                <tr>
                    <td width="656"><center><b><u>INCENTIVO NUMERO <?php echo $invnum ?></u></b></center></td>
                </tr>
            </table>

            <table width="664" border="0" id="customers">
                <tr>
                    <th width="18"><span class="EstSilo3">N&ordm;</span></th>
                    <th><span class="EstSilo3">CODIGO PRODUCTO</span></th>
                    <th width="289"><span class="EstiSlo3">PRODUCTO</span></th>
                    <th ><span class="EstiSlo3">FACTOR</span></th>
                    <th width="79"><span class="EstilSo3">LOCAL</span></th>
                    <th width="79"><span class="EstilSo3">ESTADO</span></th>
                    <th width="57"><div align="right"><span class="EstiSlo3">CANT</span></div></th>
                    <th width="52"><div align="right"><span class="EstiSlo3">MONTO</span></div></th>
                    <th width="62"><div align="right"><span class="EstiSlo3">P. MINIMO</span></div></th>
                    <!--<th width="56"><div align="right"><span class="EstiSlo3">META</span></div></th>!-->
                    <th width="17"><?php echo $b1; ?></th>
                    <th width="17"><?php echo $b2; ?></th>
                </tr>


                <?php
                $i = 1;
                if ($valform == 1) {
                    $sql = "SELECT producto.codpro,producto.factor,desprod,canprocaj,canprounid,pripro,pripromin,cuota,codloc,incentivadodet.estado FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' order by desprod";
                } else if ($valform == 2) {
                    $sql = "SELECT producto.codpro,producto.factor,desprod,canprocaj,canprounid,pripro,pripromin,cuota,codloc,incentivadodet.estado FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' order by desprod";
                } else {

                    $sql = "SELECT producto.codpro,producto.factor,desprod,canprocaj,canprounid,pripro,pripromin,cuota,codloc,incentivadodet.estado FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' order by desprod";
                }
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $codpro = $row['codpro'];
                        $factor = $row['factor'];
                        $desprod = $row['desprod'];
                        $canprocaj = $row['canprocaj'];
                        $canprounid = $row['canprounid'];
                        $pripro = $row['pripro'];
                        $pripromin = $row['pripromin'];
                        $cuota = $row['cuota'];
                        $codloc = $row['codloc'];
                        $estado = $row['estado'];
                        $sql1 = "SELECT nombre FROM xcompa where codloc = '$codloc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nomloc = $row1['nombre'];
                            }
                        }

                        $valoruni = redondear_dos_decimal($pripro / $factor);
                        if ($canprocaj == 0) {
                            $cantt = $canprounid;
                            $desc = "Unid";
                        } else {
                            $cantt = $canprocaj;
                            $desc = "Cajas";
                        }
                        ?>

                        <tr>
                            <td align="center" ><?php echo $i ?></td>
                            <td align="center" ><?php echo $codpro ?></td>
                            <td ><?php echo $desprod ?></td>
                            <td align="center"><?php echo $factor ?></td>
                            <td align="center" ><?php echo $nomloc ?></td>
                            <td align="center" >
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                    <select name="estado">
                                        <option value="1" <?= ($estado == 1)? "selected" : "" ?> >HABILITADO</option>
                                        <option value="0" <?= ($estado == 0)? "selected" : "" ?> >DESHABILITADO</option>
                                    </select>
                                <?php } else { ?>
                                    <div align="center"><?= ($estado == 1)? "HABILITADO" : "DESHABILITADO" ?></div>
                                <?php } ?>
                            </td>
                            
                            <td >
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?> 

                                    <input name="cantidad" type="text" id="cantidad" size="4"  value="<?php echo $cantt ?>" onkeypress="return acceptNum(event);"/>

                                <?php } else { ?>
                                    <div align="center"><?php
                                        echo $cantt;
                                        echo " ";
                                        echo $desc;
                                        ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td >
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                    <input name="monto" type="text" id="monto" size="4"  value="<?php echo $pripro ?>"  onkeypress="return decimal(event);"/>
                                <?php } else { ?>
                                    <div align="right" title="<?php echo "El valor de unidad es " . $valoruni; ?> ">
                                        <?php echo " S/".$pripro ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td ><div align="right"><?php echo $pripromin ?></div></td>
                            <!--<td ><div align="right"><?php echo " S/".$cuota ?></div></td>!--->
                            <td align="center">
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                    <input type="hidden"name="codproducto_grabar"  id="codproducto_grabar" value="<?php echo $cod ?>" />
                                    <input type="hidden" id="invnum_grabar" name="invnum_grabar" value="<?php echo $invnum; ?>"/>
                                    <input type="button" id="boton" onClick="guardar();" alt="GUARDAR"/>

                                <?php } else { ?>
                                    <a href="incentivohist2.php?invnum=<?php echo $invnum ?>&valform=1&codpros=<?php echo $codpro ?>"><img src="../../../images/edit_16.png" width="15" height="16" border="0" title="EDITAR"/>	  </a>
                                <?php } ?>
                            </td>
                            <td align="center">
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                    <a href="incentivohist2.php?invnum=<?php echo $invnum ?>" >
                                        <img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" onClick="validar_grid()" alt="ACEPTAR"/>
                                    </a>
                                <?php } else { ?>
                                    <div align="center">
                                        <a href="incentivohist2_del.php?invnum=<?php echo $invnum ?>&codpro=<?php echo $codpro ?>&codloc=<?php echo $codloc ?>">
                                            <img src="../../../images/del_16.png" width="16" height="16" border="0"/>	</a>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    ?>
                    <center>No se logr� encontrar registros para este Numero de Incentivo</center>
                <?php }
                ?>
            </table>
        </form>
    </body>
</html>
