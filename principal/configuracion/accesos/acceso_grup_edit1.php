<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="euc-jp">

            <title>Documento sin t&iacute;tulo</title>
            <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
            <?php
            require_once ('../../../conexion.php');
            require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
            require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
            require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
            $codgrup = $_REQUEST['codgrup'];
            ?>
            <script language="JavaScript">
                function graba()
                {
                    var f = document.form1;
                    ventana = confirm("Desea grabar estos Datos");
                    if (ventana) {
                        f.action = "acceso_grup_edit2.php";
                        f.submit();
                    }
                }
            </script>
            <style>
                .tr:hover {
                    background: #ffffff;
                }

            </style>
    </head>
    <body>
        <form id="form1" name="form1" method = "post" action="">

            <img src="../../../images/line.jpg" width="508" height="1" />
            <?php
            $codgrup = $_REQUEST['codgrup'];
            $i = 0;
            $sql = "SELECT * FROM acceso where nombre <> 'sobra' order by orden  ";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                ?>
                <table width="508" border="0">
                    <tr>
                        <th width="57" class="text_combo_select">OPCION</th>
                        <th width="221" class="text_combo_select">NOMBRE</th>
                        <th width="216" class="text_combo_select">
                            <div align="right">Desea que tenga acceso?</div>
                        </th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($result)) {


                        $idacceso = $row['idacceso'];
                        $item = $row['item'];
                        $nombre = $row['nombre'];
                        $sel = 0;

                        $sql1 = "SELECT * FROM detalle_acceso where codgrup = '$codgrup' and idacceso = '$idacceso'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $sel = 1;
                        } else {
                            $sel = 0;
                        }

                        $string = $item;
                        $letra = $string[0];
                        $i++;
                        ?>

                        <tr class="tr" <?php if ($letra == 'A') { ?>  bgcolor= "#c1cd1a" <?php } ?> <?php if ($letra == 'M') { ?>  bgcolor= "#f1cffb" <?php } ?> <?php if ($letra == 'F') { ?>  bgcolor= "#f0cae8" <?php } ?>  <?php if ($letra == 'U') { ?>  bgcolor= "#b5f6fb" <?php } ?> <?php if ($letra == 'R') { ?>  bgcolor= "#f9b2b2" <?php } ?> <?php if ($letra == 'C') { ?>  bgcolor= "#88d1bb" <?php } ?> <?php if ($letra == 'S') { ?>  bgcolor= "#cccccc" <?php } ?>>
                            <td width="57" align="center" ><?php echo $item ?></td>
                            <td width="395"><?php echo $nombre ?></td>
                            <td width="42" >
                                <div align="right"  >
                                    <select name="c<?php echo $idacceso ?>" >
                                        <option value="1" <?php if ($sel == 1) { ?> selected="selected"<?php } ?>>SI</option>
                                        <option value="0" <?php if ($sel == 0) { ?> selected="selected"<?php } ?>>NO</option>
                                    </select>
                                </div>
                            </td>
                        <?php }
                        ?>
                    </tr>
                </table>
                <img src="../../../images/line.jpg" width="508" height="1" />
                <table width="508" border="0">
                    <tr>
                        <td width="357">&nbsp;</td>
                        <td width="141"><label>
                                <div align="right">
                                    <input name="codgrup" type="hidden" id="codgrup" value="<?php echo $codgrup ?>" />
                                    <input type="button" name="Submit" value="Grabar" class="grabar" onclick="graba()"/>
                                </div>
                            </label></td>
                    </tr>
                </table>
                <?php
            } else {
                ?>
                <center>
                    NO EXISTEN OPCIONES DE MENU REGISTRADOS
                </center>
            <?php }
            ?>
        </form>
    </body>
</html>
