<?php

require_once('../conexion.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de productos</title>

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
    $i = 0;
   $sqlDetalleVenta = "SELECT codpro,desprod,factor,codbar,codmar,codfam,coduso,codpres,digemid,registrosanitario FROM producto ORDER BY codpro";
    $resultDetalleVenta = mysqli_query($conexion, $sqlDetalleVenta);
    
    
			
    if (mysqli_num_rows($resultDetalleVenta)) {
    ?>

        <table border='1' width="100%" align="center" id="customers">

            <thead>
                 <tr>
                    <th colspan='30'>
                        <h1>
                         REPORTE DE PRODUCTOS
                        </h1>
                    </th>
                </tr>
                <tr>
                  
                    <th> codigoProducto</th>
                    <th> descripcionProducto </th>
                    <th> factor </th>
                    <th> codbar </th>
                    <th> nombreMarca </th>
                    <th> principioActivo </th>
                    <th> accionTerapeutica </th>
                    <th> presentacion </th>
                    <th> digemid </th>
                    <th> registroSanitario </th>
                    <th> codigo_marca </th>
                    <th> codigo_presentacion </th>
                    <th> codigo_principioActivo </th>
                    <th> codigo_accionTerapeutica </th>
                     		 				  						

                    
                
                </tr>
            </thead>
            <tbody>
                <?php

               $codbar='';
               $digemid='';
               $registrosanitario='';
               $codmar='';
               $codfam='';
               $codpres='';
               $coduso='';
                
                while ($rowDetalleVenta = mysqli_fetch_array($resultDetalleVenta)) {

                    $codpro       = $rowDetalleVenta['codpro'];
                    $desprod       = $rowDetalleVenta['desprod'];
                    $factor     = $rowDetalleVenta['factor'];
                    $codbar         = $rowDetalleVenta['codbar'];
                    $codmar    = $rowDetalleVenta['codmar'];
                    $codfam      = $rowDetalleVenta['codfam'];
                    $coduso      = $rowDetalleVenta['coduso'];
                    $codpres      = $rowDetalleVenta['codpres'];
                    $digemid     = $rowDetalleVenta['digemid'];
                    $registrosanitario     = $rowDetalleVenta['registrosanitario'];
                    
                  
                

  
	$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}

            $sql1="SELECT ltdgen FROM titultabla where dsgen = 'COMPUESTO GENERICO'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen1     = $row1['ltdgen'];	
			}
			}

            $sql1="SELECT ltdgen FROM titultabla where dsgen = 'CLASE DE PRODUCTO'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen2     = $row1['ltdgen'];	
			}
			}

            $sql1="SELECT ltdgen FROM titultabla where dsgen = 'PRESENTACION'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen3     = $row1['ltdgen'];	
			}
			}






			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];	
			}
			}
			
			 $sql1 = "SELECT destab FROM titultabladet where codtab = '$codfam' and tiptab = '$ltdgen1'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $principioActivo = $row1['destab'];
                }
            }

            
			 $sql1 = "SELECT destab FROM titultabladet where codtab = '$coduso' and tiptab = '$ltdgen2'";
             $result1 = mysqli_query($conexion, $sql1);
             if (mysqli_num_rows($result1)) {
                 while ($row1 = mysqli_fetch_array($result1)) {
                     $accionTerapeutica = $row1['destab'];
                 }
             }

             $sql1 = "SELECT destab FROM titultabladet where codtab = '$codpres' and tiptab = '$ltdgen3'";
             $result1 = mysqli_query($conexion, $sql1);
             if (mysqli_num_rows($result1)) {
                 while ($row1 = mysqli_fetch_array($result1)) {
                     $presentacion = $row1['destab'];
                 }
             }
              
                    
                     
                        echo '<tr>
                  
                    <td>' . $codpro . ' </td>
                    <td>' . $desprod . ' </td>
                    <td>' . $factor . ' </td>
                    <td>' . $codbar . ' </td>
                    <td>' . $marca . ' </td>
                    <td>' . $principioActivo . ' </td>
                    <td>' . $accionTerapeutica . ' </td>
                    <td>' . $presentacion . ' </td>
                    <td>' . $digemid . ' </td>
                    <td>' . $registrosanitario . ' </td>
                    <td>' . $codmar . ' </td>
                    <td>' . $codpres . ' </td>
                    <td>' . $codfam . ' </td>
                    <td>' . $coduso . ' </td>
                    
                   
                  
                     
                 
                
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
                    'excel'
                ]
                
            });
        }

    );
    
    
     
</script>