  <div class="dropdown d-inline ">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cogs"></i>
    </button>
    <div class="dropdown-menu " x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
         
   

        <a class="dropdown-item" href="{{ route('cotizaciones.show', $cotizacion_id) }}"> <i class="fa fa-eye fa-1x"></i>Ver Proceso
        </a>
        <a class="dropdown-item" href="{{ route('cotizaciones.edit', $cotizacion_id) }}"> <i class="fa fa-edit fa-1x"></i>Editar
        </a>
 
        <form method="POST" id="formdeletetx{{ $cotizacion_id }}" action="{{ route('cotizaciones.destroy', $cotizacion_id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit"
                onclick="FormDelete('tx{{ $cotizacion_id }}','esta segur@ que desea eliminar este registro',event)"
                class="btn dropdown-item btn-danger btn-sm m-1"><i class="fa fa-trash fa-1x"> </i>Eliminar</button>
        </form>
    </div>
  </div>
