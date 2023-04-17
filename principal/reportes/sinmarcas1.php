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
        <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
        <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
        <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
        <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
        <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL?>
        <script language="JavaScript">
            function buscar()
            {
                var f = document.form1;
                var tip = document.form1.report.value;
                if (tip == 1)
                {
                    f.action = "marcas1.php";
                } else
                {
                    f.action = "marcas_prog.php";
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
    <body>
        <table width="100%" border="0">
            <tr>
                <td><b><u>REPORTE POR MARCAS </u></b>
                    <form id="form1" name="form1" method = "post" action="">
                        <table width="90%" border="0">
                            <tr>
                                <td><label>
                                        <div align="right">
                                            <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>
                                        </div>
                                    </label></td>
                            </tr>
                        </table>
                    </form>
                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <br>
            <iframe src="sinmarcas2.php" name="marco" id="marco" width="100%" height="510" scrolling="Automatic" frameborder="0" allowtransparency="0">
            </iframe>
    </body>
</html>
