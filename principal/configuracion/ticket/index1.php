<?php
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
include('../../session_user.php');
include('../../local.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
        <link href="../../select2/css/select2.min.css" rel="stylesheet" />

        <script src="../../select2/jquery-3.4.1.js"></script>
        <script src="../../select2/js/select2.min.js"></script>
        <?php
        require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
        require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
        require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
        ?>
        <script>
            function sf()
            {
                var f = document.form1;
                f.text.focus();
            }
            function salir()
            {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                f.action = "../../index.php";
                f.submit();
            }
            function buscar()
            {
                var f = document.form1;
                if ((f.local.value == "") || (f.local.value == 0))
                {
                    alert("Seleccione una Local");
                    f.local.focus();
                    return;
                }


                f.method = "post";
                f.action = "index1.php";
                f.submit();
            }
            function save()
            {
                var f = document.form1;


                f.method = "post";
                f.action = "index2.php";
                f.submit();
            }
        </script>
        <style>
            select { width:210px; }
            .tablarepor {

                border: 1px solid black;
                border-collapse: collapse;

            }
            .tablarepor tr{

                background: #ececec;
            }
        </style>
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
        <?php
        $srch = $_REQUEST['srch'];
        $local = $_REQUEST['local'];

        if ($srch == 1) {
            $sql1 = "SELECT nombre,imprapida,habil,logo FROM xcompa where codloc = '$local'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $nombre = $row1['nombre'];
                    $imprapida = $row1['imprapida'];
                    $habil = $row1['habil'];
                    $logo = $row1['logo'];
                }
            }
        }

        $sql = "SELECT nlicencia FROM datagen ";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nlicencia = $row['nlicencia'];
            }
        }

        $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '$local'";
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
    </head>
    <body <?php if ($srch == 1) { ?>onload="sf();"<?php } ?>>
        <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
        <?php if ($desc <> '') { ?>
            <font color="<?php echo $color ?>"><?php echo $desc; ?></font>
            <br />
        <?php } ?>
        <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" enctype="multipart/form-data">

            <table width="100%" border="0" >
                <table width="100%" border="0" >


                    <tr>
                        <td >
                            <table width="100%" border="0" class="tablarepor">
                                <tr>
                                    <td width="69"><strong>Local </strong></td>

                                    <td width="216">
                                        <select name="local" id="local" >
                                            <option value="0">Seleccione un local</option>
                                            <?php
                                            $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                            $result = mysqli_query($conexion, $sql);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row[0] ?>" <?php if ($local == $row[0]) { ?>selected="selected"<?php } ?>>
                                                        <?php
                                                        if ($row[2] <> '') {
                                                            echo $row[2];
                                                        } else {
                                                            echo $row[1];
                                                        }
                                                        ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="0">NO EXISTEN LOCALES REGISTRADOS</option>
                                            <?php }
                                            ?>
                                        </select>          
                                    </td>

                                    <td width="179">
                                        <div align="right">
                                            <input name="srch" type="hidden" id="srch" value="1" />
                                            <input name="exit" type="button" id="exit" value="Buscar" onclick="buscar()" class="buscar"/>

                                            <input name="codloc" type="hidden" id="codloc" value="<?php echo $local ?>" />
                                            <input name="grab" type="button" value="Grabar" onclick="save()" class="grabar" <?php if ($srch <> 1) { ?>disabled="disabled"<?php } ?> />

                                            <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir"  />
                                        </div>
                                    </td>
                                </tr>



                            </table>

                        </td>
                    </tr>
                </table>
                <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>

                <?php if ($srch == 1) { ?>
                    <table width="100%" border='0' id="customers">
                        <tr>
                            <th width="35%">TICKET</th>
                            <th width="65%">EDITAR</th>
                        </tr> 
                        <tr>
                            <td ><img src="ticket.png"></td>
                            <td>
                                <table border='0' width="100%">
                                    <tr>
                                        <td width="10%" class="LETRA" align="center">LINEA 1</td>
                                        <td width="90%"> 
                                            <input name="linea1" id="linea1" type="text"  value="<?php echo $linea1 ?>"  size="100%"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 2</td>
                                        <td> <input name="linea2" id="linea2" type="text"  value="<?php echo $linea2 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 3</td>
                                        <td><input name="linea3" id="linea3" type="text"  value="<?php echo $linea3 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 4</td>
                                        <td><input name="linea4" id="linea4" type="text"  value="<?php echo $linea4 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 5</td>
                                        <td><input name="linea5" id="linea5" type="text"  value="<?php echo $linea5 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 6</td>
                                        <td><input name="linea6" id="linea6" type="text"  value="<?php echo $linea6 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 7</td>
                                        <td><input name="linea7" id="linea7" type="text"  value="<?php echo $linea7 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 8</td>
                                        <td><input name="linea8" id="linea8" type="text"  value="<?php echo $linea8 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">LINEA 9</td>
                                        <td><input name="linea9" id="linea9" type="text"  value="<?php echo $linea9 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" width="100%">

                                            <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 1</td>
                                        <td><input name="pie1" id="pie1" type="text"  value="<?php echo $pie1 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 2</td>
                                        <td><input name="pie2" id="pie2" type="text"  value="<?php echo $pie2 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 3</td>
                                        <td><input name="pie3" id="pie3" type="text"  value="<?php echo $pie3 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 4</td>
                                        <td><input name="pie4" id="pie4" type="text"  value="<?php echo $pie4 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 5</td>
                                        <td><input name="pie5" id="pie5" type="text"  value="<?php echo $pie5 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 6</td>
                                        <td><input name="pie6" id="pie6" type="text"  value="<?php echo $pie6 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 7</td>
                                        <td><input name="pie7" id="pie7" type="text"  value="<?php echo $pie7 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 8</td>
                                        <td><input name="pie8" id="pie8" type="text"  value="<?php echo $pie8 ?>" size="100%"/></td>
                                    </tr>
                                    <tr>
                                        <td class="LETRA" align="center">PIE 9</td>
                                        <td><input name="pie9" id="pie9" type="text"  value="<?php echo $pie9 ?>" size="100%"/></td>
                                    </tr>
                                    <!--<tr align="center">
                                        <td colspan="2" width="100%">
                                              <input name="codloc" type="hidden" id="codloc" value="<?php echo $local ?>" />
                                            <input name="grabar_ticket" type="button" value="Grabar Ticket" onclick="save_ticket()" class="grabarventa" <?php if ($srch <> 1) { ?>disabled="disabled"<?php } ?> />
                                        </td>
                                    </tr>-->
                                </table>


                            </td>
                        </tr>
                    </table>
                <?php } ?>

            </table>
        </form>
    </body>
</html>
<script type="text/javascript">
    $('#local').select2();
</script>