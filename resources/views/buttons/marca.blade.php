 
<div class="dropdown d-inline">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cogs"></i>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
         
  
        <a class="dropdown-item" href="{{ route('marca.edit', $marca_id) }}"> <i class="fa fa-edit fa-1x"></i> Editar marca
        </a>
        <a class="dropdown-item p-0 pl-2">
        <form method="POST" id="formdeletetx{{ $marca_id }}" action="{{ route('marca.destroy', $marca_id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit" style="width: 100%"
                onclick="FormDelete('tx{{ $marca_id }}','esta segur@ que desea eliminar esta marca',event)"
                class="btn btn-ligth btn-sm m-1 text-left"><i class="fa fa-trash fa-1x"> </i> Eliminar marca</button>
        </form> </a>
    </div>
  </div>

 