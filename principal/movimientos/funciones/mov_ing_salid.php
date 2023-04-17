<script language="JavaScript">
    function ingreso(e) {
        tecla = e.keyCode;


        var type = document.form1.type.value; //type 
        var reg = document.form1.reg.value; //reg 


        /////ingreso/////
        if (type == 1) {

            if (tecla == 49) {
                if (reg == 1) {

                    location.href = "compras/compras_busca_copy.php?&compras=63 ";


                } else {

                    location.href = "consulta_compras/consult_compras.php";
                }
            }
            if (tecla == 50) {

                if (reg == 1) {

                    location.href = "transferencia_ing/transferencia_ing.php";

                } else {

                    alert('no');
                }

            }
            if (tecla == 51) {

                if (reg == 1) {

                    location.href = "";

                } else {

                    alert('no');
                }

            }
            if (tecla == 53) {

                if (reg == 1) {

                    location.href = "";

                } else {

                    alert('no');
                }

            }
            if (tecla == 54) {

                if (reg == 1) {

                    location.href = "";

                } else {

                    alert('no');
                }

            }

        } else {




        }


    }


    function mensaje_error() {
        alert('tienes el mismo usuario abierto en otra computadora, esta lista se eliminara');
    }

    // Emite un post para el formulario
    function grabar() {
        var f = document.form1;
        f.method = "POST";
        f.submit();
    }
    // Emite un post pero cambiando el destino de form para el "index.php" superior (salida)
    function salir() {
        var f = document.form1;
        f.method = "POST";
        f.target = "_top";
        f.action = "../index.php";
        f.submit();
    }
    // Emite un post cambiando la salida a "ing_salid2.php" siempre que se marque un "radio button"
    function validar() {
        var f = document.form1;
        var i;
        var c;
        // Valida marca del check box
        for (i = 0; i < document.form1.rd.length; i++) {
            if (document.form1.rd[i].checked) {
                c = 1;
            }
        }
        // Si radio button marcado, ir a ing_salida2.php
        if (c == 1) {
            f.method = "POST";
            f.action = "ing_salid2.php";
            f.submit();
        } else // pide al usuario que elija
        {
            alert("Seleccione una Opcion");
            f.rd.focus();
            return;
        }
    }
</script>