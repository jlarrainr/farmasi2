<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('../../session_user.php');
//echo $usuario;exit;
require_once('session_ventas.php');
//echo "hola";exit;
$venta = isset($_SESSION['venta']) ? $_SESSION['venta'] : '';
$cotizacion = isset($_SESSION['cotizacion']) ? $_SESSION['cotizacion'] : '';
$search = isset($_SESSION['search']) ? $_SESSION['search'] : '';
$cierre_caja = isset($_SESSION['cierrecaja']) ? $_SESSION['cierrecaja'] : '';
// $cierre_caja = $_REQUEST['cierrecaja'];
$sum33 = "";
$st = "";
$codigo_busk = "";
$z = "";
$add = "-1";
$typpe = "";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
    <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>

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

        #efecto1 {
            position: relative;
            background: #f3efed;
            width: 60%;
            height: 30px;
            border: none;
            outline: none;

            padding: 0 12px;
            border-radius: 25px 0 0 25px;
            /*border: 1px solid #6ec0f5;*/
        }

        #efecto2 {
            position: relative;
            left: -4px;
            margin-top: 8px;
            border-radius: 0 25px 25px 0;
            width: 10%;
            height: 30px;
            border: none;
            outline: none;
            font-weight: bolder;
            cursor: pointer;
            background: #3398db;
            color: #fff;
        }

        #efecto2:hover {
            background: #fcc154;
        }
    </style>
    <?php
    require_once('../../../conexion.php');
    require_once('../../../titulo_sist.php');
    require_once('../../../funciones/highlight.php');
    require_once('calcula_monto.php');
    require_once('funciones/ventas_index1.php');
    require_once('funciones/ventas_index2.php');
    require_once('../funciones/functions.php');
    require_once('../../../funciones/botones.php');
    //require_once('funciones/datos_generales.php');
    $fechaActual = date('Y-m-d');

    $sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
    $resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
    if (mysqli_num_rows($resultP_drogueria)) {
        while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
            $drogueria = $row_drogueria['drogueria'];
        }
    }
    if ($count == 0) {
        $sqlCli = "SELECT codcli FROM cliente where  descli like '%PUBLICO EN GENERAL%'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {

                $codcli = $row['codcli'];
            }
        }
       mysqli_query($conexion, "UPDATE venta set n_cotizacion = '0',cuscod='$codcli',codmed='0',forpag='E',numeroCuota='0',ventaDiasCuotas='0'   where invnum = '$venta'"); ///controla bonificaciones
    }
    $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
    $tipo = isset($_REQUEST['tipo']) ? ($_REQUEST['tipo']) : "";


    $sqlventa = "SELECT unidad_normal,ventaalcosto FROM datagen_det";
    $resultventa = mysqli_query($conexion, $sqlventa);
    if (mysqli_num_rows($resultventa)) {
        if ($rowventa = mysqli_fetch_array($resultventa)) {
            $unidad_normal = $rowventa['unidad_normal'];
            $ventaalcosto = $rowventa['ventaalcosto'];
        }
    }


    $sql = "SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $limite_busk = $row['limite'];

            // $priceditable = $row['priceditable'];
        }
    }
    $sqlP = "SELECT precios_por_local,masPrecioVenta FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
            $masPrecioVenta = $row['masPrecioVenta'];
        }
    }
    if ($precios_por_local  == 1) {
        require_once '../../../precios_por_local.php';
    }
    function limpia_espacios($cadena)
    {
        $cadena = str_replace(' ', '', $cadena);
        return $cadena;
    }

    function fecha($fechadata)
    {
        $fecha = explode("-", $fechadata);
        $dia = $fecha[2];
        $mes = $fecha[1];
        $year = $fecha[0];
        $fecharesult = $mes . '/' . $year;
        return $fecharesult;
    }

    // if ($resolucion == 1) {
    //     $charact = 40;
    //     $charactbonif = 10;
    // } else {
    $charact = 50;
    $charactbonif = 14;
    // }

    $sql1_impresion = "SELECT numlineas FROM impresion where numlineas <> '0'";
    $result1_impresion = mysqli_query($conexion, $sql1_impresion);
    if (mysqli_num_rows($result1_impresion)) {
        while ($row1_impresion = mysqli_fetch_array($result1_impresion)) {
            $numlineas = $row1_impresion['numlineas'];
        }
    }

    $sql1_LOCAL0 = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
    $result1_LOCAL0 = mysqli_query($conexion, $sql1_LOCAL0);
    if (mysqli_num_rows($result1_LOCAL0)) {
        while ($row1_LOCAL0 = mysqli_fetch_array($result1_LOCAL0)) {
            $localp = $row1_LOCAL0['codloc'];
        }
    }


    $sqlVenta = "SELECT sucursal,forpag,tipoOpcionPrecio FROM venta where invnum = '$venta'";
    $resultVenta = mysqli_query($conexion, $sqlVenta);
    if (mysqli_num_rows($resultVenta)) {
        while ($rowVenta = mysqli_fetch_array($resultVenta)) {
            $sucursal = $rowVenta['sucursal'];
            $forpag = $rowVenta['forpag'];
            $tipoOpcionPrecio = $rowVenta['tipoOpcionPrecio'];
        }
    }
    // echo 'forpag = ' . $forpag . "<br>";
    //**CONFIGPRECIOS_PRODUCTO**//
    $nomlocalG = "";
    $sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
    $resultLocal = mysqli_query($conexion, $sqlLocal);
    if (mysqli_num_rows($resultLocal)) {
        while ($rowLocal = mysqli_fetch_array($resultLocal)) {
            $nomlocalG = $rowLocal['nomloc'];
        }
    }


    $numero_xcompa = substr($nomlocalG, 5, 2);
    $tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);


    $TablaPrevtaMain = "prevta";
    $TablaPreuniMain = "preuni";
    if ($nomlocalG <> "") {
        if ($nomlocalG == "LOCAL1") {
            $TablaPrevta = "prevta1";
            $TablaPreuni = "preuni1";
        } else {
            if ($nomlocalG == "LOCAL2") {
                $TablaPrevta = "prevta2";
                $TablaPreuni = "preuni2";
            } else {
                $TablaPrevta = "prevta";
                $TablaPreuni = "preuni";
            }
        }
    } else {
        $TablaPrevta = "prevta";
        $TablaPreuni = "preuni";
    }
    //**FIN_CONFIGPRECIOS_PRODUCTO**//

    if (($val == 1) and ($tipo == 2)) {
        $campo = "codpro";
        $operador_sql = "=";
        $limite_sql = "";
        if ($limite_busk > 0) {
            if ($search == "") {
                $producto = $_REQUEST['country_ID'];
                $sql = "SELECT codpro FROM producto where codpro = '$producto' and activo = '1' and eliminado='0'  ";
            } else {
                $producto = $_REQUEST['codigo_busk'];
                switch ($search) {
                    case 2:
                        $campo = "codfam";
                        break;
                    case 3:
                        $campo = "coduso";
                        break;
                    case 4:
                        $campo = "codmar";
                        break;
                    case 6:
                        $campo = "codpres";
                        break;
                }
            }
        } else {
            //$acc =	$_REQUEST['acc'];
            $CampoAdic = "";
            $acc = isset($_REQUEST['acc']) ? ($_REQUEST['acc']) : "";
            if ($acc == 1) {
                $producto = $_REQUEST['country_ID'];
                $sql = "SELECT codpro FROM producto where codpro = '$producto' and activo = '1' and eliminado='0' ";
            } else {
                $producto = $_REQUEST['country'] . "%";
                $campo = "desprod";
                $operador_sql = "like";
                $CampoAdic = "%";
                $limite_sql = "limit 15";
            }
        }

        $add = 0;
        $sql = "SELECT codpro FROM producto where " . $campo . " " . $operador_sql . " '$producto' and activo = '1'  and eliminado='0' " . $limite_sql;
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            $add = 3;
        }
    } else {
        $add = isset($_REQUEST['add']) ? ($_REQUEST['add']) : "-1";
    }

    $sql = "SELECT cuscod,codmed FROM venta where usecod = '$usuario' and invnum = '$venta' and estado ='1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $cuscod = $row['cuscod'];
            $codmed = $row['codmed'];
        }
    }


    $sql = "SELECT descli,ruccli FROM cliente where codcli = '$cuscod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nombre_cliente = $row['descli'];
            $ruc_cliente = $row['ruccli'];
        }
    }
    
 /* $sqlCuotaPago = "SELECT VC.fecha_pago FROM venta_cuotas AS VC INNER JOIN venta AS V on V.invnum=VC.venta_id INNER JOIN cliente AS C on C.codcli=V.cuscod WHERE V.forpag='C' and V.estado='0' and V.val_habil='0' and VC.montoCobro>0  and C.codcli = '$cuscod'  LIMIT 1 ";
    $resultCuotaPago = mysqli_query($conexion, $sqlCuotaPago);
    if (mysqli_num_rows($resultCuotaPago)) {
        while ($rowCuotaPago = mysqli_fetch_array($resultCuotaPago)) {
            $fecha_pago = $rowCuotaPago[0];
            
        }
         $tieneDeudas=1;
    }else{
        $tieneDeudas=0;
    }
    
    
    if($tieneDeudas ==1){
        
        if($fecha_pago <= date('Y-m-d')){
           //echo '<script language="javascript">var mensaje;var opcion = confirm("Clicka en Aceptar o Cancelar");if (opcion == true) {mensaje = "Has clickado OK";} else {	mensaje = "Has clickado Cancelar";};</script>';
        }
        
    }
*/

    // if (isset($codmed)) {

    $sql = "SELECT nommedico,codcolegiatura FROM medico  WHERE codmed = '$codmed'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nommedico2 = $row['nommedico'];
            $codcolegiatura2 = $row['codcolegiatura'];
        }
    } else {
        $nommedico2 = "";
        $codcolegiatura2 = "";
    }


    $sql1 = "SELECT codloc,codgrup FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codloc = $row1['codloc'];
            $codgrupve = $row1['codgrup'];
        }
    }

    $sql1_codgrup = "SELECT * FROM `grupo_user` WHERE codgrup = '$codgrupve' and ((nomgrup LIKE '%adm%')or (nomgrup LIKE '%sup%'))"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_codgrup = mysqli_query($conexion, $sql1_codgrup);
    if (mysqli_num_rows($result1_codgrup)) {
        $controleditable = 1;
    } else {
        $controleditable = 0;
    }


    // $sql1_codgrup = "SELECT * FROM `grupo_user` WHERE codgrup = '$codgrupve' and ((nomgrup LIKE '%ven%')or (nomgrup LIKE '%cola%'))"; ////CODIGO DEL LOCAL DEL USUARIO
    // $result1_codgrup = mysqli_query($conexion, $sql1_codgrup);
    // if (mysqli_num_rows($result1_codgrup)) {
    //     $ventasAnteriores = 1;
    // } else {
    //     $ventasAnteriores = 0;
    // }
    

    $sql1xx = "SELECT priceditable FROM datagen_det";
    $result1xx = mysqli_query($conexion, $sql1xx);
    if (mysqli_num_rows($result1xx)) {
        while ($row1xx = mysqli_fetch_array($result1xx)) {
            $priceditable = $row1xx['priceditable'];
        }
    }

    if ($usuariosEspeciales_ArqueoCaja == 1) {

        if (($usuario == '1') || ($usuario == '2') || ($usuario == '7742') || ($codgrupve == '2')) {
            $bloqueoUsuario = '1';
        } else {
            $bloqueoUsuario = '0';
        }
    } else {
        $bloqueoUsuario = '0';
    }


    if (($arqueo_caja == 1) && ($bloqueoUsuario == 0)) {

        $fecha_actual_arqueo = date('Y/m/d');


        $sql_arqueo_no_cerraron_dias_antes = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio<>'$fecha_actual_arqueo' and estado ='0' ";
        $result_arqueo_no_cerraron_dias_antes = mysqli_query($conexion, $sql_arqueo_no_cerraron_dias_antes);
        if (mysqli_num_rows($result_arqueo_no_cerraron_dias_antes)) {
            $arqueo_arqueo_no_cerraron_dias_antes = 1;
        } else {
            $arqueo_arqueo_no_cerraron_dias_antes = 0;
        }

        $sql_arqueo_bloqueo = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo'";
        $result_arqueo_bloqueo = mysqli_query($conexion, $sql_arqueo_bloqueo);
        if (mysqli_num_rows($result_arqueo_bloqueo)) {
            $arqueo_bloqueo = 1;
        } else {
            $arqueo_bloqueo = 0;
        }

        if ($arqueo_bloqueo == 1) {

            $sql_arqueo_bloqueo_cierre = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo' and fecha_cierre='$fecha_actual_arqueo' and  monto_cierre > 0";
            $result_arqueo_bloqueo_cierre = mysqli_query($conexion, $sql_arqueo_bloqueo_cierre);
            if (mysqli_num_rows($result_arqueo_bloqueo_cierre)) {

                $arqueo_bloqueo_2 = 1;
            } else {
                $arqueo_bloqueo_2 = 0;
            }
        } else {
            $arqueo_bloqueo_2 = 0;
        }
    } else {
        $arqueo_bloqueo = 1;
        $arqueo_arqueo_no_cerraron_dias_antes = 0;
        $arqueo_bloqueo_2 = 0;
    }



    $fecha_actual_arqueo = date('Y/m/d');
    $sql_arqueo = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo'  and monto_cierre = 0";
    $result_arqueo = mysqli_query($conexion, $sql_arqueo);
    if (mysqli_num_rows($result_arqueo)) {
        $arqueo = 1;
    } else {
        $arqueo = 0;
    }


    ?>


    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <script language="javascript" type="text/javascript">
        function Submit_seguro(formulario) {
            for (i = 1; i < formulario.elements.length; i++) {
                if (formulario.elements[i].type == 'submit') {
                    formulario.elements[i].disabled = true
                }
            }
            formulario.submit()
            Submit_seguro = Submit_off
            return false
        }

        function Submit_off(formulario) {
            return false
        }

        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

        function PRINCIPIOACTIVO(limpiacadena) {
            window.open('prinactivo.php?lim=' + limpiacadena, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=70,left=540,width=455,height=350');
        }

        function ACCIONTERAPEUTICA(limpiacadena) {
            window.open('accionte.php?lim=' + limpiacadena, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=70,left=540,width=455,height=350');
        }

        function abrir_info(e, codpro) {
            tecla = e.keyCode;
            ////F8
            // if (tecla == 118) {
            //     window.open('historial_ventas.php?codpro= ' + codpro, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=250,width=905,height=320');
            // }
        }

        function incentiv() {
            ////boton///
            var left = 80;
            var top = 120;
            var width = 1250;
            var height = 420;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

        function formaPrecio() {
            ////boton///
            var left = 80;
            var top = 120;
            var width = 1250;
            var height = 420;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('tipoPrecios.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
        var prueba;

        function f6() {
            
            
             w = 700;
                            h = 500;
                            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                            var top = ((height / 2) - (h / 2)) + dualScreenTop;
                            var newWindow = window.open('tip_venta.php', 'Forma Pago', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

 




            
            
            
            
            
        }

        function f2() {
            
             w = 1300;
                            h = 600;
                            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                            var top = ((height / 2) - (h / 2)) + dualScreenTop;
                            var newWindow = window.open('f2/f2.php', 'Forma Pago', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
                            
            
            
           
        }

        function f1() {
            window.open('f3/f3.php', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=250,width=905,height=450');
        }

        function arqueo_caja() {
            ////boton///
            var left = 400;
            var top = 200;
            var width = 550;
            var height = 360;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('arqueo_caja/arqueo_caja.php?entrada=2', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

        function buscarb() {
            var f = document.form1;
            if (f.country.value !== '') {
                document.form1.submit();
            } else {
                alert("Ingrese una descripcion");
                f.country.focus();
                return false;
            }

            f.submit();
        }
    </script>
    <script language="javascript" src="funciones/jquery.js"></script>
    <script language="javascript">
        $(document).ready(function() {

            $('form').keypress(function(e) {
                if (e == 13) {
                    return false;
                }
            });

            $('input').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

        });
        var nav4 = window.Event ? true : false;

        function enteres(evt) {
            var f = document.form1;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                var cod = document.form1.country_ID.value;
                window.location.href = "venta_index2.php?cod=" + cod + "&add=1&typpe=1";
            } else {
                return false;
            }
        }

        function enteres1(evt) {
            var f = document.form1;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (f.country.value !== '') {
                    document.form1.submit();
                } else {
                    alert("Ingrese una descripcion");
                    return false;
                }
            } else {
                return false;
            }
        }
    </script>
    <style>
        a:link,
        a:visited {
            color: #0066CC;
            border: 0px solid #e7e7e7;
        }

        a:hover {
            background: #FFFF66;
            border: 1px solid #ccc;
        }

        a:focus {
            background-color: #FFFF66;
            /*color de fondo de descripcion de los productos al pasar con las flechas del teclado */
            color: #0066CC;
            /*padding: 0px 0px 0px 20px;*/

        }

        a:active {
            background-color: #FFFF66;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        .Estilo1 {
            color: #006699;
            font-weight: bold;
        }

        .Estilo2 {
            color: #0066CC;
            font-weight: bold;
        }

        .Estilo2fin {
            color: #0b55c4;
            font-size: 20px;
            /* font-weight: bold; */
        }

        .Estilo3 {
            color: #003300
        }


        .f {
            text-decoration: none;
            padding: 2px;
            font-weight: 200;
            font-size: 10px;
            color: #ffffff;
            background-color: #1883ba;
            font-weight: bold;
            border-radius: 6px;

        }
    </style>
    <script type="text/javascript">
        function resizeIframe(obj) {
            obj.style.height = 0;
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }

        function eventoeduardo(e, a) {


            var event = window.event ? window.event : e;
            tecla = event.keyCode;

            if (tecla == 40) {

                var id_fila = a + 1;

                var id_fila1 = 'fila_' + id_fila;
                var baja = 'fila_' + (id_fila - 1);
                document.getElementById(id_fila1).style.backgroundColor = '#FFFF66';
                document.getElementById(baja).style.backgroundColor = '';
            } else if (tecla == 38) {
                var id_fila = a - 1;
                var id_fila1 = 'fila_' + id_fila;
                var sube = 'fila_' + (id_fila + 1);

                document.getElementById(id_fila1).style.backgroundColor = '#FFFF66';
                document.getElementById(sube).style.backgroundColor = '';
            }
        }
    </script>
</head>

<body onkeyup="abrir_index2(event)" <?php if ($cierre_caja == 1) { ?> onload="salir1();" <?php } ?> <?php if (($add == 1) || ($add == 2)) { ?> onload="st();" <?php
                                                                                                                                                            } else {
                                                                                                                                                                if ($add == 3 || $add == 0) {
                                                                                                                                                                ?> onload="getfocus(event);" <?php } else { ?> onload="sf();" <?php
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                ?>>

    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <table width="100%" height="30" border="0" class="tabla2">


            <tr>
                <td width="40%">

                    <div align="left"><span class="blues">
                            <?php if ($nommedico2 <> "") { ?>
                                <b>MEDICO :&nbsp;&nbsp;</b> <?php echo $nommedico2 ?>
                            <?php } ?>
                            <?php if ($codcolegiatura2 <> "") { ?>
                                <b>CODIGO :&nbsp;&nbsp;</b><?php echo $codcolegiatura2; ?></span>
                    <?php } ?>
                    </div>

                </td>

                <td width="30%">
                    <?php if (strlen($ruc_cliente) > 0) { ?>

                        <div align="center"> <span style='font-size:40px;color: #2a4f8c;'><b>FACTURA</b></span></div>
                    <?php } ?>
                </td>


                <td width="30%">
                    <div align="right"><span class="blues"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLIENTE:</b> <?php echo $nombre_cliente ?></span></div>
                </td>

            </tr>

            <tr>
                <td width="60%" colspan="2">
                    <input type="button" class="Botonesclientesventas" name="Submit" value="Asignar m&eacute;dico (F1)" onclick="f1();" class="Botonesclientesventas" />
                    <input type="button" class="Botonesclientesventas" name="Submit" value="Asignar cliente (F2)" onclick="f2();" />
                    <input type="button" class="Botonesclientesventas" name="Submit" value="Forma de pago (F6)" onclick="f6();" />
                    <input type="button" class="Botonesclientesventas" name="Submit" value="Ver Incentivos(F11)" onclick="incentiv();" />
                    <?php if ($masPrecioVenta == 1) { ?>
                        <input type="button" class="Botonesclientesventas" name="Submit" value="Tipos de Precios" onclick="formaPrecio();" <?php if (($count >= 1) || ($count1 < 0)) { ?>disabled="disabled" title="Tiene una venta pendiente Cancelar o Eliminar para poder poder escoger Tipos de Precios , gracias" <?php } ?> />
                    <?php } ?>
                    <?php if ($arqueo == 1) { ?>
                        <blink>
                            <input type="button" class="modificar" name="Submit" style="font-size:15px;" value="Cierre Caja" onclick="arqueo_caja();" />
                        </blink>
                    <?php } ?>
                </td>

                <td width="40%" valign="middle">
                    <div align="right">
                        <input name="documento" type="hidden" id="documento" value="<?php echo $nrovent ?>" />
                        <input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
                        <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
                        <input name="CodClaveVendedor" type="hidden" id="CodClaveVendedor" value="" />
                        &nbsp;
                        <input name="veb" type="button" id="veb" value="GRABAR VENTA(F9)" onclick="grabar1()" class="grabarventa" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" title="Necesita escoger un producto para activar la Opcion GRABAR VENTA(F9)" <?php } ?> />
                        <input name="ext3" type="button" id="ext3" value="Cancelar(F4)" onclick="cancelar()" class="cancelar" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?> />

                        <input name="ext2" type="button" id="ext2" value="Salir(F12)" onclick="salir1()" class="salir" />
                    </div>
                </td>
            </tr>
        </table>
        <?php

        $contador_filtro_de_lineas = 0;
        if (!empty($arr_detalle_venta)) {
            foreach ($arr_detalle_venta as $row => $item) {
                $contador = ++$row;
                //$codtemp      = key($arr_detalle_venta); 
                $codtemp = array_search($row, $arr_detalle_venta);
                $codpross = $row['codpro'];

                if ($codpross == $cod) {
                    //echo "<script type=\"text/javascript\">alert(\"SI COINCIDE\");</script>";  
                    $smss = "1";
                } else {
                    $smss = "0";
                }
            }
            $contador_filtro_de_lineas = $contador;

            // echo 'contador_filtro_de_lineas = ' . $contador_filtro_de_lineas;
            // echo 'numlineas = ' . $numlineas;
        }
        ?>

        <table width="100%" border="0">
            <tr>
                <td width="70%">
                    <?php
                    if ($limite_busk > 0) {
                    ?>
                        <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" value="" size="65" class="busk" onkeypress="enteres(event)" />
                        <input type="hidden" id="country_hidden" name="country_ID" />
                    <?php
                    } else {
                    ?>
                        <!--<input id="efecto1" type="text" placeholder="Buscar Producto . . . . ." name="country" id="country" size="50" class="busk" onkeypress="enteres1(event), this.value = this.value.toUpperCase();" />-->
                        <input id="efecto1" type="text" placeholder="Buscar Producto . . . . ." name="country" id="country" size="10%" class="busk" <?php if ($contador_filtro_de_lineas >= $numlineas) { ?> onkeypress="lineasfiltro();" readonly <?php } ?> onkeypress="enteres1(event), this.value = this.value.toUpperCase();" <?php if (($arqueo_bloqueo == 0) || ($arqueo_bloqueo_2 == 1) || ($arqueo_arqueo_no_cerraron_dias_antes  == 1)) {  ?> disabled="disabled" <?php } ?> />
                    <?php
                    }
                    ?>
                    <input id="efecto2" type="button" name="Submit" value="BUSCAR" class="busk" onclick="buscarb()" <?php if (($arqueo_bloqueo == 0) || ($arqueo_bloqueo_2 == 1) || ($arqueo_arqueo_no_cerraron_dias_antes  == 1)) {  ?> disabled="disabled" <?php } ?> />
                </td>
                <td width="30%">
                    <div align="center">
                        <input name="tt" type="hidden" id="tt" value="" />
                        <input name="vt" type="hidden" id="vt" value="" />
                        <input name="tipo" type="hidden" id="tipo" value="2" />
                        <input name="val" type="hidden" id="val" value="1" />

                        <input name="activado" type="hidden" id="activado" value="<?php echo $count ?>" />
                        <input name="activado1" type="hidden" id="activado1" value="<?php echo $count1 ?>" />
                        <input name="medico" type="hidden" id="medico" value="<?php echo $nommedico2 ?>" />
                        <input name="t33" type="hidden" id="t33" value="1" />
                    </div>
                    <div align="right">

                      
                        <input name="ext" type="button" id="ext" value="&nbsp;Buscar ventas anteriores&nbsp;" onclick="buscar()" class="buscar" <?php if (($count >= 1) || ($count1 < 0)) { ?>disabled="disabled" title="Tiene una venta pendiente Cancelar o Eliminar para poder Buscar, gracias" <?php } ?> <?php if (($arqueo_bloqueo == 0) || ($arqueo_bloqueo_2 == 1) || ($arqueo_arqueo_no_cerraron_dias_antes  == 1)) {  ?> disabled="disabled" <?php } ?> />
                    
                    
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="100%">
                    <b title="Anteponer el * para Realizar la Busqueda Ejmplo: *NAPROXENO ">
                        <font color="#FF9900">* &nbsp; X PRINCIPIO ACTIVO </font>
                    </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b title="Anteponer el / para Realizar la Busqueda Ejmplo: /ANTIBIOTICO ">
                        <font color="#FF0000">/ &nbsp; X ACCION TERAPEUTICA</font>
                    </b>
                </td>
            </tr>
        </table>

        <?php
        $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
        if ($val == 1) {
            if ($tipo == 2) {
                $add = 0;
                $cod = 0;
                $i = 1;

                $campo = "codpro";
                if ($limite_busk > 0) {
                    if ($search == '') {
                        $producto = $_REQUEST['country_ID'];
                    } else {
                        $producto = $_REQUEST['codigo_busk'];

                        switch ($search) {
                            case 2:
                                $campo = "codfam";
                                break;
                            case 3:
                                $campo = "coduso";
                                break;
                            case 4:
                                $campo = "codmar";
                                break;
                            case 6:
                                $campo = "codpres";
                                break;
                        }
                    }
                    $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where " . $campo . " = '$producto' and activo = '1' and eliminado='0'  order by $tabla desc";
                } else {
                    $acc = isset($_REQUEST['acc']) ? ($_REQUEST['acc']) : "";
                    $productop = isset($_REQUEST['codigo_busk']) ? ($_REQUEST['codigo_busk']) : "";
                    if ($productop <> "") {
                        switch ($search) {
                            case 2:
                                $campo = "codfam";
                                break;
                            case 3:
                                $campo = "coduso";
                                break;
                            case 4:
                                $campo = "codmar";
                                break;
                            case 6:
                                $campo = "codpres";
                                break;
                        }
                        $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where " . $campo . " = '$productop' and activo = '1' and eliminado='0'  order by $tabla desc ,desprod desc";
                    } else {
                        if ($acc == 1) {
                            $producto = $_REQUEST['country_ID'];
                            $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where codpro = '$producto' and activo = '1' and eliminado='0'  order by $tabla desc,desprod desc";
                        }
                        /* else
                              {
                              $producto 	= $_REQUEST['country'];
                              $sql="SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where ((desprod LIKE '$producto%') or (codbar = '$producto') or (codpro = '$producto%'))  and activo = '1' order by $tabla desc,desprod desc";
                              } */ else {
                            // $producto = $_REQUEST['country'];
                            // $codfamm = $_REQUEST['codfam'];
                            // $codusoo = $_REQUEST['coduso'];

                            $codusoo = isset($_REQUEST['coduso']) ? ($_REQUEST['coduso']) : "";
                            $codfamm = isset($_REQUEST['codfam']) ? ($_REQUEST['codfam']) : "";
                            $producto = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
                            $limpiacadena = "";
                            $DetectaAsterics1 = substr($producto, 0, 1);
                            $DetectaAsterics2 = substr($producto, 0, 1);
                            if ($DetectaAsterics2 == "*") {
                                $limpiacadena = str_replace('*', '', $producto);
                                echo "<script language='javascript'> PRINCIPIOACTIVO('" . $limpiacadena . "'); </script>";
                            } elseif ($DetectaAsterics1 == "/") {

                                //                                    ACCION TERAPEUTICA
                                $limpiacadena = str_replace('/', '', $producto);
                                echo "<script language='javascript'> ACCIONTERAPEUTICA('" . $limpiacadena . "'); </script>";
                            } else {

                                if ($codfamm <> "") {
                                    $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where codfam='$codfamm'  and activo = '1' and eliminado='0'  order by $tabla desc,desprod desc";
                                } elseif ($codusoo <> "") {
                                    $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where coduso='$codusoo'  and activo = '1' and eliminado='0'  order by $tabla desc,desprod desc";
                                } else {

                                    $healthy=array("ñ","Ñ");
                                    $yummy =array("&ntilde;","&Ntilde;" );
                                    

                                    // $limpiacadena = $producto;
                                    $limpiacadena = str_replace($healthy, $yummy, $producto);
                                    // if ($palabra_contenida == 1) {
                                    //     $limpiacadena = "%" . $limpiacadena . "%";
                                    // } else {
                                    //     $limpiacadena =   $limpiacadena . "%";
                                    // }

                                    $sql = "SELECT codpro,desprod,codmar,prelis,factor,incentivado,pcostouni,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  FROM producto where ((desprod LIKE '$limpiacadena%') or (codbar = '$limpiacadena') or (codpro = '$limpiacadena')  )  and activo = '1' and eliminado='0' order by $tabla   desc, incentivado desc,desprod desc";
                                }
                            }
                        }
                    }
                }
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
        ?>

                    <table id="customers" width="100%" border="0" style="margin-top:10px;">

                        <tr>
                            <th width="6%" style="border-top-left-radius: 10px;">COD. PRO</th>
                            <th width="40%">DESCRIPCION</th>
                            <th width="10%">
                                <div align="center">MARCA</div>
                            </th>
                            <th width="5%">
                                <div align="CENTER">LOTE</div>
                            </th>
                            <th width="7%">
                                <div align="CENTER">FEVEN</div>
                            </th>
                            <th width="7%">
                                <div align="center">PRECIO CAJA</div>
                            </th>
                            <th width="7%">
                                <div align="center">PRECIO BLISTER</div>
                            </th>
                            <th width="7%">
                                <div align="center">PRECIO UNID</div>
                            </th>
                            <th width="9%">
                                <div align="center">STOCK DISPONIBLE</div>
                            </th>
                            <th width="2%" style="border-top-right-radius: 10px;">&nbsp;</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            $codpro = $row['codpro'];
                            $desprod = utf8_encode($row['desprod']);
                            $codmar = $row['codmar'];
                            $factor = $row['factor'];
                            $cant_loc1 = $row[10];
                            //$incentivado = $row['incentivado'];

                            //editado adrian
                            $incentivado = 0;

                            $sqlIncentivos = "SELECT COUNT(*) AS contador FROM incentivado 
                            INNER JOIN incentivadodet ON incentivado.invnum = incentivadodet.invnum
                            WHERE incentivadodet.codpro ='$codpro' AND incentivado.estado = 1 AND incentivadodet.estado = 1 AND incentivado.esta_desa = 0";

                            $resultSqlIncentivos = mysqli_query($conexion, $sqlIncentivos);

                            if (mysqli_num_rows($resultSqlIncentivos)) 
                            {
                                while ($row2 = mysqli_fetch_array($resultSqlIncentivos)) 
                                {
                                    if($row2["contador"] > 0)
                                    {
                                        $incentivado = 1;
                                    }
                                    else 
                                    {
                                        $incentivado = 0;
                                    }
                                }
                            }

                            $recetaMedica = $row['recetaMedica'];
                            // , opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica 
                            if ($masPrecioVenta == 1) {
                                $pblister = $row['blister'];
                                $preblister = $row['preblister'];
                                $referencial = $row['prelis'];
                                $pcostouni = $row['pcostouni'];
                                $margene = $row['margene'];
                                $prevtaMain = $row['PrevtaMain'];
                                $preuniMain = $row['PreuniMain'];
                                $costre = $row['costre'];

                                if ($tipoOpcionPrecio == 2) {
                                    $opPrevta2 = $row['opPrevta2'];
                                    $opPreuni2 = $row['opPreuni2'];

                                    if ($opPrevta2 > 0) {
                                        $prevta = $opPrevta2;
                                    } else {
                                        $prevta = $row[13];
                                    }
                                    if ($opPreuni2 > 0) {
                                        $preuni = $opPreuni2;
                                    } else {
                                        $preuni = $row[14];
                                    }
                                } else if ($tipoOpcionPrecio == 3) {
                                    $opPrevta3 = $row['opPrevta3'];
                                    $opPreuni3 = $row['opPreuni3'];

                                    if ($opPrevta3 > 0) {
                                        $prevta = $opPrevta3;
                                    } else {
                                        $prevta = $row[13];
                                    }
                                    if ($opPreuni3 > 0) {
                                        $preuni = $opPreuni3;
                                    } else {
                                        $preuni = $row[14];
                                    }
                                } else if ($tipoOpcionPrecio == 4) {
                                    $opPrevta4 = $row['opPrevta4'];
                                    $opPreuni4 = $row['opPreuni4'];
                                    if ($opPrevta4 > 0) {
                                        $prevta = $opPrevta4;
                                    } else {
                                        $prevta = $row[13];
                                    }
                                    if ($opPreuni4 > 0) {
                                        $preuni = $opPreuni4;
                                    } else {
                                        $preuni = $row[14];
                                    }
                                } else if ($tipoOpcionPrecio == 5) {
                                    $opPrevta5 = $row['opPrevta5'];
                                    $opPreuni5 = $row['opPreuni5'];
                                    if ($opPrevta5 > 0) {
                                        $prevta = $opPrevta5;
                                    } else {
                                        $prevta = $row[13];
                                    }
                                    if ($opPreuni5 > 0) {
                                        $preuni = $opPreuni5;
                                    } else {
                                        $preuni = $row[14];
                                    }
                                } else {
                                    $prevta = $row[13];
                                    $preuni = $row[14];
                                }
                            } else {
                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                    $pblister = $row['blister'];
                                    $preblister = $row['preblister'];
                                    $referencial = $row['prelis'];
                                    $pcostouni = $row['pcostouni'];
                                    $margene = $row['margene'];
                                    $prevtaMain = $row['PrevtaMain'];
                                    $preuniMain = $row['PreuniMain'];
                                    $prevta = $row[13];
                                    $preuni = $row[14];
                                    $costre = $row['costre'];
                                } elseif ($precios_por_local == 0) {
                                    $pblister = $row['blister'];
                                    $preblister = $row['preblister'];
                                    $referencial = $row['prelis'];
                                    $pcostouni = $row['pcostouni'];
                                    $margene = $row['margene'];
                                    $prevtaMain = $row['PrevtaMain'];
                                    $preuniMain = $row['PreuniMain'];
                                    $prevta = $row[13];
                                    $preuni = $row[14];
                                    $costre = $row['costre'];
                                }
                            }

                            if ($drogueria == 1) {

                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                if (mysqli_num_rows($result1_movlote)) {
                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                        $stock_movlote = $row1_movlote[0];
                                    }
                                }

                                $cant_loc = $stock_movlote;
                            } else {

                                $cant_loc = $cant_loc1;
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $blister_p,$preblister_p ,$prelis_p,$pcostouni_p,$margene_p,$prevta_p,$preuni_p,$costre_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $pblister = $row_precio[0];
                                        $preblister = $row_precio[1];
                                        $referencial = $row_precio[2];
                                        $pcostouni = $row_precio[3];
                                        $margene = $row_precio[4];
                                        $prevtaMain = $row_precio[5];
                                        $preuniMain = $row_precio[6];
                                        $prevta = $row_precio[5];
                                        $preuni = $row_precio[6];
                                        $costre = $row_precio[7];
                                    }
                                }
                            }

                            //**CONFIGPRECIOS_PRODUCTO**//
                            if (($prevta == "") || ($prevta == 0)) {
                                $prevta = $prevtaMain;
                            }
                            if (($preuni == "") || ($preuni == 0)) {
                                $preuni = $preuniMain;
                            }

                            //**FIN_CONFIGPRECIOS_PRODUCTO**//

                            if (($referencial > 0) and ($referencial <> $prevta)) {
                                $margenes = ($margene / 100) + 1;
                                $precio_ref = $referencial;
                                //$precio_ref     = $referencial/$factor;
                                //$precio_ref     = $referencial* $factor;
                                $precio_ref = $precio_ref * $margenes;
                                $desc1 = $precio_ref - $preuni;
                                if ($desc1 < 0) {
                                    $descuento = 0;
                                } else {
                                    //esto puse yo para que no salga error eduardo
                                    if ($preuni > 0) {
                                        if (!(($precio_ref < 1) and ($precio_ref > 0))) {
                                            $precio_ref = number_format($precio_ref, 2, '.', ',');
                                        }
                                        $descuento = (($precio_ref - $preuni) / $precio_ref) * 100;
                                    }
                                }
                            } else {
                                $precio_ref = $preuni;
                                $descuento = 0;
                            }

                            $vencimnnn = "";
                            $numlote = "";
                            $sql1_movlote = "SELECT numlote,vencim FROM movlote where codpro = '$codpro'  and codloc= '$sucursal'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
                            $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                            if (mysqli_num_rows($result1_movlote)) {
                                while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                    $numlote = $row1_movlote['numlote'];
                                    $vencimnnn = $row1_movlote['vencim'];
                                }
                            }

                            $sql1_titultabladet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = 'M'";
                            $result1_titultabladet = mysqli_query($conexion, $sql1_titultabladet);
                            if (mysqli_num_rows($result1_titultabladet)) {
                                while ($row1_titultabladet = mysqli_fetch_array($result1_titultabladet)) {
                                    $marca = $row1_titultabladet['destab'];
                                    $marca1 = $row1_titultabladet['abrev'];
                                }
                            }
                            //echo $marca1;
                            //$codloc local de usuario logueado
                            // $codloc local de local 0
                            /*$sql1_incentivadodet = "SELECT COUNT(codpro) FROM incentivadodet as DI INNER JOIN incentivado as I on I.invnum=DI.invnum  where DI.codpro = '$codpro'  and I.estado='1'  and ((DI.codloc = '$codloc') or (DI.codloc = '$localp'))";
                            $result1_incentivadodet = mysqli_query($conexion, $sql1_incentivadodet);
                            if (mysqli_num_rows($result1_incentivadodet)) {
                                while ($row1_incentivadodet = mysqli_fetch_array($result1_incentivadodet)) {
                                    $sumcodes = $row1_incentivadodet[0];
                                }
                            } else {
                                $sumcodes = 0;
                            }
                            if ($sumcodes <> 0) {
                                $incentivado = 1;
                            } else {
                                $incentivado = 0;
                            }*/
                            $sql1_bonifi = "SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
                            $result1_bonifi = mysqli_query($conexion, $sql1_bonifi);
                            if (mysqli_num_rows($result1_bonifi)) {
                                while ($row1_bonifi = mysqli_fetch_array($result1_bonifi)) {
                                    $desprod_bonif = $row1_bonifi['desprod'];
                                }
                                $bonifi = 1;
                            } else {
                                $bonifi = 0;
                            }
                            $sql1 = "SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$venta'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                $control = 1;
                            } else {
                                $control = 0;
                            }

                            $control = 0;
                            if (($incentivado == 1) and ($cant_loc > 0)) {
                                $color = 'prodincent';
                                $text = 'text_prodincent';
                            } else {
                                if ($cant_loc > 0) {
                                    $color = 'prodnormal';
                                    $text = 'text_prodnormal';
                                } else {
                                    $color = 'prodstock';
                                    $text = 'text_prodstock';
                                }
                            }
                            if ($factor == 0) {
                                $factor = 1;
                            }
                            ++$z;
                            $convert1 = $cant_loc / $factor;
                            $div1 = floor($convert1);
                            $mult1 = $factor * $div1;
                            $tot1 = $cant_loc - $mult1;


                            if ($factor > 1) {
                                $convert1 = $cant_loc / $factor;
                                $caja = ((int) ($convert1));
                                $unidad = ($cant_loc - ($caja * $factor));
                                $stocknuevo = "<b>C</b>" . $caja . "<b> + F</b>" . $unidad;
                            } else {
                                $convert1 = $cant_loc / $factor;
                                $caja = ((int) ($convert1));

                                $stocknuevo = "<b>C </b>" .  $caja;
                            }

                            $formatostock = $stocknuevo;


                            if ($preuni > 0) {
                            } else {
                                if ($factor <> 0) {
                                    $preuni = $prevta / $factor;
                                }
                            }
                            // if ($ventaalcosto == 1) {

                            //     if ($nomlocalG == "LOCAL0") {

                            //         if ($unidad_normal == 0) {

                            //             $prevta = $costre * (1 + 5 / 100);
                            //             $preuni = $prevta / $factor;
                            //         } else {
                            //             $prevta = $costre * (1 + $unidad_normal / 100);
                            //             $preuni = $prevta / $factor;
                            //         }
                            //     }
                            // }
                            $preunit = number_format($preuni, 3, '.', ' ');


                        ?>
                            <tr height="5%" style="padding:5px" id="fila_<?php echo $z ?>">

                                <td onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <span class="<?php echo $text ?>"><?php echo $codpro ?>-</span>
                                    <?php } ?>
                                </td>

                                <td title="Su factor es <?php echo $factor; ?>" onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <a id="l<?php echo $z ?>" style="text-decoration:none" href="venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1" onkeypress="eventoeduardo(event,<?php echo $z ?>);" onkeyup="abrir_info(event,<?php echo $codpro ?>)" <?php if ($recetaMedica == 1) { ?> class="prodRMedica" <?php } else { ?> class="<?php echo $color ?>"> <?php } ?><b><?php
                                                                                                                                                                                                                                                                                                                                                                                            if ($bonifi == 1) {
                                                                                                                                                                                                                                                                                                                                                                                                echo substr($desprod, 0, $charact);
                                                                                                                                                                                                                                                                                                                                                                                                if (($drogueria == 1) && ($cant_loc == "") && ($cant_loc1 > 0)) {
                                                                                                                                                                                                                                                                                                                                                                                                    echo "<blink> - vencido -</blink>";
                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                if (($recetaMedica == 1)) {
                                                                                                                                                                                                                                                                                                                                                                                                    echo "<blink> - RECETA MEDICA -</blink>";
                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                echo " + (B) x CAJA ";
                                                                                                                                                                                                                                                                                                                                                                                                echo substr($desprod_bonif, 0, $charactbonif);
                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                echo substr($desprod, 0, $charact);
                                                                                                                                                                                                                                                                                                                                                                                                if (($drogueria == 1) && ($cant_loc == "") && ($cant_loc1 > 0)) {
                                                                                                                                                                                                                                                                                                                                                                                                    echo "<blink> - vencido </blink>";
                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                if (($recetaMedica == 1)) {
                                                                                                                                                                                                                                                                                                                                                                                                    echo "<blink> - RECETA MEDICA -</blink>";
                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                            ?></b></a>
                                    <?php } ?>
                                </td>

                                <td title="<?php echo $marca; ?>" onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="CENTER" class="<?php echo $text ?>"><b><?php
                                                                                            if ($marca1 == "") {
                                                                                                echo limpia_espacios($marca);
                                                                                                echo " ";
                                                                                            } else {
                                                                                                echo limpia_espacios($marca1);
                                                                                                echo " ";
                                                                                            }
                                                                                            ?></b>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="CENTER" class="<?php echo $text ?>"><?php
                                                                                        if ($numlote <> "") {
                                                                                            echo $numlote;
                                                                                        }
                                                                                        ?></div>
                                    <?php } ?>
                                </td>
                                <td onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="CENTER" class="<?php echo $text ?>"><?php
                                                                                        if ($vencimnnn <> "") {
                                                                                            echo $vencimnnn;
                                                                                        }
                                                                                        ?></div>
                                    <?php } ?>
                                </td>



                                <td onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="CENTER" class="<?php echo $text ?>"><?php echo $prevta ?></div>
                                    <?php } ?>
                                </td>
                                <td title=" A partir de &nbsp;<?php echo $pblister; ?>&nbsp;und &nbsp;el precio es <?php echo $preblister; ?>" onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="CENTER" class="<?php echo $text ?>"><?php echo $pblister . "<b style='color:red;'>&nbsp;>&nbsp;</b>" . $preblister; ?> </div>
                                    <?php } ?>
                                </td>
                                <td bgcolor="#CBE3F3" onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="center" class="<?php echo $text ?>"><b><?php echo $preunit ?></b></div>
                                    <?php } ?>
                                </td>

                                <td onclick="location.href = 'venta_index2.php?cod=<?php echo $codpro ?>&add=1&typpe=1'">
                                    <?php if ($control == 0) { ?>
                                        <div align="center" class="<?php echo $text ?>"><?php echo $formatostock; ?></div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($control == 0) { ?>
                                        <div align="center">
                                            <a style="text-decoration:none" href="javascript:popUpWindow('ver_prod_loc.php?cod=<?php echo $codpro ?>', 50, 50, 1250, 1500)">
                                                <input name="codigo_producto" type="hidden" id="codigo_producto" value="<?php echo $codpro ?>" />
                                                <img src="../../../images/lens.gif" width="14" height="15" border="0" /></a>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            ++$i;
                        }
                        ?>
                    </table>
                <?php
                } else {
                ?>
                    <center><br><br>
                        <h3 class='Estilo2fin' style="width:100%;">
                            NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA
                        </h3>
                    </center>
        <?php
                }
            }
        }
        ?>
        <?php
        $add = isset($_REQUEST['add']) ? ($_REQUEST['add']) : "-1";
        $typpe = isset($_REQUEST['typpe']) ? ($_REQUEST['typpe']) : "";
        $i = 1;
        if ($typpe == 1) {
            //echo "holaaaa";exit;
            $val = 0;
            $cod = $_REQUEST['cod'];



            if (isset($_SESSION['arr_detalle_venta'])) {
                $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
            } else {
                $arr_detalle_venta = array();
            }

            if (!empty($arr_detalle_venta)) {
                foreach ($arr_detalle_venta as $row) {
                    //$contador = ++$row;
                    //$codtemp      = key($arr_detalle_venta); 
                    $codtemp = array_search($row, $arr_detalle_venta);
                    $codpross = $row['codpro'];

                    if ($codpross == $cod) {
                        //echo "<script type=\"text/javascript\">alert(\"SI COINCIDE\");</script>";  
                        $smss = "1";
                    } else {
                        $smss = "0";
                    }

                    // var_dump($codtemp);
                }
                //$contador_filtro_de_lineas = $contador;
                //echo $contador_filtro_de_lineas;
            }


            $sqlProducto = "SELECT recetaMedica FROM producto where codpro = '$cod' ";
            $resultProducto = mysqli_query($conexion, $sqlProducto);
            if (mysqli_num_rows($resultProducto)) {
                while ($rowProducto = mysqli_fetch_array($resultProducto)) {
                    $recetaMedica = $rowProducto['recetaMedica'];
                }
            }

            if ($recetaMedica == 1) {
                echo '<script type="text/javascript">alertify.alert("FARMASIS", "<h1><strong><center>Venta autorizada solo con receta médica</center></strong></h1>");</script>';
            }


            $sql = "SELECT costre,codpro,desprod,costre,codmar,factor,costpr,stopro,pcostouni,margene,codfam,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni, opPrevta2, opPreuni2, opPrevta3, opPreuni3, opPrevta4, opPreuni4, opPrevta5,opPreuni5,recetaMedica  "
                . "FROM producto where codpro = '$cod' and activo = '1' and eliminado='0'  order by desprod";

            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
        ?>
                <span class="Estilo1"><u>F4 = LINEA DE PRODUCTOS</u></span>

                <table width="100%" id="customers">
                    <tr>
                        <th width="6%" bgcolor="#6ec0f5" style="border-top-left-radius: 10px;padding:0 5px;">N&ordm;</th>
                        <th width="45%">DESCRIPCION</th>
                        <th width="4%">FACTOR</th>
                        <th width="7%">
                            <div align="center"> STOCK DISPONIBLE</div>
                        </th>
                        <th width="7%">
                            <div align="center"> PRECIO CAJA </div>
                        </th>
                        <th width="7%">
                            <div align="CENTER">BLISTER</div>
                        </th>
                        <th width="10%">
                            <div align="center">PRECIO UNID</div>
                        </th>
                        <th width="10%">
                            <div align="center">CANTIDAD </div>
                        </th>
                        <th width="8%" bgcolor="#6ec0f5" style="border-top-right-radius: 10px;">
                            <div align="center">TOTAL</div>
                        </th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $codpro = $row['codpro'];
                        $desprod = utf8_encode($row['desprod']);
                        $codmar = $row['codmar'];
                        $factor = $row['factor'];
                        $stopro = $row['stopro'];
                        $cant_loc_add1 = $row[13];
                        $codfam = $row['codfam'];

                        if ($drogueria == 1) {

                            $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                            $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                            if (mysqli_num_rows($result1_movlote)) {
                                while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                    $stock_movlote = $row1_movlote[0];
                                }
                            }

                            $cant_loc_add = $stock_movlote;
                        } else {

                            $cant_loc_add = $cant_loc_add1;
                        }



                        if ($masPrecioVenta == 1) {
                            $costre = $row['costre'];
                            $costpr = $row['costpr'];
                            $pcostouni = $row['pcostouni'];
                            $margene = $row['margene'];
                            $pblister = $row['blister'];
                            $preblister = $row['preblister'];
                            $prevtaMain = $row['PrevtaMain'];
                            $preuniMain = $row['PreuniMain'];
                            $recetaMedica = $row['recetaMedica'];

                            if ($tipoOpcionPrecio == 2) {
                                $opPrevta2 = $row['opPrevta2'];
                                $opPreuni2 = $row['opPreuni2'];

                                if ($opPrevta2 > 0) {
                                    $prevta = $opPrevta2;
                                } else {
                                    $prevta = $row[13];
                                }
                                if ($opPreuni2 > 0) {
                                    $preuni = $opPreuni2;
                                } else {
                                    $preuni = $row[14];
                                }
                            } else if ($tipoOpcionPrecio == 3) {
                                $opPrevta3 = $row['opPrevta3'];
                                $opPreuni3 = $row['opPreuni3'];

                                if ($opPrevta3 > 0) {
                                    $prevta = $opPrevta3;
                                } else {
                                    $prevta = $row[16];
                                }
                                if ($opPreuni3 > 0) {
                                    $preuni = $opPreuni3;
                                } else {
                                    $preuni = $row[17];
                                }
                            } else if ($tipoOpcionPrecio == 4) {
                                $opPrevta4 = $row['opPrevta4'];
                                $opPreuni4 = $row['opPreuni4'];
                                if ($opPrevta4 > 0) {
                                    $prevta = $opPrevta4;
                                } else {
                                    $prevta = $row[16];
                                }
                                if ($opPreuni4 > 0) {
                                    $preuni = $opPreuni4;
                                } else {
                                    $preuni = $row[17];
                                }
                            } else if ($tipoOpcionPrecio == 5) {
                                $opPrevta5 = $row['opPrevta5'];
                                $opPreuni5 = $row['opPreuni5'];
                                if ($opPrevta5 > 0) {
                                    $prevta = $opPrevta5;
                                } else {
                                    $prevta = $row[16];
                                }
                                if ($opPreuni5 > 0) {
                                    $preuni = $opPreuni5;
                                } else {
                                    $preuni = $row[17];
                                }
                            } else {
                                $prevta = $row[16];
                                $preuni = $row[17];
                            }
                        } else {

                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $costre = $row['costre'];
                                $costpr = $row['costpr'];
                                $pcostouni = $row['pcostouni'];
                                $margene = $row['margene'];
                                $pblister = $row['blister'];
                                $preblister = $row['preblister'];
                                $prevtaMain = $row['PrevtaMain'];
                                $preuniMain = $row['PreuniMain'];
                                $prevta = $row[16];
                                $preuni = $row[17];
                            } elseif ($precios_por_local == 0) {
                                $costre = $row['costre'];
                                $costpr = $row['costpr'];
                                $pcostouni = $row['pcostouni'];
                                $margene = $row['margene'];
                                $pblister = $row['blister'];
                                $preblister = $row['preblister'];
                                $prevtaMain = $row['PrevtaMain'];
                                $preuniMain = $row['PreuniMain'];
                                $prevta = $row[16];
                                $preuni = $row[17];
                            }


                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $costre_p,$costpr_p,$pcostouni_p,$margene_p,$blister_p,$preblister_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costre = $row_precio[0];
                                        $costpr = $row_precio[1];
                                        $pcostouni = $row_precio[2];
                                        $margene = $row_precio[3];
                                        $pblister = $row_precio[4];
                                        $preblister = $row_precio[5];
                                        $prevtaMain = $row_precio[6];
                                        $preuniMain = $row_precio[7];
                                        $prevta = $row_precio[6];
                                        $preuni = $row_precio[7];
                                    }
                                }
                            }
                        }


                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                            $sql_precio = "SELECT $costre_p,$costpr_p,$pcostouni_p,$margene_p,$blister_p,$preblister_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
                            $result_precio = mysqli_query($conexion, $sql_precio);
                            if (mysqli_num_rows($result_precio)) {
                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                    $costre = $row_precio[0];
                                    $costpr = $row_precio[1];
                                    $pcostouni = $row_precio[2];
                                    $margene = $row_precio[3];
                                    $pblister = $row_precio[4];
                                    $preblister = $row_precio[5];
                                    $prevtaMain = $row_precio[6];
                                    $preuniMain = $row_precio[7];
                                    $prevta = $row_precio[6];
                                    $preuni = $row_precio[7];
                                }
                            }
                        }
                        //**CONFIGPRECIOS_PRODUCTO**//
                        if (($prevta == "") || ($prevta == 0)) {
                            $prevta = $prevtaMain;
                        }
                        if (($preuni == "") || ($preuni == 0)) {
                            $preuni = $preuniMain;
                        }

                        //**FIN_CONFIGPRECIOS_PRODUCTO**//

                        if (strlen($pblister) == 0) {
                            $pblister = 0;
                        }
                        if (strlen($preblister) == 0) {
                            $preblister = 0;
                        }

                        $sql1 = "SELECT desprod FROM ventas_bonif_unid inner join producto on ventas_bonif_unid.codpro = producto.codpro where producto.codpro = '$codpro' and unid <> 0 order by codkey asc limit 1";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $desprod_bonif = $row1['desprod'];
                            }
                            $bonif = 1;
                        } else {
                            $bonif = 0;
                        }

                        $sql1 = "SELECT codpro FROM temp_venta where codpro = '$codpro' and invnum = '$venta'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $control = 1;
                        } else {
                            $control = 0;
                        }


                        // $convert = $cant_loc_add / $factor;
                        // $div = floor($convert);
                        // $mult = $factor * $div;
                        // $tot = $cant_loc_add - $mult;
                        // if ($preuni > 0) {
                        // } else {
                        //     if ($factor <> 0) {
                        //         $preuni = ($prevta / $factor);
                        //     }
                        // }

                        if ($factor > 1) {
                            $convert1 = $cant_loc_add / $factor;
                            $caja = ((int) ($convert1));
                            $unidad = ($cant_loc_add - ($caja * $factor));
                            $stocknuevo = "<b>C</b>" . $caja . "<b> + F</b>" . $unidad;
                        } else {
                            $convert1 = $cant_loc_add / $factor;
                            $caja = ((int) ($convert1));

                            $stocknuevo = "<b>C </b>" .  $caja;
                        }


                        // if ($ventaalcosto == 1) {
                        //     if ($nomlocalG == "LOCAL0") {
                        //         if ($unidad_normal == 0) {
                        //             $prevta = $costre * (1 + 5 / 100);
                        //             $preuni = $prevta / $factor;
                        //         } else {
                        //             $prevta = $costre * (1 + $unidad_normal / 100);
                        //             $preuni = $prevta / $factor;
                        //         }
                        //     }
                        // }

                        $preunit = number_format($preuni, 3, '.', ' ');

                        $sql = "SELECT ventablister FROM datagen";
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            if ($row = mysqli_fetch_array($result)) {
                                $ventablister = $row['ventablister'];
                            }
                        }
                    ?>
                        <tr>

                            <td align="center">
                                <font color="#006699" size="4"><?php echo $i ?></font>
                            </td>
                            <td title="Su factor es <?php echo $factor; ?>">
                                <font color="#006699" size="3"><?php
                                                                if ($bonif == 1) {
                                                                    echo substr($desprod, 0, $charact);
                                                                    echo " ";
                                                                    if (($recetaMedica == 1)) {
                                                                        echo "<blink> - RECETA MEDICA -</blink>";
                                                                    }
                                                                    echo " + (B) x CAJA ";
                                                                    echo substr($desprod_bonif, 0, $charactbonif);
                                                                } else {
                                                                    echo substr($desprod, 0, $charact);
                                                                    echo "...";
                                                                }
                                                                ?></font>
                            </td>


                            <td>
                                <b>
                                    <font color="#006699" size="4">
                                        <div align="center">
                                            <?php echo $factor; ?>
                                        </div>
                                    </font>
                                </b>
                            </td>
                            <td>
                                <div align="center"><b>
                                        <font color="<?php if ($cant_loc_add == 0) { ?>#FF0000<?php } else { ?>#006699<?php } ?>" size="4">
                                            <?php echo $stocknuevo ?>
                                        </font>
                                    </b></div>
                            </td>
                            <td>
                                <b>
                                    <font color="#006699" size="4">
                                        <div align="center">
                                            <?php echo $prevta; ?>
                                        </div>
                                    </font>
                                </b>
                            </td>

                            <td align="center">
                                <b>
                                    <font color="#006699" size="4">
                                        <?php echo $pblister . ">&nbsp;" . $preblister; ?>
                                    </font>
                                </b>
                            </td>

                            <!--AQUI SE INGRESA EL PRECIO-->
                            <td>
                                <label>
                                    <div align="center">
                                        <?php if ($control == 0) { ?>
                                            <input name="text2" type="hidden" id="text2" value="<?php echo $preuni; ?>" />
                                            <input name="textprevta" type="hidden" id="textprevta" value="<?php echo $prevta; ?>" />
                                            <input name="text222" type="text" class="cant" id="text222" value="<?php echo $preuni; ?>" size="4" onkeyup="precio1();" onkeypress="return letraent(event);" <?php
                                                                                                                                                                                                            if ($priceditable == 1) {
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                if ($controleditable == 1) {
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                            ?>readonly onclick="blur()" <?php
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                        ?> />
                                        <?php
                                        } else {
                                        ?>
                                            <font color="#006699" size="4"><?php
                                                                            echo '<b>';
                                                                            echo $preuni;
                                                                            echo '</b>';
                                                                            ?></font>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </label>
                            </td>
                            <!--AQUI SE INGRESA LA CANTIDAD-->
                            <td>
                                <div align="center">
                                    <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni; ?>" />
                                    <input type="hidden" name="numero" id="numero" />
                                    <input type="hidden" name="codpro" id="codpro" value="<?php echo $codpro; ?>" />
                                    <input type="hidden" name="factor" id="factor" value="<?php echo $factor; ?>" />
                                    <input type="hidden" name="cant_prod" id="cant_prod" value="<?php echo $cant_loc_add; ?>" />
                                    <input name="pblister" type="hidden" id="pblister" value="<?php echo $pblister; ?>" />
                                    <input name="preblister" type="hidden" id="preblister" value="<?php echo $preblister; ?>" />
                                    <input name="ventablister" type="hidden" id="ventablister" value="<?php echo $ventablister; ?>" />
                                    <input name="typpe" type="hidden" id="typpe" value="<?php echo $typpe; ?>" />
                                    <input name="add" type="hidden" id="add" value="<?php echo $add; ?>" />



                                    <?php if ($control == 0) { ?>
                                        <input name="text1" type="text" class="cant" id="text1" onkeypress="return letracc(event);" onkeyup="precio();" size="4" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                            <td bgcolor="#FFFF99">
                                <div align="center">
                                    <?php if ($control == 0) { ?>
                                        <input name="text333" type="text" class="cant1" id="text333" onclick="blur()" size="4" disabled="disabled" />
                                        <input type="hidden" name="text3" id="text3" value="" />
                                        <input name="medico" type="hidden" id="medico" value="<?php echo $nommedico2; ?>" />
                                    <?php }
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <?php if ($cant_loc_add <= 0) { ?>
                            <tr>
                                <td width="100%" colspan='8' align="center">
                                    <a style='color:#ff5733;font-size:17px;font-weight: bold;text-align: justify;'>
                                        <blink> <strong>EL PRODUCTO SELECCIONADO NO CUENTA CON STOCK, DIGITE LA CANTIDAD SOLICITADA PARA QUE SE GUARDE EN EL REPORTE DE FALTANTES. &nbsp; &nbsp; &nbsp;(NO SE ADICIONARA EL PRODUCTO A LA VENTA)</strong></blink>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                    <?php
                        ++$i;
                    }
                    ?>

                </table>


            <?php
            } else {
            ?>


                <br><br>
                <span class="text_combo_select"><u>NO SE LOGRO ENCONTRAR NINGUN PODUCTO CON LA DESCRIPCION INGRESADA</u></span>


        <?php
            }
        }
        ?>
        <iframe src="venta_index3.php" name="index2" width="100%" height="300" scrolling="Automatic" frameborder="0" id="index2" allowtransparency="0">
        </iframe>

        <div style="margin-top: 10px">
            <div>
                <img src="../../../images/line2.png" width="100%" height="4" />
            </div>

            <table width="100%" border="0">
                <tr>
                    <td width="17%">
                        <div align="center">
                            <strong>MONTO BRUTO : </strong><input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' '); //echo $numero_formato_frances = number_format($mont_bruto, 2, '.', ' ');                                                               
                                                                                                                                                                                        ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>
                    <td width="17%">
                        <div align="center">
                            <strong>ICBPER : </strong><input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo  $numero_formato_frances = number_format($icbper_total, 2, '.', ' ');
                                                                                                                                                                                    ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>

                    <td width="17%">
                        <div align="center">
                            <strong>DCTO : </strong><input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo 0 //echo $numero_formato_frances = number_format($total_des, 2, '.', ' ');                                                               
                                                                                                                                                                                    ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>

                    <td width="17%">
                        <div align="center">
                            <strong>V. VENTA : </strong><input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($valor_vent1, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>
                    <td width="17%">
                        <div align="center">
                            <strong>IGV : </strong><input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($sum_igv, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>
                    <td width="17%">
                        <div align="center">
                            <strong>NETO : </strong><input name="mont5" class="monto_tot" type="text" id="mont5" onclick="blur()" size="8" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
                        </div>
                    </td>
                </tr>
            </table>

            <div>
                <img src="../../../images/line2.png" width="100%" height="4" />
            </div>
        </div>
    </form>
    <?php
    /* mysqli_free_result($result);
                                  mysqli_free_result($result1);
                                  mysqli_close($conexion); */
    mysqli_close($conexion);
    ?>
</body>

</html>