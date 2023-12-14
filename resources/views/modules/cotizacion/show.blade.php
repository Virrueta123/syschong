@extends('layouts.app')
@section('historial')
    <h1>Cotizacion detalles</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cotizacion.index') }}" class="text-danger">Toda las cotizaciones </a>
        </div>
        <div class="breadcrumb-item">Creando cotizacion</div>
    </div>
@endsection
@section('content')
    <div id="app">

        <cotizacion-mantenimiento url_whatsapp="{{$url_whatsapp}}" accesorios="{{$accesorios}}" autorizaciones="{{$autorizaciones}}"  url_raiz="{{$url_raiz}}" id="{{$id}}" forma_pago="{{$forma_pago}}" correlativo_factura="{{$correlativo_factura}}" correlativo_boleta="{{$correlativo_boleta}}" empresa="{{$empresa}}" cotizacion="{{ $get }}" />

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
