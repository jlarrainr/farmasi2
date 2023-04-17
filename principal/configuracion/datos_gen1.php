<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <script type="text/javascript" language="JavaScript1.2" src="menu/stmenu.js"></script>
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'd/m/Y'
            });
            myCal = new Calendar({
                date2: 'd/m/Y'
            });

            myCal3 = new Calendar({
                date3: 'd/m/Y'
            }, {
                classes: ['i-heart-ny'],
                direction: 1
            });
        });
    </script>
    <?php
    require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once("../../funciones/calendar.php");
    require_once("funciones/datos_gen1.php"); //FUNCIONES DE ESTA VENTANA
    require_once("../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once('../../convertfecha.php');
    $date = date('d/m/Y');
    $date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
    $date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";

    // if ($date1 == "") {
    //     $fecha_muestra = $date;
    // } else {
    //     $fecha_muestra =  $date1;
    // }
    // if ($date2 == "") {
    //     $fecha_muestra2 = $date;
    // } else {
    //     $fecha_muestra2 =  $date2;
    // }
    ?>
    <style>
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

        #date1,
        #date2 {
            width: auto;
        }

        label:hover {
            font-size: 20px;
            color: royalblue;
        }
    </style>
</head>



<body>

    <script type="text/javascript">
        function A4_SI() {
            var f = document.form1;
            var radiovalue = f.formadeimpresion_SI.value;
            if (radiovalue == 1) {
                document.form1.for_continuo_SI.disabled = true;
                document.getElementById("mensaje2").innerHTML = "  DESHABILITADO";
                document.getElementById("mensaje2").style.color = "#fff";
                document.getElementById("CONTINUO").style.background = "#f51e1e"; //ROJO
            }
        }

        function A4_NO() {
            var f = document.form1;
            var radiovalue = f.formadeimpresion_NO.value;
            if (radiovalue == 0) {
                document.form1.for_continuo_SI.disabled = false;
                document.getElementById("mensaje2").innerHTML = "";
                document.getElementById("CONTINUO").style.background = "#fff"; //ROJO
            }
        }

        function continuo_SI() {
            var f = document.form1;
            var radiovalue = f.for_continuo_SI.value;
            if (radiovalue == 1) {
                document.form1.formadeimpresion_SI.disabled = true;
                document.getElementById("mensaje1").innerHTML = "  DESHABILITADO";
                document.getElementById("mensaje1").style.color = "#fff";
                document.getElementById("A4").style.background = "#f51e1e"; //ROJO
            }
        }

        function continuo_NO() {
            var f = document.form1;
            var radiovalue = f.for_continuo_NO.value;
            if (radiovalue == 0) {
                document.form1.formadeimpresion_SI.disabled = false;
                document.getElementById("mensaje1").innerHTML = "";
                document.getElementById("A4").style.background = "#FFF"; //ROJO
            }
        }

        function mensaje(valortext) {
            // onfocus="mensaje(1)"
            var valortext;
            if (valortext == 1) {
                document.getElementById("informacion1").innerHTML = 'Digite la razón social de la empresa.'
            } else if (valortext == 2) {
                document.getElementById("informacion1").innerHTML = 'Digite la direccion fiscal o principal de la empresa.'
            } else if (valortext == 3) {
                document.getElementById("informacion1").innerHTML = 'Digite el RUC de la empresa.'
            } else if (valortext == 4) {
                document.getElementById("informacion2").innerHTML = 'Porcentaje de IGV.'
            } else if (valortext == 5) {
                document.getElementById("informacion2").innerHTML = 'Se activara el modo Drogueria en todo el sistema.'
                document.getElementById("tipo").innerHTML = "TIPO DE SISTEMA (MODO DROGUERIA)";
                document.getElementById("tipo2").innerHTML = "";
            } else if (valortext == 6) {
                document.getElementById("informacion2").innerHTML = 'Se activara el modo Botica en todo el sistema.'
                document.getElementById("tipo").innerHTML = "TIPO DE SISTEMA (MODO BOTICA / FARMACIA)";
                document.getElementById("tipo2").innerHTML = "";
            } else if (valortext == 7) {
                document.getElementById("informacion4").innerHTML = 'A partir de esta fecha lo usuarios no tendran acceso al sistema.'
            } else if (valortext == 8) {
                document.getElementById("informacion4").innerHTML = 'Se mostrara las alertas de pago cada vez que inicie sesion o realiza una venta.'
            } else if (valortext == 9) {
                document.getElementById("informacion4").innerHTML = 'No se mostraran las alertas de pago.'
            } else if (valortext == 10) {
                document.getElementById("informacion4").innerHTML = 'CORTE DE SISTEMA DEFINITIVO, no permite acceder, mostrara una alerta de corte (de haber una venta en proceso, esperara concluirla para realizar el corte).'
            } else if (valortext == 11) {
                document.getElementById("informacion4").innerHTML = 'Se alertara de los productos vencidos y proximos a vencer(3 meses) cada vez que inice sesion.'
            } else if (valortext == 12) {
                document.getElementById("informacion4").innerHTML = 'No se mostraran alertas de vencimiento.'
            } else if (valortext == 13) {
                document.getElementById("informacion4").innerHTML = 'Se alertara en caso no se haya enviado los comprobantes a la SUNAT.'
            } else if (valortext == 14) {
                document.getElementById("informacion4").innerHTML = 'No se mostraran alertas de envio de comprobantes a SUNAT.'
            } else if (valortext == 15) {
                document.getElementById("informacion4").innerHTML = 'Es la cantidad de veces que fue visualizado el mensaje de alerta de pago.'
            } else if (valortext == 16) {
                document.getElementById("informacion4").innerHTML = 'Fecha de alerta masiva.'
            } else if (valortext == 17) {
                document.getElementById("informacion4").innerHTML = 'Activa alerta masiva.'
            } else if (valortext == 18) {
                document.getElementById("informacion4").innerHTML = 'Desactiva alerta masiva.'
            } else if (valortext == 19) {
                document.getElementById("informacion2").innerHTML = 'Se activaran costos y precios distintos a cada local (solo para cadenas).'
            } else if (valortext == 20) {
                document.getElementById("informacion2").innerHTML = 'Todos los costos y precios de venta son iguales para todos los locales .'
            } else if (valortext == 21) {
                document.getElementById("informacion3").innerHTML = 'Se activara el arqueo de caja al iniciar las ventas (Despues del cierre no podra realizar ninguna venta hasta el dia siguiente).'
            } else if (valortext == 22) {
                document.getElementById("informacion3").innerHTML = 'Se desactiva la opcion de arqueo de caja, no abrira ni cerrara caja.'
            } else if (valortext == 23) {
                document.getElementById("informacion3").innerHTML = 'Al grabar una venta, aparecera marcado la opcion TICKET por defecto, si la venta es mayor a la cantidad asignada en la siguiente opcion pasara a Boleta por defecto.'
            } else if (valortext == 24) {
                document.getElementById("informacion3").innerHTML = 'Al grabar una venta, aparecera BOLETA por defecto.'
            } else if (valortext == 25) {
                document.getElementById("informacion3").innerHTML = 'Se imprimira 1 comprobante de pago por defecto.'
            } else if (valortext == 26) {
                document.getElementById("informacion3").innerHTML = 'Se imprimira 2 comprobante de pago por defecto.'
            } else if (valortext == 27) {
                document.getElementById("informacion3").innerHTML = 'Se imprimira 3 comprobante de pago por defecto.'
            } else if (valortext == 28) {
                document.getElementById("informacion3").innerHTML = 'Se imprimira 4 comprobante de pago por defecto.'
            } else if (valortext == 29) {
                document.getElementById("informacion3").innerHTML = 'Las impresiones de las ventas estaran en formato A4 y ya NO para TICKETERA'
            } else if (valortext == 30) {
                document.getElementById("informacion3").innerHTML = 'Imprimira en formato TICKETERA.'
            } else if (valortext == 31) {
                document.getElementById("informacion3").innerHTML = 'PARA ACTIVAR EL FORMATO CONTINUO TIENE QUE ESTAR DESACTIVADO FORMATO A4.'
            } else if (valortext == 32) {
                document.getElementById("informacion3").innerHTML = 'Imprimira en formato para TICKETERA.'
            } else if (valortext == 33) {
                document.getElementById("informacion3").innerHTML = 'Si coloco cantidad por blister a un producto, no podra vender por cantidades inferiores.'
            } else if (valortext == 34) {
                document.getElementById("informacion3").innerHTML = 'La venta podra ser por blister y por unidades'
            } else if (valortext == 35) {
                document.getElementById("informacion3").innerHTML = 'AL ACTIVAR LA OPCION F8 PODRA GABAR SU VENTA, PERO NO PODRA ENVIAR EL COMPROBANTE A LA SUANT PORQUE NO TENDRA NUMERO DE DOCUMENTO.'
            } else if (valortext == 36) {
                document.getElementById("informacion3").innerHTML = 'NO PODRA GRABAR NINGUNA VENTA CON F8'
            } else if (valortext == 37) {
                document.getElementById("informacion3").innerHTML = 'Por cada sol de venta se acumulara la cantidad de .... punto(s) para los clientes. '
            } else if (valortext == 38) {
                document.getElementById("informacion3").innerHTML = 'A partir de este monto la opcion BOLETA estara marcada por defecto.'
            } else if (valortext == 39) {
                document.getElementById("informacion3").innerHTML = 'Los vendedores podran anular las ventas (los supervisores, administradores y vendedores con permisos especiales tambien).'
            } else if (valortext == 40) {
                document.getElementById("informacion3").innerHTML = 'Los vendedores NO PODRAN anular ninguna venta, necesitara ingresar un Administrador, Supervisor o vendedor con permisos especiales para realizarlo.'
            } else if (valortext == 41) {
                document.getElementById("informacion3").innerHTML = 'Los vendedores SI PODRAN CAMBIAR LOS PRECIOS en las ventas (los supervisores, administradores y vendedores con permisos especiales tambien ).'
            } else if (valortext == 42) {
                document.getElementById("informacion3").innerHTML = 'Los vendedores NO PODRAN CAMBIAR LOS PRECIOS en las ventas (SI los supervisores, administradores y vendedores con permisos especiales )'
            }else if (valortext == 43) {
                document.getElementById("informacion3").innerHTML = '1'
            }else if (valortext == 44) {
                document.getElementById("informacion3").innerHTML = '2'
            }else if (valortext == 45) {
                document.getElementById("informacion3").innerHTML = 'Se imprimira el codigo Hash en los comprobantes de venta'
            }else if (valortext == 46) {
                document.getElementById("informacion3").innerHTML = 'NO Se imprimira el codigo Hash en los comprobantes de venta'
            }else if (valortext == 47) {
                document.getElementById("informacion3").innerHTML = 'Los administradores del sistema no podran acceder a arqueo de caja'
            }else if (valortext == 48) {
                document.getElementById("informacion3").innerHTML = 'Los administradores del sistema si podran acceder a arqueo de caja'
            }

            // var colors = ['#00f0ff', '#51b86d', '#5183b8'];
            // var random_color = colors[Math.floor(Math.random() * colors.length)];
            // document.getElementById('informacion').style.color = random_color;
        }
    </script>
    <?php require_once("../../funciones/calendar.php"); ?>
    <div class="mask1" height="100%">
        <div class="mask2" height="100%">
            <script type="text/javascript" language="JavaScript1.2" src="menu/men.js"></script>
            <div class="mask3" height="100%">
                <br>


                <?php require_once('datos_gen1a.php'); ?>
            </div>
        </div>
    </div>
</body>

</html>