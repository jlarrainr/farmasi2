<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href=".style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>

    <script language="JavaScript">
        function buscar() {

            var f = document.form1;
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "cli1.php";
            } else {
                f.action = "cli_prog.php";
            }
            f.submit();

        }
    </script>
</head>
<?php
$date = date('d/m/Y');
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";

$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}
/////////////////////////////////
?>

<body>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
    <table width="100%" border="0">
        <tr>
            <td><b><u>LISTA DE CLIENTE </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0">
                        <tr>
                            <td width="3">SALIDA</td>
                            <td width="80"><label>
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>
                                </label></td>


                            <td width="217">
                                <input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                            </td>

                            <td width="50">
                                <div align="right"></div>
                            </td>

                        </tr>
                    </table>




                </form>
                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
    ?>
        <?php require('cli2.php'); ?>
        <!-- <iframe src="cli2.php?val=<?php echo $val ?>" name="marco" id="marco" width="90%" height="730" scrolling="Automatic" frameborder="0" allowtransparency="0">
        </iframe> -->
    <?php }
    ?>
</body>

</html>