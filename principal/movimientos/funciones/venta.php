<script language="JavaScript">
function email(valor1) {
    
 var valor1;
 
 
var opcion = prompt("Introduzca un correo", valor1);
 
  if (opcion == null || opcion == "") {
     //   mensaje = "Has cancelado o introducido el nombre vacío";
        alert("Ingrese el Correo Electronico, Operacion no valida");  return;
        
        } else {
         var f = document.form1;
         f.method = "post";
    	 f.target = "_top";
    	 //f.action ="reimpimercorreo.php?correo="+valor;
    	 f.action ="reimpimercorreo.php?correo="+opcion;
	     f.submit();
        }
  
}
function buscar_venta()
{
	  var f = document.form1;
	  if (f.num.value == "")
	  { alert("Ingrese el Nro del Documento"); f.num.focus(); return; }
	  f.method = "post";
	  f.action ="ventas1.php";
	  f.submit();
}

var nav4 = window.Event ? true : false;
	function ent1(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			var f = document.form1;

		var f = document.form1;
	  if (f.num.value == "")
	  { alert("Ingrese el Nro del Documento"); f.num.focus(); return; }
	  f.method = "post";
	  f.action ="ventas1.php";
	  f.submit();
		}
		return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
	}



function prints(valor) {
var valor;
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open("ventas2_1.php?invnum="+valor,"",opciones);
return false;
}
function descargar_venta(valor)
{
    var valor;
    //alert(valor); return; 
	  var f = document.form1;
	  f.method = "post";
	  f.target = "_top";
	  f.action ="crearPdf.php?invnum="+valor;
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
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function salir1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_salir.php";
	 f.submit();
}
function buscar()
{
	 var f = document.form1;
	 //ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
	 //if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="ventas_buscar.php";
	 f.submit();
	 //}
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
		v1	   = parseFloat(v1 * factor);
		}
		else
		{
		document.form1.numero.value=0;		////avisa que es numero
		v1      = v1;						////ES NUMERO
		}
	  if (v1>st)
  	  { 
	  //alert("La cantidad Ingresada excede al Stock Actual del Producto"); 
	  ventana=confirm("La cantidad Ingresada excede al Stock Actual del Producto ¿Desea Grabar esta informacion?");
	     if (ventana) 
		 {
		  f.method = "post";
		  f.target = "venta_principal";
		  f.action ="venta_index2_reg.php";
		  f.submit();
		 }
		 else
		 {
		 f.text1.focus();
		 return; 
		 }
	  }
	  else
	  {
	  f.method = "post";
	  f.target = "venta_principal";
	  f.action ="venta_index2_reg.php";
	  f.submit();
	  }
}
var nav4 = window.Event ? true : false;
function letrac(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	  var f 	 = document.form1;
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
		v1	   = parseFloat(v1 * factor);
		}
		else
		{
		document.form1.numero.value=0;		////avisa que es numero
		v1      = v1;						////ES NUMERO
		}
	  if (v1>st)
  	  { 
	  //alert("La cantidad Ingresada excede al Stock Actual del Producto"); 
	  ventana=confirm("La cantidad Ingresada excede al Stock Actual del Producto ¿Desea Grabar esta informacion?");
	     if (ventana) 
		 {
		  f.method = "post";
		  f.target = "venta_principal";
		  f.action ="venta_index2_reg.php";
		  f.submit();
		 }
		 else
		 {
		 f.text1.focus();
		 return; 
		 }
	  }
	  else
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
		  f.method = "post";
		  f.target = "venta_principal";
		  f.action ="venta_index2_reg.php";
		  f.submit();
	  }
	}
	return (key == 67 || key == 99 ||key <= 13 || (key >= 48 && key <= 57));	
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
  f.target = "venta_principal";
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
// RECUPERA
function eliminar(){
	 var f = document.form1;
	 ventana=confirm("Desea Activar esta Venta");
	 if (ventana) {
	 f.method = "post";
	 f.target = "_top";
	 f.action ="hab_salidas_varias.php";
	 f.submit();
	 }
}
// ANULAR
function eliminar1() {
		var f = document.form1;
		alertify
			.confirm("<h1 style='color:red;font-family:Arial, Helvetica;font-size:60px;'><strong><center>CUIDADO</center></strong></h1>", "<h3 style='font-family:Arial, Helvetica;font-size:20px;margin-top: -55px;'>Desea Anular esta Venta, tenga en cuenta que luego no podra ser recuperada?</h3>",
				function() {
					alertify.success('Ok')

					var f = document.form1;
					f.method = "POST";
					f.target = "_top";
					f.action = "des_salidas_varias.php";
					f.submit();
				},
				function() {
					alertify.error('Cancel')
				}).set('labels', {
				ok: 'SI',
				cancel: 'NO'
			});



		// ventana = confirm("<h2>Desea Anular esta Venta, tenga en cuenta que luego no podra ser recuperada<h2> ");
		// if (ventana) {
		// 	f.method = "post";
		// 	f.target = "_top";
		// 	f.action = "des_salidas_varias.php";
		// 	f.submit();
		// }
	}
function abrir_index1(e) {
tecla=e.keyCode
  if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=270,width=605,height=240');
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
  if(tecla==118)
  {
  	var codigo = document.form1.codigo_producto.value;	 //window.open('f7/f7.php?cod='+codigo+'','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=420');
	 window.open('ver_prod_loc.php?cod='+codigo+'','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=10,width=1100,height=150');
  }
  if(tecla==117)
  {
  	var codigo = document.form1.codigo_producto.value; //window.open('f6/f6.php?cod='+codigo+'','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=420');
	window.open('ver_prod.php?cod='+codigo+'','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=90,left=285,width=650,height=200');
  }
  if(tecla==113)
  {
  	 window.open('f2/f2.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=605,height=240');
  }
  /*if(tecla==119)
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
  }*/
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