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
function nuevo_movtablas1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.action ="mov_tablas7.php";
	 f.submit();
}
function salir_movtablas1()
{
  var f = document.form1;
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  f.method = "POST";
  f.target ="_top";
  f.action ="../index.php";
  f.submit();
  ///////////////////////////////////
}
</script>
<script language="JavaScript">
function atras_movtablas2()
{
	 var f = document.form1;
	 f.target ="_top";
	 f.action ="mov_tablas.php";
	 f.submit();
}
function nuevo_movtablas2()
{
	 var f = document.form1;
	 f.action ="mov_tablas3.php";
	 f.submit();
}
</script>
<script language="JavaScript">
function atras_movtablas3()
{
	 var f = document.form1;
	 f.method = "post";
	 f.action ="mov_tablas2.php";
	 f.submit();
}
function save_movtabla3()
{
  var f = document.form1;
  if (f.tipodes.value == "MARCA")
  {
  	if (f.abrev.value == "")
	{ alert("Ingrese una Abreviatura"); f.abrev.focus(); return; }
  }
  if (f.desc.value == "")
  { alert("Ingrese una Descripcion"); f.desc.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana)
  {
  f.method = "POST";
  f.action ="mov_tablas4.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>
<SCRIPT language="JavaScript">
function st(){
  document.form1.desc.focus();
}
function su(){
  document.form1.abrev.focus();
}
</SCRIPT>
<SCRIPT language="JavaScript">
function back_movtabla5()
{
	 var f = document.form1;
	 f.method = "post";
	 f.action ="mov_tablas2.php";
	 f.submit();
}
function save_movtabla5()
{
  var f = document.form1;
  if (f.desc.value == "")
  { alert("Ingrese una Descripcion"); f.desc.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_tablas4.php";
  f.submit();
  }
  ///////////////////////////////////
}
</SCRIPT>
<SCRIPT language="JavaScript">
function del_movtabla6()
{
  var f = document.form1;
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Eliminar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_tablas4.php";
  f.submit();
  }
  ///////////////////////////////////
}
</SCRIPT>
<script language="JavaScript">
function atras_movtablas7()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target ="_top";
	 f.action ="mov_tablas.php";
	 f.submit();
}
function save_movtabla7()
{
  var f = document.form1;
  if (f.abrev.value == "")
  { alert("Ingrese una Abreviatura"); f.abrev.focus(); return; }
  if (f.desc.value == "")
  { alert("Ingrese una Descripcion"); f.desc.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_tablas8.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>