<script language="JavaScript">
  function salir1() {
    var f = document.form1;
    f.target = "_top";
    f.action = "../index.php";
    f.submit();
  }
</script>
<script language="JavaScript">
  function save_datosgen1() {
    var f = document.form1;
    if (f.desc.value == "") {
      alert("Ingrese una Descripcion");
      f.desc.focus();
      return;
    }
    if (f.igv.value == "") {
      alert("Ingrese el IGV");
      f.igv.focus();
      return;
    }

    //VENTANA QUE CONFIRMA SI GRABO O NO?
    ventana = confirm("Desea Grabar estos datos");
    if (ventana) {
      f.btn.value = 1;
      f.target = "_top";
      f.method = "POST";
      f.action = "graba_datos.php";
      f.submit();
    }
    ///////////////////////////////////
  }

  function save_datosgen2() {
    var f = document.form1;
    //if (f.ventas.value == 0)
    //{ alert("Ingrese condicion de la Venta"); f.venta.focus(); return; }
    if (f.limit.value == "") {
      alert("Ingrese un limite para la busqueda es Informacion");
      f.limit.focus();
      return;
    }
    ventana = confirm("Desea Grabar estos datos");
    if (ventana) {
      f.btn.value = 4;
      f.method = "POST";
      f.action = "graba_datos.php";
      f.submit();
    }
    ///////////////////////////////////
  }

  function sf() {
    document.form1.cliente.focus();;
  }
</script>