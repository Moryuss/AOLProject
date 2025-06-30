@extends('layouts.master')

@section('sidebar')
    <img src="{{ asset('images/magnifyingGlass.png') }}" alt="Cerca" class="me-2" style="width: 500px; height: 500px;">
@endsection

@section('body')
    <div class="container text-center py-5">
        <h1 class="display-1">404</h1>
        <p class="lead">Pagina non trovata</p>
        <p>La pagina che stai cercando non esiste o è stata spostata.</p>
        <a href="{{ url('/') }}" class="btn aol-btn">Torna alla Home</a>
    </div>
@endsection