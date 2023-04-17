<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('../../session_user.php');
?>

<?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');  //CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES


$es_transferencia = false;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        input,
        select,
        textarea {
            border-radius: 15px;
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
        }

        th {
            padding: 10px;
            color: #fff;
            /* background-color: #438FFF !important;  paracambiar colores */
        }

        body {
            /* background-color: #EAEAEA !important; */
        }
    </style>
    <link href="css/letras.css" rel="stylesheet" type="text/css" />

    <!--<link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css"> !-->

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////

    $UbigeoLlegada = isset($_REQUEST['UbigeoLlegada']) ? ($_REQUEST['UbigeoLlegada']) : "";
    $UbigeoPartida = isset($_REQUEST['UbigeoPartida']) ? ($_REQUEST['UbigeoPartida']) : "";

    $Ubigeodireccion = "";





    $UnidadMedidaPesoBruto = isset($_REQUEST['UnidadMedidaPesoBruto']) ? ($_REQUEST['UnidadMedidaPesoBruto']) : "";



    $tipdoc = isset($_REQUEST['tipdoc']) ? $_REQUEST['tipdoc'] : "";
    $sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user    = $row1['nomusu'];
            $codloc   = $row1['codloc'];
        }
    }

    $sqlDrogueria = "SELECT drogueria FROM datagen_det";
    $resultDrogueria = mysqli_query($conexion, $sqlDrogueria);
    if (mysqli_num_rows($resultDrogueria)) {
        while ($rowDrogueria = mysqli_fetch_array($resultDrogueria)) {
            $drogueria    = $rowDrogueria['drogueria'];
          
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
        function cambiarDNIRUCDestinatario() {
            var index = document.getElementById("tipoDocumentoIdentidad").value;

            if (index == 6) {
                document.getElementById("numeroDocumentoDestinatario").maxLength = 11;
            } else if (index == 1) {
                document.getElementById("numeroDocumentoDestinatario").maxLength = 8;
            }

            document.getElementById("numeroDocumentoDestinatario").value = "";
        }

        function cambiarDNIRUCTransporte() {


            var index = document.getElementById("tipoDocumentoIdentidadTransportista").value;
            var index2 = document.getElementById("tipoDocumentoIdentidadTransportistaPrivado").value;


            if (index == 6) {
                document.getElementById("numeroDocumentoTransportista").maxLength = 11;
            } else if (index == 1) {
                document.getElementById("numeroDocumentoTransportista").maxLength = 8;
            }

            if (index2 == 6) {
                document.getElementById("numeroDocumentoTransportistaPrivado").maxLength = 11;
            } else if (index2 == 1) {
                document.getElementById("numeroDocumentoTransportistaPrivado").maxLength = 8;
            }

            document.getElementById("numeroDocumentoTransportista").value = "";
            document.getElementById("numeroDocumentoTransportistaPrivado").value = "";
        }


        function sf() {
            document.form1.numdoc.focus();
        }

        function validar() {
            var f = document.form1;
            tipoBusqueda1 = f.tipoBusqueda.value
            numeroDocumento1 = f.numeroDocumento.value

            if ((tipoBusqueda1 == "") || (tipoBusqueda1 == 0)) {
                alert("Seleccione un tipo de busquedad");
                f.tipoBusqueda.focus();
                return;
            }

            if ((numeroDocumento1 == "") || (numeroDocumento1 == "0")) {
                alert("Ingrese un numero documento valido.");
                f.numeroDocumento.focus();
                return;
            }

            f.action = "guia2.php";
            f.method = "post";
            f.submit();

        }

        function validarFromaPago() {

            var f = document.form2;
            formaPago = f.forpag.value; // E= efectivo //// D = deposito

            if (formaPago == "E") {

                f.nrobanco.disabled = true;
                f.banco.disabled = true;
                document.getElementById("nrobancoNone").style.display = "none";
                document.getElementById("bancoNone").style.display = "none";
                document.getElementById("nrobancoNone1").style.display = "none";
                document.getElementById("bancoNone1").style.display = "none";

                f.nrobanco.value = 0;

            } else if (formaPago == "D") {

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
            var montoSaldoItem = parseFloat(document.form2.montoSaldoItem.value); //saldo
            var montoSaldoText = parseFloat(document.form2.montoSaldoText.value); //pago


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
                /*var VenvioPorTercero = parseFloat(f.envioPorTercero.value); 
      
       if(VenvioPorTercero == "" || VenvioPorTercero == 0){
           alert("Seleccione una opcion para continuar.");
            return;
      }*/

                ventana = confirm("Desea Grabar estos datos");
                if (ventana) {
                    f.method = "POST";
                    f.action = "guia_reg.php";
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

        function cargarContenido() {

            var VmodalidadTraslado = parseFloat(document.getElementById("modalidadTraslado").value); //saldo

            //editadoAdrian
            if (VmodalidadTraslado == 1) {
                document.getElementById("trasportePrivado").style.display = "none";
                document.getElementById("trasportePublico").style.display = "block";

                document.getElementById("tipoDocumentoIdentidadTransportistaPrivado").value = '';
                document.getElementById("numeroDocumentoTransportistaPrivado").value = '';
                document.getElementById("empresaTransportistaPrivado").value = '';
                document.getElementById("licenciaConductor").value = '';

                document.getElementById("tipoDocumentoIdentidadTransportista").required = true;
                document.getElementById("numeroDocumentoTransportista").required = true;
                document.getElementById("empresaTransportista").required = true;

                document.getElementById("tipoDocumentoIdentidadTransportistaPrivado").required = false;
                document.getElementById("numeroDocumentoTransportistaPrivado").required = false;
               document.getElementById("empresaTransportistaPrivado").required = false;
               document.getElementById("licenciaConductor").required = false;




            } else if (VmodalidadTraslado == 2) {
                document.getElementById("trasportePrivado").style.display = "block";
                document.getElementById("trasportePublico").style.display = "none";

                document.getElementById("tipoDocumentoIdentidadTransportista").value = '';
                document.getElementById("numeroDocumentoTransportista").value = '';
                document.getElementById("empresaTransportista").value = '';

                document.getElementById("tipoDocumentoIdentidadTransportista").required = false;
                document.getElementById("numeroDocumentoTransportista").required = false;
                document.getElementById("empresaTransportista").required = false;

                document.getElementById("tipoDocumentoIdentidadTransportistaPrivado").required = true;
                document.getElementById("numeroDocumentoTransportistaPrivado").required = true;
                document.getElementById("empresaTransportistaPrivado").required = true;
                document.getElementById("licenciaConductor").required = true;
                

            }

        }
    </script>

    <?php
    //$hour   = date(G);
    $fechaActual        = date('Y-m-d');
    $val                = isset($_REQUEST['val']) ? $_REQUEST['val'] : "";
    $tipoBusqueda       = isset($_REQUEST['tipoBusqueda']) ? $_REQUEST['tipoBusqueda'] : "";
    $numeroDocumento    = isset($_REQUEST['numeroDocumento']) ? $_REQUEST['numeroDocumento'] : "";

    if ($val == 1) {
        //VENTAS
        if ($tipoBusqueda == 1) {
            // echo 'VENTAS ='.  "<br>";
            //$tabla='detalle_venta  as DV';
            $select = "
  	    SELECT DV.codpro as codigo, 
  	    IF(DV.fraccion = 'F' , CONCAT('C',DV.canpro) ,  DV.canpro) as cantidad,
  	    P.desprod as descripcion , 
  	    DV.prisal as precio, 
  	    DV.pripro as subTotal 
  	    FROM detalle_venta DV 
  	    INNER JOIN producto P 
  	    on P.codpro=DV.codpro";

            $sql = "SELECT invnum,val_habil,guiaRemision,nrofactura,sucursal FROM venta where nrofactura ='$numeroDocumento' and estado=0 and invtot>0 and guiaRemision=0 ";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $invnum        = $row['invnum'];
                    $val_habil        = $row['val_habil'];
                    $guiaRemision        = $row['guiaRemision'];
                    $nrofactura        = $row['nrofactura'];
                    $sucursal_origen        = $row['sucursal'];
                }
            } else {
                echo '<script type="text/javascript">
                    alert("No se encontro registos o ya se genero una guia del documento");
                     window.location.href="guia1.php";
             </script>';
                return;
            }
        } else if ($tipoBusqueda == 2) {
            //TRANSFERENCIA
            //echo 'TRANSFERENCIA ='.  "<br>";


            $sqlubigeoPartida = "SELECT direccion, ubigeo FROM ticket WHERE sucursal = '$codloc' ";



            $resultUbigeoPartida = mysqli_query($conexion, $sqlubigeoPartida);

            if (mysqli_num_rows($resultUbigeoPartida)) {
                while ($rowUP = mysqli_fetch_array($resultUbigeoPartida)) {
                    $Ubigeodireccion = $rowUP['direccion'];
                    $UbigeoPartida = $rowUP['ubigeo'];
                }
            }







            $select = "SELECT M.codpro as codigo, 
  	    IF(M.qtypro != '' , M.qtypro,  M.qtyprf) as cantidad,
        P.desprod as descripcion , 
  	    M.pripro as precio, 
  	    M.costre as subTotal
		FROM movmov M
  	    INNER JOIN producto P 
  	    on P.codpro=M.codpro";
            $sql = "SELECT * FROM movmae WHERE tipmov='2' and tipdoc='3' and numdoc='$numeroDocumento' and guiaRemision='0'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $invnum        = $row['invnum'];
                    $val_habil        = $row['val_habil'];
                    $guiaRemision        = $row['guiaRemision'];
                    $numdoc        = $row['numdoc'];
                    $sucursal_origen        = $row['sucursal'];
                    $es_transferencia = true;
                }
            } else {
                echo '<script type="text/javascript">
                    alert("No se encontro registos");
                    window.location.href="guia1.php";
             </script>';
                return;
            }
        }

        //echo '$val_habil = '.$val_habil."<br>";
        //echo '$guiaRemision = '.$guiaRemision."<br>";
        if ($val_habil == 1) {

            echo '<script type="text/javascript">
                        alert("El numero de documento se encuentra deshabilitada");
                        window.location.href="guia1.php";
                 </script>';
            return;
        }

        if ($guiaRemision == 1) {
            echo '<script type="text/javascript">
                    alert("El numero de documento tiene una guia de remision realizada");
                    window.location.href="guia1.php";
             </script>';
            return;
        }
    }




    //echo '$val             = '.$val."<br>";
    //echo '$tipoBusqueda    = '.$tipoBusqueda."<br>";
    //echo '$numeroDocumento = '.$numeroDocumento."<br>";


    ?>


    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>

    <title><?php echo $desemp ?></title>


</head>

<body id="container" style="height: 1000px;">
    <form name="form1" id="form1">
        <!--onClick="highlight(event)" onKeyUp="highlight(event)"-->
        <table width="90%" border="0" id="customers" class="table table-bordered" style="background-color: #e2ecf8; border-color: white;">

            <tr>
                <!--<td width="42" class="LETRA">FECHA</td>
                <td width="113">
                  <input class="LETRA2" name="textfield" type="text" disabled="disabled" value="<?php echo date('d/m/Y'); ?>" size="15" />
                </td>-->


                <th width="100">

                    <div align='center' style="color:#000  !important; align-items:center; margin-top: 10px;">Tipo de Busqueda: </div>
                </th>
                <td width="100">
                    <select class="form-select " aria-label="Default select example" id="tipoBusqueda" name="tipoBusqueda" class="form-select">
                        <!--<option selected >Seleccione una Opción</option>!-->
                        <option selected value="1" <?php if ($tipoBusqueda == 1) { ?> selected="selected" <?php } ?>>Ventas </option>
                        <option value="2" <?php if ($tipoBusqueda == 2) { ?> selected="selected" <?php } ?>>Transferencia </option>
                    </select>
                </td>
                <th width="100">
                    <div align="center" type='text' class="LETRA" style="color:#000  !important; margin-top: 10px;">Numero de Documento: </div>
                </th>
                <td width='100'>
                    <input class="form-control" name="numeroDocumento" id="numeroDocumento" type="text" value="<?php echo $numeroDocumento; ?>" />
                </td>
                <td width="150">
                    <input name="val" type="hidden" id="val" value="1" />

                    <?php if ($val != 1) { ?>
                        <input type="button" name="Submit" value="Buscar" class="btn btn-primary" onclick="validar();" />
                    <?php } ?>
                    <?php if ($val == 1) { ?>
                        <!--<input type="button" onclick="//;" />!-->
                        <button type="submit" class="btn btn-success" form="form2" name="Submit2" value="Grabar">Grabar</button>
                    <?php } ?>


                    <?php if ($val == 1) { ?>

                        <input type="button" name="Submit2" value="Salir" class="btn btn-danger" onclick="window.parent.location.href='../guia/guia.php';" />
                    <?php } else { ?>
                        <input type="button" name="Submit2" value="Salir" class="btn btn-danger" onclick="window.parent.location.href='../ing_salid.php';" />
                    <?php  } ?>


                    <?php if ($val == 1) { ?>
                        <button onClick="window.location.reload();" class="btn btn-warning">Limpiar</button>
                    <?php } ?>






                </td>
                <td width="200">
                    <div align="center" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /><?php echo $user ?></div>
                </td>
            </tr>

        </table>
    </form>

    <?php if ($val == 1) { ?>





        <form id="form2" name="form2" onsubmit="return grabar()">
            <!--onClick="highlight(event)" onKeyUp="highlight(event)"-->

            <input name="tipoBusqueda" type="hidden" value="<?php echo $tipoBusqueda; ?>" />
            <input name="invnum" type="hidden" value="<?php echo $invnum; ?>" />


            <table width="100%" border="0" class="table table-bordered" style="background-color: white; border-color: white;">

                <tr>
                    <td colspan="4">
                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>INFORMACION PRINCIPAL</strong></legend>




                            <div class="div_remitenteG">
                                <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">

                                    <tr style="width:100%;background-color: #2e91d2;">
                                        <th width="25%">
                                            FECHA EMISION(*)
                                        </th>
                                        <th width="25%">
                                            PUERTO DE EMBARQUE
                                        </th>
                                        <th width="25%">
                                            DATOS CONTENEDOR
                                        </th>
                                        <th width="25%">
                                            ENVIO POR TERCEROS
                                        </th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input id="fechaEmision" name="fechaEmision" type="text" class='form-control' value="<?php echo fecha($fechaActual); ?>" />
                                        </td>
                                        <td>
                                            <input id="puertoAeropuerto" name="puertoAeropuerto" type="text" class='form-control' value="" placeholder="Ejemplo: PAI" />
                                        </td>
                                        <td>
                                            <input id="datosContenedor" name="datosContenedor" type="text" class='form-control' value="" placeholder="Ejemplo: PGY-645" />
                                        </td>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="envioPorTercero" name="envioPorTercero" required>

                                                <option value="0" selected>Por Defecto(NO) </option>
                                                <option value="2">SI </option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>


                    </td>
                    <td>

                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DATOS DEL DESTINATARIO</strong></legend>


                            <div class="div_destinatarioG">



                                <?php

                                $rucT = "";
                                $razon_socialT = "";

                                if ($es_transferencia) {
                                    $sql = "SELECT ruc, razon_social FROM movmae 
                            INNER JOIN emisor ON movmae.sucursal = emisor.id
                            WHERE tipmov=2 and tipdoc=3 and invnum = '$invnum'";

                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $rucT    = $row["ruc"];
                                        $razon_socialT = $row["razon_social"];
                                    }
                                }


                                ?>

                                <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">

                                    <tr style="width:100%;background-color: #2e91d2;">
                                        <th width="15%">
                                            RUC/DNI(*)
                                        </th>
                                        <th width="25%">
                                            NUMERO DE DOCUMENTO(*)
                                        </th>
                                        <th width="35%">
                                            NOMBRES Y APELLIDOS Y/O RAZÓN SOCIAL(*)
                                        </th>

                                    </tr>

                                    <tr>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="tipoDocumentoIdentidad" name="tipoDocumentoIdentidad" onchange="cambiarDNIRUCDestinatario();">

                                                <!-- <option value="" selected>Seleccione una opción </option> -->
                                                <option value="6">RUC </option>
                                                <!-- <option value="1">DNI </option> -->
                                                <?= ($es_transferencia) ? '' :'<option value="1" >DNI </option>' ?>
                                            </select>
                                        </td>
                                        <td>
                                        <input id="numeroDocumentoDestinatario" name="numeroDocumentoDestinatario" type="text" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" class='form-control' value="<?=$rucT?>" placeholder="Ejemplo:20000000001"  required />    
                                        <!-- <input id="numeroDocumentoDestinatario" name="numeroDocumentoDestinatario" type="text" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" class='form-control' value="" placeholder="Ejemplo:20000000001" required /> -->
                                        </td>
                                        <td>
                                        <input id="empresaDestino" name="empresaDestino" type="text" class='form-control' value="<?=$razon_socialT?>"  placeholder="Ejemplo:Empresa de destino"  size="90" onkeyup="this.value = this.value.toUpperCase();" required/>
                                        <!-- <input id="empresaDestino" name="empresaDestino" type="text" class='form-control' value="" placeholder="Ejemplo:Empresa de destino" size="90" onkeyup="this.value = this.value.toUpperCase();" required /> -->
                                        </td>
                                    </tr>
                                </table>

                            </div>
                    </td>
                </tr>




                <tr>
                    <td colspan="3">
                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DATOS DE ENVIO</strong></legend>


                            <div class="div_destinatarioG">
                                <?php

                                $rucT = "";
                                $razon_socialT = "";

                                if ($es_transferencia) {
                                    $sql = "SELECT ruc, razon_social FROM movmae INNER JOIN emisor ON movmae.sucursal = emisor.id WHERE tipmov=2 and tipdoc=3 and invnum = '$invnum'";

                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $rucT    = $row["ruc"];
                                        $razon_socialT = $row["razon_social"];
                                    }
                                }


                                ?>

                                <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">

                                    <tr style="width:99%;background-color: #2e91d2;">
                                        <th>
                                            MOTIVO DE TRASLADO(*)
                                        </th>
                                        <th>
                                            DESCRIPCION DE MOTIVO DE TRASLADO(*)
                                        </th>
                                        <th>
                                            OBSERVACION(*)
                                        </th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="motivoTranslado" name="motivoTranslado" required>
                                                <option value="" selected>Seleccione una opción </option>
                                                <option value="01">VENTA</option>
                                                <option value="02">COMPRA</option>
                                                <option value="04">TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA</option>
                                                <option value="08">IMPORTACION</option>
                                                <option value="09">EXPORTACION</option>
                                                <option value="13">OTROS</option>
                                                <option value="14">VENTA SUJETA A CONFIRMACION DEL COMPRADOR</option>
                                                <option value="18">TRASLADO EMISOR ITINERANTE CP</option>
                                                <option value="19">TRASLADO A ZONA PRIMARIA</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class='form-control' id="descripcionMotivoTraslado" name="descripcionMotivoTraslado" type="text" value="" placeholder="Ejemplo:Para almacen" required />
                                        </td>
                                        <td>
                                            <input class='form-control' id="descripcionNotas" name="descripcionNotas" type="text" value="" placeholder="Ejemplo:Para almacen" required />
                                        </td>
                                    </tr>

                                    <tr style="width:99%;background-color: #2e91d2;">
                                        <th>
                                            TRANSBORDO PROGRAMADO
                                        </th>
                                        <th>
                                            PESO BRUTO DE LOS BIENES(*)
                                        </th>
                                        <th>
                                            UNIDAD DE MEDIDA PESO BRUTO(*)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="indicadorTransbordoProgramado" name="indicadorTransbordoProgramado" required>
                                                <option value="1" selected>Por Defecto (NO)</option>
                                                <option value="2">SI </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class='form-control' id="pesoBrutoTotalBienes" name="pesoBrutoTotalBienes" type="text" value="" placeholder="Ejemplo:1000.00" required />
                                        </td>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="unidadMedidaPesoBruto" name="unidadMedidaPesoBruto" required>
                                                <option value="">--SELECCIONE UNIDAD--</option>

                                                <?php
                                                $sql = "SELECT code_master,name_master FROM ss_master";
                                                $result = mysqli_query($conexion, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $code_master = $row["code_master"];
                                                    $name_master = $row["name_master"];

                                                ?>
                                                    <option value="<?php echo $code_master ?>" <?php if ($code_master == $UnidadMedidaPesoBruto) { ?>selected="selected" <?php } ?> class="Estilodany"><?php echo $name_master ?></option>
                                                <?php } ?>

                                            </select>

                                        </td>
                                    </tr>

                                    <tr style="width:99%;background-color: #2e91d2;">
                                        <th>
                                            Nº DE BULTOS O PAQUETES(*)
                                        </th>
                                        <th>
                                            MODALIDAD DE TRASLADO(*)
                                        </th>
                                        <th>
                                            FECHA INICIO DE TRASLADO(*)
                                        </th>
                                    </tr>
                                    <tr>

                                        <td>
                                            <input class='form-control' id="numeroBultosPaquetes" name="numeroBultosPaquetes" type="text" value="" placeholder="Ejemplo:5" required />
                                        </td>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="modalidadTraslado" name="modalidadTraslado" onkeyup="cargarContenido()" onchange="cargarContenido()" required>
                                                <option value="" selected>Seleccione una opción </option>
                                                <option value="01">Transporte Publico</option>
                                                <option value="02">Transporte Privado</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class='form-control' id="fechaInicioTraslado" name="fechaInicioTraslado" type="date" value="<?php echo date('Y-m-d'); ?>" required />
                                        </td>
                                    </tr>

                                </table>
                            </div>
                    </td>


                    <td colspan="3">
                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>TRANSPORTISTA (TRANSPORTE PUBLICO)</strong></legend>

                            <div class="div_destinatarioG" id="trasportePublico"  >

                                <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">

                                    <tr style="width:99%;background-color: #2e91d2;">
                                        <th>
                                            TIPO DE DOCUMENTO
                                        </th>
                                        <th>
                                            NUMERO DE DOCUMENTO
                                        </th>
                                        <th>
                                            NOMBRES Y APELLIDOS Y/O RAZON SOCIAL
                                        </th>

                                    </tr>


                                    <tr>
                                        <td>
                                            <select class="form-select" aria-label="Default select example" id="tipoDocumentoIdentidadTransportista" name="tipoDocumentoIdentidadTransportista" onchange="cambiarDNIRUCTransporte();">
                                                <option value="" selected>Seleccione una opción </option>
                                                <option value="6">RUC </option>
                                                <option value="1">DNI </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class='form-control' id="numeroDocumentoTransportista" name="numeroDocumentoTransportista" type="text" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" value="" placeholder="Ejemplo:20000000001" />
                                        </td>
                                        <td>
                                            <input class='form-control' id="empresaTransportista" name="empresaTransportista" type="text" value="" placeholder="Ejemplo:Empresa de destino" onkeyup="this.value = this.value.toUpperCase();" size="90" />
                                        </td>
                                    </tr>


                                </table>

                            </div>
                            <br>
                            <br>

                            <fieldset class="border p-2">
                                <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>TRANSPORTISTA (TRANSPORTE PRIVADO)</strong></legend>


                                <div class="div_destinatarioG"  id="trasportePrivado" >
                                    <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">
                                        <tr style="width:99%;background-color: #2e91d2;">
                                            <th>
                                                TIPO DE DOCUMENTO
                                            </th>
                                            <th>
                                                NUMERO DE RUC
                                            </th>
                                            <th>
                                                LICENCIA CONDUCTOR
                                            </th>
                                            <th>
                                                PLACA DEL VEHICULO
                                            </th>

                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-select" aria-label="Default select example" id="tipoDocumentoIdentidadTransportista" name="tipoDocumentoIdentidadTransportistaPrivado" onchange="cambiarDNIRUCTransporte();">
                                                    <option value="">Seleccione una opcion</option> 
                                                    <option value="6">RUC </option>
                                                    <option value="1">DNI </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class='form-control' id="numeroDocumentoTransportistaPrivado" name="numeroDocumentoTransportistaPrivado" type="text" maxlength="11" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" value="" placeholder="Ejemplo:20000000001" />
                                            </td>
                                            <td>
                                                <input class='form-control' id="licenciaConductor" name="licenciaConductor" type="text"   maxlength="9" value="" placeholder="Ejemplo: Q123123" onkeyup="this.value = this.value.toUpperCase();" size="70" />
                                            </td>
                                            <td>
                                                <input class='form-control' id="empresaTransportistaPrivado" name="empresaTransportistaPrivado" type="text" maxlength="6" value=""  placeholder="Ejemplo: SC2T41M" onkeyup="this.value = this.value.toUpperCase();" size="50" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>



                    </td>

                </tr>

                <tr>
                    <td colspan="3">
                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DIRECCION PUNTO DE PARTIDA</strong></legend>
                            <div class="control-group">
                                <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">
                                    <tr style="width:99%;background-color: #2e91d2;">
                                        <th>
                                            BUSCAR UBIGEO
                                        </th>
                                        <th>
                                            DIRECCION COMPLETA Y DETALLADA DE PARTIDA
                                        </th>
                                    </tr>
                                    <tr>

                                        <td>


                                            <?php

                                            $sql = "select CONCAT(departamento, ' - ',provincia,' - ',distrito) as direccionUbi,ubigeo,direccion from ticket WHERE id=$sucursal_origen ";
                                            $result = mysqli_query($conexion, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $direccionUbi    = $row["direccionUbi"];
                                                $ubigeo1 = $row["ubigeo"];
                                                $direccion = $row["direccion"];
                                            }

                                            ?>


                                            <input class='form-control' type="text" value="<?= $direccionUbi; ?>" disabled />
                                            <input class='form-control' type="hidden" name='UbigeoPartida' id='UbigeoPartida' value="<?= $ubigeo1; ?>" />


                                        </td>
                                        <td>
                                            <input class='form-control' name='direccionDePartida' id='direccionDePartida' type="text" value="<?= $direccion; ?>" size="130" placeholder="Ejemplo:CAR. MALGINAL SATIPO MAZAMARI KM. 4.8" />
                                        </td>



                                    </tr>
                                </table>
                            </div>
                        </fieldset>
                    </td>

                    <td colspan="3">


                        <fieldset class="border p-2">
                            <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>DIRECCION PUNTO DE LLEGADA</strong></legend>


                            <table class="table_cabe" width="100%" style="width:99%; background-color: #FFFF00; border-color: white;" border="0" id="customers" class="table table-bordered">
                                <tr style="width:99%;background-color: #2e91d2;">
                                    <th>
                                        BUSCAR UBIGEO
                                    </th>
                                    <th>
                                        DIRECCION COMPLETA Y DETALLADA DE LLEGADA
                                    </th>
                                </tr>
                                <tr>

                                    <td>


                                        <?php

                                        if (!$es_transferencia) {
                                            echo '<select class="form-select"  id="UbigeoLlegada" name="UbigeoLlegada" required>
                                      <option value="">--BUSCAR UBIGEO--</option>';

                                            $sql = "SELECT ubigeo1,dpto,prov,distrito FROM ubigeo ";
                                            $result = mysqli_query($conexion, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ubigeo1 = $row["ubigeo1"];
                                                $dpto = $row["dpto"];
                                                $prov = $row["prov"];
                                                $distrito = $row["distrito"];

                                                $nombreCompleto1 = $dpto . ' - ' . $prov . ' - ' . $distrito;

                                                echo '<option value="' . $ubigeo1 . '"  class="Estilodany">' . $nombreCompleto1 . '</option>';
                                            }

                                            echo '</select>';
                                        } else {
                                            echo '<select class="form-select"  id="UbigeoLlegada" name="UbigeoLlegada" required>';


                                            $sql = "SELECT ubigeo, departamento, provincia, distrito,direccion FROM movmae 
                                    INNER JOIN ticket ON movmae.sucursal1 = ticket.sucursal
                                    WHERE tipmov=2 and tipdoc=3 and invnum = '$invnum'";
                                            $result = mysqli_query($conexion, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ubigeo1 = $row["ubigeo"];
                                                $dpto = $row["departamento"];
                                                $prov = $row["provincia"];
                                                $distrito = $row["distrito"];
                                                $direccionLlegada = $row["direccion"];

                                                $nombreCompleto1 = $dpto . ' - ' . $prov . ' - ' . $distrito;

                                                echo '<option selected value="' . $ubigeo1 . '"  class="Estilodany">' . $nombreCompleto1 . '</option>';
                                            }

                                            echo '</select>';
                                        }
                                        ?>



                                    </td>
                                    <?php

                                    if (!$es_transferencia) { ?>
                                        <td>
                                            <input class='form-control' id="direccionDeLlegada" name="direccionDeLlegada" type="text" value="<?= $Ubigeodireccion ?>" size="130" placeholder="Ejemplo:CAR. MALGINAL SATIPO MAZAMARI KM. 4.8" onkeyup="this.value = this.value.toUpperCase();" required />
                                        </td>
                                    <?php    } else {  ?>


                                        <td>
                                            <input class='form-control' id="direccionDeLlegada" name="direccionDeLlegada" type="text" value="<?= $direccionLlegada ?>" size="130" placeholder="Ejemplo:CAR. MALGINAL SATIPO MAZAMARI KM. 4.8" onkeyup="this.value = this.value.toUpperCase();" required />
                                        </td>

                                    <?php } ?>

                                </tr>
                            </table>
                        </fieldset>
                    </td>

                </tr>

                <fieldset class="border p-2">
                    <legend style="color:#000000;font-size:15px;" class="float-none w-auto p-2"> <strong>BIENES A TRANSPORTAR</strong></legend>

                    <?php

                    $sql = "$select WHERE invnum='$invnum'";

                    echo '<script>alert("' . $select . '")</script>';

                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                    ?>
                        <table class="table_cabe" width="100%" style="width:99%; background-color: #FDFD96; border-color: white;" border="1" id="customers" class="table table-bordered">
                            <tr style="width:99%;background-color: #2e91d2;">
                                <th>
                                    CODIGO
                                </th>
                                <th>
                                    CANTIDAD
                                </th>

                                <th>
                                    DESCRIPCION
                                </th>

                                <?php if ($drogueria == 1){ ?>
                                    <th>
                                    LOTE
                                </th>

                                <th>
                                    FECHA VENCIM.
                                </th>

                                <?php   } ?>
                                

                                
                                <th>
                                    TIPO DE AFECTACION
                                </th>
                                <th>
                                    PRECIO
                                </th>
                                <th>
                                    SUB TOTAL
                                </th>
                                <th>
                                    TOTAL
                                </th>
                            </tr>




                            <?php while ($row = mysqli_fetch_array($result)) {
                                $codigo        = $row['codigo'];
                                $cantidad      = $row['cantidad'];
                                $descripcion   = $row['descripcion'];
                                $precio        = $row['precio'];
                                $subTotal      = $row['subTotal'];


                            ?>

                            

                                <?php if ($tipoBusqueda  == 1) {  ?>

                                    <?php $mensajeTipo = "Venta"; ?>

                                <?php   } else { ?>

                                    <?php $mensajeTipo = "Transferencia"; ?>

                                <?php    } ?>


                                <?php 

$vencimnnn = "";
$numlote = "";
$sql1_movlote = "SELECT numlote,vencim FROM movlote where codpro = '$codigo'  and codloc= '$codloc'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
$result1_movlote = mysqli_query($conexion, $sql1_movlote);
if (mysqli_num_rows($result1_movlote)) {
    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
        $numlote = $row1_movlote['numlote'];
        $vencimnnn = $row1_movlote['vencim'];
    }
}




?>




                                <tr>
                                    <td>
                                        <?php echo $codigo; ?>
                                    </td>
                                    <td>
                                        <?php echo $cantidad; ?>
                                    </td>
                                    <td>
                                        <?php echo $descripcion; ?>
                                    </td>
                                    <?php if ($drogueria == 1){ ?>

                                        <td>
                                        <?php echo $numlote; ?>
                                    </td>
                                    <td>
                                        <?php echo $vencimnnn; ?>
                                    </td>

                                    
                                <?php   } ?>
                                        
                                    <td>
                                        <?php echo $mensajeTipo; ?>
                                    </td>
                                    <td>
                                        <?php echo $precio; ?>
                                    </td>
                                    <td>
                                        <?php echo $subTotal; ?>
                                    </td>
                                    <td>
                                        <?php echo $subTotal; ?>
                                    </td>

                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                </fieldset>

            </table>
            <br>
            <br>
            <br>
        </form>




    <?php } else {
    ?>
        <br><br><br><br>
        <br><br><br><br>
        <br><br><br><br>
        <div align="center" style="margin-top: 150px;">
            <h3 class='Estilo2'>
                SELECCIONE UN TIPO DE BUSQUEDA E INGRESE NUMERO DOCUMENTO A BUSCAR
            </h3>
        </div>
    <?php // } //CIERRO EL VALID
    } //CIERRO EL VAL
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.select2').select2();
    // $('#tipoBusqueda').select2();
</script>