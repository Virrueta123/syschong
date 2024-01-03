@if (is_null($Data->inventario->moto->cliente))
 
    <div class="profile-widget-item">
        <div class="profile-widget-item-label"> Sin Cliente</div>
        <div class="profile-widget-item-value">187</div>
      </div>
@else
    @php
        $cliente = $Data->inventario->moto->cliente;
    @endphp
 
    @if ($cliente->cli_ruc != 'no tiene')
    
    @if ($cliente->cli_nombre!="no tiene")
    <div class="profile-widget-item">
       <div class="profile-widget-item-label">R.social: {{ $cliente->cli_razon_social }} </div>
       <div class="profile-widget-item-value">Nombre: {{ $cliente->cli_nombre }} {{ $cliente->cli_apellido }}</div>
     </div> 
   @else
   <div class="profile-widget-item">
       <div class="profile-widget-item-label">R.social: {{ $cliente->cli_razon_social }} </div>
       <div class="profile-widget-item-value">Nombre:  no registrado</div>
     </div> 
   @endif
       
    @elseif (is_null($cliente->cli_ruc))
       
        <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: no registrado </div>
            <div class="profile-widget-item-value">Nombre:  {{ $cliente->cli_nombre }} {{ $cliente->cli_apellido }}</div>
          </div>
    @else
        @if ($cliente->cli_nombre!="no tiene")
         <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: {{ $cliente->cli_razon_social }} </div>
            <div class="profile-widget-item-value">Nombre: {{ $cliente->cli_nombre }} {{ $cliente->cli_apellido }}</div>
          </div> 
        @else
        <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: {{ $cliente->cli_razon_social }} </div>
            <div class="profile-widget-item-value">Nombre:  no registrado</div>
          </div> 
        @endif
        
    @endif
@endif

