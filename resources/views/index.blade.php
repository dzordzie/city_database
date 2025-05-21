@extends('layout.master')

@section('content')

<div class="container mt-5">
    <input type="text" id="city" class="form-control" placeholder="Zadajte názov">
    <ul id="suggestions" class="list-group mt-2"></ul>
</div>

@endsection