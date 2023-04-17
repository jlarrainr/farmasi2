<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>MANTENIMIENTO DE INFORMACION</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/select.css" rel="stylesheet" type="text/css" />
    <style>
        input.bt {
            font-size: 9px;
            font-weight: bold;
            font-family: Verdana, Helvetica;
            height: 20px;
            width: 65px;
        }
    </style>
    <script>
        function validar() {
            var f = document.form1;
            f.method = "post";
            f.action = "index.php";
            f.submit();
        }
    </script>
    <style>
        table.tabla2 {
            color: #404040;
            background-color: #FFFFFF;
            border: 1px #CDCDCD solid;
            border-collapse: collapse;
            border-spacing: 0px;
        }

        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
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

        .LETRA2 {
            background: #d7d7d7
        }
    </style>
    <?php
    $i = 0;
    $z = 0;
    $ii = $_REQUEST['cant'];
    $b1 = $_REQUEST['b1'];
    $b2 = $_REQUEST['b2'];
    require_once('../../../conexion_import.php');
    $cc = "s";
    $xx = 1;
    $rr = 0;
    while ($xx <= $ii) {
        mysqli_select_db($b1, $conexion);
        $yy = $cc . $xx;
        $check = $_REQUEST[$yy];
        if ($check <> '') {
            /* $sql= "DESCRIBE ".$check;
                  $result = mysqli_query($conexion,$sql);
                  while ($row = mysqli_fetch_array($result)){
                  $campo = $row[0];
                  echo '<br>';
                  }
                 */
            ////////////////////////////////////////////////////////////
            $rr = 0;
            $sql = "SHOW FIELDS FROM " . $check;
            $result = mysqli_query($conexion, $sql, $conexion);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $rr++;
                }
            }
            //echo $rr;
            //echo '<br>';
            ////////////////////////////////////////////////////////////
            $i = 0;
            $sql = "SHOW FIELDS FROM " . $check;
            $result = mysqli_query($conexion, $sql, $conexion);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $i++;
                    $col[$i] = $row[0];
                    if ($i == $rr) {
                        $tot = $tot . ',' . $col[$i];
                    } else {
                        if ($i == 1) {
                            $tot = $col[$i];
                        } else {
                            $tot = $tot . ',' . $col[$i];
                        }
                    }
                }
            }
            //echo $tot;
            //echo '<br>';echo '<br>';
            ////////////////////////////////////////////////////////////
            $registros_tab = 0;
            $sql = "select $tot FROM " . $check;
            $result = mysqli_query($conexion, $sql, $conexion);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $z = 0;
                    $registros_tab = $rr - 1;
                    while ($z < $rr) {
                        $prod = $row[$z];
                        if ($z == 0) {
                            $prods = "'" . $prod . "'";
                        } else {
                            $prods = $prods . ",'" . $prod . "'";
                        }
                        $z++;
                    }
                    //data($check,$tot,$prods);
                    //echo '<br>';
                    mysqli_select_db($b2, $conexion);
                    //mysqli_select_db($b2, $conexion);
                    //echo $check; echo ' - '; echo $tot; echo ' - '; echo $prods;
                    mysqli_query($conexion, "INSERT INTO $check ($tot) VALUES ($prods)");
                    //echo '<br>';
                    //require_once('conexion1.php'); 
                    //echo $check; echo ' - '; echo $tot; echo ' - '; echo $prods; 
                    /* require_once('conexion1.php'); 
                          $productos = $prods;
                          //echo $productos;
                          //mysqli_query($conexion,"INSERT INTO $check ($tot) VALUES ($productos)");
                          echo $productos;
                          echo '<br>';
                         */
                }
            }
            //mysqli_close($conexion);
            ////////////////////////////////////////////////////////////
        }
        $xx++;
    }
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
                <td width="605" valign="top">
                    <table width="575" border="0">
                        <tr>
                            <td><strong><u>3- Se realiz� la importaci�n de datos de manera exitosa. DE<font color="#FF0000"> <?php echo $b1; ?></font> A <font color="#FF0000"><?php echo $b2; ?></font></u></strong></td>
                        </tr>
                    </table>
                    <table width="575" border="0">
                        <tr>
                            <td width="575">
                                <div align="right">
                                    <input name="b1" type="hidden" id="b1" value="<?php echo $b1; ?>" />
                                    <input name="b2" type="hidden" id="b2" value="<?php echo $b2; ?>" />
                                    <input name="Submit3" type="button" onclick="validar()" value="Finalizar" class="bt" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>