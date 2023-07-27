<td class="p-2 d-inline-block" style="justify-content: center;">
    <div class="row d-flex flex-row">

        <a class="m-2" href="{{ route('cliente.delete', encriptar($cli->Tx_Id)) }}"> <i
                class="fa-solid fa-pen-to-square text-info"></i> </a>


        <form method="POST" id="formdeletetx{{ $tx->Tx_Id }}" action="{{ route('tx.delete', $tx->Tx_Id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit"
                onclick="FormDelete('tx{{ $tx->Tx_Id }}','esta segur@ que desea eliminar este tratamiento',event)"
                class="btn btn-danger btn-xs"><i class="fa-solid fa-trash fa-1x"> </i></button>
        </form>

    </div>
</td>
