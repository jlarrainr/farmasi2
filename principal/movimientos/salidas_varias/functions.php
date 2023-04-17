<?php include('../../session_user.php');
require_once('../../../conexion.php');
$invnum  = $_SESSION['transferencia_sal_val'];
////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql = "SELECT numdoc FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$numdoc    = $row['numdoc'];
	}
}
?>
<script language="JavaScript">
	function grabar1() {
		var f = document.form1;
		if (f.referencia.value == "") {
			alert("Ingrese una referencia");
			f.referencia.focus();
			return;
		}
		if (f.mont2.value == "") {
			alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
			f.mont2.focus();
			return;
		}
		if (confirm("�Desea Grabar esta informacion?")) {
			alert("EL NUMERO REGISTRADO ES " + <?php echo $numdoc ?>);
			f.method = "POST";
			f.target = "_top";
			f.action = "transferencia1_sal_reg.php";
			f.submit();
		}
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

		if (v4 > v3) {
			alert("La cantidad Ingresada excede al Stock Actual del Producto");
			f.text1.focus();
			return;
		}
		f.method = "POST";
		f.target = "comp_principal";
		f.action = "transferencia4_sal.php";
		f.submit();
	}

	var statSend = false;
	var nav4 = window.Event ? true : false;

	function ent(evt, valor) {
		var valor;
		var key = nav4 ? evt.which : evt.keyCode;
		if (key == 13) {
			if (!statSend) {
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

				if (v4 > v3) {
					alert("La cantidad Ingresada excede al Stock Actual del Producto");
					f.text1.focus();
					return;
				}
				f.method = "post";
				f.action = "transferencia4_sal.php";
				f.target = "comp_principal";
				f.submit();

				statSend = true;
				return true;
			} else {
				alert("El proceso esta siendo cargado espere un momento...");
				return false;
			}

		}
		if (valor == 1) {
			// valor = 1 // para enteros
			return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));

		} else if (valor == 4) {
			// valor = 1 // para enteros
			return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
		}
	}

	function validar_grid() {
		var f = document.form1;
		f.method = "POST";
		f.action = "salidas_varias3.php";
		f.submit();
	}

	function precio() {

		var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
		var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
		var v3 = parseFloat(document.form1.stock.value); //PRECIO PROMEDIO
		var factor = parseFloat(document.form1.factor.value); //FACTOR
		var costre = parseFloat(document.form1.costre.value); //FACTOR

		var total;
		var cos;
		var valor = isNaN(v1);
		if (valor == true) {
			//var porcion = v1.substring(1); // porcion = "ndo"
			var porcion = document.form1.text1.value.substring(1);
			var fact = parseFloat(porcion / factor);

			cos = costre / factor;
			total = parseFloat(cos * porcion);
			document.form1.number.value = 1; ////avisa que no es numero

			if ((porcion) > v3) {
				alert("La cantidad Ingresada excede al Stock Actual del Producto");
				f.text1.focus();
				return;
			}


		} else {
			var porcion = parseFloat(v1 * factor);
			if ((porcion) > v3) {
				alert("La cantidad Ingresada excede al Stock Actual del Producto");
				f.text1.focus();
				return;
			}



			cos = costre;
			total = parseFloat(cos * v1);
			document.form1.number.value = 0; ////avisa que es numero
		}
		total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
		cos = Math.round(cos * Math.pow(10, 2)) / Math.pow(10, 2);
		///////////////////////////////////////////////////////////
		if (document.form1.text1.value != '') {
			document.form1.text2.value = cos;
			document.form1.text3.value = total;
			document.form1.text2x.value = cos;
			document.form1.subtotal2.value = total;
		} else {
			document.form1.text2.value = '';
			document.form1.text3.value = '';
		}

	}

	function fc() {
		document.form1.text1.focus();
	}

	function sf() {
		document.form1.country.focus();
		document.form1.first.disabled = true;
		document.form1.next.disabled = true;
		document.form1.prev.disabled = true;
		document.form1.fin.disabled = true;
		document.form1.nuevo.disabled = true;
		document.form1.modif.disabled = true;
	}

	function links() {
		document.getElementById('l1').focus()
	}
</script>