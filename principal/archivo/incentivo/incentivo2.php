<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'Y-m-d'
            });
            myCal = new Calendar({
                date2: 'Y-m-d'
            });
        });
    </script>
    <?php
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    require_once("ajax_incentivo.php"); //FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <script>
        function validar_prod() {
            var f = document.form1;
            if (f.desc.value == "") {
                alert("Debe ingresar una Descripcion");
                f.desc.focus();
                return;
            }
            if (f.date1.value == "") {
                alert("Debe ingresar una Fecha");
                f.date1.focus();
                return;
            }
            if (f.date2.value == "") {
                alert("Debe ingresar una Fecha");
                f.date2.focus();
                return;
            }
            if (f.estado.value == 0) {
                ventana = confirm("�Desea deshabilitar este Incentivo y sus registros?");
                if (ventana) {
                    f.method = "post";
                    f.target = "principal";
                    f.action = "incentivo_activar.php";
                    f.submit();
                } else {
                    return;
                }
            }

            f.method = "post";
            f.target = "principal";
            f.action = "incentivo_activar.php";
            f.submit();
        }

        function vvalida() {
            var f = document.form1;
            if (f.desc.value == "") {
                alert("Debe ingresar una Descripcion");
                f.desc.focus();
                return;
            }
            if (f.date1.value == "") {
                alert("Debe ingresar una Fecha");
                f.date1.focus();
                return;
            }
            if (f.date2.value == "") {
                alert("Debe ingresar una Fecha");
                f.date2.focus();
                return;
            }
            f.method = "post";
            f.target = "principal";
            f.action = "incentivo_activar1.php";
            f.submit();
        }

        function des() {
            var f = document.form1;
            f.desc.focus();
        }

        function eliminarIncentivo(invnum)
        {

  
            ventana = confirm("Desea eliminar este incentivo?");
            if (ventana) 
            {

                window.parent.parent.location.href="incentivoborrar.php?invnum=" + invnum;
            } else {
                return;
            }
            
        }

    </script>
    <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
    <style>
        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

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
            background-color: #FFFF99;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        a:active {
            background-color: #FFFF99;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;

        }

        #customers #total {

            text-align: center;
            background-color: #9ebcc1;
            color: white;
            font-size: 14px;
            font-weight: 900;
        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ebf8a4;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }

        .HABILITADO {
            text-decoration: none;
            /*padding: 3px;*/
            font-weight: 600;
            font-size: 14px;
            color: #ffffff;
            background-color: #8fcba6;
            border-radius: 6px;
            border: 1px solid #196e39;
        }

        .DESHABILITADO {
            text-decoration: none;
            /*padding: 3px;*/
            font-weight: 600;
            font-size: 14px;
            color: #ffffff;
            background-color: #fb8080;
            border-radius: 6px;
            border: 1px solid #f92020;
        }

        input {

            border: 1px solid #ccc;
            border-radius: 4px;

            background-color: white;
            background-position: 3px 3px;


        }
    </style>
</head>
<?php
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$sql = "SELECT count(*) FROM incentivado where estado = '1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $countregx = $row[0];
    }
}
if ($countregx <> 0) {
    $sql = "SELECT invnum FROM incentivado where estado = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnumss = $row[0];
        }
    }
}

function formato($c)
{
    printf("%08d", $c);
}

$valform = $_REQUEST['valform'];
$invnums = $_REQUEST['invnum'];
$nn = $_REQUEST['nn'];
?>

<body <?php if ($nn == 1) { ?> onload="des();" <?php } ?>>
    <form id="form1" name="form1" method="post">

        <img src="../../../images/line2.png" width="100%" height="4" />
        <?php
        if ($nn == 1) {
        ?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#20c44f" style="color:white;font-size:13px;font-weight: 900;">
                    <th>DESCRIPCION</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA FIN</th>
                    <th>ESTADO</th>
                    <th>GRABAR</th>
                    <th>ACEPTAR</th>
                </tr>
                <tr onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                    <td width="35%" align="center">
                        <textarea style="width: 97%;" name="desc" cols="70" rows="1" id="desc"></textarea>
                        <input name="invnum2" type="hidden" id="invnum2" value="<?php echo $invnum ?>" />
                    </td>
                    <td width="15%" align="center">
                        <input style="width:auto;" type="text" name="date1" id="date1" size="12" value="<?php echo date('Y-m-d') ?>" />
                    </td>
                    <td width="15%" align="center">
                        <input style="width:auto;" type="text" name="date2" id="date2" size="12" value="<?php echo date('Y-m-d') ?>" />
                    </td>
                    <td width="20%">
                        <div align="center">
                            <select name="estado">
                                <option value="1">HABILITADO</option>
                                <option value="0">DESHABILITADO</option>
                            </select>
                        </div>
                    </td>
                    <td width="10%" align="center">
                        <input id="vvv" type="button" value="Grabar" class="grabar" onclick="vvalida()" />
                    </td>
                    <td width="5%" align="center">
                        <a href="incentivo2.php"><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /></a>
                    </td>
                </tr>
            </table>
            <img src="../../../images/line2.png" width="100%" height="4" />
        <?php }
        ?>
        <?php
        $sql = "SELECT * FROM incentivado where esta_desa = 0 order by invnum desc";

        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
        ?>
            <table width="100%" border="0" id="customers">
                <tr>
                    <th width="8%"><strong>N&ordm; INCENTIVO</strong></th>
                    <th width="26%"><strong>DESCRIPCION</strong></th>
                    <th width="12%"><strong>FECHA DE INICIO </strong> </th>
                    <th width="12%"><strong>FECHA DE FIN </strong> </th>
                    <th width="15%">
                        <div align="center"><strong>ESTADO </strong> </div>
                    </th>
                    <th width="5%">
                        <div align="center"></div>
                    </th>
                    <th width="5%">VER</th>
                    <th width="3%">&nbsp;</th>
                    <th width="6%">COPIAR</th>
                    <th width="6%"> <?php if ($valform <> 1) { ?>EDITAR <?php } else { ?> GUARDAR <?php } ?></th>
                    <th width="2%">&nbsp;</th>
                    <th width="6%">ELIMINAR</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $invnum = $row['invnum'];
                    $dateini = $row['dateini'];
                    $datefin = $row['datefin'];
                    $estado = $row['estado'];
                    $descripcion = $row['descripcion'];
                    if ($estado == 1) {
                        $desc = "HABILITADO";
                    } else {
                        $desc = "DESHABILITADO";
                    }
                    $sql1 = "SELECT count(*) FROM incentivadodet where invnum = '$invnum'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $countt = $row1[0];
                        }
                    }
                ?>
                    <tr>
                        <td align="center">
                            <?php echo formato($invnum); ?>
                        </td>
                        <td>
                            <?php if ($invnum == $invnums) { ?>
                                <textarea name="desc" cols="50" rows="1" id="desc"><?php echo $descripcion ?></textarea>
                                <input name="invnum" type="hidden" id="invnum" value="<?php echo $invnum ?>" />
                            <?php
                            } else {
                                echo $descripcion;
                            }
                            ?>
                        </td>
                        <td align="center">
                            <?php if ($invnum == $invnums) { ?>
                                <input style="width:auto;" type="text" name="date1" id="date1" size="12" value="<?php echo $dateini; ?>" /><?php
                                                                                                                                        } else {
                                                                                                                                            echo fecha($dateini);
                                                                                                                                        }
                                                                                                                                            ?>
                        </td>
                        <td align="center">
                            <?php if ($invnum == $invnums) { ?>
                                <input style="width:auto;" type="text" name="date2" id="date2" size="12" value="<?php echo $datefin; ?>" /><?php
                                                                                                                                        } else {
                                                                                                                                            echo fecha($datefin);
                                                                                                                                        }
                                                                                                                                            ?>
                        </td>
                        <td>
                            <div align="center">
                                <?php if ($invnum == $invnums) { ?>
                                    <select name="estado">
                                        <option value="1" <?php if ($estado == 1) { ?>selected="selected" <?php } ?>>HABILITADO</option>
                                        <option value="0" <?php if ($estado == 0) { ?>selected="selected" <?php } ?>>DESHABILITADO</option>
                                    </select>
                                <?php
                                } else {
                                ?>
                                    <button class="<?php
                                                    if ($estado == 1) {
                                                    ?>
                                                    HABILITADO
                                                    <?php
                                                    } else {
                                                    ?>
                                                    DESHABILITADO
                                                    <?php
                                                    }
                                                    ?>"> <?php echo $desc; ?> </button>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div align="center"><?php echo $countt ?> Reg.</div>
                        </td>

                        <td align="center"><a href="javascript:popUpWindow('incentivohist2.php?invnum=<?php echo $invnum ?>', 300, 70, 800, 350)"><img src="../../../images/lens.gif" width="15" height="16" border="0" title="VER RELACION" /></a></td>

                        <td align="center"><a href="javascript:popUpWindow('incentivohist3.php?invnum=<?php echo $invnum ?>', 400, 50, 780, 350)"><img src="../../../images/lens.gif" width="16" height="16" border="0" title="RELACION DE INCENTIVO" /></a></td>

                        <td align="center">
                            <!--<a>-->
                            <a href="incentivo2_copy.php?invnum=<?php echo $invnum ?>">
                                <img src="../../../images/copy_16.png" width="16" height="16" title="COPIAR INCENTIVO" border="0" />
                            </a>
                        </td>
                        <td align="center">
                            <?php if ($valform <> 1) { ?>
                                <a href="incentivo2.php?invnum=<?php echo $invnum ?>&valform=1"><img src="../../../images/edit_16.png" width="15" height="16" border="0" title="EDITAR" /> </a>
                                <?php
                            } else {
                                if ($invnums == $invnum) {
                                ?>
                                    <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
                            <?php
                                }
                            }
                            ?>
                        </td>
                        <td align="center">
                            <?php
                            if (($valform == 1) and ($invnums == $invnum)) {
                            ?>
                                <a href="incentivo2.php">
                                    <img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /></a>
                            <?php }
                            ?>
                        </td>
                        <td align="center">

                            <input type="button"  value="     " border="0" style="background-image: url(../../../images/del_16.png); background-color:rgba(255,255,255,0.0); border:none;" onclick="eliminarIncentivo(<?=$invnum?>)">
                             
                        </td>  
                    </tr>
                <?php }
                ?>
            </table>
        <?php } else { ?>
            <div style="color:red;font-size:26px;padding:50px" align="center">
                <blink><strong>CREE UN NUEVO INCENTIVO PARA PODER EMPEZAR</strong< /blink>
            </div>

        <?php

        }
        ?>
    </form>
</body>

</html>