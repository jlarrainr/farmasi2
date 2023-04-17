<?php
include('../../session_user.php');
require_once('../../../conexion.php');
$invnum = $_SESSION['compras'];
////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql = "SELECT numdoc FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $numdoc    = $row['numdoc'];
    }
}
?>
<style>
    .H1 {
        color: red;
    }
</style>
<script language="JavaScript">
    function mensaje(valortext) {
        // onfocus="mensaje(1)"
        var valortext;
        if (valortext == 1) {
            document.getElementById("pasos").innerHTML = 'ejm: para una caja: 1,para 50 unidades: f50, si la cantidad a ingresar es una caja mas fracciones colocar el total en unidades.';
        } else if (valortext == 2) {
            document.getElementById("pasos").innerHTML = 'Colocar el costo de la caja o entero, si ingresa fracciones colocar el costo de cada fraccion(unidad)';
        } else if (valortext == 3) {
            document.getElementById("pasos").innerHTML = 'Si en la factura aparece algun desc, los descuentos son asignados en %, ejm: en la factura de compra figura 10%, colocar el numero 10 indicara que tiene un desc del 10% sobre el costo de compra';
        } else if (valortext == 4) {
            document.getElementById("pasos").innerHTML = 'Si en la factura aparece algun desc, los descuentos son asignados en %, ejm: en la factura de compra figura 10%, colocar el numero 10 indicara que tiene un desc del 10% sobre el costo de compra';
        } else if (valortext == 5) {
            document.getElementById("pasos").innerHTML = 'Si en la factura aparece algun desc, los descuentos son asignados en %, ejm: en la factura de compra figura 10%, colocar el numero 10 indicara que tiene un desc del 10% sobre el costo de compra';
        } else if (valortext == 6) {
            document.getElementById("pasos").innerHTML = '"Aqui se coloca el nuevo precio de venta de la caja, se calculara automaticamente el margen de utilidad en las opciones anteriores ';
        } else if (valortext == 7) {
            document.getElementById("pasos").innerHTML = 'Aqui se coloca el nuevo precio de venta de la unidad o fraccion, se calculara automaticamente el margen de utilidad en las opciones anteriores ';
        } else if (valortext == 8) {
            document.getElementById("pasos").innerHTML = 'SI DESEA COLOCAR UN PRECIO DE VENTA EN CONCRETO SALTAR ESTAS DOS OPCIONES, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, colocar el margen de utilidad que se desea ganar en relacion al costo de la caja, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la caja. ';
        } else if (valortext == 9) {
            document.getElementById("pasos").innerHTML = 'SI DESEA COLOCAR UN PRECIO DE VENTA EN CONCRETO SALTAR ESTAS DOS OPCIONES, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, colocar el margen de utilidad que se desea ganar en relacion al costo de la unidad, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la unidad.';
        } else if (valortext == 10) {
            document.getElementById("pasos").innerHTML = 'Aquí se coloca el número de lote del producto.';
        } else if (valortext == 11) {
            document.getElementById("pasos").innerHTML = 'Aquí se coloca la fecha de vencimiento del producto el mes  ';
        } else if (valortext == 12) {
            document.getElementById("pasos").innerHTML = 'Aquí se coloca la fecha de vencimiento del producto el año. ';
        } else if (valortext == 13) {
            document.getElementById("pasos").innerHTML = 'Colocar el numero del total de unidades que contiene un blister';
        } else if (valortext == 14) {
            document.getElementById("pasos").innerHTML = 'No confundir, no es el precio total del blister, aquí se coloca el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. ';
        } else if (valortext == 15) {
            document.getElementById("pasos").innerHTML = 'Colocar la cantidad del stock minimo solo en cajas o enteros.  <a href="../../archivo/stockminsinest/stockmin.php" target="_blank"> Ver reporte de stock minimo </a>';
        } else if (valortext == 16) {
            document.getElementById("pasos").innerHTML = 'Colocar registro sanitario.';
        } else if (valortext == 17) {
            document.getElementById("pasos").innerHTML = 'Colocar codigo DIGEMID';
        }
    }

    function mensaje_error() {
        ventana = confirm('Este numero de documento ya fue grabado, recuerde que no puede abrir el mismo modulo en otra pestaña o computador al mismo tiempo con el mismo usuario, esta lista no sera registrada');
        if (ventana) {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            // f.action = "../ventas/logout.php";
            f.action = "compras1_del.php";
            f.submit();
        } else {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            // f.action = "../ventas/logout.php";
            f.action = "compras1_del.php";
            f.submit();
        }
    }

    function compras11(e) {
        tecla = e.keyCode;
        /////F9 grabar compra/////
        if (tecla == 120) {
            var count2 = document.form1.carcount.value; //$count1 
            if (count2 > 0) {
                var f = document.form1;
                if (f.combo_zone1.value == 0) {
                    alert("Seleccione un Proveedor");
                    f.combo_zone1.focus();
                    return;
                }
                if (f.date1.value == "") {
                    alert("Ingrese la Fecha del Documento");
                    f.date1.focus();
                    return;
                }
                if (f.n1.value == "") {
                    alert("Ingrese el Nro del Documento");
                    f.n1.focus();
                    return;
                }
                if (f.n2.value == "") {
                    alert("Ingrese el Nro del Documento");
                    f.n2.focus();
                    return;
                }
                if (f.fpago.value == "") {
                    alert("Ingrese el tipo de Pago");
                    f.fpago.focus();
                    return;
                }
                if (f.plazo.value == "") {
                    alert("Ingrese el plazo");
                    f.plazo.focus();
                    return;
                }
                if (f.date2.value == "") {
                    alert("Ingrese la Fecha de Vencimiento");
                    f.date2.focus();
                    return;
                }
                if ((f.mont5.value == "") || (f.mont5.value == "0.00")) {
                    alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                    f.mont5.focus();
                    return;
                }
                ventana = confirm("Desea Grabar estos datos");
                if (ventana) {
                    alert("EL NUMERO REGISTRADO ES <?php echo $numdoc ?>");
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "compras1_reg.php";
                    f.submit();
                }

            } else {
                alert('no11111112');
            }
        }
    }


    function compras22(e) {
        tecla = e.keyCode;
        /////F9 grabar compra/////
        if (tecla == 120) {
            var count2 = document.form1.carcount.value; //$count1 
            if (count2 > 0) {
                ventana = confirm("Desea Grabar estos datos f9");
                if (ventana) {
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "compras1_reg.php";
                    f.submit();
                }

            } else {
                //alert("sdfsd")
            }

        }
    }

    var statSend = false;

    function grabar1() {
        if (!statSend) {
            var f = document.form1;
            if (f.combo_zone1.value == 0) {
                alert("Seleccione un Proveedor");
                f.combo_zone1.focus();
                return;
            }
            if (f.date1.value == "") {
                alert("Ingrese la Fecha del Documento");
                f.date1.focus();
                return;
            }
            if (f.n1.value == "") {
                alert("Ingrese el Nro del Documento");
                f.n1.focus();
                return;
            }
            if (f.n2.value == "") {
                alert("Ingrese el Nro del Documento");
                f.n2.focus();
                return;
            }
            if (f.fpago.value == "") {
                alert("Ingrese el tipo de Pago");
                f.fpago.focus();
                return;
            }
            if (f.plazo.value == "") {
                alert("Ingrese el plazo");
                f.plazo.focus();
                return;
            }
            if (f.date2.value == "") {
                alert("Ingrese la Fecha de Vencimiento");
                f.date2.focus();
                return;
            }
            if ((f.mont5.value == "") || (f.mont5.value == "0.00")) {
                alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                f.mont5.focus();
                return;
            }

            // if ((f.valida_igv.value == "")) {

            //     if ((f.dinafecto.value == "") || (f.dinafecto.value == "0.00")) {
            //         alert("Ingrese la cantidad del inafecto del documento");
            //         f.dinafecto.focus();
            //         return;
            //     }
            //     if ((f.dtotal.value == "") || (f.dtotal.value == "0.00")) {
            //         alert("Ingrese la cantidad del TOTAL del documento");
            //         f.dtotal.focus();
            //         return;
            //     }
            // } else {

            ////igv inafecto visar////

            if ((f.dafecto.value == "") || (f.dafecto.value == "0.00")) {
                alert("Ingrese la cantidad de afecto del documento");
                f.dafecto.focus();
                return;
            }
            if ((f.digv.value == "") && (f.dinafecto.value == "")) {
                alert("Tiene que ingresar la cantidad de Inafecto o IGV");
                f.digv.focus();
                return;
            }
            if ((f.digv.value == "0.00") && (f.dinafecto.value == "0.00")) {
                alert("Tiene que ingresar la cantidad de Inafecto o IGV");
                f.digv.focus();
                return;
            }
            if ((f.digv.value == "0.00") && (f.dinafecto.value == "")) {
                alert("Tiene que ingresar la cantidad de Inafecto o IGV");
                f.digv.focus();
                return;
            }
            if ((f.digv.value == "") && (f.dinafecto.value == "0.00")) {
                alert("Tiene que ingresar la cantidad de Inafecto o IGV");
                f.digv.focus();
                return;
            }



            if ((f.dtotal.value == "") || (f.dtotal.value == "0.00")) {
                alert("Ingrese la cantidad del TOTAL del documento");
                f.dtotal.focus();
                return;
            }
            // }

            ventana = confirm("Desea Grabar estos datos");
            if (ventana) {
                alert("EL NUMERO REGISTRADO ES <?php echo $numdoc ?>");
                f.method = "POST";
                f.target = "_top";
                f.action = "compras1_reg.php";
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

    function cancelar() {
        var count2 = document.form1.carcount.value; //$count1 
        if (count2 > 0) {


            alertify
                .confirm("<h1 style='color:red;font-family:Arial, Helvetica;font-size:60px;'><strong><center>CUIDADO</center></strong></h1>", "<h3 style='font-family:Arial, Helvetica;font-size:20px;margin-top: -55px;'> Esta intentando salir de compras, se eliminara la lista cargada y no podrá ser recuperada.<br><br>¿Estas seguro que desea salir?</h3>",
                    function() {
                        alertify.success('Ok')

                        var f = document.form1;
                        f.method = "POST";
                        f.target = "_top";
                        f.action = "compras1_del.php";
                        f.submit();
                    },
                    function() {
                        alertify.error('Cancel')
                    }).set('labels', {
                    ok: 'SI',
                    cancel: 'NO'
                });


        } else {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "compras1_del.php";
            f.submit();
        }

    }

    function producto() {


        window.open("mov_prod.php", "PRODUCTOS", "toolbar=yes,scrollbars=yes,resizable=yes, width=1250,height=620");
    }

    function proveedor() {

        window.open("mov_proveedor.php", "PRODUCTOS", "toolbar=yes,scrollbars=yes,resizable=yes, width=1250,height=620");

    }

    function validar_prod() {
        var f = document.form1;
        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var valor = isNaN(v1);
        if (valor == true) {
            document.form1.number.value = 1; ////avisa que no es numero
        } else {
            document.form1.number.value = 0; ////avisa que es numero
        }
        if ((f.text1.value == "") || (f.text1.value == "0")) {
            alert("Ingrese una Cantidad");
            f.text1.focus();
            return;
        }
        if ((f.text2.value == "") || (f.text2.value == "0.00")) {
            alert("Ingrese el Precio");
            f.text2.focus();
            return;
        }
        //VENTANA QUE CONFIRMA SI GRABO O NO?
        f.method = "POST";
        f.target = "comp_principal";
        f.action = "compras4.php";
        f.submit();
    }

    function validar_grid() {
        var f = document.form1;
        f.method = "POST";
        f.action = "compras3.php";
        f.submit();
    }

    function buscar() {
        var f = document.form1;
        if (f.textos.value == "") {
            alert("Ingrese un Numero de Documento");
            f.textos.focus();
            return;
        }
        f.method = "POST";
        f.target = "_top";
        f.action = "compras1_session.php";
        f.submit();
    }


    //AGregado para pruebas de bonificados Jesus 27 de enero eliminar si da fallos

    function calcularPecioBonificado() {


        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var factor = parseFloat(document.form1.factor.value); //CANTIDAD
        var qtyprfYaExistente = parseFloat(document.form1.qtyprfYaExistente.value); //CANTIDAD
        var costprYaExistente = parseFloat(document.form1.costprYaExistente.value); //CANTIDAD
        var qtyproYaExistente = parseFloat(document.form1.qtyproYaExistente.value); //CANTIDAD
        var bonifi = parseFloat(document.form1.bonifi.value); //CANTIDAD
        var stockpro = parseFloat(document.form1.stockpro.value); //CANTIDAD

        console.log('qtyprfYaExistente = ', qtyprfYaExistente);
        console.log('qtyproYaExistente = ', qtyproYaExistente);

        if (bonifi == 1) {


            //var valor1 = isNaN(qtyprfYaExistente);
            if (qtyproYaExistente == 0) {

                var text1EnteroPrimerR = document.form1.qtyprfYaExistente.value.substring(1);
                var valorEnteroPrimerR = parseFloat(text1EnteroPrimerR);

                console.log('Factor');

            } else {

                var text1EnteroPrimerR1 = document.form1.qtyproYaExistente.value;
                var valorEnteroPrimerR = parseFloat(text1EnteroPrimerR1 * factor);

                console.log('entero');
            }



            console.log('valorEnteroPrimerR = ', valorEnteroPrimerR);
            var valor = isNaN(v1);
            if (valor == true) {

                var text1Entero = document.form1.text1.value.substring(1);
                var valorEntero = parseFloat(text1Entero);

                var porcion = document.form1.text1.value.substring(1);
                var fact = parseFloat(porcion);


                console.log('valorEnterovalorEnterovalorEntero = ', fact);


                var promedio = ((((stockpro + valorEnteroPrimerR) * costprYaExistente)) / ((stockpro + valorEnteroPrimerR + fact)));

            } else {

                var valorEntero1 = document.form1.text1.value;
                var valorEntero = parseFloat(valorEntero1 * factor);
                var promedio = ((((stockpro + valorEnteroPrimerR) / factor) * costprYaExistente)) / (((stockpro + valorEnteroPrimerR + valorEntero) / factor));


            }

            document.getElementById("informacion").innerHTML = Math.round(promedio * Math.pow(10, 2)) / Math.pow(10, 2);

            // document.form1.valorTomado.value =Math.round(promedio * Math.pow(10, 2)) / Math.pow(10, 2);   

            //console.log('text1 = ' , text1);
            console.log('promedio = ', promedio);
            //console.log('stockpro = ' , stockpro);
            //console.log('factor = ' , factor);
            //console.log('valorEntero = ' , valorEntero);
            //console.log('qtyprfYaExistente = ' , qtyprfYaExistente);
            //console.log('costprYaExistente = ' , costprYaExistente);
            //console.log('qtyproYaExistente = ' , qtyproYaExistente);
            //console.log('bonifi = ' , bonifi);

        } else {
            document.getElementById("informacion").innerHTML = "";
        }


    }


    //Hasta aca fue lo agregado

    function precio() {
        var ckigv = "<?php echo $ckigv; ?>";
        //console.log(document.form1.porcentaje.value);
        //console.log(ckigv);
        if (document.form1.text3.value == "") {
            document.form1.text3.value = 0;
        }
        if (document.form1.text4.value == "") {
            document.form1.text4.value = 0;
        }
        if (document.form1.text5.value == "") {
            document.form1.text5.value = 0;
        }
        /* var icbper = parseFloat(document.form1.icbper.value); //CANTIDAD
         
         if(icbper !=1){
             if(icbper == 1){
                 ckigv=1;
             }else{
                 ckigv=0;
             }
         }
         */
        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var v2 = parseFloat(document.form1.text2.value); //PRECIO
        var v3 = parseFloat(document.form1.text3.value); //DESCUENTO1
        var v4 = parseFloat(document.form1.text4.value); //DESCUENTO2
        var v5 = parseFloat(document.form1.text5.value); //DESCUENTO3
        var factor = parseFloat(document.form1.factor.value); //FACTOR
        var stock = parseFloat(document.form1.stockpro.value); //STOCK ACTUAL
        var p = parseFloat(document.form1.porcentaje.value); //PORCENTAJE
        //nuevo
        var prevta = parseFloat(document.form1.prevta.value); //FACTOR
        var costpr = parseFloat(document.form1.costpr.value); //FACTOR
        var utldmin = parseFloat(document.form1.utldmin.value); //FACTOR
        var PrecioP = parseFloat(document.form1.PrecioPrint.value); //FACTOR
        var price2P = parseFloat(document.form1.tprevta.value); //precio caja
        var price3P = parseFloat(document.form1.preunin.value); // precio unidad
        var preblisterP = parseFloat(document.form1.tpreblister.value); //FACTOR
        var margenunidad = parseFloat(document.form1.priceU.value); //margen unidad

        var a;
        var b;
        var c;
        var pventa;
        var total;
        var porcent;
        var promedio;
        a = parseFloat(1 - (v3 / 100));
        b = parseFloat(1 - (v4 / 100));
        c = parseFloat(1 - (v5 / 100));
        if (ckigv !== "1" && document.form1.porcentaje.value !== "") {
            porcent = parseFloat(1 + (p / 100));
            pventa = parseFloat(v2 * (a * b * c) * porcent);
            //pventa = parseFloat(v2 * (a) * porcent);
            pventa = pventa.toFixed(2);

        } else {
            porcent = 1;
            pventa = parseFloat(v2 * (a * b * c) * porcent);
            //pventa = parseFloat(v2 * (a) * porcent);
        }
        pventa = Math.round(pventa * Math.pow(10, 3)) / Math.pow(10, 3);

        var valor = isNaN(v1);
        if (valor == true) {





            //  document.getElementById("sugerencia").innerHTML = precioRefencial;

            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);
            var fact = parseFloat(porcion);

            //	pventa2 =v2 *factor;
            pventa2 = pventa * factor;
            total = parseFloat(fact * pventa);
            document.form1.number.value = 1; ////avisa que no es numero

            if ((prevta > 0) && (costpr > 0)) {



                price2x = ((prevta / costpr) * pventa2);
                price3x = (price2x / factor);

                /*margenblister= Math.round(price3x / preblisterP * 100, 2) - 100;
                 porcentablister = (1 + (margenblister / 100))
                 
                 bliste1 = (price3x * porcentablister);
                 bliste2 = bliste1 -price3x;
                 
                 bliste2 = Math.round(bliste2 * Math.pow(10, 3)) / Math.pow(10, 3);
                 
                 if ((document.form1.text1.value != '') && (document.form1.text2.value != '')) {
                 
                 document.form1.p3.value = bliste2;
                 
                 }*/

            } else {

                porcentajeunidad = parseFloat(1 + (utldmin / 100));
                price3x = parseFloat((pventa / factor) * utldmin);


                price2x1 = ((pventa2 * utldmin) / 100);
                price2x = (pventa2 + price2x1);
                //price3x = (price2x / factor);

                /*margenblister= Math.round(price3x / preblisterP * 100, 2) - 100;
                 porcentablister = (1 + (margenblister / 100))
                 
                 bliste1 = (price3x * porcentablister);
                 bliste2 = bliste1 -price3x;
                 
                 bliste2 = Math.round(bliste2 * Math.pow(10, 3)) / Math.pow(10, 3);
                 
                 if ((document.form1.text1.value != '') && (document.form1.text2.value != '')) {
                 
                 document.form1.p3.value = bliste2;
                 
                 }
                 
                 */

            }

        } else {
            total = parseFloat(v1 * pventa);
            document.form1.number.value = 0; ////avisa que es numero



            if ((prevta > 0) && (costpr > 0)) {

                margen100 = Math.round(v2 / PrecioP * 100, 2) - 100;

                if (margen100 == 100) {

                    porcenta = (1 + (margen100 / 100))

                    price2x = (price2P * porcenta);
                    price3x = (price3P * porcenta);
                    preblisterPx = (preblisterP * porcenta);


                    if ((document.form1.text1.value != '') && (document.form1.text2.value != '')) {
                        //                        document.form1.price1.value = price2x;
                        //                        document.form1.priceU.value = price3x;

                        if (factor > 1) {
                            document.form1.p3.value = preblisterPx;
                        }
                    }

                } else {
                    //                    document.form1.price1.value = price2P;
                    //                    document.form1.priceU.value = price3P;

                    if (factor > 1) {
                        document.form1.p3.value = preblisterP;
                    }
                    price2x = ((prevta / costpr) * pventa);

                    porcentajeunidad = parseFloat(1 + (margenunidad / 100));
                    price3x = parseFloat((pventa / factor) * porcentajeunidad);


                    //price3x = (price2x / factor);





                }

            } else {



                price2x1 = ((pventa * utldmin) / 100);
                price2x = (pventa + price2x1);

                porcentajeunidad = parseFloat(1 + (margenunidad / 100));
                price3x = parseFloat(pventa * porcentajeunidad);


                // price3x = (price2x / factor);

            }
        }





        price2x = Math.round(price2x * Math.pow(10, 2)) / Math.pow(10, 2);
        price3x = Math.round(price3x * Math.pow(10, 3)) / Math.pow(10, 3);

        total = Math.round(total * Math.pow(10, 3)) / Math.pow(10, 3);
        if (document.form1.text1.value != '' && document.form1.text2.value != '') {

            document.form1.text6.value = pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);

            //		document.form1.price.value=pventa;
            document.form1.text7.value = total;

            document.form1.price2.value = price2x;
            document.form1.price3.value = price3x;


        } else {
            document.form1.text6.value = '';
            document.form1.text7.value = '';
            //                document.form1.price.value='';
            //            document.form1.price2.value = '';
            //            document.form1.price3.value = '';
        }



    }

    function sf() {
        document.form1.price1.focus();
        var f = document.form1;
        var v1 = parseFloat(document.form1.text6.value); //precio
        var v2 = parseFloat(document.form1.price1.value); //margen
        var v3 = parseFloat(document.form1.factor.value); //factor
        if (document.form1.price1.value === "") {
            document.form1.price1.value = 0;
            v2 = 0;
        }
        a = parseFloat(1 + (v2 / 100));
        pventa = parseFloat(v1 * a);
        pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
        //pventaunit      = parseFloat(pventa / v3);
        //pventaunit      = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 
        f.price2.value = pventa;
        f.price3.value = pventaunit;
    }

    function recomendacion() {
        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var factor = parseFloat(document.form1.factor.value); //FACTOR
        var costoCaja = parseFloat(document.form1.costoCaja.value); //margen unidad

        var valor = isNaN(v1);
        if (valor == true) {


            if (costoCaja > 0) {
                var precioRefencial = (costoCaja / factor);
                precioRefencial = Math.round(precioRefencial * Math.pow(10, 2)) / Math.pow(10, 2);
                // alert('price2P = '+price2P);
                // alert('factor = '+ factor);
                alert('Se le recomienda que el costo por fraccion sea = ' + precioRefencial);
            }
        } else {
            var texto = 'COSTO CAJA';
            document.getElementById("costo").innerHTML = texto;
            document.getElementById("costo2").innerHTML = texto;
        }

    }

    function precioo() {
        var f = document.form1;
        var t1 = parseFloat(document.form1.text1.value); //precio
        var v1 = parseFloat(document.form1.text6.value); //precio
        var v2 = parseFloat(document.form1.price1.value); //margen caja
        var v3 = parseFloat(document.form1.factor.value); //factor






        if (document.form1.price1.value == "") {
            document.form1.price1.value = '';
            v2 = 0;
        }


        var valor = isNaN(t1);
        if (valor == true) {
            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);


            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat((v1 * v3) * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            //pventaunit = parseFloat(pventa / v3);
            //pventaunit = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 


        } else {
            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat(v1 * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            //pventaunit = parseFloat(pventa / v3);
            //pventaunit = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 

        }
        if (document.form1.price1.value != '') {

            f.price2.value = pventa; //precio de venta uni caja
        } else {
            f.price2.value = '';
        }
        /////
        //f.price3.value = pventaunit;                  //precio de venta uni
    }


    function precioUni() {
        var f = document.form1;
        var t1 = parseFloat(document.form1.text1.value); //precio

        var v1 = parseFloat(document.form1.text6.value); //precio
        var v2 = parseFloat(document.form1.priceU.value); //margen unidad
        var v3 = parseFloat(document.form1.factor.value); //factor
        if (document.form1.price1.value === "") {
            document.form1.price1.value = 0;
            v2 = 0;
        }

        var valor = isNaN(t1);
        if (valor == true) {

            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);

            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat((v1 * v3) * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            pventaunit = parseFloat(pventa / v3);
            pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
            //f.price2.value = pventa;
            // if $factor=1
            // {
            //             pventaunit=$tprevta ;
            // }
            f.price3.value = pventaunit; //precio de venta uni


        } else {
            a = parseFloat(1 + (v2 / 100));
            pventa = parseFloat(v1 * a);
            pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
            pventaunit = parseFloat(pventa / v3);
            pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
            //f.price2.value = pventa;
            // if $factor=1
            // {
            //             pventaunit=$tprevta ;
            // }
            f.price3.value = pventaunit; //precio de venta uni
        }
    }

    function precio1() {
        var f = document.form1;
        var t1 = parseFloat(document.form1.text1.value); //precio
        var v1 = parseFloat(document.form1.text6.value); //precio costo
        var v2 = parseFloat(document.form1.price2.value); //precio caja
        var v3 = parseFloat(document.form1.factor.value); //factor
        if (v3 === 0) {
            v3 = 1;
        }
        var rpc = 0;
        var valor = isNaN(t1);
        if (valor == true) {
            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);

            rpc = ((v2 - (v1 * v3)) / (v1 * v3)) * 100;
            rpc = Math.round(rpc * Math.pow(10, 2)) / Math.pow(10, 2);

            f.price1.value = rpc;



        } else {
            rpc = ((v2 - v1) / v1) * 100;
            rpc = Math.round(rpc * Math.pow(10, 2)) / Math.pow(10, 2);
            f.price1.value = rpc;
        }

    }



    function precioUni1() {
        var f = document.form1;
        var t1 = parseFloat(document.form1.text1.value); //precio
        var v1 = parseFloat(document.form1.text6.value); //precio costo
        var v2 = parseFloat(document.form1.price3.value); //precio unidad
        var v3 = parseFloat(document.form1.factor.value); //factor
        if (v3 === 0) {
            v3 = 1;
        }

        var valor = isNaN(t1);
        if (valor == true) {
            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);
            var rpu1 = ((v1 * v3) / v3);
            var rpu = ((v2 - rpu1) / rpu1) * 100;
            rpu = Math.round(rpu * Math.pow(10, 2)) / Math.pow(10, 2);
            f.priceU.value = rpu;

        } else {
            var rpu1 = (v1 / v3);
            var rpu = ((v2 - rpu1) / rpu1) * 100;
            rpu = Math.round(rpu * Math.pow(10, 2)) / Math.pow(10, 2);
            f.priceU.value = rpu;
        }
    }

    function consult_validar() {
        var f = document.form1;
        if (f.numero.value == "") {
            alert("Ingrese el Nro del Documento");
            f.numero.focus();
            return;
        }
        f.method = "POST";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function cancelar_consult() {
        var f = document.form1;
        ventana = confirm("Desea cancelar y salir de esta Aplicacion");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "../ing_salid.php";
            f.submit();
        }
    }

    function fc() {
        document.form1.text1.focus();
    }

    function ValidarIGV() {
        var f = document.form1;
        f.method = "post";
        f.action = "compras1.php";
        f.submit();
    }

    function searchs() {
        var f = document.form1;
        if (f.alfa1.value == "") {
            alert("Seleccione un Proveedor");
            f.alfa1.focus();
            return;
        }
        if (f.alfa1.value == 0) {
            alert("Seleccione un Proveedor");
            f.alfa1.focus();
            return;
        }
        if (f.nrocompra.value == "") {
            alert("Ingrese el Numero de la Orden de Compra");
            f.nrocompra.focus();
            return;
        }
        f.method = "post";
        f.action = "compras_busca.php";
        f.submit();
    }

    function searchs2() {
        var f = document.form1;
        if (f.alfa1.value == "") {
            alert("Seleccione un Proveedor");
            f.alfa1.focus();
            return;
        }
        /*if (f.alfa1.value == 0)
         { alert("Seleccione un Proveedoraa"); f.alfa1.focus(); return; }*/
        var prov = f.alfa1.value;
        f.DatosProveedor.value = prov;
        f.method = "post";
        f.action = "compras1.php";
        f.submit();
    }

    function carga() {
        document.form1.date1.disabled = false;
        document.form1.date2.disabled = false;
        //document.form1.moneda.disabled = false;
        document.form1.n1.disabled = false;
        document.form1.n2.disabled = false;
        document.form1.textfield3.disabled = false;
        document.form1.plazo.disabled = false;
        document.form1.fpago.disabled = false;
        document.form1.ckigv.disabled = false;
        document.form1.fpago.focus();
    }

    function carga1() {

        document.form1.date1.disabled = false;
        document.form1.date2.disabled = false;
        //document.form1.moneda.disabled = false;
        document.form1.n1.disabled = false;
        document.form1.n2.disabled = false;
        document.form1.textfield3.disabled = false;
        document.form1.plazo.disabled = false;
        document.form1.fpago.disabled = false;
        document.form1.ckigv.disabled = false;


        /*
         document.form1.date1.disabled = true;
         document.form1.date2.disabled = true;
         //document.form1.moneda.disabled = true;
         document.form1.n1.disabled = true;
         document.form1.n2.disabled = true;
         document.form1.textfield3.disabled = true;
         document.form1.plazo.disabled = true;
         document.form1.fpago.disabled = true;
         document.form1.ckigv.disabled = true;*/
        document.form1.country.focus();
    }

    function sf() {
        document.form1.first.disabled = true;
        document.form1.next.disabled = true;
        document.form1.prev.disabled = true;
        document.form1.fin.disabled = true;
        document.form1.nuevo.disabled = true;
        document.form1.modif.disabled = true;
    }

    function sssf() {
        document.form1.country.focus();
    }

    function ss() {
        document.form1.first.disabled = true;
        document.form1.next.disabled = true;
        document.form1.prev.disabled = true;
        document.form1.fin.disabled = true;
        document.form1.nuevo.disabled = true;
        document.form1.modif.disabled = true;
        alert("Falta ingresar lotes en la compra seleccionada");
    }

    function links() {
        document.getElementById('l1').focus()
    }

    function caj1() {
        document.getElementById('text1').focus()
    }
</script>