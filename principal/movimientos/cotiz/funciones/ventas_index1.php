
<style type="text/css">
    h1 {
        color: #FF0000;
        font-weight: bold;
        font-size: 30px;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }
</style>
<script language="JavaScript">
    function salir1()
    {

        var f = document.form1;
        var act = document.form1.activado.value;   //$count
        var act1 = document.form1.activado1.value; //$count1 

        //if ((act == 1)||(act1<0))

        if ((act > 0) || (act1 > 0))
        {


            alertify
                    .alert("<h1><strong><center>IMPOSIBLE SALIR DE COTIZACION</center></strong></h1>", "<h3> Cancele la cotizacion antes de salir, con el boton CANCELAR o F4 </h3>", function () {
                        alertify.message('OK');
                    });


        } else {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "ventas_salir.php";
            f.submit();
        }

    }
    function buscar()
    {
        var f = document.form1;
        //ventana=confirm("Desea cancelar esta venta y realizar una busqueda");
        //if (ventana) {
        f.method = "POST";
        f.target = "_top";
        f.action = "ventas_buscar.php";
        f.submit();
        //}
    }
    function cancelar()
    {
        var f = document.form1;
        ventana = confirm("Desea cancelar esta Cotizacion");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "ventas_cancel.php";
            f.submit();
        }
    }
    function grabar1()
    {
        var cod = parseFloat(document.form1.cod.value);
        var f = document.form1;
        ventana = confirm("Desea Grabar esta Cotizacion");
        if (ventana) {
            alert("EL NUMERO DE COTIZACION ES " + cod);
//            ventana2 = confirm("EL NUMERO DE COTIZACION ES " + cod);
//            if (ventana2) {
            f.method = "post";
            f.target = "_top";
            f.action = "venta_reg.php";
            f.submit();
//            }
        }
    }
</script>