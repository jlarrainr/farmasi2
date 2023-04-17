<?php
require_once('../../session_user.php');
$venta = $_SESSION['cotiz'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
        <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
        <title>IMPRESION DE VENTA</title>
        <script>
            function escapes(e) {
                tecla = e.keyCode
                if (tecla == 27)
                {
                    //document.form1.val.value = "";
                    //document.form1.tipo.value = "";
                    //document.form1.submit();
                    window.close();
                }
                if (tecla == 70)
                {
                    var f = document.form1;
                    f.rd.value = 1;
                    f.method = "post";
                    f.action = "imprimir1.php";
                    f.submit();
                }

                if (tecla == 66)
                {
                    var f = document.form1;
                    f.rd.value = 2;
                    f.method = "post";
                    f.action = "imprimir1.php";
                    f.submit();
                }
                if (tecla == 84)
                {
                    var f = document.form1;
                    f.rd.value = 3;
                    f.method = "post";
                    f.action = "imprimir1.php";
                    f.submit();
                }
            }
            function imprimir()
            {
                var f = document.form1;
                f.method = "post";
                f.action = "imprimir1.php";
                f.submit();
            }
        </script>
        <?php
        require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
        require_once('../../../funciones/functions.php'); //DESHABILITA TECLAS
        $sql = "SELECT invnum,cuscod,invfec,nrovent FROM venta where usecod = '$usuario' and estado ='1'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $invnum = $row['invnum'];
                $cuscod = $row['cuscod'];
                $invfec = $row['invfec'];
                $nrovent = $row['nrovent'];
            }
        }

        function formato($c) {
            printf("%08d", $c);
        }
        ?>
    </head>
    <body onkeyup="escapes(event)">
        <table width="868" height="535" border="1">
            <tr>
                <td width="855" height="372" bgcolor="#FFFFCC">
                    <table width="512" height="204" border="0" align="center" class="tabla2">
                        <tr>
                            <td width="504"><u><strong>IMPRESION DE VENTAS</strong></u> - Seleccione el Tipo de Venta 
                                <!--<br><br>-->
                                <table width="494" border="0" align="center">
                                    <tr>
                                        <td width="71"><strong>N&ordm; DE VENTA</strong> </td>
                                        <td width="263"><?php echo formato($nrovent); ?></td>
                                        <td width="51"><strong>FECHA</strong></td>
                                        <td width="91"><?php echo $invfec ?></td>
                                    </tr>
                                </table>
                                <form id="form1" name="form1">
                                    <table width="494" border="0" align="center">
                                        <tr>
                                            <td width="70" height="22"><div align="center"><strong>&quot;F&quot;</strong></div></td>
                                            <td width="414">
                                                FACTURA				
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="22"><div align="center"><strong>&quot;B&quot;</strong></div></td>
                                            <td>
                                                BOLETA				
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="28"><div align="center"><strong>&quot;T&quot;</strong></div></td>
                                            <td>
                                                TICKET INTERNO				
                                                <input name="rd" type="hidden" id="rd" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
