@extends('layouts.app')
@section('historial')
    <h1>Formulario de edicion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('mecanico.index') }}" class="text-danger">Mecanicos</a></div>
        <div class="breadcrumb-item">Editar Mecanico</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_mecanico" method="POST" action="{{ route('mecanico.update',$id) }}">
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
                    <h2 class="section-title">Formulario para editar un mecanico</h2>
                </div>
                <div class="card-body">
                     
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" value="{{old('name',$edit->name)}}" id="name">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="last_name">Apellido</label>
                            <input type="text" class="form-control" value="{{old('last_name',$edit->last_name)}}" name="last_name" id="last_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Correo electronico</label>
                            <input type="text" class="form-control" name="email" value="{{old('email',$edit->email)}}" id="email">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="dni">Dni</label>
                            <input type="text" class="form-control" name="dni" value="{{old('dni',$edit->dni)}}" id="dni">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_mecanico" class="btn btn-danger boton-color">Editar Mecanico</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
       
        /* -- *********************** -- */

        /* -- ******** validation  ************* -- */

        $("#form_mecanico").validate({
            rules: { 
                email: {
                    email: true,
                },
                dni: {
                    required: true,
                    number: true,
                    maxlength: 8,
                    minlength: 8,
                },
                name: {
                    maxlength: 200,
                    required: true,
                },
                last_name: {
                    maxlength: 200,
                    required: true,
                } 
            },
            submitHandler: function(form){ 
                $("#crear_mecanico").addClass("disabled btn-progress")
                console.log("disabled")
                 return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
