@extends('layouts.app')
@section('historial')
    <h1>Crear Venta</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('pos.create') }}" class="text-danger">Pos</a>
        </div>
        <div class="breadcrumb-item">Crear Venta</div>
    </div>
@endsection
@section('content')
    <div id="app">
        <pos-create forma_pago="{{$forma_pago}}" correlativo_factura="{{$correlativo_factura}}" correlativo_boleta="{{$correlativo_boleta}}" empresa="{{$empresa}}"></pos-create>
    </div>
@endsection

@section('js')
    <script>
        var toggle_sidebar_mini = function(mini) {
            let body = $('body');

            if (!mini) {
                body.removeClass('sidebar-mini');
                $(".main-sidebar").css({
                    overflow: 'hidden'
                });
                setTimeout(function() {
                    $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
                    sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
                }, 500);
                $(".main-sidebar .sidebar-menu > li > ul .dropdown-title").remove();
                $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-toggle');
                $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-original-title');
                $(".main-sidebar .sidebar-menu > li > a").removeAttr('title');
            } else {
                body.addClass('sidebar-mini');
                body.removeClass('sidebar-show');
                sidebar_nicescroll.remove();
                sidebar_nicescroll = null;
                $(".main-sidebar .sidebar-menu > li").each(function() {
                    let me = $(this);

                    if (me.find('> .dropdown-menu').length) {
                        me.find('> .dropdown-menu').hide();
                        me.find('> .dropdown-menu').prepend('<li class="dropdown-title pt-3">' + me.find('> a')
                            .text() + '</li>');
                    } else {
                        me.find('> a').attr('data-toggle', 'tooltip');
                        me.find('> a').attr('data-original-title', me.find('> a').text());
                        $("[data-toggle='tooltip']").tooltip({
                            placement: 'right'
                        });
                    }
                });
            }
        }
        toggle_sidebar_mini(true);
    </script>
@endsection
