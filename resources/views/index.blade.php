@extends('layout.master')

@section('content')

<div class="section-form">
    <div class="container d-flex flex-column align-items-center justify-content-center">
        <h1 class="heading text-center mb-4">Vyhľadať v databáze&nbspobcí</h1>
        <input type="text" id="city" placeholder="Zadajte názov">
        <ul id="suggestions" class="list-group mt-2"></ul>
    </div>
</div>

@endsection