<script language="JavaScript">
    function prints(valor) {
        var valor;
        var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
        window.open("imprimir.php?cod=" + valor, "", opciones);
        return false;
    }

    function prints_salidas(valor, a, b) {
        var valor;
        //alert("hola");
        var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
        window.open("imprimir.php?cod=" + valor + "&pag=" + a + "&numero=" + b, "", opciones);
        return false;
    }

    function inic() {
        document.form1.num.focus();
        document.form1.save.disabled = true;
        document.form1.fecha1.disabled = true;
        document.form1.n1.disabled = true;
        document.form1.n2.disabled = true;
        document.form1.moneda.disabled = true;
        document.form1.fecha2.disabled = true;
        document.form1.plazo.disabled = true;
        document.form1.fecha3.disabled = true;
    }

    function update() {
        document.form1.numero.focus();
        document.form1.save.disabled = false;
        document.form1.modif.disabled = true;
        document.form1.ext.disabled = true;
        document.form1.del.disabled = true;
        document.form1.fecha1.disabled = false;
        document.form1.n1.disabled = false;
        document.form1.n2.disabled = false;
        document.form1.moneda.disabled = false;
        document.form1.fecha2.disabled = false;
        document.form1.plazo.disabled = false;
        document.form1.fecha3.disabled = false;
    }

    function modificar() {
        var f = document.form1;
        f.method = "POST";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function habilitaring() {
        var f = document.form1;
        ventana = confirm("Desea Habilitar este Ingreso");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "consult_hab_compra.php";
            f.submit();
        }
    }

    function eliminaring() {
        var f = document.form1;
        ventana = confirm("Desea Deshabilitar este Ingreso");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "consult_des_compra.php";
            f.submit();
        }
    }
    var statSend = false;

    function eliminar() {
        if (!statSend) {
            var f = document.form1;
            ventana = confirm("Desea Habilitar esta Compra");
            if (ventana) {
                f.method = "POST";
                f.target = "_top";
                f.action = "consult_hab_compra.php";
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
    var statSend = false;

    function eliminar1() {
        if (!statSend) {
            var f = document.form1;
            ventana = confirm("Desea Deshabilitar esta Compra");
            if (ventana) {
                f.method = "POST";
                f.target = "_top";
                f.action = "consult_des_compra.php";
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






    function consult_validar() {
        var f = document.form1;
        if (f.num.value == "") {
            alert("Ingrese el Nro del Documento");
            f.num.focus();
            return;
        }
        f.method = "POST";
        document.form1.upd.value = 0;
        f.action = "consult_compras1.php";
        f.submit();
    }

    function consult_todos() {
        var f = document.form1;
        f.method = "POST";
        document.form1.upd.value = "";
        document.form1.num.value = "";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function cancelar_consult() {
        var f = document.form1;
        ventana = confirm("Desea cancelar esta Consulta");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "consult_compras.php";
            f.submit();
        }
    }

    function anular_ingreso1() {
        var f = document.form1;
        f.method = "POST";
        f.target = "_top";
        f.action = "anular_ingreso.php";
        f.submit();
    }

    function habilitar_ingreso1() {
        var f = document.form1;
        f.method = "POST";
        f.target = "_top";
        f.action = "habilitar_ingreso.php";
        f.submit();
    }
    var statSend = false;

    function anular_salida1() {


        if (!statSend) {
            var f = document.form1;

            ventana = confirm("Desea Deshabilitar esta Documento, una vez deshabilitar no podra ser recuperada.");
            if (ventana) {
                f.method = "POST";
                f.target = "_top";
                f.action = "anular_salida.php";
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

    var statSend = false;

    function habilitar_salida1() {
        if (!statSend) {
            var f = document.form1;
            ventana = confirm("Desea Habilitar esta Compra");
            if (ventana) {
                f.method = "POST";
                f.target = "_top";
                f.action = "habilitar_salida.php";
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

    function salir_consult() {
        var f = document.form1;
        f.method = "POST";
        f.target = "_top";
        f.action = "../ing_salid.php";
        f.submit();
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
        ventana = confirm("Desea Grabar estos datos");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "consult_reg_compras.php";
            f.submit();
        }
    }

    function precio() {
        if (document.form1.text3.value == "") {
            document.form1.text3.value = 0;
        }
        if (document.form1.text4.value == "") {
            document.form1.text4.value = 0;
        }
        if (document.form1.text5.value == "") {
            document.form1.text5.value = 0;
        }
        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var v2 = parseFloat(document.form1.text2.value); //PRECIO
        var v3 = parseFloat(document.form1.text3.value); //DESCUENTO1
        var v4 = parseFloat(document.form1.text4.value); //DESCUENTO2
        var v5 = parseFloat(document.form1.text5.value); //DESCUENTO3
        var factor = parseFloat(document.form1.factor.value); //FACTOR
        var stock = parseFloat(document.form1.stockpro.value); //STOCK ACTUAL
        var p = parseFloat(document.form1.porcentaje.value); //PORCENTAJE
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
        if (document.form1.porcentaje.value == "") {
            porcent = 1;
            pventa = parseFloat(v2 * (a * b * c) * porcent);
        } else {
            porcent = parseFloat(1 + (p / 100));
            pventa = parseFloat(v2 * (a * b * c) * porcent);
        }
        var valor = isNaN(v1);
        if (valor == true) {
            //var porcion = v1.substring(1); // porcion = "ndo"
            var porcion = document.form1.text1.value.substring(1);
            var fact = parseFloat(porcion / factor);
            total = parseFloat(fact * pventa);
            document.form1.number.value = 1; ////avisa que no es numero
        } else {
            total = parseFloat(v1 * pventa);
            document.form1.number.value = 0; ////avisa que es numero
        }
        if (document.form1.text1.value != '' && document.form1.text2.value != '') {
            document.form1.text6.value = pventa;
            document.form1.text7.value = total;
        } else {
            document.form1.text6.value = '';
            document.form1.text7.value = '';
        }

    }

    function grabar() {
        var f = document.form1;
        if (f.fecha1.value == "") {
            alert("Ingrese la Fecha del Documento");
            f.fecha1.focus();
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
        if (f.plazo.value == "") {
            alert("Ingrese el plazo");
            f.plazo.focus();
            return;
        }
        if (f.fecha3.value == "") {
            alert("Ingrese la Fecha de Vencimiento");
            f.fecha3.focus();
            return;
        }
        if ((f.mont5.value == "") || (f.mont5.value == "0.00")) {
            alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
            f.mont5.focus();
            return;
        }
        ventana = confirm("Desea Grabar estos datos");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "consult_compras.php";
            f.submit();
        }
    }

    function validar_grid() {
        var f = document.form1;
        f.method = "post";
        f.action = "consult_compras2.php";
        f.submit();
    }

    function primero() {
        var f = document.form1;
        var v1 = parseInt(document.form1.first.value);
        document.form1.num.value = '';
        document.form1.numero.value = '';
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function siguiente() {
        var f = document.form1;
        var v1 = parseInt(document.form1.nextpage.value);
        document.form1.pageno.value = v1;
        document.form1.num.value = '';
        document.form1.numero.value = '';
        f.method = "post";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function anterior() {
        var f = document.form1;
        var v1 = parseInt(document.form1.prevpage.value);
        document.form1.pageno.value = v1;
        document.form1.num.value = '';
        document.form1.numero.value = '';
        f.method = "post";
        f.action = "consult_compras1.php";
        f.submit();
    }

    function ultimo() {
        var f = document.form1;
        var v1 = parseInt(document.form1.lastpage.value);
        document.form1.pageno.value = v1;
        document.form1.num.value = '';
        document.form1.numero.value = '';
        f.method = "post";
        f.action = "consult_compras1.php";
        f.submit();
    }
</script>