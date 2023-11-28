@extends('layouts.app')
@section('historial')
    <h1>Formulario de ediccion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('forma_pago.index') }}" class="text-danger">Forma de pago</a></div>
        <div class="breadcrumb-item">Editando Forma de pago</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="forma_pago" method="POST" action="{{ route('forma_pago.update',$id) }}">
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
                            <h1>Editar forma de pago</h1>
                            <div class="section-header-breadcrumb">
                            </div>
                        </div>
 
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="forma_pago_nombre">Nombre de la forma de pago</label>
                                <input type="text" class="form-control" name="forma_pago_nombre" value="{{$get->forma_pago_nombre}}" id="forma_pago_nombre">
                            </div> 
                        </div>

                    </div> 

                    <div class="card-footer">
                        <button type="submit" id="crear_tienda" class="btn btn-danger boton-color">Editar Forma de pago</button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        /* -- ******** validation  ************* -- */

        $("#forma_pago").validate({
            rules: {
                forma_pago_nombre: {
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
