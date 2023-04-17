<script language="JavaScript">
function salir1()
{
	 var f = document.form1;
	 f.target ="_top";
	 f.action ="../index.php";
	 f.submit();
}
</script>
<script language="JavaScript">
function save_datosgen1()
{
  var f = document.form1;
  if (f.pas1.value == "")
  { alert("Ingrese una Clave"); f.pas1.focus(); return; }
  if (f.pas2.value == "")
  { alert("Ingrese una Clave"); f.pas2.focus(); return; }
  if (f.pas3.value == "")
  { alert("Ingrese una Clave"); f.pas3.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.btn.value = 2;
  f.method = "POST";
  f.action ="graba_datos.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>