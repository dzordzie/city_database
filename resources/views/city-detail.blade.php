@extends('layout.master')

@section('content')
<div>
    <h1>{{ $city->name }}</h1>
    <p>{{ $city->latitude }}</p>
    <p>{{ $city->longitude }}</p>
    <p>{{ $city->fax }}</p>
    <p>{{ $city->email }}</p>
    <p>{{ $city->mayor_name }}</p>
    <p>{{ $city->city_hall_address }}</p>
    <p>{{ $city->phone }}</p>
    <p>{{ $city->web }}</p>
    <img src="{{ asset($city->coat_of_arms_image) }}" alt="{{ $city->name }}">
</div>
@endsection