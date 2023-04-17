<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <?php
        require_once ('../../../conexion.php');
        require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
        $valform = $_REQUEST['valform'];
        $cod = $_REQUEST['cod'];
        ?>
        <script language="JavaScript">
            function validar_grid()
            {
                var f = document.form1;
                if (f.items.value == "")
                {
                    alert("Ingrese el Item del Sistema");
                    f.items.focus();
                    return;
                }
                if (f.nom.value == "")
                {
                    alert("Ingrese el nombre de la Opcion");
                    f.nom.focus();
                    return;
                }
                f.method = "post";
                f.action = "items2.php";
                f.submit();
            }
        </script>


        <style>
            .tr:hover {
                background: #ffffff;
            }

        </style>
    </head>

    <body>
        <form id="form1" name="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
            <table width="508" border="0">
                <tr>
                    <td width="107" class="text_combo_select">ITEM</td>
                    <td width="341" class="text_combo_select">NOMBRE</td>
                    <td width="46" class="text_combo_select">&nbsp;</td>
                </tr>
            </table>
            <img src="../../../images/line.jpg" width="508" height="1" />
            <?php
            $sql = "SELECT * FROM acceso where nombre <> 'sobra' order by orden  ";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                ?>
                <table width="508" border="0">
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $idacceso = $row['idacceso'];
                        $item = $row['item'];
                        $nombre = $row['nombre'];
                        $string = $item;
                        $letra = $string[0];
                        ?>
                        <tr class="tr" <?php if ($letra == 'A') { ?>  bgcolor= "#c1cd1a" <?php } ?> <?php if ($letra == 'M') { ?>  bgcolor= "#f1cffb" <?php } ?> <?php if ($letra == 'F') { ?>  bgcolor= "#f0cae8" <?php } ?>  <?php if ($letra == 'U') { ?>  bgcolor= "#b5f6fb" <?php } ?> <?php if ($letra == 'R') { ?>  bgcolor= "#f9b2b2" <?php } ?> <?php if ($letra == 'C') { ?>  bgcolor= "#88d1bb" <?php } ?> <?php if ($letra == 'S') { ?>  bgcolor= "#cccccc" <?php } ?>>
                            <td width="107">
                                <?php
                                if (($valform == 1) and ( $cod == $idacceso)) {
                                    ?>
                                <input name="items" type="text" id="items" size="20" value="<?php echo $item ?>" onKeyUp="this.value = this.value.toUpperCase();" readonly/>
                                    <?php
                                } else {
                                    echo $item;
                                }
                                ?>
                            </td>
                            <td width="332">
                                <?php
                                if (($valform == 1) and ( $cod == $idacceso)) {
                                    ?>
                                    <!--<input name="nom" type="text" id="nom" size="60" value="<?php echo $nombre ?>" onKeyUp="this.value = this.value.toUpperCase();"/>-->
                                    <input name="nom" type="text" id="nom" size="60" value="<?php echo $nombre ?>" />
                                    <?php
                                } else {
                                    echo $nombre;
                                }
                                ?>	</td>
                            <td width="24">

                            </td>
                            <td width="27">
                                <?php
                                if (($valform == 1) and ( $cod == $idacceso)) {
                                    ?>
                                    <input name="idacceso" type="hidden" id="idacceso" value="<?php echo $idacceso ?>" />
                                    <input name="button" type="button" id="boton" onclick="validar_grid()" alt="GUARDAR"/>
                                    <?php
                                } else {
                                    ?>
                                    <a href="items1.php?cod=<?php echo $idacceso ?>&valform=1">
                                        <img src="../../../images/edit_16.png" width="16" height="16" border="0"/></a>
                                <?php }
                                ?>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
                <?php
            } else {
                ?>
                <center>NO EXISTE INFORMACION EN EL SISTEMA POR EL MOMENTO</center>
            <?php }
            ?>
        </form>
    </body>
</html>
