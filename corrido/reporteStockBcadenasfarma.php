<?php

require_once('../conexion.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <style>
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
</head>

<body>

    <?php

    require_once('../conexion.php');
    require_once '../convertfecha.php';
    
    $dbhost     = 'localhost';	//host del Mysql 
    $dbUsuario  = 'farmasi2_mariros';	//En este caso el servidor no tiene valor para usuario para acceder a la base
    $dbpassword = 'mariarosa2';	//Aqui tambien no hay un valor especifico
    $db         ='farmasi2_bcadenasfarma';		// Nombre de la Base Datos
    //$db         ='farmasi1_gallarday';		// Nombre de la Base Datos


$conexionA = mysqli_connect($dbhost, $dbUsuario, $dbpassword, $db);


    $i = 0;
    $sqlDetalleVenta = "SELECT codpro, desprod,codmar, factor, s001 FROM producto WHERE s001 > 0";
    $resultDetalleVenta = mysqli_query($conexionA, $sqlDetalleVenta);
    if (mysqli_num_rows($resultDetalleVenta)) {
    ?>

        <table border='1' width="100%" align="center" id="customers">

            <thead>
                 <tr>
                    <th colspan='30'>
                        <h1>
                        REPORTE DE STOCK
                        </h1>
                    </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th> Codigo Producto </th>
                    <th> Descripcion del Producto </th>
                    <th> Marca </th>
                    <th> Factor </th>
                    <th> Stock Local 1 </th>
                  
                </tr>
            </thead>
            <tbody>
                <?php
              
                
                while ($rowDetalleVenta = mysqli_fetch_array($resultDetalleVenta)) {

                    $codpro         = $rowDetalleVenta['codpro'];
                    $desprod       = $rowDetalleVenta['desprod'];
                    $codmar        =$rowDetalleVenta['codmar'];
                    $factor       = $rowDetalleVenta['factor'];
                    $s001        = $rowDetalleVenta['s001'];
      
 $marca='';
                       $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
                                        $result1 = mysqli_query($conexionA, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $marca = $row1['destab'];
                                            }
                                        }     
                     
                   
                    
                        $i++;
                        echo '<tr>
                    <td>' . $i . ' </td>
                    <td>' . $codpro  . ' </td>
                    <td>' . $desprod . ' </td>
                    <td>' . $marca . ' </td>
                    <td>' . $factor . ' </td>
                    <td>' . stockcaja($s001,$factor) . ' </td>
           
                </tr>';
                    
                }

                ?>
            </tbody>
        </table>
    <?php

    }
    ?>


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
                },
                dom: 'Bfrtip',
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                    'excel', 'pdf',
                ]
                
            });
        }

    );
    
    
     
</script>