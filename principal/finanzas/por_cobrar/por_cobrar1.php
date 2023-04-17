<?php 
error_reporting(E_ALL);
  ini_set('display_errors', '1');
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

  <title><?php echo $desemp ?></title>
  <link href="css/letras.css" rel="stylesheet" type="text/css" />
  <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
  <link href="css/select.css" rel="stylesheet" type="text/css" />
  <link href="css/puntos.css" rel="stylesheet" type="text/css" />
  <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once('../../../convertfecha.php');  //CONEXION A BASE DE DATOS
  require_once("../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
  require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  ?>
 <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'd/m/Y'
            });
        });
    </script>
  <link href="../../select2/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </link>
  <script src="../../select2/jquery-3.4.1.js"></script>
  <script src="../../select2/js/select2.min.js"></script>

  <?php ////////////////////////////////////////////////////////////////////////////////////////////////
  $tipdoc = isset($_REQUEST['tipdoc']) ? $_REQUEST['tipdoc'] : "";
  $sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
      $user    = $row1['nomusu'];
      $codloc   = $row1['codloc'];
    }
  }
 
 
  $sql = "SELECT invnum FROM planilla order by invnum desc limit 1";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $numplan    = $row['invnum'];
    }
    $numplan++;
  } else {
    $numplan = 1;
  }
  
  function formato($c)
  {
    printf("%06d", $c);
  }
  function formato1($c)
  {
    printf("%04d", $c);
  }
  ?>
  <script>
    function sf() {
      document.form1.numdoc.focus();
    }

    function validar() {
      var f = document.form1;
      cliente = f.cliente.value
      
      if((cliente != "")||(cliente == "0")){
      
      f.action = "por_cobrar2.php";
      f.method = "post";
      f.submit();
      
      }else{
          alert("no hay cliente a buscar, porque no tiene ningun cliente con deuda.")
      }
    }
	function clickTipdoc() {
	     var f = document.form2;
	      if (f.tipdoc.value == '2') {
	          	document.getElementById("reprogramacionNone").style.display = "block";
	      }else{
	          	document.getElementById("reprogramacionNone").style.display = "none";
	      }
	    
	}
 
	
	
	
    function validarFromaPago() {
     var f = document.form2;
     formaPago= f.forpag.value; // E= efectivo //// D = deposito
     
         if(formaPago=="E"){
            
            f.nrobanco.disabled = true;
            f.banco.disabled = true;
             document.getElementById("nrobancoNone").style.display = "none";
             document.getElementById("bancoNone").style.display = "none";
             document.getElementById("nrobancoNone1").style.display = "none";
             document.getElementById("bancoNone1").style.display = "none";
             
             f.nrobanco.value = 0;
              
         }else if(formaPago=="D"){
            
            f.nrobanco.disabled = false;
            f.banco.disabled = false;
            
             	document.getElementById("nrobancoNone").style.display = "block";
                document.getElementById("bancoNone").style.display = "block";
                document.getElementById("nrobancoNone1").style.display = "block";
                document.getElementById("bancoNone1").style.display = "block";
         }
     
    }

    function montoApagar() {
      var l = document.form2;
      var  montoSaldoItem  = parseFloat(document.form2.montoSaldoItem.value); //saldo
      var  montoSaldoText = parseFloat(document.form2.montoSaldoText.value); //pago


      if (document.form2.montoSaldoText.value == "") {
        montoSaldoText = 0;
      }
      if (montoSaldoText <= montoSaldoItem) {
        calculoMonto = montoSaldoItem - montoSaldoText;
        l.saldoPendiente.value = calculoMonto.toFixed(2)
        l.saldoPendienteHidden.value = calculoMonto.toFixed(2)
        
        
      } else {
          
        l.montoSaldoText.value = 0;
        l.saldoPendiente.value = 0;
        l.saldoPendienteHidden.value = 0;
        alert("La Cantidad ingresada Excede al Saldo");
        f.montoSaldoText.focus();
        
        return;
      }
    }

    function saldosletra() {
      var f = document.form2;
      var v1 = parseFloat(document.form2.s.value); //saldo
      var v2 = parseFloat(document.form2.paga.value); //pago
      var plaz = parseFloat(document.form2.plazo.value); //plazo
      //        alert(v1);
      //	if (document.form2.plaz.value !== "")
      //	{
      v11 = v1 / plaz
      rest = v1 - v11;
      //	}
      f.paga.value = v11.toFixed(2)

      f.ttt.value = rest.toFixed(2)
    }

    function alerta() {
        alert("Se debe selecionar una cuota a pagar almenos, operacion no valida");
    }
    
     var statSend = false;
    function grabar() {
        if (!statSend) {
      var f = document.form2;
      
      var saldoPendienteHidden      = parseFloat(document.form2.saldoPendienteHidden.value); //saldo pendiente
      var tipoDocumento             = parseFloat(document.form2.tipdoc.value); //1 = contado //// 2 = reprogramacion
      var fechaActual               = document.form2.fechaActual.value; //1 = contado //// 2 = reprogramacion
      var fechaReprogramacion       = document.form2.date1.value; //1 = contado //// 2 = reprogramacion
      var formaPago                 = document.form2.forpag.value; //1 = contado //// 2 = reprogramacion
      var banco                     = document.form2.banco.value; //1 = contado //// 2 = reprogramacion
      var numeroBanco               = document.form2.nrobanco.value; //1 = contado //// 2 = reprogramacion
      
      //alert(fechaActual+' ------'+fechaReprogramacion);
      
      if(saldoPendienteHidden >0 ){
          if(tipoDocumento == 1){
               alert('El sado pendiente es mayor a 0, debe seleccionar reprogramacion de pago. ');return false;
          }else if(fechaActual == fechaReprogramacion ){
               alert('El sado pendiente es mayor a 0, la fecha de reprogramacion debe  que ser mayor a fecha actual.');return false;
          }else if(fechaReprogramacion <= fechaActual ){
               alert('El sado pendiente es mayor a 0, la fecha de reprogramacion debe  que ser mayor a fecha actual.');return false;
          }
      }
      
      if(formaPago == 'D'){
          
          if((banco == 0)||(banco == "")){
               alert('La forma de pago es deposito, seleccione banco. ');return false;
          }else  if((numeroBanco == 0)||(numeroBanco == "")){
               alert('La forma de pago es deposito, ya selecciono banco pero el numero de operacion esta en cero o vacio, agrege numero de operacion. ');return false;
          }
          
      }
      
 
        
        
        ventana = confirm("Desea Grabar estos datos");
            if (ventana) {
                f.method = "POST";
                f.action = "por_cobrar_reg.php";
                //window.open("pre_imprimir.php?invnum='" + valor1 + "'&proveedor='"+ valor2 +"'",'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                f.submit();
                statSend = true;
                return true;
            } else {
                return false;

            }
        } else {
            alert("El proceso esta siendo cargado espere un momento...");
            return false;
        }
    }

    function salir() {
      var l = document.form1;
      l.target = "_top";
      l.action = "../../index.php";
      l.submit();
    }
    var nav4 = window.Event ? true : false;

    function acceptNum(evt) {
      // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
      var key = nav4 ? evt.which : evt.keyCode;
      return (key <= 13 || (key >= 48 && key <= 57));

    }

    function cambia() {

      var f = document.form2;
      if (f.seleccionDeuda.value == "") {
        alert("N� OPERACION");
        f.seleccionDeuda.focus();
        return;
      }
      if (f.seleccionDeuda.value == 0) {
        alert("N� OPERACION");
        f.seleccionDeuda.focus();
        return;
      }
      f.method = "post";
      f.submit();
    }
  </script>
  <?php
  //$hour   = date(G);
  $dater  = date('Y-m-d');
  //$dater	= CalculaFechaHora($hour);
  
  	$valid = isset($_REQUEST['valid']) ? $_REQUEST['valid'] : "";
  	$val = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
  	$forpag = isset($_REQUEST['forpag']) ? $_REQUEST['forpag'] : "";
  	$cliente = isset($_REQUEST['cliente']) ? $_REQUEST['cliente'] : "";
  	$docux = isset($_REQUEST['docux']) ? $_REQUEST['docux'] : "";
  	$seleccionDeuda = isset($_REQUEST['seleccionDeuda']) ? $_REQUEST['seleccionDeuda'] : "";
  	
 
 
 

  $invnumss = $seleccionDeuda;

  $sql = "SELECT codcli,descli FROM cliente where codcli ='$cliente' order by descli ";
  $result = mysqli_query($conexion, $sql);
  while ($row = mysqli_fetch_array($result)) {
    $codigoCliente = $row["codcli"];
  }
  ?>
<link href="css/estilosPantalla.css" rel="stylesheet" type="text/css" />

<style>
    .loading {
			position: fixed;
			z-index: 9999;
			background: rgba(17, 17, 17, 0.5);
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
		}

		.loading div {
			position: absolute;
			background-image: url('loading.gif');
			background-size: 60px 60px;
			top: 50%;
			left: 50%;
			width: 60px;
			height: 60px;
			margin-top: -30px;
			margin-left: -30px;
		}
</style>
</head>

<body>
   
  <form name="form1" id="form2" onClick="highlight(event)" onKeyUp="highlight(event)">
    <table width="100%" border="0">
      <tr>
        <td width="42" class="LETRA">FECHA</td>
        <td width="113">
          <input class="LETRA2" name="textfield" type="text" disabled="disabled" value="<?php echo date('d/m/Y'); ?>" size="15" />
        </td>
 
        <td width="140">
          <div align="right" class="LETRA">CLIENTES </div>
        </td>
        <td width="300">

          <select style='width:250px;' id="cliente" name="cliente">
            <!--<option value="1" >SELECCIONE UN PROVEEDOR </option>-->
            <?php
            $sql = "SELECT C.codcli,C.descli,C.dnicli,C.ruccli FROM venta_cuotas AS VC INNER JOIN venta AS V on V.invnum=VC.venta_id INNER JOIN cliente AS C on C.codcli=V.cuscod WHERE V.forpag='C' and V.estado='0' and V.val_habil='0' and VC.montoCobro>0 Group by V.cuscod ";
            $result = mysqli_query($conexion, $sql);
            while ($row = mysqli_fetch_array($result)) {
              $codigoCliente = $row[0];
              $nombreCliente = $row[1];
              $dniCliente   = $row[2];
              $rucCliente   = $row[3];
              
              if($dniCliente <> ""){
                  $documento=$dniCliente;
              }else{
                  $documento=$rucCliente;
              }
            ?>
              <option value="<?php echo $codigoCliente; ?>" <?php if ($cliente == $codigoCliente) { ?> selected="selected" <?php } ?>><?php echo $nombreCliente.' - '. $documento; ?></option>
            <?php } ?>
          </select>
        </td>
        <td width="200">
          <input name="val" type="hidden" id="val" value="1" />
          <input type="button" name="Submit" value="Buscar" class="buscar" onclick="validar();" />
          <input type="button" name="Submit2" value="Salir" class="salir" onclick="salir();" />
        </td>
        <td width="200">
          <div align="right" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /><?php echo $user ?></div>
        </td>
      </tr>
    </table>
    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
  </form>
  <?php if ($val == 1) {
    
  ?>
    <form name="form2" id="form2" onClick="highlight(event)" onKeyUp="highlight(event)">
      <?php
      $sql1 = "SELECT  C.descli,SUM(VC.montoCobro) FROM venta_cuotas AS VC INNER JOIN venta AS V on V.invnum=VC.venta_id INNER JOIN cliente AS C on C.codcli=V.cuscod WHERE V.forpag='C' and V.estado='0' and V.val_habil='0'  and VC.montoCobro>0 and V.cuscod='$cliente' Group by V.cuscod ";
      $result1 = mysqli_query($conexion, $sql1);
      if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
          $nombreCliente    = $row1[0];
          $monto_deuda    = $row1[1];
        }
      }
      $saldo22     = $monto_deuda;
      $saldo     = $monto_deuda;
      if ($saldo == 0) {
        $desc_pendiente = "CANCELADO";
      } else {
        $desc_pendiente = "POR PAGAR";
      }
      
      $seleccionDeuda = isset($_REQUEST['seleccionDeuda']) ? $_REQUEST['seleccionDeuda'] : "";
      $ver = isset($_REQUEST['ver']) ? $_REQUEST['ver'] : "";
      
      if ($seleccionDeuda <> "") {
        $activ = isset($_REQUEST['activ']) ? $_REQUEST['activ'] : "";
        $codpro = isset($_REQUEST['codpro']) ? $_REQUEST['codpro'] : "";
        if ($activ == 1) {
        } else {
          $invnumss = $seleccionDeuda;
        }
        $valform  = 1;
      }

      
      ?>


      <table width="100%" border="0">

        <tr>
          <td>
            <br />
            <table width="100%" border="1" class="tabla2" align="center" cellpadding="0" cellspacing="0">
              <thead id="Topicos_Cabecera_Datos">
                <tr bgcolor="#83b9e7">
                  <th width="101">
                    <div align="center"><strong>N&ordm; DOC </strong></div>
                  </th>
                  <th width="366"><strong>CLIENTE</strong></th>
                  <th width="104">
                    <div align="center"><strong>ESTADO</strong></div>
                  </th>
                  <th width="100">
                    <div align="right"><strong>SALDO</strong></div>
                  </th>
                </tr>
              </thead>
              <tr>
                <td width="101">
                  <div align="center"><?php echo formato(1); ?></div>
                </td>
                <td width="366"><?php echo $nombreCliente; ?></td>
                <td width="104">
                  <div align="center"><?php echo $desc_pendiente; ?></div>
                </td>
                <td width="100">
                  <div align="center"><?php echo "S/ " . $numero_formato_frances = number_format($saldo22, 2, '.', ' '); ?></div>
                </td>
              </tr>
              <tr>
                <td bgcolor="#83b9e7" width="101">
                  <div align="center"><strong><?php if ($saldo == 0) { ?>ESTADO<?php } else { ?>SALDO<?php } ?></strong></div>
                </td>
                <td colspan="6" width="830" style='font-size: 18px;' <?php if ($saldo > 0) { ?>bgcolor="#fc783a" <?php } ?>> &nbsp;&nbsp;<strong><?php if ($saldo == 0) { ?> <font color="#000000">NO ADEUDA</font><?php } else { ?> <b style="color:#feeae5;"><?php echo " SALDO POR PAGAR " . $saldo22; ?></b> <?php } ?></strong></td>
              </tr>
            </table>
            <?php
            $sql = "SELECT VC.id,V.invfec,V.numeroCuota,VC.fecha_pago,V.nrofactura,VC.montoCobro,V.invnum,VC.fecha_pago_reprogramacion,VC.textoCuota FROM venta_cuotas AS VC INNER JOIN venta AS V on V.invnum=VC.venta_id INNER JOIN cliente AS C on C.codcli=V.cuscod WHERE V.forpag='C' and V.estado='0' and V.val_habil='0'  and VC.montoCobro>0 and V.cuscod='$cliente'  order by VC.id asc ";
            $result = mysqli_query($conexion, $sql);
            $valorComparacion='';
            $fechaPagoReprogr='';
            if (mysqli_num_rows($result)) {
            ?>
              <table width="100%" border="0"  align="center" cellpadding="0" cellspacing="0" scrolling="Automatic"  id="customers">
                <tr bgcolor="#83b9e7">
                  <th><div  align="center"> N&ordm;</div></th>
                  <th><div  align="center"> N&ordm; DOCUMENTO</div></th>
                  <th><div  align="center"> FECHA DE VENTA</div> </th>
                  <th><div  align="center"> CUOTA(S)</div></th>
                  <th><div  align="center"> FECHA PAGO CUOTA</div> </th>
                   
                  <th><div  align="center"> MONTO TOTAL</div></th>
                  <th></th>
                </tr>
                <?php
                $i = 0;

                while ($row1 = mysqli_fetch_array($result)) {
                  $invnumSelect           = $row1[0];
                  $invfec           = $row1[1];
                  $numeroCuota      = $row1[2];
                  $fecha_pago       = $row1[3];
                  $nrofactura       = $row1[4];
                  $monto_deuda      = $row1[5];
                  $invnumVenta      = $row1[6];
                  $fechaplazo       = $row1[7];
                  $textoCuota       = $row1[8];
                  
                  $i++;
                $fechaPagoReprogr=  ($fechaplazo =='0000-00-00')?fecha($fecha_pago) : fecha($fechaplazo) ;
                ?>
               <tr>
                    <td align="center"  ><?php echo $i; ?></td>
                    <td align="center">
                      <a href="ver_venta_usu.php?invnum=<?php echo $invnumVenta ?>" target="_blank" onclick="window.open(this.href,this.target,'width=1000,height=300,top=180,bottom=200,left=100,right=100,toolbar=no,location=no,status=no,menubar=no');return false;"><strong>
                         <?php echo $nrofactura;?> 
                        </strong>
                        </a>
                    </td>
                    <td align="center"><?php echo fecha($invfec); ?></td>
                    <td align="center"><?php echo $textoCuota; ?></td>
                    <td align="center"> <?php echo $fechaPagoReprogr;  ?></td>
                   
                    <td align="center"><?php echo "S/ " . $monto_deuda; ?></td>
                    <td align="center"><input name="seleccionDeuda" type="radio" id="seleccionDeuda" value="<?php echo $invnumSelect; ?>" <?php if ($seleccionDeuda == $invnumSelect) { ?> checked <?php } ?> <?php if ($i<>1) { ?> disabled="disabled" <?php } ?>   onchange="cambia()" />  </td>

                  </tr>
                <?php 
                }
                ?>
              </table>
            <?php }
             
            if (($saldo22 <> 0)&& ($seleccionDeuda !=''))  {
            ?>
              
              <?php  
              $monto_deuda22=0;
              $sql1 = "SELECT id,montoCobro,textoCuota,fecha_pago,fecha_pago_reprogramacion FROM `venta_cuotas` WHERE id='$seleccionDeuda' and montoCobro >0";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                  $id    = $row1['id'];
                  $monto_deudare    = $row1['montoCobro'];
                
                  $fecha_pago    = $row1['fecha_pago'];
                  $fechaplazo    = $row1['fecha_pago_reprogramacion'];
                  $textoCuota    = $row1['textoCuota'];
                }
                
                $fechaPagoReprogrHidden=  ($fechaplazo =='0000-00-00')?fecha($fecha_pago) : fecha($fechaplazo) ;
                 
                $monto_deuda22 +=  $monto_deudare;
                $saldo = $monto_deuda22;
              }
              ?>
              
                 <fieldset style="width:98%;">
                    <legend style="color:brown;font-size:16px;"> <strong>REALIZAR COBRANZA</strong></legend>
              <table width="100%" height="111" border="0" align="center" class="tabla2">
                <tr>
                  <td valign="top">
                    <table width="100%" border="0" align="center">
                        <tr>
                           <td width="133" class="LETRA">CUOTA A PAGAR</td>
                           <td colspan="4"> <input    style="width:130px" class="LETRA2"  name="textoCuota" id="textoCuota"  type="text" style="border-width:0px; width: 74px; font-size:12px;" readonly="true" value="<?php echo $textoCuota; ?>"   /></td>
                        </tr>
                      <tr>
                        <td width="133" class="LETRA">FECHA REGISTRO</td>
                        <td width="712" colspan="2">
                            
                          <input    style="width:130px" class="LETRA2"    type="text" style="border-width:0px; width: 74px; font-size:12px;" readonly="true" value="<?php echo fecha($dater); ?>" <?php if ($saldo == 0) { ?> disabled="disabled" <?php } ?> />
                          
                         <!-- <img style="cursor:pointer;" onclick="showCalendar(1)" src="../../../funciones/codebase/imgs/calendar.gif" align="absmiddle" />
                          <div id="calendar1" style="position:absolute; left:94px; top:0px; display:none"></div>
                          -->
                        </td>
                        <td width="173" align="right" class="LETRA">  <div id='bancoNone1' style="display:none">BANCO </div></td>
                        <td width="220">
                          <div id='bancoNone' style="display:none">
                          <select  style="width:130px" name="banco" id="banco">
                            <option value="0">Seleccione un Banco</option>
                            <?php
                            $sql = "SELECT * FROM titultabladet where tiptab = 'B' order by destab";
                            $result = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                              <option value="<?php echo $row["codtab"] ?>"><?php echo $row["destab"] ?></option>
                            <?php }
                            ?>
                          </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="LETRA">TIPO DOCUMENTO </td>
                        <td>
                          <input name="sal" type="hidden" id="sal" value="<?php echo $saldo ?> " />
                          <select style="width:138px" name="tipdoc" id="tipdoc" onchange="clickTipdoc()" <?php if ($saldo == 0) { ?> disabled="disabled" <?php } ?>  >
                            <option value="1" <?php if ($tipdoc == 1) { ?>selected="selected" <?php } ?> >CONTADO</option>
                            <option value="2" <?php if ($tipdoc == 2) { ?>selected="selected" <?php } ?> >REPROGRAMAR PAGO</option>
                          </select>
                        </td>
                        <td>
                            <div id='reprogramacionNone' style="display:none">
                              <strong>FECHA DE REPROGRAMACION </strong> 
                              <input style="width:auto;" tabindex="2" type="text" name="date1" id="date1" size="25" value="<?php echo fecha(date('Y-m-d')); ?>"  >
                             
                            </div>
                        </td>
                        <td width="500" class="LETRA" align="right">  <div id='nrobancoNone1' style="display:none">NUMERO DE OPERACION DEL BANCO  </div></td>
                        <td width="350">
                            <div id='nrobancoNone' style="display:none">
                            <input name="nrobanco" type="text" id="nrobanco" size="20" disabled="disabled" />
                            </div>
                            </td>
                      </tr>
                      <tr>
                        <td class="LETRA">FORMA DE PAGO </td>
                        <td colspan="4">
                          <select  style="width:138px" name="forpag" id="forpag" onclick="validarFromaPago();" onkeyup="validarFromaPago()" onchange="validarFromaPago();"    <?php if ($saldo == 0) { ?> disabled="disabled" <?php } ?>>
                            <option value="E" selected="selected">EFECTIVO</option>
                            <option value="D">DEPOSITO</option>
                           
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="LETRA">MONTO A PAGAR </td>
                        <td colspan="4">
                          <input name="montoSaldoItem" type="hidden" id="montoSaldoItem" value="<?php echo $saldo ?>" />
                          <input name="montoSaldoText"  style="width:130px" type="text" id="montoSaldoText" <?php if ($seleccionDeuda <> 0) { ?> value="<?php echo $saldo; ?>" <?php } ?>   <?php if ($seleccionDeuda !='') { ?> onkeyup="montoApagar()"<?php }else{  ?>   onclick="alerta();"   <?php }  ?>                          />
                        </td>

                      </tr>
                      <tr>
                        <td class="LETRA">SALDO PENDIENTE </td>
                        <td colspan="4">
                          <input name="saldoPendienteHidden" type="hidden" id="saldoPendienteHidden" />
                          <input class="LETRA2"  style="width:130px" style="color:#ff2d00;" name="saldoPendiente" id="saldoPendiente"  type="text" <?php if ($seleccionDeuda <> 0) { ?> value="<?php echo "0.00"; ?>" <?php } ?> disabled="disabled" />
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                    <td>
                         <div align="right">
                            <input type="button" name="Submit3" value="Grabar" class="grabarventa" <?php if ($saldo == 0) { ?> disabled="disabled" <?php } ?> <?php if ($seleccionDeuda !='') { ?> onclick="grabar()"<?php }else{  ?>   onclick="alerta();"  <?php }  ?>     />
                             <input name="fechaActual" type="hidden" id="fechaActual" value="<?php echo date('d/m/Y'); ?>" />
                            <input name="antiguo" type="hidden" id="antiguo" value="<?php echo $monto_deudare ?>" />
                            <input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
                            <input name="cliente" type="hidden" id="cliente" value="<?php echo $cliente ?>" />
                            <input name="fechaPagoReprogrHidden" type="hidden" id="fechaPagoReprogrHidden" value="<?php echo $fechaPagoReprogrHidden ?>" />
                          </div>
                    </td>
                </tr>
                
                
              </table>
              </fieldset>
 

            <?php } ?>
           
               <fieldset style="width:98%;">
                    <legend style="color:brown;font-size:16px;"> <strong>DETALLE DE COBRANZA </strong></legend>
                    
            
                  <center>
                    <iframe src="por_cobrar3.php?cliente=<?php echo $cliente ?>" name="iFrame1" width="100%" height="500" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
                    </iframe>

                  </center>
                 
</fieldset>
          </td>
        </tr>
      </table>
    </form>
  <?php } else {
  ?>
    <br><br><br><br>
    <br><br><br><br>
    <br><br><br><br>
    <div align="center">
      <h3 class='Estilo2'>
        SELECCIONE UN CLIENTE A BUSCAR
      </h3>
    </div>
  <?php // } //CIERRO EL VALID
  } //CIERRO EL VAL
  ?>
</body>

</html>
<script>
  $('#cliente').select2();
  $('#banco').select2();
  $('#forpag').select2();
  $('#tipdoc').select2();
  //	
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>