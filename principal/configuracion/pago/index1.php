<?php
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
include('../../session_user.php');
// include('../../local.php');
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
        function sf() {
            var f = document.form1;
            f.text.focus();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function actualizar() {
            var f = document.form1;
            if ((f.id.value == "") || (f.id.value == 0)) {
                alert("Seleccione un ID para actualizar");
                f.id.focus();
                return;
            }
            if ((f.text.value == "") || (f.text.value == 0)) {
                alert("Ingrese una Descripcion del cambio");
                f.text.focus();
                return;
            }
            ventana = confirm("Desea Actualizar estos datos Asignado con el ID " + f.id.value);
            if (ventana) {
                f.method = "post";
                f.action = "index2.php";
                f.submit();
            }
        }

        function save() {
            var f = document.form1;
            if ((f.text.value == "") || (f.text.value == 0)) {
                alert("Ingrese una Descripcion del cambio");
                f.text.focus();
                return;
            }
            ventana = confirm("Desea Grabar estos datos");
            if (ventana) {
                var f = document.form1;
                f.method = "post";
                f.action = "index2.php";
                f.submit();
            }
        }
    </script>
    <style>
        select {
            width: 210px;
        }

        .tablarepor {

            border: 1px solid black;
            border-collapse: collapse;

        }

        .tablarepor tr {

            background: #ececec;
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

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
    <?php
    $srch = $_REQUEST['srch'];
    $id = $_REQUEST['id'];
    ?>
</head>

<body onload="sf();">
    <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
    <font color="<?php echo $color ?>"><?php echo $desc; ?></font>
    <br />
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" enctype="multipart/form-data">
        <table width="100%" border="0">
            <tr>
                <td width="501">
                    <table width="100%" border="1" class="tablarepor">
                        <tr>
                            <td width="10%" colspan="3">
                                <select name="id" id="id" style="width: auto;">
                                    <option value="0"> seleccione id </option>
                                    <?php
                                    $sql = "SELECT id FROM historial order by id";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row["id"] ?>" <?php if ($id == $row["id"]) { ?> selected="selected" <?php } ?>>
                                            <?php if ($row["id"] <> "") {
                                                echo $row["id"];
                                            } else {
                                                echo $row["id"];
                                            } ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input name="srch" type="hidden" id="srch" value="1" />
                                <input name="exit" type="button" id="exit" value="Actualizar" onclick="actualizar()" class="imprimir" />
                            </td>
                            <!-- <td width="20%" colspan="2">
                                <div align="left">
                                    <input name="srch" type="hidden" id="srch" value="1" />
                                    <input name="exit" type="button" id="exit" value="Actualizar" onclick="actualizar()" class="buscar" />
                                </div>
                            </td> -->

                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea id="text" name="text" rows="6" cols="100"></textarea>
                            </td>
                            <td width="75%">

                                <div align="right">
                                    <input name="id2" type="hidden" id="id2" value="<?php echo $id ?>" />
                                    <input name="grab" type="button" value="Grabar" onclick="save()" class="grabar" />
                                    <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                                </div>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
    </form>

    <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
    <table width="100%" id="customers">
        <tr>
            <th width="5%">ID</th>
            <th width="40%">DESCRIPCION</th>
            <th width="30%">USUARIO</th>
            <th width="10%">FECHA</th>
            <th width="10%">HORA</th>
        </tr>


        <?php
        $sql = "SELECT id,actividad,usuario,fecha,hora,id_secundario FROM historial";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $actividad = $row['actividad'];
                $usuario_2 = $row['usuario'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];
                $id_secundario = $row['id_secundario'];
                $hora = date("g:i a", strtotime($hora));
                $sql_usuario = "SELECT nomusu FROM usuario where usecod = '$usuario_2'";
                $result_usuario = mysqli_query($conexion, $sql_usuario);
                if (mysqli_num_rows($result_usuario)) {
                    while ($row_usuario = mysqli_fetch_array($result_usuario)) {
                        $user_n_usuario = $row_usuario['nomusu'];
                    }
                }
        ?>

                <tr>
                    <th><?php echo $id; ?></th>
                    <td><?php echo $actividad; ?></td>
                    <td><?php echo $user_n_usuario; ?></td>
                    <td><?php echo fecha($fecha); ?></td>
                    <td><?php echo $hora; ?></td>

                </tr>

        <?php
            }
        }
        ?>
    </table>
</body>

</html>
<script type="text/javascript">
    $('#id').select2();
</script>