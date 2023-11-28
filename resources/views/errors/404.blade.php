@if (auth()->check())
    

    @section('historial')
        <h1>Error 404</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Error</a></div>
            <div class="breadcrumb-item">404</div>
        </div>
    @endsection

    @section('content')
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <img src="{{ asset('images/svg/error404.svg') }}" class="img-fluid" alt="Responsive Image"
                            width="600">
                        <div class="page-description">
                            Ruta no encontrada, usa el menu para navegar
                        </div>
                        <div class="page-search">
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endsection

    @section('js')
    @endsection
@else
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <img src="{{ asset('images/svg/error404.svg') }}" class="img-fluid" alt="Responsive Image"
                        width="600">
                    <div class="page-description">
                        Ruta no encontrada, usa el menu para navegar
                    </div>
                    <div class="page-search">
                    </div>
                </div>
            </div>

        </div>
    </section>
@endif
