<script language="JavaScript">
	function buscar_venta() {
		var f = document.form1;
		if (f.num.value == "") {
			alert("Ingrese el Nro del Documento");
			f.num.focus();
			return;
		}
		f.method = "post";
		f.action = "devolucion1.php";
		f.submit();
	}

	function buscar_venta_no() {
		var f = document.form1;

		alert("CANCELA LA OPERACION DE NOTA DE CREDITO");

		// f.method = "post";
		// f.action = "devolucion1.php";
		// f.submit();
	}
	var nav4 = window.Event ? true : false;

	function ent1(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			var f = document.form1;
			if (f.num.value == "") {
				alert("Ingrese el Nro del Documento");
				f.num.focus();
				return;
			}
			f.method = "post";
			f.action = "devolucion1.php";
			f.submit();
		}
		return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
	}

	function ent12(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			var f = document.form1;
			alert("CANCELA LA OPERACION DE NOTA DE CREDITO");
		}
		return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
	}


	function buscar() {
		var f = document.form1;
		//ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
		//if (ventana) {
		f.method = "POST";
		f.target = "_top";
		f.action = "ventas_buscar.php";
		f.submit();
		//}
	}

	function cancelar() {
		var f = document.form1;
		// var count = f.count2.value; //CANTIDAD
		// if (count > 0) {
		ventana = confirm("Desea cancelar esta Nota de Credito");
		if (ventana) {
			f.method = "POST";
			f.target = "_top";
			f.action = "cancelar.php";
			f.submit();
		}
		// } else {
		// 	alert("No se encuentra cargada ningun documento operacion imposible");
		// }
	}

	var statSend = false;

	function grabar1() {

		if (!statSend) {

			var f = document.form1;
			ventana = confirm("Desea Grabar esta Nota de Credito");
			if (ventana) {
				f.method = "post";
				f.target = "_top";
				f.action = "grabar_devolucion.php";
				f.submit();

				statSend = true;
				return true;
			} else {
				return false;

			}

		} else {
			alert("El proceso esta siendo cargado espere un momento...");
			return false;
		}

	}

	function salir() {
		var f = document.form1;
		f.method = "post";
		f.target = "_top";
		f.action = "salirdevolucion.php";
		f.submit();
	}

	function precio() {
		var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
		var v2 = parseFloat(document.form1.text2.value); //PRECIO
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		var total;
		var valor = isNaN(v1);
		if (valor == true) ////NO ES NUMERO
		{
			var v1 = document.form1.text1.value.substring(1);
			v1 = parseFloat(v1 * factor);
			total = parseFloat(v1 * v2);
		} else {
			total = parseFloat(v1 * v2);
		}
		total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
		if (document.form1.text1.value != '') {
			document.form1.text3.value = total;
		} else {
			document.form1.text3.value = '';
		}
	}

	function precio1() {
		var v1 = parseFloat(document.form1.t1.value); //CANTIDAD
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		var canpro = parseFloat(document.form1.canpro.value);
		//         var st = parseFloat(document.form1.stockpro.value);
		var valor = isNaN(v1);
		if (valor == true) ////NO ES NUMERO
		{
			var v1 = document.form1.t1.value.substring(1);
		}

		/*if (v1 > canpro) {
			alert("Ingrese una Cantidad Menor o Diferente a 0");
			f.t1.focus();
			return;
		}*/



		//                if ((v1 == 0) || (v1 == ''))
		//		{ 
		//		alert('Debe ingresar un valor diferente a 0');document.form1.t1.focus();
		//		return;
		//		}


	}

	function add_item() {
		var f = document.form1;
		var v1 = parseFloat(document.form1.text1.value); //CANTIDAD NGRESADA
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		var st = parseFloat(document.form1.cant_prod.value); //CANTIDAD ACTUAL POR LOCAL
		if (f.text1.value == "") {
			alert("Ingrese una Cantidad");
			f.text1.focus();
			return;
		}
		var valor = isNaN(v1);
		if (valor == true) ////NO ES NUMERO
		{
			document.form1.numero.value = 1; ////avisa que no es numero
			var v1 = document.form1.text1.value.substring(1);
			v1 = parseFloat(v1 * factor);
		} else {
			document.form1.numero.value = 0; ////avisa que es numero
			v1 = v1; ////ES NUMERO
		}
		if (v1 > st) {
			alert("La cantidad Ingresada excede al Stock Actual del Producto");
			f.text1.focus();
			return;
		}
		f.method = "post";
		f.target = "venta_principal";
		f.action = "venta_index2_reg.php";
		f.submit();
	}



	var nav4 = window.Event ? true : false;

	function ent(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			var f = document.form1;

			var v1 = parseFloat(document.form1.t1.value); //CANTIDAD NGRESADA
			var st = parseFloat(document.form1.stockpro.value); //CANTIDAD ACTUAL POR LOCAL
			// var sw = parseFloat(document.form1.cantemp.value);		//CANTIDAD AGREGADA EN LA COMPRA
			var factor = parseFloat(document.form1.factor.value); //FACTOR
			//st = st + sw;
			st = st;
			/*if ((f.t1.value == "") || (f.t1.value == "0")) {
				alert("Ingrese una Cantidad");
				f.t1.focus();
				return;
			}*/
			var valor = isNaN(v1);
			if (valor == true) ////NO ES NUMERO
			{
				document.form1.number.value = 1; ////avisa que no es numero
				var v1 = document.form1.t1.value.substring(1);
				v1 = parseFloat(v1 * factor);
			} else {
				document.form1.number.value = 0; ////avisa que es numero
				v1 = v1; ////ES NUMERO
			}


			if (v1 > st) {
				alert("La cantidad Ingresada excede al Stock Actual del Producto");
				f.t1.focus();
				return;
			}

			f.method = "post";
			f.action = "venta_index3_reg.php";
			f.submit();
		}

		return (key == 67 || key == 99 || key <= 13 || (key >= 48 && key <= 57));
	}


	var nav4 = window.Event ? true : false;

	function ent2(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			var f = document.form1;

			var v1 = parseFloat(document.form1.t1.value); //CANTIDAD NGRESADA
			var st = parseFloat(document.form1.stockpro.value); //CANTIDAD ACTUAL POR LOCAL
			// var sw = parseFloat(document.form1.cantemp.value);		//CANTIDAD AGREGADA EN LA COMPRA
			var factor = parseFloat(document.form1.factor.value); //FACTOR
			//st = st + sw;
			st = st;
			/*if ((f.t1.value == "") || (f.t1.value == "0")) {
				alert("Ingrese una Cantidad");
				f.t1.focus();
				return;
			}*/
			var valor = isNaN(v1);
			if (valor == true) ////NO ES NUMERO
			{
				document.form1.number.value = 1; ////avisa que no es numero
				var v1 = document.form1.t1.value.substring(1);
				v1 = parseFloat(v1 * factor);
			} else {
				document.form1.number.value = 0; ////avisa que es numero
				v1 = v1; ////ES NUMERO
			}


			if (v1 > st) {
				alert("La cantidad Ingresada excede al Stock Actual del Producto");
				f.t1.focus();
				return;
			}

			f.method = "post";
			f.action = "venta_index3_reg.php";
			f.submit();
		}

		return (key <= 13 || (key >= 48 && key <= 57));


	}


	function validar_grid() {
		var f = document.form1;
		f.method = "post";
		f.action = "devolucion2.php";
		f.submit();
	}

	function validar_prod() {
		var f = document.form1;

		var v1 = parseFloat(document.form1.t1.value); //CANTIDAD NGRESADA
		var st = parseFloat(document.form1.stockpro.value); //CANTIDAD ACTUAL POR LOCAL
		// var sw = parseFloat(document.form1.cantemp.value);		//CANTIDAD AGREGADA EN LA COMPRA
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		//st = st + sw;
		st = st;
		/*if ((f.t1.value == "") || (f.t1.value == "0")) {
			alert("Ingrese una Cantidad");
			f.t1.focus();
			return;
		}*/
		var valor = isNaN(v1);
		if (valor == true) ////NO ES NUMERO
		{
			document.form1.number.value = 1; ////avisa que no es numero
			var v1 = document.form1.t1.value.substring(1);
			v1 = parseFloat(v1 * factor);
		} else {
			document.form1.number.value = 0; ////avisa que es numero
			v1 = v1; ////ES NUMERO
		}
		if (v1 > st) {
			alert("La cantidad Ingresada excede al Stock Actual del Producto");
			f.t1.focus();
			return;
		}

		f.method = "post";
		f.action = "venta_index3_reg.php";
		f.submit();

	}


	function sf() {
		document.form1.country.focus();
	}

	function st() {
		document.form1.text1.focus();
	}

	function sb() {
		document.form1.buscar.focus();
	}

	function ad() {


		document.getElementById("t1").value = "";
		document.form1.t1.focus();
	}

	function fc() {
		document.form1.num.focus();
	}



	function getfocus() {
		document.getElementById('l1').focus()
	}
</script>