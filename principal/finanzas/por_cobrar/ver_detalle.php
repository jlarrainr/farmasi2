
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link href="css/letras.css" rel="stylesheet" type="text/css" />
  <link href="css/puntos.css" rel="stylesheet" type="text/css" />
  <link href="css/estilosPantalla.css" rel="stylesheet" type="text/css" />
  <title>Documento sin t&iacute;tulo</title>
  <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once('../../../convertfecha.php');  //CONEXION A BASE DE DATOS
  ?>
  <script type="text/javascript">
    var fila = null;

    function pulsar(obj) {
      obj.style.background = '#FFFF99';
      if (fila != null && fila != obj)
        fila.style.background = '@ffffff';
      fila = obj;
    }
    
     
  
  </script>
  <style type="text/css">
    .Estilo1 {
      color: #FFFFFF;
      font-weight: bold;
    }


    #boton {
      background: url('../../../images/save_16.png') no-repeat;
      border: none;
      width: 16px;
      height: 16px;
    }

    #boton1 {
      background: url('../../../images/icon-16-checkin.png') no-repeat;
      border: none;
      width: 16px;
      height: 16px;
    }

    #habilitado {
      background: url('habilitado.png') no-repeat;
      border: none;
      width: 30px;
      height: 25px;
    }

    #deshabilitado {
      background: url('deshabilitado.png') no-repeat;
      border: none;
      width: 30px;
      height: 25px;
    }
    
  

.active {
    background-color: #4CAF50;
}
  </style>
  
</head>

<body bgcolor="#f7f7f7">
    
  <?php

  $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
 
 //echo '$id = '.$id;
  
  
  function formato($c)
  {
    printf("%06d", $c);
  }
  

  $sql1 = "SELECT VC.id, VC.fechaplazo, VC.tipoDocumento, VC.id_cuota, VC.formaPago, VC.montoPago, VC.usuario, VC.hora, VC.codigoCliente, VC.fechapago, VC.banco, VC.nrobanco, VC.saldo_deuda,VC.textoCuota,VC.montoTotal FROM venta_cuotas_detalle AS VC   INNER JOIN venta_cuotas AS V ON V.id=VC.id_cuota         where V.venta_id = '$id' order by id desc";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
  ?>

    <table width="100%" align="center" border="0" id="customers">
      <thead id="Topicos_Cabecera_Datos">
        <tr style="font-size:12pt" class="GridviewScrollHeader">
          <th>N&ordm; </th>
          <th>USUARIO</span></th>
          <th>FECHA</span></th>
          <th>HORA</span></th>
          <th>N&ordm; DOCUMENTO</span></th>
          <th>CUOTA(S)</span></th>
          <th>TIPO DOCUMENTO</span></th>
          <th>FORMA PAGO</span></th>
          <th>MONTO A PAGAR</th>
          <th>MONTO PAGADO</th>
          <th>MONTO RESTANTE</th>
        </tr>
      </thead>

      <?php while ($row1 = mysqli_fetch_array($result1)) {
        $id                     = $row1['id'];
        $fechaplazo             = $row1['fechaplazo'];
        $fechapago              = $row1['fechapago'];
        $tipoDocumento          = $row1['tipoDocumento'];
        $id_cuota               = $row1['id_cuota'];
        $formaPago              = $row1['formaPago'];
        $montoPago              = $row1['montoPago'];
        $codusu                 = $row1['usuario'];
        $hora                   = $row1['hora'];
        $codigoCliente          = $row1['codigoCliente'];
        $saldo_deuda            = $row1['saldo_deuda'];
         $textoCuota            = $row1['textoCuota'];
         $montoTotal            = $row1['montoTotal'];
        
        
        if ($tipoDocumento == "1") {
          $tipdoc_desc = "CONTADO";
        }
        if ($tipoDocumento == "2") {
          $tipdoc_desc = "REPROGRAMACION DE PAGO";
        }
        if ($tipoDocumento == "3") {
          $tipdoc_desc = "DEVOLUCIONES O CANJES";
        }
        if ($formaPago == "E") {
          $forpag_desc = "EFECTIVO";
        }
        if ($formaPago == "L") {
          $forpag_desc = "LETRA";
        }
        if ($formaPago == "D") {
          $forpag_desc = "DEPOSITO";
        }
        if ($formaPago == "N") {
          $forpag_desc = "NOTA DE CREDITO";
        }
        $saldo_gen   = $saldo_gen - $monpag;


        $sql = "SELECT nomusu FROM usuario where usecod = '$codusu'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
          while ($row = mysqli_fetch_array($result)) {
            $nomusu = $row['nomusu'];
          }
        }
        $sqlVC = "SELECT V.nrofactura,VC.monto,VC.venta_id FROM `venta_cuotas` as VC INNER JOIN venta as V on VC.venta_id=V.invnum WHERE VC.`id`='$id_cuota' GROUP BY V.nrofactura    ";
        $resultVC = mysqli_query($conexion, $sqlVC);
        if (mysqli_num_rows($resultVC)) {
          while ($rowVC = mysqli_fetch_array($resultVC)) {
            $nrofactura = $rowVC['nrofactura'];
            $monto      = $rowVC['monto'];
            $venta_id      = $rowVC['venta_id'];
            
          }
        }
        if ($hora <= 12) {
          $hor    = " am";
        } else {
          $hor    = " pm";
        }
      ?>
        <tbody>
          <tr>
            <td><?php echo formato($id); ?></td>
            <td><?php echo $nomusu ?></td>
            <td><?php echo fecha($fechapago) ?></td>
            <td><?php echo $hora . $hor; ?></td>
            <td><?php echo $nrofactura; ?></td>
            <td><?php echo $textoCuota; ?></td>
            <td><?php echo $tipdoc_desc ?></td>
            <td><?php echo $forpag_desc ?></td>
            <td>
              <div><strong><?php echo $numero_formato_frances = number_format($montoTotal, 2, '.', ' '); ?></strong></div>
            </td>
            <td>
              <div><strong><?php echo $numero_formato_frances = number_format($montoPago, 2, '.', ' '); ?></strong></div>
            </td>
            <td>
              <div><strong><?php echo $numero_formato_frances = number_format($saldo_deuda, 2, '.', ' '); ?></strong></div>
            </td>
           
          </tr>
        </tbody>
      <?php }
      ?>
    </table>
  <?php }
  ?>
  
</body>

</html>