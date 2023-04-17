<?php
include('../session_user.php');
include('ajax/funciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="../reportes/css/style.css" rel="stylesheet" type="text/css" />
        <link href="../reportes/css/tablas.css" rel="stylesheet" type="text/css" />
        <link href="../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
        <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
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
            <?php //require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
            ?>
            <?php require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
            ?>
            <?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES
            ?>
            <script type="text/javascript" src="../../funciones/ajax.js"></script>
            <script type="text/javascript" src="../../funciones/ajax-dynamic-list1.js"></script>
            <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
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

    <body onload="st();">
        <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css' />
        <table width="100%" border="0">
            <tr>
                <td>
                    <b>ENVIO DE NOTAS DE CREDITO A SUNAT</b>
                    <br/>
                    <form id="form1" name="form1" method="post">
                        <br/>
                        <table class="rodrigo-table-form">
                            <tr>
                                <td valign="top" >Fecha</td>
                                <td valign="top" ><input type="date" id="date" value="<?= $date ?>"></td>
                                <td valign="top" >Sucursal</td>
                                <td valign="top" >
                                    <select id="sucursal">
                                        <?php
                                        $sql = mysqli_query($conexion, "SELECT linea1, linea7, sucursal, sucursal_codigo, sucursal_ruc FROM ticket ORDER BY sucursal_ruc, sucursal_codigo");
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
                                <td valign="top" >
                                    <button type="button" 
                                            id="sunat-enviar" 
                                            onclick="consultar_docs();">
                                        Mostrar Notas de Credito
                                    </button>
                                </td>
                                <td valign="top" colspan="2">
                                    <button type="button" id="sunat-enviar-masa">
                                        Declarar Todas las NC
                                    </button>
                                </td>
<!--                                <td>
                                    <button type="button" onclick="limpiar_enviados();" id="limpiar-enviados">
                                        Limpiar enviados
                                    </button>
                                </td>-->
<!--                                <td valign="top">
                                    <select id="typesummary" name="typesummary">
                                        <option value="notasboleta">3-Nota de Credito de Boletas</option>
                                        <option value="anullnotasboleta">4-Anulacion Nota de Credito de Boletas</option>
                                    </select>
                                    <br/>
                                    <button type="button" id="sunat-summary">
                                        Enviar Resumen de NC
                                    </button>
                                </td>-->
                                <td valign="top">
                                    <button type="button" onclick="salir()">
                                        Salir
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <table class="rodrigo-table-data" border="1px">
                            <thead>
                                <tr>
                                    <th>Total Comprobantes: <span id="cpe-total">0</span></th>
                                    <th style="color:blue">Total Enviados: <span id="cpe-sent">0</span></th>
                                    <th style="color:red">Total Pendientes: <span id="cpe-pending">0</span></th>
                                </tr>
                            </thead>
                        </table>
                        <br/>
                        <table class="rodrigo-table-data" border="1px" id="sunat-table">
                            <thead>
                                <tr>
                                    <th width="85px">Nota</th>
                                    <th width="65px">Emitido</th>
                                    <th>Motivo</th>
                                    <th width="85px">Afectado</th>
                                    <th width="75px">RUC/DNI</th>
                                    <th>Cliente</th>
                                    <th width="65px">Total</th>
                                    <th width="65px">Enviado</th>
                                    <th>Codigo</th>
                                    <th>Respuesta</th>
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
        <?php if ($val == 1) {
            ?>
            <iframe src="stock_loc2.php?val=<?php echo $val ?>&country=<?php echo $country ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>" name="marco" id="marco" width="958" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
            </iframe>
        <?php }
        ?>
    </body>

</html>

<style type="text/css">
    .enviado {
        color: #A4A4A4;
    }
</style>

<script type="text/javascript">
    var delay = 0;
    var cpes = 0;

    $('#sunat-enviar-masa').on('click', function (e) {
        var date = $('#date').val();
        var sucursal = $('#sucursal').val();
        if (date.length > 0 && sucursal.length > 0) {
            $.ajax({
                type: 'POST',
                url: 'ApiFacturacion/controlador/controlador.php',
                data: {
                    action: 'GUARDAR_NC_MASIVO',
                    date: date,
                    sucursal: sucursal
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $('#sunat-enviar').attr('disabled', 'disabled');
                    $('#sunat-enviar-masa').val('Enviando...');
                    $('#sunat-enviar-masa').attr('disabled', 'disabled');
                    $('.btn-envio').attr('disabled', 'disabled');
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function (response) {
                    location.href = '?date=' + date + '&sucursal=' + sucursal;
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                location.href = '?date=' + date + '&sucursal=' + sucursal;
            });
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
                        action: 'ENVIO_RESUMEN_NC',
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

    /**
     * 
     
     * @param {type} id
     * @returns {undefined}     */
    function enviar_documento_sunat(id) {
        var date = $('#date').val();
        var sucursal = $('#sucursal').val();
        $.ajax({
            type: 'POST',
            url: 'ApiFacturacion/controlador/controlador.php',
            data: {
                action: 'GUARDAR_NC',
                id: id
            },
            dataType: 'JSON',
            beforeSend: function () {
                $('.btn-envio').attr('disabled', 'disabled');
                $('#sunat-enviar').attr('disabled', 'disabled');
            },
            success: function (json) {
                location.href = '?date=' + date + '&sucursal=' + sucursal;
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('.btn-envio').removeAttr('disabled');
            $('#sunat-enviar').removeAttr('disabled');
            //console.log(jqXHR);
            location.href = '?date=' + date + '&sucursal=' + sucursal;
        });
    }


    function enviar_documento_sunat_masa(id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/ajax_envio.php',
            data: {
                action: 'crear_json_nc',
                id: id
            },
            dataType: 'JSON',
            success: function (json) {
                enviar_api_nota_credito(id, json);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        });
    }

    function consultar_docs() {
        cpes = 0;
        var date = $('#date').val();
        var sucursal = $('#sucursal').val();
        if (date.length > 0 && sucursal.length > 0) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajax_envio.php',
                data: {
                    action: 'consultar_nc',
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
                    action: 'limpiar_enviados_nc',
                    date: date,
                    sucursal: sucursal
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $('#limpiar-enviados').attr('disabled', 'disabled');
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function (response) {
                    /*$('#limpiar-enviados').removeAttr('disabled');
                     $('#sunat-table tbody').html(response.data);*/
                    window.location.href = '?date=' + date + '&sucursal=' + sucursal;
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            });
        } else {
            alert('Seleccione los rangos de fecha y la sucursal.');
        }
    }

    function enviar_api_nota_credito(id, json) {
        var api = '../../greenter/examples/nota-credito.php';
        $.ajax({
            type: 'POST',
            url: api,
            data: {
                action: 'enviar_nota_credito',
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
                action: 'actualizar_nc',
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
            if (confirm('Esta apunto de generar una comunicacion de baja para enviar a SUNAT, 多Desea continuar?')) {
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
                                enviar_api_resumen(response.data, date, sucursal);
                            } else {
                                alert('No se encontro ningun documento anulado para comunicar.');
                                $('#sunat-resumen').removeAttr('disabled');
                                $('#sunat-resumen').removeClass('enviado');
                                $('.loading').remove();
                            }
                        } else {
                            $('#sunat-resumen').removeAttr('disabled');
                            $('#sunat-resumen').removeClass('enviado');
                            alert('Algunas boletas de la fecha seleccionada, no fueron enviados a SUNAT, verifique para generar el resumen correctamente. Gracias.');
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

    function enviar_api_resumen(json, date, sucursal) {
        var api = '../../greenter/examples/comunicacion-baja.php';
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
                guardar_resumen(enviado, code, description, hash, json, ticket, date, sucursal, 'FACTURA');
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#sunat-resumen').removeAttr('disabled');
            $('#sunat-resumen').removeClass('enviado');
            console.log(jqXHR);
        });
    }

    function enviar_api_resumen_boletas(json, date, sucursal) {
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
                guardar_resumen(enviado, code, description, hash, json, ticket, date, sucursal, 'BOLETA', true);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#sunat-resumen').removeAttr('disabled');
            $('#sunat-resumen').removeClass('enviado');
            console.log(jqXHR);
        });
    }

    function guardar_resumen(enviado, code, description, hash, json, ticket, date, sucursal, type, final = false) {
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
            success: function (response) {
                var items_factura = parseInt(json.items_factura.length);
                var items_boleta = parseInt(json.items_boleta.length);
                var items_total = items_factura + items_boleta;
                if (final == false) {
                    enviar_api_resumen_boletas(json, date, sucursal);
                } else {
                    alert('Se comunicaron ' + items_total + ' documentos para baja.');
                    window.location.href = '?date=' + date + '&sucursal=' + sucursal;
                }
            }
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