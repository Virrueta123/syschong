@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('accesorios.index') }}" class="text-danger">accesorios</a></div>
        <div class="breadcrumb-item">Editando accesorios</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_accesorios_nombre" method="POST" action="{{ route('accesorios.update',$edit->accesorios_id) }}">
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
                    <h2 class="section-title">Formulario para editar un accesorio</h2>
                </div>
                <div class="card-body">
                     
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="accesorios_nombre">Nombre del accesorio</label>
                            <input type="text" class="form-control" name="accesorios_nombre" value="{{$edit->accesorios_nombre}}" id="accesorios_nombre">
                        </div> 
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_accesorio" class="btn btn-danger boton-color">Editar Accesorio</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
          

        /* -- ******** validation  ************* -- */

        $("#form_accesorios_nombre").validate({
            rules: {
                accesorios_nombre: {
                    maxlength: 220, 
                    required: true,
                } 
            },
            submitHandler: function(form){ 
                $("#crear_accesorio").addClass("disabled btn-progress")
                
                 return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
