<script>
	function sf() {
		document.form1.codigo.disabled = true;
		document.form1.nom.disabled = true;
		document.form1.direccion.disabled = true;
		document.form1.departamento.disabled = true;
		document.form1.provincia.disabled = true;
		document.form1.distrito.disabled = true;
		document.form1.ruc.disabled = true;
		document.form1.nextel.disabled = true;
		document.form1.mail.disabled = true;
		document.form1.representante.disabled = true;
		document.form1.lcredito.disabled = true;
		document.form1.fono.disabled = true;
		document.form1.tipo.disabled = true;
		document.form1.obs.disabled = true;
		document.form1.printer.disabled = false;
		document.form1.save.disabled = true;
		document.form1.ext.disabled = true;
		document.form1.boton_ruc.disabled = true;
		var rads = document.form1.rd;
		for (var i = 0; i < rads.length; i++) {
			document.form1.rd[i].disabled = true;
		}
		//document.form2.buscar.focus();

	}

	function buton2() {
		document.form1.nom.disabled = false;
		document.form1.direccion.disabled = false;
		document.form1.departamento.disabled = false;
		document.form1.ruc.disabled = false;
		document.form1.ruc.focus();
		document.form1.nextel.disabled = false;
		document.form1.mail.disabled = false;
		document.form1.representante.disabled = false;
		document.form1.lcredito.disabled = false;
		document.form1.fono.disabled = false;
		document.form1.tipo.disabled = false;
		document.form1.obs.disabled = false;
		document.form1.boton_ruc.disabled = false;
		///	botones
		document.form1.printer.disabled = true;
		document.form1.modif.disabled = true;
		document.form1.nuevo.disabled = true;
		document.form1.save.disabled = false;
		document.form1.ext.disabled = false;
		document.form1.first.disabled = true;
		document.form1.prev.disabled = true;
		document.form1.next.disabled = true;
		document.form1.fin.disabled = true;
		document.form1.del.disabled = true;

		//LIMPIO CAJAS
		document.form1.nom.value = "";
		document.form1.direccion.value = "";
		document.form1.ruc.value = "";
		document.form1.nextel.value = "";
		document.form1.mail.value = "";
		document.form1.representante.value = "";
		document.form1.lcredito.value = "";
		document.form1.fono.value = "";
		document.form1.textt1.value = "";
		document.form1.textt2.value = "";
		document.form1.textt3.value = "";
		document.form1.val.value = 1;
		var v1 = parseInt(document.form1.fincod.value);
		v1 = v1 + 1;
		document.form1.codigo.value = v1;
		document.form1.cod_nuevo.value = v1;
	}

	function buton3() {
		document.form1.nom.disabled = false;

		document.form1.direccion.disabled = false;
		document.form1.departamento.disabled = false;
		document.form1.ruc.disabled = false;
		document.form1.ruc.focus();
		document.form1.nextel.disabled = false;
		document.form1.mail.disabled = false;
		document.form1.representante.disabled = false;
		document.form1.lcredito.disabled = false;
		document.form1.fono.disabled = false;
		document.form1.tipo.disabled = false;
		document.form1.obs.disabled = false;
		document.form1.boton_ruc.disabled = false;
		///	botones
		document.form1.printer.disabled = true;
		document.form1.modif.disabled = true;
		document.form1.nuevo.disabled = true;
		document.form1.save.disabled = false;
		document.form1.first.disabled = true;
		document.form1.prev.disabled = true;
		document.form1.next.disabled = true;
		document.form1.fin.disabled = true;
		document.form1.del.disabled = true;
		document.form1.ext.disabled = false;
		document.form1.val.value = 2;
	}

	function validar() {
		var f = document.form1;
		if (f.nom.value == "") {
			alert("Ingrese el nombre del Cliente");
			f.nom.focus();
			return;
		}
		if (f.ruc.value == "") {
			alert("Ingrese un Ruc");
			f.ruc.focus();
			return;
		}
		if (f.direccion.value == "") {
			alert("Ingrese una direccion");
			f.direccion.focus();
			return;
		}
		if (f.val.value == 1) {
			if (f.departamento.value == 0) {
				alert("Seleccione un Departamento");
				f.departamento.focus();
				return;
			}
		}
		//VENTANA QUE CONFIRMA SI GRABO O NO?
		ventana = confirm("Desea Grabar estos datos");
		if (ventana) {
			document.form1.btn.value = 4;
			f.method = "POST";
			f.action = "graba_proveedor.php";
			f.submit();
		}
		///////////////////////////////////
	}
</script>
<script language="JavaScript">
	function primero() {
		var f = document.form1;
		var v1 = parseInt(document.form1.first.value);
		document.form1.pageno.value = v1;
		f.method = "post";
		f.action = "mov_proveedor.php";
		f.submit();
	}

	function siguiente() {
		var f = document.form1;
		var v1 = parseInt(document.form1.nextpage.value);
		document.form1.pageno.value = v1;
		f.method = "post";
		f.action = "mov_proveedor.php";
		f.submit();
	}

	function anterior() {
		var f = document.form1;
		var v1 = parseInt(document.form1.prevpage.value);
		document.form1.pageno.value = v1;
		f.method = "post";
		f.action = "mov_proveedor.php";
		f.submit();
	}

	function ultimo() {
		var f = document.form1;
		var v1 = parseInt(document.form1.lastpage.value);
		document.form1.pageno.value = v1;
		f.method = "post";
		f.action = "mov_proveedor.php";
		f.submit();
	}
</script>
<script language="JavaScript">
	function eliminar() {
		var f = document.form1;
		ventana = confirm("Desea Eliminar este Proveedor");
		if (ventana) {
			document.form1.btn.value = 5;
			f.method = "POST";
			f.action = "graba_proveedor.php";
			f.submit();
		}
	}

	function salir() {
		var f = document.form1;
		document.form1.btn.value = 6;
		f.method = "POST";
		f.action = "graba_proveedor.php";
		f.submit();
	}
</script>