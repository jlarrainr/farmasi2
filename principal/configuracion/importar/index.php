<?php require_once('conexion2.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>MANTENIMIENTO DE INFORMACION</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/select.css" rel="stylesheet" type="text/css" />
        <style>
            input.bt
            {
                font-size:9px;
                font-weight:bold;
                font-family:Verdana,Helvetica;
                height:20px; 
                width:65px;
            }
        </style>
        <script>
            function validar()
            {
                var f = document.form1;
                var t1 = f.b1.value;
                var t2 = f.b2.value;
                if (t1 == t2)
                {
                    alert("UD DEBE SELECCIONAR BASE DE DATOS DIFERENTES");
                    return;
                }
                f.method = "post";
                f.action = "index1.php";
                f.submit();
            }
            function sal()
            {
                var f = document.form1;
                f.target = "_top";
                f.action = "../../index.php"
                f.submit();
            }
        </script>
        <style>
            table.tabla2
            { 
                color: #404040;
                background-color: #FFFFFF;
                border: 1px #CDCDCD solid;
                border-collapse: collapse;
                border-spacing: 0px;
            }

            .LETRA{
                font-family:Tahoma;
                font-size:11px;
                line-height:normal;
                color:'#5f5e5e';
                font-weight: bold;
            }
            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px; 
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
            .LETRA2{
                background:#d7d7d7
            }

        </style>
    </head>
    <body>
        <form id="form1" name="form1">
            <p>&nbsp;</p>
            <center>
                <font color="#0066CC">IMPORTAR INFORMACI&Oacute;N DE BASE DE DATOS </font>
            </center>
            <br />
            <table width="615" height="180" border="0" align="center" class="tabla2">
                <tr>
                    <td width="605" valign="top"><div align="center">
                            <br /><br />
                            <table width="575" border="0">
                                <tr>
                                    <td><strong><u>1- SELECCIONAR BASE DE DATOS </u></strong></td>
                                </tr>
                            </table>
                            <br />
                            <table width="575" border="0">
                                <tr>
                                    <td>Seleecionar la base de datos de la cual se desea extraer su informaci�n</td>
                                </tr>
                            </table>
                            <table width="575" border="0">
                                <tr>
                                    <td width="58">ORIGEN</td>
                                    <td width="202"><select id="b1" name="b1">
                                            <?php
                                            $sql1 = "show databases";
                                            $result1 = mysqli_query($conexion, $sql1);
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                ?>
                                                <option value="<?php echo $row1[0] ?>" ><?php echo strtoupper($row1[0]) ?></option>
                                            <?php } ?>
                                        </select>              
                                    </td>
                                    <td width="301">&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                            <table width="575" border="0">
                                <tr>
                                    <td>Seleecionar la base de datos donde se importar&aacute; su informaci&oacute;n </td>
                                </tr>
                            </table>
                            <table width="575" border="0">
                                <tr>
                                    <td width="58">DESTINO</td>
                                    <td width="205"><select id="b2" name="b2">
                                            <?php
                                            $sql1 = "show databases";
                                            $result1 = mysqli_query($conexion, $sql1);
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                ?>
                                                <option value="<?php echo $row1[0] ?>" ><?php echo strtoupper($row1[0]) ?></option>
                                            <?php } ?>
                                        </select></td>
                                    <td width="298"><input name="Submit3" type="button" onclick="validar()" value="Siguiente" class="bt"/>
                                        <input name="Submit22" type="button" onclick="sal()" value="Salir" class="bt"/>
                                    </td>
                                </tr>
                            </table>
                            <table width="575" border="0">
                                <tr>
                                    <td width="187">&nbsp;</td>
                                    <td width="215">&nbsp;</td>
                                    <td width="159">&nbsp;</td>
                                </tr>
                            </table>
                        </div></td>
                </tr>
            </table>
        </form>
    </body>
</html>
