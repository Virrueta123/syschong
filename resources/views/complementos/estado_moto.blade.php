@switch($estado)
    @case('N')
        <span class="badge badge-info">Nuevo</span>
    @break

    @case('B')
        <span class="badge badge-success">Bueno</span> 
    @break

    @case('R')
        <span class="badge badge-warning">Regular</span> 
    @break

    @case('D')
        <span class="badge badge-danger">Deficiente</span> 
    @break
@endswitch
 