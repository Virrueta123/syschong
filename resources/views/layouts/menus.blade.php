<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li><a class="nav-link" href="credits.html"><i class="fa fa-home"></i>
            <span>Inicio</span></a></li>
           
    @foreach ($menu as $mn)
        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="{{ $mn['icon'] }}"></i>
                <span>{{ $mn['name'] }}</span></a>
            <ul class="dropdown-menu">
                @foreach ($mn['submenu'] as $submenu)
                    <li><a class="nav-link" href="{{route($submenu['url'])}}">{{ $submenu['name'] }}</a></li>
                @endforeach
            </ul>
        </li>
    @endforeach

    <li><a class="dropdown-item has-icon text-danger" href="credits.html"><i class="fas fa-sign-out-alt"></i>
            <span>Cerrar sesion</span></a></li>
</ul>
