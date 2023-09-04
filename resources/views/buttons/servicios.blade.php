<td class="p-2 d-inline-block" style="justify-content: center;">
    <div class="row d-flex flex-row">
 
        <a class="btn btn-info btn-sm m-1" href="{{ route('servicios.show', $servicios_id) }}"> <i class="fa fa-eye fa-1x"></i>
        </a>
        <a class="btn btn-info btn-sm m-1" href="{{ route('servicios.edit', $servicios_id) }}"> <i class="fa fa-edit fa-1x"></i>
        </a>

        <a class="btn btn-info btn-sm m-1" href="{{ route('servicios.estado', $servicios_id) }}"> <i class="fa fa-ban"></i>
        </a>
 
        <form method="POST" id="formdeletetx{{ $servicios_id }}" action="{{ route('servicios.destroy', $servicios_id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit"
                onclick="FormDelete('tx{{ $servicios_id }}','esta segur@ que desea eliminar este cliente',event)"
                class="btn btn-danger btn-sm m-1"><i class="fa fa-trash fa-1x"> </i></button>
        </form>

    </div>
</td>
