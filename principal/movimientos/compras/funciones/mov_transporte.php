<script language="JavaScript">
function nuevo_movtransp1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.action ="mov_transp2.php";
	 f.submit();
}
function back_movtransp1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target ="_top";
	 f.action ="mov_tablas.php";
	 f.submit();
}
function salir1()
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
function atras_movtransp2()
{
	 var f = document.form1;
	 f.target ="_top";
	 f.action ="mov_transp.php";
	 f.submit();
}
function save_movtransp2()
{
  var f = document.form1;
  if (f.desc.value == "")
  { alert("Ingrese una Descripcion"); f.desc.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_transp3.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>
<script language="JavaScript">
function atras_movtransp4()
{
	 var f = document.form1;
	 f.method = "post";
	 f.action ="mov_transp1.php";
	 f.submit();
}
function save_movtransp4()
{
  var f = document.form1;
  if (f.desc.value == "")
  { alert("Ingrese una Descripcion"); f.desc.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_transp3.php";
  f.submit();
  }
  ///////////////////////////////////
}
</script>
<SCRIPT language="JavaScript">
function atras_movtransp5()
{
	 var f = document.form1;
	 f.method = "post";
	 f.action ="mov_transp1.php";
	 f.submit();
}
function del_movtabla5()
{
  var f = document.form1;
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Eliminar estos datos");
  if (ventana) {
  f.method = "POST";
  f.action ="mov_transp3.php";
  f.submit();
  }
  ///////////////////////////////////
}
</SCRIPT>
<SCRIPT language="JavaScript">
function st(){
  document.form1.desc.focus();
}
function su(){
  document.form1.abrev.focus();
}
</SCRIPT>