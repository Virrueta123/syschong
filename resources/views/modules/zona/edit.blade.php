@extends('layouts.app')
@section('historial')
    <h1>Formulario de edicion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('zona.index') }}" class="text-danger">Zona</a></div>
        <div class="breadcrumb-item">Editando Zona</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_cliente" method="POST" action="{{ route('zona.update',$id) }}">
                @csrf
                @method("PUT")
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h2 class="section-title">Formulario para editar una zona de producto</h2>
                </div>
              
                            <div class="card-body">

                                <h2 class="section-title">Editar zona del producto</h2>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="zona_nombre">Nombre de la zona</label>
                                        <input type="text" v-model="zona_nombre" value="{{$get->zona_nombre}}" class="form-control"
                                            name="zona_nombre" id="zona_nombre">
                                    </div>
                                </div>
                            </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Actualizar Zona</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script> 
        /* -- ******** validation  ************* -- */

        $("#form_cliente").validate({
            rules: {
                zona_nombre: {
                    maxlength: 255,
                    minlength: 3,
                    required: true,
                } 
            },
            submitHandler: function(form){ 
                $("#crear_cliente").addClass("disabled btn-progress")
                console.log("disabled")
                 return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
