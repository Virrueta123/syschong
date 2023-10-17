@extends('layouts.noauth')
 
@section('content')
    <div id="app">

        <cotizacion-cliente-show   cotizacion="{{ $get }}" />

    </div>
@endsection

@section('js')
    <script>
        $("#form_cotizacion").validate({
            rules: {
                observacion_sta: {
                    required: true,
                },
                mecanico_id: {
                    required: true,
                },
            },
            submitHandler: function(form) {
                var cotizacion = $("#cotizacion");
 
                if (cotizacion.val() == 0) {
                    Swal.fire({
                        icon: "info",
                        title: "Datos faltantes",
                        text: "Porfavor ingrese repuestos y servicios",
                        footer: "-------",
                    });
                } else {
                    if (autorizaciones.val() == "") {
                        Swal.fire({
                            icon: "info",
                            title: "Datos faltantes",
                            text: "Porfavor seleccione al menos una condicion",
                            footer: "-------",
                        });
                    } else {
                        return true;
                    }
                }
                return false;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
