<script>
    function sf() {
        document.form1.codigo.disabled          = true;
        document.form1.ruc.disabled             = true;
        document.form1.dni.disabled             = true;
        document.form1.nom.disabled             = true;
        document.form1.propietario.disabled     = true;
        document.form1.direccion.disabled       = true;
        document.form1.limiteCredito.disabled   = true;
        document.form1.tipo.disabled            = true;
        document.form1.estado.disabled          = true;
        document.form1.condicion.disabled       = true;
        document.form1.fono.disabled            = true;
        document.form1.fono1.disabled           = true;
        document.form1.email.disabled           = true;
        
       
        document.form1.printer.disabled         = false;
        document.form1.save.disabled            = true;
        document.form1.ext.disabled             = true;
        //document.form2.buscar.focus();
    }

    function buton2() {
        
        document.form1.ruc.disabled             = false;
        document.form1.dni.disabled             = false;
        document.form1.nom.disabled             = false;
        document.form1.propietario.disabled     = false;
        document.form1.direccion.disabled       = false;
        document.form1.limiteCredito.disabled   = false;
        document.form1.tipo.disabled            = false;
        document.form1.estado.disabled          = false;
        document.form1.condicion.disabled       = false;
        document.form1.fono.disabled            = false;
        document.form1.fono1.disabled           = false;
        document.form1.email.disabled           = false;
        
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
        document.form1.ruc.focus();
        
        document.form1.ruc.value             = "";
        document.form1.dni.value             = "";
        document.form1.nom.value             = "";
        document.form1.propietario.value     = "";
        document.form1.direccion.value       = "";
        document.form1.limiteCredito.value   = "";
        document.form1.tipo.value            = "";
        document.form1.estado.value          = "";
        document.form1.condicion.value       = "";
        document.form1.fono.value            = "";
        document.form1.fono1.value           = "";
        document.form1.email.value           = "";
        
        
        
        document.form1.textt1.value         = "";
        document.form1.textt2.value         = "";
        document.form1.textt3.value         = "";
        document.form1.emailres.value       = "";
         
        document.form1.val.value = 1;
        var v1 = parseInt(document.form1.fincod.value);
        v1 = v1 + 1;
        document.form1.codigo.value         = v1;
        document.form1.cod_nuevo.value      = v1;
    }

    function buton3() {
        document.form1.nom.disabled = false;
       
        document.form1.ruc.focus();
        document.form1.ruc.disabled             = false;
        document.form1.dni.disabled             = false;
        document.form1.nom.disabled             = false;
        document.form1.propietario.disabled     = false;
        document.form1.direccion.disabled       = false;
        document.form1.limiteCredito.disabled   = false;
        document.form1.tipo.disabled            = false;
        document.form1.estado.disabled          = false;
        document.form1.condicion.disabled       = false;
        document.form1.fono.disabled            = false;
        document.form1.fono1.disabled           = false;
        document.form1.email.disabled           = false;
        ///	botones
        document.form1.printer.disabled         = true;
        document.form1.modif.disabled           = true;
        document.form1.nuevo.disabled           = true;
        document.form1.save.disabled            = false;
        document.form1.ext.disabled             = false;
        document.form1.first.disabled           = true;
        document.form1.prev.disabled            = true;
        document.form1.next.disabled            = true;
        document.form1.fin.disabled             = true;
        document.form1.del.disabled             = true;
        document.form1.val.value                = 2;
    }

    function errorDNI() {
            alert("DNI ya se encuentra registardo");
            var f = document.form1;
            f.country.focus();
            return;
        }

        function errorRUC() {
            alert("RUC ya se encuentra registardo");
            var f = document.form1;
            f.country.focus();
            return;
        }


    function validarRUC(elemento) {
        var f = document.form1;

        if (f.ruc.value != "") {

            document.form1.dni.disabled = true;
            document.getElementById("resultadoDNI").innerHTML = "DNI deshabilitado";
            document.getElementById("resultadoDNI").style.color = "red";
            document.getElementById("dni").style.borderColor = "#f51e1e"; //ROJO     

            var maxLength = 11;
            var strLength = elemento.value.length;
            document.getElementById("contadorRUC").innerHTML = strLength + '/' + maxLength;

            if (strLength < maxLength) {
                document.getElementById("contadorRUC").style.color = "red"; //rojo
            } else {
                document.getElementById("contadorRUC").style.color = "blue"; //azul
            }
        } else {
            document.form1.dni.disabled = false;
            document.getElementById("resultadoDNI").innerHTML = "DNI habilitado";
            document.getElementById("resultadoDNI").style.color = "blue";
            document.getElementById("dni").style.borderColor = "#15ff00"; //VERDE
            document.getElementById("contadorRUC").innerHTML = '';
        }

    }

    function validarDNI(elemento) {
        var f = document.form1;
        if (f.dni.value != "") {

            document.form1.ruc.disabled = true;
            document.getElementById("resultadoRUC").innerHTML = "RUC deshabilitado";
            document.getElementById("resultadoRUC").style.color = "red";
            document.getElementById("ruc").style.borderColor = "#f51e1e"; //ROJO

            var maxLength = 8;
            var strLength = elemento.value.length;
            document.getElementById("contadorDNI").innerHTML = strLength + '/' + maxLength;

            if (strLength < maxLength) {
                document.getElementById("contadorDNI").style.color = "red"; //rojo
            } else {
                document.getElementById("contadorDNI").style.color = "blue"; //azul
            }

        } else {
            document.form1.ruc.disabled = false;
            document.getElementById("resultadoRUC").innerHTML = "RUC habilitado";
            document.getElementById("resultadoRUC").style.color = "blue";
            document.getElementById("ruc").style.borderColor = "#15ff00"; //VERDE
            document.getElementById("contadorDNI").innerHTML = '';
        }

    }

    function validarEmail(elemento) {

        var texto = document.getElementById(elemento.id).value;
        var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if (texto != "") {
            if (!regex.test(texto)) {
                document.getElementById("resultado").innerHTML = "Correo invalido";
                document.getElementById("resultado").style.color = "red";
                document.form1.emailres.value = 0;
            } else {
                document.getElementById("resultado").innerHTML = "Correo valido";
                document.getElementById("resultado").style.color = "blue";
                document.form1.emailres.value = 1;
            }
        } else {
            document.getElementById("resultado").innerHTML = "";
            document.form1.emailres.value = "";
        }
    }

    function cli() {

        //	 f.action ="../../archivo/mov_prod.php";
        window.open("vercli/cli.php", "clientes", "width=1300, height=700");
    }

    function validar() {
        var f = document.form1;
        var s = document.form1.val.value;
        if (f.nom.value == "") {
            alert("Ingrese el nombre del Cliente");
            f.nom.focus();
            return;
        }
        /*if (f.propietario.value == "") {
            alert("Ingrese el nombre del Propietario");
            f.propietario.focus();
            return;
        }*/
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
        if ((f.ruc.value == "") && (f.dni.value == "")) {
            alert("Ingresar un RUC o un DNI del cliente");
            f.ruc.focus();
            return;
        }

        var ruc = f.ruc.value;
        if (ruc.length > 0) {
            if (ruc.length < 11) {
                alert("Debe ingresar 11 caracteres en el RUC");
                f.ruc.focus();
                return false;
            }
        }
        var dni = f.dni.value;
        if (dni.length > 0) {
            if (dni.length < 8) {
                alert("Debe ingresar 8 caracteres en el DNI");
                f.dni.focus();
                return false;
            }
        }

        if (f.email.value != "") {
            if (f.emailres.value == 0) {
                alert("Correo invalido");
                f.email.focus();
                return;
            }
        }


        //        if (f.credito.value == "")
        //        {
        //            alert("Ingrese un Credito Inicial");
        //            f.credito.focus();
        //            return;
        //        }
        //        if (f.state.value == "")
        //        {
        //            alert("Ingrese un Estado");
        //            f.state.focus();
        //            return;
        //        }
        //VENTANA QUE CONFIRMA SI GRABO O NO?
        ventana = confirm("Desea Grabar estos datos");
        if (ventana) {
            document.form1.btn.value = 4;
            f.method = "POST";
            f.action = "graba_cliente.php";
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
        f.action = "mov_cliente.php";
        f.submit();
    }

    function siguiente() {
        var f = document.form1;
        var v1 = parseInt(document.form1.nextpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_cliente.php";
        f.submit();
    }

    function anterior() {
        var f = document.form1;
        var v1 = parseInt(document.form1.prevpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_cliente.php";
        f.submit();
    }

    function ultimo() {
        var f = document.form1;
        var v1 = parseInt(document.form1.lastpage.value);
        document.form1.pageno.value = v1;
        f.method = "post";
        f.action = "mov_cliente.php";
        f.submit();
    }
</script>
<script language="JavaScript">
    /*function validar1()
     {
     var f = document.form1;
     document.form1.pageno.value=2;
     f.method = "post";
     f.action ="mov_cliente.php";
     f.submit();
     }
     */
    function eliminar() {
        var f = document.form1;
        ventana = confirm("Desea Eliminar este Cliente");
        if (ventana) {
            document.form1.btn.value = 5;
            f.method = "POST";
            f.action = "graba_cliente.php";
            f.submit();
        }
    }

    function salir() {
        var f = document.form1;
        document.form1.btn.value = 6;
        f.method = "POST";
        f.action = "graba_cliente.php";
        f.submit();
    }


    function busqueda_DNI() {
        dni = $('#dni').val();
        if ((dni == "")) {
            alert("Ingresar un DNI del cliente");
            document.form2.dni.focus();
            return;
        }

        if (dni.length > 0) {
            if (dni.length < 8) {
                alert("Debe ingresar 8 caracteres en el DNI");
                document.form2.dni.focus();
                return false;
            }
        }

        try {
            Param = {
                //     documento: 'DNI',
                //     nro_documento: dni


                documento: dni,
                tipo_documento: 'DNI',
                origen: 1,
                op: 'consulta'
            };

            //Param.tipo = (Param.tipo_documento == 'DNI' ? 'D' : 'R');
            //Param.DNI_RUC = (Param.tipo_documento == 'DNI' ? true : false);

            URLs = 'https://dniruc.apisperu.com/api/v1/dni/' + dni + '?token=' + $("#token").val();

            //URLs = 'https://www.consultarucsunat.com/api_empresas.php';
            $.ajax({
                url: URLs,
                //data: Param,
                dataType: 'JSON',
                success: function(respuesta) {

                    response = respuesta;



                    //  response = respuesta['result'];
                    // var datos = eval(datos_dni);
                    //     var n1 = (datos[1]);
                    //     var n2 = (datos[2]);
                    //     var n3 = (datos[3]);
                    //     var mas = n1 + ' ' + n2 + ' ' + n3;
                    $('#dni').val(response.dni);
                    $('#nom').val(response.apellidoPaterno + ' ' + response.apellidoMaterno + ' ' + response.nombres);



                },
                error: function() {
                    console.log("No se ha podido obtener la información");
                }
            });
        } catch (error) {
            console.log(error);
        }


    }

    function busqueda() {

        try {
            Param = {

                documento: $("#ruc").val(),
                tipo_documento: 'RUC',
                origen: 1,
                op: 'consulta'

                // documento: 'RUC',
                //nro_documento: $("#ruc").val()
            };

            // Param.tipo = (Param.tipo_documento == 'DNI' ? 'D' : 'R');
            // Param.DNI_RUC = (Param.tipo_documento == 'DNI' ? true : false);

            // URLs = 'https://www.consultarucsunat.com/api_empresas.php';
            URLs = 'https://dniruc.apisperu.com/api/v1/ruc/' + $("#ruc").val() + '?token=' + $("#token").val();
            $.ajax({
                url: URLs,
                //data: Param,
                dataType: 'JSON',
                success: function(respuesta) {
                    response = respuesta;
                    $('#direccion').val(response.direccion);
                    $('#nom').val(response.razonSocial);
                    $('#tipo').val(response.tipo);
                    $('#estado').val(response.estado);
                    $('#condicion').val(response.condicion);
                    // $('#fono').val(response.Telefono);



                    $("#departamento").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.departamento));
                    $("#provincia").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.provincia));
                    $("#distrito").append($("<option></option>").attr({
                        value: '0',
                        selected: "selected"
                    }).text(response.distrito));

                },
                error: function() {
                    console.log("No se ha podido obtener la informaci贸n");
                }
            });
        } catch (error) {
            console.log(error);
        }


    }
</script>