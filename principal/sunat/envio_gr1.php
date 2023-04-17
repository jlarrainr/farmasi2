<?php
include('../session_user.php');
include('ajax/funciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="../reportes/css/style.css" rel="stylesheet" type="text/css" />
        <link href="../reportes/css/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
        <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
        <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
        <script type="text/javascript">
            window.addEvent('domready', function () {
                myCal = new Calendar({
                    date1: 'Y-m-d'
                });
                myCal = new Calendar({
                    date2: 'Y-m-d'
                });
            });
        </script>
        <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
        ?>
        <?php require_once("../../funciones/calendar.php"); ?>
        <?php // require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
        ?>
        <?php require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
        ?>
        <?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES
        ?>
        <script type="text/javascript" src="../../funciones/ajax.js"></script>
        <script type="text/javascript" src="../../funciones/ajax-dynamic-list1.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript">
            function salir() {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                f.action = "../index.php";
                f.submit();
            }
        </script>

    </head>
    <?php
//$hour   = date(G);
//$date = CalculaFechaHora($hour);
    $date = date("Y-m-d");
    $val = $_REQUEST['val'];
    $country = $_REQUEST['country'];
    $report = $_REQUEST['report'];
    $sql = "SELECT export FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
        }
    }
////////////////////////////
    $registros = 40;
    $pagina = $_REQUEST["pagina"];
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $registros;
    }
    ?>
    <script language="javascript" type="text/javascript">
        function st() {
            var f = document.form1;
            f.country.focus();
        }
    </script>
    <?php
    if (isset($_GET['date']) and isset($_GET['sucursal'])) {
        $date = $_GET['date'];
        $sucursal = $_GET['sucursal'];
        $run = 1;
    } else {
        $date = date('Y-m-d');
        $sucursal = 0;
        $run = 0;
    }
    ?>

    <style type="text/css">
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
            background-image: url('ajax/loading.gif');
            background-size: 60px 60px;
            top: 50%;
            left: 50%;
            width: 60px;
            height: 60px;
            margin-top: -30px;
            margin-left: -30px;
        }
    </style>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css' />

    <body onload="st();">
        <table width="100%" border="0">
            <tr>
                <td>
                    <b>ENVIO DE GUIAS DE REMISION A SUNAT</b>
                    <br/>
                    <form id="form1" name="form1" method="post">
                        <br/>
                        <table class="rodrigo-table-form" border="0" width="100%">
                            <tr>
                                <td valign="top" width='40px'>Fecha</td>
                                <td valign="top" width='100px'><input type="date" id="date" value="<?= $date ?>"></td>
                                <td valign="top" width='50px'>Sucursal</td>
                                <td valign="top"  width='100px'>
                                    <select id="sucursal">
                                        <?php
                                        $sql = mysqli_query($conexion, "SELECT linea1, linea7, sucursal, sucursal_codigo, sucursal_ruc FROM ticket WHERE LENGTH(linea7) > 0 ORDER BY sucursal_ruc, sucursal_codigo");
                                        while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                                            if ($sucursal == $key['sucursal']) {
                                                echo '<option value="' . $key['sucursal'] . '" selected>' . $key['sucursal_ruc'] . '-' . $key['linea7'] . '-' . $key['linea1'] . '</option>';
                                            } else {
                                                echo '<option value="' . $key['sucursal'] . '">' . $key['sucursal_ruc'] . '-' . $key['linea7'] . '-' . $key['linea1'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                             
                              
                                
                                <td valign='top' width='50px'><input type="button" value="Mostrar Comprobantes" id="sunat-enviar" onclick="consultar_docs();" class="nuevo"></td>
                               
                                <td valign='top' width='50px'><input type="button" value="Enviar en Masa" id="sunat-enviar-masa" class="grabarventa"></td>
                                 
                                <td valign='top' width='50px'><input type="button" value="Limpiar Enviados" onclick="limpiar_enviados();" id="limpiar-enviados" class="imprimir"></td> 
                                
                                
                                
                              <!--    <td valign='top' width='70px' >
                                    <select id="typesummary" name="typesummary">
                                        <option value="boleta">1-Boletas de Venta</option>
                                        <option value="anullboleta">2-Anulacion de Boletas de Venta</option>
                                        <option value="anullfactura">5-Comunicacion de Baja Factura</option>
                                        <!--                                        <option value="anullncfactura">Comunicación Baja de Notas de Facturas</option>-->
                                   <!--    </select>-->
                                  
                     <!--  
                                </td>
                                
                                <td valign='top' width='50px'><input type="button" value="Enviar Resumen" id="sunat-summary" class="consultar"></td> -->
                                
                          <td><input type="button" value="Salir" onclick="salir()" class="salir"></td>
                            </tr>
                            <tr>
                                <td colspan="9" style="color:red">
                                   <!--     <b>NOTA: </b>Una vez enviado todos los comprobantes,.-->
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <table class="rodrigo-table-data" border="1px" id="sunat-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><span id="cpe-total">0</span> comprobantes</th>
                                    <th style="color:#67a650; text-align:center;"><span id="cpe-sent">0</span> enviados</th>
                                    <th style="color:blue; text-align:center;"><span id="cpe-anulados">0</span> bajas</th>
                                    <th style="color:red; text-align:center;"><span id="cpe-pending">0</span> pendientes</th>
                                </tr>
                            </thead>
                        </table>
                        <br/>
                        <table class="rodrigo-table-data" border="1px" 
                               style="border-collapse:collapse;" id="sunat-table">
                            <thead>
                                <tr>
                                    <th width="92px">Tipo</th>
                                    <th width="89px">Serie</th>
                                   <th width="110px">Fecha de Emisión</th>
                                    <th width="75px">RUC/DNI</th>
                                    <th width="180px">Cliente</th>
                                    
                                    <th width="65px">Total</th>
                                    <th width="110px">Inicio de Traslado</th>
                                    <th width="65px">Enviado</th>
                                    <th width="65px">Codigo</th>
                                    <th>Respuesta Sunat</th>
<!--                                    <th width="65px">Anulado Sistema</th>-->
                                                                    
                                    <th width="50px">Opcion</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <br/>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        <?php if ($val == 1) : ?>
            <iframe src="stock_loc2.php?val=<?php echo $val ?>&country=<?php echo $country ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>" name="marco" id="marco" width="958" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
            </iframe>
        <?php endif; ?>
        <style type="text/css">
            .enviado {
                color: #A4A4A4;
            }
        </style>

        <script type="text/javascript">
            var delay = 0;
            var cpes = 0;

            //ENVIO MASIVO DE FACTURAS
            $('#sunat-enviar-masa').on('click', function (e) {
                var date = $('#date').val();
                var sucursal = $('#sucursal').val();

                if (date.length > 0 && sucursal.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'ApiFacturacion/controlador/controlador.php',
                        data: {
                            action: 'GUARDAR_VENTA_MASIVO',
                            date: date,
                            sucursal: sucursal,
                            typesummary: $("#option_summary").val()
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                            $('#sunat-enviar').attr('disabled', 'disabled');
                            $('#sunat-enviar-masa').val('Enviando...');
                            $('#sunat-enviar-masa').attr('disabled', 'disabled');
                            $('.btn-envio').attr('disabled', 'disabled');
                            $(document.body).append('<span class="loading"><div></div></span>');
                        },
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        location.href = '?date=' + date + '&sucursal=' + sucursal;
                    })
                    setTimeout(function () {
                        // enviar_documento_sunat_masa(value.id, value.type);
                        cpes--;
                        if (cpes == 0) {
                            delay = 0;
                            setTimeout(function () {
                                alert('Ya culmino el envio en masa, ahora verifique que todos los documentos fueron enviados correctamente para proceder a comunicar la baja de documentos anulados en el sistema.');
                                window.location.href = '?date=' + date + '&sucursal=' + sucursal;
                            }, delay += 1800);
                        }
                    }, delay += 1800);
                } else {
                    alert('Seleccione los rangos de fecha y la sucursal.');
                }
            });

            //ROMMEL MERCADO
            //GENERAR RESUMEN
            $('#sunat-summary').on('click', function () {
                var date = $('#date').val();
                var sucursal = $('#sucursal').val();
                if (date.length > 0 && sucursal.length > 0) {
                    if (confirm('Enviar Resumen, Desea continuar?')) {
                        $.ajax({
                            type: 'POST',
                            url: 'ApiFacturacion/controlador/controlador.php',
                            data: {
                                action: 'ENVIO_RESUMEN',
                                date: date,
                                sucursal: sucursal,
                                typesummary: $("#typesummary").val()
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                                $('#sunat-resumen').attr('disabled', 'disabled');
                                $('#sunat-resumen').addClass('enviado');
                                $(document.body).append('<span class="loading"><div></div></span>');
                            },
                            success: function (response) {
                                console.log(response)
                                $('#sunat-resumen').removeAttr('disabled');
                                $('#sunat-resumen').removeClass('enviado');
                                $('.loading').remove();
                                location.href = '?date=' + date + '&sucursal=' + sucursal;
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            $('#sunat-resumen').removeAttr('disabled');
                            $('#sunat-resumen').removeClass('enviado');
                            $('.loading').remove();
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                            location.href = '?date=' + date + '&sucursal=' + sucursal;
                        });
                    } else {
                        return false;
                    }
                } else {
                    alert('Seleccione la fecha de generacion y sucursal.');
                }
            });


         function consultar_docs() {
        cpes = 0;
        var date = $('#date').val();
        var sucursal = $('#sucursal').val();
        
        
        
        
        if (date.length > 0 && sucursal.length > 0) {
            
            
    
            
            $.ajax({
                type: 'POST',
                url: 'ajax/ajax_consulta.php',
                data: {
                    action: 'consultar_gr',
                    date: date,
                    sucursal: sucursal
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function (response) {
                    $('#sunat-table tbody').html(response.data);
                    $('#cpe-total').html(response.total);
                    $('#cpe-sent').html(response.sent);
                    $('#cpe-pending').html(response.pending);
                    cpes = parseInt(response.pending);
                    $('.loading').remove();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            });
        } else {
            alert('Seleccione los rangos de fecha y la sucursal.');
        }
    }
            function limpiar_enviados() {
                var date = $('#date').val();
                var sucursal = $('#sucursal').val();
                if (date.length > 0 && sucursal.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/ajax_envio.php',
                        data: {
                            action: 'limpiar_enviados',
                            date: date,
                            sucursal: sucursal
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                            $('#limpiar-enviados').attr('disabled', 'disabled');
                            $(document.body).append('<span class="loading"><div></div></span>');
                        },
                        success: function (response) {
                            $('#limpiar-enviados').removeAttr('disabled');
                            $('#sunat-table tbody').html(response.data);
                            window.location.href = '?date=' + date + '&sucursal=' + sucursal;
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    });
                } else {
                    alert('Seleccione los rangos de fecha y la sucursal.');
                }
            }

            function enviar_documento_sunat(id, TYPE) {
                $.ajax({
                    type: 'POST',
                    url: 'ApiFacturacion/controlador/controlador.php',
                    data: {
                        action: 'GUARDAR_GUIA',
                        id: id
                    },
                    success: async function (data) {
                         console.log(data);
                        //await $('.btn-envio').attr('disabled', 'disabled');
                        //await $('#sunat-enviar').attr('disabled', 'disabled');
                        await consultar_docs()
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('.btn-envio').removeAttr('disabled');
                    $('#sunat-enviar').removeAttr('disabled');
                    // console.log(jqXHR);
                });
            }

            function enviar_documento_sunat_masa(id, type) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajax_envio.php',
                    data: {
                        action: 'crear_json',
                        id: id
                    },
                    dataType: 'JSON',
                    success: function (json) {
                        if (type == 'F') {
                            enviar_api_factura(id, json);
                        } else if (type == 'B') {
                            enviar_api_boleta(id, json);
                        }
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                });
            }

            function enviar_api_factura(id, json) {
                var api = '../../greenter/examples/factura.php';
                $.ajax({
                    type: 'POST',
                    url: api,
                    data: {
                        json: JSON.stringify(json)
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status != undefined && response.status == 'OK') {
                            var code = response.code;
                            var description = response.description;
                            var hash = response.hash;
                            var enviado = 1;
                        } else {
                            var code = response.code;
                            var description = response.description;
                            var hash = '';
                            var enviado = 0;
                        }
                        actualizar_documento(id, enviado, code, description, hash);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('.btn-envio').removeAttr('disabled');
                    $('#sunat-enviar').removeAttr('disabled');
                    console.log(jqXHR);
                });
            }

            function enviar_api_boleta(id, json) {
                var api = '../../greenter/examples/boleta.php';
                $.ajax({
                    type: 'POST',
                    url: api,
                    data: {
                        json: JSON.stringify(json)
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status != undefined && response.status == 'OK') {
                            var code = response.code;
                            var description = response.description;
                            var hash = response.hash;
                            var enviado = 1;
                        } else {
                            var code = response.code;
                            var description = response.description;
                            var hash = '';
                            var enviado = 0;
                        }
                        actualizar_documento(id, enviado, code, description, hash);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('.btn-envio').removeAttr('disabled');
                    $('#sunat-enviar').removeAttr('disabled');
                    console.log(jqXHR);
                });
            }

            function actualizar_documento(id, enviado, code, description, hash) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajax_envio.php',
                    data: {
                        action: 'actualizar',
                        id: id,
                        enviado: enviado,
                        code: code,
                        description: description,
                        hash: hash
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        $('.btn-envio').removeAttr('disabled');
                        $('#sunat-enviar').removeAttr('disabled');
                        $('#row-' + id).replaceWith(response.data);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('.btn-envio').removeAttr('disabled');
                    $('#sunat-enviar').removeAttr('disabled');
                    console.log(jqXHR);
                });
            }

            //COMUNICACION DE BAJA
            $('#sunat-resumen').on('click', function () {
                var date = $('#date').val();
                var sucursal = $('#sucursal').val();
                if (date.length > 0 && sucursal.length > 0) {
                    if (confirm('Esta apunto de generar una comunicacion de baja para enviar a SUNA. Â¿Desea continuar?')) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/ajax_generar.php',
                            data: {
                                action: 'resumen',
                                date: date,
                                sucursal: sucursal
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                                $('#sunat-resumen').attr('disabled', 'disabled');
                                $('#sunat-resumen').addClass('enviado');
                                $(document.body).append('<span class="loading"><div></div></span>');
                            },
                            success: function (response) {

                                if (response.status == 'OK') {

                                    if (response.data.items_boleta.length > 0 || response.data.items_factura.length > 0) {
                                        if (response.data.items_boleta.length > 0) {
                                            console.log('boletaaaaa');
                                            enviar_api_resumen('2', date, sucursal);
                                        }
                                        if (response.data.items_factura.length > 0) {
                                            console.log('Factura');
                                            // enviar_api_resumen_boletas('1', date, sucursal);
                                            enviar_api_resumen('1', date, sucursal);
                                        }
                                        setTimeout(function () {
                                            var items_factura = parseInt(response.data.items_factura.length);
                                            var items_boleta = parseInt(response.data.items_boleta.length);
                                            alert('Se comunicaron ' + items_factura + ' facturas y ' + items_boleta + ' boletas para darlos de baja.');
                                            window.location.href = '?date=' + date + '&sucursal=' + sucursal;
                                        }, 4000);
                                    } else {
                                        alert('No se encontro ningun documento anulado para comunicar.');
                                        $('#sunat-resumen').removeAttr('disabled');
                                        $('#sunat-resumen').removeClass('enviado');
                                        $('.loading').remove();
                                    }
                                } else {
                                    $('#sunat-resumen').removeAttr('disabled');
                                    $('#sunat-resumen').removeClass('enviado');
                                    alert('Algunas boletas de la fecha seleccionada no fueron enviadas a SUNAT, verifique para generar el resumen correctamente. Gracias.');
                                    $('.loading').remove();
                                }
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            $('#sunat-resumen').removeAttr('disabled');
                            $('#sunat-resumen').removeClass('enviado');
                            $('.loading').remove();
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        });
                    } else {
                        return false;
                    }
                } else {
                    alert('Seleccione la fecha de generacion y sucursal.');
                }
            });

            function enviar_api_resumen(tipo, date, sucursal) {
                $.ajax({
                    type: 'POST',
                    url: 'ApiFacturacion/controlador/controlador.php',
                    data: {
                        action: 'ENVIO_BAJAS_BOLETA',
                        tipo: tipo,
                        date: date,
                        sucursal: sucursal
                    },
                    dataType: 'JSON',
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('#sunat-resumen').removeAttr('disabled');
                    $('#sunat-resumen').removeClass('enviado');
                    console.log(jqXHR);
                });
            }



            function enviar_api_resumen_boletas(tipo, date, sucursal) {
                var api = '../../greenter/examples/resumen.php';
                $.ajax({
                    type: 'POST',
                    url: api,
                    data: {
                        json: JSON.stringify(json)
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status != undefined && response.status == 'OK') {
                            var code = response.code;
                            var description = response.description;
                            var hash = response.hash;
                            var ticket = response.ticket;
                            var enviado = 1;
                        } else {
                            var code = response.code;
                            var description = response.description;
                            var hash = '';
                            var ticket = '';
                            var enviado = 0;
                        }
                        guardar_resumen(enviado, code, description, hash, json, ticket, date, sucursal, 'BOLETA');
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('#sunat-resumen').removeAttr('disabled');
                    $('#sunat-resumen').removeClass('enviado');
                    console.log(jqXHR);
                });
            }

            function guardar_resumen(enviado, code, description, hash, json, ticket, date, sucursal, type) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajax_generar.php',
                    data: {
                        action: 'guardar_resumen',
                        enviado: enviado,
                        code: code,
                        description: description,
                        hash: hash,
                        ticket: ticket,
                        type: type,
                        json: JSON.stringify(json)
                    },
                    dataType: 'JSON',
                    success: function (response) {}
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('#sunat-resumen').removeAttr('disabled');
                    $('#sunat-resumen').removeClass('enviado');
                    console.log(jqXHR);
                });
            }
        </script>

        <?php
        if ($run > 0) {
            echo '<script>consultar_docs();</script>';
        }
        ?>
    </body>
</html>
