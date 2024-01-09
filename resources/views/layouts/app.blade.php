<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/empresa/logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- General CSS Files -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    


    <link rel="stylesheet"
        href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap.min.css">


    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />



    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('css')


</head>

<body>
    <div class="loading" id="loadingSpinner">
        <div class="central"> 
            <span class="loader"></span>
            <p>Cargando operacion</p>
        </div>
    </div>

    <div>

        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg  bg-degradado"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <a href="{{ route('pos.create') }}" class="btn btn-icon btn-light"><i class="fa fa-plus"></i>
                            POS</a> 
                        <a href="{{ route('empresa.edit') }}" class="btn btn-icon btn-light"><i class="fas fa-plus"></i> ME</a>
                        <a href="{{ route('taller.index') }}" class="btn btn-icon btn-light"><i class="fa fa-hammer"></i></a>
                        <a href="{{ route('calendario.index') }}" class="btn btn-icon btn-light"><i class="fa fa-calendar"></i></a>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link   nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div>
                        </a>
                         
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{route("home")}}"><img src="{{ asset('images/empresa/logo-chong.png') }}"
                                class="img-thumbnail" width="150" alt=""></a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{route("home")}}"><img src="{{ asset('images/empresa/logo.png') }}" class="img-thumbnail"
                                alt=""></a>
                    </div>

                    @include('layouts.menus')

                </aside>
            </div>


            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        @yield('historial')
                    </div>
                    @yield('content')
                </section>
            </div>




            <footer class="main-footer">
                <div class="footer-left">

                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>



    <!-- Scripts -->
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- ******** IMask para controlar las entradas de digitos en los inputs ************* -->
    <script src="https://unpkg.com/imask"></script>
    <!-- *********************** -->


    <!-- Template JS File -->

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>


    <!-- ******** sweet alert 2 par mostrar mensajes ************* -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- *********************** -->

    <!-- ******** plugins para la validacion de los formularios ************* -->


    <script src="{{ asset('assets/js/plugins/jquery_validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery_validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery_validation/localization/messages_es_PE.min.js') }}"></script>
    <script src="{{ asset('assets/js/init.js') }}"></script>

    <!-- *********************** -->

    <!-- ******** datatables ************* -->

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

 


    <!-- Librería de los botones de DataTables -->

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script> <!-- Librería de la extensión ColVis -->

    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

    <!-- *********************** -->
    <script src="{{ mix('js/app.js') }}"></script>
    <!-- ******** para colocar los scripts de los modulos ************* -->+

    @yield('js')

    <script>
        var loading = document.getElementById('loadingSpinner');
        loading.style.display = 'block';
        window.onload = function() {
            loading.style.display = 'none';
};
        

        @if (session()->has('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            })
        @endif
        @if (session()->has('error'))
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2500
            })
        @endif
        @if (session()->has('warning'))
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: '{{ session('warning') }}',
                showConfirmButton: false,
                timer: 2500
            })
        @endif
    </script>

    <!-- *********************** -->

</body>

</html>
