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

    function cargarContenido( a) {
        
        
   /*  
        alert('vencimiento = '+ vencimiento);
        alert('numeroLote = '+ numeroLote);
        alert('idlote = '+idlote);*/
        
       
        
         var id_vencimiento = 'vencimiento' + a;
         var id_numeroLote = 'numeroLote' + a;
         var id_idlote = 'idlote' + a;
        
       /* alert('vencimiento = '+ id_vencimiento);
        alert('numeroLote = '+ id_numeroLote);
        alert('idlote = '+id_idlote);
        */
        vencimiento =  document.getElementById(id_vencimiento).value;
        numeroLote =  document.getElementById(id_numeroLote).value;
        idlote =  document.getElementById(id_idlote).value;
        ajax = nuevoAjax();
       
       
        ajax.open("GET", "actualiza_lote.php?vencimiento=" + vencimiento + "&numeroLote=" + numeroLote + "&idlote=" + idlote, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                contenedor.innerHTML = ajax.responseText
            }
        }
        ajax.send(null)
    }
</script>