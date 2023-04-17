<script language="javascript">
    function nuevoAjax() {
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }

        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }

    function cargarContenido() {
       // alert("prueba");
        ////SUMAR DIA FECHA///////
        var num = document.form1.plazo.value;
        f = document.form1.date1.value;
       // alert('fecha = ' + f);
        // pasaremos la fecha a formato mm/dd/yyyy  yyyy/mm/dd  dd/mm/yyyy
        f = f.split('/');
        f = f[1] + '/' + f[0] + '/' + f[2];
        var hoy = new Date(f);
        hoy.setTime(hoy.getTime() + num * 24 * 60 * 60 * 1000);
        var mes = hoy.getMonth() + 1;
        if (mes < 9)
            mes = '0' + mes;
        //fecha=hoy.getFullYear()+'/'+mes+'/'+hoy.getDate(); 
        fecha = hoy.getDate() + '/' + mes + '/' + hoy.getFullYear();
        document.form1.date2.value = fecha;
        //        var date1, plazo, n1, n2, moneda, date2, contenedor,dafecto,dinafecto,digv,dtotal;
        var date1, plazo, n1, n2, date2, contenedor, dafecto, dinafecto, digv, dtotal;
        //contenedor = document.getElementById('contenedor');
        date1 = document.form1.date1.value;
        date2 = document.form1.date2.value;
        plazo = document.form1.plazo.value;
        fpag = document.form1.fpago.value;
        n1 = document.form1.n1.value;
        n2 = document.form1.n2.value;
        //        moneda = document.form1.moneda.value;

        dafecto = document.form1.dafecto.value;
        dinafecto = document.form1.dinafecto.value;
        digv = document.form1.digv.value;
        dtotal = document.form1.dtotal.value;


        ajax = nuevoAjax();
        //        ajax.open("GET", "actualiza_compra.php?plazo=" + plazo + "&n1=" + n1 + "&n2=" + n2 + "&moneda=" + moneda + "&date1=" + date1 + "&date2=" + date2 + "&fpag=" + fpag, true);
        //        ajax.open("GET", "actualiza_compra.php?plazo=" + plazo + "&n1=" + n1 + "&n2=" + n2 + "&moneda=" + moneda + "&date1=" + date1 + "&date2=" + date2 + "&dafecto=" + dafecto + "&dinafecto=" + dinafecto + "&digv=" + digv+ "&dtotal=" + dtotal+ "&fpag=" + fpag , true);
        ajax.open("GET", "actualiza_compra.php?plazo=" + plazo + "&n1=" + n1 + "&n2=" + n2 + "&date1=" + date1 + "&date2=" + date2 + "&dafecto=" + dafecto + "&dinafecto=" + dinafecto + "&digv=" + digv + "&dtotal=" + dtotal + "&fpag=" + fpag, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                contenedor.innerHTML = ajax.responseText
            }
        }
        ajax.send(null)
    }
</script>