@if (is_null($Data->cliente))
 
    <div class="profile-widget-item">
        <div class="profile-widget-item-label"> Sin Cliente</div>
        <div class="profile-widget-item-value">187</div>
      </div>
@else
    
 
    @if ($Data->cliente->cli_ruc != 'no tiene')
    
    @if ($Data->cliente->cli_nombre!="no tiene")
    <div class="profile-widget-item">
       <div class="profile-widget-item-label">R.social: {{ $Data->cliente->cli_razon_social }} </div>
       <div class="profile-widget-item-value">Nombre: {{ $Data->cliente->cli_nombre }} {{ $Data->cliente->cli_apellido }}</div>
     </div> 
   @else
   <div class="profile-widget-item">
       <div class="profile-widget-item-label">R.social: {{ $Data->cliente->cli_razon_social }} </div>
       <div class="profile-widget-item-value">Nombre:  no registrado</div>
     </div> 
   @endif
       
    @elseif (is_null($Data->cliente->cli_ruc))
       
        <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: no registrado </div>
            <div class="profile-widget-item-value">Nombre:  {{ $Data->cliente->cli_nombre }} {{ $Data->cliente->cli_apellido }}</div>
          </div>
    @else
        @if ($Data->cliente->cli_nombre!="no tiene")
         <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: {{ $Data->cliente->cli_razon_social }} </div>
            <div class="profile-widget-item-value">Nombre: {{ $Data->cliente->cli_nombre }} {{ $Data->cliente->cli_apellido }}</div>
          </div> 
        @else
        <div class="profile-widget-item">
            <div class="profile-widget-item-label">R.social: {{ $Data->cliente->cli_razon_social }} </div>
            <div class="profile-widget-item-value">Nombre:  no registrado</div>
          </div> 
        @endif
        
    @endif
@endif

