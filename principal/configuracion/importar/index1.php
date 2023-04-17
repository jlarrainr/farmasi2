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
            function retro()
            {
                var f = document.form1;
                f.method = "post";
                f.action = "index.php";
                f.submit();
            }
            function validar()
            {
                var f = document.form1;
                f.method = "post";
                f.action = "index2.php";
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
        <?php
        $b1 = $_REQUEST['b1'];
        $b2 = $_REQUEST['b2'];
        require_once('../../../conexion.php');
        ?>
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
                    <td width="605" valign="top"><table width="575" border="0">
                            <tr>
                                <td><strong><u>2- SELECCIONAR LOS CAMPOS A EXPORTAR DE LA BASE DE DATOS <font color="#FF0000"><?php echo $b1; ?></font></u></strong></td>
                            </tr>
                        </table>
                        <table width="575" border="0">
                            <tr>
                                <td width="575">
                                    <div align="right">
                                        <input name="b1" type="hidden" id="b1" value="<?php echo $b1; ?>" />
                                        <input name="b2" type="hidden" id="b2" value="<?php echo $b2; ?>" />
                                        <input name="Submit32" type="button" onclick="retro()" value="Retroceder" class="bt"/>
                                        <input name="Submit3" type="button" onclick="validar()" value="Siguiente" class="bt"/>
                                        <input name="Submit22" type="button" onclick="sal()" value="Salir" class="bt"/>            
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table width="575" border="0">
                            <tr>
                                <td width="27"><strong>N&ordm;</strong></td>
                                <td width="442"><strong>CAMPO</strong></td>
                                <td width="92"><div align="right"><strong>SELECCIONAR</strong></div></td>
                            </tr>
                        </table>
                        <table width="575" border="0">
                            <?php
                            $i = 0;
                            $sql = "SHOW TABLES";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $i++;
                                    $camp = $row[0];
                                    $t = $i % 2;
                                    if ($t == 1) {
                                        $color = "#EAEFF3";
                                    } else {
                                        $color = "#ffffff";
                                    }
                                    ?>
                                    <tr bgcolor="<?php echo $color; ?>" onmouseover="this.style.backgroundColor = '#FEFFBF';" onmouseout="this.style.backgroundColor = '<?php echo $color ?>';">
                                        <td width="27"><?php echo $i; ?></td>
                                        <td width="442"><?php echo $camp; ?></td>
                                        <td width="92"><label>
                                                <div align="center">
                                                    <input type="checkbox" name="s<?php echo $i; ?>" id="s<?php echo $i; ?>" value="<?php echo $camp; ?>"/>
                                                </div>
                                            </label></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table></td>
                </tr>
            </table>
            <input name="cant" type="hidden" id="cant" value="<?php echo $i; ?>" />
        </form>
    </body>
</html>
