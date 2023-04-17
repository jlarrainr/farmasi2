<script language="JavaScript">

    function precio2()
    {
        var v1 = parseFloat(document.form1.t1.value);
        var v2 = parseFloat(document.form1.t2.value);
        var total;
        var valor = isNaN(v1);
        if (valor == true)			////NO ES NUMERO
        {
            var v1 = document.form1.t1.value.substring(1);
            v1 = parseFloat(v1);
            total = parseFloat(v1 * v2);
        } else {
            v1 = parseFloat(v1);
            total = parseFloat(v1 * v2);
        }
        total = parseFloat(v1 * v2);
        total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
        document.form1.t3.value = total;
        document.form1.t33.value = total;
    }

    function precio1()
    {
        var v1 = parseFloat(document.form1.t1.value);			//CANTIDAD
        var v2 = parseFloat(document.form1.t22.value);			//PRIPRO
        var v2editable = parseFloat(document.form1.t2.value);			//PRIPRO EDITABLE
        var v3 = parseFloat(document.form1.t23.value);			//PREUNI
        var v4 = parseFloat(document.form1.t24.value);			//CAJA
        var pblister = parseFloat(document.form1.pblister.value);	//BLISTER
        var preblister = parseFloat(document.form1.preblister.value);	//PRECIO DE BLISTER
        var factor = parseFloat(document.form1.factor.value);		//FACTOR
        if (factor == 1) {
            var valor = isNaN(v1);
            if (valor == true)			////NO ES NUMERO
            {
                var v1 = document.form1.t1.value.substring(1);
                if (document.form1.t1.value != '') {
                    document.form1.t1.value = 'C' + v1;
                } else {
                    document.form1.t1.value = '';
                }
            } else {
                if (document.form1.t1.value != '') {
                    document.form1.t1.value = 'C' + v1;
                } else {
                    document.form1.t1.value = '';
                }
            }
        }
        var total;
        var valor = isNaN(v1);
        if (valor == true)			////NO ES NUMERO
        {
            var v1 = document.form1.t1.value.substring(1);
            //v1		= parseFloat(v1 * v4);
            document.form1.t2.value = v4;
            document.form1.t22.value = v4;
            total = parseFloat(v1 * v4);
        } else
        {
            if ((pblister > 1) && (v1 >= pblister) && (preblister > 0))
            {
                total = parseFloat(v1 * preblister);
                document.form1.t2.value = preblister;
                // document.form1.t22.value=preblister;
            } else
            {
                total = parseFloat(v1 * v3);
                document.form1.t2.value = v3;
                document.form1.t22.value = v3;
            }
        }
        total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
        if (document.form1.t1.value != '') {
            document.form1.t3.value = total;
            document.form1.t33.value = total;
        } else {
            document.form1.t3.value = '';
            document.form1.t33.value = total;
        }
    }
    function validar_prod() {
        var f = document.form1;
        var v1 = parseFloat(document.form1.t1.value);				    //CANTIDAD NGRESADA
        var st = parseFloat(document.form1.stockpro.value);		        //CANTIDAD ACTUAL POR LOCAL
        var sw = parseFloat(document.form1.cantemp.value);		        //CANTIDAD AGREGADA EN LA COMPRA
        var factor = parseFloat(document.form1.factor.value);		    //FACTOR
        var t2 = parseFloat(document.form1.t2.value);		            //CANTIDAD INGRESADA
        var t22 = parseFloat(document.form1.t22.value);		            //CANTIDAD AGREGADA EN LA COMPRA
        var preuni = parseFloat(document.form1.t23.value);		        //preuni
        var prevta = parseFloat(document.form1.t24.value);		        //prevta
        var pblister = parseFloat(document.form1.pblister.value);    //BLISTER
        var preblister = parseFloat(document.form1.preblister.value);	//PRECIO DE BLISTER
        stock_total = st + sw;
        if ((f.t1.value == "") || (f.t1.value == "0"))
        {
            alert("Ingrese una Cantidad");
            f.t1.focus();
            return;
        }
        if (t2 != t22) {
            var valor = isNaN(v1);
            if (valor == true)									////NO ES NUMERO
            {
                document.form1.number.value = 1;		        ////avisa que no es numero
                var v1 = document.form1.t1.value.substring(1);
                v1 = parseFloat(v1 * factor);
                precio = prevta;
                mensaje = "por Caja del Producto : S/" + precio;
            } else
            {
                document.form1.number.value = 0;		        ////avisa que es numero
                v1 = v1;						                ////ES NUMERO
                if (v1 >= pblister) {
                    precio = preblister;
                } else {
                    precio = preuni;
                }
                mensaje = "por Unidad del Producto : S/" + precio;
            }
            if (t2 < precio)
            {
                alert("El Precio Ingresado es Menor al Precio" + mensaje);
                f.t2.focus();
                return;
            }
        } else {
            var valor = isNaN(v1);
            if (valor == true)									////NO ES NUMERO
            {
                document.form1.number.value = 1;		        ////avisa que no es numero
                var v1 = document.form1.t1.value.substring(1);
                v1 = parseFloat(v1 * factor);
            } else
            {
                document.form1.number.value = 0;		        ////avisa que es numero
                v1 = v1;						                ////ES NUMERO
            }
        }
        if (v1 > st)
        {
            alert("La cantidad Ingresada excede al Stock Actual del Producto");
            f.t1.focus();
            return;
        }
        f.method = "post";
        f.target = "venta_principal";
        f.action = "venta_index3_reg.php";
        f.submit();
    }
    function letrac(evt) {
        var key = nav4 ? evt.which : evt.keyCode;
        ////ENTER////
        if (key == 13)
        {
            var f = document.form1;
            var v1 = parseFloat(document.form1.t1.value);				    //CANTIDAD NGRESADA
            var st = parseFloat(document.form1.stockpro.value);		        //CANTIDAD ACTUAL POR LOCAL
            var sw = parseFloat(document.form1.cantemp.value);		        //CANTIDAD AGREGADA EN LA COMPRA
            var factor = parseFloat(document.form1.factor.value);		    //FACTOR
            var t2 = parseFloat(document.form1.t2.value);		            //CANTIDAD INGRESADA
            var t22 = parseFloat(document.form1.t22.value);		            //CANTIDAD AGREGADA EN LA COMPRA
            var preuni = parseFloat(document.form1.t23.value);		        //preuni
            var prevta = parseFloat(document.form1.t24.value);		        //prevta
            var pblister = parseFloat(document.form1.pblister.value);    //BLISTER
            var preblister = parseFloat(document.form1.preblister.value);	//PRECIO DE BLISTER
            stock_total = st + sw;                                          // la suma del stock que tengo en el local + la cantida a vender

            if ((f.t1.value == "") || (f.t1.value == "0"))
            {
                alert("Ingrese una Cantidad");
                f.t1.focus();
                return;
            }
            if (t2 != t22) {
                var valor = isNaN(v1);
                if (valor == true)									////NO ES NUMERO
                {
                    document.form1.number.value = 1;		        ////avisa que no es numero
                    var v1 = document.form1.t1.value.substring(1);
                    v1 = parseFloat(v1 * factor);
                    precio = prevta;
                    mensaje = "por Caja del Producto : S/" + precio;
                } else
                {
                    document.form1.number.value = 0;		        ////avisa que es numero
                    v1 = v1;						                ////ES NUMERO
                    if (v1 >= pblister) {
                        precio = preblister;
                    } else {
                        precio = preuni;
                    }
                    mensaje = "por Unidad del Producto : S/" + precio;
                }
                if (t2 < precio)
                {
                    alert("El Precio Ingresado es Menor al Precio" + mensaje);
                    f.t2.focus();
                    return;
                }
            } else {
                var valor = isNaN(v1);
                if (valor == true)									////NO ES NUMERO
                {
                    document.form1.number.value = 1;		        ////avisa que no es numero
                    var v1 = document.form1.t1.value.substring(1);
                    v1 = parseFloat(v1 * factor);

                } else
                {
                    document.form1.number.value = 0;		        ////avisa que es numero
                    v1 = v1;						                ////ES NUMERO
                }
            }
            if (v1 > stock_total)
            {
                alert("La cantidad Ingresada excede al Stock Actual del Producto");
                f.t1.focus();
                return;
            }
            f.method = "post";
            f.target = "venta_principal";
            f.action = "venta_index3_reg.php";
            f.submit();
        } else
        {
            var v1 = parseFloat(document.form1.t1.value);			//CANTIDAD
            var v2 = parseFloat(document.form1.t2.value);			//PRIPRO
            var pblister = parseFloat(document.form1.pblister.value);		//BLISTER
            var preblister = parseFloat(document.form1.preblister.value);		//PRECIO DE BLISTER
            var factor = parseFloat(document.form1.factor.value);		//FACTOR
            var total;
            var valor = isNaN(v1);
            if (valor == true)			////NO ES NUMERO
            {
                var v1 = document.form1.t1.value.substring(1);
                v1 = parseFloat(v1 * factor);
                total = parseFloat(v1 * v2);
            } else
            {
                if ((pblister > 1) && (v1 >= pblister) && (preblister > 0))
                {

                    total = parseFloat(v1 * preblister);
                } else
                {
                    total = parseFloat(v1 * v2);
                }
            }
            total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
            if (document.form1.t1.value != '') {
                document.form1.t3.value = total;
                document.form1.t33.value = total;
            } else {
                document.form1.t3.value = '';
                document.form1.t33.value = '';
            }
        }
    }
    function validar_grid() {
        var f = document.form1;
        f.method = "post";
        f.action = "venta_index3.php";
        f.submit();
    }
    function abrir_index2(e) {
        tecla = e.keyCode
////F2////
        /* if(tecla==113)
         {
         window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=240');
         }*/
        var popUpWin = 0;
        ////F11////
        if (tecla == 122)
        {
            var left = 90;
            var top = 120;
            var width = 895;
            var height = 420;
            if (popUpWin)
            {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
        ////F4/////
        if (tecla == 115)
        {

            var f = document.form1;
            var act = document.form1.activado.value;
            var act1 = document.form1.activado1.value;
            if ((act == 0) || (act1 > 1))
            {
            } else
            {
                ventana = confirm("Desea cancelar esta venta");
                if (ventana) {
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "ventas_cancel.php";
                    f.submit();
                }
            }
        }
        /////SUPR/////
        if (tecla == 46)
        {
            var f = document.form1;
            var ctemp = f.codtemp.value;
            //var dir   = 'venta_index3_del.php?cod='+ctemp;
            window.open('venta_index3_del.php?cod=' + ctemp, 'venta_principal');
            //alert (dir);
            //alert(ctemp);
            //document.form1.target = "venta_principal";
            //window.opener.location.href="venta_index3_del.php?cod="+ctemp;
            //self.close();
            //f.method = "post";
            //f.action = dir;
            //f.submit();
        }
        ////F6/////
        if (tecla == 117)
        {
            var codigo = document.form1.codigo_producto.value;
            window.open('ver_prod.php?cod=' + codigo + '', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=90,left=285,width=650,height=200');
        }
        ////F8////
        if (tecla == 119)
        {
            var f = document.form1;
            var act = document.form1.activado.value;
            var act1 = document.form1.activado1.value;
            if ((act == 0) || (act1 > 1))
            {
                alert("Venta Incompleta. Imposible Grabar");
                f.num.focus();
                return;
            } else
            {
                ventana = confirm("Desea Grabar esta Venta");
                if (ventana) {
                    f.method = "post";
                    f.target = "_top";
                    f.action = "venta_reg.php";
                    f.submit();
                }
            }
        }
        /////F9/////
        if (tecla == 120)
        {
            var f = document.form1;
            var act = document.form1.activado.value;
            var act1 = document.form1.activado1.value;
            if ((act == 0) || (act1 > 1))
            {
                alert("Cotizacion Incompleta. Imposible de Imprimir");
                f.num.focus();
                return;
            } else
            {
//  	  window.open('imprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
                var cod = parseFloat(document.form1.cod.value);
                ventana = confirm("Desea Grabar esta Cotizacion");
                if (ventana) {
                    alert("EL NUMERO DE COTIZACION ES " + cod);
//                    ventana2 = confirm("EL NUMERO DE COTIZACION ES " + cod);
//                    if (ventana2) {
                    f.method = "post";
                    f.target = "_top";
                    f.action = "venta_reg.php";
                    f.submit();
//                    }
                }
            }
        }
        /////F12////
        if (tecla == 123)
        {
            document.getElementById("l1").focus();
        }
    }
    function ad() {
        document.form1.t1.focus();
    }
</script>