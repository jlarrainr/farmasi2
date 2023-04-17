<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="../select2/css/select2.min.css" rel="stylesheet" />
        <script src="../select2/jquery-3.4.1.js"></script>
        <script src="../select2/js/select2.min.js"></script>

        <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
        <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
        <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
        <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
        <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL?>
        <script language="JavaScript">
            function buscar()
            {
                var f = document.form1;
                var tip = document.form1.report.value;
                if (tip == 1)
                {
                    if (f.dia.value == "")
                    {
                        alert("Ingrese el Numero de dias");
                        f.dia.focus();
                        return;
                    }
                    f.action = "prod_sin_venta1.php";
                } else
                {
                    f.action = "prod_sin_venta1_prog.php";
                }
                f.submit();
            }
            function salir()
            {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                f.action = "../index.php";
                f.submit();
            }
            function printer()
            {
                window.marco.print();
            }
        </script>
    </head>
    <?php
    //////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
    $date = date("Y-m-d");
    $val = $_REQUEST['val'];
    $dia = $_REQUEST['dia'];
    $local = $_REQUEST['local'];
    $sql = "SELECT export FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
        }
    }

    $sql = "SELECT nlicencia FROM datagen ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nlicencia = $row['nlicencia'];
        }
    }
///////////////////////////////////
    if ($local <> 'all') {
        require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
    }
    ?>
    <body>
        <table width="100%" border="0">
            <tr>
                <td><b><u>REPORTE DE PRODUCTOS SIN MOVIMIENTOS </u></b>
                    <form id="form1" name="form1" method = "post" action="">
                        <table class="tablarepor"width="100%" border="0">
                            <tr>
                                <td width="145" class="LETRA">SALIDA</td>
                                <td width="146"><select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>              </td>
                                <td width="58" class="LETRA"><div align="right">LOCAL</div></td>
                                <td width="504"><select style="width:170px" name="local" id="local">
                                        <?php if ($nombre_local == 'LOCAL0') { ?>
                                            <option value="all" <?php if ($local == 'all') { ?> selected="selected"<?php } ?>>TODOS LOS LOCALES</option>
                                        <?php } ?>
                                        <?php
                                        if ($nombre_local == 'LOCAL0') {
                                            $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                        } else {
                                            $sql = "SELECT * FROM xcompa where codloc = '$codigo_local'";
                                        }
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $loc = $row["codloc"];
                                            $nloc = $row["nomloc"];
                                            $nombre = $row["nombre"];
                                            if ($nombre == '') {
                                                $locals = $nloc;
                                            } else {
                                                $locals = $nombre;
                                            }
                                            ?>
                                            <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected"<?php } ?>><?php echo $nloc ?>
                                            </option>
                                        <?php } ?>
                                    </select>              
                                </td>
                            </tr>
                            <tr>
                                <td width="145" class="LETRA">NRO DE DIAS A CONSULTAR </td>
                                <td width="98"><input name="dia" type="text" id="dia" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $dia ?>"/></td>
                                 <td width="83">&nbsp;</td>
                                <td align="right" width="390"><input name="val" type="hidden" id="val" value="1" />
                                    <input type="button" name="Submit" value="Buscar" onclick="buscar()" class="buscar"/>
                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                    <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/></td>
<!--                                <td width="83">&nbsp;</td>
                                <td width="83">&nbsp;</td>
                                <td width="103">&nbsp;</td>-->
                            </tr>
                        </table>
                       
                    </form>
                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <br>
            <?php
            if ($val == 1) {
                require_once("prod_sin_venta2.php");
                ?>
             <!--   <iframe src="prod_sin_venta2.php?dia=<?php echo $dia ?>&local=<?php echo $local ?>&val=<?php echo $val ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
                </iframe>-->
            <?php }
            ?>
                <div class="go-top-container" title="Vuelve al comienzo">
                <div class="go-top-button" title="Vuelve al comienzo">
                    <a id="volver-arriba" href="#" title="Vuelve al comienzo" style="  cursor:pointer;">
                        <i class="fas fa-chevron-up" title="Vuelve al comienzo">

                        </i>
                    </a>
                </div>
            </div>
            <script src="js/gotop.js"></script>
    </body>
</html>
<script>
    $('#local').select2();

</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>

