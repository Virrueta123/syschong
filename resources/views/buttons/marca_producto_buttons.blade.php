
<td class="p-2 d-inline-block" style="justify-content: center;">
    <div class="row d-flex flex-row">
 
        <a class="btn btn-info btn-sm m-1" href="{{ route('marca_producto.edit', $marca_prod_id) }}"> <i class="fa fa-edit fa-1x"></i>
        </a>

        <a class="btn btn-info btn-sm m-1" href="{{ route('marca_producto.estado', $marca_prod_id) }}"> <i class="fa fa-ban"></i>
        </a>
 
        <form method="POST" id="formdeletetx{{ $marca_prod_id }}" action="{{ route('marca_producto.destroy', $marca_prod_id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit"
                onclick="FormDelete('tx{{ $marca_prod_id }}','esta segur@ que desea eliminar esta marca de producto',event)"
                class="btn btn-danger btn-sm m-1"><i class="fa fa-trash fa-1x"> </i></button>
        </form>

    </div>
</td>
