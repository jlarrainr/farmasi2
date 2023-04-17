<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('../../../conexion.php');

require_once('../../session_user.php');
require_once('session_ventas.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');

require_once('calcula_monto.php');

$venta = $_SESSION['venta'];
$UsuarioPrincipal = $_SESSION['codigo_user'];

$sql1 = "SELECT  drogueria FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $drogueria      = $row1['drogueria'];
    }
}

$sql_V = "SELECT * FROM venta where invnum = '$venta'";
$result_V = mysqli_query($conexion, $sql_V);
if (mysqli_num_rows($result_V)) {
    while ($row = mysqli_fetch_array($result_V)) {
        $usecod = $row['usecod'];
        $codmed = $row['codmed'];
        $cuscod = $row['cuscod'];
    }
}
//echo '$codmed'.$codmed."<br>";


//PARA VALIDACION DE MONTOS

//DESDE ACA 

$sqlCli = "SELECT codcli FROM cliente where  descli like '%PUBLICO EN GENERAL%'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {

        $codcli2 = $row['codcli'];
    }
}

$alertaClienteNombre = 0;
if ($monto_total >= 700) {

    if ($cuscod == $codcli2) {


        $alertaClienteNombre = '1';

        // echo '<script LANGUAGE="JavaScript">alert("El monto ingresado supera lo permitido por sunat, es necesario ingresar DNI y Nombre de Cliente");return;</script>';


    }
}

//// HASTA ACA PARTE 1

$sql_U = "SELECT * FROM usuario where usecod = '$usecod'";
$result_U = mysqli_query($conexion, $sql_U);
if (mysqli_num_rows($result_U)) {
    while ($row = mysqli_fetch_array($result_U)) {
        $codloc = $row['codloc'];
        $nomusu = $row['nomusu'];
    }
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
        //        $imprapida = $row['imprapida'];////puede ser 0 o 1 o ""
    }
}
$numero_xcompa = substr($nomloc, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);


$_SESSION['UsuarioPrincipal'] = $UsuarioPrincipal;
$CVendedor = isset($_REQUEST['CodClaveVendedor']) ? $_REQUEST['CodClaveVendedor'] : "";
$tecKey = isset($_REQUEST['tecKey']) ? $_REQUEST['tecKey'] : ""; //F8,F9

if ($CVendedor <> "") {
    $sql1 = "SELECT usecod FROM usuario where claveventa = '$CVendedor'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $CodUsuarioVendedor = $row1['usecod'];
        }
    }
    $_SESSION['codigo_user'] = $CodUsuarioVendedor;
    $usuario = $CodUsuarioVendedor;
}

mysqli_query($conexion, "UPDATE venta set usecod = '$usuario',tipteclaimpresa = '$tecKey' where invnum = '$venta'");

$stockParaVenta = true;
$descProducto = "";

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

if (!empty($arr_detalle_venta)) {

    function qd_sd($array, $campo, $campo2, $fraccion, $factor)
    {
        $nuevo = array();
        foreach ($array as $parte) {
            $clave[] = $parte[$campo];
        }
        $unico = array_unique($clave);
        $suma_campro1 = 0;
        $suma_campro2 = 0;
        $suma_campro = 0;

        foreach ($unico as $un) {
            foreach ($array as $original) {
                if ($un == $original[$campo]) {
                    if ($original[$fraccion] == "F") {
                        $suma_campro1 += $suma_campro + ($original[$campo2] * $original[$factor]);
                    } else {
                        $suma_campro2 += $suma_campro + $original[$campo2];
                    }
                    if ($original[$factor] > 1) {
                        $fraccion_asigna = 'T';
                        $factor_asigna = $original[$factor];
                    } else {
                        $fraccion_asigna = 'F';
                        $factor_asigna = $original[$factor];
                    }

                    $suma = $suma_campro1 + $suma_campro2;
                }
            }
            $ele['codpro'] = $un;
            $ele['canpro'] = $suma;
            $ele['factor'] = $factor_asigna;
            $ele['fraccion'] = $fraccion_asigna;
            array_push($nuevo, $ele);
            $suma = 0;
            $suma_campro = 0;
            $suma_campro1 = 0;
            $suma_campro2 = 0;
        }
        return $nuevo;
    }
}

$chido = qd_sd($arr_detalle_venta, 'codpro', 'canpro', 'fraccion', 'factor');
// echo '<pre>';
// print_r($chido);
// echo '</pre>';


$arrAux = array();
if (!empty($arr_detalle_venta)) {
    $contArray = 0;
    $recetaMedicaC = 0;
    while ($stockParaVenta && isset($chido[$contArray])) {
        $row = $chido[$contArray];
        $contArray++;
        $codpro     = $row['codpro'];
        $canpro     = $row['canpro'];
        $fraccion   = $row['fraccion'];
        $factor     = $row['factor'];


        if ($fraccion == "F") {
            $cantemp = $canpro * $factor;
        } else {
            $cantemp = $canpro;
        }


        $sql2 = "SELECT stopro, factor, desprod,$tabla,codpro,recetaMedica FROM producto where codpro = '$codpro'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            if ($row2 = mysqli_fetch_array($result2)) {
                $stopro = $row2['stopro'];
                $factor2 = $row2['factor'];
                $desprod = $row2['desprod'];
                $codpro = $row2['codpro'];
                $candisponible1 = $row2[3];
                $recetaMedica = $row2['recetaMedica'];


                if ($drogueria == 1) {

                    $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                    $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                    if (mysqli_num_rows($result1_movlote)) {
                        while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                            $stock_movlote = $row1_movlote[0];
                        }
                    }

                    $candisponible = $stock_movlote;
                } else {

                    $candisponible = $candisponible1;
                }




                if ($cantemp > $candisponible) {
                    $stockParaVenta = false;
                    $descProducto = $desprod;
                } else {
                    $arrAux[] = $row;
                }
            }
        }
        $recetaMedicaC += $recetaMedica;
    }
}
// echo '<pre>';
// print_r($arrAux);
// echo '</pre>';

// $_SESSION['arr_detalle_venta'] = $arrAux;
//**FIN_CONFIGPRECIOS_PRODUCTO**//

$count = 0;
$count1 = 0;
$count2 = 0;

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

foreach ($arr_detalle_venta as $row) {
    //    error_log("Codigo Venta: " . $row['invnum']);
    $invnumTemp = $row['invnum'];
    $canproTemp = $row['canpro'];
    //if ($invnumTemp ==$invnum) {
    $count++;
    if ($canproTemp == '0') {
        $count1++;
    } else {
        $count2++;
    }
    //}
    
}


//DESDE ACA parte 2


if ($alertaClienteNombre == 1) { ?>



    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }

            .LETRA {
                font-family: Tahoma;
                font-size: 11px;
                line-height: normal;
                color: '#5f5e5e';
                font-weight: bold;
            }

            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px;
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
        </style>


        <script LANGUAGE="JavaScript">
            alert("Para ventas mayores a 700 soles es necesario ingresar Documento de Identidad del Comprador.");
            window.opener.location.reload(true);
            window.close();
        </script>


    </head>

    <body>
    </body>
<?php exit;
}

//HASTA ACA


if (!$stockParaVenta) {
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }

            .LETRA {
                font-family: Tahoma;
                font-size: 11px;
                line-height: normal;
                color: '#5f5e5e';
                font-weight: bold;
            }

            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px;
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
        </style>


        <script LANGUAGE="JavaScript">
            alert("No hay suficiente stock del producto <?php echo $descProducto; ?>.");
            window.opener.location.reload(true);
            window.close();
        </script>


    </head>

    <body>
    </body>
<?php
    exit;
}

if ($count == 0) {


    $sqlXCOM = "SELECT error_venta FROM usuario where usecod = '$usuario'";
    $resultXCOM = mysqli_query($conexion, $sqlXCOM);
    if (mysqli_num_rows($resultXCOM)) {
        while ($row = mysqli_fetch_array($resultXCOM)) {
            $error_venta = $row['error_venta'];

            $error_venta_suma = $error_venta + 1;
            mysqli_query($conexion, "UPDATE usuario set error_venta = '$error_venta_suma' where usecod = '$usuario'");
        }
    }

    if ($error_venta == 0) {
        $mensaje_error_pantalla_multiples = 'USTED ESTA VENDIENDO EN DOS PANTALLAS AL MISMO TIEMPO NO ESTA PERIMITIDO ESTA FUNCION. ';
    } else {
        $mensaje_error_pantalla_multiples = 'USTED ESTA VENDIENDO EN DOS PANTALLAS AL MISMO TIEMPO NO ESTA PERIMITIDO ESTA FUNCION. LLEVA ' . $error_venta . ' INTENTO(S) CON EL MISMO PROCESO NO PERMITIDO, LLEGARA AL PUNTO EN QUE SE DESHABILITE SU USUARIO Y TENDRAN QUE COMUNICARSE CON FARMASIS PARA ACTIVARLO.GRACIAS ';
    }

?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }

            .LETRA {
                font-family: Tahoma;
                font-size: 11px;
                line-height: normal;
                color: '#5f5e5e';
                font-weight: bold;
            }

            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px;
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
        </style>


        <script LANGUAGE="JavaScript">
            alert("<?php echo $mensaje_error_pantalla_multiples; ?>");
            window.opener.location.reload(true);
            window.close();
        </script>


    </head>

    <body>
    </body>
<?php

    $to = "fallascfcsystem@gmail.com";
    $subject = "PROBLEMAS DE MULTIPLES PANTALLAS EN VENTA";
    // $message = $desemp . " esta vendiendo con multiples pantallas el usuario :" . $nomusu .;
    $message = $desemp . ' ,el usuario = ' . $nomusu . 'codigo : ' . $usuario . " ,esta vendiendo con multiples pantallas.";
    $headers = "From: www.farmasis.site" . "\r\n";
    mail($to, $subject, $message, $headers);


    exit;
}




if (($recetaMedicaC > 0) && ($codmed == 0)) {




?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }

            .LETRA {
                font-family: Tahoma;
                font-size: 11px;
                line-height: normal;
                color: '#5f5e5e';
                font-weight: bold;
            }

            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px;
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
        </style>


        <script LANGUAGE="JavaScript">
            alert("Venta autorizada solo con receta médica");
            window.opener.location.reload(true);
            window.close();
        </script>


    </head>

    <body>
    </body>
<?php
    exit;
}



if ($sum_igv < 0) { ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>IMPRESION DE VENTA</title>
        <style type="text/css">
            a:link {
                color: #666666;
            }

            a:visited {
                color: #666666;
            }

            a:hover {
                color: #666666;
            }

            a:active {
                color: #666666;
            }

            .Letras {
                font-size: <?php echo $fuente; ?>px;
            }

            .LETRA {
                font-family: Tahoma;
                font-size: 11px;
                line-height: normal;
                color: '#5f5e5e';
                font-weight: bold;
            }

            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px;
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
        </style>


        <script LANGUAGE="JavaScript">
            alert("Se ha producido un error. Favor de comunicarse con +51 985 862 693");
            window.opener.location.reload(true);
            window.close();
        </script>


    </head>

    <body>
    </body>
<?php
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <title><?php echo $desemp ?></title>
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <!--            <link href="f9/css/autocomplete.css" rel="stylesheet" type="text/css" />
                        <link href="../../archivo/css/select_cli.css" rel="stylesheet" type="text/css"/>
                      <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
                        <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
                        <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
                        <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
                        <link rel="stylesheet" href="f9/jquery-ui/jquery-ui.css" type="text/css" media="screen"/>
                        <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.autocomplete.css" type="text/css" media="screen"/>-->

    <!--            <script language="JavaScript" type="text/javascript" src="f9/jquery.js"></script>
            <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery-ui.min.js"></script>
            <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.core.js"></script>
            <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.widget.js"></script>
            <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.position.js"></script>
            <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.autocomplete.js"></script>-->
    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>
    <script type="text/javascript">
        function boletan() {
            document.getElementById("nombre_doc").innerHTML = "BOLETA DE VENTA";
            document.getElementById("nombre_doc").style.color = "#264cdb";
        }

        function ticketn() {
            document.getElementById("nombre_doc").innerHTML = "TICKET DE VENTA";
            document.getElementById("nombre_doc").style.color = "#00CC00";
        }

        function fc() {

            document.form1.country.focus();

        }

        function cerrar_popup() {
            window.close();
        }
        
        //editado adrian
        
        //var validador = true;

//editado adrian
function escapes(e) 
        {
            tecla = e.keyCode;
            
            if (tecla === 27) {
                window.close();
            }
            else if (tecla === 13) 
            {
                
                if (document.getElementById("efectivo").style.display == 'block' ) 
                {
                    var f = document.form1;
                    var monto = f.monto_total.value;
                    var paga = f.pagacon.value;
                    var vuelto;
                    if (paga !== "") {
                        vuelto = paga - monto;
                        if (vuelto < 0) 
                        {
                            alert("El monto ingresado es incorrecto");
                            
                            validador = false;
                            
                            
                            return;
                        
                        }
                        f.vueltos.value = vuelto;
                    }
                    f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
                }
                else 
                {
                    grabar();
                }
                
            }
        }

        function enter(e) {
            tecla = e.keyCode;
            if (tecla === 13) {
                var f = document.form1;
                f.pagacon.focus();
            }
        }

        function sf() {
            var f = document.form1;


            // !EDUARDO
            var forpagVentaValor = document.form1.forpagVenta.value;
            // alert(forpagVentaValor);
            if (forpagVentaValor == 'C') {
                document.getElementById("efectivo").style.display = "none";

                var f = document.form1;
                f.mulEfectivo.value = '';
                f.mulFaltante.value = '';
                f.mulTarjeta.value = '';
                //f.mulMasterCard.value = ''; //Edit Marjorie
                f.mulCanje.value = '';
                $("#tarjeta").val(0).trigger("change");
                f.numeroTarjeta.value = '';
                f.pagacon.value = '';
                f.vuelto.value = '';
            }
            f.anotacion.focus();

        }

        //editado adrian
        function calculo(event) {
            
      
            var f = document.form1;
            var monto = f.monto_total.value;
            var paga = f.pagacon.value;

            vuelt = paga - monto;
            vuelt2 = vuelt.toFixed(2);

            //alert(vuelt2);

            f.vuelto.value = vuelt2;
            
            /*if (event.keyCode !== 13) 
            {
                validador = true;
                
            }*/
                
        }

        function calculoMultiple() {
            var f = document.form1;
            var vmulCobranza = parseFloat(f.mulCobranza.value);

            var vmulEfectivo = parseFloat(f.mulEfectivo.value);
            var vmulTarjeta = parseFloat(f.mulTarjeta.value);
            //var vmulMasterCard = parseFloat(f.mulMasterCard.value);
            var vmulCanje = parseFloat(f.mulCanje.value);


            if (document.form1.mulEfectivo.value == '') {
                vmulEfectivo = 0;
            }
            if (document.form1.mulTarjeta.value == '') {
                vmulTarjeta = 0;
            }
            //Edit Marjorie
            /* if (document.form1.mulMasterCard.value == '') {
                vmulMasterCard = 0;
            }*/
            if (document.form1.mulCanje.value == '') {
                vmulCanje = 0;
            }

            // alert("vmulCobranza = " + vmulCobranza);
            // alert("vmulEfectivo = " + vmulEfectivo);
            // alert("vmulTarjeta = " + vmulTarjeta);
            // alert("vmulMasterCard = " + vmulMasterCard);
            // alert("vmulCanje = " + vmulCanje);

            //var vmonto = vmulEfectivo + vmulTarjeta + vmulMasterCard + vmulCanje;
            var vmonto = vmulEfectivo + vmulTarjeta + vmulCanje;
            vmulFaltante1 = vmulCobranza - vmonto;
            vmulFaltante = vmulFaltante1.toFixed(2);




            if (vmulFaltante < 0) {
                f.mulEfectivo.value = '';
                f.mulFaltante.value = '';
                f.mulTarjeta.value = '';
                //f.mulMasterCard.value = ''; //Edit Marjorie
                f.mulCanje.value = '';
                alert("La cantidad ingresada supera el monto a cobrar");
            } else {
                f.mulFaltante.value = vmulFaltante;
            }
        }
        //ADD Marjorie
        function calculoYapePlin() 
        {
            var f = document.form1;
            var vYPCobranza = parseFloat(f.ypCobranza.value);

            var vYPMonto = parseFloat(f.montoYapePlin.value);
            var vYPNumero = parseFloat(f.numeroYapePlin.value);

            if (document.form1.montoYapePlin.value == '') {
                vYPMonto = 0;
            }
            /*if (document.form1.numeroYapePlin.value == '') {
                vYPNumero = 0;
            }*/

            var vmonto = vYPMonto;
            vYPFaltante1 = vYPCobranza - vmonto;
            vYPFaltante = vYPFaltante1.toFixed(2);

            if (vYPFaltante < 0) {
                f.montoYapePlin.value = '';
                f.numeroYapePlin.value = '';
                alert("La cantidad ingresada supera el monto a cobrar");
            }  else {
                f.vYPFaltante.value = vYPaltante;
            }
            
            
        } //ADD Marjorie

        function grabar() {
            var f = document.form1;

            var forpagVentaValor = f.forpagVenta.value;
           
            if (forpagVentaValor == 'C') {
                f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
            }


            //Validacion Efectivo
            if (document.getElementById("efectivo").style.display == 'block') {

                var monto = f.monto_total.value;
            var paga = f.pagacon.value;
            var vuelto;
            if (paga !== "") {
                vuelto = paga - monto;
                if (vuelto < 0) {
                    alert("El monto ingresado es incorrecto");
                    return;
                }
                f.vueltos.value = vuelto;
            }
            f.action = "imprimir.php";
            f.method = "post";
            f.submit();
            }

            //Validacion Tarjeta
            //editado adrian 20-05-2022
            if (document.getElementById("debito").style.display == 'block') {

                var nroTarjeta = f.numeroTarjeta.value;
                var tarjeta = f.tarjeta.value;
                
                if (tarjeta == 0) 
                {
                    alert("Verifique los campos");
                    return;
                } else 
                {
                    f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
                }
            }

            //Validacion Multiple
            if (document.getElementById("multiple").style.display == 'block') {

                var vmulFaltante = f.mulFaltante.value;
                var vmulFaltantef = parseFloat(f.mulFaltante.value);
                if (document.form1.mulFaltante.value == '') {
                    vmulFaltantef = 0;
                }

                if (vmulFaltantef !== 0 || vmulFaltante == "") {
                    alert("Verifique el monto a pagar");
                    return;
                } else {
                    f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
                }
            }

            //Validacion YapePlin
            if (document.getElementById("yapeplin").style.display == 'block') {

                var vYPCobranza = parseFloat(f.ypCobranza.value); 
                var vYPMontof = parseFloat(f.montoYapePlin.value);
                var vYPMonto = f.montoYapePlin.value;
                var vYPNumero = f.numeroYapePlin.value;

                //|| vYPNumero == ""

                if (vYPMonto == "" ) {
                    alert("Verifique los datos ingresados");
                    return;
                }else if(vYPMontof!==vYPCobranza){
                    alert("El monto ingresado es menor que el monto a pagar");
                    return;

                }else {
                    f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
                }

            }

        }
        //                $(function ()
        //                {
        //
        //                    $("#cliente").autocomplete({
        //                        source: "f9/ajax-list-countries.php",
        //                        minLength: 2,
        //                        select: function (event, ui) {
        //                            $('#cliente_ID').val(ui.item.id);
        //                            $('#correo').val(ui.item.Mail);
        //                            $('#ruc').val(ui.item.Ruc);
        //                        }
        //                    });
        //                });
    </script>
    <?php
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once('../../../funciones/functions.php'); //DESHABILITA TECLAS
    require_once('../../../funciones/highlight.php'); //ILUMINA CAJAS DE TEXTOS
    require_once('../../../funciones/botones.php'); //COLORES DE LOS BOTONES
    //            require_once("f9/funciones/call_combo.php");
    require_once("calcula_monto.php");
    $sqlVent = "SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,sucursal,fecven,correlativo,codmed FROM venta where usecod = '$usuario' and estado ='1' and invnum = '$venta'";
    $resultVent = mysqli_query($conexion, $sqlVent);
    if (mysqli_num_rows($resultVent)) {
        while ($row = mysqli_fetch_array($resultVent)) {
            $invnum = $row['invnum'];
            $nrovent = $row['nrovent'];
            $invfec = $row['invfec'];
            $cuscod = $row['cuscod'];
            $usecod = $row['usecod'];
            $codven = $row['codven'];
            $forpag = $row['forpag'];
            $sucursal = $row['sucursal'];
            $fecven = $row['fecven'];
            $correlativo = $row['correlativo'];
            $codmed = $row['codmed'];
        }
    }

 $sqlCli = "SELECT codcli,descli,email,ruccli, dnicli,limiteCredito FROM cliente where codcli = '$cuscod'";
    $resultCli = mysqli_query($conexion, $sqlCli);
    if (mysqli_num_rows($resultCli)) {
        while ($row = mysqli_fetch_array($resultCli)) {
            $codcli = $row["codcli"];
            $descli = $row["descli"];
            $email = $row["email"];
            $ruccli = $row["ruccli"];
            $dnicli = $row["dnicli"];
            $limiteCredito = $row["limiteCredito"];
        }
    }
  
  
if ($forpag == 'C') {
    
    
   
    
    
    if ($monto_total > $limiteCredito) {
        $yaNoCredito = 1;
    } else {
        $yaNoCredito = 0;
    }
    
     //echo 'asdasdasdas'. "<br>";
}else {
        $yaNoCredito = 0;
}
  //  echo '$yaNoCredito = '.$yaNoCredito."<br>";
    
$sqlCuota = "SELECT SUM(VC.montoCobro) FROM venta_cuotas as VC INNER JOIN venta as V on V.invnum=VC.venta_id WHERE V.cuscod='$cuscod' and VC.montoCobro>0 ";
$resultCuota = mysqli_query($conexion, $sqlCuota);
if (mysqli_num_rows($resultCuota)) {
    while ($rowCuota = mysqli_fetch_array($resultCuota)) {

        $saldo_cuota = $rowCuota['0'];
    }
}

    $TicketDefecto = 0;
    $numCopias = 1;
    $sqlGen = "SELECT montoboleta,TicketDefecto,numerocopias,TicketDefectoMayorA FROM datagen"; ////por defecto 5
    $resultGen = mysqli_query($conexion, $sqlGen);
    if (mysqli_num_rows($resultGen)) {
        while ($row = mysqli_fetch_array($resultGen)) {
            $montoboleta = $row["montoboleta"];
            $TicketDefecto = $row["TicketDefecto"];
            $numCopias = $row["numerocopias"];
            $TicketDefectoMayorA = $row["TicketDefectoMayorA"];
        }
    }

    function formato($c)
    {
        printf("%08d", $c);
    }
    ?>

    <style>
        .botonimagenEfectivo {
            background-image: url(dinero.svg);
            background-repeat: no-repeat;
            height: 90px;
            width: 90px;
            background-position: center;
            color: #fff;
            font-size: 22px;
        }

        .botonimagenMultiple {
            background-image: url(tarjeta-de-credito.svg);
            background-repeat: no-repeat;
            height: 90px;
            width: 90px;
            background-position: center;
            color: #fff;
            font-size: 22px;
        }

        .botonimagenDebito {
            background-image: url(tarjeta-de-debito.png);
            background-repeat: no-repeat;
            position: relative;
            height: 90px;
            width: 90px;
            background-position: center;
            color: #fff;
            font-size: 22px;
        }

        .botonimagenYapePlin {
            background-image: url(yapeplin.png);
            background-repeat: no-repeat;
            position: relative;
            height: 90px;
            width: 90px;
            background-position: center;
            color: #fff;
            font-size: 22px;
        }
    </style>
        <script>
    
    function limpiar()
    {
        var f = document.form1;
        
        f.mulEfectivo.value = '';
        f.mulFaltante.value = '';
        f.mulTarjeta.value = '';
        
        //f.mulMasterCard.value = '';
        
        f.mulCanje.value = '';
        f.numeroTarjeta.value = '';
        $("#tarjeta").val(0).trigger("change");
        
        f.pagacon.value = '';
        f.vuelto.value = '';
        
        f.montoYapePlin.value = '';
        f.numeroYapePlin.value = '';
        f.mulEfectivo.value = '';
        f.mulTarjeta.value = '';
        f.mulCanje.value = '';
        
    }

    function alertaPago() 
    {

        alertify.alert("FARMASIS", '<h1><strong><center>Forma de pago al credito</center></strong></h1>');
        
    }

    function btnEfectivo() {
        document.getElementById("efectivo").style.display = "block";
        document.getElementById("multiple").style.display = "none";
        document.getElementById("debito").style.display = "none";
        document.getElementById("yapeplin").style.display = "none";

        var f = document.form1;

        f.pagacon.focus();
        
        limpiar();
        
    }

    function btnDebito() {
        document.getElementById("debito").style.display = "block";
        document.getElementById("multiple").style.display = "none";
        document.getElementById("efectivo").style.display = "none";
        document.getElementById("yapeplin").style.display = "none";
        
        limpiar();
        
        var f = document.form1;
        
        f.numeroTarjeta.focus();
        
    }

    function btnMultiple() {

        document.getElementById("multiple").style.display = "block";
        document.getElementById("efectivo").style.display = "none";
        document.getElementById("debito").style.display = "none";
        document.getElementById("yapeplin").style.display = "none";
        
        limpiar();
        
        var f = document.form1;
        
        f.mulEfectivo.focus();
        
    }
    //ADD Marjorie
    function btnYapePlin() {

        document.getElementById("yapeplin").style.display = "block";
        document.getElementById("multiple").style.display = "none";
        document.getElementById("efectivo").style.display = "none";
        document.getElementById("debito").style.display = "none";
        
        limpiar();
        
        var f = document.form1;

        
        //editado adrian

        f.montoYapePlin.value = f.ypCobranza.value;

        f.montoYapePlin.focus();
        
    }
</script>   
    <style type="text/css">
        h1 {
            color: #FF0000;
            font-size: 40px;
            font-weight: bold;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        h2 {
            margin-top: -40px;
        }
    </style>


<?php if($yaNoCredito == 1){?>
        <script LANGUAGE="JavaScript">
            alert("El cliente paso el limite de credito o no tiene linea de credito permitido, el documento de venta sera asignado al cliente publico en general. ");
            window.opener.location.reload(true);
            window.opener.location.href = "clienteDeudaCanceloPorLimiteCredito.php";
           // document.form1.target = "venta_principal";
            window.close();
        </script>
<?php } ?>
</head>


<body onkeyup="escapes(event)" onload="sf();">
    <table width="868" height="535" border="1">

        <tr>
            <td width="855" height="372" bgcolor="#FFFFCC">
                <table width="481" border="0" align="center">
                    <tr>
                        <td width="398">
                            <?php
                            if (!$stockParaVenta) {
                                echo "<center>
                            <font color='red' size='+2'>
                                <b>No hay suficiente stock del producto: </b></font>
                            <font color='red' size='+1'>
                                    <b>" . $descProducto . "</b></font><br />
                            <font color='red' size='+1'>
                                <b>Cantidad Actual disponible: " . $candisponible . "</b></font></center>";
                                return;
                            }
                            $FactDefecto = 0;
                            $BolDefecto = 0;
                            $TickDefecto = 0;


                            if ($TicketDefecto == 1) {
                                if (strlen($ruccli) == 11) {
                                    $FactDefecto = 1;
                                    $BolDefecto = 0;
                                    $TickDefecto = 0;
                                    $titulo = "FACTURA";
                                    $color = "#FF0000";
                                } else if ($monto_total > $TicketDefectoMayorA) {
                                    $FactDefecto = 0;
                                    $BolDefecto = 1;
                                    $TickDefecto = 0;
                                    $titulo = "BOLETA DE VENTA";
                                    $color = "#264cdb";
                                } else {
                                    $titulo = "TICKET DE VENTA";
                                    $color = "#00CC00";
                                    $FactDefecto = 0;
                                    $BolDefecto = 0;
                                    $TickDefecto = 1;
                                }
                            } else {
                                if (strlen($ruccli) == 11) {
                                    $FactDefecto = 1;
                                    $BolDefecto = 0;
                                    $TickDefecto = 0;
                                    $titulo = "FACTURA";
                                    $color = "#FF0000";
                                } else {
                                    $FactDefecto = 0;
                                    $BolDefecto = 1;
                                    $TickDefecto = 0;
                                    $titulo = "BOLETA DE VENTA";
                                    $color = "#264cdb";
                                }
                            }
                            ?>
                            <center>
                                <font color="<?php echo $color; ?>" size="+4"><b id="nombre_doc"><?php echo $titulo; ?></b></font>
                            </center>
                        </td>
                    </tr>
                </table>
                <br /><br /><br />
                <table width="512" height="204" border="0" align="center" class="tabla2">
                    <tr>
                        <td width="504">
                            <fieldset>
                                <legend> <u><strong>IMPRESION DE VENTAS </strong></u></legend>

                                <table width="494" border="0" align="center">
                                    <tr>
                                        <td width="71"><strong>N&ordm; DE VENTA</strong> </td>
                                        <td width="263"><?php echo formato($correlativo); ?></td>
                                        <td width="51" align="right"><strong>FECHA:</strong></td>
                                        <td width="91"><?php echo fecha($invfec); ?></td>
                                    </tr>
                                </table>
                                <form id="form1" name="form1">
                                    <input type="hidden" name="CVendedor" value="<?php echo $CVendedor; ?>" />
                                    <table width="494" border="0" align="center">
                                        <tr>
                                            <td valign="top">CLIENTE</td>
                                            <td valign="top">
                                                <input value="<?php echo $descli; ?>" type="text" style="width: 80%" name="cliente" id="cliente" autofocus readonly />
                                                <input name="cliente_ID" id="cliente_ID" value="<?php echo $codcli; ?>" type="hidden" />
                                                <input name="val" type="hidden" id="val" value="1" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="ruc" id="ruc" style="width: 80%" value="<?php echo $ruccli; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">OBSERVACION</td>
                                            <td>
                                                <input name="anotacion" id="anotacion" type="text" onkeypress="this.value = this.value.toUpperCase();" style="width: 80%" maxlength="20" />
                                                <input name="forpagVenta" type="hidden" id="forpagVenta" value="<?php echo $forpag; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">MAIL</td>
                                            <td>
                                                <input name="correo" id="correo" style="width: 80%" type="text" value="<?php echo $email; ?>"  />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TIPO DOCUMENTO</td>
                                            <td>
                                                <?php
                                                if (strlen($ruccli) >= 11) {
                                                ?>
                                                    <input type="radio" value="1" checked name="rd" /><span style='color:red;font-size: 18px;'><b>FACTURA DE VENTA ELECTRONICA</b></span>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="radio" value="4" name="rd" id="ticket" <?php if ($TickDefecto == 1) { ?>checked<?php } ?> onclick="ticketn();" /><label for="ticket" style='color:green;font-size: 18px;'><b>TICKET</b></label>
                                                    <input type="radio" <?php
                                                                        if ($dnicli == "") {
                                                                            echo "disabled ";
                                                                        }
                                                                        ?> value="2" name="rd" id="boleta" <?php if ($BolDefecto == 1) { ?>checked<?php } ?> onclick="boletan();" /><label for="boleta" style='color:blue;font-size: 18px;'><b>BOLETA</b></label>
                                                    <!-- <input type="radio" disabled value="1" name="rd" <?php if ($FactDefecto == 1) { ?>checked<?php } ?>/><span style='color:red;font-size: 18px;'><b>FACTURA</b></span>-->
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NUMERO DE COPIAS</td>
                                            <td>
                                                <?php for ($i = 1; $i <= $numCopias; $i++) { ?>
                                                    <input type="radio" value="<?php echo $i; ?>" name="numCopias" <?php if ($numCopias == $i) { ?>checked<?php } ?> /><span><b><?php echo $i; ?></b></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <!--<tr>
                                                    <td width="101" height="22"><div align="right"><strong>NRO DOCUMENTO</strong></div></td>
                                                    <td width="383">
                                                      <input name="factura" type="text" class="cant" id="factura" onkeypress="enter(event);" value="" size="42"/>                </td>
                                                </tr>-->
                                        <tr>
                                            <td colspan="2">
                                                <hr>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="2" cellpadding="0" cellspacing="0" align="center">
                                                <table>
                                                    <thead>
                                                        <tr>

                                                            <th>
                                                                <input class="botonimagenEfectivo" <?php if ($forpag != 'C') { ?> onclick="btnEfectivo();" <?php } else { ?>onclick="alertaPago();" <?php } ?>title="Pago a realizar en Efectivo" />
                                                            </th>
                                                            <th>
                                                                <input class="botonimagenDebito" <?php if ($forpag != 'C') { ?>onclick="btnDebito();" <?php } else { ?>onclick="alertaPago();" <?php } ?> title="Pago a realizar con tarjeta Debito" />
                                                            </th>
                                                            <th>
                                                                <input class="botonimagenMultiple" <?php if ($forpag != 'C') { ?>onclick="btnMultiple();" <?php } else { ?>onclick="alertaPago();" <?php } ?> title="Pago a realizar en Multiples pagos" />
                                                            </th>
                                                            <th>
                                                                <input class="botonimagenYapePlin" <?php if ($forpag != 'C') { ?>onclick="btnYapePlin();" <?php } else { ?>onclick="alertaPago();" <?php } ?> title="Pago a realizar en Yape o Plin" />
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div align="center"><strong> Contado</strong> </div>
                                                            </td>
                                                            <td>
                                                                <div align="center"><strong> Tarjeta</strong> </div>
                                                            </td>
                                                            <td>
                                                                <div align="center"><strong>Multiple</strong></div>
                                                            </td>
                                                            <td>
                                                                <div align="center"><strong>Yape/Plin</strong></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td align="center" colspan="2" width="100%">
                                                <div align="center" id="efectivo" style="display:block">
                                                    <fieldset>
                                                        <legend> <u><strong>Solo pago en Efectivo...</strong></u></legend>

                                                        <table width="100%" colspan="2" cellpadding="0" border="0" cellspacing="0" align="center">
                                                            <thead>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="right"><strong>cobrando </strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input name="cobrando" type="text" class="cant" id="cobrando" value="<?= $accesoDescuento == 1 ? $monto_total_descuento : $monto_total; ?>" size="10" readonly />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="22">
                                                                        <!-- //editado adrian -->
                                                                        <div align="right"><strong>Pag&oacute; con </strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input name="pagacon" type="text" class="cant" id="pagacon" onkeypress="return decimal(event)" onkeyup="calculo(event);" size="10" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="right"><strong>Vuelto</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input name="vuelto" type="text" class="cant1" id="vuelto" onkeypress="return decimal(event)" disabled="disabled" size="10" />
                                                                        <input name="monto_total" type="hidden" id="monto_total" value="<?= $accesoDescuento == 1 ? $monto_total_descuento : $monto_total; ?>" />
                                                                        <input name="vueltos" type="hidden" id="vueltos" />

                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </fieldset>
                                                </div>
                                                <!-- // • • • • •
                                                // ──────────────────────────────────────────────────────────────────────────────── -->

                                                <div align="center" id="debito" style="display:none">
                                                    <fieldset>
                                                        <legend> <u><strong>Solo pago en Debito...</strong></u></legend>

                                                        <table width="100%" colspan="2" cellpadding="1" border="0" cellspacing="1" align="center">
                                                            <thead>
                                                                <tr>
                                                                    <th><span class="LETRA">Tarjeta Debito o Credito</span></th>
                                                                    <td>
                                                                        <select name="tarjeta" id="tarjeta" style="width: 250px ;">
                                                                            <option value="0">Seleccione una Tarjeta...</option>
                                                                            <?php $sql = "SELECT * FROM tarjeta    order by nombre";
                                                                            $result = mysqli_query($conexion, $sql);
                                                                            while ($row = mysqli_fetch_array($result)) {
                                                                            ?>
                                                                                <option value="<?php echo $row['id'] ?>" <?php if ($codtab == $row['id']) { ?>selected="selected" <?php } ?>><?php echo $row['nombre'] ?></option>
                                                                            <?php }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th><span class="LETRA">Numero Tarjeta </span></th>
                                                                    <td>
                                                                        <input name="numeroTarjeta" type="text" id="numeroTarjeta" onkeypress="return enters(event);" value="<?php echo $numtarjet ?>" />
                                                                    </td>
                                                                </tr>

                                                            </thead>
                                                        </table>
                                                    </fieldset>
                                                </div>
                                                <!-- // • • • • •
                                                // ──────────────────────────────────────────────────────────────────────────────── -->

                                                <div align="center" id="multiple" style="display:none">
                                                    <fieldset>
                                                        <legend> <u><strong>Multiples Medios de Pago...</strong></u></legend>

                                                        <table width="100%" colspan="2" cellpadding="0" border="0" cellspacing="0" align="center">
                                                            <thead>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>Efectivo </strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="mulEfectivo" name="mulEfectivo" onkeypress="return decimal(event)" onkeyup="calculoMultiple();" tabindex="1" />
                                                                    </td>
                                                                    <td rowspan="4">

                                                                        <table>
                                                                            <tr>
                                                                                <th>
                                                                                    <div align="left">Cobranza:</div>
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="text" id="mulCobranza" class="cant" name="mulCobranza" onkeypress="return decimal(event)" readonly value="<?php echo $monto_total;  ?>" size="10" /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>
                                                                                    <div align="left">Faltante:</div>
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="text" id="mulFaltante" name="mulFaltante" onkeypress="return decimal(event)" readonly /></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>Tarjeta</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="mulTarjeta" name="mulTarjeta" onkeypress="return decimal(event)" onkeyup="calculoMultiple();" tabindex="2" />
                                                                    </td>
                                                                </tr>
                                                                <!-- <tr>Edit Marjorie</tr> -->
                                                                <!-- <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>MasterCard</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="mulMasterCard" name="mulMasterCard" onkeypress="return decimal(event)" onkeyup="calculoMultiple();" tabindex="3" />
                                                                    </td>
                                                                </tr>-->
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>YAPE/PLIN</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="mulCanje" name="mulCanje" onkeypress="return decimal(event)" onkeyup="calculoMultiple();" tabindex="4" />
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </fieldset>
                                                </div>
                                                <!-- <tr>ADD Marjorie</tr> -->
                                                <div align="center" id="yapeplin" style="display:none">
                                                    <fieldset>
                                                        <legend> <u><strong>Pago con Yape o Plin...</strong></u></legend>

                                                        <table width="100%" colspan="2" cellpadding="0" border="0" cellspacing="0" align="center">
                                                            <thead>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>Monto</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" id="montoYapePlin" name="montoYapePlin" onkeypress="return decimal(event)" onkeyup="calculoYapePlin();" tabindex="3" />
                                                                        <input disabled type="text" id="mypvisto" name="mypvisto" value="<?php echo $monto_total;  ?>" tabindex="3" />
                                                                    </td>
                                                                    <td rowspan="4">

                                                                        <table>
                                                                            <tr>
                                                                                <th>
                                                                                    <div align="left">Cobranza:</div>
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input  type="text" id="ypCobranza" class="cant" name="ypCobranza" onkeypress="return decimal(event)" readonly value="<?php echo $monto_total;  ?>" size="10" /></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="22">
                                                                        <div align="left"><strong>Numero</strong></div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="numeroYapePlin" name="numeroYapePlin" onkeypress="return enters(event)" value="" tabindex="4" />
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </fieldset>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="2">

                                                <input type="button" name="Submit" value="GRABAR" onclick="grabar();" class="grabar" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                        </td>
                        </fieldset>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
     //mysqli_close($conexion);
    ?>
</body>
<script type="text/javascript">
    $('#numeroCuota').select2();

    $("#tarjeta").select2({
        placeholder: "sometext",
        allowClear: false,
        tags: true
    });
</script>

</html>