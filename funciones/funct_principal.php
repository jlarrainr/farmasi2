<SCRIPT LANGUAGE="JavaScript">
  function imprimir() {
    if (window.print)
      window.print()
    else
      alert("Disculpe, su navegador no soporta esta opci�n.");
    return false;
  }
  var nav4 = window.Event ? true : false;

  function decimal(evt) {
    var key = nav4 ? evt.which : evt.keyCode;
    return (key <= 13 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57));
  }
  var nav4 = window.Event ? true : false;

  function acceptNum(evt) {
    var key = nav4 ? evt.which : evt.keyCode;
    return (key <= 13 || key == 37 || key == 39 || (key >= 48 && key <= 57));
  }
  var nav4 = window.Event ? true : false;

  function f(evt) {
    var key = nav4 ? evt.which : evt.keyCode;
    return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
  }
  var nav4 = window.Event ? true : false;

  function c(evt) {
    var key = nav4 ? evt.which : evt.keyCode;
    return (key == 67 || key == 99 || (key <= 13 || (key >= 48 && key <= 57)));
  }
  var nav4 = window.Event ? true : false;

  function forma_pago(evt) {
    var key = nav4 ? evt.which : evt.keyCode;
    return (key == 99 || key == 101 || key == 116 || key == 67 || key == 69 || key == 84 || key == 8);
  }
  var popUpWin = 0;

  function popUpWindow(URLStr, left, top, width, height) {
    if (popUpWin) {
      if (!popUpWin.closed) popUpWin.close();
    }
    popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
  }
</script>