<?php
$sql1 = "SELECT utldmin FROM datagen_det"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $utldmin = $row1['utldmin'];
    }
}
$sql1 = "SELECT r_sanitario  FROM datagen"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $r_sanitario = $row1['r_sanitario'];
    }
}
?>
<script>
    function mensaje(valortext) {
        var valortext;
        if (valortext == 1) {
            document.getElementById("pasos").innerHTML = 'Ingrese la descripcion del producto, concentracion y cantidad '
        } else if (valortext == 2) {
            document.getElementById("pasos").innerHTML = 'Ingrese cuantas unidades vienen en el producto para la venta '
        } else if (valortext == 3) {
            document.getElementById("pasos").innerHTML = '¿Cuantas unidades contiene un blister? (solo llenar si tendra un precio especial por blister)'
        } else if (valortext == 4) {
            document.getElementById("pasos").innerHTML = 'Para buscar escriba el laboratorio o marca'
        } else if (valortext == 5) {
            document.getElementById("pasos").innerHTML = 'Para buscar escriba el principio activo  '
        } else if (valortext == 6) {
            document.getElementById("pasos").innerHTML = 'Para buscar escriba el accion terapeutica'
        } else if (valortext == 7) {
            document.getElementById("pasos").innerHTML = 'Para buscar escriba el presentacion'
        } else if (valortext == 8) {
            document.getElementById("pasos").innerHTML = 'Marcar solo si este producto registrara lote y vencimiento '
        } else if (valortext == 9) {
            document.getElementById("pasos").innerHTML = 'Marcar solo si este producto es Afecto al IGV'
        } else if (valortext == 10) {
            document.getElementById("pasos").innerHTML = 'Ingrese el Codigo DIGEMID'
        } else if (valortext == 11) {
            document.getElementById("pasos").innerHTML = 'Ingrese el Registro Sanitario'
        } else if (valortext == 8) {
            document.getElementById("pasos").innerHTML = 'Ingrese el Codigo de barras'
        }
    }
    //<!--
    function conmayus(field) {
        field.value = field.value.toUpperCase()
    }



    function precion() {
        var ncostre = parseFloat(document.form1.ncostre.value);
        var nmargene = parseFloat(document.form1.nmargene.value);
        var nmargenenuevo = parseFloat(document.form1.nmargenenuevo.value);

        var nfactor = parseFloat(document.form1.factor.value);
        var blister = parseFloat(document.form1.blister.value);

        if ((blister > 0) && (nfactor > 1)) {
            document.form1.npreblister.disabled = false;
        } else {
            document.form1.npreblister.disabled = true;
        }
        if (nfactor > 1) {
            document.form1.npreuni.disabled = false;
        } else {
            document.form1.npreuni.disabled = true;
        }
        var valor = isNaN(nfactor);
        if (valor == true) ////NO ES NUMERO
        {
            var nfactor = 1; //FACTOR
        }

        if ((nmargene == 0) || ((nmargene == ""))) {
            nmargene = nmargenenuevo;
        }


        porcentaje = (1 + (nmargene / 100));

        caja = ncostre * porcentaje;
        unidad = ((ncostre / nfactor) * porcentaje);

        margenecaja = Math.round(caja / ncostre * 100, 2) - 100;

        margene2uni = Math.round(unidad / (ncostre / nfactor) * 100, 2) - 100;

        caja = Math.round(caja * Math.pow(10, 2)) / Math.pow(10, 2);
        unidad = Math.round(unidad * Math.pow(10, 3)) / Math.pow(10, 3);

        margenecaja = Math.round(margenecaja * Math.pow(10, 2)) / Math.pow(10, 2);
        margene2uni = Math.round(margene2uni * Math.pow(10, 2)) / Math.pow(10, 2);

        if ((document.form1.ncostre.value != '') && (document.form1.nmargene.value != '')) {

            document.form1.nprevta.value = caja;
            document.form1.npreuni.value = unidad;
            document.form1.nmargenuni.value = margene2uni;
            document.form1.nmargene.value = margenecaja;

        } else {
            document.form1.nprevta.value = '';
            document.form1.npreuni.value = '';
            document.form1.nmargenuni.value = '';
        }
    }

    function precioncaja() {
        var ncostre = parseFloat(document.form1.ncostre.value);
        var nprevta = parseFloat(document.form1.nprevta.value);
        var factor = parseFloat(document.form1.factor.value);
        var blister = parseFloat(document.form1.blister.value);

        if ((blister > 0) && (nfactor > 1)) {
            document.form1.npreblister.disabled = false;
        } else {
            document.form1.npreblister.disabled = true;
        }
        if (factor > 1) {
            document.form1.npreuni.disabled = false;
        } else {
            document.form1.npreuni.disabled = true;
        }

        var valor = isNaN(factor);
        if (valor == true) ////NO ES NUMERO
        {
            var factor = 1; //FACTOR
        }
        preciounidad = nprevta / factor;


        margenecaja = Math.round(nprevta / ncostre * 100, 2) - 100;
        margenecaja = Math.round(margenecaja * Math.pow(10, 2)) / Math.pow(10, 2);


        if ((document.form1.ncostre.value != '') && (document.form1.nmargene.value != '')) {

            document.form1.nmargene.value = margenecaja;
            document.form1.nmargenuni.value = margenecaja;
            document.form1.npreuni.value = preciounidad;
        } else {
            document.form1.nmargene.value = '';
            document.form1.nmargenuni.value = '';
            document.form1.npreuni.value = '';
            document.form1.npreblister.value = '';
            document.form1.nmargenblister.value = '';
        }

    }

    function precionunidad() {
        var ncostre = parseFloat(document.form1.ncostre.value);
        var npreuni = parseFloat(document.form1.npreuni.value);
        var nfactor = parseFloat(document.form1.factor.value);
        var blister = parseFloat(document.form1.blister.value);

        if ((blister > 0) && (nfactor > 1)) {
            document.form1.npreblister.disabled = false;
        } else {
            document.form1.npreblister.disabled = true;
        }
        if (nfactor > 1) {
            document.form1.npreuni.disabled = false;
        } else {
            document.form1.npreuni.disabled = true;
        }
        margene2uni = Math.round(npreuni / (ncostre / nfactor) * 100, 2) - 100;
        margene2uni = Math.round(margene2uni * Math.pow(10, 2)) / Math.pow(10, 2);

        if ((document.form1.ncostre.value != '') && (document.form1.nmargene.value != '')) {

            document.form1.nmargenuni.value = margene2uni;
        } else {
            document.form1.nmargenuni.value = '';
        }
    }

    function precioblister() {
        var nfactor = parseFloat(document.form1.factor.value);
        var npreblister = parseFloat(document.form1.npreblister.value);
        var npreuni = parseFloat(document.form1.npreuni.value);
        var blister = parseFloat(document.form1.blister.value);

        if ((blister > 0) && (nfactor > 1)) {
            document.form1.npreblister.disabled = false;
        } else {
            document.form1.npreblister.disabled = true;
        }
        if (nfactor > 1) {
            document.form1.npreuni.disabled = false;
        } else {
            document.form1.npreuni.disabled = true;
        }
        if ((npreblister > npreuni) || (npreblister == npreuni)) {
            alert('El precio de blister no puede ser mayor o igual al precio de unidad');
            document.form1.npreblister.focus();
            return;
        }

        margenblister2 = ((((npreblister * nfactor) / 100) - 1) * 100);
        margenblister2 = Math.round(margenblister2 * Math.pow(10, 2)) / Math.pow(10, 2);

        if ((document.form1.ncostre.value != '') && (document.form1.nmargene.value != '') && (document.form1.npreblister.value != '')) {

            document.form1.nmargenblister.value = margenblister2;
        } else {
            document.form1.nmargenblister.value = '';
        }

    }

    function producto() {


        //	 f.action ="../../archivo/mov_prod.php";
        window.open("info/info.php", "PRODUCTOS", "width=1000, height=700");
    }

    /*var isCtrl = false;
     function ctrls(e)
     {
     if(e.which == 17) isCtrl=true;
     if(e.which == 121 && isCtrl == true) {
     alert("HOLAAAAA")
     }
     }*/

    function prods(e) {
        tecla = e.keyCode;
        /////F3
        //if(e.which  == 17) isCtrl=false;
        /* var isCtrl = false;
         //alert(tecla);
         if(tecla == 17)
         { 
         isCtrl=true;
         }
         if(tecla == 121 && isCtrl == true)
         {
         alert("holaaaaaaaaa");
         }*/
        if (tecla == 114) {
            document.form1.des.disabled = false;
            document.form1.des.focus();
            document.form1.factor.disabled = false;
            document.form1.digemid.disabled = false;
            <?php if ($r_sanitario == 1) { ?>

                document.form1.registrosanitario.disabled = false;
            <?php } ?>
            document.form1.blister.disabled = false;
            document.form1.marca.disabled = false;
            document.form1.moneda.disabled = false;
            document.form1.line.disabled = false;
            document.form1.clase.disabled = false;
            document.form1.present.disabled = false;
            //--document.form1.price1.disabled = false;
            //            document.form1.price2.disabled = false;
            //            document.form1.price3.disabled = true;
            document.form1.cod_bar.disabled = false;
            document.form1.cod_cuenta.disabled = false;
            document.form1.img.disabled = true;
            document.form1.igv.disabled = false;
            //document.form1.inc.disabled = false;
            document.form1.lotec.disabled = false;
            document.form1.textdesc.disabled = false;
            document.form1.rd.disabled = false;
            document.form1.rd1.disabled = false;
            ///	botones
            document.form1.printer.disabled = true;
            document.form1.modif.disabled = true;
            document.form1.nuevo.disabled = true;
            document.form1.save.disabled = false;
            document.form1.del.disabled = true;
            document.form1.first.disabled = true;
            document.form1.prev.disabled = true;
            document.form1.next.disabled = true;
            document.form1.fin.disabled = true;
            document.form1.ext.disabled = false;
            document.form1.val.value = 2;
            /*var z=dhtmlXComboFromSelect("marca");
             z.enableFilteringMode(true);
             var z=dhtmlXComboFromSelect("line");
             z.enableFilteringMode(true);
             var z=dhtmlXComboFromSelect("clase");
             z.enableFilteringMode(true);
             var z=dhtmlXComboFromSelect("present");
             z.enableFilteringMode(true);*/
            document.form1.codigo.focus();
        }
        ///F4
        if (tecla == 115) {
            document.form1.submit();
        }
        if (tecla == 119) {
            var f = document.form1;
            if (f.save.disabled == false) {
                if (f.des.value == "") {
                    alert("Ingrese el nombre del Producto");
                    f.des.focus();
                    return;
                }
                if (f.factor.value == "") {
                    alert("Ingrese el Factor");
                    f.factor.focus();
                    return;
                }
                //--if ((f.price1.value == "0.00") || (f.price1.value == ""))
                //--{ alert("Ingrese el Precio de Costo"); f.price1.focus(); return; }
                var utdmin = <?php echo $utldmin; ?>;
                if (f.price2.value < utdmin) {
                    alert("La utilidad ingresada no corresponde segun la configuracion del Sistema");
                    document.form1.price2.focus();
                    return;
                } else {
                    if ((f.price2.value == "0.00") || (f.price2.value == "")) {
                        alert("Ingrese el Margen de Utilidad");
                        f.price2.focus();
                        return;
                    }
                }
                if ((f.price3.value == "0.00") || (f.price3.value == "")) {
                    alert("Ingrese el Precio de Venta");
                    f.price3.focus();
                    return;
                }
                if ((f.marca.value == "") || (f.marca.value == 0)) {
                    alert("Seleccione una Marca");
                    f.marca.focus();
                    return;
                }
                if ((f.line.value == "") || (f.line.value == 0)) {
                    alert("Seleccione un Principio Activo");
                    f.line.focus();
                    return;
                }
                if ((f.clase.value == "") || (f.clase.value == 0)) {
                    alert("Seleccione una Accion Terapeutica");
                    f.clase.focus();
                    return;
                }
                if ((f.present.value == "") || (f.present.value == 0)) {
                    alert("Seleccione una Presentacion");
                    f.present.focus();
                    return;
                }
                //VENTANA QUE CONFIRMA SI GRABO O NO?
                ventana = confirm("Desea Grabar estos datos");
                if (ventana) {
                    document.form1.btn.value = 4;
                    f.method = "POST";
                    f.action = "graba_producto.php";
                    f.submit();
                }
                ///////////////////////////////////
            }
        }
    }

    function pulsar(e) {
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 13)
            return false;
    }

    function sf() {
        document.form1.codigo.disabled = true;
        document.form1.des.disabled = true;
        document.form1.factor.disabled = true;
        document.form1.digemid.disabled = true;
        <?php if ($r_sanitario == 1) { ?>

            document.form1.registrosanitario.disabled = true;
        <?php } ?>
        document.form1.blister.disabled = true;
        document.form1.marca.disabled = true;
        document.form1.moneda.disabled = true;
        document.form1.line.disabled = true;
        document.form1.clase.disabled = true;
        document.form1.present.disabled = true;
        document.form1.price.disabled = true;
        //--document.form1.price1.disabled = true;
        //        document.form1.price2.disabled = true;
        //        document.form1.price3.disabled = true;
        //        document.form1.price4.disabled = true;
        document.form1.cod_bar.disabled = true;
        document.form1.cod_cuenta.disabled = true;
        document.form1.img.disabled = true;
        document.form1.igv.disabled = true;
        //document.form1.inc.disabled = true;
        document.form1.lotec.disabled = true;
        document.form1.textdesc.disabled = true;
        document.form1.printer.disabled = false;
        document.form1.save.disabled = true;
        document.form1.ext.disabled = true;
        document.form1.rd.disabled = true;
        document.form1.rd1.disabled = true;
        // document.form1.country.focus();

        //        para editar los precios en mismo modulo de productos
        document.form1.ncostre.disabled = true;
        document.form1.nmargene.disabled = true;
        document.form1.nprevta.disabled = true;
        document.form1.nmargenblister.disabled = true;
        document.form1.npreuni.disabled = true;
        document.form1.nmargenuni.disabled = true;
        document.form1.npreblister.disabled = true;

    }

    function buton2() {
        document.form1.des.disabled = false;
        document.form1.factor.disabled = false;
        document.form1.digemid.disabled = false;
        <?php if ($r_sanitario == 1) { ?>

            document.form1.registrosanitario.disabled = false;
        <?php } ?>
        document.form1.blister.disabled = false;
        document.form1.marca.disabled = false;
        document.form1.line.disabled = false;
        document.form1.clase.disabled = false;
        document.form1.present.disabled = false;
        document.form1.moneda.disabled = false;
        //--document.form1.price1.disabled = false;
        //        document.form1.price2.disabled = true;
        //        document.form1.price3.disabled = true;
        document.form1.cod_bar.disabled = false;
        document.form1.cod_cuenta.disabled = false;
        document.form1.img.disabled = false;
        document.form1.igv.disabled = false;
        document.form1.igv.checked = true;
        //document.form1.inc.disabled = false;
        //document.form1.inc.checked = false;
        document.form1.lotec.disabled = false;
        document.form1.lotec.checked = false;
        document.form1.textdesc.disabled = false;
        document.form1.rd.disabled = false;
        document.form1.rd1.disabled = false;
        ///	botones
        document.form1.printer.disabled = true;
        document.form1.modif.disabled = true;
        document.form1.nuevo.disabled = true;
        document.form1.save.disabled = false;
        document.form1.ext.disabled = false;
        document.form1.first.disabled = true;
        document.form1.prev.disabled = true;
        document.form1.next.disabled = true;
        document.form1.fin.disabled = true;
        document.form1.del.disabled = true;

        //        para editar los precios en mismo modulo de productos
        document.form1.ncostre.disabled = false;
        document.form1.nmargene.disabled = false;
        document.form1.nprevta.disabled = false;
        //        document.form1.nmargenblister.disabled = false;
        document.form1.npreuni.disabled = false;
        document.form1.nmargenuni.disabled = false;

        var blister = parseFloat(document.form1.blister.value);
        var nfactor = parseFloat(document.form1.factor.value);

        if ((blister > 0) && (nfactor > 1)) {
            document.form1.npreblister.disabled = false;
        } else {
            document.form1.npreblister.disabled = true;
        }
        if (nfactor > 1) {
            document.form1.npreuni.disabled = false;
        } else {
            document.form1.npreuni.disabled = true;
        }
        //        document.form1.npreblister.disabled = false;
        //LIMPIO CAJAS
        //        para editar los precios en mismo modulo de productos
        document.form1.ncostre.value = "";
        document.form1.nmargene.value = "0";
        document.form1.nprevta.value = "";
        document.form1.nmargenblister.value = "0";
        document.form1.npreuni.value = "";
        document.form1.nmargenuni.value = "0";
        document.form1.npreblister.value = "";
        document.form1.digemid.value = "";
        <?php if ($r_sanitario == 1) { ?>

            document.form1.registrosanitario.value = "";
        <?php } ?>
        //        *****************************************************

        document.form1.des.value = "";
        document.form1.des.focus();
        document.form1.factor.value = "";
        document.form1.blister.value = "";
        document.form1.price.value = "";

        document.getElementById("1").innerHTML = "0.00";
        document.getElementById("2").innerHTML = "0.00";
        document.getElementById("3").innerHTML = "0.00";
        document.getElementById("4").innerHTML = "0.00";
        document.getElementById("5").innerHTML = "0.00";
        document.getElementById("6").innerHTML = "0.00";
        document.getElementById("7").innerHTML = "0.00";
        //        document.getElementById("pv2").innerHTML = "0.00";
        //        document.getElementById("pv1").innerHTML = "0.00";



        //--document.form1.price1.value = "";
        //        document.form1.price2.value = "";
        //        document.form1.price3.value = "";
        document.form1.cod_bar.value = "";
        document.form1.cod_cuenta.value = "";
        document.form1.img.value = "";
        //        document.form1.pv1.value = "";
        //        document.form1.pv2.value = "";
        //document.form1.igv.value = "";
        //document.form1.inc.value = "";
        //document.form1.lotec.value = "";
        document.form1.textdesc.value = "";
        document.form1.price.value = "0.00";
        //--document.form1.price1.value="0.00";
        //        document.form1.price2.value = "0.00";
        //        document.form1.price3.value = "0.00";
        //        document.form1.price4.value = "0.00";


        document.form1.sstock.value = "0F0";


        document.form1.val.value = 1;


        var m1x = document.form1.marca.value;
        var l1x = document.form1.line.value;
        var c1x = document.form1.clase.value;
        var p1x = document.form1.present.value;

        if (m1x != 0) {

            var marca1 = document.getElementById("marca");
            marca1.remove(marca1.selectedIndex);
        }

        if (l1x != 0) {
            var line1 = document.getElementById("line");
            line1.remove(line1.selectedIndex);
        }

        if (c1x != 0) {
            var clase1 = document.getElementById("clase");
            clase1.remove(clase1.selectedIndex);
        }

        if (p1x != 0) {
            var present1 = document.getElementById("present");
            present1.remove(present1.selectedIndex);

        }

        /*var z=dhtmlXComboFromSelect("marca");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("line");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("clase");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("present");
         z.enableFilteringMode(true);*/
        var v1 = parseInt(document.form1.fincod.value);
        v1 = v1 + 1;
        document.form1.codigo.value = v1;
        document.form1.cod_nuevo.value = v1;
        document.form1.rd.value = 1;
        document.form1.rd1.value = 1;
    }

    function buton3() {
        document.form1.des.disabled = false;
        document.form1.des.focus();
        document.form1.factor.disabled = false;
        document.form1.digemid.disabled = false;
        <?php if ($r_sanitario == 1) { ?>

            document.form1.registrosanitario.disabled = false;
        <?php } ?>
        document.form1.blister.disabled = false;
        document.form1.marca.disabled = false;
        document.form1.moneda.disabled = false;
        document.form1.line.disabled = false;
        document.form1.clase.disabled = false;
        document.form1.present.disabled = false;
        document.form1.price.disabled = false;
        //--document.form1.price1.disabled = false;
        //        document.form1.price2.disabled = true;
        //        document.form1.price3.disabled = true;
        document.form1.cod_bar.disabled = false;
        document.form1.cod_cuenta.disabled = false;
        document.form1.img.disabled = true;
        document.form1.igv.disabled = false;
        //document.form1.inc.disabled = false;
        document.form1.lotec.disabled = false;
        document.form1.textdesc.disabled = false;
        document.form1.rd.disabled = false;
        document.form1.rd1.disabled = false;
        ///	botones
        document.form1.printer.disabled = true;
        document.form1.modif.disabled = true;
        document.form1.nuevo.disabled = true;
        document.form1.save.disabled = false;
        document.form1.del.disabled = true;
        document.form1.first.disabled = true;
        document.form1.prev.disabled = true;
        document.form1.next.disabled = true;
        document.form1.fin.disabled = true;
        document.form1.ext.disabled = false;
        document.form1.val.value = 2;

        //        para editar los precios en mismo modulo de productos
        document.form1.ncostre.disabled = true;
        document.form1.nmargene.disabled = true;
        document.form1.nprevta.disabled = true;
        document.form1.nmargenblister.disabled = true;
        document.form1.npreuni.disabled = true;
        document.form1.nmargenuni.disabled = true;
        document.form1.npreblister.disabled = true;
        /*var z=dhtmlXComboFromSelect("marca");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("line");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("clase");
         z.enableFilteringMode(true);
         var z=dhtmlXComboFromSelect("present");
         z.enableFilteringMode(true);*/

        var v1 = parseInt(document.form1.ppg.value);
        document.form1.pageno.value = v1;
        document.form1.codigo.focus();
        document.form1.rd.value = 1;
        document.form1.rd1.value = 1;
    }

    function precio() {
        var v1 = parseFloat(document.form1.price1.value); //PRECIO DE COSTO
        //        var v2 = parseFloat(document.form1.price2.value);		//MARGEN
        var factr = parseFloat(document.form1.factor.value); //FACTOR
        var valor = isNaN(factr);
        if (valor == true) ////NO ES NUMERO
        {
            var factr = parseFloat(document.form1.factor.value); //FACTOR
        }
        var a, b;
        a = parseFloat(v1 * ((v2 / 100) + 1));
        a = Math.round(a * 100) / 100;
        if (factr > 0) {
            b = parseFloat(a / factr);
            b = Math.round(b * 100) / 100;
        }
        if (document.form1.price1.value != '' && document.form1.price2.value != '') {
            //            document.form1.price3.value = a;
            //            document.form1.price33.value = a;
            //            document.form1.price4.value = b;
            //            document.form1.price44.value = b;
        } else {
            //            document.form1.price3.value = '';
            //            document.form1.price33.value = '';
            //            document.form1.price4.value = '';
            //            document.form1.price44.value = '';
        }

    }

    function validar() {
        var f = document.form1;


        if (f.des.value == "") {
            alert("Ingrese el nombre del Producto");
            f.des.focus();
            return;
        }
        if (f.factor.value == "") {
            alert("Ingrese el Factor");
            f.factor.focus();
            return;
        }
        /*if ((f.price1.value == "0.00") || (f.price1.value == ""))
         { alert("Ingrese el Precio de Costo"); f.price1.focus(); return; }
         if (f.price2.value < utdmin)
         {
         alert("La utilidad ingresada no corresponde segun la configuracion del Sistema"); document.form1.price2.focus();return;
         }
         else
         {
         if ((f.price2.value == "0.00") || (f.price2.value == ""))
         { alert("Ingrese el Margen de Utilidad"); f.price2.focus(); return; }
         }
         if ((f.price3.value == "0.00") || (f.price3.value == ""))
         { alert("Ingrese el Precio de Venta"); f.price3.focus(); return; }
         */
        if ((f.marca.value == "") || (f.marca.value == 0)) {
            alert("Seleccione una Marca");
            f.marca.focus();
            return;
        }
        if ((f.line.value == "") || (f.line.value == 0)) {
            alert("Seleccione un Principio Activo");
            f.line.focus();
            return;
        }
        if ((f.clase.value == "") || (f.clase.value == 0)) {
            alert("Seleccione una Accion terapeutica");
            f.clase.focus();
            return;
        }
        if ((f.present.value == "") || (f.present.value == 0)) {
            alert("Seleccione una Presentacion");
            f.present.focus();
            return;
        }
        if (f.blister.value > 0) {

            if ((f.npreblister.value > f.npreuni.value)) {
                alert("El precio de blister no puede ser mayor o igual al precio de unidad");
                f.npreblister.focus();
                return;
            }
            if ((f.npreblister.value == 0) || ((f.npreblister.value == ""))) {
                //alert("El precio de blister no puede ser cero porque el blister es mayor a 0");
                //f.npreblister.focus();
                //return;
            }
        }
        //VENTANA QUE CONFIRMA SI GRABO O NO?
        ventana = confirm("Desea Grabar estos datos");
        if (ventana) {
            document.form1.btn.value = 4;
            f.method = "POST";
            f.action = "graba_producto.php";
            f.submit();
        }
        ///////////////////////////////////
    }
</script>
<script language="JavaScript">
    function primero() {
        var f = document.form1;
        var v1 = parseInt(document.form1.first.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_prod.php";
        f.submit();
    }

    function siguiente() {
        var f = document.form1;
        var v1 = parseInt(document.form1.nextpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_prod.php";
        f.submit();
    }

    function anterior() {
        var f = document.form1;
        var v1 = parseInt(document.form1.prevpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_prod.php";
        f.submit();
    }

    function ultimo() {
        var f = document.form1;
        var v1 = parseInt(document.form1.lastpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_prod.php";
        f.submit();
    }
</script>
<script language="JavaScript">
    function eliminar() {
        var f = document.form1;
        ventana = confirm("Desea Eliminar este Producto");
        if (ventana) {
            document.form1.btn.value = 5;
            f.method = "POST";
            f.action = "graba_producto.php";
            f.submit();
        }
    }

    function eliminarkardex() {

        //alert("este producto tiene movimiento imposible eliminar");
        //alertify.error("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php //echo "NO SE PUDO ELIMINAR EL PRODUCTO SELECCIONADO POSEE MOVIMIENTOS EN KARDEX";                                          
                                                                                                        ?></p>");

        var f = document.form1;
        ventana = confirm("No se pudo eliminar el producto seleccionado posee movimientos en kardex, Desea Eliminar este Producto?");
        if (ventana) {
            document.form1.btn.value = 5;
            f.method = "POST";
            f.action = "graba_producto.php";
            f.submit();
        }


    }

    function eliminarstock() {
        //   alert("este producto tiene stock imposible eliminar");

        alertify.error("<p style='color:White;font-size:15px;font-weight: bold;text-align:center;'><?php echo "NO SE PUDO ELIMINAR EL PRODUCTO SELECCIONADO AUN TIENE STOCK"; ?></p>");
    }

    function salir() {
        var f = document.form1;
        document.form1.btn.value = 6;
        f.method = "POST";
        f.action = "graba_producto.php";
        f.submit();
    }
</script>