<script language="JavaScript">
	function validar() {
		var f = document.form1;
		if (f.documento.value == "") {
			alert("Ingrese el Numero del Documento");
			f.documento.focus();
			return;
		}
		if (f.local.value == 0) {
			alert("Seleccione un Local");
			f.local.focus();
			return;
		}
		f.method = "POST";
		f.submit();
	}

	function cancelar() {
		var f = document.form1;
		ventana = confirm("Desea cancelar esta Aplicacion");
		if (ventana) {
			document.form1.srch.value = 0;
			f.method = "POST";
			f.target = "_top";
			f.action = "transferencia1_ing_cancel.php";
			f.submit();
		}
	}

	function salir() {
		var f = document.form1;
		f.method = "POST";
		f.target = "_top";
		f.action = "transferencia1_ing_del.php";
		f.submit();
	}

	
	
	var statSend = false;
    function grabar_dato() {
        if (!statSend) {
            var f = document.form1;
            ventana = confirm("¿Desea Grabar la Información Mostrada?");
            if (ventana) {
                f.method = "POST";
                f.target = "_top";
                f.action = "transferencia1_ing_reg.php";
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
	
	
	
	
	
	

	function sf() {
		document.form1.documento.focus();
	}

	function sb() {
		document.form1.documento.disabled = true;
		document.form1.local.disabled = true;
		document.form1.busk.disabled = true;
	}


	// function popup(valor) {
	// 	var valor;
	// 	window.open("pendientes.php?cuenta=" + cuenta, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=300,left=340,width=750,height=300');
	// }


	function popup(valor) {
		var valor;
		//alert("hola");
		var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=400, top=200, left=340";
		window.open("pendientes.php?cuenta=" + valor, "", opciones);
		// return false;
	}


	function validar_prod() {
		var f = document.form1;
		var v3 = parseFloat(document.form1.stock.value); //CANTIDAD ACTUAL POR LOCAL
		var v4 = parseFloat(document.form1.text1.value); //CANTIDAD NGRESADA
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		if ((f.text1.value == "") || (f.text1.value == "0")) {
			alert("Ingrese una Cantidad");
			f.text1.focus();
			return;
		}
		var valor = isNaN(v4);
		if (valor == true) {
			//var porcion = v1.substring(1); // porcion = "ndo"
			var v4 = document.form1.text1.value.substring(1);
		} else {
			v4 = v4 * factor; ////avisa que es numero
		}
		f.method = "post";
		f.action = "transferencia2_ing_reg.php";
		f.submit();
	}

	function validar_grid() {
		var f = document.form1;
		f.method = "post";
		f.action = "transferencia2_ing.php";
		f.submit();
	}

	function precio() {
		var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
		var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		var total;
		var valor = isNaN(v1);
		if (valor == true) {
			//var porcion = v1.substring(1); // porcion = "ndo"
			var porcion = document.form1.text1.value.substring(1);
			var fact = parseFloat(porcion / factor);
			total = parseFloat(fact * v2);
			document.form1.number.value = 1; ////avisa que no es numero
		} else {
			total = parseFloat(v1 * v2);
			document.form1.number.value = 0; ////avisa que es numero
		}
		total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
		///////////////////////////////////////////////////////////
		if (document.form1.text1.value != '') {
			document.form1.text3.value = total;
		} else {
			document.form1.text3.value = '';
		}

	}

	function fc() {
		document.form1.text1.focus();
	}
</script>