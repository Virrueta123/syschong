@extends('layouts.app')
@section('historial')
    <h1>Formulario para editar registro</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('autorizaciones.index') }}" class="text-danger">autorizaciones</a></div>
        <div class="breadcrumb-item">Editando autorizacion</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_autorizaciones" method="POST" action="{{ route('autorizaciones.update',$edit->aut_id) }}">
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
                <div class="card-header">
                    <h2 class="section-title">Formulario para crear autorizaciones</h2>
                </div>
                <div class="card-body">
                     
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="aut_nombre">Nombre de la autorizacion</label>
                            <input type="text" class="form-control" value="{{$edit->aut_nombre}}" name="aut_nombre" id="aut_nombre">
                        </div> 
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-danger boton-color">Editar Autorizacion</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
          

        /* -- ******** validation  ************* -- */

        $("#form_autorizaciones").validate({
            rules: {
                aut_nombre: {
                    maxlength: 255, 
                    required: true,
                } 
            },
            submitHandler: function(form){ 
                $("#submit").addClass("disabled btn-progress")
                
                 return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
