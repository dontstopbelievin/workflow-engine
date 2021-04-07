<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{url('css/app.css?v=1.13')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{url('assets/css/ready.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/demo.css')}}">
    <link rel="stylesheet" href="{{url('css/font_awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/custom.css?v=1.13')}}">
    <title>@yield('title')</title>
</head>
<body>
    @if(Auth::check())
        @section('header')
            @include('layouts.header')
        @show
        
        @section('sidebar')
            @include('layouts.sidebar')
        @show
        @section('messages')
            <div style="position:absolute;float:right;min-width:calc(100% - 320px);margin-top: 60px;margin-left: 290px; z-index: 1000;">
                @include('layouts.messages')
            </div>
        @show
        <div style="height: 100%;">
            @yield('content')
        </div>
    @else
        @section('header')
            @include('layouts.header')
        @show
        @section('messages')
            <div style="position:absolute;float:right;min-width:calc(100% - 320px);margin-top: 60px;margin-left: 290px; z-index: 1000;">
                @include('layouts.messages')
            </div>
        @show
        <div style="height: 100%;">
            @yield('content')
        </div>
    @endif
</body>
    @section('footer')
        @include('layouts.footer')
    @show
    @yield('scripts')
</html>
