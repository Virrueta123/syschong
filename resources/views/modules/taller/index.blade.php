@extends('layouts.app')

@section('historial')
    <h1>Taller</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('taller.index') }}">Taller</a></div>
        <div class="breadcrumb-item">Taller</div>
    </div>
@endsection

@section('content')
    <div id="app">
        <taller-show></taller-show>
    </div>
@endsection

@section('js')
@endsection
