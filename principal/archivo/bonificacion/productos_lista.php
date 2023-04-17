<?php
include('../../session_user.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');

$ProductoBusk     = isset($_REQUEST['ProductoBusk']) ? ($_REQUEST['ProductoBusk']) : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
    <?php
    require_once("../../../funciones/botones.php");    //COLORES DE LOS BOTONES
    ?>
    <style>
        .siniformacion {
            font-family: Tahoma;
            font-size: 20px;
            line-height: normal;
            color: #e65a3d;
            padding: 20px;
            font-weight: bold;
            /*margin-top:  20px;*/
        }


        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 12px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #FFFF66;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }

        table {
            width: 100%;
        }
    </style>
    <script>
        function SelecProducto(Valor) {
            alert(Valor);
            var f = document.lista;
            f.ActionForm.value = "";
            // f.CProductoBonif.value = Valor;
            f.method = "post";
            f.action = "productos.php?CProductoBonif=" + valor;
            f.submit();


        }
    </script>
</head>

<body>
    <form name="lista" id="lista">
        <table style="width: 100%" id="customers">
            <?php
            if (is_numeric($ProductoBusk)) {
                $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where codbar = '$ProductoBusk' or codpro = '$ProductoBusk' and eliminado='0' ";
            } else {
                $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where desprod like '$ProductoBusk%' and eliminado='0' ";
            }
            $result3 = mysqli_query($conexion, $sql3);
            if (mysqli_num_rows($result3)) {
            ?>
                <thead>

                    <tr>
                        <th style="text-align: left;" class="LETRA">CODIGO</th>
                        <th style="text-align: left;" class="LETRA">SELECCIONE UN PRODUCTO</th>
                        <th style="text-align: left;" class="LETRA">MARCA</th>
                        <th style="text-align: left;" class="LETRA">FACTOR</th>
                        <th style="text-align: left;" class="LETRA">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($row3 = mysqli_fetch_array($result3)) {
                        $codpro         = $row3['codpro'];
                        $desprod        = $row3['desprod'];
                        $codmar         = $row3['codmar'];
                        $factor         = $row3['factor'];
                        $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                        $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                        if (mysqli_num_rows($resultMarcaDet)) {
                            while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                $marca     = $row1['destab'];
                                $abrev     = $row1['abrev'];
                                if ($abrev == '') {
                                    $marca = substr($marca, 0, 4);
                                } else {
                                    $marca = substr($abrev, 0, 4);
                                }
                            }
                        }
                        $t = $i % 2;
                        if ($t == 1) {
                            $Color = "#f5f8f9";
                        } else {
                            $Color = "#D4D0C8";
                        }
                    ?>
                        <tr>
                            <td><?php echo $codpro; ?></td>
                            <td><?php echo $desprod; ?></td>
                            <td><?php echo $marca; ?></td>
                            <td style="text-align: center;"><?php echo $factor; ?></td>
                            <td><input type="button" class="limpiar" name="Seleccionar" value="Seleccionar" onclick="SelecProducto(<?php echo $codpro; ?>);" /></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            <?php
            } else {
            ?>

                <div class="siniformacion">
                    <center>
                        No se logro encontrar informacion con los datos ingresados
                    </center>
                </div>
            <?php
            }
            ?>


        </table>
    </form>
</body>

</html>

<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                "pageLength": 100,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ãltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
        }

    );
</script>