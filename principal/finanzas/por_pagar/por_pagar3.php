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
    
     function detallado() {
          document.getElementById("detalladoDIV").style.display = "block";
          document.getElementById("resumidoDIV").style.display = "none";
     }
     
     function resumido() {
          document.getElementById("detalladoDIV").style.display = "none";
          document.getElementById("resumidoDIV").style.display = "block";
     }
     
     function popup(valor1){
        
        var valor1;
        
             w = 1000;
            h = 800;
                            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                            var top = ((height / 2) - (h / 2)) + dualScreenTop;
                            var newWindow = window.open('ver_detalle.php?id=' + valor1, 'PRIMPRIMIR', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);


 
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
    
    
    
    ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #d0d0ca;
}

li {
    float: left;
}

li a {
    display: block;
    color: #ef9e56;
    text-align: center;
    padding: 10px 10px;
    text-decoration: none;
    font-size:15px;
}

li a:hover:not(.active) {
    background-color: #d1e0f3;
     color: #000000;
}

.active {
    background-color: #4CAF50;
}
  </style>
  
</head>

<body bgcolor="#f7f7f7">
    
   <ul>
  <li onclick=detallado();  onchange="detallado()" ><a>Detallado</a></li>
  <li onclick=resumido();  onchange="resumido()"><a>Resumido</a></li>
  
</ul>
    
   <div id='detalladoDIV' style="display:block">
    
  <?php
 
  $cliente  = $_REQUEST['proveedor'];
 //echo '$cliente ====== '.$cliente;
  function formato($c)
  {
    printf("%06d", $c);
  }
  //$estado = 0;

  $sql1 = "SELECT id, fechaplazo, tipoDocumento,id_cuota, formaPago, montoPago, usuario,hora, codigoCliente, fechapago,banco, nrobanco, saldo_deuda,textoCuota,montoTotal,fecha_pago_cuota FROM cuentaPorPagarDetalle where codigoCliente = '$cliente' order by id desc";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
  ?>

    <table width="100%" align="center" border="0" id="customers">
      <thead id="Topicos_Cabecera_Datos">
        <tr style="font-size:12pt" class="GridviewScrollHeader">
          <th>N&ordm; </th>
          <th>USUARIO</span></th>
          <th>FECHA REGISTRO</span></th>
          <th>HORA REGISTRO</span></th>
          <th>N&ordm; DOCUMENTO</span></th>
          <th>CUOTA(S)</span></th>
          <th>TIPO DOCUMENTO</span></th>
          <th>FORMA PAGO</span></th>
          <th>MONTO A PAGAR</th>
          <th>MONTO PAGADO</th>
          <th>MONTO RESTANTE</th>
        </tr>
      </thead>

      <?php
      $i=0;
      while ($row1 = mysqli_fetch_array($result1)) {
           $i++;
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
        $fecha_pago_cuota      = $row1['fecha_pago_cuota'];
        $numero_documento     = $row1['numero_documento'];
                  $numero_documento1    = $row1['numero_documento1'];
                  $nrofactura           =$numero_documento.'-'.$numero_documento1;
        
        
        if ($tipoDocumento == "1") {
          $tipdoc_desc = "CONTADO";
          $title="";
        }
        if ($tipoDocumento == "2") {
          $tipdoc_desc = "REPROGRAMACION DE PAGO";
          $title="Le tocaba pagar el dia ". fecha($fecha_pago_cuota).", se le repogramo para el dia  ". fecha($fechaplazo);
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
        
        $sqlVC = "SELECT numero_documento,numero_documento1 FROM movmae  WHERE  invnum='$id_cuota'    ";
        $resultVC = mysqli_query($conexion, $sqlVC);
        if (mysqli_num_rows($resultVC)) {
          while ($rowVC = mysqli_fetch_array($resultVC)) {
           $numero_documento     = $rowVC['numero_documento'];
                  $numero_documento1    = $rowVC['numero_documento1'];
                  $nrofactura           =$numero_documento.'-'.$numero_documento1;
           
          }
        }
        
        
        

        if ($hora <= 12) {
          $hor    = " am";
        } else {
          $hor    = " pm";
        }
      ?>
        <tbody>
          <tr title="<?php echo $title;?>">
            <td><?php echo formato($i); ?></td>
            <td><?php echo $nomusu ?></td>
            <td><?php echo fecha($fechapago) ?></td>
            <td><?php echo $hora . $hor; ?></td>
            <td title="<?php echo $title;?>"><?php echo $nrofactura; ?></td>
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
  </div>
  
  <div id='resumidoDIV' style="display:none">
    
  <?php
  

   
 // $sql1 = "SELECT VCD.id, VCD.usuario,VCD.id_cuota FROM cuentaPorPagarDetalle as VCD INNER JOIN venta_cuotas as VC on VC.id=VCD.id_cuota where VCD.codigoCliente = '$cliente' GROUP by VC.venta_id order by id desc ";
  
  $sql1 = "SELECT VC.invnum,VC.numero_documento,VC.numero_documento1, VCD.usuario,VCD.id_cuota FROM cuentaPorPagarDetalle as VCD INNER JOIN movmae as VC on VC.invnum=VCD.id_cuota where VCD.codigoCliente = '$cliente' GROUP by VC.invnum order by id desc ";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
  ?>

    <table width="100%" align="center" border="0" id="customers">
      <thead id="Topicos_Cabecera_Datos">
        <tr style="font-size:12pt" class="GridviewScrollHeader">
          <th>N&ordm; </th>
          <th>USUARIO</span></th>
          <th>N DOCUMENTO</span></th>
          
           
        </tr>
      </thead>

      <?php 
      $i=0;
      while ($row1 = mysqli_fetch_array($result1)) {
          $i++;
        $id                     = $row1['invnum'];
       $codusu                 = $row1['usuario'];
       $id_cuota                 = $row1['id_cuota'];
    $numero_documento     = $row1['numero_documento'];
                  $numero_documento1    = $row1['numero_documento1'];
        
        
       $nrofactura=$numero_documento.'-'.$numero_documento1;

        $sql = "SELECT nomusu FROM usuario where usecod = '$codusu'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
          while ($row = mysqli_fetch_array($result)) {
            $nomusu = $row['nomusu'];
          }
        }
        
      
        
        
     
        
      ?>
        <tbody>
          <tr>
            <td><?php echo formato($i); ?></td>
            <td><?php echo $nomusu ?></td>
             
            <td> <a onclick="popup(<?php echo $id ?>)"><strong>
                         <?php echo $nrofactura;?> 
                        </strong>
                        </a></td>
             
             
           
          </tr>
        </tbody>
      <?php }
      ?>
    </table>
  <?php }
  ?>
  </div>
</body>

</html>