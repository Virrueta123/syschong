@switch($estado)
    
    @case('A')
        <span class="badge badge-success">Activo</span> 
    @break
  
    @case('N')
        <span class="badge badge-danger">Desactivo</span> 
    @break
@endswitch
 