<script language="JavaScript">
function inic(){
document.form1.num.focus();
document.form1.save.disabled = true;
document.form1.fecha2.disabled = true;
}
function update(){
document.form1.numero.focus();
document.form1.save.disabled = false;
document.form1.modif.disabled = true;
document.form1.ext.disabled = true;
document.form1.del.disabled = true;
document.form1.del1.disabled = true;
document.form1.fecha2.disabled = false;
}
function modificar(){
var f = document.form1;
f.method = "POST";
f.action ="consult_compras1.php";
f.submit();
}
function eliminar(){
	 var f = document.form1;
	 ventana=confirm("Desea Habilitar esta Compra");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="cons_hab_transf_sal.php";
	 f.submit();
	 }
}
function eliminar1(){
	 var f = document.form1;
	 ventana=confirm("Desea Deshabilitar esta Compra");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="cons_des_transf_sal.php";
	 f.submit();
	 }
}
function consult_validar()
{
	  var f = document.form1;
	  if (f.num.value == "")
	  { alert("Ingrese el Nro del Documento"); f.num.focus(); return; }
	  f.method = "POST";
	  document.form1.upd.value = 0;
	  f.action ="cons_transferencia_sal1.php";
	  f.submit();
}
function cancelar_consult()
{
	 var f = document.form1;
	 ventana=confirm("Desea cancelar esta Consulta");
	 if (ventana) {
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="cons_transferencia_sal.php";
	 f.submit();
	 }
}
function salir_consult()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../ing_salid.php";
	 f.submit();
}
function validar_prod(){
  var f = document.form1;
  var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
  var valor = isNaN(v1);
		if (valor == true)
		{
		document.form1.number.value=1;		////avisa que no es numero
		}
		else
		{
		document.form1.number.value=0;		////avisa que es numero
		}
  if ((f.text1.value == "") || (f.text1.value == "0"))
  { alert("Ingrese una Cantidad"); f.text1.focus(); return; }
  if ((f.text2.value == "") || (f.text2.value == "0.00"))
  { alert("Ingrese el Precio"); f.text2.focus(); return; }
  //VENTANA QUE CONFIRMA SI GRABO O NO?
  ventana=confirm("Desea Grabar estos datos");
  if (ventana) {
  f.method = "POST";
  f.target = "_top";
  f.action ="consult_reg_compras.php";
  f.submit();
  }
}
function precio(){
		if (document.form1.text3.value == "")
		{
		document.form1.text3.value = 0;
		}
		if (document.form1.text4.value == "")
		{
		document.form1.text4.value = 0;
		}
		if (document.form1.text5.value == "")
		{
		document.form1.text5.value = 0;
		}
		var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
		var v2 = parseFloat(document.form1.text2.value);		//PRECIO
		var v3 = parseFloat(document.form1.text3.value);		//DESCUENTO1
		var v4 = parseFloat(document.form1.text4.value);		//DESCUENTO2
		var v5 = parseFloat(document.form1.text5.value);		//DESCUENTO3
		var factor = parseFloat(document.form1.factor.value);	//FACTOR
		var stock  = parseFloat(document.form1.stockpro.value);	//STOCK ACTUAL
		var p  = parseFloat(document.form1.porcentaje.value);	//PORCENTAJE
		var a;
		var b;
		var c;
		var pventa;
		var total;
		var porcent;
		var promedio;
		a = parseFloat(1 - (v3/100));
		b = parseFloat(1 - (v4/100));
		c = parseFloat(1 - (v5/100));
		if (document.form1.porcentaje.value =="")
		{
		porcent = 1;
		pventa = parseFloat(v2 * (a * b * c) * porcent);
		}
		else
		{
		porcent = parseFloat(1 + (p/100));
		pventa = parseFloat(v2 * (a * b * c) * porcent);
		}
		var valor = isNaN(v1);
		if (valor == true)
		{
		//var porcion = v1.substring(1); // porcion = "ndo"
		var porcion = document.form1.text1.value.substring(1);
		var fact	= parseFloat(porcion/factor);
		total   = parseFloat(fact * pventa);
		document.form1.number.value=1;		////avisa que no es numero
		}
		else
		{
		total  = parseFloat(v1 * pventa);
		document.form1.number.value=0;		////avisa que es numero
		}
		if(document.form1.text1.value!='' && document.form1.text2.value!=''){
			document.form1.text6.value=pventa;
			document.form1.text7.value=total;
		}else{
			document.form1.text6.value='';
			document.form1.text7.value='';
		}

}
function validar_grid(){
  var f = document.form1;
  f.method = "post";
  f.action ="consult_compras2.php";
  f.submit();
}
</script>