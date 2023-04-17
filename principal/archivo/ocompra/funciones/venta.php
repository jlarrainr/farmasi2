<script language="JavaScript">
function buscar_venta()
{
	  var f = document.form1;
	  if (f.num.value == "")
	  { alert("Ingrese el Nro del Documento"); f.num.focus(); return; }
	  f.method = "post";
	  f.action ="ventas1.php";
	  f.submit();
}
function nueva_venta()
{
	  var f = document.form1;
	  f.method = "post";
	  f.target = "_top";
	  f.action ="ventas_registro.php";
	  f.submit();
}
function salir()
{
	 var f = document.form1;
	 ventana=confirm("Desea salir de esta Aplicacion");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
	 }
}
function salir1()
{
	 var f = document.form1;
	 ventana=confirm("Desea salir de esta Aplicacion");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_salir.php";
	 f.submit();
	 }
}
function buscar()
{
	 var f = document.form1;
	 ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_buscar.php";
	 f.submit();
	 }
}
function cancelar()
{
	 var f = document.form1;
	 ventana=confirm("Desea cancelar esta venta");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_cancel.php";
	 f.submit();
	 }
}
function next_venta()
{
	 var f = document.form1;
	 ventana=confirm("Realizar Venta sin asignar Cliente");
	 if (ventana) {
	 f.method = "post";
	 f.target = "_top";
	 f.action ="ventas2.php";
	 f.submit();
	 }
}
function grabar1()
{
	 var f = document.form1;
	 ventana=confirm("Desea Grabar esta Venta");
	 if (ventana) {
	 f.method = "post";
	 f.target = "_top";
	 f.action ="venta_reg.php";
	 f.submit();
	 }
}
function precio()
{
	var v1 		= parseFloat(document.form1.text1.value);		//CANTIDAD
	var v2 		= parseFloat(document.form1.text2.value);		//PRECIO
	var factor  = parseFloat(document.form1.factor.value);		//FACTOR
	var total;
	var valor   = isNaN(v1);
		if (valor == true)			////NO ES NUMERO
		{
		var v1  = document.form1.text1.value.substring(1);	
		v1		= parseFloat(v1 * factor);
		total   = parseFloat(v1 * v2);
		}
		else
		{
		total   = parseFloat(v1 * v2);
		}
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	if(document.form1.text1.value!=''){
			document.form1.text3.value=total;
	}else{
			document.form1.text3.value='';
	}
}
function precio1()
{
	var v1 		= parseFloat(document.form1.t1.value);			//CANTIDAD
	var v2 		= parseFloat(document.form1.t2.value);			//PRIPRO
	var factor  = parseFloat(document.form1.factor.value);		//FACTOR
	var total;
	var valor = isNaN(v1);
		if (valor == true)			////NO ES NUMERO
		{
		var v1 = document.form1.t1.value.substring(1);	
		v1		= parseFloat(v1 * factor);
		total   = parseFloat(v1 * v2);
		}
		else
		{
		total   = parseFloat(v1 * v2);
		}
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	if(document.form1.t1.value!=''){
			document.form1.t3.value=total;
	}else{
			document.form1.t3.value='';
	}
}
function add_item()
{
	var f = document.form1;
	  var v1 	 = parseFloat(document.form1.text1.value);			//CANTIDAD NGRESADA
	  var factor = parseFloat(document.form1.factor.value);			//FACTOR
	  var st 	 = parseFloat(document.form1.cant_prod.value);		//CANTIDAD ACTUAL POR LOCAL
	  if (f.text1.value == "")
	  { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
  		var valor = isNaN(v1);
		if (valor == true)									////NO ES NUMERO
		{
		document.form1.numero.value=1;		////avisa que no es numero
		var v1 = document.form1.text1.value.substring(1);	
		v1		= parseFloat(v1 * factor);
		}
		else
		{
		document.form1.numero.value=0;		////avisa que es numero
		v1      = v1;						////ES NUMERO
		}
	  if (v1>st)
  	  { alert("La cantidad Ingresada excede al Stock Actual del Producto"); f.text1.focus(); return; }
	  f.method = "post";
	  //f.target = "_top";
	  f.action ="venta_index2_reg.php";
	  f.submit();
}
function validar_prod(){
  var f = document.form1;
  var v1 = parseFloat(document.form1.t1.value);				//CANTIDAD NGRESADA
  var st = parseFloat(document.form1.stockpro.value);		//CANTIDAD ACTUAL POR LOCAL
  var sw = parseFloat(document.form1.cantemp.value);		//CANTIDAD AGREGADA EN LA COMPRA
  var factor = parseFloat(document.form1.factor.value);		//FACTOR
  st = st + sw;
  if ((f.t1.value == "") || (f.t1.value == "0"))
  { alert("Ingrese una Cantidad"); f.t1.focus(); return; }
  var valor = isNaN(v1);
		if (valor == true)									////NO ES NUMERO
		{
		document.form1.number.value=1;		////avisa que no es numero
		var v1 = document.form1.t1.value.substring(1);	
		v1		= parseFloat(v1 * factor);
		}
		else
		{
		document.form1.number.value=0;		////avisa que es numero
		v1      = v1;						////ES NUMERO
		}
  if (v1>st)
  { alert("La cantidad Ingresada excede al Stock Actual del Producto"); f.t1.focus(); return; }
  f.method = "post";
  f.target = "_top";
  f.action ="venta_index3_reg.php";
  f.submit();
}
function primero()
{
	 var f = document.form1;
	 document.form1.tip.value = 0;
	 var v1 = parseInt(document.form1.first.value);
	 document.form1.pageno.value=v1;
	 f.method = "post";
	 f.action ="ventas1.php";
	 f.submit();
}
function siguiente()
{
	 var f = document.form1;
	 document.form1.tip.value = 0;
	 var v1 = parseInt(document.form1.nextpage.value);
	 document.form1.pageno.value=v1;
	 f.method = "post";
	 f.action ="ventas1.php";
	 f.submit();
}
function anterior()
{
	 var f = document.form1;
	 document.form1.tip.value = 0;
	 var v1 = parseInt(document.form1.prevpage.value);
	 document.form1.pageno.value=v1;
	 f.method = "post";
	 f.action ="ventas1.php";
	 f.submit();
}
function ultimo()
{
	 var f = document.form1;
	 document.form1.tip.value = 0;
	 var v1 = parseInt(document.form1.lastpage.value);
	 document.form1.pageno.value=v1;
	 f.method = "post";
	 f.action ="ventas1.php";
	 f.submit();
}
function validar_grid(){
  	var f = document.form1;
  f.method = "post";
  f.action ="venta_index3.php";
  f.submit();
}
function eliminar(){
	 var f = document.form1;
	 ventana=confirm("Desea Habilitar esta VENTA");
	 if (ventana) {
	 f.method = "post";
	 f.target = "_top";
	 f.action ="hab_salidas_varias.php";
	 f.submit();
	 }
}
function eliminar1(){
	 var f = document.form1;
	 ventana=confirm("Desea Deshabilitar esta VENTA");
	 if (ventana) {
	 f.method = "post";
	 f.target = "_top";
	 f.action ="des_salidas_varias.php";
	 f.submit();
	 }
}
function abrir_index1(e) {
tecla=e.keyCode
  if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=270,width=525,height=290');
  }
  if(tecla==119)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Venta Incompleta. Imposible Grabar"); f.num.focus(); return; 
	 }
	 else
	 {
	 	 ventana=confirm("Desea Grabar esta Venta");
		 if (ventana) {
		 f.method = "post";
		 f.target = "_top";
		 f.action ="venta_reg.php";
		 f.submit();
		 }
	 }
  }
  if(tecla==120)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Venta Incompleta. Imposible de Imprimir"); f.num.focus(); return; 
	 }
	 else
	 {
	  window.open('imprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=200,width=785,height=560');
	 }
  }
}
function abrir_index2(e) {
tecla=e.keyCode
  if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=525,height=290');
  }
  if(tecla==119)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Venta Incompleta. Imposible Grabar"); f.num.focus(); return; 
	 }
	 else
	 {
	 	 ventana=confirm("Desea Grabar esta Venta");
		 if (ventana) {
		 f.method = "post";
		 f.target = "_top";
		 f.action ="venta_reg.php";
		 f.submit();
		 }
	 }
  }
  if(tecla==120)
  {
  	 var f = document.form1;
	 var act = document.form1.activado.value;
	 var act1 = document.form1.activado1.value;
	 if ((act == 0) || (act1 > 1))
	 {
		 alert("Venta Incompleta. Imposible de Imprimir"); f.num.focus(); return; 
	 }
	 else
	 {
  	  window.open('imprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
	 }
  }
}
function sf(){
document.form1.country.focus();
}
function st(){
document.form1.text1.focus();
}
function sb(){
document.form1.buscar.focus();
}
function ad(){
document.form1.t1.focus();
}
function fc(){
document.form1.num.focus();
}
function getfocus(){
document.getElementById('l1').focus()
}
</script>