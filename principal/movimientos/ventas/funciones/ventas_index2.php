<?php
require_once('../../../conexion.php');
$sql = "SELECT vendedorventa FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $vendedorventa = $row['vendedorventa'];
    }
}


$sql = "SELECT venf8 FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $venf8 = $row['venf8'];
    }
}
?>
<style type="text/css">
    h1 {
        color: #FF0000;
        font-weight: bold;
        font-size: 30px;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }
</style>
<script language="JavaScript">
    function precio() {

        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var blister = parseInt(document.form1.pblister.value); //BLISTER
        var preblister = parseFloat(document.form1.preblister.value); //PRECIO DE BLISTER
        var factor = parseFloat(document.form1.factor.value); //FACTOR

        if (factor == 1) {
            var valor = isNaN(v1);
            if (valor == true) //NO ES NUMERO
            {
                var v1 = document.form1.text1.value.substring(1);
                if (document.form1.text1.value != '') {
                    document.form1.text1.value = 'C' + v1;
                } else {
                    document.form1.text1.value = '';
                }
            } else {
                if (document.form1.text1.value != '') {
                    document.form1.text1.value = 'C' + v1;
                } else {
                    document.form1.text1.value = '';
                }
            }
        }

        /* if (document.form1.text222.disabled == true) {
           
            var v22 = parseFloat(document.form1.text2.value);                   //PRECIO UNITARIO
            var v2venta = parseFloat(document.form1.textprevta.value);          //PRECIO CAJA
 
         } else {*/

        var v22 = parseFloat(document.form1.text2.value); //PRECIO UNITARIO
        var v2venta = parseFloat(document.form1.textprevta.value); //PRECIO CAJA
        //}

        var total;
        var valor = isNaN(v1);
        if (valor == true) //NO ES NUMERO
        {
            var v1 = document.form1.text1.value.substring(1);
            document.form1.text222.value = v2venta;
            total = parseFloat(v1 * v2venta);

        } else { //ES NUMERO    


            if ((blister > 1) && (v1 >= blister) && (preblister > 0)) {
                document.form1.text222.value = preblister;
                total = parseFloat(v1 * preblister);

            } else {

                document.form1.text222.value = v22;
                //document.form1.text2.value = v22;
                total = parseFloat(v1 * v22);
            }

        }

        total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);

        if (document.form1.text1.value != '') {
            document.form1.text3.value = total;
            document.form1.text333.value = total;
        } else {
            document.form1.text3.value = '';
            document.form1.text333.value = '';
        }
    }

    function precio1() {
        var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
        var precioEditable = (document.form1.text222.value); //PRECIO A EDITAR
        var preuni = parseFloat(document.form1.text2.value); //PRECIO PARA UNIDAD
        var prevta = parseFloat(document.form1.textprevta.value); //PRECIO PARA CAJA
        var factor = parseFloat(document.form1.factor.value); //FACTOR

        var total;
        var valor = isNaN(v1);
        if (valor == true) ////NO ES NUMERO
        {
            var v1 = document.form1.text1.value.substring(1);
            total = parseFloat(v1 * precioEditable);

            if (factor == 1) {
                if (document.form1.text222.value != '') {
                    document.form1.text2.value = precioEditable;
                    document.form1.textprevta.value = precioEditable;
                } else {
                    document.form1.text222.value = '';
                }

            } else {

                if (document.form1.text222.value != '') {
                    document.form1.text222.value = precioEditable;
                    document.form1.textprevta.value = precioEditable;
                } else {
                    document.form1.text222.value = '';
                }

            }
        } else {
            total = parseFloat(v1 * precioEditable);

            if (document.form1.text222.value != '') {
                document.form1.text222.value = precioEditable;
                document.form1.text2.value = precioEditable;
            } else {
                document.form1.text222.value = '';
            }

        }

        total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
        if ((document.form1.text1.value != '') && (document.form1.text222.value != '')) {
            document.form1.text3.value = total;
            document.form1.text333.value = total;
        } else {
            document.form1.text3.value = '';
            document.form1.text333.value = '';
        }


    }


    function grabar1() {
        var f = document.form1;
        tecKey = 2;
        <?php
        if ($vendedorventa == 1) {
        ?>
            var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
            if (claveVendedor !== null) {
                $.ajax({
                    type: "GET",
                    url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                    async: true,
                    success: function(datos) {
                        var dataJson = eval(datos);
                        var contad = 0;
                        for (var i in dataJson) {
                            contad++;
                            //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                        }
                        if (contad > 0) {

                            w = 600;
                            h = 400;
                            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                            var top = ((height / 2) - (h / 2)) + dualScreenTop;
                            var newWindow = window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor + '&tecKey=' + tecKey, 'PRIMPRIMIR', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);




                            // window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor + '&tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');

                        } else {
                            alert("No existe el Usuario");
                            return;
                        }
                    },
                    error: function(obj, error, objError) {
                        //avisar que ocurriï¿½ un error
                    }
                });
            }
        <?php
        } else {
        ?>

            w = 890;
            h = 630;
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
            var top = ((height / 2) - (h / 2)) + dualScreenTop;
            var newWindow = window.open('preimprimir.php?tecKey=' + tecKey, 'PRIMPRIMIR', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);



            // window.open('preimprimir.php?tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');

        <?php
        }
        ?>
    }

    function letraent(evt) {
        //key=e.keyCode;
        var key = nav4 ? evt.which : evt.keyCode;
        /////F4/////
        if (key == 115) {
            var codigo = document.form1.codpro.value;
            window.open('ver_prod_loc.php?cod=' + codigo + '', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=5,width=1010,height=350');
        }
        ////ESC/////
        if (key == 27) {
            document.form1.val.value = "";
            document.form1.tipo.value = "";
            document.form1.typpe.value = 0;
            document.form1.add.value = 0;

            document.form1.submit();
            //window.opener.location.href="venta_index2.php";
        }
        ////ENTER////
        if (key == 13) {
            var f = document.form1;
            var v1 = parseFloat(document.form1.text1.value); //CANTIDAD NGRESADA
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            var st = parseFloat(document.form1.cant_prod.value); //CANTIDAD ACTUAL POR LOCAL
            var pblister = parseFloat(document.form1.pblister.value); //PRECIO DE BLISTER	
            var preblister = parseFloat(document.form1.preblister.value); //PRECIO DE BLISTER
            var ventablister = parseFloat(document.form1.ventablister.value); //PRECIO DE BLISTER
            if (f.text222.value == "") {
                alert("Ingrese el Precio del Producto");
                f.text222.focus();
                return;
            }
            if (f.text1.value == "") {
                alert("Ingrese una Cantidad");
                f.text1.focus();
                return;
            }
            var valor = isNaN(v1);
            if (valor == true) ////NO ES NUMERO
            {
                document.form1.numero.value = 1; ////avisa que no es numero
                var v1 = document.form1.text1.value.substring(1);
                v1 = parseFloat(v1 * factor);
            } else {
                document.form1.numero.value = 0; ////avisa que es numero
                v1 = v1; ////ES NUMERO
            }
            if (v1 > st) {
                alert("La cantidad Ingresada excede al Stock Actual del Producto1");

            } else {
                if ((pblister > 0) && (preblister > 0) && (ventablister > 0)) {
                    if ((v1 % pblister !== 0)) {
                        alert("LA CANTIDAD ES INCORRECTA");

                    } else {
                        f.method = "post";
                        f.action = "venta_index2_reg.php";
                        f.submit();
                    }
                } else {
                    f.method = "post";
                    f.action = "venta_index2_reg.php";
                    f.submit();
                }
            }
            //alert("hola");
        }
        return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
    }
    var statSend = false;

    function letracc(evt) {

        //key=e.keyCode;
        var key = nav4 ? evt.which : evt.keyCode;
        /////F4/////
        if (key == 115) {
            var codigo = document.form1.codpro.value;
            window.open('ver_prod_loc.php?cod=' + codigo + '', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=5,width=1010,height=350');
        }
        ////ESC/////
        if (key == 27) {
            document.form1.val.value = "";
            document.form1.tipo.value = "";
            document.form1.typpe.value = 0;
            document.form1.add.value = 0;

            document.form1.submit();
            //window.opener.location.href="venta_index2.php";
        }
        ////ENTER////
        if (key == 13) {
            if (!statSend) {
                var f = document.form1;
                var v1 = parseFloat(document.form1.text1.value); //CANTIDAD NGRESADA
                var factor = parseFloat(document.form1.factor.value); //FACTOR
                var st = parseFloat(document.form1.cant_prod.value); //CANTIDAD ACTUAL POR LOCAL
                var pblister = parseFloat(document.form1.pblister.value); //PRECIO DE BLISTER
                var preblister = parseFloat(document.form1.preblister.value); //PRECIO DE BLISTER
                var ventablister = parseFloat(document.form1.ventablister.value); //PRECIO DE BLISTER

                if (f.text222.value == "") {
                    alert("Ingrese el Precio del Producto");
                    f.text222.focus();
                    return;
                    return false;
                }
                if (f.text1.value == "") {
                    alert("Ingrese una Cantidad");
                    f.text1.focus();
                    return;
                    return false;
                }
                // if (f.text3.value == 0)
                //{ alert("El total debe ser diferente de 0"); return; }
                var valor = isNaN(v1);
                if (valor == true) ////NO ES NUMERO
                {
                    document.form1.numero.value = 1; ////avisa que no es numero
                    var v1 = document.form1.text1.value.substring(1);
                    v1 = parseFloat(v1 * factor);
                } else {
                    document.form1.numero.value = 0; ////avisa que es numero
                    v1 = v1; ////ES NUMERO
                }

                if (v1 > st) {
                    //alert("La cantidad Ingresada excede al Stock Actual del Producto"); 
                    ventana = confirm('¿Desea grabar esta información en el reporte de "Productos no vendidos por falta de stock"?');
                    if (ventana) {
                        f.method = "post";
                        f.action = "venta_index2_reg.php?faltastock=1";
                        f.submit();
                        statSend = true;
                        return true;
                    } else {
                        f.text1.focus();
                        return;
                        return false;
                    }
                }

                if ((pblister > 0) && (preblister > 0) && (ventablister > 0)) {
                    if ((v1 % pblister !== 0)) {
                        alert(" LA CANTIDAD ES INCORRECTA");
                        return false;
                    } else {
                        f.method = "post";
                        f.action = "venta_index2_reg.php";
                        f.submit();

                        statSend = true;
                        return true;
                    }
                } else {
                    f.method = "post";
                    f.action = "venta_index2_reg.php";
                    f.submit();
                    statSend = true;
                    return true;
                }

                //alert("hola");
                statSend = true;
                return true;
            } else {
                alert("El producto esta siendo cargado espere un momento...");
                return false;
            }
        }
        return (key == 67 || key == 99 || key <= 13 || (key >= 48 && key <= 57));
    }

    function abrir_index2(e) {
        tecla = e.keyCode;
        if (tecla == 116) {
            var popUpWin = 0;
            var left = 120;
            var top = 120;
            var width = 880;
            var height = 220;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('buscaprod/tip_busqueda.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
        //alert(tecla);
        if (tecla == 27) {
            document.form1.val.value = "";
            document.form1.tipo.value = "";

            document.form1.typpe.value = 0;
            document.form1.add.value = 101;
            document.form1.submit();
        }


        //////F6/////
        if (tecla == 117) {
 
       
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
        ////F11////
        if (tecla == 122) {
            var popUpWin = 0;
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
        ////F2///
        if (tecla == 113) {
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

        //f12 para salir
        if (tecla == 123) {

            var f = document.form1;
            var act = document.form1.activado.value; //$count
            var act1 = document.form1.activado1.value; //$count1 
            //if ((act == 1)||(act1<0))

            if ((act > 0) || (act1 > 0)) {


                alertify
                    .alert("<h1><strong><center>IMPOSIBLE SALIR DE VENTAS</center></strong></h1>", "<h3> Cancele la venta antes de salir de ventas con el boton NUEVO o F4 </h3>", function() {
                        alertify.message('OK');
                    });


            } else {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                f.action = "ventas_salir.php";
                f.submit();
            }

        }

        ///F1////
        if (tecla == 112) {
            window.open('f3/f3.php', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=250,width=905,height=450');
        }



        ////F4///
        if (tecla == 115) {
            var f = document.form1;
            var act = document.form1.activado.value;
            var act1 = document.form1.activado1.value;

            var t33 = document.form1.t33.value;


            if ((act == 0) || (act1 > 1)) {} else {
                /*if ((f.medico.value == "") && (t33 = 0))
                 { alert("Asigna a un medico antes de cancelar esta venta333");  return; }*/
                ventana = confirm("Desea cancelar esta venta");
                if (ventana) {
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "ventas_cancel.php";
                    f.submit();
                }
            }
        }
        <?php
        if ($venf8 == 1) {
        ?>
            ////F8///
            if (tecla == 119) {
                var f = document.form1;
                var act = document.form1.activado.value;
                var act1 = document.form1.activado1.value;
                var t33 = document.form1.t33.value;
                if (f.t33.value == 0) {
                    alert("LA CANTIDAD INGRESADA ES 0, LA VENTA DEBE SER GRABADA CON F4 Y ASIGNANDO A UN MEDICO");
                    return;
                }


                if (t33 > 0) {

                    if ((act == 0) || (act1 > 1)) {
                        alert("Venta Incompleta. Imposible Grabar");
                        f.num.focus();
                        return;
                    } else {
                        <?php
                        if ($vendedorventa == 1) {
                        ?>
                            var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
                            if (claveVendedor !== null) {
                                $.ajax({
                                    type: "GET",
                                    url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                                    async: true,
                                    success: function(datos) {
                                        var dataJson = eval(datos);
                                        var contad = 0;
                                        for (var i in dataJson) {
                                            contad++;
                                            //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                                        }
                                        if (contad > 0) {
                                            //ENVIO NORMALMENTE
                                            f.method = "post";
                                            f.target = "_top";
                                            f.CodClaveVendedor.value = "c" + claveVendedor;
                                            f.action = "venta_reg.php";
                                            f.submit();
                                        } else {
                                            alert("No existe el Usuario");
                                            return;
                                        }
                                    },
                                    error: function(obj, error, objError) {
                                        //avisar que ocurriÃ¯Â¿Â½ un error
                                    }
                                });
                            }
                        <?php
                        } else {
                        ?>
                            //                var f = document.form1;
                            //                var act = document.form1.text3.value;
                            ventana = confirm("Desea Grabar esta Venta");
                            if (ventana) {
                                f.method = "post";
                                f.target = "_top";
                                f.action = "venta_reg.php";
                                f.submit();
                            }
                        <?php
                        }
                        ?>
                    }
                }
            }
        <?php } ?>
        /////F9/////
        //if((tecla==120) || (tecla ==119))
        if ((tecla == 120)) {
            var tecKey = 0;
            if (tecla == 119) {
                tecKey = 1;
            }
            if (tecla == 120) {
                tecKey = 2;
            }
            var f = document.form1;
            var act = document.form1.activado.value;
            var act1 = document.form1.activado1.value;
            var t33 = document.form1.t33.value;
            if (f.t33.value == 0) {
                alert("LA CANTIDAD INGRESADA ES 0, LA VENTA DEBE SER GRABADA CON F4 Y ASIGNANDO A UN MEDICO");
                return;
            }

            if (t33 > 0) {
                if ((act == 0) || (act1 > 1)) {
                    alert("Venta Incompleta. Imposible de Imprimir");
                    f.num.focus();
                    return;
                } else {
                    <?php
                    if ($vendedorventa == 1) {
                    ?>
                        var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
                        if (claveVendedor !== null) {
                            $.ajax({
                                type: "GET",
                                url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                                async: true,
                                success: function(datos) {
                                    var dataJson = eval(datos);
                                    var contad = 0;
                                    for (var i in dataJson) {
                                        contad++;
                                        //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                                    }
                                    if (contad > 0) {
                                        //ENVIO NORMALMENTE
                                        //--------------------------window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor,'PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                                        window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor + '&tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
                                    } else {
                                        alert("No existe el Usuario");
                                        return;
                                    }
                                },
                                error: function(obj, error, objError) {
                                    //avisar que ocurriÃ¯Â¿Â½ un error
                                }
                            });
                        }
                    <?php
                    } else {
                    ?>
                        //----------------------------window.open('preimprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                        window.open('preimprimir.php?tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
                    <?php
                    }
                    ?>
                }
            }

        }
        ////F12/////
        if (tecla == 123) {
            var htmled = document.getElementById("index2");
            htmled.contentWindow.document.getElementById("ll").focus();
        }
    }

    function sf() {
        document.form1.country.focus();
    }

    function st() {
        document.form1.text1.focus();
    }

    function getfocus() {
        document.getElementById('l1').focus();
        document.getElementById('fila_1').style.backgroundColor = '#FFFF66';
    }

    function lineasfiltro() {
        alert("Es el maximo de lineas");
        return;
    }
</script>