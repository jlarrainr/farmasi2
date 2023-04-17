<?php
include('../../session_user.php');
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/select_cli.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../archivo/js/jquery.min.js"></script>
    <?php
    require_once("funciones/mov_proveedor.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../local.php"); //LOCAL DEL USUARIO
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $pag = $_REQUEST['pageno'];
    $ultimo = $_REQUEST['ultimo'];
    $close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";
    if (isset($_REQUEST['pageno'])) {
        $pageno = $_REQUEST['pageno'];
    } else {
        $pageno = 1;
    }
    $sql = "SELECT count(*) FROM proveedor";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numrows = $row[0];
        }
    }
    $busqueda2 = $_REQUEST['country_ID2'];
    $busqueda = $_REQUEST['country_ID'];
    $search = $_REQUEST['search'];  ////1 ACTIVO
    $word = $_REQUEST['word'];   ////PALABRA BUSCADA
    if ($search == "") {
        $search = 0;
        $busqueda = "";
    }
    /////SELECCIONO EL ULTIMO CODIGO
    $sql = "SELECT codpro FROM proveedor order by codpro desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $fincod = $row[0];
        }
    } else {
        $fincod = 0;
    }
    
            $sql_token = "SELECT token FROM datagen  ";
    $result_token = mysqli_query($conexion, $sql_token);
    if (mysqli_num_rows($result_token)) {
        while ($row_token = mysqli_fetch_array($result_token)) {
            $token = $row_token["token"];
        }
    }
    
    /////////////////////////////////
    $rows_per_page = 1;
    $lastpage = ceil($numrows / $rows_per_page);
    $pageno = (int) $pageno;
    if ($ultimo == 1) {
        $pageno = $lastpage;
    }
    if ($pageno > $lastpage) {
        $pageno = $lastpage;
    } // if
    if ($pageno < 1) {
        $pageno = 1;
    } // if
    $limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;
    if ($search == 1) {
        $sql = "SELECT codpro,despro,dirpro,dispro,dptpro,propro,telpro,contac,rucpro,email,pagweb,tipcli,lcredito,representante,nextel,mail FROM proveedor where codpro = '$busqueda'";
    } else {
        $sql = "SELECT codpro,despro,dirpro,dispro,dptpro,propro,telpro,contac,rucpro,email,pagweb,tipcli,lcredito,representante,nextel,mail FROM proveedor $limit";
    }
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row["codpro"]; //codgio
            $despro = $row["despro"];  //nombre
            $dirpro = $row["dirpro"];  //direccion
            $dispro = $row["dispro"];  //distrito
            $dptpro = $row["dptpro"];  //departamento
            $propro = $row["propro"];  //provincia
            $telpro = $row["telpro"];  //telefono
            $contac = $row["contac"];  //propietario
            $rucpro = $row["rucpro"];  //ruc
            $email = $row["email"];  //email
            $pagweb = $row["pagweb"];  //pagina web
            $tipcli = $row["tipcli"];  //tipo de empresa, proveedor
            $lcredito = $row["lcredito"];  //tipo de empresa, proveedor
            $representante = $row["representante"];  //tipo de empresa, proveedor
            $nextel = $row["nextel"];  //tipo de empresa, proveedor
            $mail = $row["mail"];  //tipo de empresa, proveedor
        }
    } else {
        $codpro = 1;
    }
    ?>
    <?php
    require_once("funciones/call_combo.php"); //LLAMA A generaSelect
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="comercial/funciones/control.js"></script>
    <!--<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/stmenu.js"></script>-->
    <script type="text/javascript">
        function cerrar_popup() {
            //                document.form1.target = "venta_principal";
            window.opener.location.href = "busca_prov/salir.php?proveedor=<?php echo $busqueda2 ?>";
            self.close();
        }
    </script>
    <style>
        .boton_personalizado_RUC {
            text-decoration: none;
            padding: 2px;
            font-weight: 600;
            font-size: 11px;
            color: #bf0909;
            background-color: #f8f8f8;
            border-radius: 6px;
            border: 1px solid #bf0909;
        }

        .boton_personalizado_RUC:hover {
            color: #ffffff;
            background-color: #bf0909;
        }

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
            background-color: #e9e8eb;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }
    </style>
</head>

<body <?php if ($close == 1) { ?> onLoad="cerrar_popup();" <?php } else { ?> onLoad="sf();" <?php } ?>>
    <?php

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }
    ?>
    <div class="tabla1">
        <!--<script type="text/javascript" language="JavaScript1.2" src="../../menu_block/men.js"></script>-->
        <script type="text/javascript" src="../../archivo/funciones/select_3_niveles.js"></script>
        <div class="title">
            <span class="titulos">SISTEMA DE VENTAS - Mantenimiento de Proveedores
                <b>
                    <?php
                    $up = $_REQUEST['up'];
                    $del = $_REQUEST['del'];
                    $error = $_REQUEST['error'];
                    $ok = $_REQUEST['ok'];
                    if ($error == 2) {
                    ?>
                        <font color="#FF0000" size="-2">ERROR!</font>
                        <font color="#FFFF66" size="-2"> - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS.</font>
                    <?php
                    }
                    if ($ok == 1) {
                    ?>
                        <font color="#FFFF66" size="-2">- SE LOGRO GRABAR EXITOSAMENTE LOS DATOS</font>
                    <?php
                    }
                    if ($up == 1) {
                    ?>
                        <font color="#FFFF66" size="-2">- SE LOGRO ACTUALIZAR EL PROVEEDOR SELECCIONADO</font>
                    <?php
                    }
                    if ($del == 1) {
                    ?>
                        <font color="#FFFF66" size="-2">- SE LOGRO ELIMINAR EL PROVEEDOR INDICADO</font>
                    <?php }
                    ?>
                </b>
            </span>
        </div>


        <div class="mask1" style="height: auto;margin-bottom: 12px;">
            <div class="mask2" style="height: auto;margin-bottom: 12px;">
                <div class="mask3" style="height: auto;margin-bottom: 12px;">
                    <?php require('mov_proveedor1.php'); ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
     function busqueda() {

          try {
            Param = {

                documento: $("#ruc").val(),
                tipo_documento: 'RUC',
                origen: 1,
                op: 'consulta'

                // documento: 'RUC',
                //nro_documento: $("#ruc").val()
            };

            // Param.tipo = (Param.tipo_documento == 'DNI' ? 'D' : 'R');
            // Param.DNI_RUC = (Param.tipo_documento == 'DNI' ? true : false);

            // URLs = 'https://www.consultarucsunat.com/api_empresas.php';
            URLs = 'https://dniruc.apisperu.com/api/v1/ruc/' + $("#ruc").val() + '?token=' + $("#token").val();
            $.ajax({
                url: URLs,
                //data: Param,
                dataType: 'JSON',
                success: function(respuesta) {
                    response = respuesta;
                    $('#direccion').val(response.direccion);
                    $('#nom').val(response.razonSocial);
                    $('#tipo').val(response.tipo);
                    $('#estado').val(response.estado);
                    $('#condicion').val(response.condicion);
                    // $('#fono').val(response.Telefono);



                 /*   $("#departamento").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.departamento));
                    $("#provincia").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.provincia));
                    $("#distrito").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.distrito));*/

                },
                error: function() {
                    console.log("No se ha podido obtener la informaci璐竛");
                }
            });
        } catch (error) {
            console.log(error);
        }

    }
</script>