@extends('layouts.app')
@section('historial')
    <h1>Panel Principal</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"> --- </div>
        <div class="breadcrumb-item"> --- </div>
    </div>
@endsection
@section('content')
    <div id="app">
        <dashboard></dashboard>
    </div>
@endsection
