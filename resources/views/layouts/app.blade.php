<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{url('css/app.css?v=1.13')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css?v=1.13')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{url('assets/css/ready.css?v=1.13')}}">
    <link rel="stylesheet" href="{{url('assets/css/demo.css?v=1.13')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?v=1.13">
</head>
<body>
    @section('header')
        @include('layouts.header')
    @show
    @if(Auth::check() && Route::current()->uri != 'policy')
        @section('sidebar')
            @include('layouts.sidebar')
        @show
    @endif
    @section('messages')
        @include('layouts.messages')
    @show
    <div style="height: 100%;">
        @yield('content')
    </div>
</body>
    @section('footer')
        @include('layouts.footer')
    @show
    @yield('scripts')
</html>
