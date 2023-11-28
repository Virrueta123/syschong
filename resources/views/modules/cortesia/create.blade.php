@extends('layouts.app')
@section('historial')
    <h1>Crear cortesia</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('activaciones.index') }}" class="text-danger">Activaciones</a></div>
        <div class="breadcrumb-item">Crear cortesia </div>
    </div>
@endsection
@section('content')
   <div id="app">
     <add-cortesia activacion="{{$activacion}}" cortesia="{{app('empresa')->cortesia()}}" id="{{$id}}" accesorios="{{$accesorios}}" autorizaciones="{{$autorizaciones}}"></add-cortesia>
   </div>
@endsection

@section('js')
    <script>  
        /* -- ******** validation  ************* -- */

        $("#form_cortesia").validate({
            rules: { 
                km: {
                    required: true, 
                }, 
                precio: { 
                    required: true,
                  required: true,
                }, 
                tienda_cobrar:{
                    required:true
                }
            },
            submitHandler: function(form) {
                $("#crear_cortesia").addClass("disabled btn-progress")
                
                return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
