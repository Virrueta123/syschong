 <div class="row d-flex flex-row">

     <a class="btn btn-info btn-sm m-1" href="{{ route('autorizaciones.edit', $aut_id) }}"> <i
             class="fa fa-edit fa-1x"></i>
     </a>

     <form method="POST" id="formdeletetx{{ $aut_id }}" action="{{ route('autorizaciones.destroy', $aut_id) }}">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <input name="_method" type="hidden" value="DELETE">
         <button type="submit"
             onclick="FormDelete('tx{{ $aut_id }}','esta segur@ que desea eliminar esta autorizacion',event)"
             class="btn btn-danger btn-sm m-1"><i class="fa fa-trash fa-1x"> </i></button>
     </form>

 </div>
