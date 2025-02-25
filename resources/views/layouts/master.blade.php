<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', '@Master Layout'))</title>
    @include('partial.head')
    
</head>
<body>
    
    @include('partial.header')

    @yield('content')

    @include('partial.footer')

    @include('partial.scripts')
</body>
</html>
