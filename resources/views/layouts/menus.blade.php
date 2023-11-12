<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li><a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home"></i>
            <span>Inicio</span></a></li>

    @if (Auth::check())
        @foreach ($menu as $mn)
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="{{ $mn['icon'] }}"></i>
                    <span>{{ $mn['name'] }}</span></a>
                <ul class="dropdown-menu">
                    @foreach ($mn['submenu'] as $submenu)
                        <li> <a class="nav-link" style="font-size: 0.7rem;" href="{{ route($submenu['url']) }}">{{ $submenu['name'] }}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    @else
    @endif
 
    <li> <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span>Cerrar sesion</span>
        </a></li>
 
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</ul>
