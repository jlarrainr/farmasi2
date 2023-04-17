<?php

require_once('../conexion.php');

$dbhostComparacion     = 'farmasis-rds.ccmsgoobkgqo.us-east-1.rds.amazonaws.com';
$dbUsuarioComparacion  = 'admin';
$dbpasswordComparacion = 'f4rmxziS*20x22';
$dbComparacion         = 'farmasi2_demo';
$conPrueba = mysqli_connect($dbhostComparacion, $dbUsuarioComparacion, $dbpasswordComparacion, $dbComparacion) or die("No se ha podido conectar al servidor de Base de datos");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LISTA DE PROCESOS</title>
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
      padding: 5px;
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
  </style>

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
</head>

<body>
  <table id="customers" width="100%" border="0" style="margin-top:10px;">
    <thead>
      <tr>
        <th colspan="3">
          <div align="center">
            <h1>LISTA DE PROCESOS</h1>
          </div>
        </th>
      </tr>
      <tr>
        <th>NOMBRE TABLA</th>
        <th>ACCION</th>
        <th>CAMPOS ACTUALIZADOS</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $sqlX = "SHOW TABLES";
      $resultX = mysqli_query($conPrueba, $sqlX);
      if (mysqli_num_rows($resultX)) {
        while ($rowX = mysqli_fetch_array($resultX)) {
          $tables    = $rowX[0];

          $tablas[] = array(
            "nombreTablas"  => $tables
          );
        }
      }

      foreach ($tablas  as $key) {

        $nombreTabla = $key['nombreTablas'];
        $sqlCl = "SHOW COLUMNS FROM $nombreTabla  ";
        $resultCl = mysqli_query($conPrueba, $sqlCl);
        if (mysqli_num_rows($resultCl)) {
          while ($rowCl = mysqli_fetch_array($resultCl)) {
            $columanas    = $rowCl[0];
            $tipo    = $rowCl[1];

            $detalle_tabla['tabla']     = $nombreTabla;
            $detalle_tabla['columnna']  = $columanas;
            $detalle_tabla['tipo']      = $tipo;
            $arr_detalle_tabla[]        = $detalle_tabla;
          }
        }

        $exists = mysqli_query($conexion, "select 1 from $nombreTabla");

        if ($exists !== false) {
          $nombreCampoResumen = '';
          $items = array();
          foreach ($arr_detalle_tabla as $row) {

            $nombreTablas   = $row['tabla'];
            $nombreCampo    = $row['columnna'];
            $tipo           = $row['tipo'];

            $exists2 = mysqli_query($conexion, "select 1 from $nombreTablas");

            if ($exists2 !== false) {
              $nombreCampoResumen = '';

              $sql = "SHOW COLUMNS FROM $nombreTablas WHERE Field = '$nombreCampo' ";
              $result = mysqli_query($conexion, $sql);
              $contador = mysqli_num_rows($result);
              if ($contador === 0) {

                $sqlALTER = "ALTER TABLE $nombreTablas ADD $nombreCampo $tipo   NOT NULL";
                $resultsqlALTER = mysqli_query($conexion, $sqlALTER);

                $items[] = array(
                  "campos"  => $nombreCampo
                );

                foreach ($items  as $key) {
                  $nombreCampoResumen .= $key['campos'] . ', ';
                }
                $nombreCampoResumen = substr($nombreCampoResumen, 0, -2);
              }
            }
          }
          echo '<tr><td>' . $nombreTabla . '</td> <td>ACTUALIZADO</td> <td>' . $nombreCampoResumen . '</td></tr>';
        } else {
          echo ' <tr><td>' . $nombreTabla . '</td> <td>NO EXISTE</td><td></td> </tr> ';
        }
      }
      ?>
    </tbody>
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