<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title',env('APP_NAME'))</title>
    @csrf

    <link rel="shortcut icon" href="{{ asset('img/AdminLTELogo.png') }}" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
    @laravelPWA
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
