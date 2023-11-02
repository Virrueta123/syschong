@extends('layouts.app')
@section('historial')
    <h1>Formulario para aperturar una caja</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('caja.index') }}" class="text-danger">Caja</a></div>
        <div class="breadcrumb-item">Creando una caja</div>
    </div>
@endsection
@section('content')

    <div class="section-body">
        <div class="card">
            <form id="form_caja" method="POST" action="{{ route('caja.store') }}">
                @csrf
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
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="referencia">Referencia</label>
                                <input type="text" class="form-control" name="referencia" id="referencia">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="prod_codigo">Precio Mantenimiento</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            S/.
                                        </div>
                                    </div>
                                    <input-money name="saldo_inicial" name_precio="saldo_inicial"></input-money>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Caja</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        /* -- ******** validation  ************* -- */

        $("#form_caja").validate({
            rules: {
                referencia: {
                    maxlength: 200,
                    required: true,
                },
                saldo_inicial: {
                    maxlength: 200,
                    required: true,
                },
            },
            submitHandler: function(form) {
                $("#crear_cliente").addClass("disabled btn-progress")
                console.log("disabled")
                return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
