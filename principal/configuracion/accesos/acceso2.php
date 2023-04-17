<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="euc-jp">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/mootools.js" type="text/javascript"></script>
    <script src="sexylightbox.packed.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../../css/sexylightbox.css" type="text/css" media="all" />
    <script type="text/javascript">
        window.addEvent('domready', function() {
            new SexyLightBox();
            new SexyLightBox({
                find: 'sexywhite',
                color: 'white',
                OverlayStyles: {
                    'background-color': '#000'
                }
            });
        });
    </script>
    <script language="JavaScript">
        function salir() {
            var f = document.form1;
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function eliminarestado0() {
            var f = document.form1;
            var mensaje = confirm("SE BORRARAN TODOS LOS USUARIOS DESACTIVADOS, ESTA SEGURO?");
            if (mensaje) {
                f.method = "post";
                f.action = "acceso2eliminar.php";
                f.submit();

            } else {
                f.method = "post";
                f.action = "acceso2.php";
                f.submit();
            }
        }

        function mensaje() {
            alert("Acceso no permitido");
        }
    </script>
</head>
<?php
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");
require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
//require_once("funciones/ip.php");
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td width="635">
                <table width="100%" border="0">
                    <tr>
                        <td width="469"><strong class="text_combo_select">GRUPOS DE USUARIOS DEL SISTEMA </strong></td>
                        <td width="145">
                            <form id="form1" name="form1" method="post">
                                <div align="right"><input type="button" name="Submit" value="Salir" onclick="salir()" class="salir" /></div>
                            </form>
                        </td>
                    </tr>
                </table>
                <img src="../../../images/line2.jpg" width="100%" height="4" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" align="center" class="tabla2">
        <tr>
            <td width="640">
                <?php

                function formato($c)
                {
                    printf("%04d", $c);
                }

                $sql = "SELECT codgrup,nomgrup FROM grupo_user order by codgrup";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                ?>
                    <table width="100%" border="0" align="center">

                        <tr style="background: #CDCDCD;">
                            <th width="70" class="text_combo_select" align="left">CODIGO</th>
                          <!--  <th width="2" class="text_combo_select" align="left"></th>-->
                            <th width="680" class="text_combo_select" align="left">GRUPO</th>
                            <th width="13" class="text_combo_select" align="left">NRO DE USUARIOS</th>
                            <th width="28" class="text_combo_select" align="left">&nbsp;</th>
                            <!--<th width="102">&nbsp;</th>-->
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            $codgrup = $row['codgrup'];
                            $nomgrup = $row['nomgrup'];
                            $sql1 = "SELECT count(*) FROM usuario where codgrup = '$codgrup' and eliminado='0'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $count = $row1[0];
                                }
                            } else {
                                $count = 0;
                            }
                            $i++;
                        ?>
                            <tr onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                <td width="70"><?php echo formato($codgrup) ?></td>

                                <!-- <td width="158">
                                                                                    <a href="www.google.com">
                                    <?php echo $nomgrup ?>
                                                                                    </a>
                                                                                    
                                                                                    </td>-->
                                <!--<td><a href="acceso_nombre.php?codu=<?php echo $codgrup ?>&TB_iframe=true&amp;height=160&amp;width=520" rel="sexylightbox">
                                        <img src="../../../images/nuevo.png" width="16" height="16" border="0" />
                                    </a>
                                </td>-->
                                <td width="200" class="text_combo_select">
                                    <div align="left">
                                       <!-- <a href="acceso2.php">
                                            <a href="acceso_nombre.php?codu=<?php // echo $codgrup ?>&TB_iframe=true&amp;height=160&amp;width=520" rel="sexylightbox">
                                                <?php //echo $nomgrup ?>
                                            </a>
                                        </a>-->
                                         <?php echo $nomgrup ?>
                                        
                                    </div>
                                </td>
                                
                                

                                <td width="302"><a href="acceso_user.php?codgrup=<?php echo $codgrup ?>&TB_iframe=true&amp;height=570&amp;width=625" rel="sexylightbox"><img src="../../../images/user.png" width="15" height="16" border="0" /></a> <?php echo $count ?></td>
                                <td width="25">
                                    <div align="right"><a href="acceso_grup_edit.php?codgrup=<?php echo $codgrup ?>&TB_iframe=true&amp;height=570&amp;width=625" rel="sexylightbox"><img src="../../../images/edit_16.png" width="16" height="16" border="0" /></a></div>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php
                } else {
                ?>
                    <center>NO SE LOGRO ENCONTRAR INFORMACION EN EL SISTEMA</center>
                <?php }
                ?>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" align="center" class="tabla2">
        <tr>
            <td width="640">
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="113" class="text_combo_select">&nbsp;</td>
                        <td width="122" class="text_combo_select">&nbsp;</td>
                        <td width="132" class="text_combo_select">
                            <div align="right">
                                <a href="#" onclick="eliminarestado0()">
                                    <img src="../../../images/controlpanel.png" width="16" height="16" border="0" />
                                    ACTUALIZAR
                                </a>
                            </div>
                        </td>

                        <td width="107" class="text_combo_select">
                            <div align="right">
                                <a href="acceso2.php">
                                    <a href="acceso_grup.php?TB_iframe=true&amp;height=160&amp;width=520" rel="sexylightbox">
                                        <img src="../../../images/save_16.png" width="16" height="16" border="0" /> NUEVO GRUPO
                                    </a>
                                </a>
                            </div>
                        </td>
                        <td width="127">


                            <div align="right">
                                <a <?php if ($usuario == 2) { ?> href="items.php?TB_iframe=true&amp;height=570&amp;width=625" rel="sexylightbox" <?php } else { ?> href="#" onclick="mensaje()" <?php } ?>>
                                    <img src="../../../images/add1.gif" width="14" height="15" border="0" />
                                    ITEMS DEL SISTEMA
                                </a>
                            </div </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>