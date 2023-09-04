@extends('layouts.app')
@section('historial')
    <h1>Formulario de edicion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="text-danger">Categorias</a></div>
        <div class="breadcrumb-item">Creando cliente</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_cliente" method="POST" action="{{ route('categorias.update',$id) }}">
                @csrf
                @method('PUT')
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
                    <h2 class="section-title">Formulario para editar una categoria de producto</h2>
                </div>
                <img src="{{ asset('images/svg/editar.svg') }}" alt="My Happy SVG" width="350" />

                <div class="card-body">
                    <h2 class="section-title">Crear categoria del producto</h2>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="categoria_nombre">Nombre de la categoria</label>
                            <input type="text" v-model="categoria_nombre" value="{{ $get->categoria_nombre }}" class="form-control" name="categoria_nombre"
                                id="categoria_nombre">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Editar Categoria</button>
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
                categoria_nombre: {
                    maxlength: 255,
                    minlength: 5,
                    required: true,
                }
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
