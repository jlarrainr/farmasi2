<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <?php require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
        ?>
        <style type="text/css">
            <!--
            table.tabla2
            { 
                color: #404040;
                background-color: #FFFFFF;
                border: 1px #CDCDCD solid;
                border-collapse: collapse;
                border-spacing: 0px;}
            .Estilo1 {color: #006699}
            .Estilo2 {color: #003366}
            -->
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
        <style>
            a:link,
            a:visited {
                color: #0066CC;
                border: 0px solid #e7e7e7;
            }
            a:hover {
                background: #fff;
                border: 0px solid #ccc;
            }
            a:focus {
                background-color: #FFFF66;
                color: #0066CC;
                border: 0px solid #ccc;
            }
            a:active {
                background-color: #FFFF66;
                color: #0066CC;
                border: 0px solid #ccc;
            } 
        </style>
        <?php
        $anio = $_REQUEST['anio'];
        $meses = $_REQUEST['meses'];
        $valform = $_REQUEST['valform'];
        ?>
        <script>
            function mini()
            {
<?php
if ($meses == "") {
    ?>
                    document.getElementById('l1').focus();
    <?php
} else {
    ?>
                    document.getElementById('l<?php echo $meses; ?>').focus();
<?php }
?>
                document.form1.minim.focus();
            }
            function sf()
            {
                document.form1.text0.focus();
            }
            function cerrar(e) {
                tecla = e.keyCode
                if (tecla == 27)
                {
                    var f = document.form1;
                    f.action = "cuotas2.php";
                    f.submit();
                }
            }
            var nav4 = window.Event ? true : false;
            function numeros1(evt)
            {
                var key = nav4 ? evt.which : evt.keyCode;
                if (key == 13)
                {
                    var f = document.form1;
                    f.method = "post";
                    f.action = "cuotas3.php";
                    f.submit();
                } else
                {
                    return (key <= 13 || key == 37 || key == 39 || (key >= 48 && key <= 57));
                }
            }
        </script>
        <?php
        $sql1 = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1' order by codloc";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $codloc = $row1['codloc'];
                $nomloc = $row1['nomloc'];
                $nom2 = $row1['nombre'];
                if ($nom2 <> "") {
                    $nombre_local = $nom2;
                } else {
                    $nombre_local = $nomloc;
                }
                if ($nomloc == 'LOCAL0') {
                    $local0 = $nombre_local;
                }
                if ($nomloc == 'LOCAL1') {
                    $local1 = $nombre_local;
                }
                if ($nomloc == 'LOCAL2') {
                    $local2 = $nombre_local;
                }
                if ($nomloc == 'LOCAL3') {
                    $local3 = $nombre_local;
                }
                if ($nomloc == 'LOCAL4') {
                    $local4 = $nombre_local;
                }
                if ($nomloc == 'LOCAL5') {
                    $local5 = $nombre_local;
                }
                if ($nomloc == 'LOCAL6') {
                    $local6 = $nombre_local;
                }
                if ($nomloc == 'LOCAL7') {
                    $local7 = $nombre_local;
                }
                if ($nomloc == 'LOCAL8') {
                    $local8 = $nombre_local;
                }
                if ($nomloc == 'LOCAL9') {
                    $local9 = $nombre_local;
                }
                if ($nomloc == 'LOCAL10') {
                    $local10 = $nombre_local;
                }
                if ($nomloc == 'LOCAL11') {
                    $local11 = $nombre_local;
                }
                if ($nomloc == 'LOCAL12') {
                    $local12 = $nombre_local;
                }
                if ($nomloc == 'LOCAL13') {
                    $local13 = $nombre_local;
                }
                if ($nomloc == 'LOCAL14') {
                    $local14 = $nombre_local;
                }
                if ($nomloc == 'LOCAL15') {
                    $local15 = $nombre_local;
                }
                if ($nomloc == 'LOCAL16') {
                    $local16 = $nombre_local;
                }
            }
        }
        ?>
    </head>
    <body onload="<?php if ($valform == 1) { ?>sf();<?php } else { ?>mini();<?php } ?>" onkeyup="cerrar(event)">
        <table width="971" border="0" class="tabla2">
            <tr>
                <td width="963"><img src="../../../images/line2.png" width="960" height="4" />
                    <table width="962" border="0">
                        <tr>
                            <td width="108"><strong>MES / A&Ntilde;O </strong></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local0; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local1; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local2; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local3; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local4; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local5; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local6; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local7; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local8; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local9; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local10; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local11; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local12; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local13; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local14; ?></span></div></td>
                            <td width="46"><div align="right"><span class="Estilo1"><?php echo $local15; ?></span></div></td>
                            <td width="44"><div align="right"><span class="Estilo1"><?php echo $local16; ?></span></div></td>
                        </tr>
                    </table>
                    <img src="../../../images/line2.png" width="960" height="4" />
                    <form name="form1">
                        <table width="962" border="0" id="myTab">
                            <?php
                            $mes = 1;
                            while ($mes <= 12) {
                                if ($mes == 1) {
                                    $dmes = "ENERO";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 2) {
                                    $dmes = "FEBRERO";
                                    $color = "#ECE9D8";
                                }
                                if ($mes == 3) {
                                    $dmes = "MARZO";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 4) {
                                    $dmes = "ABRIL";
                                    $color = "#ECE9D8";
                                }
                                if ($mes == 5) {
                                    $dmes = "MAYO";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 6) {
                                    $dmes = "JUNIO";
                                    $color = "#ECE9D8";
                                }
                                if ($mes == 7) {
                                    $dmes = "JULIO";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 8) {
                                    $dmes = "AGOSTO";
                                    $color = "#ECE9D8";
                                }
                                if ($mes == 9) {
                                    $dmes = "SETIEMBRE";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 10) {
                                    $dmes = "OCTUBRE";
                                    $color = "#ECE9D8";
                                }
                                if ($mes == 11) {
                                    $dmes = "NOVIEMBRE";
                                    $color = "#E5E5E5";
                                }
                                if ($mes == 12) {
                                    $dmes = "DICIEMBRE";
                                    $color = "#ECE9D8";
                                }
                                $sql = "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM cuota where mes = '$dmes' and anio = '$anio'";
                                $result = mysqli_query($conexion, $sql);
                                if (mysqli_num_rows($result)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $s000 = $row[0];
                                        $s001 = $row[1];
                                        $s002 = $row[2];
                                        $s003 = $row[3];
                                        $s004 = $row[4];
                                        $s005 = $row[5];
                                        $s006 = $row[6];
                                        $s007 = $row[7];
                                        $s008 = $row[8];
                                        $s009 = $row[9];
                                        $s010 = $row[10];
                                        $s011 = $row[11];
                                        $s012 = $row[12];
                                        $s013 = $row[13];
                                        $s014 = $row[14];
                                        $s015 = $row[15];
                                        $s016 = $row[16];
                                    }
                                } else {
                                    $s000 = "0";
                                    $s001 = "0";
                                    $s002 = "0";
                                    $s003 = "0";
                                    $s004 = "0";
                                    $s005 = "0";
                                    $s006 = "0";
                                    $s007 = "0";
                                    $s008 = "0";
                                    $s009 = "0";
                                    $s010 = "0";
                                    $s011 = "0";
                                    $s012 = "0";
                                    $s013 = "0";
                                    $s014 = "0";
                                    $s015 = "0";
                                    $s016 = "0";
                                }
                                ?>
                                <tr bgcolor="<?php echo $color; ?>">
                                    <td width="108">
                                        <a id="l<?php echo $mes ?>" href="cuotas2.php?valform=1&anio=<?php echo $anio ?>&meses=<?php echo $mes ?>"><?php echo $dmes; ?></a>
                                        <?php
                                        if (($valform == 1) and ( $meses == $mes)) {
                                            ?>
                                            <input name="meses" type="hidden" id="meses" value="<?php echo $mes ?>" />
                                            <input name="anio" type="hidden" id="anio" value="<?php echo $anio ?>" />
                                        <?php }
                                        ?>		  </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text0" size="4" onkeypress="return numeros1(event);" value="<?php echo $s000 ?>"/>
                                                <?php
                                            } else {
                                                echo $s000;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text1" size="4" onkeypress="return numeros1(event);" value="<?php echo $s001 ?>"/>
                                                <?php
                                            } else {
                                                echo $s001;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text2" size="4" onkeypress="return numeros1(event);" value="<?php echo $s002 ?>"/>
                                                <?php
                                            } else {
                                                echo $s002;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text3" size="4" onkeypress="return numeros1(event);" value="<?php echo $s003 ?>"/>
                                                <?php
                                            } else {
                                                echo $s003;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text4" size="4" onkeypress="return numeros1(event);" value="<?php echo $s004 ?>"/>
                                                <?php
                                            } else {
                                                echo $s004;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text5" size="4" onkeypress="return numeros1(event);" value="<?php echo $s005 ?>"/>
                                                <?php
                                            } else {
                                                echo $s005;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text6" size="4" onkeypress="return numeros1(event);" value="<?php echo $s006 ?>"/>
                                                <?php
                                            } else {
                                                echo $s006;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text7" size="4" onkeypress="return numeros1(event);" value="<?php echo $s007 ?>"/>
                                                <?php
                                            } else {
                                                echo $s007;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text8" size="4" onkeypress="return numeros1(event);" value="<?php echo $s008 ?>"/>
                                                <?php
                                            } else {
                                                echo $s008;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text9" size="4" onkeypress="return numeros1(event);" value="<?php echo $s009 ?>"/>
                                                <?php
                                            } else {
                                                echo $s009;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text10" size="4" onkeypress="return numeros1(event);" value="<?php echo $s010 ?>"/>
                                                <?php
                                            } else {
                                                echo $s010;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text11" size="4" onkeypress="return numeros1(event);" value="<?php echo $s011 ?>"/>
                                                <?php
                                            } else {
                                                echo $s011;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text12" size="4" onkeypress="return numeros1(event);" value="<?php echo $s012 ?>"/>
                                                <?php
                                            } else {
                                                echo $s012;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text13" size="4" onkeypress="return numeros1(event);" value="<?php echo $s013 ?>"/>
                                                <?php
                                            } else {
                                                echo $s013;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text14" size="4" onkeypress="return numeros1(event);" value="<?php echo $s014 ?>"/>
                                                <?php
                                            } else {
                                                echo $s014;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="46">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text15" size="4" onkeypress="return numeros1(event);" value="<?php echo $s015 ?>"/>
                                                <?php
                                            } else {
                                                echo $s015;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td width="44">
                                        <div align="right">
                                            <?php
                                            if (($valform == 1) and ( $meses == $mes)) {
                                                ?>
                                                <input type="text" name="text16" size="4" onkeypress="return numeros1(event);" value="<?php echo $s016 ?>"/>
                                                <?php
                                            } else {
                                                echo $s016;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $mes++;
                            }
                            ?>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
