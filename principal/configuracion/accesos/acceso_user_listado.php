<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
        <script src="../../../funciones/alertify/alertify.min.js"></script>
        <?php
        require_once ('../../../conexion.php');
        require_once ('../../../convertfecha.php');
        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
        ?>
        <style>
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;

            }

            #customers td,
            #customers th {
                border: 1px solid #ddd;
                padding: 3px;

            }

            #customers tr:nth-child(even) {
                background-color: #f0ecec;
            }

            #customers tr:hover {
                background-color: #ddd;
            }

            #customers  th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size: 12px;
                font-weight: 900;
            }
        </style>
    </head>

    <body >
        <?php
        $codgrup = $_REQUEST['codgrup'];
        $error = $_REQUEST['error'];
        $error_contrasena = $_REQUEST['contrasena'];
        $ok = $_REQUEST['ok'];
        $val = $_REQUEST['val'];

        $sql = "SELECT nomgrup FROM grupo_user where codgrup = '$codgrup'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomgrup = $row['nomgrup'];
            }
        }
        if ($val == 1) {
            ?>
<!--            <table width="100%" border="0" align="center">
                <tr>
                    <td align="center" width="578"><span class="text_combo_select"><strong> LISTADO DE USUARIOS - <?php echo $nomgrup ?></strong></span><img src="../../../images/line2.jpg" width="570" height="4" />
                    </td>
                </tr>
            </table>-->
            <table width="584" border="0" align="center" class="tabla2">
                <tr>
                    <td><span class="Estilo1">
                            <?php if ($ok == 1) { ?>
                                <script >
                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.success("<a style='color:White;font-size:10px;font-weight: bold;'>SE LOGRO REGISTRAR SATISFACTORIAMENTE UN USUARIO.</a>", alertify.get('notifier', 'position'));

                                </script>
                                <?php
//                                echo "<b>SE LOGRO REGISTRAR SATISFACTORIAMENTE UN USUARIO</b><br>";
                            }
                            if ($error == 1) {
                                ?>
                                <script>

                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.error("<a style='color:White;font-size:10px;font-weight: bold;'>NO SE PUDO REGISTRAR EL USUARIO, LA CLAVE  YA EXISTE EN EL SISTEMA.</a>", alertify.get('notifier', 'position'));

                                </script>
                                <?php
                            }
                            if ($error_contrasena == 1) {
                                ?>
                                <script>

                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.error("<a style='color:White;font-size:10px;font-weight: bold;'>LA CLAVE SIGE SIENDO LA MISMA.</a>", alertify.get('notifier', 'position'));

                                </script>
                                <?php
                            }
                            ?>
                        </span> </td>
                </tr>
            </table>
        <?php }
        ?>
        <table width="100%" border="0" align="center">
            <tr>
                <td align="center" width="578"><span class="text_combo_select"><strong> LISTADO DE USUARIOS - <?php echo $nomgrup ?></strong></span><img src="../../../images/line2.jpg" width="570" height="4" />
                </td>
            </tr>
        </table>
        <img src="../../../images/line.jpg" width="100%" height="1" />

        <?php
        $sql = "SELECT U.usecod,U.nomusu,U.logusu,U.abrev,U.fecha_reg,U.estado,X.nomloc, X.nombre FROM usuario U INNER JOIN xcompa X ON U.codloc = X.codloc where U.codgrup = '$codgrup' and eliminado ='0'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            ?>
            <table width="100%" border="0" id="customers">
                <tr>
                    <th width="5%" >N</th>
                    <th >CODIGO</th>
                    <th width="15%" >USUARIO</th>
                    <th width="15%" >LOCAL</th>
                    <th width="15%" >ABREV</th>
                    <th width="30%" >NOMBRE</th>
                    <th width="10%">FECHA</th>
                    <th width="9%" ></th>
                    <th width="5%" >ESTADO</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {

                    $usecod = $row['usecod'];
                    $nomusu = $row['nomusu'];
                    $logusu = $row['logusu'];
                    $abrev = $row['abrev'];
                    $fecha_reg = $row['fecha_reg'];
                    $estado = $row['estado'];
                    $nomLoc = $row['nomloc'];
                    $nombre = $row['nombre'];
                    $i++;
                    ?>
                    <tr    <?php if ($estado == 0) { ?>  style="background-color: #fd8383;color: #fff;" <?php } ?>>
                        <td  align="center"><?php echo $i; ?></td>
                        <td  align="center"><?php echo $usecod; ?></td>
                        <td  align="center"><?php echo $logusu ?></td>
                        <td  align="center"><?php echo $nombre ?></td>
                        <td align="center"><?php echo $abrev ?></td>
                        <td ><?php echo $nomusu ?></td>
                        <td ><?php echo fecha($fecha_reg); ?></td>
                        <td >
                            <div align="right">
                                 <?php if( ($usecod<>1)&&($usecod<>2)) { ?>
                                <a href="acceso_user_listado1.php?codgrup=<?php echo $codgrup ?>&usecod=<?php echo $usecod ?>"><img src="../../../images/edit_16.png" width="16" height="16" title="EDITAR USUARIO" border="0"/></a>
                             <?php } ?>
                            </div>
                        </td>
                        <td width="5%">
                            <div align="center">
                                <?php if( ($usecod<>1)&&($usecod<>2)) { ?>
                                <?php if ($estado == 0) { ?>
                                    <a href="dar_alta.php?user=<?php echo $usecod ?>&codgrup=<?php echo $codgrup ?>">
                                        <img src="../../../images/del_16.png" width="16" height="16" title="HACER CLIC PARA ACTIVAR USUARIO" border="0"/>
                                    </a>
                                <?php } else { ?>
                                    <a href="dar_baja.php?user=<?php echo $usecod ?>&codgrup=<?php echo $codgrup ?>">
                                        <img src="../../../images/icon-16-checkin.png" width="16" height="16" title="HACER CLIC PARA DESACTIVAR USUARIO" border="0"/>
                                    </a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </td>
                    <?php }
                    ?>
                </tr>
                <?php
            } else {
                ?>
                <center>NO EXISTEN USUARIOS PARA ESTE GRUPO</center>
            <?php }
            ?>
        </table>
    </body>
</html>
