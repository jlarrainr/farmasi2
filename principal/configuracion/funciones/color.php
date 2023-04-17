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
function save_color()
{
  var f = document.form1;
   if (f.text.value == "")
  { alert("Seleccione un Color"); f.text.focus(); return; }
   if (f.text1.value == "")
  { alert("Seleccione un Color"); f.text1.focus(); return; }
   if (f.text2.value == "")
  { alert("Seleccione un Color"); f.text2.focus(); return; }
   if (f.text3.value == "")
  { alert("Seleccione un Color"); f.text3.focus(); return; }
   if (f.text4.value == "")
  { alert("Seleccione un Color"); f.text4.focus(); return; }
   if (f.text5.value == "")
  { alert("Seleccione un Color"); f.text5.focus(); return; }
   if (f.text6.value == "")
  { alert("Seleccione un Color"); f.text6.focus(); return; }
   if (f.text7.value == "")
  { alert("Seleccione un Color"); f.text7.focus(); return; }
   if (f.text8.value == "")
  { alert("Seleccione un Color"); f.text8.focus(); return; }
   if (f.text9.value == "")
  { alert("Seleccione un Color"); f.text9.focus(); return; }
   if (f.text10.value == "")
  { alert("Seleccione un Color"); f.text10.focus(); return; }
   if (f.text11.value == "")
  { alert("Seleccione un Color"); f.text11.focus(); return; }
   if (f.text12.value == "")
  { alert("Seleccione un Color"); f.text12.focus(); return; }
   if (f.text13.value == "")
  { alert("Seleccione un Color"); f.text13.focus(); return; }
   if (f.text14.value == "")
  { alert("Seleccione un Color"); f.text14.focus(); return; }
   if (f.text15.value == "")
  { alert("Seleccione un Color"); f.text15.focus(); return; }
   if (f.text16.value == "")
  { alert("Seleccione un Color"); f.text16.focus(); return; }
   if (f.text17.value == "")
  { alert("Seleccione un Color"); f.text17.focus(); return; }
  if (f.text19.value == "")
  { alert("Seleccione un Color"); f.text19.focus(); return; }
  if (f.text20.value == "")
  { alert("Seleccione un Color"); f.text20.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.btn.value = 3;
  f.method = "POST";
  f.action ="graba_datos.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>