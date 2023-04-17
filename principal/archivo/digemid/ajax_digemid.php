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
////SUMAR DIA FECHA///////


        var  CodEstab;
        CodEstab = document.form1.CodEstab.value;
        ajax = nuevoAjax();
        ajax.open("GET", "actualiza_digmid.php?CodEstab=" + CodEstab, true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                contenedor.innerHTML = ajax.responseText
            }
        }
        ajax.send(null)
    }

</script>