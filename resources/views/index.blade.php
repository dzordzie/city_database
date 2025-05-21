<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ui42 Assignment</title>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container mt-5">
            <input type="text" id="city" class="form-control" placeholder="Zadajte názov">
            <ul id="suggestions" class="list-group mt-2"></ul>
        </div>
    </body>
</html>
