<script>
    function cerrar(e) {
        tecla = e.keyCode
        if (tecla == 27) {
            document.form1.submit();
        }
    }

    var statSend = false;
    var nav4 = window.Event ? true : false;
    // PARA CANTIDADES ENTERAS

    function evento_compra(evt, valor) {
        var valor;
        var key = nav4 ? evt.which : evt.keyCode;
        if (key == 13) {

            if (!statSend) {
                var f = document.form1;
                var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
                var p_compra = parseFloat(document.form1.text6.value); //CANTIDAD
                var p_caja_venta = parseFloat(document.form1.price2.value); //CANTIDAD
                var p_unidad_venta = parseFloat(document.form1.price3.value); //CANTIDAD
                var valor = isNaN(v1);
                if (valor == true) {
                    document.form1.number.value = 1; ////avisa que no es numero
                } else {
                    document.form1.number.value = 0; ////avisa que es numero
                }
                var fa = parseFloat(document.form1.factor.value); //CANTIDAD
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
                if (document.form1.lotee.value == 1) {
                    
                    if (f.countryL.value == "") {
                        alert("Ingrese el Numero de Lote");
                        f.countryL.focus();
                        return;
                    }
                    if (f.mesL.value == "") {
                        alert("Ingrese el Mes");
                        f.mesL.focus();
                        return;
                    }
                    if (f.yearsL.value == "") {
                        alert("Ingrese el A�o");
                        f.yearsL.focus();
                        return;
                    }
                    var cadena = f.yearsL.value;
                    var cadena_mes = f.mesL.value;
                    var longitud = cadena.length;
                    if (f.mesL.value > 12) {
                        alert("Ingrese un Mes valido");
                        f.mesL.focus();
                        return;
                    }
                    if (longitud < 4) {
                        alert("Ingrese un Año valido1");
                        f.yearsL.focus();
                        return;
                    }
                    var fecha = new Date();
                    var ano = fecha.getFullYear();
                    var mess = fecha.getMonth() + 1;
                    cadena = parseInt(f.yearsL.value);
                    var res = f.mesL.value.substring(0, 1);

                    if (res == 0) {



                        var cadena_mes2 = parseInt(document.form1.mesL.value, 10);



                    } else {
                        cadena_mes2 = parseInt(f.mesL.value);
                    }


                    ano = parseInt(ano);
                    mess = parseInt(mess);


                    if (ano > cadena) {
                        alert("Ingrese un Año posterior al Año Actual");
                        f.years.focus();
                        return;
                    } else {
                        if (ano == cadena) {
                            if (cadena_mes2 <= mess) {
                                alert("Ingrese un Mes posterior ");
                                f.mesL.focus();
                                return;
                            }
                        }
                    }
                }
                if (fa > 1) {
                    if (document.form1.blis.value > 1) {
                        if ((f.p3.value == "") || (f.p3.value == "0")) {
                            alert("Ingrese una Precio de Blister");
                            f.p3.focus();
                            return;
                        }
                        if ((f.blister.value == "") || (f.blister.value == "0")) {
                            alert("Ingrese una Cantidad de Blister");
                            f.blister.focus();
                            return;
                        }
                    }
                }
                p_compra_unidad = p_compra / fa;
                if (p_caja_venta <= p_compra) {
                    alert("El Precio de venta de caja es menor al precio de compra");
                    f.price2.focus();
                    return;
                }
                if (fa > 1) {
                    if (p_unidad_venta <= p_compra_unidad) {
                        alert("El Precio de venta de unidad es menor al precio de compra");
                        f.price3.focus();
                        return;
                    }
                }
                var mensaje0 = "¿Esta seguro de continuar?";
                if (f.text2.value == f.PrecioPrint.value) {
                    var mensaje1 = "EL COSTO DE LA CAJA NO HA SIDO MODIFICADO?";
                } else {
                    var mensaje1 = " ";
                }
                if (f.price2.value == f.tprevta.value) {
                    var mensaje2 = "EL PRECIO DE VENTA DE LA CAJA NO HA SIDO MODIFICADO";
                } else {
                    var mensaje2 = "";
                }
                if (fa > 1) {
                    if (f.price3.value == f.preunin.value) {
                        var mensaje3 = "EL PRECIO DE VENTA DE LA UNIDAD NO HA SIDO MODIFICADO";
                    } else {
                        var mensaje3 = "";
                    }
                } else {
                    var mensaje3 = "";
                }
                if ((f.text2.value == f.PrecioPrint.value) || (f.price2.value == f.tprevta.value) || ((fa > 1) && (f.price3.value == f.preunin.value))) {
                    ventana = confirm(mensaje0 + "\n\n" + mensaje1 + "\n" + mensaje2 + "\n" + mensaje3);
                    if (ventana) {
                        f.method = "post";
                        f.action = "compras2_reg.php";
                        f.target = "comp_principal";
                        f.submit();
                    } else {
                        f.text2.focus();
                        return;
                    }
                } else {
                    f.method = "post";
                    f.action = "compras2_reg.php";
                    f.target = "comp_principal";
                    f.submit();
                }
                statSend = true;
                return true;
            } else {
                alert("El producto esta siendo cargado espere un momento...");
                return false;
            }
        }

        if (valor == 1) {
            // valor = 1 // para enteros
            return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));

        } else if (valor == 4) {
            // valor = 1 // para enteros
            return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
        } else if (valor == 2) {
            // valor = 2 // para decimales
            return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
        } else if (valor == 3) {
            // valor = 3 // para alfanumericos
            return !(key > 31 && (key < 48 || key > 90) && (key < 97 || key > 122));
        }
    }

    function caj1() {
        //document.form1.text1.focus();
    }
    var popUpWin = 0;

    function popUpWindows(URLStr, left, top, width, height) {
        pcosto = document.form1.text2.value;
        pdesc1 = document.form1.text3.value;
        pdesc2 = document.form1.text4.value;
        pdesc3 = document.form1.text5.value;
        ptext1 = document.form1.text1.value;
        pigv = "<?php echo $ckigv; ?>";
        if (popUpWin) {
            if (!popUpWin.closed)
                popUpWin.close();
        }
        URLStr = URLStr + '&costo=' + pcosto + '&desc1=' + pdesc1 + '&desc2=' + pdesc2 + '&desc3=' + pdesc3 + '&text1=' + ptext1 + '&pigv=' + pigv;
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
    }

    function compras2(e) {
        tecla = e.keyCode;
        var f = document.form1;
        var a = f.carcount.value;
        var b = f.carcount1.value;
        if (tecla == 120) {
            if ((a == 0) || (b > 0)) {
                alert('No se puede realizar la impresiÃÂ¯ÃÂ¿ÃÂ½n de este Documento');
            } else {
                //alert("hola");	 
                //f.method = "POST";
                //f.target = "_top";
                //f.action ="comprasop_reg.php";
                //f.submit();
                //if (window.print)
                //window.print()
                //else
                //alert("Disculpe, su navegador no soporta esta opciÃÂ¯ÃÂ¿ÃÂ½n.");
            }
        }
        if (tecla == 27) {
            document.form1.submit();
        }

        ////F2///
        if (tecla == 113) {
            window.open('mov_proveedor.php', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,top=60,left=50,width=1250,height=470');
        }
    }



    // !-- -- -- -- -- -- --price-- -- -- -- -- -- -- -- -- -- -- -- -- -- - >

    function sf() {
        document.form1.price1.focus();
        var f = document.form1;
        var v1 = parseFloat(document.form1.price.value); //precio
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

    function cerrar(e) {
        tecla = e.keyCode
        if (tecla == 27) {
            window.close();
        }
    }

    function validar() {
        var f = document.form1;
        f.method = "post";
        f.action = "price1.php";
        f.submit();

    }
</script>