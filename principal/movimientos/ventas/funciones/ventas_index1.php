<?php
require_once('../../../conexion.php');
$sql = "SELECT vendedorventa FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $vendedorventa = $row['vendedorventa'];
    }
}
?>
<script language="JavaScript">
    /* function salir1()
     {
     var f = document.form1;
     f.method = "POST";
     f.target = "_top";
     f.action = "ventas_salir.php";
     f.submit();
     }*/
    function Validardelivery() {
        var f = document.form1;
        f.method = "post";
        f.action = "delivery.php";
        f.submit();
    }

    function salir1() {

        var f = document.form1;
        var act = document.form1.activado.value; //$count
        var act1 = document.form1.activado1.value; //$count1 
        //if ((act == 1)||(act1<0))

        if ((act > 0) || (act1 > 0)) {


            alertify
                .alert("<h1><strong><center>IMPOSIBLE SALIR DE VENTAS</center></strong></h1>", "<h3> Cancele la venta antes de salir de ventas con el boton NUEVO o F4 </h3>", function() {
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
        /* if (f.medico.value == "")
         {
             alert("Asigna a un medico antes de cancelar esta venta");
             return;
         }*/
        ventana = confirm("Desea cancelar esta venta?");
        if (ventana) {
            f.method = "POST";
            f.target = "_top";
            f.action = "ventas_cancel.php";
            f.submit();
        }
    }

    function grabarventa() {
        var tecKey = 0;
        if (tecla == 119) {
            tecKey = 1;
        }
        if (tecla == 120) {
            tecKey = 2;
        }
        var f = document.form1;
        var act = document.form1.activado.value;
        var act1 = document.form1.activado1.value;
        var t33 = document.form1.t33.value;
        if (f.t33.value == 0) {
            alert("LA CANTIDAD INGRESADA ES 0, LA VENTA DEBE SER GRABADA CON F4 Y ASIGNANDO A UN MEDICO");
            return;
        }

        if ((act == 0) || (act1 > 1)) {
            alert("Venta Incompleta. Imposible de Imprimir");
            f.num.focus();
            return;
        } else {
            <?php
            if ($vendedorventa == 1) {
            ?>
                var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
                if (claveVendedor !== null) {
                    $.ajax({
                        type: "GET",
                        url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                        async: true,
                        success: function(datos) {
                            var dataJson = eval(datos);
                            var contad = 0;
                            for (var i in dataJson) {
                                contad++;
                                //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                            }
                            if (contad > 0) {
                                //ENVIO NORMALMENTE
                                window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor + '&tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
                            } else {
                                alert("No existe el Usuario");
                                return;
                            }
                        },
                        error: function(obj, error, objError) {
                            //avisar que ocurriï¿½ un error
                        }
                    });
                }
            <?php
            } else {
            ?>
                window.open('preimprimir.php?tecKey=' + tecKey, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
            <?php
            }
            ?>

        }
    }

    function grabar1() {
        var f = document.form1;

        <?php
        if ($vendedorventa == 1) {
        ?>
            var claveVendedor = prompt("Ingrese la clave de Vendedor de Ventas", "");
            if (claveVendedor !== null) {
                $.ajax({
                    type: "GET",
                    url: "VerificaClaveVendedor.php?Codigo=c" + claveVendedor,
                    async: true,
                    success: function(datos) {
                        var dataJson = eval(datos);
                        var contad = 0;
                        for (var i in dataJson) {
                            contad++;
                            //alert(dataJson[i].ID + " _ " + dataJson[i].C);
                        }
                        if (contad > 0) {
                            window.open('preimprimir.php?CodClaveVendedor=c' + claveVendedor, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');

                        } else {
                            alert("No existe el Usuario");
                            return;
                        }
                    },
                    error: function(obj, error, objError) {
                        //avisar que ocurri� un error
                    }
                });
            }
        <?php
        } else {
        ?>
            window.open('preimprimir.php', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=885,height=630');
        <?php
        }
        ?>
    }
</script>