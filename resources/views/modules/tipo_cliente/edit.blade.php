@extends('layouts.app')
@section('historial')
    <h1>Formulario de edicion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Tipos de clientes</a></div>
        <div class="breadcrumb-item">Editar tipo de creacion</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_tipo_cliente" method="POST" action="{{ route('tipo_cliente.update',$id) }}">
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
                            <h1>Editar tipo de cliente</h1>
                            <div class="section-header-breadcrumb">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="tipo_cliente_nombre">Nombre de tipo de cliente</label>
                                <input type="text" class="form-control" value="{{ $edit->tipo_cliente_nombre }}" name="tipo_cliente_nombre" id="tipo_cliente_nombre"> 
                        </div> 

                    </div>

                </div>


                <div class="card-footer">
                    <button type="submit" id="crear_tienda" class="btn btn-danger boton-color">Editar Tipo de cliente</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
         
        /* -- ******** validation  ************* -- */

        $("#form_tipo_cliente").validate({
            rules: {
                tipo_cliente_nombre: {
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
