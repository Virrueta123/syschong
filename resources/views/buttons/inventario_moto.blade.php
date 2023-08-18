<div class="btn-group dropleft">
    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu dropleft" x-placement="left-start"
        style="position: absolute; transform: translate3d(-202px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
        <a class="dropdown-item" href="{{ route("inventario_moto.show",$inventario_moto_id) }}"><i class="fa fa-eye" aria-hidden="true"></i> Ver Inventario</a>
        <a class="dropdown-item" href="{{ route("inventario_moto.edit",$inventario_moto_id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Editar</a>

        <form method="POST" id="formdeletetx{{ $inventario_moto_id }}" action="{{ route('inventario_moto.destroy', $inventario_moto_id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit"
                onclick="FormDelete('tx{{ $inventario_moto_id }}','esta segur@ que desea eliminar este inventario',event)"
                class="btn dropdown-item btn-danger btn-sm m-1"><i class="fa fa-trash fa-1x"> </i> Eliminar Inventario</button>
        </form>

    </div>
</div>
