 <div class="dropdown d-inline">
     <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
         <i class="fa fa-cogs"></i>
     </button>
     <div class="dropdown-menu" x-placement="bottom-start"
         style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">

         @if ($is_abierto == 'Y')
             <a class="dropdown-item p-0 pl-2">
                 <form method="POST" id="formdeletetx{{ $caja_chica_id }}"
                     action="{{ route('caja.cerrar', $caja_chica_id) }}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input name="_method" type="hidden" value="PUT">
                     <button type="submit" style="width: 100%"
                         onclick="FormDelete('tx{{ $caja_chica_id }}','esta segur@ que desea cerrar esta caja',event)"
                         class="btn btn-ligth btn-sm m-1 text-left"><i class="fa fa-door-closed"></i> Cerrar
                         Caja</button>
                 </form>
             </a>

             <a class="dropdown-item" href="{{ route('caja.edit', $caja_chica_id) }}"> <i class="fa fa-edit fa-1x"></i>
                 editar caja
             </a>

             <a class="dropdown-item p-0 pl-2">
                 <form method="POST" id="formdeletetx{{ $caja_chica_id }}"
                     action="{{ route('caja.destroy', $caja_chica_id) }}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input name="_method" type="hidden" value="DELETE">
                     <button type="submit" style="width: 100%"
                         onclick="FormDelete('tx{{ $caja_chica_id }}','esta segur@ que desea eliminar esta caja',event)"
                         class="btn btn-ligth btn-sm m-1 text-left"><i class="fa fa-trash fa-1x"> </i> Eliminar
                         Caja</button>
                 </form>
             </a>
         @endif


         <a class="dropdown-item" href="{{ route('caja.show', $caja_chica_id) }}"> <i class="fa fa-eye fa-1x"></i>
             Visualizar
         </a>


     </div>
 </div>
