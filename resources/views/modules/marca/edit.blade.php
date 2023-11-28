@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Marcas</a></div>
        <div class="breadcrumb-item">Creando Marca</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_modelo" method="POST" action="{{ route('marca.update',$id) }}">
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
                <div id="app">
                    <div class="card-body">
                        <div class="section-header">
                            <h1>Crear Marca</h1>
                            <div class="section-header-breadcrumb">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="marca_nombre">Nombre de la marca</label>
                                <input type="text" class="form-control" value="{{$edit->marca_nombre}}" name="marca_nombre" id="marca_nombre"> 
                        </div>
 

                    </div>

                </div>


                <div class="card-footer">
                    <button type="submit" id="crear_tienda" class="btn btn-danger boton-color">Crear Marca</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
         
        /* -- ******** validation  ************* -- */

        $("#form_modelo").validate({
            rules: {
                marca_nombre: {
                    maxlength: 250,
                    required: true,
                } 
            },
            submitHandler: function(form) {
                $("#crear_tienda").addClass("disabled btn-progress")
                
                return true;
                
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
