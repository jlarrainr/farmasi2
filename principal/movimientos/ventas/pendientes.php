<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once('../../../titulo_sist.php');
    include('../../local.php');
    ?>
    <script>
        // Si usuario pulsa tecla ESC, cierra ventana
        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }

        function cerrars(e) {
            var f = document.form1;
            var cxr = e;
            document.form1.target = "venta_principal";
            window.opener.location.href = "exit1.php?invnum=" + cxr;
            self.close();
        }

        function eliminar_cotizacion(valor) {
            var valor;

            //alert(valor); return; 
            var f = document.form1;
            ventana = confirm("Se eliminara el registro de esta cotizacion no lo podra recuperar ...");
            if (ventana) {
                // f.method = "post";
                // f.target = "_top";
                // f.action = "eliminar_cotizacion.php?invnum=" + valor;
                // f.submit();

                document.form1.target = "venta_principal";
                window.opener.location.href = "eliminar_cotizacion.php?invnum=" + valor;
                self.close();

            }
        }
    </script>
    <?php

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%04d", $c);
    }
    ?>
    <title>COTIZACIONES PENDIENTES</title>
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
    <style>
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
            padding: 3px;
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

        .text_combo_select {
            font-family: Tahoma;
            font-size: 15px;
            line-height: normal;
            color: red;
            padding: 20px;
            font-weight: bolder;
        }
    </style>
</head>

<body onkeyup="cerrar(event)">
    <form name="form1">
        <table class="tabla2" width="100%" border="0">
            <tr>
                <td>
                    <table width="100%" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
                        <tr align="center">
                            <td style="color:#ffffff;font-size:15px;font-weight: bolder;"> LISTADO DE COTIZACIONES DISPONIBLES </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.jpg" width="100%" height="4" /></div>
                    <table width="100%" border="0" align="center" id="customers" cellpadding="0" cellspacing="0">
                        <thead id="Topicos_Cabecera_Datos">
                            <?php
                            echo $codloc;
                            // Lee cotizaciones registradas y vigentes para la sucursal (baja=0)
                            $sql = "SELECT invfec,invnum,invtot,usecod,cuscod,hora,codmed FROM cotizacion where sucursal = '$codigo_local' and baja = '0' and invtot <> 0 and estado='0' and estado_venta ='0' order by invnum DESC";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                            ?>

                                <tr>
                                    <th width="10%"><strong>
                                            <div align="center">N.COTIZACION
                                        </strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="center"><strong>FECHA/HORA</strong></div>
                                    </th>

                                    <th width="30%"><strong>CLIENTE</strong></th>
                                    <th width="10%"><strong>DNI/RUC</strong></th>
                                    <th width="30%"><strong>MEDICO</strong></th>
                                    <th width="10%"><strong>COLEGIATURA</strong></th>
                                    <th width="30%"><strong>VENDEDOR</strong></th>
                                    <th width="10%">
                                        <div align="center"><strong>MONTO</strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="center"><strong>ELIMINAR COTIZACION</strong></div>
                                    </th>
                                </tr>
                        </thead>
                        <tbody id="gtnp_Listado_Datos">
                            <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $invfec = $row['invfec'];
                                    $invnum = $row['invnum'];
                                    $invtot = $row['invtot'];
                                    $usecod = $row['usecod'];
                                    $cuscod = $row['cuscod'];
                                    $hora = $row['hora'];
                                    $codmed = $row['codmed'];

                                    $sql_usuario = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                                    $result_usuario = mysqli_query($conexion, $sql_usuario);
                                    if (mysqli_num_rows($result_usuario)) {
                                        while ($row_usuario = mysqli_fetch_array($result_usuario)) {
                                            $nomusu = $row_usuario['nomusu'];
                                        }
                                    }
                                    //$sqlCli = "SELECT descli,dnicli,ruccli FROM cliente where codcli = '$cuscod' and descli <> 'PUBLICO EN GENERAL'";
                                    $sqlCli = "SELECT descli,dnicli,ruccli FROM cliente where codcli = '$cuscod' ";
                                    $resultCli = mysqli_query($conexion, $sqlCli);
                                    if (mysqli_num_rows($resultCli)) {
                                        while ($row = mysqli_fetch_array($resultCli)) {
                                            $descli = $row["descli"];
                                            $dnicli = $row["dnicli"];
                                            $ruccli = $row["ruccli"];
                                        }
                                    }
                                    if($codmed){
                                    $sqlMedico = "SELECT nommedico,codcolegiatura,TIPO FROM medico where codmed = '$codmed' ";
                                    $resultMedico = mysqli_query($conexion, $sqlMedico);
                                    if (mysqli_num_rows($resultMedico)) {
                                        while ($rowMedico = mysqli_fetch_array($resultMedico)) {
                                            $nommedico = $rowMedico["nommedico"];
                                            $codcolegiatura = $rowMedico["codcolegiatura"];
                                            $TIPO = $rowMedico["TIPO"];
                                            
                                            $nommedico=$nommedico. 'ESP: ' . $TIPO;
                                        }
                                    }
                                    }else{
                                        $nommedico='No Asignado';
                                        $codcolegiatura='No Asignado';
                                    }
                            ?>
                                <tr>
                                    <td align="center"><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo formato($invnum); ?></a></td>
                                    <td align="center"><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo fecha($invfec); ?></a></td>

                                    <td><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo $descli; ?></a></td>
                                    <td><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php if ($dnicli <> '') {
                                                                                                echo $dnicli;
                                                                                            } else {
                                                                                                echo $ruccli;
                                                                                            } ?></a></td>

                                    <td><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo $nommedico ; ?></a></td>
                                    <td><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo $codcolegiatura; ?></a></td>
                                    <td><a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo $nomusu; ?></a></td>
                                    <td align="center">
                                        <a href="javascript:cerrars(<?php echo $invnum ?>)"><?php echo $invtot ?></a>
                                    </td>
                                    <td>
                                        <div align="center">

                                            <img src="eliminar.svg" width="25" height="25" onclick="eliminar_cotizacion('<?php echo $invnum; ?>')" ; />

                                        </div>
                                    </td>
                                </tr>

                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>

                    <div align="center" class="text_combo_select">
                        <span>
                            <blink>NO SE LOGRO ENCONTRAR NINGUNA COTIZACION REGISTRADA</blink>
                        </span>
                    </div>
                <?php } ?>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>

<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                // "pageLength": 25,
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