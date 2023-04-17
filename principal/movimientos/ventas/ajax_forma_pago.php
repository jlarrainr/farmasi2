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
    var pago, contenedor;
    document.form1.fpago.value = document.form1.fpago.value.toUpperCase();
    document.form1.ndias.value = document.form1.ndias.value;
    
    contenedor = document.getElementById('contenedor');
    pago = document.form1.fpago.value;
    dias = document.form1.ndias.value;
    
    ajax = nuevoAjax();
    ajax.open("GET", "actualiza_forma_pago.php?pago=" + pago + "&dias=" + dias , true);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        contenedor.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)
  }
</script>